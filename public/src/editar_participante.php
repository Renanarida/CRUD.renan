<?php

require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? 0;
  $nome = $_POST['nome'] ?? '';
  $email = $_POST['email'] ?? '';
  $telefone = $_POST['telefone'] ?? '';
  $cpf = $_POST['cpf'] ?? '';
  $setor = $_POST['setor'] ?? '';

  // Verifica se o CPF já existe em outro participante
  $sql_check = "SELECT id FROM participantes WHERE cpf = ? AND id != ?";
  $stmt_check = $conn->prepare($sql_check);
  $stmt_check->bind_param("si", $cpf, $id);
  $stmt_check->execute();
  $stmt_check->store_result();

  if ($stmt_check->num_rows > 0) {
    die('Erro: Este CPF já está cadastrado para outro participante.');
  }

  // Atualiza incluindo o CPF
  $sql = "UPDATE participantes SET nome=?, email=?, telefone=?, cpf=?, setor=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $nome, $email, $telefone, $cpf, $setor, $id);

  header("Location: ../reunioes.php");
  exit;
}
?>

<head>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="./style/editar_participante.css">
</head>

<!-- Modal para editar um participante específico -->
<div class="modal fade" id="modalEditarParticipanteIndividual" tabindex="-1"
  aria-labelledby="modalEditarParticipanteIndividualLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="src/editar_participante.php" method="POST" id="formEditarParticipante">
        <input type="hidden" name="id" id="editarId">

        <div class="modal-header">
          <h5 class="modal-title" id="modalEditarParticipanteIndividualLabel">Editar Participante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="editarNome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="editarNome" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="editarEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="editarEmail" name="email" required>
          </div>
          <div class="mb-3">
            <label for="editarTelefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="editarTelefone" name="telefone">
          </div>
          <div class="mb-3">
            <label for="editarCpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="editarCpf" name="cpf" required
              pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
              title="Digite o CPF no formato 000.000.000-00">
          </div>
          <div class="mb-3">
            <label for="editarSetor" class="form-label">Setor</label>
            <input type="text" class="form-control" id="editarSetor" name="setor">
          </div>
        </div>

        <div class="modal-footer">
          <button class="botao_salvar" type="submit">Salvar Alterações</button>
          <button class="botao_cancelar_participante" type="button" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script src="./js/editar_participante.js"></script>