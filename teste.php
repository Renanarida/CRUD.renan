<?php
require_once('src2/PHPMailer.php');
require_once('src2/SMTP.php');
require_once('src2/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Corrigido
    $mail->SMTPAuth = true;
    $mail->Username = 'renan.yukio.arida@gmail.com';
    $mail->Password = 'antr oelz iwkw mnab'; // Substitua pela senha de app
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Adicionado
    $mail->Port = 587;

    $mail->setFrom('renan.yukio.arida@gmail.com', 'Renan');
    $mail->addAddress('renan.yukio.arida@gmail.com', 'Yukio'); 

    $mail->isHTML(true);
    $mail->Subject = 'Teste de Envio de gmail renan arida';
    $mail->Body = 'Chegou o email teste do <strong>Renan Arida</strong>';
    $mail->AltBody = 'Clique neste link para alterar o email: <a href="https://example.com/alterar-email">Alterar Email</a>';

    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // opcional, para debug
    $mail->Debugoutput = 'html';

    if ($mail->send()) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Erro ao enviar o e-mail.";
    }

} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
?>
