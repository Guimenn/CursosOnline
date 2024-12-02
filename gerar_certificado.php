<?php
session_start();

// Captura os dados enviados via GET
if (isset($_GET['curso']) && isset($_GET['modulo'])) {
    $curso = htmlspecialchars($_GET['curso']); // Nome do curso
    $modulo = htmlspecialchars($_GET['modulo']); // Nome do módulo
} else {
    die("Os parâmetros do curso e módulo são obrigatórios!");
}

$usuario = $_SESSION['usuario_email']; // Recupera o email do usuário da sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars($_POST['nome']); // Nome do estudante

    // Cria o caminho para o arquivo do certificado
    $pasta_usuario = "certificados/{$usuario}/{$curso}/";
    $arquivo_certificado = "{$pasta_usuario}{$modulo}.png";

    // Verifica se o certificado já foi emitido
    if (file_exists($arquivo_certificado)) {
        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro no Login</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
            <style>
                body {
                    font-family: "Poppins", sans-serif;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "warning",
                    title: "O certificado do curso ' . $modulo . ' já foi emitido!",
                    text: "",
                    confirmButtonText: "Voltar",
                    confirmButtonColor: "#24D162",
                    width: "325px",
                    background: "#1D1D1D",
                    backdrop: "rgba(0, 0, 0, 0.6)",
                    color: "white"
                }).then(() => {
                    window.location.href = "acompanhamento.php";
                });
            </script>
        </body>
        </html>
        ';
        exit();
    }

    // Cria a pasta para o usuário, se não existir
    if (!file_exists($pasta_usuario)) {
        mkdir($pasta_usuario, 0777, true);
    }

    // Dimensões da imagem
    $largura = 1000;
    $altura = 700;

    // Cria uma nova imagem em branco
    $imagem = imagecreatetruecolor($largura, $altura);

    // Define as cores
    $cor_fundo = imagecolorallocate($imagem, 245, 245, 245); // Fundo claro
    $cor_borda = imagecolorallocate($imagem, 0, 0, 0);       // Preto
    $cor_texto = imagecolorallocate($imagem, 50, 50, 50);     // Cinza Escuro
    $cor_destaque = imagecolorallocate($imagem, 76, 175, 80); // Verde

    // Preenche o fundo
    imagefill($imagem, 0, 0, $cor_fundo);

    // Adiciona uma borda ao redor do certificado
    $espessura_borda = 15;
    for ($i = 0; $i < $espessura_borda; $i++) {
        imagerectangle($imagem, $i, $i, $largura - $i - 1, $altura - $i - 1, $cor_borda);
    }

    // Centraliza texto horizontalmente
    function centralizar_texto($imagem, $texto, $fonte, $tamanho, $y, $cor)
    {
        $caixa_texto = imagettfbbox($tamanho, 0, $fonte, $texto);
        $largura_texto = $caixa_texto[2] - $caixa_texto[0];
        $x = (imagesx($imagem) - $largura_texto) / 2;
        imagettftext($imagem, $tamanho, 0, $x, $y, $cor, $fonte, $texto);
    }

    // Caminho para a fonte
    $fonte = 'C:/Windows/Fonts/arial.ttf';
    $fonteescrita= 'C:/Windows/Fonts/Mtcorsva.ttf';

    // Adiciona os textos centralizados
    centralizar_texto($imagem, "CERTIFICADO DE CONCLUSÃO", $fonte, 36, 100, $cor_destaque);
    centralizar_texto($imagem, "Este certificado é concedido a:", $fonte, 20, 200, $cor_texto);
    centralizar_texto($imagem, strtoupper($nome), $fonte, 28, 270, $cor_texto);
    centralizar_texto($imagem, "Por concluir o curso de:", $fonte, 20, 340, $cor_texto);
    centralizar_texto($imagem, "{$curso} - {$modulo}", $fonte, 24, 400, $cor_destaque);
    centralizar_texto($imagem, "Emitido em: " . date('d/m/Y'), $fonte, 16, 500, $cor_texto);
    centralizar_texto($imagem, "ESTUDOMIND", $fonteescrita, 30, 550, $cor_texto);
    centralizar_texto($imagem, "Assinatura digital de EstudoMind", $fonte, 14, 580, $cor_texto);

    // Salva a imagem em arquivo
    imagepng($imagem, $arquivo_certificado);

    // Libera a memória
    imagedestroy($imagem);

    // Exibe a imagem gerada com opção de download
    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Certificado Gerado</title>
        <style>
            body {
                background-color: #1D1D1D;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-family: 'Poppins', Arial, sans-serif;
                color: white;
                text-align: center;
                padding: 20px;
            }
            img {
                max-width: 90%;
                height: auto;
                margin: 20px 0;
                border: 5px solid #4CAF50;
                border-radius: 10px;
            }
            a {
                display: inline-block;
                padding: 10px 20px;
                margin: 10px;
                color: #fff;
                background-color: #24D162;
                text-decoration: none;
                font-size: 18px;
                border-radius: 5px;
                transition: 0.3s;
            }
            a:hover {
                background-color: #1B8E50;
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>
        <img src='{$arquivo_certificado}' alt='Certificado'>
        <a href='{$arquivo_certificado}' download='certificado.png'>Baixar Certificado</a>
        <a href='index.php'>Voltar</a>
    </body>
    </html>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Certificado</title>
    <link rel="stylesheet" href="estilos/gerar-certificado.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="">
            <h2>Gerar Certificado</h2>
            <label for="nome">Nome do Estudante:</label>
            <input type="text" id="nome" name="nome" required minlength="6" placeholder="Digite seu nome completo" autofocus autocomplete="off"><br><br>
            <button type="submit">Gerar Certificado</button>
        </form>
    </div>
</body>

</html>