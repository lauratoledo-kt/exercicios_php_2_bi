<?php
// TODO 01 (concluído): abrir a sessão antes do HTML.
session_start();
$titulo = 'Início';
// TODO 02 (concluído): reaproveitar o cabeçalho.
require __DIR__ . '/includes/cabecalho.php';
?>
<section class="hero">
    <div class="eyebrow"><span class="status-dot"></span> Desafio da Noite · Tecnologias para Internet</div>
    <h1>Seu espaço começa aqui.</h1>
    <p>Cadastre suas informações, consulte seus dados durante a navegação e encerre a sessão quando quiser.</p>
    <div class="hero-actions">
        <a class="button button-primary" href="cadastro.php">Realizar cadastro <span aria-hidden="true">→</span></a>
        <a class="button button-outline" href="resultado.php">Consultar meus dados</a>
    </div>
</section>
<section class="dashboard-grid" aria-label="Funcionalidades do portal">
    <article class="feature-card">
        <span class="feature-number">01</span>
        <h2>Cadastro simplificado</h2>
        <p>Informe seu nome, endereço de e-mail e idade com validação antes de confirmar.</p>
        <a href="cadastro.php">Ir para cadastro <span aria-hidden="true">→</span></a>
    </article>
    <article class="feature-card">
        <span class="feature-number">02</span>
        <h2>Consulta de informações</h2>
        <p>Seus dados permanecem disponíveis enquanto a sessão estiver ativa.</p>
        <a href="resultado.php">Ver meus dados <span aria-hidden="true">→</span></a>
    </article>
    <article class="feature-card">
        <span class="feature-number">03</span>
        <h2>Controle da sessão</h2>
        <p>Ao sair do portal, as informações temporárias são eliminadas.</p>
        <a href="logout.php">Encerrar sessão <span aria-hidden="true">→</span></a>
    </article>
</section>
<?php if (isset($_SESSION['aluno']) && is_array($_SESSION['aluno'])): ?>
    <aside class="notice notice-info" role="status">
        Bem-vindo(a) de volta, <strong><?= escapar($_SESSION['aluno']['nome'] ?? '') ?></strong>!
        Seu cadastro está disponível na página <a href="resultado.php">Meus dados</a>.
    </aside>
<?php endif; ?>
<?php
// TODO 03 (concluído): reaproveitar o rodapé.
require __DIR__ . '/includes/rodape.php';
