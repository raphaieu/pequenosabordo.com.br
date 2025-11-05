<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    private $authConfig;

    public function __construct()
    {
        $this->authConfig = require __DIR__ . '/../../config/auth.php';
    }

    private function renderView($viewPath, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../../views/' . $viewPath;
        return ob_get_clean();
    }

    public function loginForm(Request $request, Response $response): Response
    {
        // Se já estiver logado, redireciona para dashboard
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/dashboard');
        }

        $html = $this->renderView('login.php');
        $response->getBody()->write($html);
        return $response;
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        if ($username === $this->authConfig['username'] && 
            $password === $this->authConfig['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/admin/dashboard');
        }

        // Erro de login
        $html = $this->renderView('login.php', [
            'error' => 'Usuário ou senha incorretos'
        ]);
        $response->getBody()->write($html);
        return $response;
    }

    public function logout(Request $request, Response $response): Response
    {
        session_destroy();
        session_start();
        session_regenerate_id(true);

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/admin/login');
    }
}

