<?php
// Inicia a sessão
session_start();

// Inclui os arquivos necessários
include 'items/items.php'; // Inclui a barra de navegação e rodapé
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


// Define o arquivo de acompanhamento
$arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";
$arquivocertificado = "certificados/{$usuario}/";



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

// Inicializa a variável $certificados
$certificados = [];



// Verifica se o diretório de certificados do usuário existe
if (is_dir($arquivocertificado)) {
    // Lê todos os arquivos do diretório de certificados
    $certificados = array_diff(scandir($arquivocertificado), array('..', '.')); // Remove as entradas "." e ".."
}




// Verifica se o diretório de certificados existe

// Lê os acompanhamentos
$acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);

$pastaUsuario = "certificados/{$usuario}";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento e Certificados - EstudoMind</title>

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
                <?php
                if (count($acompanhamentos) > 0):
                    echo '<div class="flex-course-card">';
                    foreach ($acompanhamentos as $acompanhamento):
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

                        // Exibe os detalhes do curso
                        echo '
                <div class="course-card">
                    <img src="' . htmlspecialchars($imagem) . '" alt="' . htmlspecialchars($descricao) . '">
                    <h3 class="course-card-title">' . htmlspecialchars($acompanhamento) . '</h3>
                    <a href="paginadecursos.php?curso=' . urlencode($cursoName) . '&modulo=' . urlencode($moduloName) . '" class="btn-courses">Ver Acompanhamento</a>
                </div>';
                    endforeach;
                    echo '</div>';
                else:
                    echo '<p style="font-size: 2rem; display: flex; justify-content: center; margin-top: 20%;">Você ainda não está inscrito em nenhum curso.</p>';
                endif;
                ?>
            </div>
        </div>


        <!-- Seção de certificados -->
        <div class="certificates-list">
            <h2 style="text-align: center; margin-top: 40px;">Certificados Emitidos</h2>
            <?php
            $pastaUsuario = "certificados/{$usuario}"; // Caminho base do usuário
            if (is_dir($pastaUsuario)) {
                $cursos = array_diff(scandir($pastaUsuario), ['..', '.']); // Lê os cursos
                if (count($cursos) > 0) {
                    echo '<div class="flex-course-card">';
                    foreach ($cursos as $curso) {
                        $pastaCurso = "{$pastaUsuario}/{$curso}";
                        if (is_dir($pastaCurso)) {
                            $modulos = array_diff(scandir($pastaCurso), ['..', '.']); // Lê os módulos
                            foreach ($modulos as $modulo) {
                                $nomeModulo = pathinfo($modulo, PATHINFO_FILENAME); // Remove a extensão .txt
                                echo '
                        <div class="course-card">
                            <img src="img/certificate-placeholder.png" alt="Certificado de Conclusão">
                            <h3 class="course-card-title">' . htmlspecialchars($curso) . '</h3>
                            <h4>' . htmlspecialchars($nomeModulo) . '</h4>
                            <a href="certificados/' . urlencode($usuario) . '/' . urlencode($curso) . '/' . urlencode($modulo) . '" class="btn-courses" target="_blank">Ver Certificado</a>
                        </div>';
                            }
                        }
                    }
                    echo '</div>';
                } else {
                    echo '<p style="font-size: 1.5rem; display: flex; justify-content: center; margin-top: 20px;">Você ainda não possui certificados emitidos.</p>';
                }
            } else {
                echo '<p style="font-size: 1.5rem; display: flex; justify-content: center; margin-top: 20px;">A pasta de certificados não foi encontrada.</p>';
            }
            ?>
        </div>

        </div>

        </div>
    </main>

    <!-- Chama a função para renderizar o rodapé -->
    <?php Footer(); ?>
</body>

</html>