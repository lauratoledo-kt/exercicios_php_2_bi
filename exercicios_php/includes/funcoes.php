<?php

declare(strict_types=1);

// Lê o texto sem alterá-lo, para poder recolocá-lo no campo depois do envio.
function campoPost(string $campo): string
{
    $valor = $_POST[$campo] ?? '';
    return is_string($valor) ? $valor : '';
}

// Escapa dados do usuário tanto nos campos quanto nos resumos.
function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function inteiroPositivo(string $texto): ?int
{
    $texto = trim($texto);
    if (!ctype_digit($texto)) {
        return null;
    }

    $valor = filter_var(ltrim($texto, '0'), FILTER_VALIDATE_INT);
    return $valor !== false && $valor > 0 ? $valor : null;
}

function numeroDecimal(string $texto): ?float
{
    $texto = str_replace(',', '.', trim($texto));
    if (!preg_match('/\A(?:[0-9]+(?:\.[0-9]+)?|\.[0-9]+)\z/', $texto)) {
        return null;
    }

    $valor = (float) $texto;
    return is_finite($valor) ? $valor : null;
}

function precoEmCentavos(string $texto): ?int
{
    $texto = trim($texto);
    if (!preg_match('/\A([0-9]+)(?:[,.]([0-9]{1,2}))?\z/', $texto, $partes)) {
        return null;
    }

    // 25,5 → 2550 centavos. Assim o preço não passa por um float.
    $centavos = str_pad($partes[2] ?? '', 2, '0', STR_PAD_RIGHT);
    return inteiroPositivo($partes[1] . $centavos);
}

function formatarReais(int $centavos): string
{
    $reais = (string) intdiv($centavos, 100);
    $reais = preg_replace('/\B(?=(?:[0-9]{3})+\z)/', '.', $reais);
    $fracao = str_pad((string) ($centavos % 100), 2, '0', STR_PAD_LEFT);
    return "R$ $reais,$fracao";
}
