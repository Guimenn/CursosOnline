<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'items/items.php';
include 'items/courses.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    // Verifique as credenciais do usuário (a lógica de verificação deve ser implementada)
    // Se as credenciais estiverem corretas:
    $_SESSION['usuario'] = $nome; // O nome do usuário deve ser atribuído aqui
    header('Location: index.php'); // Redireciona para a página inicial ou onde você deseja
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - EstudoMind</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="stylesheet" href="estilos/cursos.css" media="all">
    <link rel="stylesheet" href="estilos/media-query/mq-cursos.css">
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

</head>

<body>
    <?php
    Menu($menuItems);
    ?>
    <section id="home" class="banner">
        <div class="banner-content">
            <h1>Seus <span>Cursos Online</span> em um Só lugar</h1>
            <p>Acesse nossos cursos a qualquer hora e de qualquer lugar.</p>
            <?php
            $i = 0;
            foreach ($cursos as $linguagem) {
                $curso = array_keys($linguagem)[0];
                echo '<a href="#curso-' . $i . '" class="btn-primary">' . $curso . '</a>';
                $i++;
            }
            ?>
        </div>

    </section>
    <div class="scroll-indicator" aria-label="Scroll down">
        <span>Scroll</span>
        <i class="fas fa-arrow-down"></i>
    </div>

    <section>
        <div class="courses">
            <h2>Nossos Cursos</h2>
            <div class="course-list">
                <?php
                $i = 1;  // Inicializando o contador para cursos

                foreach ($cursos as $linguagem) {
                    // Exibe o nome do curso
                    $cursoNome = array_keys($linguagem)[0];
                    echo '<h2 class="title-course " id="curso-' . $i . '">' . $cursoNome . '</h2>';
                    echo '<div class="row">';
                    // Itera pelos módulos do curso
                    foreach ($linguagem[$cursoNome] as $modulo => $detalhes) {
                        // Gerando a URL com os parâmetros de curso e módulo
                        $url = "paginadecursos.php?curso=" . urlencode($cursoNome) . "&modulo=" . urlencode($modulo);

                        // Exibe o card do módulo
                        echo '
                        <div class="card ' . $detalhes['cor'] . '">
                            <img src="' . $detalhes['image'] . '" alt="' . $detalhes['descricao'] . '" class="image" />
                            <h3>' . $modulo . '</h3>
                            <p>' . $detalhes['descricao'] . '</p>
                            <a href="' . $url . '" class="button ' . $detalhes['cor'] . '">Ver Curso</a>
                        </div>';
                    }

                    echo '</div>';  // Fecha o container de cursos
                    $i++;  // Incrementa o contador para o próximo curso
                }
                ?>

            </div>
        </div>
        </div>
    </section>
    <?php Footer(); ?>
    <script src="js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>