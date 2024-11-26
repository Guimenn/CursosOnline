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
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link rel="stylesheet" href="estilos/acompanhamentos.css">
            <link rel="stylesheet" href="estilos/items.css">
            <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
        </head>
        <body>
            ';
        echo '
            <script>
                Swal.fire({
                    icon: "warning",
                    title: "O certificado do curso '. $modulo . ' já foi emitido!",
                    text: "",
                    confirmButtonText: "Voltar",
                    confirmButtonColor: "#24D162",
                    width: "325px",
                    background: "#1D1D1D",
                    backdrop: "rgba(0, 0, 0, 0.6)",
                    color: "white"
                }).then(() => {
                    window.location.href = "acompanhamento.php"; // Redireciona após o alerta
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
    $cor_fundo = imagecolorallocate($imagem, 255, 255, 255); // Branco
    $cor_borda = imagecolorallocate($imagem, 0, 0, 0);       // Preto
    $cor_texto = imagecolorallocate($imagem, 50, 50, 50);    // Cinza Escuro
    $cor_destaque = imagecolorallocate($imagem, 76, 175, 80); // Verde

    // Preenche o fundo
    imagefill($imagem, 0, 0, $cor_fundo);

    // Adiciona uma borda ao redor do certificado
    $espessura_borda = 10;
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

    // Caminho para a fonte (certifique-se de ter esta fonte em sua pasta de trabalho)
    $fonte = 'C:/Windows/Fonts/arial.ttf';

    // Adiciona os textos centralizados
    centralizar_texto($imagem, "CERTIFICADO DE CONCLUSÃO", $fonte, 36, 100, $cor_destaque);
    centralizar_texto($imagem, "Este certificado é concedido a:", $fonte, 20, 200, $cor_texto);
    centralizar_texto($imagem, strtoupper($nome), $fonte, 28, 270, $cor_texto);
    centralizar_texto($imagem, "Por concluir o curso de:", $fonte, 20, 340, $cor_texto);
    centralizar_texto($imagem, "{$curso} - {$modulo}", $fonte, 24, 400, $cor_destaque);
    centralizar_texto($imagem, "Emitido em: " . date('d/m/Y'), $fonte, 16, 500, $cor_texto);
    centralizar_texto($imagem, "___________________________", $fonte, 16, 550, $cor_texto);
    centralizar_texto($imagem, "Assinatura do Responsável", $fonte, 14, 580, $cor_texto);

    // Salva a imagem em arquivo
    imagepng($imagem, $arquivo_certificado);

    // Libera a memória
    imagedestroy($imagem);

    // Exibe a imagem gerada com opção de download
    echo "<div style='text-align: center; display: flex; flex-direction: column;'>";
    echo "<p style='font-size: 18px; font-family: Arial, sans-serif; color: #333;'>Certificado gerado com sucesso!</p>";
    echo "<img src='{$arquivo_certificado}' alt='Certificado' style='border: 5px solid #4CAF50; max-width: 80%; height: auto; margin: 20px auto;'>";

    echo "<a href='{$arquivo_certificado}' download='certificado.png' style='
    display: inline-block;
    padding: 12px 30px;
    margin: 20px auto;
    text-decoration: none;
    color: #fff;
    background-color: #4CAF50;
    border-radius: 5px;
    font-size: 18px;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
'>Baixar Certificado</a>";

    echo "<br><a href='index.php' style='
        display: inline-block;
        margin-top: 15px;
        text-decoration: none;
        font-size: 16px;
        color: #4CAF50;
    '>Voltar</a>";
    echo "</div>";
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
    <style>
       
    </style>
</head>

<body>
    <form method="POST" action="">
        <h2>Gerar Certificado</h2>
        <label for="nome">Nome do Estudante:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <button type="submit">Gerar Certificado</button>
    </form>
</body>

</html>