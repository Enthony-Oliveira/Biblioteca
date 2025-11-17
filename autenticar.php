<?php
session_start();
require_once 'config/database.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

$email = $_POST['email'] ?? null;
$senha = $_POST['senha'] ?? null;

$sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":email" => $email]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($senha, $usuario['senha'])) {

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_perfil'] = $usuario['perfil'];

    header("Location: index.php");
    exit;

} else {
    header("Location: login.php?erro=1");
    exit;
}
