<?php

use Slim\Factory\AppFactory;
use App\Middleware\AuthMiddleware;
use App\Controllers\AuthController;
use App\Controllers\ProdutoController;
use App\Controllers\ReservaController;
use App\Models\Produto;
use App\Models\Reserva;
use App\Services\UploadService;
use App\Services\PdfService;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

// Carrega variáveis de ambiente
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Inicia sessão
session_start();

// Configura base path se não estiver definido
if (!isset($_SERVER['SCRIPT_NAME'])) {
    $_SERVER['SCRIPT_NAME'] = '/admin/public/index.php';
}

// Salva valores originais para debug (descomente se necessário)
// $originalRequestUri = $_SERVER['REQUEST_URI'] ?? '';
// $originalPathInfo = $_SERVER['PATH_INFO'] ?? '';
// $originalScriptName = $_SERVER['SCRIPT_NAME'] ?? '';

// Processa REQUEST_URI para ajustar rotas
// IMPORTANTE: /admin/api e /images devem manter o prefixo completo
if (isset($_SERVER['REQUEST_URI'])) {
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // Remove query string temporariamente
    $queryString = '';
    if (($pos = strpos($requestUri, '?')) !== false) {
        $queryString = substr($requestUri, $pos);
        $requestUri = substr($requestUri, 0, $pos);
    }
    
    // Verifica se é rota de API ou imagens (mantém prefixo completo)
    if (strpos($requestUri, '/admin/api') === 0) {
        // Mantém /admin/api intacto - Slim precisa ver o caminho completo
        // Remove apenas /admin/public/index.php se estiver presente
        $_SERVER['REQUEST_URI'] = $requestUri . $queryString;
        // Define PATH_INFO corretamente para o Slim
        $_SERVER['PATH_INFO'] = $requestUri;
    } elseif (strpos($requestUri, '/images') === 0) {
        // Mantém /images intacto
        $_SERVER['REQUEST_URI'] = $requestUri . $queryString;
        $_SERVER['PATH_INFO'] = $requestUri;
    } elseif (strpos($requestUri, '/admin') === 0) {
        // Remove /admin para rotas administrativas
        $requestUri = substr($requestUri, 6);
        if ($requestUri === '' || $requestUri === '/') {
            $requestUri = '/';
        } else {
            $requestUri = '/' . ltrim($requestUri, '/');
        }
        $_SERVER['REQUEST_URI'] = $requestUri . $queryString;
        $_SERVER['PATH_INFO'] = $requestUri;
    } elseif ($requestUri === '' || $requestUri === '/admin') {
        $_SERVER['REQUEST_URI'] = '/' . $queryString;
        $_SERVER['PATH_INFO'] = '/';
    }
    
    // Garante que PATH_INFO está definido mesmo se não foi processado acima
    if (!isset($_SERVER['PATH_INFO'])) {
        $_SERVER['PATH_INFO'] = $requestUri;
    }
}

// Cria aplicação Slim
$app = AppFactory::create();

// NÃO configura base path - queremos controle manual sobre as rotas
// Isso permite que /admin/api e /images funcionem corretamente

// Função helper para renderizar views PHP
function renderView($viewPath, $data = []) {
    extract($data);
    ob_start();
    include __DIR__ . '/views/' . $viewPath;
    return ob_get_clean();
}

// Função helper para gerar URL de imagens
function imageUrl($imagePath) {
    // Remove barra inicial se houver
    $imagePath = ltrim($imagePath, '/');
    
    // Em desenvolvimento, usa localhost:3000 (Vite)
    // Em produção, usa a rota do PHP ou relativo
    if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'localhost:8000') {
        // Desenvolvimento: aponta para Vite na porta 3000
        return 'http://localhost:3000/' . $imagePath;
    }
    
    // Produção ou quando não for localhost:8000: usa rota do PHP
    return '/images/produtos/' . basename($imagePath);
}

// Função helper para gerar URLs do admin
function adminUrl($path = '') {
    $path = ltrim($path, '/');
    return '/admin/' . $path;
}

// Configuração do banco de dados
$dbConfig = require __DIR__ . '/config/database.php';
$dsn = sprintf(
    '%s:host=%s;dbname=%s;charset=%s',
    $dbConfig['driver'],
    $dbConfig['host'],
    $dbConfig['database'],
    $dbConfig['charset']
);

