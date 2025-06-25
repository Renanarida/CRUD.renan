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

// $stmt = $conn->prepare("SELECT id, nome, email, tema, notificacoes FROM usuarios WHERE email = ?");
// $stmt->bind_param("s", $email);
// $stmt->execute();
// $result = $stmt->get_result();
// $usuario = $result->fetch_assoc();

// $_SESSION['usuario_id'] = $usuario['id'];
// $_SESSION['usuario_nome'] = $usuario['nome'];
// $_SESSION['config_tema'] = $usuario['tema'];
// $_SESSION['config_notificacoes'] = $usuario['notificacoes'];

?>

<?php

    //implementação do PHPMailer

    // require_once('src2/PHPMailer.php');
    // require_once('src2/SMTP.php');
    // require_once('src2/Exception.php');

    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\SMTP;
    // use PHPMailer\PHPMailer\Exception;

    // $mail = new PHPMailer(true);

    // try {
    //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //     $mail->isSMTP();
    //     $mail->host = 'smtp.gmail.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'renan.yukio.arida@gmail.com';
    //     $mail->Password = '123';
    //     $mail->Port = 587;

    //     $mail->setFrom('renan.yukio.arida@gmail.com');
    //     $mail->addAddress('renan.yukio.arida@gmail.com');

    //     $mail->isHTML(true);
    //     $mail->Subject = 'Teste de Envio de gmail renan arida';
    //     $mail->Body = 'Chegou o email teste do <strong>Renan Arida</strong>';
    //     $mail->AltBody = 'Chegou o email teste do Renan Arida';

    //     if($mail->send()) {
    //         echo "E-mail enviado com sucesso!";
    //     } else {
    //         echo "Erro ao enviar o e-mail.";
    //     }

    // } catch (Exception $e) {
    //     echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    // }
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
            Esqueceu a senha? <a id="link-senha" href="#">Clique aqui</a>
        </div>

        <div class="mt-3 text-center">
            Ainda não tem conta? <a id="link-cadastrar" href="cadastrar.php">Cadastre-se</a>
        </div>
    </div>
</body>
</html>