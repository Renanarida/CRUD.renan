<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = $_POST['tema'] ?? 'claro';
    $notificacoes = $_POST['notificacoes'] ?? 1;

    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("UPDATE usuarios SET tema = ?, notificacoes = ? WHERE id = ?");
    $stmt->bind_param("sii", $tema, $notificacoes, $usuario_id);
    $stmt->execute();

    // Atualiza na sessão também
    $_SESSION['config_tema'] = $tema;
    $_SESSION['config_notificacoes'] = $notificacoes;

    header("Location: configuracoes.php");
    exit;
}