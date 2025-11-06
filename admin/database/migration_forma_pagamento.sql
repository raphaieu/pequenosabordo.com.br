-- Migração: Adicionar coluna forma_pagamento na tabela reservas
-- Execute: mysql -u usuario -p nome_banco < migration_forma_pagamento.sql

USE pequenos_a_bordo;

-- Adicionar coluna forma_pagamento
ALTER TABLE reservas ADD COLUMN forma_pagamento VARCHAR(50) NOT NULL DEFAULT 'PIX' AFTER data_fim;

-- Atualizar registros existentes para PIX (padrão)
UPDATE reservas SET forma_pagamento = 'PIX' WHERE forma_pagamento IS NULL OR forma_pagamento = '';

-- Verificar resultado
SELECT id, nome_completo, forma_pagamento FROM reservas LIMIT 5;

