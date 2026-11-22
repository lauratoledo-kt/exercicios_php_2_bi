<?php
// Testes das regras de negócio, sem precisar conectar ao MySQL.
declare(strict_types=1);

require_once __DIR__ . '/../includes/funcoes.php';

$base = [
    'nome' => 'Teclado Mecânico',
    'categoria' => 'Informática',
    'preco' => '250,00',
    'quantidade' => '10',
];

$testes = [
    ['Nome vazio', ['nome' => ''], 'O nome do produto é obrigatório.'],
    ['Categoria vazia', ['categoria' => ''], 'A categoria é obrigatória.'],
    ['Preço zero', ['preco' => '0'], 'O preço deve ser maior que zero.'],
    ['Preço negativo', ['preco' => '-1'], 'Informe um preço válido e maior que zero (ex.: 250,00).'],
    ['Preço com letras', ['preco' => 'abc'], 'Informe um preço válido e maior que zero (ex.: 250,00).'],
    ['Preço com mais de duas casas', ['preco' => '8,999'], 'Informe um preço válido e maior que zero (ex.: 250,00).'],
    ['Quantidade negativa', ['quantidade' => '-2'], 'A quantidade deve ser um número inteiro maior ou igual a zero.'],
    ['Quantidade decimal', ['quantidade' => '1,5'], 'A quantidade deve ser um número inteiro maior ou igual a zero.'],
    ['Quantidade vazia', ['quantidade' => ''], 'A quantidade deve ser um número inteiro maior ou igual a zero.'],
    ['Nome acima de 150 caracteres', ['nome' => str_repeat('a', 151)], 'O nome deve ter no máximo 150 caracteres.'],
    ['Categoria acima de 100 caracteres', ['categoria' => str_repeat('a', 101)], 'A categoria deve ter no máximo 100 caracteres.'],
];

$falhas = 0;
foreach ($testes as [$nome, $alteracoes, $mensagemEsperada]) {
    $resultado = validarProduto(array_merge($base, $alteracoes));
    $ok = in_array($mensagemEsperada, $resultado['erros'], true);
    echo ($ok ? '[OK] ' : '[FALHOU] ') . $nome . PHP_EOL;
    if (!$ok) $falhas++;
}

$validos = [
    ['Produto correto, vírgula decimal', $base, '250.00', 10],
    ['Estoque zero permitido', array_merge($base, ['quantidade' => '0']), '250.00', 0],
    ['Preço com ponto', array_merge($base, ['preco' => '0.50']), '0.50', 10],
    ['Preço com uma casa', array_merge($base, ['preco' => '12,5']), '12.50', 10],
];
foreach ($validos as [$nome, $dados, $precoEsperado, $quantidadeEsperada]) {
    $resultado = validarProduto($dados);
    $ok = $resultado['erros'] === []
        && $resultado['preco'] === $precoEsperado
        && $resultado['quantidade'] === $quantidadeEsperada;
    echo ($ok ? '[OK] ' : '[FALHOU] ') . $nome . PHP_EOL;
    if (!$ok) $falhas++;
}

$okTexto = limparTexto('  Teclado   Mecânico  ') === 'Teclado Mecânico';
$okHtml = escapar('<script>alert("x")</script>') === '&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;';
foreach (['Limpeza de espaços' => $okTexto, 'Escape de HTML' => $okHtml] as $nome => $ok) {
    echo ($ok ? '[OK] ' : '[FALHOU] ') . $nome . PHP_EOL;
    if (!$ok) $falhas++;
}

$total = count($testes) + count($validos) + 2;
echo PHP_EOL . ($total - $falhas) . '/' . $total . ' testes aprovados.' . PHP_EOL;
exit($falhas === 0 ? 0 : 1);
