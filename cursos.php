<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'items.php';
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



<?php include 'courses.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/cursos.css">
    <link rel="stylesheet" href="estilos/items.css">
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
        <div class="scroll-indicator" aria-label="Scroll down">
            <span>Scroll</span>
            <i class="fas fa-arrow-down"></i>
        </div>
    </section>
    <section>
        <div class="courses">
            <h2>Nossos Cursos</h2>
            <div class="course-list">
                <?php
                $i = 0;
                foreach ($cursos as $linguagem) {
                    echo '<h1 class="title-course" id="curso-' . $i . '">' . array_keys($linguagem)[0] . '</h1>';
                    echo '<div class="flex-course-card">';
                    foreach ($linguagem as $modulo) {
                        foreach ($modulo as $key => $value) {
                            echo '
                            <div class="course-card">
                            <img src="img-cursos/' . $value['image'] . '" alt="' . $value['description'] . '">
                            <h3>' . $key . '</h3>
                            <p>' . $value['description'] . '</p>
                            <a href="#" class="btn-courses">Ver Cursos</a>
                            </div>
                        ';
                        }
                    }
                    echo '</div>';
                    $i++;
                }
                ?>
            </div>
        </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>