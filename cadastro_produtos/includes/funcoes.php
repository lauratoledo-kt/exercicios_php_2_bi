<?php
// Funções de limpeza, segurança e validação dos dados recebidos.
declare(strict_types=1);

function receberCampo(array $post, string $campo): string
{
    // Evita erro caso o campo não tenha sido enviado ou seja um array.
    $valor = $post[$campo] ?? '';
    return is_string($valor) ? trim($valor) : '';
}

function limparTexto(string $texto): string
{
    // Remove espaços nas extremidades e espaços repetidos no interior.
    $texto = trim($texto);
    return preg_replace('/\s+/u', ' ', $texto) ?? $texto;
}

function escapar(string $texto): string
{
    // Impede que textos digitados sejam interpretados como HTML.
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function contarCaracteres(string $texto): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($texto, 'UTF-8');
    }
    $resultado = preg_match_all('/./us', $texto);
    return $resultado === false ? strlen($texto) : $resultado;
}

/**
 * Valida os campos sem acessar o banco de dados.
 *
 * Retorno:
 *   erros      => mensagens a apresentar ao usuário;
 *   preco      => decimal normalizado com ponto e duas casas, ou null;
 *   quantidade => inteiro não negativo, ou null.
 */
function validarProduto(array $dados): array
{
    $erros = [];
    $precoValidado = null;
    $quantidadeValidada = null;

    if ($dados['nome'] === '') {
        $erros[] = 'O nome do produto é obrigatório.';
    } elseif (contarCaracteres($dados['nome']) > 150) {
        $erros[] = 'O nome deve ter no máximo 150 caracteres.';
    }

    if ($dados['categoria'] === '') {
        $erros[] = 'A categoria é obrigatória.';
    } elseif (contarCaracteres($dados['categoria']) > 100) {
        $erros[] = 'A categoria deve ter no máximo 100 caracteres.';
    }

    // Aceita preço como 250,00 ou 250.00, sem separador de milhar.
    // O limite de oito dígitos inteiros corresponde a DECIMAL(10,2).
    $precoDigitado = $dados['preco'];
    if (!preg_match('/^\d{1,8}(?:[,.]\d{1,2})?$/D', $precoDigitado)) {
        $erros[] = 'Informe um preço válido e maior que zero (ex.: 250,00).';
    } else {
        $precoNormalizado = str_replace(',', '.', $precoDigitado);
        $partes = explode('.', $precoNormalizado);
        $inteiros = (int) $partes[0];
        $centavos = (int) str_pad($partes[1] ?? '0', 2, '0');

        if ($inteiros === 0 && $centavos === 0) {
            $erros[] = 'O preço deve ser maior que zero.';
        } else {
            // Mantém precisão decimal, evitando fazer contas monetárias com float.
            $precoValidado = sprintf('%d.%02d', $inteiros, $centavos);
        }
    }

    // FILTER_VALIDATE_INT devolve o inteiro 0 para estoque zero (permitido).
    $quantidade = filter_var(
        $dados['quantidade'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 0, 'max_range' => 2147483647]]
    );

    if ($quantidade === false) {
        $erros[] = 'A quantidade deve ser um número inteiro maior ou igual a zero.';
    } else {
        $quantidadeValidada = $quantidade;
    }

    return [
        'erros' => $erros,
        'preco' => $precoValidado,
        'quantidade' => $quantidadeValidada,
    ];
}
