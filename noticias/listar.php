<?php
// noticias/listar.php - Lista de notícias com opções de editar/excluir
require_once __DIR__ . '/../includes/conexao.php';



// Busca todas as notícias ordenadas
$stmt = $pdo->query("SELECT * FROM noticias ORDER BY data_publicacao DESC");
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="noticias-header">
    <h2>Notícias</h2>
    <a href="./noticias/adicionar.php" class="btn-adicionar">+ Nova Notícia</a>
</div>
<table class="tabela-noticias">
    <thead>
        <tr>
            <th>Imagem</th>
            <th>Título</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($noticias as $n): ?>
        <tr>
            <td>
                <?php if ($n['imagem']): ?>
                    <img src="/../uploads/<?=htmlspecialchars($n['imagem'])?>" class="miniatura" alt="">
                <?php else: ?>
                    <span class="sem-imagem">-</span>
                <?php endif; ?>
            </td>
            <td><?=htmlspecialchars($n['titulo'])?></td>
            <td><?=date('d/m/Y H:i', strtotime($n['data_publicacao']))?></td>
            <td>
                <a href="editar.php?id=<?=$n['id']?>" class="btn-editar">Editar</a>
                <a href="excluir.php?id=<?=$n['id']?>" class="btn-excluir" onclick="return confirmarExclusao();">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($noticias)): ?>
        <tr><td colspan="4">Nenhuma notícia cadastrada.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<script>
function confirmarExclusao() {
    return confirm('Tem certeza que deseja excluir esta notícia?');
}
</script>

