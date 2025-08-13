<?php
require_once __DIR__ . '/../../config/conexao.php';

$idReuniao = $_GET['id_reuniao'] ?? 0;

if (!is_numeric($idReuniao)) {
    echo 'ID inválido.';
    exit;
}

$stmt = $conn->prepare("SELECT * FROM participantes WHERE id_reuniao = ?");
$stmt->bind_param("i", $idReuniao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<p>Nenhum participante encontrado.</p>';
    exit;
}

while ($p = $result->fetch_assoc()) {
    echo '<div class="card mb-2">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($p['nome']) . '</h5>';
    echo '<p class="card-text">';
    echo '<strong>Email:</strong> ' . htmlspecialchars($p['email']) . '<br>';
    echo '<strong>Telefone:</strong> ' . htmlspecialchars($p['telefone']) . '<br>';
    echo '<strong>CPF:</strong> ' . htmlspecialchars($p['cpf']) . '<br>';
    echo '<strong>Setor:</strong> ' . htmlspecialchars($p['setor']) . '<br>';
    echo '<button class="btn btn-sm btn-warning me-2 btn-editar" 
                data-id="' . $p['id'] . '" 
                data-nome="' . htmlspecialchars($p['nome']) . '"
                data-email="' . htmlspecialchars($p['email']) . '"
                data-telefone="' . htmlspecialchars($p['telefone']) . '"
                data-CPF="' . htmlspecialchars($p['cpf']) . '"
                data-setor="' . htmlspecialchars($p['setor']) . '"
                data-bs-toggle="modal" 
                data-bs-target="#modalEditarParticipante">
            Editar
          </button>';
    echo '</p>';
    echo '</div>';
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <style>
    .scroll-y-400 {
    max-height: 450px;
    overflow-y: auto;
    overflow-x: hidden;
}
    </style>

</head>



<div class="modal fade" id="modalEditarParticipante" tabindex="-1" aria-labelledby="modalEditarParticipanteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarParticipanteLabel">Participantes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="scroll-y-400" id="modalParticipantesBody">
        Carregando...
      </div>
    </div>
  </div>
</div>

<script src="./js/editar_participante.js"></script>
