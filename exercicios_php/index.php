<?php
require_once __DIR__ . '/includes/funcoes.php';

$titulo = 'Inicio';
$pagina = 'inicio';
require __DIR__ . '/includes/cabecalho.php';
?>
    <main class="container">
        <div class="introducao inicio">
            <p class="etiqueta">Prática de PHP</p>
            <h1>Formulários e decisões</h1>
            <p>Três exercícios para receber dados com POST, validar os campos e apresentar o resultado na mesma página.</p>
        </div>
        <div class="cartoes">
            <a href="cadastro-aluno.php" class="cartao modulo">
                <span class="numero">01</span>
                <h2>Cadastro de Aluno</h2>
                <p>Receba nome, curso e idade e mostre o resumo do aluno.</p>
                <span class="ir">Abrir exercício <span aria-hidden="true">→</span></span>
            </a>
            <a href="calculadora-media.php" class="cartao modulo">
                <span class="numero">02</span>
                <h2>Calculadora de Média</h2>
                <p>Valide duas notas e descubra a situação acadêmica.</p>
                <span class="ir">Abrir exercício <span aria-hidden="true">→</span></span>
            </a>
            <a href="simulador-pedido.php" class="cartao modulo">
                <span class="numero">03</span>
                <h2>Simulador de Pedido</h2>
                <p>Calcule desconto e valor final conforme o subtotal e o tipo de cliente.</p>
                <span class="ir">Abrir exercício <span aria-hidden="true">→</span></span>
            </a>
        </div>
    </main>
</body>
</html>
