<?php
session_start();
include "items/navbar.php";
function autenticarUsuario($email, $senha)
{
    $arquivo = 'usuarios.txt';
    if ($handle = fopen($arquivo, 'r')) {
        while (($linha = fgets($handle)) !== false) {
            $dados = explode('|', trim($linha));
            if (count($dados) === 3) { // Certifique-se de que a linha contém 3 elementos
                list($nome, $emailArquivo, $senhaArquivo) = $dados;
                if ($email === $emailArquivo && $senha === $senhaArquivo) {
                    fclose($handle);
                    return $nome;
                }
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
        $_SESSION['usuario_email'] = $email;
        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login Sucesso</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="estilos/acompanhamentos.css">
            <link rel="stylesheet" href="estilos/items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>';
        Menu($menuItems);
        echo '
            <script>
                Swal.fire({
                    title: "Sucesso!",
                    text: "Login efetuado com sucesso!",
                    icon: "success",
                    width: "325px",
                    background: "#1D1D1D",
                    backdrop: "rgba(0, 0, 0, 0.6)",
                    color: "white"
                }).then(() => {
                    window.location.href = "index.php"; // Redireciona após o alerta
                });
            </script>
        </body>
        </html>
        ';
        exit;
    } else {
        // Exibir alerta de erro caso login falhe
        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro no Login</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="estilos/acompanhamentos.css">
            <link rel="stylesheet" href="estilos/items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>
            ';
        Menu($menuItems);
        echo '
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Login ou Senha Incorretos!",
                    text: "Por favor, tente novamente.",
                    width: "325px",
                    background: "#1D1D1D",
                    backdrop: "rgba(0, 0, 0, 0.6)",
                    color: "white"
                }).then(() => {
                    window.location.href = "login-teste.php"; // Redireciona após o alerta
                });
            </script>
        </body>
        </html>
        ';
        exit;
    }
}
?>
