<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

$id = $_GET['id'] ?? 0;
$id = (int) $id;

$reuniao = $conn->query("SELECT * FROM reunioes WHERE id=$id")->fetch_assoc();
$participantes = $conn->query("SELECT * FROM participantes WHERE id_reuniao=$id");

if (!$reuniao) {
    echo "<p>Reunião não encontrada.</p>";
    exit;
}

echo "<h5>Participantes da reunião: " . htmlspecialchars($reuniao['assunto']) . "</h5>";

if ($participantes->num_rows > 0) {
    echo "<div class='row row-cols-1 row-cols-md-2 g-3'>";

    while ($p = $participantes->fetch_assoc()) {
?>

        <head>
            <link rel="stylesheet" href="./style/carregar_participantes.css">
        </head>

        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($p['nome']) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($p['email']) ?></h6>
                    <p class="card-text">
                        <strong>Telefone:</strong> <?= htmlspecialchars($p['telefone']) ?><br>
                        <strong>Setor:</strong> <?= htmlspecialchars($p['setor']) ?>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0 d-flex gap-2">

                    <?php if ($_SESSION['usuario_adm_poderoso'] == 1) { ?>
                        
                        <!-- Botão Editar -->
                        <button id="botao_editar_participante" type="button" class="botao_editar_participante btn-editar-participante"
                            data-id="<?= $p['id'] ?>"
                            data-nome="<?= htmlspecialchars($p['nome']) ?>"
                            data-email="<?= htmlspecialchars($p['email']) ?>"
                            data-telefone="<?= htmlspecialchars($p['telefone']) ?>"
                            data-setor="<?= htmlspecialchars($p['setor']) ?>">
                            Editar
                        </button>

                        <!-- Botão Remover -->
                        <a id="botao_remover" href="src/excluir_participante.php?id=<?= $p['id'] ?>&reuniao=<?= $id ?>"
                            onclick="return confirm('Remover participante?')">
                            Remover
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php
    }

    echo "</div>";
} else {
    echo "<p>Nenhum participante cadastrado.</p>";
}
?>