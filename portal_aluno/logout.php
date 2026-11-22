<?php
// TODO 21 (concluído): recuperar a sessão atual.
session_start();
// TODO 22 (concluído): apagar as variáveis da sessão.
$_SESSION = [];

// Remover o cookie da sessão no navegador (complemento de segurança).
if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $parametros['path'],
        'domain' => $parametros['domain'],
        'secure' => $parametros['secure'],
        'httponly' => $parametros['httponly'],
        'samesite' => $parametros['samesite'] ?? 'Lax',
    ]);
}
// TODO 23 (concluído): destruir a sessão no servidor.
session_destroy();
// TODO 24 (concluído): voltar ao início e parar a execução.
header('Location: index.php', true, 303);
exit;
