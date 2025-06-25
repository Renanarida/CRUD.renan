<?php
require_once __DIR__ . '/../../config/conexao.php';


$token = $_POST['token'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token = :token AND token_expira > NOW()");
$stmt->execute([':token' => $token]);

if ($usuario = $stmt->fetch()) {
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha, token = NULL, token_expira = NULL WHERE id = :id");
    $stmt->execute([
        ':senha' => $senha,
        ':id' => $usuario['id']
    ]);
// print_r($stmt);

    echo "Senha redefinida com sucesso!";
} else {
    echo "Token inválido ou expirado.";
}