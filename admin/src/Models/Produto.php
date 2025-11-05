<?php

namespace App\Models;

use PDO;

class Produto
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY criado_em ASC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO produtos (nome, imagem, marca, tipoInstalacao, orientacao, precoCurto, precoLongo, descricao) 
                VALUES (:nome, :imagem, :marca, :tipoInstalacao, :orientacao, :precoCurto, :precoLongo, :descricao)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'],
            ':imagem' => $data['imagem'],
            ':marca' => $data['marca'],
            ':tipoInstalacao' => $data['tipoInstalacao'] ?? null,
            ':orientacao' => $data['orientacao'] ?? null,
            ':precoCurto' => $data['precoCurto'],
            ':precoLongo' => $data['precoLongo'],
            ':descricao' => $data['descricao'],
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE produtos SET 
                nome = :nome, 
                imagem = :imagem, 
                marca = :marca, 
                tipoInstalacao = :tipoInstalacao, 
                orientacao = :orientacao, 
                precoCurto = :precoCurto, 
                precoLongo = :precoLongo, 
                descricao = :descricao,
                atualizado_em = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nome' => $data['nome'],
            ':imagem' => $data['imagem'],
            ':marca' => $data['marca'],
            ':tipoInstalacao' => $data['tipoInstalacao'] ?? null,
            ':orientacao' => $data['orientacao'] ?? null,
            ':precoCurto' => $data['precoCurto'],
            ':precoLongo' => $data['precoLongo'],
            ':descricao' => $data['descricao'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