try {
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $dbConfig['options']);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// Instancia serviços
$uploadService = new UploadService();
$pdfService = new PdfService();
$produtoModel = new Produto($pdo);
$reservaModel = new Reserva($pdo);

// Instancia controllers
$authController = new AuthController();
$produtoController = new ProdutoController($produtoModel, $uploadService);
$reservaController = new ReservaController($reservaModel, $produtoModel, $pdfService);

// Middleware de autenticação
$authMiddleware = new AuthMiddleware();

// ============================================
// ROTAS PÚBLICAS (fora do base path)
// ============================================

// API pública para produtos (front-end) - DEVE SER PRIMEIRA PARA TER PRIORIDADE
$app->get('/admin/api/produtos', function ($request, $response) use ($produtoModel) {
    $produtos = $produtoModel->all();
    $response->getBody()->write(json_encode($produtos));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withHeader('Access-Control-Allow-Origin', '*');
});

// Rota para servir imagens estáticas
$app->get('/images/produtos/{filename}', function ($request, $response, $args) {
    $baseDir = dirname(__DIR__);
    $distFile = $baseDir . '/dist/images/produtos/' . $args['filename'];
    $publicFile = $baseDir . '/public/images/produtos/' . $args['filename'];
    
    // Tenta dist primeiro, depois public
    if (file_exists($distFile)) {
        $file = $distFile;
    } elseif (file_exists($publicFile)) {
        $file = $publicFile;
    } else {
        return $response->withStatus(404);
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file);
    finfo_close($finfo);
    
    $response->getBody()->write(file_get_contents($file));
    return $response
        ->withHeader('Content-Type', $mimeType)
        ->withHeader('Cache-Control', 'public, max-age=31536000');
});

// ============================================
// ROTAS ADMINISTRATIVAS (com prefixo removido)
// ============================================

// Rotas públicas (sem prefixo /admin porque o base path já está configurado)
$app->get('/login', [$authController, 'loginForm'])->setName('login');
$app->post('/login', [$authController, 'login']);
$app->get('/logout', [$authController, 'logout'])->setName('logout');

// Rotas protegidas - Dashboard
$app->get('/dashboard', function ($request, $response) use ($produtoModel, $reservaModel) {
    $produtosCount = count($produtoModel->all());
    $reservasCount = count($reservaModel->all());
    $html = renderView('dashboard.php', [
        'produtosCount' => $produtosCount,
        'reservasCount' => $reservasCount
    ]);
    $response->getBody()->write($html);
    return $response;
})->add($authMiddleware);

// Rotas protegidas - Produtos
$app->get('/produtos', [$produtoController, 'index'])->add($authMiddleware);
$app->get('/produtos/create', [$produtoController, 'create'])->add($authMiddleware);
$app->post('/produtos/store', [$produtoController, 'store'])->add($authMiddleware);
$app->get('/produtos/{id}/edit', [$produtoController, 'edit'])->add($authMiddleware);
$app->post('/produtos/{id}/update', [$produtoController, 'update'])->add($authMiddleware);
$app->post('/produtos/{id}/delete', [$produtoController, 'delete'])->add($authMiddleware);

// Rotas protegidas - Reservas
$app->get('/reservas', [$reservaController, 'index'])->add($authMiddleware);
$app->get('/reservas/create', [$reservaController, 'create'])->add($authMiddleware);
$app->post('/reservas/store', [$reservaController, 'store'])->add($authMiddleware);
$app->get('/reservas/{id}/edit', [$reservaController, 'edit'])->add($authMiddleware);
$app->post('/reservas/{id}/update', [$reservaController, 'update'])->add($authMiddleware);
$app->post('/reservas/{id}/delete', [$reservaController, 'delete'])->add($authMiddleware);
$app->get('/reservas/{id}/pdf', [$reservaController, 'generatePdf'])->add($authMiddleware);

// Redireciona /admin e /admin/ para /admin/login
$app->get('/', function ($request, $response) {
    return $response
        ->withStatus(302)
        ->withHeader('Location', '/admin/login');
});

// Executa aplicação
$app->run();

