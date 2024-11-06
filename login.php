<?php
session_start();

function autenticarUsuario($email, $senha) {
    $arquivo = 'usuarios.txt';
    if ($handle = fopen($arquivo, 'r')) {
        while (($linha = fgets($handle)) !== false) {
            list($nome, $emailArquivo, $senhaArquivo) = explode('|', trim($linha));
            if ($email === $emailArquivo && $senha === $senhaArquivo) {
                fclose($handle);
                return $nome;
            }
        }
        fclose($handle);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    session_unset();
    session_destroy();
    session_start();

    $nome = autenticarUsuario($email, $senha);

    if ($nome) {
        $_SESSION['usuario'] = $nome;
        echo "Login Efetuado com Sucesso!";
        header("Refresh: 2; url=index.php");
        exit();
    } else {
        echo "Login ou senha inválidos!";
    }
}
?>
