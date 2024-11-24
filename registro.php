
<?php

// Inclui o arquivo externo contém a navbar
include "items/navbar.php";

// Função para verificar se o email já existe no arquivo
function emailJaExiste($email, $arquivo)
{
    // Abre o arquivo no modo de leitura
    if ($handle = fopen($arquivo, 'r')) {
        // Lê o arquivo linha por linha
        while (($linha = fgets($handle)) !== false) {
            // Divide a linha em partes separadas pelo caractere '|'
            $dadosLinha = explode('|', trim($linha));

            // Verifica se há pelo menos 3 partes na linha (nome, email e senha)
            if (count($dadosLinha) >= 2) {
                $emailArquivo = $dadosLinha[1];

                // Verifica se o email informado já existe no arquivo
                if ($email === $emailArquivo) {
                    fclose($handle); // Fecha o arquivo antes de retornar
                    return true; // Retorna true se o email for encontrado
                }
            }
        }
        fclose($handle); // Fecha o arquivo caso não encontre o email
    }
    return false; // Retorna false se o email não existir
}


// Verifica se o método de envio é POST e se o formulário de registro foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registro'])) {
    // Obtém os valores do formulário e remove espaços em branco
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $arquivo = 'usuarios.txt'; // Nome do arquivo onde os dados serão armazenados

    // Verifica se o email já está cadastrado
    if (emailJaExiste($email, $arquivo)) {
        // Se o email já estiver registrado, exibe uma mensagem de erro usando SweetAlert2
        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro no Registro</title>
            <!-- Importa bibliotecas e estilos necessários -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="estilos/acompanhamentos.css">
            <link rel="stylesheet" href="estilos/items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>';
        // Exibe a barra de navegação
        Menu($menuItems);
        echo '
            <script>
                // Exibe um alerta de erro e redireciona para a página de login
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
        // Caso o email não exista, salva os dados no arquivo
        $dados = "$nome|$email|$senha\n"; // Formata os dados do usuário
        $fp = fopen($arquivo, 'a'); // Abre o arquivo no modo de escrita
        fwrite($fp, $dados); // Escreve os dados no arquivo
        fclose($fp); // Fecha o arquivo

        // Exibe uma mensagem de sucesso usando SweetAlert2
        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registro Sucesso</title>
            <!-- Importa bibliotecas e estilos necessários -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="estilos/acompanhamentos.css">
            <link rel="stylesheet" href="estilos/items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>';
        // Exibe a barra de navegação
        Menu($menuItems);
        echo '
            <script>
                // Exibe um alerta de sucesso e redireciona para a página de login
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
        exit(); // Encerra o script após exibir a mensagem de sucesso
    }
}

?>
