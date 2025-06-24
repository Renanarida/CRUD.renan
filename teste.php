<?php

    require_once('src2/PHPMailer.php');
    require_once('src2/SMTP.php');
    require_once('src2/Exception.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'renan.yukio.arida@gmail.com';
        $mail->Password = '123';
        $mail->Port = 587;

        $mail->setFrom('renan.yukio.arida@gmail.com');
        $mail->addAddress('renan.yukio.arida@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Teste de Envio de gmail renan arida';
        $mail->Body = 'Chegou o email teste do <strong>Renan Arida</strong>';
        $mail->AltBody = 'Chegou o email teste do Renan Arida';

        if($mail->send()) {
            echo "E-mail enviado com sucesso!";
        } else {
            echo "Erro ao enviar o e-mail.";
        }

    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
?>