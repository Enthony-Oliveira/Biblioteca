<?php
require_once 'config/database.php';
require_once 'includes/funcoes.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    exibirMensagem('erro', 'ID do autor não informado.');
    header("Location: autores.php");
    exit;
}

$id = (int) $_GET['id'];

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    // Excluir autor diretamente (sem verificar livros)
    $sql = "DELETE FROM autores WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    exibirMensagem('sucesso', 'Autor excluído com sucesso!');
    header("Location: autores.php");
    exit;
} catch (PDOException $e) {

    // Erro quando há livros relacionados (chave estrangeira)
    if ($e->getCode() == '23000') {
        exibirMensagem(
            'erro',
            'Este autor possui livros cadastrados e não pode ser excluído diretamente.'
        );
        header("Location: autores.php");
        exit;
    }

    exibirMensagem('erro', 'Erro ao excluir autor: ' . $e->getMessage());
    header("Location: autores.php");
    exit;
}
