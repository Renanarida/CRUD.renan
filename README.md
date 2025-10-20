🌐 Sistema de Gerenciamento de Reuniões — CRUD

Este projeto é um sistema de gerenciamento de reuniões desenvolvido em PHP com banco de dados MySQL e interface web responsiva utilizando Bootstrap.
Nele você pode cadastrar usuários, criar reuniões, adicionar participantes, consultar e editar dados, além de recuperar senhas via e‑mail.

🧩 Tecnologias Utilizadas

⚙️ Backend: PHP 7 ou superior com PDO para acesso seguro ao banco de dados.

🗄️ Banco de Dados: MySQL (dump de criação incluso em sql/gerenciador_reunioes_renan.sql).

📧 PHPMailer: Biblioteca para envio de e‑mails de recuperação de senha.

🎨 Frontend: HTML5, CSS3 e Bootstrap 5 para layout responsivo.

🧠 JavaScript: Scripts em public/js para validação de formulários, controle de modais e pesquisas dinâmicas.

🚀 Como Instalar e Executar
📥 1. Clonar o repositório
git clone https://github.com/Renanarida/CRUD.renan.git
cd CRUD.renan

🗄️ 2. Preparar o banco de dados

Crie um banco chamado gerenciador_reunioes_renan no MySQL:

CREATE DATABASE gerenciador_reunioes_renan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


Importe o arquivo de estrutura e dados em sql/gerenciador_reunioes_renan.sql usando sua ferramenta favorita (phpMyAdmin, MySQL Workbench ou via linha de comando):

mysql -u <usuario> -p gerenciador_reunioes_renan < sql/gerenciador_reunioes_renan.sql

🛠️ 3. Configurar conexão com o banco

O arquivo config/conexao.php contém as credenciais de acesso ao banco. Ajuste os valores de host, user, password e dbname para refletirem o seu ambiente:

// config/conexao.php
$servername = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'gerenciador_reunioes_renan';

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset('utf8mb4');


💡 Dica: É recomendável usar usuário e senha diferentes de root em produção e garantir que o arquivo de configuração não seja exposto publicamente.

🐘 4. Configurar servidor web

O projeto é uma aplicação PHP tradicional. Você pode rodá‑lo de várias formas:

✔️ Usando XAMPP/LAMP/WAMP

Copie a pasta do projeto para dentro do diretório htdocs (no XAMPP) ou da pasta pública do seu servidor Apache.

Acesse http://localhost/CRUD.renan/public/index.php pelo navegador.

🔧 Usando o servidor embutido do PHP

Se preferir, utilize o servidor interno do PHP para testes rápidos:

cd public
php -S localhost:8000


Abra http://localhost:8000/index.php
 no navegador. Essa forma dispensa a instalação do Apache.

✉️ 5. Configurar envio de e‑mail (opcional)

Para a funcionalidade de recuperação de senha por e‑mail, edite enviar_email.php com os dados SMTP do seu provedor (Mailtrap, Gmail, etc.):

// enviar_email.php
$mail->isSMTP();
$mail->Host       = 'smtp.seuprovedor.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'usuario@dominio.com';
$mail->Password   = 'senha-do-email';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;


Sem configurar o SMTP o formulário de redefinição de senha exibirá uma mensagem de erro ao tentar enviar o e‑mail.

🧭 Como Utilizar o Sistema
🛂 1. Cadastro e Login

Acesse a página inicial (index.php) e clique em Cadastrar‑se para criar um usuário.

Informe nome, e‑mail, senha e confirmação de senha (mínimo 6 caracteres). A aplicação valida o formato do e‑mail e se as senhas correspondem.

Após o cadastro, faça login com seu e‑mail e senha. Se esquecer a senha, clique em “Esqueceu a senha?” e siga o passo a passo para receber um link de redefinição via e‑mail.

🧑‍💼 2. Perfis de Usuário

O sistema possui dois tipos de conta:

Administrador: pode cadastrar, editar e excluir reuniões e participantes. Tem acesso a todas as funcionalidades.

Usuário comum: pode visualizar as reuniões disponíveis e adicionar participantes, mas não consegue excluir ou editar reuniões.

O perfil é controlado pelo campo usuario_adm_poderoso na tabela usuarios. Ao editar um usuário (arquivo src/editar_usuario.php), um administrador pode promover ou rebaixar privilégios.

🗓️ 3. Gerenciamento de Reuniões

Após o login você será redirecionado para reunioes.php, onde é possível:

Listar reuniões: todas as reuniões são mostradas em cards contendo assunto, data, hora e local. Há um campo de pesquisa para filtrar por assunto.

Cadastrar nova reunião (admin): clique no botão “Cadastrar Reunião”, preencha data, hora, local e assunto e salve. O registro será inserido na tabela reunioes.

Editar reunião (admin): em cada card há um botão “Editar” que abre um modal para alterar os dados. As alterações são persistidas via src/edit_reuniao.php.

Excluir reunião (admin): o botão “Excluir” remove a reunião definitivamente após confirmação.

Adicionar participantes: tanto administradores quanto usuários comuns podem associar participantes a uma reunião usando o botão “Adicionar”. Informe nome, e‑mail, telefone e setor; o registro é salvo na tabela participantes.

Listar/Editar participantes: o botão “Participantes” mostra a lista de pessoas inscritas naquela reunião. Administradores podem editar ou remover participantes.

👥 4. Gerenciar Perfil e Senha

No canto superior direito da página de reuniões, seu nome aparece em destaque. Clique nele para acessar o menu:

Editar Perfil: altera nome, e‑mail ou privilégio de administrador (somente outro admin pode alterar privilégios).

Alterar Senha: redefina a sua senha cadastrada.

Sair: encerra a sessão (src/logout.php).

Para redefinir senhas esquecidas, utilize a página Solicitar Redefinição (src/solicitar_redefinicao.php), insira seu e‑mail e clique em Enviar. Você receberá um link com um token válido por alguns minutos; ao acessá‑lo, informe a nova senha e ela será salva pela rotina src/processar_redefinicao.php.

💡 Dicas e Boas Práticas

🔒 Segurança: utilize senhas fortes e mantenha o arquivo conexao.php protegido. O PDO com prepared statements é usado para mitigar SQL injection.

🎨 Personalização: os arquivos de estilo ficam em public/style. Sinta‑se livre para alterar cores, fontes ou imagens em public/img.

🛠️ Manutenção do código: a lógica está separada em partials dentro de public/src (PHP) e public/js (JavaScript). Isso facilita a adição de novas funcionalidades.

✉️ Envio de Convites: embora o sistema já possua envio de e‑mail para redefinição de senha, você pode expandir a função enviar_email.php para mandar convites de reunião ou confirmações aos participantes.

📄 Licença

Este projeto foi desenvolvido para fins acadêmicos e de portfólio. Sinta‑se à vontade para utilizar e modificar conforme necessário, dando os devidos créditos ao autor.
