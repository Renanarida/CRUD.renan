<?php
require_once __DIR__ . '/../../config/conexao.php';

// print_r($_GET); die;// Para depuração, remova em produção

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_participante'])) {
    // Evita problemas com inputs vazios ou malformados
    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $setor = trim($_POST['setor']);
    $id_reuniao = intval($_POST['id_reuniao']);

    // Verificação simples
    if ($nome && $telefone && $email && $setor && $id_reuniao > 0) {
        $stmt = $conn->prepare("INSERT INTO participantes (nome, telefone, email, setor, id_reuniao) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nome, $telefone, $email, $setor, $id_reuniao);

        if ($stmt->execute()) {
            echo '<p style="color: white;">Participante adicionado com sucesso!</p>';
        } else {
            echo "Erro ao adicionar participante: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos corretamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                <h5 class="modal-title" id="modalEditarParticipanteLabel">Participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

                <!-- Lista de participantes carregada via JS-2 -->
                <div  class="scroll-y-400" id="modalParticipantesBody">
                    Carregando...
                </div>

        </div>
    </div>
</div>

<!-- <script src="./js/adicionar_participante.js"></script> -->
<script src="./js/editar_participante.js"></script>
