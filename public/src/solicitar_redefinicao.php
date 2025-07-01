<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/solicitar_redefinicao.css">
    <link rel="icon" type="image/png" href="../img/padlock.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Solicitar Redefinição de Senha</title>
</head>

<body id="body" class="d-flex justify-content-center align-items-center vh-100">
    <div id="box-titulo">
        <h1 class="titulo_aviso">Solicite sua redefinição de Senha:</h1>

        <div id="box-caixa">
            <form id="solicitar_redefinicao">
                <label id="label">Digite seu email:</label>
                <input type="email" name="email" required>
                <button type="submit">Enviar</button>
            </form>
            
            <div id="mensagem" style="margin-top:10px;"></div>
        </div>
    </div>

<script>
    document.getElementById('solicitar_redefinicao').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio tradicional

        const form = e.target;
        const formData = new FormData(form);
        const mensagem = document.getElementById('mensagem');

        // Mostra mensagem enquanto espera resposta
        mensagem.textContent = 'Enviando e-mail...';
        mensagem.style.color = 'blue';

        fetch('../../enviar_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            mensagem.textContent = data;
            mensagem.style.color = data.includes("sucesso") ? 'green' : 'red';
            form.reset(); // Limpa o formulário após sucesso
            alert("Email enviado com sucesso! Verifique sua caixa de entrada ou spam.");
            alert("Você pode fechar esta página.");
        })
        .catch(error => {
            console.error('Erro:', error);
            mensagem.textContent = 'Ocorreu um erro ao enviar o formulário.';
            mensagem.style.color = 'red';
        });
    });
</script>
</body>