-- Migração completa: Logística, Status e Precificação
-- Adiciona colunas na tabela reservas
ALTER TABLE reservas ADD COLUMN telefone VARCHAR(20) AFTER nome_completo;
ALTER TABLE reservas ADD COLUMN local_entrega VARCHAR(255) AFTER endereco;
ALTER TABLE reservas ADD COLUMN horario_entrega TIME AFTER local_entrega;
ALTER TABLE reservas ADD COLUMN local_devolucao VARCHAR(255) AFTER horario_entrega;
ALTER TABLE reservas ADD COLUMN horario_devolucao TIME AFTER local_devolucao;
ALTER TABLE reservas ADD COLUMN obs_logistica TEXT AFTER horario_devolucao;
ALTER TABLE reservas ADD COLUMN status ENUM('pendente', 'entregue', 'concluido', 'cancelado') NOT NULL DEFAULT 'pendente' AFTER forma_pagamento;
ALTER TABLE reservas ADD COLUMN arquivado TINYINT(1) NOT NULL DEFAULT 0 AFTER status;
ALTER TABLE reservas ADD COLUMN deleted_at DATETIME NULL AFTER atualizado_em;

-- Adiciona coluna de valor real cobrado na tabela de ligação
ALTER TABLE reserva_produtos ADD COLUMN valor_cobrado DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER produto_id;

-- Índices para performance na tela de logística
CREATE INDEX idx_status ON reservas(status);
CREATE INDEX idx_arquivado ON reservas(arquivado);
CREATE INDEX idx_deleted_at ON reservas(deleted_at);
