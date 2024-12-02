<?php
// Inicia a sessão para armazenar informações entre páginas
session_start();

// Inclui o arquivo de itens necessários
include 'items/items.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_email'])) {
    // Exibe a página de login se o usuário não estiver logado
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
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
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

    // Renderiza o menu se a função e os itens do menu existirem
    if (function_exists('Menu') && !empty($menuItems)) {
        Menu($menuItems);
    } else {
        echo '<h1>Erro ao carregar o menu.</h1>';
    }

    // Exibe mensagem solicitando login
    echo '<h1>Por favor, faça o login para ter acesso ao Fórum.</h1>
    <script src="js/menu.js"></script>
</body>
</html>
';
    // Redireciona para a página de login após 3 segundos
    header('Refresh: 3; URL=login-teste.php');
    exit;
}

// Recupera o email do usuário logado
$usuario = $_SESSION['usuario_email'];

// Define o caminho do arquivo de acompanhamento
$arquivo = "acompanhamento/{$usuario}.txt";

// Verifica se o arquivo de acompanhamento existe
if (!file_exists($arquivo)) {
    if (isset($_SESSION['usuario'])) {
        // Cria o arquivo se o usuário estiver logado
        $fp = fopen($arquivo, 'w');
        fclose($fp);
    } else {
        header("Location: login-teste.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Configuração de metadados básicos -->
    <meta charset="UTF-8"> <!-- Define a codificação como UTF-8 para suportar caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define o site como responsivo -->
    <title>Blog - EstudoMind</title> <!-- Título da página -->
    <!-- Importação de fontes do Google e ícones FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Importação de estilos principais e de media queries -->
    <link rel="stylesheet" href="estilos/forum.css" media="all">
    <link rel="stylesheet" href="estilos/media-query/mq-blog.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
        <!-- Favicon do site -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <?php
    // Função PHP para incluir o menu
    Menu($menuItems);
    ?>
    <main>
        <!-- Seção de exibição dos posts -->
        <section class="posts">
            <img src="SlijW.gif" alt=""> <!-- Banner ou animação ilustrativa -->
            <?php
            // Verifica se o formulário foi enviado
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Captura os dados enviados pelo formulário
                $titulo = $_POST['titulo'];
                $conteudo = $_POST['conteudo'];
                $localizacao = $_POST['localizacao'];

                // Formata os dados do post para salvar no arquivo
                $post = $titulo . "|" . $conteudo . "|" . $localizacao . "|" . $_SESSION['usuario'] . PHP_EOL;

                // Salva o post no arquivo de texto
                file_put_contents('posts/posts.txt', $post, FILE_APPEND);

                // Redireciona para evitar reenvio do formulário
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            // Verifica se o arquivo de posts existe e lê os dados
            $posts = file_exists('posts/posts.txt') ? file('posts/posts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

            // Organiza os dados dos posts em um array formatado
            $formattedPosts = [];
            foreach ($posts as $post) {
                $postData = explode('|', $post); // Divide o post em partes usando o caractere "|"
                $formattedPosts[] = [
                    'titulo' => $postData[0], // Título do post
                    'conteudo' => $postData[1], // Conteúdo do post
                    'localizacao' => $postData[2], // Localização
                    'usuario' => $postData[3] // Usuário que postou
                ];
            }
            ?>

            <div class="blog">
                <h2>Posts</h2>
                <!-- Exibe os posts se existirem -->
                <?php if (count($formattedPosts) > 0) : ?>
                    <?php foreach ($formattedPosts as $post) : ?>
                        <div class="post">
                            <!-- Exibe os detalhes do post -->
                            <h1><?php echo htmlspecialchars($post['titulo']); ?></h1> <!-- Exibe o título -->
                            <p class="conteudo"><?php echo nl2br(htmlspecialchars($post['conteudo'])); ?></p> <!-- Exibe o conteúdo com quebras de linha -->
                            <p class="localizacao">
                                <i class="fas fa-map-marker"></i>
                                <?php echo htmlspecialchars($post['localizacao']); ?>
                            </p> <!-- Exibe a localização com ícone -->
                            <h4>Postado por: <?php echo htmlspecialchars($post['usuario']); ?></h4> <!-- Exibe o nome do usuário -->
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Caso não haja posts -->
                    <p>Nenhum post encontrado.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Seção para adicionar um novo post -->
        <section class="add-post">
            <h2>Adicionar Novo Post</h2>
            <div class="form-container sign-in-container">
                <!-- Formulário para criar posts -->
                <form action="" method="post" class="container">
                    <div class="user-box">
                        <label for="titulo">Titulo:</label><br> <!-- Campo para título -->
                        <input type="text" name="titulo" id="titulo" required="">
                    </div>
                    <div class="user-box">
                        <label for="conteudo">Conteúdo:</label> <!-- Campo para conteúdo -->
                        <textarea name="conteudo" id="conteudo" placeholder="Escreva seu post aqui" class="caixa-area" required></textarea>
                    </div>
                    <div class="user-box">
                        <label for="localizacao">Localização:</label> <!-- Campo para localização -->
                        <select name="localizacao" id="localizacao" class="caixa-text" required>
                            <option value="">Selecione uma localização</option>
                        </select>
                    </div>
                    <div class="user-box">
                        <input type="submit" value="Enviar" class="btn"> <!-- Botão para enviar o formulário -->
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php
    // Função PHP para incluir o rodapé
    Footer();
    ?>
    <script src="js/menu.js"></script> <!-- Script para controle do menu -->

    <script>
        // Lista de estados e cidades para preenchimento dinâmico do campo "Localização"
        const localizacoes = {
            "SP": ["São Paulo", "Campinas", "Santos", "São Bernardo do Campo", "São Caetano do Sul"],
            "RJ": ["Rio de Janeiro", "Niterói", "Petrópolis"],
            "MG": ["Belo Horizonte", "Uberlândia", "Ouro Preto"],
            "RS": ["Porto Alegre", "Caxias do Sul", "Gramado"]
        };

        // Seleciona o elemento <select> para preencher as opções
        const localizacaoSelect = document.getElementById('localizacao');

        // Preenche o <select> com estados e cidades
        Object.entries(localizacoes).forEach(([estado, cidades]) => {
            cidades.forEach(cidade => {
                const option = document.createElement('option');
                option.value = `${estado}-${cidade}`; // Valor no formato "Estado-Cidade"
                option.textContent = `${estado} - ${cidade}`; // Texto exibido no <select>
                localizacaoSelect.appendChild(option); // Adiciona a opção ao <select>
            });
        });
    </script>

</body>

</html>