<?php
require_once('config/conexao.php'); // Caminho para seu conexao.php
require_once('src2/PHPMailer.php');
require_once('src2/SMTP.php');
require_once('src2/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verifica se o campo 'email' foi enviado
if (!isset($_POST['email']) || empty($_POST['email'])) {
    die("O campo email é obrigatório.");
}

$email = $_POST['email'];
$token = bin2hex(random_bytes(32));
$expira = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Verifica se o e-mail existe no banco
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
$stmt->execute([':email' => $email]);

if ($stmt->rowCount()) {
    // Salva o token e a data de expiração
    $stmt = $pdo->prepare("UPDATE usuarios SET token = :token, token_expira = :expira WHERE email = :email");
    $stmt->execute([
        ':token' => $token,
        ':expira' => $expira,
        ':email' => $email
    ]);

    // Link com token
    $link = "http://localhost/CRUD_renan/public/src/redefinir_senha.php?token=$token";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'renan.yukio.arida@gmail.com'; // Seu email Gmail
        $mail->Password   = 'antr oelz iwkw mnab';          // Senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('renan.yukio.arida@gmail.com', 'Renan');
        $mail->addAddress('renan.yukio.arida@gmail.com', 'Yukio'); // Envia para o próprio usuário

        $mail->isHTML(true);
        $mail->Subject = 'Redefinir senha';
        $mail->Body    = "Olá! Clique no link abaixo para redefinir sua senha:<br><br>
                         <a href='$link'>$link</a><br><br>
                         Esse link expira em 1 hora.";
        $mail->AltBody = "Copie e cole este link no navegador para redefinir sua senha: $link";
        // print_r($mail);
        $mail->send();
        echo "E-mail de redefinição enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }

} else {
    echo "E-mail não encontrado no sistema.";
}
?>
