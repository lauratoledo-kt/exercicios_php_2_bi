<?php
// TODO 09 (concluído): habilitar sessões antes de redirecionar.
session_start();
// TODO 10 (concluído): carregar funções apenas uma vez.
require_once __DIR__ . '/includes/funcoes.php';

// TODO 11 (concluído): bloquear acessos que não sejam POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php', true, 303);
    exit;
}

// TODO 12 (concluído): receber campos com segurança e tratar espaços.
// O texto original tratado é guardado para preservar o formulário se houver erro.
$nome = limparTexto(is_string($_POST['nome'] ?? null) ? $_POST['nome'] : '');
$email = limparTexto(is_string($_POST['email'] ?? null) ? $_POST['email'] : '');
$idadeTexto = limparTexto(is_string($_POST['idade'] ?? null) ? $_POST['idade'] : '');

// filter_input retorna int para idades válidas, false para inválidas e null
// quando o campo está ausente; é importante diferenciá-los de zero.
$idade = filter_input(INPUT_POST, 'idade', FILTER_VALIDATE_INT);

// TODO 13 (concluído): validar na ordem definida pelo enunciado.
$erro = '';
if ($nome === '') {
    $erro = 'O nome é obrigatório.';
} elseif (!validarEmail($email)) {
    $erro = 'Informe um e-mail válido.';
} elseif ($idade === null || $idade === false || $idade <= 0) {
    $erro = 'Informe uma idade inteira maior que zero.';
}

// TODO 14 (concluído): preservar dados e erro durante o redirecionamento.
if ($erro !== '') {
    $_SESSION['erro'] = $erro;
    $_SESSION['dados_anteriores'] = [
        'nome' => $nome,
        'email' => $email,
        'idade' => $idadeTexto,
    ];
    header('Location: cadastro.php', true, 303);
    exit;
}

// TODO 15 (concluído): registrar aluno na sessão e confirmar uma vez.
session_regenerate_id(true);
$_SESSION['aluno'] = [
    'nome' => $nome,
    'email' => $email,
    'idade' => $idade,
];
$_SESSION['mensagem_sucesso'] = 'Cadastro realizado com sucesso!';
unset($_SESSION['erro'], $_SESSION['dados_anteriores']);
header('Location: resultado.php', true, 303);
exit;
