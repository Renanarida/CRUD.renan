<?php
require_once __DIR__ . '/../config/conexao.php';

$hoje = date('Y-m-d');
$result = $conn->query("SELECT * FROM reunioes ORDER BY data, hora");


session_start(); // precisa estar no topo de todos os arquivos que usam sessão

// Verificação básica de login (opcional)
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

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
        <a href="../index.php">Início</a>
        <!-- <a href="#"></a> -->
        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">Editar</a>
        <a href="#">Configurações</a>
        <a href="./src/logout.php">Sair</a>
    </div>

    <!-- Cabeçalho -->
    <header class="header-box">
        <button class="openbtn" onclick="toggleSidebar()"><img src="../public/img/interface.png" alt="hamburguer do site" height="30px" width="30px"></button>
        <div>
            <strong id="nome-usuario" class="text-end"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
        </div>
    </header>

    <div class="box-reuniao">
        <h2 class="nome_reunioes">Reuniões</h2>
        <!-- Botão para abrir o modal -->
        <button id="cadastrar_reuniao" type="button" data-bs-toggle="modal" data-bs-target="#modalAddReuniao">
            Cadastrar Reunião
        </button>

        <?php
        include './src/editar_usuario.php';
        include './src/cadastrar_reuniao.php';
        include './src/editar_reuniao.php';
        include './src/editar_participante.php';
        // include './src/participante.php';
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

                                <?php if ($_SESSION['usuario_adm_poderoso'] == 1) { ?>

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

                                <?php } else { ?>
                                    <!-- botões de usuarios comuns -->
                                    <button id="botao_participantes" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalEditarParticipante" data-id="<?= $row['id'] ?>">
                                        Participantes
                                    </button>
                                    <button id="botao_adicionar" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAdicionarParticipante"
                                        data-id_reuniao="<?= $row['id'] ?>">
                                        Adicionar
                                    </button>


                                <?php } ?>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
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