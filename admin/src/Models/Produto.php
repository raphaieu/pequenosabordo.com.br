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
        $sql = "INSERT INTO produtos (nome, imagem, marca, tipoInstalacao, orientacao, preco1, preco2, preco3, descricao) 
                VALUES (:nome, :imagem, :marca, :tipoInstalacao, :orientacao, :preco1, :preco2, :preco3, :descricao)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $data['nome'],
            ':imagem' => $data['imagem'],
            ':marca' => $data['marca'],
            ':tipoInstalacao' => $data['tipoInstalacao'] ?? null,
            ':orientacao' => $data['orientacao'] ?? null,
            ':preco1' => $data['preco1'],
            ':preco2' => $data['preco2'],
            ':preco3' => $data['preco3'],
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
                preco1 = :preco1, 
                preco2 = :preco2, 
                preco3 = :preco3, 
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
            ':preco1' => $data['preco1'],
            ':preco2' => $data['preco2'],
            ':preco3' => $data['preco3'],
            ':descricao' => $data['descricao'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

