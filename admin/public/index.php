<?php
// Entry point para o servidor PHP embutido
// Quando rodar: php -S localhost:8000 -t public
// Isso fará com que o index.php seja executado automaticamente

// Define o base path para o Slim
$_SERVER['SCRIPT_NAME'] = '/admin/index.php';

// Chama o index principal
require __DIR__ . '/../index.php';

