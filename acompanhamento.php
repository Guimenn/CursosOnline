<?php
session_start();
include 'items.php';
include 'courses.php';

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
    justify-content: center">Por favor, faça o login para ver seus acompanhamentos.</p>
    
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
    }
}
$acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);
?>
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
    <?php
    Menu($menuItems);
    ?>


    <div class="courses">
        <div class="courses-list">
            <?php if (count($acompanhamentos) > 0): ?>
                <div class="flex-course-card">
                    <?php foreach ($acompanhamentos as $acompanhamento): ?>
                        <div class="course-card">
                            <!-- Imagem do acompanhamento -->
                            <?php

                            foreach ($cursos as $linguagem) {
                                $curso = array_keys($linguagem)[0];
                                if (strpos($acompanhamento, $curso) !== false) {
                                    $imagem = $linguagem[$curso]['modulo1']['image'];
                                    break;
                                }
                            }
                            foreach ($cursos as $linguagem) {
                                $curso = array_keys($linguagem)[0];
                                if (strpos($acompanhamento, $curso) !== false) {
                                    $descricao = $linguagem[$curso]['modulo2']['description'];
                                    break;
                                }
                            }

                            ?>
                            <img src="<?php echo "img-cursos/{$imagem}"; ?>" alt="<?php echo $descricao; ?>">
                            <h3 class="course-card-title"><?php echo htmlspecialchars($acompanhamento); ?></h3>
                            <a href="acompanhamento.php?curso=<?php echo urlencode($acompanhamento); ?>" class="btn-courses">Ver Acompanhamento</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                    <p style="font-size: 2rem; display: flex; justify-content: center; margin-top: 20%;">Você ainda não está inscrito em nenhum curso.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php Footer(); ?>
</body>

</html>