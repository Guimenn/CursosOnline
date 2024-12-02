<?php
session_start();

$erro = '';
$mensagem = '';
$arquivo = file("usuarios.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Verifica se o arquivo foi carregado corretamente
if ($arquivo === false) {
    die("Erro: Não foi possível abrir o arquivo usuarios.txt.");
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao']) && $_POST['acao'] === 'esqueceuSenha') {
    $email = trim($_POST['email']);
    $encontrouEmail = false;

    $caminhoArquivo = "usuarios.txt";

    // Certifica-se de que o arquivo existe e pode ser lido
    if (!file_exists($caminhoArquivo) || !is_readable($caminhoArquivo)) {
        die("Erro: Não foi possível abrir o arquivo usuarios.txt.");
    }

    // Lê o arquivo linha por linha
    $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Itera sobre cada linha para encontrar o email
    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);
        if (isset($dados[1]) && $dados[1] === $email) {
            $encontrouEmail = true;
            $_SESSION['usuario_email'] = $dados[0]; 
            break;
        }
    }

    // Define as mensagens com base no resultado
    if ($encontrouEmail) {
        $mensagem = "E-mail encontrado! Redirecionando para redefinição de senha...";
        header("Location: novasenha.php"); 
        exit;
    } else {
        $erro = "E-mail não encontrado. Por favor, verifique e tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a Senha - EstudoMind</title>
    <link rel="stylesheet" href="estilos/esqueceuSenha.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="form-container">
        <form id="formCadastro" action="" method="post">
            <input type="hidden" name="acao" value="esqueceuSenha">
            <h2>Esqueceu sua senha?</h2>
            <div class="inp-email">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Ex: seuemail@gmail.com" required>
            </div>
            <div class="buttons">
                <button type="submit" class="submit-btn"><span></span>Enviar</button>
            </div>

            <!-- Exibe mensagens de erro ou sucesso -->
            <?php if (!empty($erro)): ?>
                <div class="mensagem-erro"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-sucesso"><?php echo htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
