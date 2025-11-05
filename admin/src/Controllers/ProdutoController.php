<?php

namespace App\Controllers;

use App\Models\Produto;
use App\Services\UploadService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController
{
    private $produto;
    private $uploadService;

    public function __construct(Produto $produto, UploadService $uploadService)
    {
        $this->produto = $produto;
        $this->uploadService = $uploadService;
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
        $produtos = $this->produto->all();
        $html = $this->renderView('produtos/index.php', [
            'produtos' => $produtos
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $html = $this->renderView('produtos/form.php', [
            'produto' => null,
            'action' => '/admin/produtos/store'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $files = $request->getUploadedFiles();

        try {
            // Upload de imagem
            $imagem = '';
            if (isset($files['imagem']) && $files['imagem']->getError() === UPLOAD_ERR_OK) {
                $imagem = $this->uploadService->upload($files['imagem']);
            } else {
                throw new \Exception('Imagem é obrigatória');
            }

            $produtoData = [
                'nome' => $data['nome'],
                'imagem' => $imagem,
                'marca' => $data['marca'],
                'tipoInstalacao' => $data['tipoInstalacao'] ?? null,
                'orientacao' => $data['orientacao'] ?? null,
                'precoCurto' => floatval($data['precoCurto']),
                'precoLongo' => floatval($data['precoLongo']),
                'descricao' => $data['descricao'],
            ];

            $this->produto->create($produtoData);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?success=Produto criado com sucesso');
        } catch (\Exception $e) {
            $html = $this->renderView('produtos/form.php', [
                'produto' => null,
                'action' => '/admin/produtos/store',
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            $response->getBody()->write($html);
            return $response;
        }
    }

    public function edit(Request $request, Response $response, array $args): Response
    {
        $produto = $this->produto->find($args['id']);
        
        if (!$produto) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?error=Produto não encontrado');
        }

        $html = $this->renderView('produtos/form.php', [
            'produto' => $produto,
            'action' => '/admin/produtos/' . $args['id'] . '/update'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $files = $request->getUploadedFiles();
        $produto = $this->produto->find($args['id']);

        if (!$produto) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?error=Produto não encontrado');
        }

        try {
            $imagem = $produto['imagem']; // Mantém imagem existente

            // Se nova imagem foi enviada, substitui
            if (isset($files['imagem']) && $files['imagem']->getError() === UPLOAD_ERR_OK) {
                // Remove imagem antiga (se existir)
                if (!empty($produto['imagem'])) {
                    $this->uploadService->delete($produto['imagem']);
                }
                $imagem = $this->uploadService->upload($files['imagem']);
            }

            $produtoData = [
                'nome' => $data['nome'],
                'imagem' => $imagem,
                'marca' => $data['marca'],
                'tipoInstalacao' => $data['tipoInstalacao'] ?? null,
                'orientacao' => $data['orientacao'] ?? null,
                'precoCurto' => floatval($data['precoCurto']),
                'precoLongo' => floatval($data['precoLongo']),
                'descricao' => $data['descricao'],
            ];

            $this->produto->update($args['id'], $produtoData);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?success=Produto atualizado com sucesso');
        } catch (\Exception $e) {
            $html = $this->renderView('produtos/form.php', [
                'produto' => $produto,
                'action' => '/admin/produtos/' . $args['id'] . '/update',
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            $response->getBody()->write($html);
            return $response;
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $produto = $this->produto->find($args['id']);

        if (!$produto) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?error=Produto não encontrado');
        }

        try {
            // Remove imagem
            $this->uploadService->delete($produto['imagem']);
            
            // Remove produto
            $this->produto->delete($args['id']);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?success=Produto excluído com sucesso');
        } catch (\Exception $e) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/produtos?error=' . urlencode($e->getMessage()));
        }
    }
}

