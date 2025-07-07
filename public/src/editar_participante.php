<?php
// editar_participante.php
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $setor = $_POST['setor'] ?? '';

    $sql = "UPDATE participantes SET nome=?, email=?, telefone=?, setor=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $setor, $id);
    $stmt->execute();

    header("Location: ../reunioes.php"); // ajuste se necessário
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
            <label for="editarSetor" class="form-label">Setor</label>
            <input type="text" class="form-control" id="editarSetor" name="setor">
          </div>
        </div>

        <div class="modal-footer">
          <button id="botao_salvar" type="submit">Salvar Alterações</button>
          <button id="botao_cancelar_participante" type="button" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script src="./js/editar_participante.js"></script>