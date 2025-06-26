<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/solicitar_redefinicao.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Solicitar Redefinição de Senha</title>
</head>

<body id="body" class="d-flex justify-content-center align-items-center vh-100">
    
    <div id="box-caixa">
        <form id="solicitar_redefinicao" action="../../enviar_email.php" method="post">
            <label>Digite seu email:</label>
            <input type="email" name="email" required>
            <button type="submit">Redefinir Senha</button>
        </form>
    </div>
</body>