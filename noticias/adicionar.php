<?php
// noticias/adicionar.php - Formulário para nova notícia
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $texto = trim($_POST['texto'] ?? '');
    $imagem = null;

    if ($titulo && $texto) {
        // Upload de imagem (opcional)
        if (!empty($_FILES['imagem']['name'])) {
            $dir_upload = __DIR__ . '/../uploads/';
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg','jpeg','png','gif'];
            if (in_array($ext, $permitidas) && $_FILES['imagem']['size'] <= 2*1024*1024) {
                $nome_uniq = uniqid('img_').'.'.$ext;
                move_uploaded_file($_FILES['imagem']['tmp_name'], $dir_upload.$nome_uniq);
                $imagem = $nome_uniq;
            } else {
                $erro = "Imagem inválida (tipo ou tamanho)";
            }
        }
        if (empty($erro)) {
            $stmt = $pdo->prepare("INSERT INTO noticias (titulo, imagem, texto) VALUES (?, ?, ?)");
            $stmt->execute([$titulo, $imagem, $texto]);
            header("Location: listar.php");
            exit;
        }
    } else {
        $erro = "Preencha título e texto!";
    }
}
?>
<?php include '../includes/cabecalho.php'; ?>
<div class="formulario-noticia">
    <h2>Adicionar Notícia</h2>
    <?php if ($erro): ?><div class="erro"><?=htmlspecialchars($erro)?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Título:</label>
        <input type="text" name="titulo" required>
        <label>Imagem (opcional, jpg/png/gif até 2MB):</label>
        <input type="file" name="imagem" accept="image/*">
        <label>Texto:</label>
        <textarea name="texto" rows="8" required></textarea>
        <button type="submit">Salvar</button>
        <a href="listar.php" class="btn-voltar">Voltar</a>
    </form>
</div>
<?php include '../includes/rodape.php'; ?>