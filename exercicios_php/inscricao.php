<?php
// Missão da Noite — Sistema de Inscrição para Eventos (EventTech)
// Missões 2 e 5: receber os dados, remover espaços e preservar os valores.
$nome = '';
$email = '';
$idade = '';
$cidade = '';
$curso = '';
$erro = '';
$sucesso = false;

$cursosDisponiveis = [
    'Desenvolvimento Web',
    'Banco de Dados',
    'Inteligência Artificial',
];

// Missão 4: proteger os valores apresentados no HTML.
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // O operador ?? evita erros caso algum campo não seja enviado.
    // is_string impede que valores manipulados como arrays quebrem trim().
    $nome = is_string($_POST['nome'] ?? null) ? trim($_POST['nome']) : '';
    $email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    $idade = is_string($_POST['idade'] ?? null) ? trim($_POST['idade']) : '';
    $cidade = is_string($_POST['cidade'] ?? null) ? trim($_POST['cidade']) : '';
    $curso = is_string($_POST['curso'] ?? null) ? trim($_POST['curso']) : '';

    // Missão 3: validar rigorosamente na ordem exigida no enunciado.
    if ($nome === '') {
        $erro = 'O nome é obrigatório.';
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $erro = 'Informe um e-mail válido.';
    } elseif (filter_var($idade, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 16],
    ]) === false) {
        $erro = 'A idade mínima é 16 anos.';
    } elseif ($cidade === '') {
        $erro = 'Informe a cidade.';
    } elseif (!in_array($curso, $cursosDisponiveis, true)) {
        $erro = 'Selecione um curso.';
    } else {
        $sucesso = true;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscrição — Workshop EventTech</title>
    <style>
        :root {
            color-scheme: light;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f3f5fa;
            color: #172033;
        }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; padding: 48px 18px; }
        .painel {
            width: min(100%, 660px);
            margin: 0 auto;
            padding: clamp(24px, 5vw, 42px);
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 18px 50px rgb(30 41 59 / 8%);
        }
        .selo {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e9e9ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        h1 { margin: 16px 0 6px; font-size: clamp(25px, 5vw, 32px); }
        .descricao { margin: 0 0 30px; color: #64748b; line-height: 1.5; }
        form { display: grid; gap: 18px; }
        .campo { display: grid; gap: 7px; }
        label { font-size: 14px; font-weight: 700; }
        input, select {
            width: 100%;
            height: 46px;
            padding: 10px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            background: white;
            color: #172033;
            font: inherit;
        }
        input:focus, select:focus {
            outline: 2px solid #6366f1;
            outline-offset: 1px;
            border-color: #6366f1;
        }
        button {
            margin-top: 8px;
            padding: 14px 18px;
            border: 0;
            border-radius: 9px;
            background: #4f46e5;
            color: white;
            font: inherit;
            font-weight: 750;
            cursor: pointer;
        }
        button:hover { background: #4338ca; }
        .mensagem { margin: 0 0 24px; padding: 14px 16px; border-radius: 10px; line-height: 1.45; }
        .erro { color: #991b1b; background: #fef2f2; border: 1px solid #fecaca; }
        .sucesso { color: #166534; background: #f0fdf4; border: 1px solid #bbf7d0; }
        .resumo { margin-top: 24px; padding: 20px; border-radius: 12px; background: #f8fafc; }
        .resumo h2 { margin: 0 0 12px; font-size: 19px; }
        .resumo p { margin: 8px 0; overflow-wrap: anywhere; }
        .rodape { margin: 24px 0 0; font-size: 12px; text-align: center; color: #94a3b8; }
    </style>
</head>
<body>
    <main class="painel">
        <span class="selo">EventTech · Workshop</span>
        <h1>Inscrição — Workshop EventTech</h1>
        <p class="descricao">Preencha seus dados para participar de um workshop de tecnologia.</p>

        <?php if ($erro !== ''): ?>
            <p class="mensagem erro" role="alert"><?= escapar($erro) ?></p>
        <?php elseif ($sucesso): ?>
            <p class="mensagem sucesso" role="status">Inscrição realizada com sucesso!</p>
        <?php endif; ?>

        <!-- Missão 1: formulário HTML; Missão 5: valores preservados. -->
        <form method="POST" action="">
            <div class="campo">
                <label for="nome">Nome completo</label>
                <input type="text" id="nome" name="nome" value="<?= escapar($nome) ?>" placeholder="Digite seu nome completo">
            </div>

            <div class="campo">
                <label for="email">E-mail</label>
                <input type="text" id="email" name="email" inputmode="email" value="<?= escapar($email) ?>" placeholder="exemplo@email.com">
            </div>

            <div class="campo">
                <label for="idade">Idade</label>
                <input type="number" id="idade" name="idade" step="1" value="<?= escapar($idade) ?>" placeholder="Informe sua idade">
            </div>

            <div class="campo">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="<?= escapar($cidade) ?>" placeholder="Sua cidade">
            </div>

            <div class="campo">
                <label for="curso">Curso desejado</label>
                <select id="curso" name="curso">
                    <option value="" <?= $curso === '' ? 'selected' : '' ?>>Selecione um curso</option>
                    <?php foreach ($cursosDisponiveis as $opcao): ?>
                        <option value="<?= escapar($opcao) ?>" <?= $curso === $opcao ? 'selected' : '' ?>><?= escapar($opcao) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Realizar inscrição</button>
        </form>

        <?php if ($sucesso): ?>
            <section class="resumo" aria-label="Resumo da inscrição">
                <h2>Resumo da inscrição</h2>
                <p><strong>Participante:</strong> <?= escapar($nome) ?></p>
                <p><strong>Cidade:</strong> <?= escapar($cidade) ?></p>
                <p><strong>Curso:</strong> <?= escapar($curso) ?></p>
            </section>
        <?php endif; ?>

        <p class="rodape">EventTech · Sistema de inscrição para eventos</p>
    </main>
</body>
</html>
