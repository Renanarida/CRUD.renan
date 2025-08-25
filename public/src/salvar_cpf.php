<?php
session_start();
require_once __DIR__ . '/../../config/conexao.php';

if (!isset($_POST['cpf']) || empty(trim($_POST['cpf']))) {
    http_response_code(400);
    echo "CPF não informado.";
    exit;
}

$cpf = trim($_POST['cpf']);

// 🔐 Se for usuário logado, salva no banco
if (isset($_SESSION['usuario_email'])) {
    $email = $_SESSION['usuario_email'];

    // Verifica se o CPF já existe em outro usuário
    $sql_check_dup = "SELECT cpf FROM usuarios WHERE cpf = ? AND email <> ?";
    $stmt_dup = $conn->prepare($sql_check_dup);
    $stmt_dup->bind_param("ss", $cpf, $email);
    $stmt_dup->execute();
    $stmt_dup->store_result();

    if ($stmt_dup->num_rows > 0) {
        http_response_code(409); // Conflito
        echo "Este CPF já está cadastrado em outra conta.";
        exit;
    }

    // Busca o usuário logado
    $sql_check = "SELECT cpf FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        if (!empty($usuario['cpf'])) {
            if ($usuario['cpf'] !== $cpf) {
                $sql_update = "UPDATE usuarios SET cpf = ? WHERE email = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ss", $cpf, $email);
                if ($stmt_update->execute()) {
                    $_SESSION['cpf_participante'] = $cpf;
                    echo "CPF atualizado com sucesso.";
                } else {
                    http_response_code(500);
                    echo "Erro ao atualizar CPF.";
                }
            } else {
                $_SESSION['cpf_participante'] = $cpf;
                echo "CPF já está registrado.";
            }
        } else {
            $sql_update = "UPDATE usuarios SET cpf = ? WHERE email = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $cpf, $email);
            if ($stmt_update->execute()) {
                $_SESSION['cpf_participante'] = $cpf;
                echo "CPF cadastrado com sucesso.";
            } else {
                http_response_code(500);
                echo "Erro ao cadastrar CPF.";
            }
        }
    } else {
        http_response_code(404);
        echo "Usuário não encontrado.";
    }

// ✅ Se for visitante ou participante sem login, apenas salva na sessão
} elseif (isset($_SESSION['visitante']) || isset($_SESSION['participante']) || isset($_SESSION['usuario_sem_login'])) {
    $_SESSION['cpf_participante'] = $cpf;
    echo "CPF registrado na sessão.";
} else {
    http_response_code(401);
    echo "Acesso não autorizado.";
}
