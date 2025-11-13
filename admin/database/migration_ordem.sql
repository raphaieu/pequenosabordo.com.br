-- Migração: Adicionar coluna ordem na tabela produtos
-- Execute: mysql -u usuario -p nome_banco < migration_ordem.sql

USE pequenos_a_bordo;

-- Adicionar coluna ordem
ALTER TABLE produtos ADD COLUMN ordem INT NOT NULL DEFAULT 0 AFTER descricao;

-- Atualizar registros existentes com ordem sequencial baseada no ID
UPDATE produtos SET ordem = id WHERE ordem = 0 OR ordem IS NULL;

-- Criar índice para melhor performance na ordenação
CREATE INDEX idx_ordem ON produtos(ordem);

-- Verificar resultado
SELECT id, nome, ordem FROM produtos ORDER BY ordem ASC LIMIT 10;

