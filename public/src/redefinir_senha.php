<?php
require_once __DIR__ . '/../../config/conexao.php';


$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token = :token AND token_expira > NOW()");
$stmt->execute([':token' => $token]);

if ($stmt->rowCount()) {
    ?>
    <form action="processar_redefinicao.php" method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label>Nova Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Salvar nova senha</button>
    </form>
    <?php
} else {
    echo "Token inválido ou expirado.";
}