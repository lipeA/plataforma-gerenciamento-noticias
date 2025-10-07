<?php
// Controle de sessão protegendo rotas
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /index.php");
    exit;
}
?>