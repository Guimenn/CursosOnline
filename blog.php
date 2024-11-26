<?php
session_start();
include 'items/items.php';
if (!isset($_SESSION['usuario_email'])) {
    echo '
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Cursos Acompanhados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/acompanhamentos.css">
    <link rel="stylesheet" href="estilos/items.css">
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <style>
    h1 {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        font-weight: normal;
    }
    </style>

</head>

<body>
';

    if (function_exists('Menu') && !empty($menuItems)) {
        Menu($menuItems);
    } else {
        echo '<h1>Erro ao carregar o menu.</h1>';
    }

    echo '<h1>Por favor, faça o login para ver seus cursos acompanhados.</h1>
    
</body>
</html>
';
    header('Refresh: 3; URL=login-teste.php');

    exit;
}

// Recupera o nome do usuário
$usuario = $_SESSION['usuario_email'];
$arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";

if (!file_exists($arquivo)) {
    if (isset($_SESSION['usuario'])) {
        // Se o arquivo não existe e o usuário está logado, crie o arquivo
        $fp = fopen($arquivo, 'w');
        fclose($fp);
    } else {
        // Se o arquivo não existe e o usuário não está logado, redirecione para o login
        header("Location: login-teste.php");
        exit;
    }
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - EstudoMind</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./estilos/blog.css" media="all">
    <link rel="stylesheet" href="estilos/media-query/mq-blog.css">
    <link rel="stylesheet" href="estilos/items.css">
</head>

<body>
    <?php
    Menu($menuItems);
    ?>
    <main>
        <section class="posts"><img src="SlijW.gif" alt="">
            <?php
            // Verifica se o formulário foi enviado
            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Pega os dados do formulário
                $titulo = $_POST['titulo'];
                $conteudo = $_POST['conteudo'];
                $localizacao = $_POST['localizacao'];

                // Formata os dados para salvar no arquivo
                $post = $titulo . "|" . $conteudo . "|" . $localizacao . "|" . $_SESSION['usuario'] . PHP_EOL;

                // Adiciona o post ao arquivo de texto
                file_put_contents('posts.txt', $post, FILE_APPEND);

                // Redireciona o usuário para a mesma página
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            // Lê o conteúdo do arquivo de texto
            $posts = file_exists('posts.txt') ? file('posts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

            // Cria uma variável para armazenar os posts formatados
            $formattedPosts = [];
            foreach ($posts as $post) {
                $postData = explode('|', $post);
                $formattedPosts[] = [
                    'titulo' => $postData[0],
                    'conteudo' => $postData[1],
                    'localizacao' => $postData[2],
                    'usuario' => $postData[3]
                ];
            }
            ?>

            <div class="blog">
                <h2>Posts</h2>
                <?php if (count($formattedPosts) > 0) : ?>
                    <?php foreach ($formattedPosts as $post) : ?>
                        <div class="post">
                         
                            <h1><?php echo htmlspecialchars($post['titulo']); ?></h1>
                            <p class="conteudo"><?php echo nl2br(htmlspecialchars($post['conteudo'])); ?></p>
                            <p class="localizacao"><i class="fas fa-map-marker"></i> <?php echo htmlspecialchars($post['localizacao']); ?></p>
                            <h4>Postado por: <?php echo htmlspecialchars($post['usuario']); ?></h4>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Nenhum post encontrado.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="add-post">
            <h2>Adicionar Novo Post</h2>
            <div class="form-container sign-in-container">
                <form action="" method="post" class="container">
                    <div class="user-box">
                        <label for="titulo">Titulo:</label><br>
                        <input type="text" name="titulo" required="">
                    </div>
                    <div class="user-box">
                        <label for="conteudo">Conteúdo:</label>
                        <textarea name="conteudo" id="conteudo" placeholder="Escreva seu post aqui" class="caixa-area" required></textarea>
                    </div>
                    <div class="user-box">
                        <label for="localizacao">Localização:</label>
                        <select name="localizacao" id="localizacao" class="caixa-text" required>
                            <option value="">Selecione uma localização</option>
                        </select>
                    </div>
                    <div class="user-box">
                        <input type="submit" value="Enviar" class="btn">
                    </div>
                </form>
            </div>
        </section>
    </main>


    <?php Footer(); ?>
    <script>
        // Lista de estados e cidades
        const localizacoes = {
            "SP": ["São Paulo", "Campinas", "Santos", "São Bernardo do Campo", "São Caetano do Sul"],
            "RJ": ["Rio de Janeiro", "Niterói", "Petrópolis"],
            "MG": ["Belo Horizonte", "Uberlândia", "Ouro Preto"],
            "RS": ["Porto Alegre", "Caxias do Sul", "Gramado"]
        };

        // Referência ao elemento do DOM
        const localizacaoSelect = document.getElementById('localizacao');

        // Preencher o select com estados e cidades
        Object.entries(localizacoes).forEach(([estado, cidades]) => {
            cidades.forEach(cidade => {
                const option = document.createElement('option');
                option.value = `${estado}-${cidade}`;
                option.textContent = `${estado} - ${cidade}`;
                localizacaoSelect.appendChild(option);
            });
        });
    </script>

</body>

</html>