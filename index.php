<?php
/**
 * Página Inicial do Sistema de Biblioteca
 * Adaptada com autenticação de login
 */


session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Impede acesso sem login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Dados do usuário logado (definidos no autenticar.php)
$usuarioNome   = $_SESSION['usuario_nome'];
$usuarioPerfil = $_SESSION['usuario_perfil'];

// Se quiser restringir somente ADMIN e BIBLIOTECÁRIO, descomente:
// $permitidos = ['admin', 'bibliotecario'];
// if (!in_array($usuarioPerfil, $permitidos)) {
//     die("Acesso permitido somente para administradores e bibliotecários.");
// }

// Inclui arquivos necessários
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'includes/funcoes.php';
require_once 'includes/header.php';

// Conexão ao banco
$db = Database::getInstance();
$pdo = $db->getConnection();

try {

    // ==========================
    // BUSCAR ESTATÍSTICAS GERAIS
    // ==========================
    $sql = "
        SELECT
            (SELECT COUNT(*) FROM livros) AS total_livros,
            (SELECT SUM(quantidade_total) FROM livros) AS total_exemplares,
            (SELECT SUM(quantidade_disponivel) FROM livros) AS exemplares_disponiveis,
            (SELECT COUNT(*) FROM clientes WHERE status = 'Ativo') AS total_clientes,
            (SELECT COUNT(*) FROM autores) AS total_autores,
            (SELECT COUNT(*) FROM emprestimos WHERE status = 'Ativo') AS emprestimos_ativos,
            (SELECT COUNT(*) FROM emprestimos WHERE status = 'Ativo' AND data_devolucao_prevista < CURDATE()) AS emprestimos_atrasados
    ";
    
    $stmt = $pdo->query($sql);
    $stats = $stmt->fetch();
?>

<!-- Título -->
<h1>🏠 Bem-vindo ao Sistema de Biblioteca</h1>

<!-- Usuário logado -->
<p style="font-size: 15px; margin-top: -10px; color: #444;">
    Usuário logado: <strong><?= htmlspecialchars($usuarioNome) ?></strong>
    (<?= htmlspecialchars($usuarioPerfil) ?>)
</p>

<!-- ==========================
     ALERTA DE EMPRÉSTIMOS ATRASADOS
     ========================== -->
<?php if ($stats['emprestimos_atrasados'] > 0): ?>
    <div class="alert alert-danger">
        <strong>⚠️ Atenção!</strong> Existem 
        <strong><?= $stats['emprestimos_atrasados'] ?></strong> empréstimo(s) em atraso.
        <a href="emprestimos.php?filtro=atrasados" style="margin-left: 10px; text-decoration: underline;">Ver detalhes »</a>
    </div>
<?php endif; ?>


<!-- ==========================
     CARDS DO DASHBOARD
     ========================== -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">

    <div style="background: linear-gradient(135deg, #667eea, #764ba2); color:white; padding:30px; border-radius:12px;">
        <div style="font-size:48px; font-weight:bold;"><?= number_format($stats['total_livros']) ?></div>
        <div>Títulos de Livros</div>
        <a href="livros.php" style="color:white;">Ver catálogo →</a>
    </div>

    <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); color:white; padding:30px; border-radius:12px;">
        <div style="font-size:48px; font-weight:bold;"><?= number_format($stats['exemplares_disponiveis']) ?></div>
        <div>Exemplares Disponíveis</div>
        <div style="font-size: 14px;">de <?= number_format($stats['total_exemplares']) ?> no total</div>
    </div>

    <div style="background: linear-gradient(135deg, #fa709a, #fee140); color:white; padding:30px; border-radius:12px;">
        <div style="font-size:48px; font-weight:bold;"><?= number_format($stats['total_clientes']) ?></div>
        <div>Clientes Ativos</div>
        <a href="clientes.php" style="color:white;">Gerenciar clientes →</a>
    </div>

    <div style="background: linear-gradient(135deg, #f093fb, #f5576c); color:white; padding:30px; border-radius:12px;">
        <div style="font-size:48px; font-weight:bold;"><?= number_format($stats['emprestimos_ativos']) ?></div>
        <div>Empréstimos Ativos</div>
        <a href="emprestimos.php" style="color:white;">Ver empréstimos →</a>
    </div>

