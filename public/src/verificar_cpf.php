<?php
require_once __DIR__ . '/../../config/conexao.php';

$cpf = $_GET['cpf'] ?? '';
$idAtual = $_GET['id'] ?? null;

if ($cpf === '') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'CPF não fornecido']);
    exit;
}

if ($idAtual) {
    $sql = "SELECT id FROM participantes WHERE cpf = ? AND id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $cpf, $idAtual);
} else {
    $sql = "SELECT id FROM participantes WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
}

$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'existe']);
} else {
    echo json_encode(['status' => 'nao_existe']);
}
?>
