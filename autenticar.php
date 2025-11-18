<?php
session_start();
require_once 'config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = Database::getInstance();
$pdo = $db->getConnection();

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    die("Erro: Email e senha são obrigatórios.");
}

$sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":email" => $email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Email não encontrado no banco.");
}

if (!password_verify($senha, $usuario['senha'])) {
    die("Senha incorreta. Hash no banco: " . $usuario['senha']);
}

$_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_perfil'] = $usuario['perfil'];

header("Location: index.php");
exit;
