<?php
// Inicia a sessão caso ainda não esteja ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Importa os arquivos necessários com funções e dados, como menu e cursos
include 'items/items.php';
include 'items/courses.php';

// Verifica se o formulário de login foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura as credenciais enviadas no formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Se o login for bem-sucedido, armazena o nome do usuário na sessão
    $_SESSION['usuario'] = $nome;

    // Redireciona o usuário para a página inicial após o login
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags básicas para configuração do documento HTML -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - EstudoMind</title>
    <!-- Importação de fontes do Google-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <!-- Importação de estilos principais e de media queries -->
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="stylesheet" href="estilos/cursos.css">
    <link rel="stylesheet" href="estilos/media-query/mq-cursos.css">
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
    <!-- Biblioteca de animação ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Favicon do site -->
    <link rel="shortcut icon" href="img/favicon.png">
</head>

<body>
    <?php
    // Exibe o menu dinâmico definido na função Menu
    Menu($menuItems);
    ?>

    <!-- Seção inicial com informações gerais -->
    <section id="home" class="banner">
        <div class="banner-content">
            <h1>Seus <span>Cursos Online</span> em um Só lugar</h1>
            <p>Acesse nossos cursos a qualquer hora e de qualquer lugar.</p>
        </div>
    </section>

    <!-- Lista de cursos -->
    <section>
        <div class="courses">
            <div class="course-list">
                <?php
                $i = 1; // Contador para IDs únicos dos cursos
                foreach ($cursos as $linguagem) {
                    $cursoNome = array_keys($linguagem)[0]; 
                    echo '<h2 class="title-course" id="curso-' . $i . '">' . $cursoNome . '</h2>';
                    echo '<div class="row">';
                    foreach ($linguagem[$cursoNome] as $modulo => $detalhes) {
                        $url = "paginadecursos.php?curso=" . urlencode($cursoNome) . "&modulo=" . urlencode($modulo); // Cria um link dinâmico para o módulo
                        echo '
                        <div class="card ' . $detalhes['cor'] . '">
                            <img src="' . $detalhes['image'] . '" alt="' . $detalhes['descricao'] . '" class="image" />
                            <h3>' . $modulo . '</h3>
                            <p>' . $detalhes['descricao'] . '</p>
                            <a href="' . $url . '" class="button ' . $detalhes['cor'] . '">Ver Curso</a>
                        </div>';
                    }

                    echo '</div>'; 
                    $i++; 
                }
                ?>
            </div>
        </div>
    </section>

    <?php
    // Exibe o rodapé utilizando a função Footer
    Footer();
    ?>

    <!-- Scripts externos -->
    <script src="js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>