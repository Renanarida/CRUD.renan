<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Configurações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="container mt-5">

    <h2>Configurações do Sistema</h2>

    <form action="salvar_configuracoes.php" method="post">
        <div class="mb-3">
            <label for="tema" class="form-label">Tema do Site</label>
            <select class="form-select" name="tema" id="tema">
                <option value="claro">Claro</option>
                <option value="escuro">Escuro</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notificacoes" class="form-label">Receber notificações?</label>
            <select class="form-select" name="notificacoes" id="notificacoes">
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Configurações</button>
    </form>

    <a href="../reunioes.php" class="btn btn-secondary mt-3">Voltar</a>

</body>

</html>
