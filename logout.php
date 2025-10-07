<?php
// logout.php - Encerra a sessão e redireciona
session_start();
session_destroy();
header("Location: index.php");
exit;
?>