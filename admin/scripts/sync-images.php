<?php
/**
 * Script para sincronizar imagens de produtos entre public e dist
 * Execute: php admin/scripts/sync-images.php
 */

$baseDir = dirname(__DIR__);
$publicDir = $baseDir . '/public/images/produtos';
$distDir = $baseDir . '/dist/images/produtos';

// Cria diretórios se não existirem
if (!is_dir($publicDir)) {
    mkdir($publicDir, 0755, true);
}

if (is_dir($baseDir . '/dist')) {
    if (!is_dir($distDir)) {
        mkdir($distDir, 0755, true);
    }
    
    // Copia imagens de public para dist
    if (is_dir($publicDir)) {
        $files = glob($publicDir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        foreach ($files as $file) {
            $filename = basename($file);
            $dest = $distDir . '/' . $filename;
            if (!file_exists($dest)) {
                copy($file, $dest);
                echo "Copiado: $filename\n";
            }
        }
    }
    
    // Copia imagens de dist para public (se houver)
    if (is_dir($distDir)) {
        $files = glob($distDir . '/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
        foreach ($files as $file) {
            $filename = basename($file);
            $dest = $publicDir . '/' . $filename;
            if (!file_exists($dest)) {
                copy($file, $dest);
                echo "Copiado para public: $filename\n";
            }
        }
    }
    
    echo "Sincronização concluída!\n";
} else {
    echo "Diretório dist não existe. Execute 'npm run build' primeiro.\n";
}

