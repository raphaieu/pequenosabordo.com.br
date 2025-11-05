<?php

namespace App\Models;

use PDO;

class Reserva
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $sql = "SELECT r.*, p.nome as produto_nome, p.imagem as produto_imagem, p.marca as produto_marca,
                p.precoCurto, p.precoLongo
                FROM reservas r
                INNER JOIN produtos p ON r.produto_id = p.id
                ORDER BY r.criado_em DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT r.*, p.nome as produto_nome, p.imagem as produto_imagem, p.marca as produto_marca,
                p.precoCurto, p.precoLongo, p.tipoInstalacao, p.orientacao, p.descricao as produto_descricao
                FROM reservas r
                INNER JOIN produtos p ON r.produto_id = p.id
                WHERE r.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO reservas (produto_id, nome_completo, cpf, endereco, data_inicio, data_fim) 
                VALUES (:produto_id, :nome_completo, :cpf, :endereco, :data_inicio, :data_fim)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':produto_id' => $data['produto_id'],
            ':nome_completo' => $data['nome_completo'],
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE reservas SET 
                produto_id = :produto_id,
                nome_completo = :nome_completo,
                cpf = :cpf,
                endereco = :endereco,
                data_inicio = :data_inicio,
                data_fim = :data_fim,
                atualizado_em = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':produto_id' => $data['produto_id'],
            ':nome_completo' => $data['nome_completo'],
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM reservas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

