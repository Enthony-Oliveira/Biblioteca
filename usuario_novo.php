<?php
// formulário simples para criar usuário
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <style>
        body { 
            font-family: Arial; 
            background:#f4f6f8; 
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }

        .card {
            background:#fff;
            padding:24px;
            border-radius:8px;
            box-shadow:0 6px 20px rgba(0,0,0,0.08);
            width:380px;
        }

        input, select {
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ccc;
            border-radius:6px;
        }

        button {
            width:100%;
            padding:12px;
            background:#28a745;
            color:#fff;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
            margin-top:10px;
        }

        .msg {
            padding:10px;
            border-radius:6px;
            margin-bottom:10px;
        }

        .erro {
            background:#ffe6e6;
            color:#b30000;
            border:1px solid #f5c2c2;
        }

        .sucesso {
            background:#e6ffef;
            color:#1a7a3d;
            border:1px solid #bff0c8;
        }

        /* 🔗 Link para login */
        .login-link {
            text-align:center;
            margin-top:15px;
        }

        .login-link a {
            text-decoration:none;
            color:#007bff;
            font-weight:bold;
            transition:0.2s;
        }

        .login-link a:hover {
            color:#0056b3;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Cadastrar Novo Usuário</h2>

    <?php if (isset($_GET['sucesso'])): ?>
        <div class="msg sucesso">Usuário cadastrado com sucesso.</div>
    <?php elseif (isset($_GET['erro'])): ?>
        <div class="msg erro"><?= htmlspecialchars($_GET['erro']) ?></div>
    <?php endif; ?>

    <form action="usuario_registrar.php" method="POST" autocomplete="off">
        <label>Nome</label>
        <input type="text" name="nome" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Senha</label>
        <input type="password" name="senha" required>

        <label>Perfil</label>
        <select name="perfil" required>
            <option value="bibliotecario">Bibliotecário</option>
            <option value="admin">Admin</option>
            <option value="suporte">Suporte</option>
        </select>

        <button type="submit">Cadastrar</button>
    </form>

    <!-- 🔗 Link para login -->
    <div class="login-link">
        Já tem conta? <a href="login.php">Fazer Login</a>
    </div>
</div>

</body>
</html>
