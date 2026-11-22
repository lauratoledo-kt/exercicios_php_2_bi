<?php
require_once __DIR__ . '/includes/funcoes.php';

$titulo = 'Cadastro de Aluno';
$pagina = 'cadastro';
$erros = [];
$resumo = null;

// Receber e preservar os valores originais dos três campos.
$nome = campoPost('nome');
$curso = campoPost('curso');
$idade = campoPost('idade');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Validar o nome e converter a idade para um inteiro positivo.
    $nomeLimpo = trim($nome);
    $idadeNumerica = inteiroPositivo($idade);

    if ($nomeLimpo === '') {
        $erros[] = 'Informe o nome do aluno.';
    }
    if ($idadeNumerica === null) {
        $erros[] = 'A idade deve ser um número inteiro maior que zero.';
    }

    // O curso não é obrigatório segundo o enunciado.
    if ($erros === []) {
        $resumo = [
            'nome' => $nomeLimpo,
            'curso' => trim($curso),
            'idade' => $idadeNumerica,
        ];
    }
}

require __DIR__ . '/includes/cabecalho.php';
?>
    <main class="container estreito">
        <div class="introducao">
            <p class="etiqueta">Exercício 01</p>
            <h1><?= h($titulo) ?></h1>
            <p>Informe os dados do aluno para gerar o resumo do cadastro.</p>
        </div>

        <form class="cartao formulario" method="post" novalidate>
            <?php require __DIR__ . '/includes/erros.php'; ?>
            <div class="campo">
                <label for="nome">Nome do aluno</label>
                <input id="nome" name="nome" value="<?= h($nome) ?>" required>
            </div>
            <div class="campo">
                <label for="curso">Curso <span class="opcional">(opcional)</span></label>
                <input id="curso" name="curso" value="<?= h($curso) ?>">
            </div>
            <div class="campo">
                <label for="idade">Idade em anos</label>
                <input id="idade" name="idade" inputmode="numeric" value="<?= h($idade) ?>" required>
            </div>
            <button type="submit">Gerar resumo</button>
        </form>

        <?php if ($resumo !== null): ?>
            <section class="cartao resultado" aria-labelledby="titulo-resultado">
                <h2 id="titulo-resultado">Resumo do aluno</h2>
                <dl>
                    <div><dt>Nome</dt><dd><?= h($resumo['nome']) ?></dd></div>
                    <div><dt>Curso</dt><dd><?= h($resumo['curso'] !== '' ? $resumo['curso'] : 'Não informado') ?></dd></div>
                    <div><dt>Idade</dt><dd><?= $resumo['idade'] ?> anos</dd></div>
                </dl>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
