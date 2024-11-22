<?php

include "items/navbar.php";
function emailJaExiste($email, $arquivo) {
    if ($handle = fopen($arquivo, 'r')) {
        while (($linha = fgets($handle)) !== false) {
            list(, $emailArquivo,) = explode('|', trim($linha));
            if ($email === $emailArquivo) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $arquivo = 'usuarios.txt';

    if (emailJaExiste($email, $arquivo)) {
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
                    title: "Erro!",
                    text: "Email já cadastrado.",
                    icon: "error",
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
    } else {
        $dados = "$nome|$email|$senha\n";
        $fp = fopen($arquivo, 'a');
        fwrite($fp, $dados);
        fclose($fp);
        
        $_SESSION['usuario_email'] = $email;
        $_SESSION['usuario'] = $nome;
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
                    text: "Usuário Registrado com Sucesso!",
                    icon: "success",
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
        exit();
    }
}
?>
