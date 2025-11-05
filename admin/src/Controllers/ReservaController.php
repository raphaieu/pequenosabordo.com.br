<?php

namespace App\Controllers;

use App\Models\Reserva;
use App\Models\Produto;
use App\Services\PdfService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReservaController
{
    private $reserva;
    private $produto;
    private $pdfService;

    public function __construct(Reserva $reserva, Produto $produto, PdfService $pdfService)
    {
        $this->reserva = $reserva;
        $this->produto = $produto;
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
        $reservas = $this->reserva->all();
        $html = $this->renderView('reservas/index.php', [
            'reservas' => $reservas
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

            $reservaData = [
                'produto_id' => intval($data['produto_id']),
                'nome_completo' => $data['nome_completo'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
            ];

            $this->reserva->create($reservaData);

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

            $reservaData = [
                'produto_id' => intval($data['produto_id']),
                'nome_completo' => $data['nome_completo'],
                'cpf' => $data['cpf'],
                'endereco' => $data['endereco'],
                'data_inicio' => $data['data_inicio'],
                'data_fim' => $data['data_fim'],
            ];

            $this->reserva->update($args['id'], $reservaData);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/reservas?success=Reserva atualizada com sucesso');
        } catch (\Exception $e) {
            $produtos = $this->produto->all();
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

        $produto = [
            'produto_nome' => $reserva['produto_nome'],
            'produto_marca' => $reserva['produto_marca'],
            'tipoInstalacao' => $reserva['tipoInstalacao'] ?? null,
            'orientacao' => $reserva['orientacao'] ?? null,
            'precoCurto' => $reserva['precoCurto'],
            'precoLongo' => $reserva['precoLongo'],
        ];

        $pdfContent = $this->pdfService->generateContract($reserva, $produto);

        $response->getBody()->write($pdfContent);
        
        return $response
            ->withHeader('Content-Type', 'application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="contrato_' . $reserva['id'] . '.pdf"');
    }
}

