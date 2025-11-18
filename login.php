<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f2f5;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background: white;
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 90%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        button {
            width: 95%;
            margin-top: 20px;
            padding: 12px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #0056b3;
        }

        .msg-sucesso {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #c3e6cb;
        }

        /* 🔗 Estilo do link de cadastro */
        .cadastro-link {
            margin-top: 18px;
            font-size: 14px;
        }

        .cadastro-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: 0.2s;
        }

        .cadastro-link a:hover {
            color: #0056b3;
        }
    </style>

</head>

<body>

    <div class="login-container">
        <h2>Sistema de Biblioteca - Login</h2>

        <?php if (isset($_GET['sucesso'])): ?>
            <p class="msg-sucesso">Usuário cadastrado com sucesso! Faça login.</p>
        <?php endif; ?>

        <form action="autenticar.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>

        <!-- 🔗 Link para registro -->
        <p class="cadastro-link">
            Não tem conta? <a href="usuario_novo.php">Cadastre-se aqui</a>.
        </p>
    </div>

</body>

</html>