<?php
// index.php - Tela de login estilizada e centralizada

session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: painel.php");
    exit;
}

// Inclui conexão e funções auxiliares
require_once __DIR__ . '/includes/conexao.php';
require_once __DIR__ . '/includes/funcoes.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $senha === $usuario['senha']) {
            // Login bem-sucedido
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: painel.php");
            exit;
        } else {
            $erro = "E-mail ou senha inválidos.";
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>
<?php include './includes/cabecalho.php'; ?>
<div class="login-container">
    <form class="login-form" method="POST" autocomplete="off">
        <h2>Login - Gerenciador de Notícias</h2>
        <?php if ($erro): ?><div class="erro"><?=htmlspecialchars($erro)?></div><?php endif; ?>
        <label>E-mail:</label>
        <input type="email" name="email" required autofocus>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Entrar</button>
    </form>
</div>
<?php include './includes/rodape.php'; ?>