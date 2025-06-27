<?php
require_once('../../config/conexao.php');

$token = $_POST['token'] ?? '';
$novaSenha = $_POST['senha'] ?? '';

if (empty($token) || empty($novaSenha)) {
    die("Dados incompletos.");
}

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE token = :token AND token_expira > NOW()");
$stmt->execute([':token' => $token]);

if ($stmt->rowCount()) {
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha, token = NULL, token_expira = NULL WHERE id = :id");
    $stmt->execute([
        ':senha' => $novaSenha,
        ':id' => $usuario['id']
    ]);

    echo "Senha alterada com sucesso!";
    // header("Location: ../../public/src/login.php");
} else {
    echo "Token inválido ou expirado.";
}
?>
