<?php
session_start();

$erro = '';
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['acao']) && $_POST['acao'] === 'novaSenha') {
    $novaSenha = trim($_POST['novaSenha']);
    $confirmarSenha = trim($_POST['confirmarSenha']);
    $email = $_SESSION['usuario_email'] ?? ''; // Verificar se o email está na sessão

    // Validações iniciais
    if (empty($email)) {
        $erro = "Sessão inválida. Por favor, reinicie o processo.";
    } elseif (empty($novaSenha) || empty($confirmarSenha)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif ($novaSenha !== $confirmarSenha) {
        $erro = "As senhas não coincidem.";
    } else {
        $caminhoArquivo = "usuarios.txt";

        // Verifica se o arquivo de usuários existe e é legível
        if (!file_exists($caminhoArquivo) || !is_readable($caminhoArquivo)) {
            $erro = "Erro ao acessar o arquivo de usuários.";
        } else {
            // Lê o conteúdo do arquivo
            $linhas = file($caminhoArquivo, FILE_IGNORE_NEW_LINES);
            $senhaAtualizada = false;
            $novoConteudo = [];

            foreach ($linhas as $linha) {
                $dados = explode("|", $linha); 
                if ($dados[0] === $email) { 
                    if ($dados[2] === $novaSenha) {
                        $erro = "A nova senha não pode ser igual à senha antiga.";
                        break; // Interrompe o loop para evitar alterações
                    }
                    unset($dados[2]); // Remove a senha antiga (assumindo que está na posição 2)
                    $dados[] = $novaSenha; 
                    $senhaAtualizada = true; 
                }
                $novoConteudo[] = implode("|", $dados); // Reconstrói a linha
            }

            // Impede a execução adicional se houver erro
            if (!empty($erro)) {
                $senhaAtualizada = false; // Garante que o arquivo não será modificado
            } elseif ($senhaAtualizada) { // Verifica se a senha foi atualizada
                if (file_put_contents($caminhoArquivo, implode(PHP_EOL, $novoConteudo) . PHP_EOL)) {
                    $mensagem = "Senha alterada com sucesso!";
                    unset($_SESSION['usuario_email']); 
                    header("Location: index.php"); 
                    exit;
                } else {
                    $erro = 'Erro ao salvar as alterações no arquivo.';
                }
            } else {
                $erro = "Usuário não encontrado para atualizar a senha.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - EstudoMind</title>
    <link rel="stylesheet" href="estilos/esqueceuSenha.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <div class="form-container">
        <form id="formCadastro" action="" method="post">
            <input type="hidden" name="acao" value="novaSenha">
            <h2>Redefinir Senha</h2>
            <div class="inp-senha">
                <label for="novasenha">Nova Senha</label>
                <input type="password" name="novaSenha" id="novasenha" placeholder="Digite sua nova senha" required>
                <label for="confirmarSenha">Confirme Nova Senha</label>
                <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirme sua nova senha" required>
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
</body>

</html>