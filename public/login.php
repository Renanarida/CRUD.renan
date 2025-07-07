<?php
session_start();
require_once __DIR__ . '/../config/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($senha === $user['senha']) {
            // Salvar TODOS os campos do usuário na sessão
            foreach ($user as $chave => $valor) {
                $_SESSION['usuario_' . $chave] = $valor;
            }

            header("Location: reunioes.php");
            exit;
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "O usuário não foi encontrado.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./style/login.css" />
    <link rel="icon" type="image/png" href="../public/img/calendar.png">
</head>
<body id="box-body" class="d-flex justify-content-center align-items-center vh-100">
    <div id="box-caixa" class="card p-4" style="width: 350px;">
        <h3 class="mb-3">Login</h3>

        <img class="img-login" src="./img/Reuniao-email.png" alt="Foto Reunião">

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" required class="form-control" />
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" id="senha" name="senha" required class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="mt-3 text-center">
            Esqueceu a senha? <a id="link-senha" href="./src/solicitar_redefinicao.php">Clique aqui</a>
        </div>

        <div class="mt-3 text-center">
            Ainda não tem conta? <a id="link-cadastrar" href="cadastrar.php">Cadastre-se aqui</a>
        </div>
    </div>
</body>
</html>