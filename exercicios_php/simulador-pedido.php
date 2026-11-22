<?php
require_once __DIR__ . '/includes/funcoes.php';

$titulo = 'Simulador de Pedido';
$pagina = 'pedido';
$erros = [];
$resumo = null;

$cliente = campoPost('cliente');
$produto = campoPost('produto');
$preco = campoPost('preco');
$quantidade = campoPost('quantidade');
$tipo = campoPost('tipo');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $clienteLimpo = trim($cliente);
    $produtoLimpo = trim($produto);
    $precoCentavos = precoEmCentavos($preco);
    $quantidadeNumerica = inteiroPositivo($quantidade);

    if ($clienteLimpo === '') {
        $erros[] = 'Informe o nome do cliente.';
    }
    if ($produtoLimpo === '') {
        $erros[] = 'Informe o produto.';
    }
    if ($precoCentavos === null) {
        $erros[] = 'O preço deve ser maior que zero e ter até duas casas decimais.';
    }
    if ($quantidadeNumerica === null) {
        $erros[] = 'A quantidade deve ser um número inteiro maior que zero.';
    }
    if (!in_array($tipo, ['comum', 'premium'], true)) {
        $erros[] = 'Selecione o tipo de cliente: comum ou premium.';
    }

    // Impede que uma entrada muito grande ultrapasse o limite dos inteiros do PHP.
    if ($erros === [] && $precoCentavos > intdiv(PHP_INT_MAX, $quantidadeNumerica)) {
        $erros[] = 'O subtotal ultrapassa o limite que pode ser calculado.';
    }

    if ($erros === []) {
        $subtotal = $precoCentavos * $quantidadeNumerica;

        // R$ 500,00 são 50.000 centavos. R$ 200,00 são 20.000 centavos.
        if ($subtotal >= 50000) {
            $percentual = 10;
        } elseif ($subtotal >= 20000) {
            $percentual = 5;
        } else {
            $percentual = 0;
        }

        if ($tipo === 'premium') {
            $percentual += 2;
        }

        // Calcula a parte inteira separada do resto e arredonda ao centavo mais próximo.
        $desconto = intdiv($subtotal, 100) * $percentual
            + intdiv(($subtotal % 100) * $percentual + 50, 100);
        $total = $subtotal - $desconto;

        $resumo = [
            'cliente' => $clienteLimpo,
            'produto' => $produtoLimpo,
            'preco' => $precoCentavos,
            'quantidade' => $quantidadeNumerica,
            'subtotal' => $subtotal,
            'percentual' => $percentual,
            'desconto' => $desconto,
            'total' => $total,
        ];
    }
}

require __DIR__ . '/includes/cabecalho.php';
?>
    <main class="container estreito">
        <div class="introducao">
            <p class="etiqueta">Exercício 03</p>
            <h1><?= h($titulo) ?></h1>
            <p>Confira o desconto e o valor final antes de concluir a compra.</p>
        </div>

        <form class="cartao formulario" method="post" novalidate>
            <?php require __DIR__ . '/includes/erros.php'; ?>
            <div class="linha-campos">
                <div class="campo">
                    <label for="cliente">Nome do cliente</label>
                    <input id="cliente" name="cliente" value="<?= h($cliente) ?>" required>
                </div>
                <div class="campo">
                    <label for="produto">Produto</label>
                    <input id="produto" name="produto" value="<?= h($produto) ?>" required>
                </div>
            </div>
            <div class="linha-campos">
                <div class="campo">
                    <label for="preco">Preço unitário (R$)</label>
                    <input id="preco" name="preco" inputmode="decimal" placeholder="Ex.: 99,90" value="<?= h($preco) ?>" required>
                </div>
                <div class="campo">
                    <label for="quantidade">Quantidade</label>
                    <input id="quantidade" name="quantidade" inputmode="numeric" value="<?= h($quantidade) ?>" required>
                </div>
            </div>
            <div class="campo">
                <label for="tipo">Tipo de cliente</label>
                <select id="tipo" name="tipo" required>
                    <option value=""<?= !in_array($tipo, ['comum', 'premium'], true) ? ' selected' : '' ?>>Selecione</option>
                    <option value="comum"<?= $tipo === 'comum' ? ' selected' : '' ?>>Comum</option>
                    <option value="premium"<?= $tipo === 'premium' ? ' selected' : '' ?>>Premium</option>
                </select>
            </div>
            <button type="submit">Simular pedido</button>
        </form>

        <?php if ($resumo !== null): ?>
            <section class="cartao resultado" aria-labelledby="titulo-resultado">
                <h2 id="titulo-resultado">Resumo do pedido</h2>
                <dl>
                    <div><dt>Cliente</dt><dd><?= h($resumo['cliente']) ?></dd></div>
                    <div><dt>Produto</dt><dd><?= h($resumo['produto']) ?></dd></div>
                    <div><dt>Preço unitário</dt><dd><?= formatarReais($resumo['preco']) ?></dd></div>
                    <div><dt>Quantidade</dt><dd><?= $resumo['quantidade'] ?></dd></div>
                    <div><dt>Subtotal</dt><dd><?= formatarReais($resumo['subtotal']) ?></dd></div>
                    <div><dt>Percentual de desconto</dt><dd><?= $resumo['percentual'] ?>%</dd></div>
                    <div><dt>Valor do desconto</dt><dd><?= formatarReais($resumo['desconto']) ?></dd></div>
                    <div class="destaque"><dt>Total a pagar</dt><dd><?= formatarReais($resumo['total']) ?></dd></div>
                </dl>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
