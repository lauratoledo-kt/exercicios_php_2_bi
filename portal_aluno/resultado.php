<?php
// TODO 16 (concluído): iniciar sessão antes do HTML.
session_start();
// TODO 17 (concluído): consultar cadastro com valores padrão seguros.
$aluno = $_SESSION['aluno'] ?? null;
if (!is_array($aluno)) {
    $aluno = null;
}
// TODO 18 (concluído): mensagem de sucesso temporária (flash).
$mensagemSucesso = $_SESSION['mensagem_sucesso'] ?? '';
unset($_SESSION['mensagem_sucesso']);
$titulo = 'Meus dados';
// TODO 19 (concluído): cabeçalho reutilizável.
require __DIR__ . '/includes/cabecalho.php';
?>
<section class="content-heading">
    <span class="section-tag">CONSULTA DE INFORMAÇÕES</span>
    <h1>Meus dados</h1>
    <p>As informações apresentadas são mantidas temporariamente na sessão PHP.</p>
</section>
<?php if ($aluno !== null): ?>
    <?php if ($mensagemSucesso !== ''): ?>
        <div class="notice notice-success" role="status"><?= escapar($mensagemSucesso) ?></div>
    <?php endif; ?>
    <section class="panel result-panel" aria-label="Dados do estudante">
        <div class="panel-heading">
            <span class="avatar" aria-hidden="true">✓</span>
            <div><h2>Informações cadastradas</h2><p>Cadastro disponível nesta sessão.</p></div>
        </div>
        <dl class="info-list">
            <div><dt>Nome completo</dt><dd><?= escapar($aluno['nome'] ?? '') ?></dd></div>
            <div><dt>E-mail</dt><dd><?= escapar($aluno['email'] ?? '') ?></dd></div>
            <div><dt>Idade</dt><dd><?= escapar($aluno['idade'] ?? '') ?> anos</dd></div>
        </dl>
        <div class="form-actions">
            <a class="button button-primary" href="cadastro.php">Fazer novo cadastro</a>
            <a class="button button-outline" href="logout.php">Encerrar sessão</a>
        </div>
    </section>
<?php else: ?>
    <section class="panel empty-state">
        <div class="empty-illustration" aria-hidden="true">?</div>
        <h2>Nenhum aluno cadastrado</h2>
        <p>Você ainda não possui informações disponíveis nesta sessão. Faça seu cadastro para começar.</p>
        <a class="button button-primary" href="cadastro.php">Ir para cadastro <span aria-hidden="true">→</span></a>
    </section>
<?php endif; ?>
<?php
// TODO 20 (concluído): rodapé reutilizável.
require __DIR__ . '/includes/rodape.php';
