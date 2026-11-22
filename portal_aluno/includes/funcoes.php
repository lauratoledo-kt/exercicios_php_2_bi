<?php
// TODO 25 (concluído): verificar o formato do endereço de e-mail.
function validarEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// TODO 26 (bônus concluído): remover espaços nas extremidades do texto.
function limparTexto(string $texto): string
{
    return trim($texto);
}

// Segurança: proteger qualquer informação exibida dentro do HTML.
function escapar(mixed $valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
