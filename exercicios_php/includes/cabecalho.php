<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($titulo) ?> | Exercícios PHP</title>
    <link rel="stylesheet" href="assets/estilo.css">
</head>
<body>
    <header class="topo">
        <div class="topo-interno">
            <a class="marca" href="index.php">Exercícios <span>PHP</span></a>
            <nav aria-label="Exercícios">
                <a href="cadastro-aluno.php"<?= $pagina === 'cadastro' ? ' aria-current="page"' : '' ?>>01 Cadastro</a>
                <a href="calculadora-media.php"<?= $pagina === 'media' ? ' aria-current="page"' : '' ?>>02 Média</a>
                <a href="simulador-pedido.php"<?= $pagina === 'pedido' ? ' aria-current="page"' : '' ?>>03 Pedido</a>
            </nav>
        </div>
    </header>
