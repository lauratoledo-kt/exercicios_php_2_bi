-- Exercício da noite — Banco de dados para cadastro de produtos.
-- Execute este arquivo uma vez no phpMyAdmin ou MySQL Workbench.

CREATE DATABASE IF NOT EXISTS loja_produtos
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE loja_produtos;

CREATE TABLE IF NOT EXISTS produtos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT UNSIGNED NOT NULL,
    CONSTRAINT chk_produtos_preco_positivo CHECK (preco > 0)
);

-- Para conferir os cadastros após utilizar o formulário:
SELECT id, nome, categoria, preco, quantidade
FROM produtos
ORDER BY id DESC;
