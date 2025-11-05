<?php

namespace App\Services;

class UploadService
{
    private $uploadDir;
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    private $maxSize = 5 * 1024 * 1024; // 5MB

    public function __construct($uploadDir = null)
    {
        // Sempre salva em public/images/produtos para garantir acesso
        $baseDir = dirname(dirname(dirname(__DIR__)));
        $this->uploadDir = $baseDir . '/public/images/produtos';

        // Cria o diretório se não existir
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
        
        // Também cria em dist se existir (para front-end compilado)
        $distDir = $baseDir . '/dist/images/produtos';
        if (is_dir($baseDir . '/dist')) {
            if (!is_dir($distDir)) {
                mkdir($distDir, 0755, true);
            }
        }
    }

    public function upload($uploadedFile)
    {
        // Se for array (formato tradicional), usa método antigo
        if (is_array($uploadedFile)) {
            return $this->uploadFromArray($uploadedFile);
        }

        // Se for UploadedFile do Slim
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            throw new \Exception('Erro no upload do arquivo');
        }

        // Valida tipo
        $mimeType = $uploadedFile->getClientMediaType();
        if (!in_array($mimeType, $this->allowedTypes)) {
            throw new \Exception('Tipo de arquivo não permitido. Use JPG, PNG ou WEBP');
        }

        // Valida tamanho
        if ($uploadedFile->getSize() > $this->maxSize) {
            throw new \Exception('Arquivo muito grande. Máximo: 5MB');
        }

        // Gera nome único
        $clientFilename = $uploadedFile->getClientFilename();
        $extension = pathinfo($clientFilename, PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $destination = $this->uploadDir . '/' . $filename;

        // Move arquivo para public
        $uploadedFile->moveTo($destination);
        
        // Copia para dist se existir (para front-end compilado)
        $baseDir = dirname(dirname(dirname(__DIR__)));
        $distDir = $baseDir . '/dist/images/produtos';
        if (is_dir($baseDir . '/dist')) {
            $distDestination = $distDir . '/' . $filename;
            if (is_dir($distDir)) {
                copy($destination, $distDestination);
            }
        }

        // Retorna caminho relativo
        return '/images/produtos/' . $filename;
    }

    private function uploadFromArray($file)
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Erro no upload do arquivo');
        }

        // Valida tipo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedTypes)) {
            throw new \Exception('Tipo de arquivo não permitido. Use JPG, PNG ou WEBP');
        }

        // Valida tamanho
        if ($file['size'] > $this->maxSize) {
            throw new \Exception('Arquivo muito grande. Máximo: 5MB');
        }

        // Gera nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $destination = $this->uploadDir . '/' . $filename;

        // Move arquivo para public
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception('Erro ao salvar arquivo');
        }
        
        // Copia para dist se existir (para front-end compilado)
        $baseDir = dirname(dirname(dirname(__DIR__)));
        $distDir = $baseDir . '/dist/images/produtos';
        if (is_dir($baseDir . '/dist')) {
            $distDestination = $distDir . '/' . $filename;
            if (is_dir($distDir)) {
                copy($destination, $distDestination);
            }
        }

        // Retorna caminho relativo
        return '/images/produtos/' . $filename;
    }

    public function delete($filePath)
    {
        $baseDir = dirname(dirname(dirname(__DIR__)));
        $filename = basename($filePath);
        
        // Remove de public
        $publicFile = $baseDir . '/public/images/produtos/' . $filename;
        $removed = false;
        if (file_exists($publicFile)) {
            unlink($publicFile);
            $removed = true;
        }
        
        // Remove de dist se existir
        $distFile = $baseDir . '/dist/images/produtos/' . $filename;
        if (file_exists($distFile)) {
            unlink($distFile);
            $removed = true;
        }
        
        return $removed;
    }

    public function getUploadDir()
    {
        return $this->uploadDir;
    }
}

