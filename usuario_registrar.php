<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: usuario_novo.php");
    exit;
}

$db = Database::getInstance();
$pdo = $db->getConnection();

// Evita erros caso algum campo não exista
$nome  = $_POST['nome']  ?? null;
$email = $_POST['email'] ?? null;
$senha = $_POST['senha'] ?? null;
$perfil = $_POST['perfil'] ?? 'cliente';

if (!$nome || !$email || !$senha) {
    die("Erro: todos os campos são obrigatórios!");
}

// Criptografa a senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nome, email, senha, perfil) 
        VALUES (:nome, :email, :senha, :perfil)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senhaHash,
        ":perfil" => $perfil
    ]);

    // Redireciona para login após cadastrar
    header("Location: login.php?sucesso=1");
    exit;

} catch (PDOException $e) {
    echo "Erro ao cadastrar: " . $e->getMessage();
}
