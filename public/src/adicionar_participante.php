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
<!-- Modal Participantes -->
<div class="modal fade" id="modalParticipantes" tabindex="-1" aria-labelledby="modalParticipantesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalParticipantesLabel">Adicionar Participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <!-- Formulário dentro do modal -->
                <form name="post_participante" method="POST">
                    <!-- Campo oculto para armazenar o ID da reunião -->
                    <input type="hidden" name="id_reuniao" id="id_reuniao">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" name="telefone" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="setor" class="form-label">Setor</label>
                            <input type="text" name="setor" class="form-control" required>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="post_participante" class="btn btn-primary">Adicionar Participante</button>
                    </div>
                </form>

                <hr>

                <!-- Lista de participantes carregada via JS -->
                <div id="modalParticipantesBody">
                    Carregando...
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modalEditarParticipante" tabindex="-1" aria-labelledby="modalEditarParticipanteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarParticipanteLabel">Editar Participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <form action="./src/editar_participante.php" method="POST">
                <div class="modal-body">
                    <!-- Campo oculto com ID do participante -->
                    <input type="hidden" name="id_participante" id="editar_id_participante">

                    <div class="mb-3">
                        <label for="editar_nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" id="editar_nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="editar_email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editar_email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editar_telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="telefone" id="editar_telefone" required>
                    </div>

                    <div class="mb-3">
                        <label for="editar_setor" class="form-label">Setor</label>
                        <input type="text" class="form-control" name="setor" id="editar_setor" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="./js/adicionar_participante.js"></script>
<script src="./js/editar_participante.js"></script>
