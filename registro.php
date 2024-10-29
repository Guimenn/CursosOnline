<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $arquivo = 'usuarios.txt';
  $dados = "$nome|$email|$senha\n";

  $fp = fopen($arquivo, 'a');
  fwrite($fp, $dados);
  fclose($fp);

  echo "$nome";
}
?>

<form action="" method="post">
  <label for="nome">Nome:</label>
  <input type="text" id="nome" name="nome"><br><br>
  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br><br>
  <label for="senha">Senha:</label>
  <input type="password" id="senha" name="senha"><br><br>
  <input type="submit" value="Registrar">
</form>