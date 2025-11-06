<?php
// Entry point para o servidor PHP embutido e produção (Nginx)
// Quando rodar: php -S localhost:8000 -t public
// Em produção: Nginx redireciona /admin para este arquivo

// Define o SCRIPT_NAME para o SlimPHP identificar corretamente
if (!isset($_SERVER['SCRIPT_NAME']) || $_SERVER['SCRIPT_NAME'] === '/index.php') {
    $_SERVER['SCRIPT_NAME'] = '/admin/public/index.php';
}

// Ajusta REQUEST_URI se necessário (quando vem do Nginx)
// Nginx pode passar a URI completa em REQUEST_URI
if (isset($_SERVER['REQUEST_URI'])) {
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // Se a URI contém /admin/public/index.php, remove
    if (strpos($requestUri, '/admin/public/index.php') !== false) {
        $requestUri = str_replace('/admin/public/index.php', '', $requestUri);
        if ($requestUri === '') {
            $requestUri = '/';
        }
        $_SERVER['REQUEST_URI'] = $requestUri;
    }
    
    // Define PATH_INFO se não estiver definido
    if (!isset($_SERVER['PATH_INFO']) && $requestUri !== '/') {
        // Remove query string para PATH_INFO
        $pathInfo = $requestUri;
        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }
        $_SERVER['PATH_INFO'] = $pathInfo;
    }
}

// Chama o index principal
require __DIR__ . '/../index.php';
