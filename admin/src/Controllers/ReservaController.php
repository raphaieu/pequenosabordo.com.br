<?php

namespace App\Controllers;

use App\Models\Reserva;
use App\Models\Produto;
use App\Models\ReservaProduto;
use App\Services\PdfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReservaController
{
    private $reserva;
    private $produto;
    private $reservaProduto;
    private $pdfService;

    public function __construct(Reserva $reserva, Produto $produto, ReservaProduto $reservaProduto, PdfService $pdfService)
    {
        $this->reserva = $reserva;
        $this->produto = $produto;
        $this->reservaProduto = $reservaProduto;
        $this->pdfService = $pdfService;
    }

    private function renderView($viewPath, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../../views/' . $viewPath;
        return ob_get_clean();
    }

    public function index(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $page = isset($queryParams['page']) ? max(1, (int)$queryParams['page']) : 1;
        $perPage = 20;
        
        $totalReservas = $this->reserva->count();
        $totalPages = ceil($totalReservas / $perPage);
        
        $reservas = $this->reserva->paginate($page, $perPage);
        
        // Busca produtos para cada reserva e verifica se já foi devolvida
        $hoje = new \DateTime();
        foreach ($reservas as &$reserva) {
            $reserva['produtos'] = $this->reservaProduto->findByReserva($reserva['id']);
            
            // Verifica se a data final já passou
            $dataFim = new \DateTime($reserva['data_fim']);
            $reserva['devolvida'] = $dataFim < $hoje;
        }
        
        $html = $this->renderView('reservas/index.php', [
            'reservas' => $reservas,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalReservas' => $totalReservas
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $produtos = $this->produto->all();
        $html = $this->renderView('reservas/form.php', [
            'reserva' => null,
            'produtos' => $produtos,
            'action' => '/admin/reservas/store'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        try {
            // Validação de datas
            $dataInicio = new \DateTime($data['data_inicio']);
            $dataFim = new \DateTime($data['data_fim']);

            if ($dataFim <= $dataInicio) {
                throw new \Exception('Data de término deve ser posterior à data de início');
            }

            // Validação de produtos
            $produtosIds = [];
            if (isset($data['produtos']) && is_array($data['produtos'])) {
                $produtosIds = array_filter(array_map('intval', $data['produtos']));
            } elseif (isset($data['produto_id'])) {
                // Compatibilidade com formulário antigo
                $produtosIds = [intval($data['produto_id'])];
            }

            if (empty($produtosIds)) {
                throw new \Exception('Selecione pelo menos um produto');
            }

            $reservaData = [
                'nome_completo' => $data['nome_completo'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
                'forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
            ];

            $reservaId = $this->reserva->create($reservaData);

            // Adiciona produtos à reserva
            foreach ($produtosIds as $produtoId) {
                $this->reservaProduto->create($reservaId, $produtoId);
            }

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?success=Reserva criada com sucesso');
        } catch (\Exception $e) {
            $produtos = $this->produto->all();
            $html = $this->renderView('reservas/form.php', [
                'reserva' => null,
                'produtos' => $produtos,
                'action' => '/admin/reservas/store',
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            $response->getBody()->write($html);
            return $response;
        }
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $reserva = $this->reserva->find($args['id']);
        $produtos = $this->produto->all();
        
        if (!$reserva) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?error=Reserva não encontrada');
        }

        // Busca produtos da reserva
        $reserva['produtos_selecionados'] = $this->reservaProduto->findByReserva($args['id']);

        $html = $this->renderView('reservas/form.php', [
            'reserva' => $reserva,
            'produtos' => $produtos,
            'action' => '/admin/reservas/' . $args['id'] . '/update'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $reserva = $this->reserva->find($args['id']);

        if (!$reserva) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?error=Reserva não encontrada');
        }

        try {
            // Validação de datas
            $dataInicio = new \DateTime($data['data_inicio']);
            $dataFim = new \DateTime($data['data_fim']);

            if ($dataFim <= $dataInicio) {
                throw new \Exception('Data de término deve ser posterior à data de início');
            }

            // Validação de produtos
            $produtosIds = [];
            if (isset($data['produtos']) && is_array($data['produtos'])) {
                $produtosIds = array_filter(array_map('intval', $data['produtos']));
            } elseif (isset($data['produto_id'])) {
                // Compatibilidade com formulário antigo
                $produtosIds = [intval($data['produto_id'])];
            }

            if (empty($produtosIds)) {
                throw new \Exception('Selecione pelo menos um produto');
            }

            $reservaData = [
                'nome_completo' => $data['nome_completo'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
                'forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
            ];

            $this->reserva->update($args['id'], $reservaData);

            // Remove produtos antigos e adiciona novos
            $this->reservaProduto->deleteByReserva($args['id']);
            foreach ($produtosIds as $produtoId) {
                $this->reservaProduto->create($args['id'], $produtoId);
            }

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?success=Reserva atualizada com sucesso');
        } catch (\Exception $e) {
            $produtos = $this->produto->all();
            $reserva['produtos_selecionados'] = $this->reservaProduto->findByReserva($args['id']);
            $html = $this->renderView('reservas/form.php', [
                'reserva' => $reserva,
                'produtos' => $produtos,
                'action' => '/admin/reservas/' . $args['id'] . '/update',
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            $response->getBody()->write($html);
            return $response;
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            $this->reserva->delete($args['id']);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?success=Reserva excluída com sucesso');
        } catch (\Exception $e) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?error=' . urlencode($e->getMessage()));
        }
    }

    public function generatePdf(Request $request, Response $response, array $args): Response
    {
        $reserva = $this->reserva->find($args['id']);

        if (!$reserva) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?error=Reserva não encontrada');
        }

        // Busca todos os produtos da reserva
        $produtos = $this->reservaProduto->findByReserva($args['id']);

        if (empty($produtos)) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?error=Reserva sem produtos');
        }

        $pdfContent = $this->pdfService->generateContract($reserva, $produtos);

        $response->getBody()->write($pdfContent);
        
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="contrato_' . $reserva['id'] . '.pdf"');
    }
}

