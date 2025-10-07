<?php
// noticias/excluir.php - Exclui notícia e imagem associada
require_once __DIR__ . '/../includes/sessao.php';
require_once __DIR__ . '/../includes/conexao.php';

$id = intval($_GET['id'] ?? 0);

// Busca notícia para apagar imagem
$stmt = $pdo->prepare("SELECT imagem FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($noticia) {
    if ($noticia['imagem']) {
        $img_path = __DIR__ . '/../uploads/' . $noticia['imagem'];
        if (file_exists($img_path)) unlink($img_path);
    }
    $stmt = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: listar.php");
exit;
?>