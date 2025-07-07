<?php
require_once __DIR__ . '/../../config/conexao.php';

//print_r($_POST); // Para depuração, remova em produção
// die;
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $setor = $_POST['setor'] ?? '';
    $id_reuniao = $_POST['id_reuniao'] ?? '';

    // Verificar campos obrigatórios
    if ($nome === '' || $email === '' || $setor === '') {
        die('Por favor, preencha todos os campos obrigatórios: nome, email e setor.');
    }

    // Prepare statement para evitar SQL Injection
    $sql = "INSERT INTO participantes (nome, email, telefone, setor, id_reuniao) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $telefone, $setor, $id_reuniao);

    if ($stmt->execute()) {
        header("Location: ../../public/reunioes.php");
        exit;
    } else {
        die('Erro ao salvar participante: ' . $stmt->error);
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/adicionar_participante.css">
    <style>
        .scroll-y-400 {
            max-height: 450px;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>

<!-- Modal Adicionar Participante -->
<div class="modal fade" id="modalAdicionarParticipante" tabindex="-1" aria-labelledby="modalAdicionarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="src/adicionar_participante.php" method="POST" id="formAdicionarParticipante">
        <input type="hidden" name="id_reuniao" id="idReuniaoInput">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAdicionarLabel">Adicionar Participante</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nomeAdicionar" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nomeAdicionar" name="nome" required>
          </div>
          <div class="mb-3">
            <label for="emailAdicionar" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailAdicionar" name="email" required>
          </div>
          <div class="mb-3">
            <label for="telefoneAdicionar" class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control sp_celphones" id="telefoneAdicionar" />
          </div>
          <div class="mb-3">
            <label for="setorAdicionar" class="form-label">Setor</label>
            <input type="text" class="form-control" id="setorAdicionar" name="setor">
          </div>
        </div>
        <div class="modal-footer">
          <button id="botao-adicionar-participante" type="submit">Salvar</button>
          <button id="botao-cancelar-participante" type="button" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script src="./js/adicionar_participante.js"></script>