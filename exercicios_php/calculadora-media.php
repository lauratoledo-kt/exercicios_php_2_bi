<?php
require_once __DIR__ . '/includes/funcoes.php';

$titulo = 'Calculadora de Média';
$pagina = 'media';
$erros = [];
$media = null;
$situacao = '';

$nome = campoPost('nome');
$nota1 = campoPost('nota1');
$nota2 = campoPost('nota2');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Converter as notas antes de comparar com os limites.
    $nomeLimpo = trim($nome);
    $valorNota1 = numeroDecimal($nota1);
    $valorNota2 = numeroDecimal($nota2);

    if ($nomeLimpo === '') {
        $erros[] = 'Informe o nome do aluno.';
    }
    if ($valorNota1 === null || $valorNota1 < 0 || $valorNota1 > 10) {
        $erros[] = 'A primeira nota é inválida. Informe um número de 0 a 10.';
    }
    if ($valorNota2 === null || $valorNota2 < 0 || $valorNota2 > 10) {
        $erros[] = 'A segunda nota é inválida. Informe um número de 0 a 10.';
    }

    if ($erros === []) {
        $media = ($valorNota1 + $valorNota2) / 2;

        // A ordem importa. Testamos primeiro a faixa mais alta.
        if ($media >= 7) {
            $situacao = 'APROVADO';
        } elseif ($media >= 4) {
            $situacao = 'RECUPERAÇÃO';
        } else {
            $situacao = 'REPROVADO';
        }
    }
}

require __DIR__ . '/includes/cabecalho.php';
?>
    <main class="container estreito">
        <div class="introducao">
            <p class="etiqueta">Exercício 02</p>
            <h1><?= h($titulo) ?></h1>
            <p>Informe duas notas entre 0 e 10. Você pode usar vírgula ou ponto como separador decimal.</p>
        </div>

        <form class="cartao formulario" method="post" novalidate>
            <?php require __DIR__ . '/includes/erros.php'; ?>
            <div class="campo">
                <label for="nome">Nome do aluno</label>
                <input id="nome" name="nome" value="<?= h($nome) ?>" required>
            </div>
            <div class="linha-campos">
                <div class="campo">
                    <label for="nota1">Primeira nota</label>
                    <input id="nota1" name="nota1" inputmode="decimal" value="<?= h($nota1) ?>" required>
                </div>
                <div class="campo">
                    <label for="nota2">Segunda nota</label>
                    <input id="nota2" name="nota2" inputmode="decimal" value="<?= h($nota2) ?>" required>
                </div>
            </div>
            <button type="submit">Calcular média</button>
        </form>

        <?php if ($media !== null): ?>
            <section class="cartao resultado" aria-labelledby="titulo-resultado">
                <h2 id="titulo-resultado">Resultado acadêmico</h2>
                <dl>
                    <div><dt>Aluno</dt><dd><?= h($nomeLimpo) ?></dd></div>
                    <div><dt>Média</dt><dd><?= number_format($media, 2, ',', '.') ?></dd></div>
                    <div class="destaque"><dt>Situação</dt><dd><?= h($situacao) ?></dd></div>
                </dl>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
