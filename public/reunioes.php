<?php
session_start();

require_once __DIR__ . '/../config/conexao.php';

$hoje = date('Y-m-d');
$result = $conn->query("SELECT * FROM reunioes ORDER BY data, hora");


// Verificação básica de login (opcional)
if (!isset($_SESSION['usuario_nome']) && !isset($_SESSION['visitante']) && !isset($_SESSION['participante'])) {
    header("Location: login.php");
    exit;
}

// ------------------------------- //
$cpf_existente = false;
$cpf = "";

// Verifica qual sessão está ativa
if (isset($_SESSION['usuario_email'])) {
    $email_usuario = $_SESSION['usuario_email'];

    // Verifica CPF no banco para usuário logado
    $sql = "SELECT cpf FROM participantes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cpf_existente = true;
        $cpf = $result->fetch_assoc()['cpf'];
    }
} elseif (isset($_SESSION['participante'])) {
    $tipo_usuario = 'participante';
} elseif (isset($_SESSION['visitante'])) {
    $tipo_usuario = 'visitante';
} else {
    $tipo_usuario = null;
}
// ----------------------------- //

//ESSA PARTE AQUI PRECISA SER ALTERADO E MELHORADO
// Se tiver CPF na sessão, filtra só as reuniões do participante
if (isset($_POST['cpf_participante'])) {
    $cpf = $_POST['cpf_participante'];
    $sql = "SELECT r.*
            FROM reunioes r
            JOIN participantes p ON p.id_reuniao = r.id
            WHERE p.cpf = ?
            ORDER BY r.data, r.hora";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Caso não tenha CPF, mostra todas
    $result = $conn->query("SELECT * FROM reunioes ORDER BY data, hora");
}
//----------------------------- //

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../public/img/calendar.png">
    <link rel="stylesheet" href="./style/reunioes.css" />
    <title>Site de Reuniões</title>
</head>

<body class="body-box">


    <!-- Sidebar retrátil com botão de fechar -->
    <div id="mySidebar" class="sidebar">
        <button class="closebtn" onclick="toggleSidebar()"><img src="../public/img/close.png" alt="icon de sair da sidebar" height="20px" width="20px"></button>

        <?php if (isset($_SESSION['usuario_nome'])): ?>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">Editar</a>
        <?php endif; ?> <!-- <--- fechando o primeiro if -->

        <?php if (isset($_SESSION['usuario_nome']) || isset($_SESSION['participante']) || isset($_SESSION['visitante'])): ?>

            <?php if (isset($_SESSION['usuario_email'])): ?>

                <?php if ($cpf_existente): ?>
                    <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCPF" onclick="preencherCPF('<?php echo $cpf; ?>')">
                        Editar CPF
                    </a>
                <?php else: ?>
                    <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCPF" onclick="preencherCPF('')">
                        Inserir CPF
                    </a>
                <?php endif; ?>

            <?php elseif (isset($_SESSION['participante']) || isset($_SESSION['visitante'])): ?>
                <a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCPF" onclick="preencherCPF('')">
                    Inserir CPF
                </a>
            <?php endif; ?>

        <?php endif; ?>


        <a id="sair-sessao" href="./src/logout.php" type="button">Sair</a>
    </div>

    <!-- Cabeçalho -->
    <header class="header-box">
        <button class="openbtn" onclick="toggleSidebar()"><img src="../public/img/interface.png" alt="hamburguer do site" height="30px" width="30px"></button>
        <div>
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <strong id="nome-usuario" class="text-end"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
            <?php else: ?>
                <strong id="nome-usuario" class="text-end">Visitante</strong>
            <?php endif; ?>
        </div>
    </header>

    <div class="box-reuniao">
        <h2 class="nome_reunioes">Reuniões</h2>
        <!-- Botão para abrir o modal -->
        <?php if (isset($_SESSION['usuario_adm_poderoso']) && $_SESSION['usuario_adm_poderoso'] == 1) { ?>
            <button id="cadastrar_reuniao" type="button" data-bs-toggle="modal" data-bs-target="#modalAddReuniao">
                Cadastrar Reunião
            </button>
        <?php } ?>

        <!-- <input type="search" id="searchCPF" placeholder="Digite seu CPF" style="width: 150px; padding: 5px 8px; font-size: 14px; border: 1px solid #ccc; border-radius: 4px;"> -->

        <?php
        include './src/editar_usuario.php';
        include './src/cadastrar_reuniao.php';
        include './src/editar_reuniao.php';
        include './src/editar_participante.php';
        include './src/adicionar_participante.php';
        ?>

        <div class="container mt-4">
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar reuniões...">
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="cardsContainer">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col card-item">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($row['assunto']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <?= date('d/m/Y', strtotime($row['data'])) ?> às <?= htmlspecialchars($row['hora']) ?>
                                </h6>
                                <p class="card-text"><strong>Local:</strong> <?= htmlspecialchars($row['local']) ?></p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">

                                <?php if (isset($_SESSION['usuario_adm_poderoso']) && $_SESSION['usuario_adm_poderoso'] == 1) { ?>

                                    <button id="botao_editar_R" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarReuniao" data-reuniao-id="<?= $row['id'] ?>"
                                        data-reuniao-data="<?= htmlspecialchars($row['data']) ?>"
                                        data-reuniao-hora="<?= htmlspecialchars($row['hora']) ?>"
                                        data-reuniao-local="<?= htmlspecialchars($row['local']) ?>"
                                        data-reuniao-assunto="<?= htmlspecialchars($row['assunto']) ?>">
                                        Editar Reunião
                                    </button>

                                    <a id="botao_excluir" type="button" href="src/excluir_reuniao.php?id=<?= $row['id'] ?>"
                                        onclick="return confirm('Excluir reunião?')">Excluir
                                    </a>

                                    <button
                                        id="botao_participantes"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditarParticipante"
                                        data-id="<?= $row['id'] ?>">
                                        Participantes
                                    </button>
                                    <button id="botao_adicionar" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAdicionarParticipante"
                                        data-id_reuniao="<?= $row['id'] ?>">
                                        Adicionar
                                    </button>

                                <?php } elseif ((isset($_SESSION['visitante']))) { ?>


                                <?php } elseif ((isset($_SESSION['participante']))) {   ?>


                                    <!-- botões de usuarios comuns -->
                                    <button id="botao_participantes" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarParticipante" data-id="<?= $row['id'] ?>">
                                        Participantes
                                    </button>
                                    <!-- <button id="botao_adicionar" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAdicionarParticipante"
                                        data-id_reuniao="<?= $row['id'] ?>">
                                        Adicionar
                                    </button> -->

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Modal CPF -->
            <div class="modal fade" id="modalCPF" tabindex="-1" aria-labelledby="modalCPFLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="formCPF" class="modal-content" method="POST" action="salvar_cpf.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalCPFLabel">Informe seu CPF</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <label for="inputCPF" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="inputCPF" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
                        </div>
                        <div class="modal-footer">
                            <button id="botao-cancelar-cpf" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button id="botao-enviar-cpf" type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Modal para listar participantes -->
            <div class="modal fade" id="modalEditarParticipante" tabindex="-1" aria-labelledby="modalEditarParticipanteLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarParticipanteLabel">Participantes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>

                        <div class="modal-body" id="modalEditarParticipanteBody">
                            Carregando participantes...
                        </div>

                    </div>
                </div>
            </div>

            <script src="./js/carregar_participantes.js"></script>
            <script src="./js/editar_reuniao.js"></script>
            <script src="./js/reunioes.js"></script>
            <script src="./js/editar_participante.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>