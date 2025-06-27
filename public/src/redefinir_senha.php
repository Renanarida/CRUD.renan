<?php
require_once __DIR__ . '/../../config/conexao.php';


$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE token = :token AND token_expira > NOW()");
$stmt->execute([':token' => $token]);

if ($stmt->rowCount()) {
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/redefinir_senha.css">
    <link rel="icon" type="image/png" href="../img/padlock.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Redefinir Senha</title>
</head>

<body id="body" class="d-flex justify-content-center align-items-center vh-100">

    <div id="box-caixa">
        <form action="processar_redefinicao.php" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <label>Nova Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Salvar nova senha</button>
        </form>
    </div>
</body>
        <?php
    } else {
        echo "Token inválido ou expirado.";
    } ?>