<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

// Marca que o usuário acessou sem login
$_SESSION['usuario_sem_login'] = true;

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cpf'])) {
    $cpf = trim($_POST['cpf']);

    // Busca reuniões pelo CPF informado
    $sql = "SELECT r.assunto, r.data, r.hora
        FROM reunioes r
        INNER JOIN participantes_reunioes pr ON pr.id_reuniao = r.id
        INNER JOIN participantes p ON p.id = pr.id_participante
        WHERE p.cpf = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    $_SESSION['cpf_participante'] = $cpf;

    // Redireciona para reunioes.php
    header("location: ../reunioes.php");
    exit;
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Reuniões do Participante</title>
    </head>

    <body>
        <h2>Reuniões vinculadas ao CPF: <?= htmlspecialchars($cpf) ?></h2>

        <?php if ($result->num_rows > 0): ?>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <strong>Assunto:</strong> <?= htmlspecialchars($row['assunto']) ?><br>
                        <strong>Data:</strong> <?= htmlspecialchars($row['data']) ?><br>
                        <strong>Horário:</strong> <?= htmlspecialchars($row['hora']) ?><br><br>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma reunião encontrada para esse CPF.</p>
        <?php endif; ?>
    </body>

    </html>

<?php
    exit;
}
?>

<!-- Se não tiver enviado o CPF ainda, exibe o formulário -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Identificação do Participante</title>
</head>

<body>
    <h2>Informe seu CPF para visualizar suas reuniões</h2>
    <form method="POST" action="">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required placeholder="Digite seu CPF">
        <button type="submit">Consultar</button>
    </form>
</body>

</html>