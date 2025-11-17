<?php
/**
 * Header padrão do sistema
 * Incluído no topo de todas as páginas.
 */

if (!defined('PRAZO_EMPRESTIMO_DIAS')) {
    require_once __DIR__ . '/../config/config.php';
}

if (!function_exists('verificarExibirMensagens')) {
    require_once __DIR__ . '/funcoes.php';
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= defined('NOME_BIBLIOTECA') ? NOME_BIBLIOTECA : 'Sistema de Biblioteca' ?></title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f4f9;
            padding-bottom: 60px;
        }

        /* ==== NAVBAR ==== */
        nav {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        nav ul {
            list-style: none;
            display: flex;
            max-width: 1200px;
            margin: auto;
            padding: 0;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 18px 25px;
            display: block;
            font-weight: 500;
            transition: 0.3s;
        }

        nav ul li a:hover {
            background: rgba(255,255,255,0.12);
        }

        /* Botão sair à direita */
        nav ul li:last-child {
            margin-left: auto;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            border-left: 2px solid rgba(255,255,255,0.3);
        }

        .btn-logout:hover {
            background: rgba(255,255,255,0.25);
        }

        /* ==== CONTAINER PRINCIPAL ==== */
        .container {
            max-width: 1200px;
            margin: 25px auto;
            background: #fff;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
            min-height: calc(100vh - 190px);
        }

        /* HEADINGS */
        h1 {
            color: #667eea;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        h2 { color: #764ba2; margin: 20px 0 10px; }
        h3 { color: #555; margin: 15px 0 10px; }

        /* MENSAGENS */
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
            border-left: 6px solid;
        }

        .alert-success { background: #d4edda; border-color: #28a745; color: #155724; }
        .alert-danger  { background: #f8d7da; border-color: #dc3545; color: #721c24; }
        .alert-warning { background: #fff3cd; border-color: #ffc107; color: #856404; }
        .alert-info    { background: #d1ecf1; border-color: #17a2b8; color: #0c5460; }

        /* FORMATAÇÃO DE TABELAS */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        thead {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #f8f9fc;
        }

        /* BOTÕES */
        .btn {
            padding: 10px 18px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin: 5px 5px 5px 0;
            transition: 0.3s;
        }

        .btn:hover {
            filter: brightness(1.15);
        }

        .btn-danger { background: #e63946; }
        .btn-success { background: #2a9d8f; }
        .btn-info { background: #1d3557; }

        /* RESPONSIVO */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }

            nav ul li:last-child {
                margin-left: 0;
            }

            .container {
                margin: 10px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<!-- MENU -->
<nav>
    <ul>
        <li><a href="index.php">🏠 Início</a></li>
        <li><a href="livros.php">📚 Livros</a></li>
        <li><a href="clientes.php">👥 Clientes</a></li>
        <li><a href="emprestimos.php">📋 Empréstimos</a></li>
        <li><a href="autores.php">✍️ Autores</a></li>
        <li><a href="relatorios.php">📊 Relatórios</a></li>

        <li><a class="btn-logout" href="usuario_registrar.php">🚪 Sair</a></li>
    </ul>
</nav>

<!-- CONTAINER PRINCIPAL -->
<div class="container">
    <?php verificarExibirMensagens(); ?>