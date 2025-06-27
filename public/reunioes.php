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

    <?php
    // $tema = $_SESSION['config_tema'] ?? 'claro';
    ?>
    <!-- <link rel="stylesheet" href="./style/tema_<?= $tema ?>.css"> -->

</head>

<body class="body-box">


    <header class="header-box">
        <nav id="nav-box" class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- <span id="saudacoes" class="navbar-text me-auto">
                    Olá, <strong id="nome-usuario"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
                </span> -->


                <!-- <a id="box-botao" class="navbar-brand ms-auto" href="./src/logout.php">
                    <strong>Logout</strong>
                </a> -->

                <div class="dropdown ms-auto">
                    <button class="botao-dropdown" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <strong id="nome-usuario"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">Editar</a></li>
                        <!-- <li><a class="dropdown-item" href="./src/configuracoes.php">Configuração</a></li> -->
                        <li><a class="dropdown-item" href="./src/logout.php">Sair</a></li>
                    </ul>
                </div>

            </div>
        </nav>

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
        include './src/participante.php';
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

                            <?php if($_SESSION['usuario_adm_poderoso'] == 1) { ?>

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

                            <button id="botao_participantes" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalEditarParticipante" data-id="<?= $row['id'] ?>">
                                Participantes
                            </button>
                            <button id="botao_adicionar" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalParticipantes" data-id="<?= $row['id'] ?>">
                                Adicionar
                            </button>

                            <?php }else {?>
                            <!-- botões de usuarios comuns -->
                            <button id="botao_participantes" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalEditarParticipante" data-id="<?= $row['id'] ?>">
                                Participantes
                            </button>
                            <button id="botao_adicionar" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalParticipantes" data-id="<?= $row['id'] ?>">
                                Adicionar
                            </button>


                            <?php }?>

                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>


            <script src="./js/editar_reuniao.js"></script>
            <script src="./js/reunioes.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            
</body>

</html>