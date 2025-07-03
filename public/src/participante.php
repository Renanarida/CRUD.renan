<?php
require_once __DIR__ . '/../../config/conexao.php';

// print_r($_GET); die;// Para depuração, remova em produção


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
    echo '<strong>Setor:</strong> ' . htmlspecialchars($p['setor']) . '<br>';
    echo '<button class="btn btn-sm btn-warning me-2 btn-editar" 
                data-id="' . $p['id'] . '" 
                data-nome="' . htmlspecialchars($p['nome']) . '"
                data-email="' . htmlspecialchars($p['email']) . '"
                data-telefone="' . htmlspecialchars($p['telefone']) . '"
                data-setor="' . htmlspecialchars($p['setor']) . '"
                data-bs-toggle="modal" 
                data-bs-target="#modalEditarParticipante">
            Editar
          </button>';
    echo '</p>';
    echo '</div>';
    echo '</div>';
}

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_participante'])) {
//     // Evita problemas com inputs vazios ou malformados
//     $nome = trim($_POST['nome']);
//     $telefone = trim($_POST['telefone']);
//     $email = trim($_POST['email']);
//     $setor = trim($_POST['setor']);
//     $id_reuniao = intval($_POST['id_reuniao']);

//     // Verificação simples
//     if ($nome && $telefone && $email && $setor && $id_reuniao > 0) {
//         $stmt = $conn->prepare("INSERT INTO participantes (nome, telefone, email, setor, id_reuniao) VALUES (?, ?, ?, ?, ?)");
//         $stmt->bind_param("ssssi", $nome, $telefone, $email, $setor, $id_reuniao);

//         if ($stmt->execute()) {
//             echo '<p style="color: white;">Participante adicionado com sucesso!</p>';
//         } else {
//             echo "Erro ao adicionar participante: " . $stmt->error;
//         }

//         $stmt->close();
//     } else {
//         echo "Por favor, preencha todos os campos corretamente.";
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
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

<!-- <script src="./js/adicionar_participante.js"></script> -->
<script src="./js/editar_participante.js"></script>
