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

    public function all($showArchived = 0)
    {
        $sql = "SELECT r.* FROM reservas r WHERE r.deleted_at IS NULL AND r.arquivado = :arquivado ORDER BY r.data_fim DESC, r.criado_em DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':arquivado', (int)$showArchived, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function paginate($page = 1, $perPage = 20, $showArchived = 0)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT r.* FROM reservas r WHERE r.deleted_at IS NULL AND r.arquivado = :arquivado ORDER BY r.data_fim DESC, r.criado_em DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':arquivado', (int)$showArchived, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count($showArchived = 0)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM reservas WHERE deleted_at IS NULL AND arquivado = ?");
        $stmt->execute([$showArchived]);
        $result = $stmt->fetch();
        return (int)$result['total'];
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
        $sql = "INSERT INTO reservas (
                    nome_completo, telefone, cpf, endereco, 
                    local_entrega, horario_entrega, local_devolucao, horario_devolucao, 
                    obs_logistica, data_inicio, data_fim, forma_pagamento, status
                ) VALUES (
                    :nome_completo, :telefone, :cpf, :endereco, 
                    :local_entrega, :horario_entrega, :local_devolucao, :horario_devolucao, 
                    :obs_logistica, :data_inicio, :data_fim, :forma_pagamento, :status
                )";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome_completo' => $data['nome_completo'],
            ':telefone' => $data['telefone'] ?? null,
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':local_entrega' => $data['local_entrega'] ?? null,
            ':horario_entrega' => $data['horario_entrega'] ?: null,
            ':local_devolucao' => $data['local_devolucao'] ?? null,
            ':horario_devolucao' => $data['horario_devolucao'] ?: null,
            ':obs_logistica' => $data['obs_logistica'] ?? null,
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
            ':status' => $data['status'] ?? 'pendente',
        ]);

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE reservas SET 
                nome_completo = :nome_completo,
                telefone = :telefone,
                cpf = :cpf,
                endereco = :endereco,
                local_entrega = :local_entrega,
                horario_entrega = :horario_entrega,
                local_devolucao = :local_devolucao,
                horario_devolucao = :horario_devolucao,
                obs_logistica = :obs_logistica,
                data_inicio = :data_inicio,
                data_fim = :data_fim,
                forma_pagamento = :forma_pagamento,
                status = :status,
                arquivado = :arquivado,
                atualizado_em = CURRENT_TIMESTAMP
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nome_completo' => $data['nome_completo'],
            ':telefone' => $data['telefone'] ?? null,
            ':cpf' => $data['cpf'],
            ':endereco' => $data['endereco'],
            ':local_entrega' => $data['local_entrega'] ?? null,
            ':horario_entrega' => $data['horario_entrega'] ?: null,
            ':local_devolucao' => $data['local_devolucao'] ?? null,
            ':horario_devolucao' => $data['horario_devolucao'] ?: null,
            ':obs_logistica' => $data['obs_logistica'] ?? null,
            ':data_inicio' => $data['data_inicio'],
            ':data_fim' => $data['data_fim'],
            ':forma_pagamento' => $data['forma_pagamento'] ?? 'PIX',
            ':status' => $data['status'] ?? 'pendente',
            ':arquivado' => $data['arquivado'] ?? 0,
        ]);
    }

    public function delete($id, $permanent = false)
    {
        if ($permanent) {
            $stmt = $this->db->prepare("DELETE FROM reservas WHERE id = ?");
            return $stmt->execute([$id]);
        }
        
        $stmt = $this->db->prepare("UPDATE reservas SET deleted_at = CURRENT_TIMESTAMP WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE reservas SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function archive($id, $archive = 1)
    {
        $stmt = $this->db->prepare("UPDATE reservas SET arquivado = ? WHERE id = ?");
        return $stmt->execute([$archive, $id]);
    }

    public function getLogistica($start, $end)
    {
        // Busca:
        // 1. Todas as reservas pendentes (não entregues ainda), independente da data.
        // 2. Todas as reservas entregues (aguardando devolução) cuja data final seja até +7 dias (inclui atrasadas).
        $sql = "SELECT r.* FROM reservas r 
                WHERE r.deleted_at IS NULL 
                AND r.arquivado = 0
                AND (
                    r.status = 'pendente' 
                    OR 
                    (r.status = 'entregue' AND r.data_fim <= :end)
                )
                ORDER BY r.data_inicio ASC, r.horario_entrega ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':end' => $end]);
        return $stmt->fetchAll();
    }
}

