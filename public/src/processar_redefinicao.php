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

    // Redirecionar para a página de login
    session_start();
} else {
    echo "Token inválido ou expirado.";
}
?>

<script>
    alert("Senha alterada com sucesso!");
    alert("Você pode fazer login novamente.");
    window.location.href = "../../public/login.php";
</script>
