<?php 
include 'items/items.php';
?>
	<!DOCTYPE html>
	<html lang="pt-br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<link rel="stylesheet" href="estilos/login-teste.css">
		<link rel="stylesheet" href="estilos/items.css">
	</head>

	<body>
		<?php
		Menu($menuItems);
		?>

		<main>
			<div class="container" id="container">
				<div class="form-container sign-up-container">
					<form action="registro.php" method="post" autocomplete="off" id="register">
						<h1>Criar uma Conta</h1>
						<div class="social-container">
						</div>
						<span>Cadastre-se agora com seu e-mail!</span>
						<div class="user-box">
							<input type="text" name="nome" required="">
							<label>Primeiro Nome</label>
						</div>
						<div class="user-box">
							<input type="text" name="email" required="">
							<label>Email</label>
						</div>
						<div class="user-box">
							<input type="password" name="senha" required="">
							<label>Senha</label>
						</div>
						<div class="user-box">
							<input type="password" name="cnfsenha" required="">
							<label>Confirmar Senha</label>
						</div>
						<button type="submit" name="registro" class="btnn-register">Registre-se</button>
					</form>
				</div>
				<div class="form-container sign-in-container">
					<form action="login.php" autocomplete="off" id="login" method="post">
						<h1>Login</h1>
						<div class="social-container">
						</div>
						<span>Acesse com sua conta</span>
						<div class="user-box">
							<input type="email" name="email" required>
							<label>Email</label>
						</div>
						<div class="user-box">
							<input type="password" name="senha" required>
							<label>Senha</label>
						</div>
						<a href="#">Esqueceu sua senha?</a>
						<button type="submit" name="login" class="btnn-login">Login</button>
					</form>
				</div>
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

		<script src="js/login-teste.js"></script>
	</body>

	</html>