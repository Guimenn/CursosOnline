<?php
session_start();
include 'items.php'; // Inclui o menu

// Definir o arquivo de banco de dados
$db_file = 'usuarios.txt';

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Verificar se o email e a senha estão vazios
    if (empty($email) || empty($senha)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Verificar se o email e a senha estão corretos
        $db = file($db_file, FILE_IGNORE_NEW_LINES);
        $login_ok = false; // Inicializar a variável login_ok como false
        foreach ($db as $linha) {
            list($nome, $email_db, $senha_db) = explode("|", $linha);
            if ($email_db == $email && $senha_db == $senha) {
                $login_ok = true; // Se as credenciais estiverem corretas, altere para true
                $_SESSION['usuario'] = ucfirst(strtolower($nome)); // Armazena o nome do usuário na sessão
                break;
            }
        }

        if ($login_ok) {
            $_SESSION['logged_in'] = true;
            header("Location: index.php"); // Redireciona para a página inicial
            exit;
        } else {
            echo "Email ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/blog.css">
    <link rel="stylesheet" href="estilos/items.css">
</head>
<body>
    <?php
    Menu($menuItems);
    ?>
    <section id="home" class="banner">
        <div class="banner-content">
            <h1>Estudo<span>Mind Blog</span></h1>
            <p>Acesse nossos cursos a qualquer hora e de qualquer lugar.</p>
        </div>
        <div class="scroll-indicator" aria-label="Scroll down">
            <span>Scroll</span>
            <i class="fas fa-arrow-down"></i>
        </div>
    </section>
    <section id="blog">
        <div class="blog">
            <div class="blog-content">
                <h2>Artigos</h2>
                <div class="blog-list">
                    <div class="blog-item">
                        <div class="blog-item-img">
                            <img src="img/blog/1.jpg" alt="">
                        </div>
                        <div class="blog-item-content">
                            <h3>Artigo 1</h3>
                            <p>Artigo 1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="contact">
                <h3>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h3>
                <textarea id="message" rows="5" placeholder="Sua Mensagem" required aria-required="true" aria-label="Mensagem"></textarea>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        <?php else: ?>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required><br><br>
                <input type="submit" value="Entrar">
            </form>
        <?php endif; ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
