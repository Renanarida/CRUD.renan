<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = $_POST['tema'] ?? 'claro';
    $notificacoes = $_POST['notificacoes'] ?? '1';

    $_SESSION['config_tema'] = '$tema';
    $_SESSION['config_notificacoes'] = '$notificacoes';

    header("location: configuracoes.php");
    exit;
}

?>