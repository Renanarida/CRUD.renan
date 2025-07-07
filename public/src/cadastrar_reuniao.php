<?php
    require_once __DIR__ . '/../../config/conexao.php';

    if ($_POST && isset($_POST['add-reuniao'])) {
        $data = $_POST['data'];
        $hora = $_POST['hora'];
        $local = $_POST['local'];
        $assunto = $_POST['assunto'];

        $conn->query("INSERT INTO reunioes (data, hora, local, assunto)
                VALUES ('$data', '$hora', '$local', '$assunto')");

        header("Location: ./reunioes.php");
        exit;
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/cadastrar_reuniao.css">
</head>

<!-- Modal de Cadastrar Reunião -->
<div class="modal fade" id="modalAddReuniao" style="backdrop-filter: blur(5px);" tabindex="-1" aria-labelledby="modalAddReuniaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAddReuniao" method="POST" action="">
                <input type="hidden" name="add-reuniao" value="1"> <!-- Identificador do formulário -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddReuniaoLabel">Cadastrar Reunião</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dataReuniao" class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" id="dataReuniao" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" class="form-control" name="hora" id="hora" required>
                    </div>
                    <div class="mb-3">
                        <label for="local" class="form-label">Local</label>
                        <input type="text" class="form-control" name="local" id="local">
                    </div>
                    <div class="mb-3">
                        <label for="assunto" class="form-label">Assunto</label>
                        <input type="text" class="form-control" name="assunto" id="assunto" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="botao-adicionar-reuniao" type="submit">Salvar</button>
                    <button id="botao-cancelar-reuniao" type="button"  data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./js/cadastrar_reuniao.js"></script>