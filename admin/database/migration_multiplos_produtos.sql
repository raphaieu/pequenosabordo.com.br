-- Migração: Suporte a múltiplos produtos por reserva
-- Execute: mysql -u usuario -p nome_banco < migration_multiplos_produtos.sql

USE pequenos_a_bordo;

-- Criar tabela de relacionamento reserva_produtos
CREATE TABLE IF NOT EXISTS reserva_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL,
    produto_id INT NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reserva_id) REFERENCES reservas(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_reserva_produto (reserva_id, produto_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migrar dados existentes da tabela reservas para reserva_produtos
INSERT INTO reserva_produtos (reserva_id, produto_id)
SELECT id, produto_id FROM reservas WHERE produto_id IS NOT NULL;

-- Remover foreign key e coluna produto_id da tabela reservas (após migração)
-- Descomente as linhas abaixo após verificar que a migração foi bem-sucedida:
-- ALTER TABLE reservas DROP FOREIGN KEY reservas_ibfk_1;
-- ALTER TABLE reservas DROP COLUMN produto_id;

-- Criar índices para melhor performance
CREATE INDEX idx_reserva_id ON reserva_produtos(reserva_id);
CREATE INDEX idx_produto_id ON reserva_produtos(produto_id);

-- Verificar resultado
SELECT rp.*, r.nome_completo, p.nome as produto_nome 
FROM reserva_produtos rp
INNER JOIN reservas r ON rp.reserva_id = r.id
INNER JOIN produtos p ON rp.produto_id = p.id
LIMIT 10;

