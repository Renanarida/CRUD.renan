<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

if (!isset($_POST['cpf']) || empty(trim($_POST['cpf']))) {
    http_response_code(400);
    echo "CPF não informado.";
    exit;
}

$cpf = trim($_POST['cpf']);

$sql = "SELECT * FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['cpf_participante'] = $cpf;
    echo "CPF salvo";
} else {
    http_response_code(404);
    echo "CPF não encontrado.";
}

?>