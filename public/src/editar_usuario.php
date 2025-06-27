<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['acao'] === 'editar') {
    $id = (int) $_POST['usuario_id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    if ($id && $nome && $email) {
        $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nome, $email, $id);

        if ($stmt->execute()) {
            // Busca dados atualizados no banco
            $result = $conn->query("SELECT nome, email FROM usuarios WHERE id = $id")->fetch_assoc();
            $_SESSION['usuario_nome'] = $result['nome'];
            $_SESSION['usuario_email'] = $result['email'];

            header("Location: ../reunioes.php");
            exit;
        } else {
            echo "Erro ao atualizar usuário.";
        }
    } else {
        echo "Campos obrigatórios não preenchidos.";
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>
<!-- Modal de Edição de Usuário -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="./src/editar_usuario.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?>">

        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($_SESSION['usuario_nome']) ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['usuario_email']) ?>" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="acao" value="editar" class="btn btn-primary">Salvar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
