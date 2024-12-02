<?php
// Inicia a sessão para gerenciar os dados do usuário
session_start();

// Inclui o arquivo que contém a função para gerar o menu da barra de navegação
include "items/navbar.php";

/**
 * Função para autenticar o usuário com base em email e senha
 * 
 * @param string $email Email fornecido pelo usuário
 * @param string $senha Senha fornecida pelo usuário
 * @return mixed Retorna o nome do usuário em caso de sucesso ou false se falhar
 */
function autenticarUsuario($email, $senha)
{
    $arquivo = 'usuarios.txt'; // Nome do arquivo que armazena os dados dos usuários
    
    // Abre o arquivo em modo de leitura
    if ($handle = fopen($arquivo, 'r')) {
        // Percorre cada linha do arquivo
        while (($linha = fgets($handle)) !== false) {
            $dados = explode('|', trim($linha));
            if (count($dados) === 3) { 
                list($nome, $emailArquivo, $senhaArquivo) = $dados; 
                if ($email === $emailArquivo && $senha === $senhaArquivo) {
                    fclose($handle); // Fecha o arquivo
                    return $nome;
                }
            }
        }
        fclose($handle); // Fecha o arquivo ao terminar de ler
    }
    return false; // Retorna false caso não encontre correspondência
}

// Verifica se o formulário foi enviado via POST e o botão de login foi clicado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Limpa qualquer sessão anterior e inicia uma nova
    session_unset();
    session_destroy();
    session_start();

    // Autentica o usuário com os dados fornecidos
    $nome = autenticarUsuario($email, $senha);

    if ($nome) {
        // Caso a autenticação seja bem-sucedida, armazena os dados do usuário na sessão
        $_SESSION['usuario'] = $nome;
        $_SESSION['usuario_email'] = $email;

        // Exibe mensagem de sucesso usando SweetAlert e redireciona para a página inicial
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
             <link rel="stylesheet" href="estilos/media-query/mq-items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>';
        Menu($menuItems); // Chama a função para exibir o menu de navegação
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
                    window.location.href = "index.php"; // Redireciona para a página inicial após o alerta
                });
            </script>
             <script src="js/menu.js"></script>
        </body>
        </html>
        ';
        exit;
    } else {
        // Exibe mensagem de erro caso a autenticação falhe
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
             <link rel="stylesheet" href="estilos/media-query/mq-items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>';
        Menu($menuItems); // Chama a função para exibir o menu de navegação
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
                    window.location.href = "login-teste.php"; // Redireciona para a página de login após o alerta
                });
            </script>
                <script src="js/menu.js"></script>
        </body>
        </html>
        ';
        exit; 
    }
}
?>
