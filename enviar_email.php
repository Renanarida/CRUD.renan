<?php
require_once('config/conexao.php');
require_once('src2/PHPMailer.php');
require_once('src2/SMTP.php');
require_once('src2/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_POST['email']) || empty($_POST['email'])) {
    die("O campo email é obrigatório.");
}

$email = $_POST['email'];
$token = bin2hex(random_bytes(32));
$expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE email = :email");
$stmt->execute([':email' => $email]);

if ($stmt->rowCount()) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("UPDATE usuarios SET token = :token, token_expira = :expira WHERE email = :email");
    $stmt->execute([
        ':token' => $token,
        ':expira' => $expira,
        ':email' => $email
    ]);

    $link = "http://localhost/CRUD_renan/public/src/redefinir_senha.php?token=$token";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'renan.yukio.arida@gmail.com';
        $mail->Password   = 'antr oelz iwkw mnab';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('renan.yukio.arida@gmail.com', 'Renan');
        $mail->addAddress($email, $usuario['nome'] ?? 'Usuário');

        $mail->CharSet = 'UTF-8'; 

$mail->isHTML(true);
$mail->Subject = 'Redefinir senha';
$mail->AddEmbeddedImage('public/img/Reuniao-email.png', 'logoReuniao');
$mail->Body    = "
    <div style='
        font-family: Arial, sans-serif;
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    '>
        <img src='cid:logoReuniao' alt='Site Reunião' style='
    width: 100%;
    max-width: 600px;
    height: auto;
    display: block;
    margin: 0 auto;
'>

        <h2 style='color: #333;'>Redefinição de Senha</h2>

        <p>Olá <strong>{$usuario['nome']}</strong>,</p>

        <p>Você solicitou a redefinição da sua senha.</p>

        <p>
            <a href='$link' style='
            background-color:rgb(0, 102, 255);
                display: inline-block;
                padding: 12px 24px;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin: 20px 0;
                font-weight: bold;
            '>Redefinir Senha</a>
        </p>
        <p style='color: #888; font-size: 12px;'>Este link expira em 1 hora.</p>
        <hr style='margin: 30px 0; border: none; border-top: 1px solid #ccc;'>
        <p style='font-size: 12px; color: #999;'>Se você não solicitou isso, apenas ignore este e-mail.</p>
    </div>
";
$mail->AltBody = "Olá {$usuario['nome']},\n\nCopie e cole este link no navegador para redefinir sua senha:\n$link\n\nEste link expira em 1 hora.";


        $mail->send();
        // echo "E-mail de redefinição enviado com sucesso!";
        // header("Location: public/src/solicitar_redefinicao.php?success=1"); //teste de redirecionamento
       echo "E-mail de redefinição enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
} else {
    echo "E-mail não encontrado no sistema.";
}