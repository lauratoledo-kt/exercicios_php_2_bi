<?php
/**
 * Exercício da noite — Cadastro de Produtos no Banco de Dados.
 * Fluxo: POST -> receber -> limpar -> validar -> conectar -> prepare -> bind -> execute.
 */
declare(strict_types=1);

session_start();
require_once __DIR__ . '/includes/funcoes.php';

$dados = [
    'nome' => '',
    'categoria' => '',
    'preco' => '',
    'quantidade' => '',
];
$erros = [];

// Mensagem temporária após o redirecionamento do cadastro bem-sucedido.
$sucesso = $_SESSION['sucesso_produto'] ?? '';
unset($_SESSION['sucesso_produto']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Receber os dados e preservar o que foi digitado.
    foreach (array_keys($dados) as $campo) {
        $dados[$campo] = receberCampo($_POST, $campo);
    }

    // 2. Limpar campos textuais, removendo espaços excedentes.
    $dados['nome'] = limparTexto($dados['nome']);
    $dados['categoria'] = limparTexto($dados['categoria']);

    // 3. Validar tudo ANTES de acessar o banco de dados.
    $validacao = validarProduto($dados);
    $erros = $validacao['erros'];

    if ($erros === []) {
        try {
            // 4. Conectar ao MySQL usando PDO SOMENTE com dados válidos.
            require_once __DIR__ . '/config/conexao.php';
            $pdo = conectarBanco();

            // 5. SQL com parâmetros nomeados; sem concatenar dados do formulário.
            $sql = 'INSERT INTO produtos (nome, categoria, preco, quantidade)
                    VALUES (:nome, :categoria, :preco, :quantidade)';
            $comando = $pdo->prepare($sql);

            // 6. Associar os dados aos parâmetros e executar o INSERT.
            $comando->bindValue(':nome', $dados['nome'], PDO::PARAM_STR);
            $comando->bindValue(':categoria', $dados['categoria'], PDO::PARAM_STR);
            $comando->bindValue(':preco', $validacao['preco'], PDO::PARAM_STR);
            $comando->bindValue(':quantidade', $validacao['quantidade'], PDO::PARAM_INT);
            $comando->execute();

            // Padrão POST/Redirect/GET: evita INSERT duplicado ao atualizar a página.
            $_SESSION['sucesso_produto'] = 'Produto cadastrado com sucesso!';
            header('Location: index.php', true, 303);
            exit;
        } catch (PDOException $excecao) {
            // Não mostramos credenciais nem detalhes internos de SQL ao usuário.
            error_log('Falha no INSERT de produto: ' . $excecao->getMessage());
            $erros[] = 'Não foi possível gravar o produto. Verifique a conexão com o MySQL e a existência da tabela.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Cadastro de Produtos | Loja</title>
    <link rel="stylesheet" href="assets/estilo.css">
</head>
<body>
    <main class="layout">
        <div class="topo">
            <div class="marca"><span class="icone-marca">▦</span> Loja<span>Tech</span></div>
            <span class="etiqueta">PHP · PDO · MySQL</span>
        </div>

        <section class="apresentacao">
            <span class="sobretitulo">GERENCIAMENTO DE ESTOQUE</span>
            <h1>Cadastro de Produtos</h1>
            <p>Cadastre seus produtos com validação segura antes de salvar as informações no banco de dados.</p>
        </section>

        <section class="cartao" aria-labelledby="titulo-formulario">
            <div class="cartao-topo">
                <div>
                    <h2 id="titulo-formulario">Novo produto</h2>
                    <p>Preencha os campos abaixo para registrar um item no estoque.</p>
                </div>
                <span class="passo">01 / 01</span>
            </div>

            <?php if ($sucesso !== ''): ?>
                <div class="alerta sucesso" role="status"><?= escapar($sucesso) ?></div>
            <?php endif; ?>

            <?php if ($erros !== []): ?>
                <div class="alerta erro" role="alert">
                    <strong>Verifique as informações:</strong>
                    <ul>
                        <?php foreach ($erros as $erro): ?>
                            <li><?= escapar($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- novalidate permite testar as validações obrigatórias do lado do PHP. -->
            <form action="index.php" method="POST" novalidate>
                <div class="campo">
                    <label for="nome">Nome do produto <span>*</span></label>
                    <input id="nome" name="nome" type="text" maxlength="150"
                           value="<?= escapar($dados['nome']) ?>" placeholder="Ex.: Teclado Mecânico" autocomplete="off">
                </div>

                <div class="campo">
                    <label for="categoria">Categoria <span>*</span></label>
                    <input id="categoria" name="categoria" type="text" maxlength="100"
                           value="<?= escapar($dados['categoria']) ?>" placeholder="Ex.: Informática" autocomplete="off">
                </div>

                <div class="grade">
                    <div class="campo">
                        <label for="preco">Preço unitário (R$) <span>*</span></label>
                        <input id="preco" name="preco" type="text" inputmode="decimal"
                               value="<?= escapar($dados['preco']) ?>" placeholder="250,00" autocomplete="off">
                        <small>Aceita 250,00 ou 250.00, sem separador de milhar.</small>
                    </div>
                    <div class="campo">
                        <label for="quantidade">Quantidade em estoque <span>*</span></label>
                        <input id="quantidade" name="quantidade" type="text" inputmode="numeric"
                               value="<?= escapar($dados['quantidade']) ?>" placeholder="10" autocomplete="off">
                        <small>Informe um número inteiro, incluindo 0.</small>
                    </div>
                </div>

                <div class="acoes">
                    <p><span>*</span> Todos os campos são obrigatórios</p>
                    <button type="submit">Cadastrar produto <span aria-hidden="true">→</span></button>
                </div>
            </form>
        </section>
        <footer>Exercício acadêmico · Validação primeiro, gravação depois.</footer>
    </main>
</body>
</html>