</div>


<!-- ==========================
     AÇÕES RÁPIDAS
     ========================== -->
<div style="background: linear-gradient(135deg, #e0c3fc, #8ec5fc); padding:25px; border-radius:12px; margin:30px 0;">
    <h2>⚡ Ações Rápidas</h2>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="emprestimo_novo.php" class="btn btn-success">📝 Novo Empréstimo</a>
        <a href="cliente_novo.php" class="btn btn-info">👤 Cadastrar Cliente</a>
        <a href="livro_novo.php" class="btn btn-warning">📚 Cadastrar Livro</a>
        <a href="autor_novo.php" class="btn btn-secondary">✍️ Cadastrar Autor</a>
    </div>
</div>


<!-- ==========================
     ÚLTIMOS LIVROS
     ========================== -->

<h2>📚 Últimos Livros Cadastrados</h2>

<?php
$sql = "
    SELECT l.id, l.titulo, a.nome AS autor,
           l.ano_publicacao, l.quantidade_disponivel, l.quantidade_total
    FROM livros l
    INNER JOIN autores a ON l.autor_id = a.id
    ORDER BY l.id DESC
    LIMIT 5
";
$stmt = $pdo->query($sql);
$ultimos_livros = $stmt->fetchAll();

if ($ultimos_livros):
?>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Ano</th>
                <th>Disponibilidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ultimos_livros as $livro): ?>
            <tr>
                <td><strong><?= htmlspecialchars($livro['titulo']) ?></strong></td>
                <td><?= htmlspecialchars($livro['autor']) ?></td>
                <td><?= $livro['ano_publicacao'] ?></td>
                <td>
                    <?php if ($livro['quantidade_disponivel'] > 0): ?>
                        <span class="badge badge-success">
                            <?= $livro['quantidade_disponivel'] ?>/<?= $livro['quantidade_total'] ?>
                        </span>
                    <?php else: ?>
                        <span class="badge badge-danger">Indisponível</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="livro_detalhes.php?id=<?= $livro['id'] ?>" class="btn btn-small">Ver Detalhes</a>
                    <?php if ($livro['quantidade_disponivel'] > 0): ?>
                        <a href="emprestimo_novo.php?livro_id=<?= $livro['id'] ?>" class="btn btn-success btn-small">Emprestar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum livro cadastrado ainda.</p>
<?php endif; ?>


<!-- ==========================
     TOP 5 LIVROS MAIS EMPRESTADOS
     ========================== -->

<h2>🏆 Top 5 Livros Mais Emprestados</h2>

<?php
$sql = "
    SELECT l.id, l.titulo, a.nome AS autor,
           COUNT(e.id) AS total_emprestimos
    FROM livros l
    INNER JOIN autores a ON l.autor_id = a.id
    LEFT JOIN emprestimos e ON l.id = e.livro_id
    GROUP BY l.id
    HAVING total_emprestimos > 0
    ORDER BY total_emprestimos DESC
    LIMIT 5
";

$stmt = $pdo->query($sql);
$top_livros = $stmt->fetchAll();

if ($top_livros):
?>
    <table>
        <thead>
            <tr>
                <th style="text-align:center;">Posição</th>
                <th>Título</th>
                <th>Autor</th>
                <th style="text-align:center;">Empréstimos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $posicao = 1;
            foreach ($top_livros as $livro):
            ?>
            <tr>
                <td style="text-align:center; font-weight:bold;">#<?= $posicao ?></td>
                <td><?= htmlspecialchars($livro['titulo']) ?></td>
                <td><?= htmlspecialchars($livro['autor']) ?></td>
                <td style="text-align:center;">
                    <span class="badge badge-info"><?= $livro['total_emprestimos'] ?> empréstimos</span>
                </td>
            </tr>
            <?php
            $posicao++;
            endforeach;
            ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum empréstimo registrado ainda.</p>
<?php endif; ?>


<?php
} catch (PDOException $e) {
    exibirMensagem('erro', 'Erro ao carregar os dados: ' . $e->getMessage());
}

require_once 'includes/footer.php';
?>
