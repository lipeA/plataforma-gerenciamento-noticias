<?php
// inclui conexão segura com MySQL usando PDO
$host = 'srv885.hstgr.io';
$db = 'u945900905_noticias';
$user = 'u945900905_noticias'; // Ajuste para seu usuário MySQL
$pass = '6Yx4NLnToK';     // Ajuste para sua senha MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>

