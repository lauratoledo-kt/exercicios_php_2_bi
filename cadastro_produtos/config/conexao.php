<?php
// Conexão PDO. Esta função só é chamada após todas as validações passarem.
declare(strict_types=1);

function conectarBanco(): PDO
{
    // Padrões do XAMPP local. Em outros ambientes, configure DB_*.
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $porta = getenv('DB_PORT') ?: '3306';
    $banco = getenv('DB_NAME') ?: 'loja_produtos';
    $usuario = getenv('DB_USER') ?: 'root';
    $senhaVariavel = getenv('DB_PASSWORD');
    $senha = $senhaVariavel === false ? '' : $senhaVariavel;

    $dsn = "mysql:host={$host};port={$porta};dbname={$banco};charset=utf8mb4";

    return new PDO($dsn, $usuario, $senha, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
