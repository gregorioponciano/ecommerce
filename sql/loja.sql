-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS projeto1_1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projeto1_1;

-- Tabela: users
CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    cpf VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(255) NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    `password` VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: password_reset_tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` INT UNSIGNED NOT NULL
);

CREATE TABLE cache_locks (
    `key` VARCHAR(255) NOT NULL PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` INT UNSIGNED NOT NULL
);

-- Tabela: sessions
CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INTEGER NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: categorias
CREATE TABLE categorias (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir categorias
INSERT INTO categorias (id, nome, created_at, updated_at) VALUES
(1, 'Lanches', NOW(), NOW()),
(2, 'Bebidas', NOW(), NOW()),
(3, 'Porções', NOW(), NOW()),
(4, 'Combos', NOW(), NOW());

-- Tabela: produtos
CREATE TABLE produtos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    categoria_id BIGINT UNSIGNED NOT NULL,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NULL,
    preco DECIMAL(8, 2) NOT NULL,
    imagem VARCHAR(255) NULL,
    estoque INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT produtos_categoria_id_foreign FOREIGN KEY (categoria_id) REFERENCES categorias (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir produtos
INSERT INTO produtos (id, categoria_id, nome, descricao, preco, imagem, estoque, created_at, updated_at) VALUES
-- Lanches (ID 1)
(1, 1, 'X-Salada Clássico', 'Hambúrguer, queijo prato, alface, tomate e maionese da casa.', 22.50, 'storage/image/lanche.jpg', 50, NOW(), NOW()),
(2, 1, 'X-Bacon Supremo', 'Hambúrguer duplo, muito bacon crocante e cheddar cremoso.', 28.90, 'storage/image/lanche.jpg', 45, NOW(), NOW()),
(3, 1, 'Sanduíche Vegetariano', 'Pão integral, queijo coalho, abobrinha e berinjela grelhadas.', 19.90, 'storage/image/lanche.jpg', 60, NOW(), NOW()),
(4, 1, 'Cheeseburger Duplo', 'Dois hambúrgueres de carne com queijo muçarela derretido.', 32.00, 'storage/image/lanche.jpg', 40, NOW(), NOW()),
(5, 1, 'X-Tudo Monstro', 'Todos os acompanhamentos: ovo, bacon, calabresa e queijo.', 45.00, 'storage/image/lanche.jpg', 25, NOW(), NOW()),

-- Bebidas (ID 2)
(6, 2, 'Refrigerante Lata (Coca-Cola)', 'Lata de 350ml.', 6.00, 'storage/image/lanche.jpg', 120, NOW(), NOW()),
(7, 2, 'Refrigerante Lata (Guaraná)', 'Lata de 350ml.', 6.00, 'storage/image/lanche.jpg', 100, NOW(), NOW()),
(8, 2, 'Suco Natural de Laranja', 'Copo de 300ml.', 8.50, 'storage/image/lanche.jpg', 80, NOW(), NOW()),

-- Porções (ID 3)
(9, 3, 'Batata Frita Grande', 'Porção de 500g de batatas rústicas com alecrim.', 15.00, 'storage/image/lanche.jpg', 60, NOW(), NOW()),
(10, 3, 'Anéis de Cebola', 'Porção de anéis de cebola empanados (300g).', 18.00, 'storage/image/lanche.jpg', 55, NOW(), NOW()),

-- Combos (ID 4)
(11, 4, 'Combo Executivo', '1 X-Salada Clássico + Batata Média + Refrigerante Lata.', 35.00, 'storage/image/lanche.jpg', 40, NOW(), NOW()),
(12, 4, 'Combo Duplo Bacon', '2 X-Bacon Supremo + 1 Porção de Anéis de Cebola + 2 Refrigerantes.', 69.90, 'storage/image/lanche.jpg', 30, NOW(), NOW());

-- Tabela: adicionais
CREATE TABLE adicionais (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    produto_id BIGINT UNSIGNED NOT NULL,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(8, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT adicionais_produto_id_foreign FOREIGN KEY (produto_id) REFERENCES produtos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: ingredientes
CREATE TABLE ingredientes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    produto_id BIGINT UNSIGNED NOT NULL,
    nome VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT ingredientes_produto_id_foreign FOREIGN KEY (produto_id) REFERENCES produtos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: enderecos
CREATE TABLE enderecos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NULL,
    bairro VARCHAR(255) NULL,
    cidade VARCHAR(255) NULL,
    estado VARCHAR(100) NULL,
    cep VARCHAR(20) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_enderecos_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: carrinhos
CREATE TABLE carrinhos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    produto_id BIGINT UNSIGNED NOT NULL,
    quantidade INTEGER NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT carrinhos_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT carrinhos_produto_id_foreign FOREIGN KEY (produto_id) REFERENCES produtos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: pedidos
CREATE TABLE pedidos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pendente', 'confirmado', 'preparando', 'entregue', 'cancelado') DEFAULT 'pendente',
    metodo_pagamento ENUM('pix', 'cartao', 'dinheiro') NOT NULL,
    endereco_entrega TEXT NOT NULL,
    observacoes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela: pedido_items
CREATE TABLE pedido_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pedido_id BIGINT UNSIGNED NOT NULL,
    produto_id BIGINT UNSIGNED NOT NULL,
    quantidade INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para melhor performance
CREATE INDEX idx_pedidos_user_id ON pedidos(user_id);
CREATE INDEX idx_pedidos_status ON pedidos(status);
CREATE INDEX idx_pedido_items_pedido_id ON pedido_items(pedido_id);
CREATE INDEX idx_pedido_items_produto_id ON pedido_items(produto_id);

-- Inserir alguns adicionais de exemplo
INSERT INTO adicionais (produto_id, nome, preco, created_at, updated_at) VALUES
(1, 'Bacon Extra', 3.00, NOW(), NOW()),
(1, 'Queijo Extra', 2.50, NOW(), NOW()),
(2, 'Molho Especial', 1.50, NOW(), NOW());

-- Inserir alguns ingredientes de exemplo
INSERT INTO ingredientes (produto_id, nome, created_at, updated_at) VALUES
(1, 'Pão de hambúrguer', NOW(), NOW()),
(1, 'Hambúrguer bovino 180g', NOW(), NOW()),
(1, 'Queijo prato', NOW(), NOW()),
(1, 'Alface americana', NOW(), NOW()),
(1, 'Tomate', NOW(), NOW());