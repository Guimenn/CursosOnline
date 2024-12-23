<?php
// Inclui o arquivo que contém a função para gerar o menu de navegação
include 'items/items.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		Login - EstudoMind
	</title>

	<!-- Importação de fontes do Google e ícones FontAwesome -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<!-- Importação de estilos principais e de media queries -->
	<link rel="stylesheet" href="estilos/login-teste.css">
	<link rel="stylesheet" href="estilos/items.css">
	<link rel="stylesheet" href="estilos/media-query/mq-items.css">
	<!-- Favicon do site -->
	<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
	<?php
	// Exibe o menu de navegação
	Menu($menuItems);
	?>

	<main>
		<div class="container" id="container">
			<!-- Formulário de Registro -->
			<div class="form-container sign-up-container">
				<form action="registro.php" method="post" autocomplete="off" id="register">
					<h1>Criar uma Conta</h1>
					<span>Cadastre-se agora com seu e-mail!</span>
					<div class="user-box">
						<input type="text" name="nome" required minlength="3">
						<label>Primeiro Nome</label>
					</div>
					<div class="user-box">
						<input type="text" name="email" required>
						<label>Email</label>
					</div>
					<div class="user-box">
						<input type="password" name="senha" required minlength="6">
						<label>Senha</label>
					</div>
					<div class="user-box">
						<input type="password" name="cnfsenha" required>
						<label>Confirmar Senha</label>
					</div>
					<button type="submit" name="registro" class="btnn-register">Registre-se</button>
				</form>
			</div>

			<!-- Formulário de Login -->
			<div class="form-container sign-in-container">
				<form action="login.php" autocomplete="off" id="login" method="post">
					<h1>Login</h1>
					<span>Acesse com sua conta</span>
					<div class="user-box">
						<input type="email" name="email" required>
						<label>Email</label>
					</div>
					<div class="user-box">
						<input type="password" name="senha" required>
						<label>Senha</label>
					</div>
					<a href="esqueceusenha.php">Esqueceu sua senha?</a>
					<button type="submit" name="login" class="btnn-login">Login</button>
				</form>
			</div>

			<!-- Contêiner para os painéis de sobreposição -->
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Bem-vindo de volta!</h1>
						<p>Se você já possui uma conta, faça login com suas informações pessoais para continuar.</p>
						<button class="ghost" id="signIn">Login</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Olá, Amigo!</h1>
						<p>Insira seus detalhes pessoais e comece sua jornada conosco!</p>
						<button class="ghost" id="signUp">Registre-se</button>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Importação de bibliotecas e scripts -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/menu.js"></script>
	<script src="js/login-teste.js"></script>

	<script>
		// Função para verificar se as senhas correspondem
		function verificarSenha() {
			var senha = document.getElementsByName("senha")[0].value; // Obtém a senha
			var cnfsenha = document.getElementsByName("cnfsenha")[0].value; // Obtém a confirmação da senha

			// Se as senhas não corresponderem
			if (senha !== cnfsenha) {
				// Exibe um alerta de erro caso as senhas não coincidam
				Swal.fire({
					icon: "error",
					title: "Erro de Senha!",
					text: "As senhas não correspondem.",
					width: '325px',
					background: '#1D1D1D',
					backdrop: 'rgba(0, 0, 0, 0.6)',
					color: 'white'
				});
				return false; // Impede o envio do formulário
			}
			return true; // Permite o envio do formulário se as senhas coincidirem
		}

		// Adiciona o ouvinte de evento para o formulário de registro
		document.getElementById("register").addEventListener("submit", function(event) {
			// Impede o envio do formulário se as senhas não coincidirem
			if (!verificarSenha()) {
				event.preventDefault();
			}
		});
	</script>
</body>

</html>