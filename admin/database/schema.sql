-- Banco de dados para Pequenos a Bordo
-- Criar o banco de dados primeiro: CREATE DATABASE pequenos_a_bordo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE pequenos_a_bordo;

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    tipoInstalacao VARCHAR(255) NULL,
    orientacao VARCHAR(255) NULL,
    preco1 DECIMAL(10,2) NOT NULL COMMENT 'Preço para 0 a 5 dias',
    preco2 DECIMAL(10,2) NOT NULL COMMENT 'Preço para 6 a 15 dias',
    preco3 DECIMAL(10,2) NOT NULL COMMENT 'Preço para 16 a 30 dias',
    descricao TEXT NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    nome_completo VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    endereco TEXT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL DEFAULT 'PIX' COMMENT 'Forma de pagamento: PIX, Cartão de Crédito (máquininha), Espécie, Link de Pagamento',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para melhor performance
CREATE INDEX idx_produto_id ON reservas(produto_id);
CREATE INDEX idx_data_inicio ON reservas(data_inicio);
CREATE INDEX idx_data_fim ON reservas(data_fim);

