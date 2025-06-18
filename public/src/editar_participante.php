<?php
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_participante']);
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    // $telefone = trim($_POST['telefone']);
    // $setor = trim($_POST['setor']);

    if ($id > 0 && $nome && $email) {
        $stmt = $conn->prepare("UPDATE participantes SET nome=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $nome, $email, $id);

        if ($stmt->execute()) {
            header("Location: ../reunioes.php?id=" . $_GET['reuniao']);
            exit;
        } else {
            echo "Erro ao atualizar participante: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Dados inválidos.";
    }
}
?>