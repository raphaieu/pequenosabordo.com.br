-- Migração: Atualizar estrutura de preços
-- De: precoCurto, precoLongo
-- Para: preco1 (0-5 dias), preco2 (6-15 dias), preco3 (16-30 dias)
-- Execute: mysql -u usuario -p nome_banco < migration_precos.sql

USE pequenos_a_bordo;

-- Adicionar nova coluna preco3
ALTER TABLE produtos ADD COLUMN preco3 DECIMAL(10,2) NULL AFTER precoLongo;

-- Copiar valores de precoLongo para preco2 e preco3 temporariamente
-- (vamos renomear depois)
UPDATE produtos SET preco3 = precoLongo WHERE preco3 IS NULL;

-- Renomear colunas
ALTER TABLE produtos CHANGE COLUMN precoCurto preco1 DECIMAL(10,2) NOT NULL;
ALTER TABLE produtos CHANGE COLUMN precoLongo preco2 DECIMAL(10,2) NOT NULL;

-- Tornar preco3 obrigatório (após migração dos dados)
ALTER TABLE produtos MODIFY COLUMN preco3 DECIMAL(10,2) NOT NULL;

-- Verificar resultado
SELECT id, nome, preco1, preco2, preco3 FROM produtos LIMIT 5;

