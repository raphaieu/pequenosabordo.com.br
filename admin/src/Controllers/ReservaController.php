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
        $showArchived = isset($queryParams['tab']) && $queryParams['tab'] === 'arquivadas' ? 1 : 0;
        $perPage = 20;
        
        $totalReservas = $this->reserva->count($showArchived);
        $totalPages = ceil($totalReservas / $perPage);
        
        $reservas = $this->reserva->paginate($page, $perPage, $showArchived);
        
        $hoje = new \DateTime();
        foreach ($reservas as &$reserva) {
            $reserva['produtos'] = $this->reservaProduto->findByReserva($reserva['id']);
            
            // Verifica se a data final já passou (apenas para exibição visual)
            $dataFim = new \DateTime($reserva['data_fim']);
            $reserva['expirada'] = $dataFim < $hoje;
        }
        
        $html = $this->renderView('reservas/index.php', [
            'reservas' => $reservas,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalReservas' => $totalReservas,
            'currentTab' => $showArchived ? 'arquivadas' : 'ativas'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function logistica(Request $request, Response $response): Response
    {
        $hoje = date('Y-m-d');
        // Aumentado para 15 dias para exibir devoluções com folga de margem
        $proximaSemana = date('Y-m-d', strtotime('+15 days'));
        
        $logistica = $this->reserva->getLogistica($hoje, $proximaSemana);
        
        foreach ($logistica as &$item) {
            $item['produtos'] = $this->reservaProduto->findByReserva($item['id']);
        }
        
        $html = $this->renderView('reservas/logistica.php', [
            'logistica' => $logistica,
            'hoje' => $hoje
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

            // Validação de produtos e preços
            if (!isset($data['produtos']) || !is_array($data['produtos'])) {
                throw new \Exception('Selecione pelo menos um produto');
            }

            $reservaData = [
                'nome_completo' => $data['nome_completo'],
                'telefone' => $data['telefone'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'local_entrega' => $data['local_entrega'],
                'horario_entrega' => $data['horario_entrega'],
                'local_devolucao' => $data['local_devolucao'],
                'horario_devolucao' => $data['horario_devolucao'],
                'obs_logistica' => $data['obs_logistica'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
                'forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
                'status' => 'pendente'
            ];

            $reservaId = $this->reserva->create($reservaData);

            // Adiciona produtos à reserva com o valor cobrado
            foreach ($data['produtos'] as $index => $produtoId) {
                $valorCobrado = isset($data['valores'][$index]) ? (float)$data['valores'][$index] : 0;
                $this->reservaProduto->create($reservaId, (int)$produtoId, $valorCobrado);
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
            $dataInicio = new \DateTime($data['data_inicio']);
            $dataFim = new \DateTime($data['data_fim']);

            if ($dataFim <= $dataInicio) {
                throw new \Exception('Data de término deve ser posterior à data de início');
            }

            if (!isset($data['produtos']) || !is_array($data['produtos'])) {
                throw new \Exception('Selecione pelo menos um produto');
            }

            $reservaData = [
                'nome_completo' => $data['nome_completo'],
                'telefone' => $data['telefone'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'local_entrega' => $data['local_entrega'],
                'horario_entrega' => $data['horario_entrega'],
                'local_devolucao' => $data['local_devolucao'],
                'horario_devolucao' => $data['horario_devolucao'],
                'obs_logistica' => $data['obs_logistica'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
                'forma_pagamento' => $data['forma_pagamento'],
                'status' => $data['status'] ?? $reserva['status'],
                'arquivado' => isset($data['arquivado']) ? (int)$data['arquivado'] : $reserva['arquivado']
            ];

            $this->reserva->update($args['id'], $reservaData);

            // Sincroniza produtos
            $this->reservaProduto->deleteByReserva($args['id']);
            foreach ($data['produtos'] as $index => $produtoId) {
                $valorCobrado = isset($data['valores'][$index]) ? (float)$data['valores'][$index] : 0;
                $this->reservaProduto->create($args['id'], (int)$produtoId, $valorCobrado);
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

    public function updateStatus(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $status = $data['status'] ?? null;
        
        if ($status) {
            $this->reserva->updateStatus($args['id'], $status);
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/admin/reservas';
        return $response
            ->withStatus(302)
            ->withHeader('Location', $referer . (strpos($referer, '?') !== false ? '&' : '?') . 'success=Status atualizado');
    }

    public function archive(Request $request, Response $response, array $args): Response
    {
        $this->reserva->archive($args['id'], 1);
        return $response
            ->withStatus(302)
            ->withHeader('Location', '/admin/reservas?success=Reserva arquivada');
    }

    public function unarchive(Request $request, Response $response, array $args): Response
    {
        $this->reserva->archive($args['id'], 0);
        return $response
            ->withStatus(302)
            ->withHeader('Location', '/admin/reservas?tab=arquivadas&success=Reserva desarquivada');
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            $this->reserva->delete($args['id']);
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?success=Reserva enviada para a lixeira');
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
            return $response->withStatus(404);
        }

        $produtos = $this->reservaProduto->findByReserva($args['id']);

        $pdfContent = $this->pdfService->generateContract($reserva, $produtos);

        $response->getBody()->write($pdfContent);
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="contrato_' . $reserva['id'] . '.pdf"');
    }
}
