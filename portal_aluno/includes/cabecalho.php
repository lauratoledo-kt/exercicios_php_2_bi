<?php
// Componente compartilhado: abertura do documento, estilo e navegação.
require_once __DIR__ . '/funcoes.php';
$titulo = $titulo ?? 'Portal do Aluno';
$paginaAtual = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal do Aluno — cadastro e consulta de informações acadêmicas em sessão PHP.">
    <title><?= escapar($titulo) ?> | Portal do Aluno</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
<div class="page-shell">
    <header class="site-header">
        <a class="brand" href="index.php" aria-label="Portal do Aluno, página inicial">
            <span class="brand-symbol" aria-hidden="true">PA</span>
            <span><strong>Portal do Aluno</strong><small>Ambiente do estudante</small></span>
        </a>
        <nav class="nav-links" aria-label="Navegação principal">
            <a href="index.php" <?= $paginaAtual === 'index.php' ? 'aria-current="page"' : '' ?>>Início</a>
            <a href="cadastro.php" <?= $paginaAtual === 'cadastro.php' ? 'aria-current="page"' : '' ?>>Cadastro</a>
            <a href="resultado.php" <?= $paginaAtual === 'resultado.php' ? 'aria-current="page"' : '' ?>>Meus dados</a>
            <a class="logout-link" href="logout.php">Encerrar sessão</a>
        </nav>
    </header>
    <main class="main-content" id="conteudo">
