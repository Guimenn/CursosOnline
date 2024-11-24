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

    // Cria a pasta para o usuário, se não existir
    $pasta_usuario = "certificados/{$usuario}/{$curso}/{$modulo}";
    if (!file_exists($pasta_usuario)) {
        mkdir($pasta_usuario, 0777, true); // Cria a pasta com permissão total
    }

    // Salva os dados no arquivo de acompanhamento dentro da pasta do usuário
    $dados = "Nome: " . $nome . "\nCurso: " . $curso . "\nMódulo: " . $modulo . "\nData: " . date('d/m/Y') . "\n\n";
    file_put_contents("{$pasta_usuario}/{$usuario}/{$curso}/{$modulo}.txt", $dados, FILE_APPEND); // Salva o arquivo dentro da pasta do usuário

    // Renderiza o certificado como HTML
    echo "<!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Certificado de Conclusão</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
                text-align: center;
            }
            .certificado {
                width: 800px;
                margin: 0 auto;
                background: #fff;
                padding: 20px;
                border: 10px solid #ccc;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .certificado h1 {
                font-size: 36px;
                color: #4CAF50;
                margin-bottom: 20px;
            }
            .certificado p {
                font-size: 18px;
                line-height: 1.6;
                margin: 10px 0;
            }
            .certificado .selo {
                margin-top: 30px;
                font-size: 14px;
                color: #666;
            }
            .assinatura {
                margin-top: 50px;
                font-size: 16px;
                font-style: italic;
            }
            .assinatura span {
                display: block;
                margin-top: 5px;
                font-style: normal;
                font-weight: bold;
            }
            /* Estilo para impressão */
            @media print {
                body {
                    background: none;
                    margin: 0;
                }
                .certificado {
                    box-shadow: none;
                }
                #imprimir {
                    display: none; /* Ocultar botão de impressão */
                }
            }
        </style>
    </head>
    <body>
        <div class='certificado'>
            <h1>Certificado de Conclusão</h1>
            <p>Este certificado é concedido a:</p>
            <p style='font-size: 24px; font-weight: bold;'>" . strtoupper($nome) . "</p>
            <p>Por concluir o curso de:</p>
            <p style='font-size: 20px; font-weight: bold;'>$curso: $modulo</p>
            <p>Emitido em: " . date('d/m/Y') . "</p>
            <div class='assinatura'>
                ____________________________
                <span>Assinatura do Responsável</span>
            </div>
            <div class='selo'>
                Este certificado foi gerado automaticamente e é válido somente com os dados acima.
            </div>
        </div>
        <button id='imprimir' onclick='window.print();'>Imprimir Certificado</button>
    </body>
    </html>";
    exit(); // Encerra o script após renderizar o certificado
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Certificado</title>
</head>

<body>
    <form method="POST" action="">
        <label for="nome">Nome do Estudante:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        <button type="submit">Gerar Certificado</button>
    </form>
</body>

</html>