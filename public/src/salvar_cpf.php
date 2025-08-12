<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cpf'])) {

    $cpf = preg_replace('/\D/', '', $_POST['cpf']);

    if (strlen($cpf) === 11) {
        $_SESSION['cpf_visitante'] = $cpf;
        echo "CPF foi salvo com sucesso!";
    } else {
        echo "CPF inválido.";
    }
} else {
    echo "O campo do CPF é obrigatório.";
}

?>