<?php
// painel.php - Painel administrativo principal, protegido por sessão
require_once __DIR__ . '/includes/sessao.php'; // Garante autenticação
require_once __DIR__ . '/includes/cabecalho.php';
?>
<div class="painel-layout">
    <aside class="menu-lateral">
        <div class="logo">📰 Gerenciador</div>
        <nav>
            <a href="painel.php" class="ativo">Início</a>
            <a href="noticias/listar.php">Gerenciar Notícias</a>
            <a href="logout.php" class="logout">Sair</a>
        </nav>
    </aside>
    <main class="conteudo-principal">
        <h1>Bem-vindo, <?=htmlspecialchars($_SESSION['usuario_nome'])?>!</h1>
        <p>Use o menu para gerenciar as notícias.</p>
        <section>
            <?php include './noticias/listar.php'; // Mostra a lista de notícias no painel ?>
        </section>
    </main>
</div>
<?php include './includes/rodape.php'; ?>