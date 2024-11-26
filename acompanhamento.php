<?php
// Inicia a sessão
session_start();

// Inclui os arquivos necessários
include 'items/items.php'; // Inclui a barra de navegaçã e rodapé
include 'items/courses.php'; // Inclui a lista de cursos

// Verifica se o usuário está logado
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

    // Verifica se o menu foi carregado corretamente
    if (function_exists('Menu') && !empty($menuItems)) {
        Menu($menuItems);
    } else {
        echo '<h1>Erro ao carregar o menu.</h1>';
    }

    // Exibe mensagem solicitando login
    echo '<h1>Por favor, faça o login para ver seus cursos acompanhados.</h1>
    
</body>
</html>
';
    // Redireciona para a página de login após 3 segundos
    header('Refresh: 3; URL=login-teste.php');
    exit;
}

// Recupera o nome do usuário
$usuario = $_SESSION['usuario_email'];

// Define os arquivos de acompanhamento e certificados
$arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";
$arquivocertificado = "certificados/certificados_{$usuario}.txt";

// Verifica se o arquivo de acompanhamento existe
if (!file_exists($arquivo)) {
    if (isset($_SESSION['usuario'])) {
        $fp = fopen($arquivo, 'w');
        fclose($fp);
    } else {
        header("Location: login-teste.php");
        exit;
    }
}

// Verifica se o arquivo de certificados existe
if (!file_exists($arquivocertificado)) {
    if (isset($_SESSION['usuario'])) {
        $fp = fopen($arquivocertificado, 'w');
        fclose($fp);
    } else {
        header("Location: login-teste.php");
        exit;
    }
}

// Lê os acompanhamentos e certificados
$acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);
$certificados = file($arquivocertificado, FILE_IGNORE_NEW_LINES);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento - EstudoMind</title>

    <!-- Fontes e estilos externos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/acompanhamentos.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <!-- Chama a função para renderizar o menu -->
    <?php Menu($menuItems); ?>

    <main>
        <div class="courses">
            <div class="courses-list">
                <!-- Verifica se existem cursos acompanhados -->
                <?php if (count($acompanhamentos) > 0): ?>
                    <div class="flex-course-card">
                        <!-- Itera sobre os cursos acompanhados -->
                        <?php foreach ($acompanhamentos as $acompanhamento): ?>
                            <div class="course-card">
                                <?php
                                // Inicializa as variáveis para o curso e módulo
                                $imagem = $descricao = $cursoName = $moduloName = null;

                                // Procura o curso e módulo correspondentes ao acompanhamento
                                foreach ($cursos as $linguagem) {
                                    $curso = array_keys($linguagem)[0];
                                    if (strpos($acompanhamento, $curso) !== false) {
                                        $cursoName = $curso; // Nome do curso
                                        foreach ($linguagem[$curso] as $moduloKey => $modulo) {
                                            if (strpos($acompanhamento, $moduloKey) !== false) {
                                                $moduloName = $moduloKey; // Nome do módulo
                                                $imagem = $modulo['image']; // Caminho da imagem
                                                $descricao = $modulo['descricao']; // Descrição do módulo
                                                break;
                                            }
                                        }
                                        break;
                                    }
                                }
                                ?>

                                <!-- Exibe os detalhes do curso -->
                                <img src="<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($descricao); ?>">
                                <h3 class="course-card-title"><?php echo htmlspecialchars($acompanhamento); ?></h3>
                                <!-- Link para a página do curso -->
                                <a href="paginadecursos.php?curso=<?php echo urlencode($cursoName); ?>&modulo=<?php echo urlencode($moduloName); ?>" class="btn-courses">Ver Acompanhamento</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Mensagem exibida caso não haja cursos inscritos -->
                    <p style="font-size: 2rem; display: flex; justify-content: center; margin-top: 20%;">Você ainda não está inscrito em nenhum curso.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <!-- Chama a função para renderizar o rodapé -->
    <?php Footer(); ?>
</body>

</html>