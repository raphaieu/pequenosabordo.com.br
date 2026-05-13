<?php

namespace App\Models;

use PDO;

class ReservaProduto
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByReserva($reservaId)
    {
        $sql = "SELECT rp.*, p.nome as produto_nome, p.imagem as produto_imagem, p.marca as produto_marca,
                p.preco1, p.preco2, p.preco3, p.tipoInstalacao, p.orientacao, p.descricao as produto_descricao
                FROM reserva_produtos rp
                INNER JOIN produtos p ON rp.produto_id = p.id
                WHERE rp.reserva_id = ?
                ORDER BY rp.id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$reservaId]);
        return $stmt->fetchAll();
    }

    public function create($reservaId, $produtoId, $valorCobrado = 0.00)
    {
        $sql = "INSERT INTO reserva_produtos (reserva_id, produto_id, valor_cobrado) 
                VALUES (:reserva_id, :produto_id, :valor_cobrado)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':reserva_id' => $reservaId,
            ':produto_id' => $produtoId,
            ':valor_cobrado' => $valorCobrado,
        ]);
    }

    public function deleteByReserva($reservaId)
    {
        $stmt = $this->db->prepare("DELETE FROM reserva_produtos WHERE reserva_id = ?");
        return $stmt->execute([$reservaId]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM reserva_produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

