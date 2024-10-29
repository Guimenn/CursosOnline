<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  $arquivo = 'usuarios.txt';
  $fp = fopen($arquivo, 'r');

  while ($linha = fgets($fp)) {
    $dados = explode('|', $linha);
    if ($dados[1] == $email && $dados[2] == $senha) {
      echo "Login realizado com sucesso!";
      break;
    }
  }

  fclose($fp);
}
?>

<form action="" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email"><br><br>
  <label for="senha">Senha:</label>
  <input type="password" id="senha" name="senha"><br><br>
  <input type="submit" value="Login">
</form>