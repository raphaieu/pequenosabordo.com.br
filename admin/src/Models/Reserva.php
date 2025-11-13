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
        $sql = "SELECT r.* FROM reservas r ORDER BY r.criado_em DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM reservas WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO reservas (nome_completo, cpf, endereco, data_inicio, data_fim, forma_pagamento) 
                VALUES (:nome_completo, :cpf, :endereco, :data_inicio, :data_fim, :forma_pagamento)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome_completo' => $data['nome_completo'],
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE reservas SET 
                nome_completo = :nome_completo,
                cpf = :cpf,
                endereco = :endereco,
                data_inicio = :data_inicio,
                data_fim = :data_fim,
                forma_pagamento = :forma_pagamento,
                atualizado_em = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nome_completo' => $data['nome_completo'],
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM reservas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

