<?php
// noticias/editar.php - Editar notícia existente
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/conexao.php';

$id = intval($_GET['id'] ?? 0);

// Busca notícia
$stmt = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$noticia) die("Notícia não encontrada.");

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $texto = trim($_POST['texto'] ?? '');

    $imagem = $noticia['imagem'];

    // Imagem nova (substitui antiga)
    if (!empty($_FILES['imagem']['name'])) {
        $dir_upload = __DIR__ . '/../uploads/';
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg','jpeg','png','gif'];
        if (in_array($ext, $permitidas) && $_FILES['imagem']['size'] <= 2*1024*1024) {
            $nome_uniq = uniqid('img_').'.'.$ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], $dir_upload.$nome_uniq);
            // Apaga imagem antiga se existir
            if ($imagem && file_exists($dir_upload.$imagem)) unlink($dir_upload.$imagem);
            $imagem = $nome_uniq;
        } else {
            $erro = "Imagem inválida (tipo ou tamanho)";
        }
    }

    if ($titulo && $texto && empty($erro)) {
        $stmt = $pdo->prepare("UPDATE noticias SET titulo=?, imagem=?, texto=? WHERE id=?");
        $stmt->execute([$titulo, $imagem, $texto, $id]);
        header("Location: listar.php");
        exit;
    } elseif (!$titulo || !$texto) {
        $erro = "Preencha título e texto!";
    }
}
?>
<?php include '../includes/cabecalho.php'; ?>
<div class="formulario-noticia">
    <h2>Editar Notícia</h2>
    <?php if ($erro): ?><div class="erro"><?=htmlspecialchars($erro)?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Título:</label>
        <input type="text" name="titulo" value="<?=htmlspecialchars($noticia['titulo'])?>" required>
        <label>Imagem atual:</label>
        <?php if ($noticia['imagem']): ?>
            <img src="../uploads/<?=htmlspecialchars($noticia['imagem'])?>" class="miniatura">
        <?php else: ?> <span class="sem-imagem">-</span> <?php endif; ?>
        <label>Nova imagem (opcional):</label>
        <input type="file" name="imagem" accept="image/*">
        <label>Texto:</label>
        <textarea name="texto" rows="8" required><?=htmlspecialchars($noticia['texto'])?></textarea>
        <button type="submit">Salvar</button>
        <a href="listar.php" class="btn-voltar">Voltar</a>
    </form>
</div>
<?php include '../includes/rodape.php'; ?>