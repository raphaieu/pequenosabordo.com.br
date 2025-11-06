<?php
// Entry point para o servidor PHP embutido e produção (Nginx)
// Quando rodar: php -S localhost:8000 -t public
// Em produção: Nginx redireciona /admin para este arquivo

// Define o SCRIPT_NAME para o SlimPHP identificar corretamente
if (!isset($_SERVER['SCRIPT_NAME']) || $_SERVER['SCRIPT_NAME'] === '/index.php') {
    $_SERVER['SCRIPT_NAME'] = '/admin/public/index.php';
}

// Chama o index principal
require __DIR__ . '/../index.php';
