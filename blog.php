<?php
session_start();
include 'items/items.php';
include 'items/courses.php';

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
</head>

<body>
';

    if (function_exists('Menu') && !empty($menuItems)) {
        Menu($menuItems);
    } else {
        echo '<p style="color: red; margin: auto;">Erro ao carregar o menu.</p>';
    }

    echo '<p style="color: red; margin-top: 20%;     display: flex;
    justify-content: center">Por favor, faça o login para ter acesso ao blog.</p>
    
</body>
</html>
';
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
    }}?>
    <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Cursos Acompanhados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/blog.css">
    <link rel="stylesheet" href="estilos/items.css">
</head>

<body>

<main><section class="posts"><img src="SlijW.gif" alt="">
<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados do formulário
    $texto = $_POST['texto'];

    $post =  $texto . "|" . $_SESSION['usuario'] .  PHP_EOL;

    // Adiciona o post ao arquivo de texto
    file_put_contents('posts.txt', $post, FILE_APPEND);

    // Redireciona o usuário para a mesma página
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
// Lê o conteúdo do arquivo de texto
$posts = file('posts.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Cria uma variável para armazenar os posts formatados
$formattedPosts = array();

// Loop para formatar os posts
foreach ($posts as $post) {
    $postData = explode('|', $post);
    $formattedPosts[] = array(
        'usuario' => $postData[1],
        'texto' => $postData[0]
    );
}
?>

<!-- HTML para exibir os posts -->
<div class="blog">
    <?php foreach ($formattedPosts as $post) { ?>
        <div class="post">
            <h4><?php echo $post['usuario']; ?></h4>
            <p><?php echo $post['texto']; ?></p>
        </div>
    <?php } ?>
</div>
</section>
<!-- Formulário para adicionar novo post -->
 <section class="add-post">
    
<form action="" method="post">
<div>
    <input type="text" name="texto" placeholder="  Seu post" class="caixa_text"></input>

    <input type="submit" value="Enviar" class="btn"></input>
    </div>
</form>
    </section>
</main>
    <?php
    Menu($menuItems);
    ?>
    
    <?php Footer(); ?>


</body>
    
    </html>