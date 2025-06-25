<?php

    $host = "localhost";
    $user = "root";
    $senha = "";
    $banco = "gerenciador_reunioes_renan";

    $conn = new mysqli($host, $user, $senha, $banco);

    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }


    $pdo = new PDO("mysql:host=localhost;dbname=gerenciador_reunioes_renan", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>