<?php
require_once __DIR__ . '/../../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $setor = $_POST['setor'] ?? '';
    $id_reuniao = $_POST['id_reuniao'] ?? '';

    // Verificar campos obrigatórios
    if ($nome === '' || $email === '' || $setor === '') {
        die('Por favor, preencha todos os campos obrigatórios: nome, email e setor.');
    }

    // 1️⃣ Inserir na tabela participantes
    $sql = "INSERT INTO participantes (nome, email, telefone, cpf, setor, id_reuniao) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $email, $telefone, $cpf, $setor, $id_reuniao);

    if ($stmt->execute()) {
        // Pegar o ID do participante recém-inserido
        $id_participante = $conn->insert_id;

        // 2️⃣ Inserir na tabela participantes_reunioes
        $sql2 = "INSERT INTO participantes_reunioes (id_participante, id_reuniao) VALUES (?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ii", $id_participante, $id_reuniao);
        $stmt2->execute();

        // Redirecionar para a página de reuniões
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
            <label for="cpfAdicionar" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpfAdicionar" name="cpf" required
              pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" 
              title="Digite o CPF no formato 000.000.000-00">>
          </div>
          <div class="mb-3">
            <label for="setorAdicionar" class="form-label">Setor</label>
            <input type="text" class="form-control" id="setorAdicionar" name="setor">
          </div>
        </div>
        <div class="modal-footer">
          <button id="botao-cancelar-participante" type="button" data-bs-dismiss="modal">Cancelar</button>
          <button id="botao-adicionar-participante" type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script src="./js/adicionar_participante.js"></script>