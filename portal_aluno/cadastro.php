<?php
// TODO 04 (concluído): sessão pronta antes do HTML.
session_start();
// TODO 05 (concluído): mensagem exibida uma vez (flash).
$erro = $_SESSION['erro'] ?? '';
unset($_SESSION['erro']);
// TODO 06 (concluído): recuperar valores e remover dados temporários.
$dadosAnteriores = $_SESSION['dados_anteriores'] ?? [];
unset($_SESSION['dados_anteriores']);
if (!is_array($dadosAnteriores)) {
    $dadosAnteriores = [];
}
$nome = $dadosAnteriores['nome'] ?? '';
$email = $dadosAnteriores['email'] ?? '';
$idade = $dadosAnteriores['idade'] ?? '';
$titulo = 'Cadastro';
// TODO 07 (concluído): cabeçalho compartilhado.
require __DIR__ . '/includes/cabecalho.php';
?>
<section class="content-heading">
    <span class="section-tag">FORMULÁRIO DE CADASTRO</span>
    <h1>Cadastro do estudante</h1>
    <p>Preencha os dados abaixo. Os campos são verificados pelo PHP antes do registro na sessão.</p>
</section>
<section class="panel form-panel" aria-label="Formulário do aluno">
    <?php if ($erro !== ''): ?>
        <div class="notice notice-error" role="alert"><?= escapar($erro) ?></div>
    <?php endif; ?>
    <!-- novalidate permite testar também as mensagens de validação feitas no PHP. -->
    <form action="processar_cadastro.php" method="post" novalidate>
        <div class="field">
            <label for="nome">Nome completo <span class="required">*</span></label>
            <input type="text" id="nome" name="nome" autocomplete="name" value="<?= escapar($nome) ?>" placeholder="Ex.: Ana Souza" required>
        </div>
        <div class="field">
            <label for="email">E-mail <span class="required">*</span></label>
            <input type="email" id="email" name="email" autocomplete="email" value="<?= escapar($email) ?>" placeholder="Ex.: ana@senac.br" required>
        </div>
        <div class="field">
            <label for="idade">Idade <span class="required">*</span></label>
            <input type="number" id="idade" name="idade" inputmode="numeric" min="1" step="1" value="<?= escapar($idade) ?>" placeholder="Ex.: 22" required>
            <small>Informe um número inteiro maior que zero.</small>
        </div>
        <div class="form-actions">
            <button type="submit" class="button button-primary">Finalizar cadastro <span aria-hidden="true">→</span></button>
            <a class="text-link" href="index.php">Voltar ao início</a>
        </div>
    </form>
</section>
<?php
// TODO 08 (concluído): rodapé compartilhado.
require __DIR__ . '/includes/rodape.php';
