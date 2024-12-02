<?php
// Inicia a sessão para rastrear o usuário
session_start();

// Inclui os arquivos necessários
include 'items/items.php';
include 'items/courses.php';

// Verifica se o usuário está logado, através da verificação do email na sessão
if (!isset($_SESSION['usuario_email'])) {
    echo '
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação da página como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define a responsividade da página -->
    <title>Meus Cursos Acompanhados</title> <!-- Título da página -->

    <!-- Links para fontes e estilos -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Ícones FontAwesome -->
    <link rel="stylesheet" href="estilos/acompanhamentos.css"> <!-- Estilo para a página de acompanhamento -->
    <link rel="stylesheet" href="estilos/items.css"> <!-- Estilo para itens (barra de navegação e outros componentes) -->
    <link rel="stylesheet" href="estilos/media-query/mq-items.css"> <!-- Estilos responsivos -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"> <!-- Ícone da página -->

    <style>
    h1 {
        text-align: center; /* Alinha o título ao centro */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh; /* Define a altura do título como 80% da altura da tela */
        font-weight: normal;
    }
    </style>
</head>

<body>
';

    Menu($menuItems);


    // Exibe uma mensagem solicitando que o usuário faça login
    echo '<h1>Por favor, faça o login para ver seus cursos acompanhados.</h1>
     <script src="js/menu.js"></script> <!-- Inclui o script do menu -->
</body>
</html>
';
    // Redireciona o usuário para a página de login após 3 segundos
    header('Refresh: 3; URL=login-teste.php');
    exit;
}

// Recupera o email do usuário logado (armazenado na sessão)
$usuario = $_SESSION['usuario_email'];

// Define o caminho do arquivo de acompanhamento do usuário
$arquivo = "acompanhamento/{$usuario}.txt";

// Define o diretório onde os certificados do usuário serão armazenados
$arquivocertificado = "certificados/{$usuario}/";

// Verifica se o arquivo de acompanhamento existe. Se não, cria um novo arquivo
if (!file_exists($arquivo)) {
    if (isset($_SESSION['usuario'])) {
        $fp = fopen($arquivo, 'w'); // Cria o arquivo de acompanhamento
        fclose($fp);
    } else {
        header("Location: login-teste.php");
        exit;
    }
}

// Inicializa a variável para armazenar os certificados
$certificados = [];

// Verifica se o diretório de certificados do usuário existe
if (is_dir($arquivocertificado)) {
    // Lê todos os arquivos do diretório de certificados (exceto os diretórios "." e "..")
    $certificados = array_diff(scandir($arquivocertificado), array('..', '.'));
}

// Lê os acompanhamentos do arquivo do usuário
$acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);

// Define o caminho do diretório de certificados do usuário
$pastaUsuario = "certificados/{$usuario}";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acompanhamento e Certificados - EstudoMind</title>

    <!-- Importação de fontes do Google e ícones FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Importação de estilos principais e de media queries -->
    <link rel="stylesheet" href="estilos/acompanhamentos.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-acompanhamento.css">
    <!-- Favicon do site -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>

<body>
    <!-- Chama a função Menu() para exibir o menu de navegação -->
    <?php Menu($menuItems); ?>

    <main>
        <!-- Seção para exibir os cursos em andamento -->
        <div class="courses">
            <h2>Cursos em Andamento</h2>
            <div class="courses-list">
                <?php
                // Verifica se há cursos em andamento
                if (count($acompanhamentos) > 0):
                    echo '<div class="flex-course-card">';
                    // Para cada acompanhamento, exibe um card de curso
                    foreach ($acompanhamentos as $acompanhamento):
                        $imagem = $descricao = $cursoName = $moduloName = null;

                        // Procura o curso e módulo correspondentes ao acompanhamento
                        foreach ($cursos as $linguagem) {
                            $curso = array_keys($linguagem)[0];
                            if (strpos($acompanhamento, $curso) !== false) {
                                $cursoName = $curso;
                                foreach ($linguagem[$curso] as $moduloKey => $modulo) {
                                    if (strpos($acompanhamento, $moduloKey) !== false) {
                                        $moduloName = $moduloKey;
                                        $imagem = $modulo['image'];
                                        $descricao = $modulo['descricao'];
                                        break;
                                    }
                                }
                                break;
                            }
                        }

                        // Exibe os detalhes do curso, incluindo a imagem, nome e link para acompanhar
                        echo '
                <div class="course-card">
                    <img src="' . htmlspecialchars($imagem) . '" alt="' . htmlspecialchars($descricao) . '">
                    <h3 class="course-card-title">' . htmlspecialchars(trim(preg_replace('/(Curso:|Módulo:|,\s*)/', '', preg_replace('/^[^,]+,/', '', $acompanhamento)), ', ')) . '</h3>
                    <a href="paginadecursos.php?curso=' . urlencode($cursoName) . '&modulo=' . urlencode($moduloName) . '" class="btn-courses">Ver Acompanhamento</a>
                </div>';
                    endforeach;
                    echo '</div>';
                else:
                    // Caso o usuário não tenha cursos em andamento
                    echo '<p style="font-size: 2rem; display: flex; justify-content: center; margin-top: 20%;">Você ainda não está inscrito em nenhum curso.</p>';
                endif;
                ?>
            </div>
        </div>

        <!-- Seção para exibir os certificados emitidos -->
        <div class="certificates-list">
            <h2>Certificados Emitidos</h2>
            <?php
            $pastaUsuario = "certificados/{$usuario}";

            // Verifica se a pasta de certificados do usuário existe
            if (is_dir($pastaUsuario)) {
                $cursos = array_diff(scandir($pastaUsuario), ['..', '.']);
                if (count($cursos) > 0) {
                    echo '<div class="flex-course-card">';
                    // Para cada curso, verifica os módulos e exibe os certificados
                    foreach ($cursos as $curso) {
                        $pastaCurso = "{$pastaUsuario}/{$curso}";
                        if (is_dir($pastaCurso)) {
                            $modulos = array_diff(scandir($pastaCurso), ['..', '.']); // Lê os módulos dentro do curso
                            foreach ($modulos as $modulo) {
                                $nomeModulo = pathinfo($modulo, PATHINFO_FILENAME); // Remove a extensão .txt do nome do módulo
                                echo '
                        <div class="course-card">
                            <img src="img/favicon.png" alt="Certificado de Conclusão">
                            <h3 class="course-card-title">' . htmlspecialchars($curso) . '</h3>
                            <h4>' . htmlspecialchars($nomeModulo) . '</h4>
                            <!-- Link para visualizar o certificado -->
                            <a href="certificados/' . rawurlencode(trim($usuario)) . '/' . rawurlencode(trim($curso)) . '/' . rawurlencode(trim($modulo)) . '" class="btn-courses" target="_blank">Ver Certificado</a>
                        </div>';
                            }
                        }
                    }
                    echo '</div>';
                } else {
                    // Caso o usuário não tenha certificados emitidos
                    echo '<p style="font-size: 1.5rem; display: flex; justify-content: center; margin-top: 20px;">Você ainda não possui certificados emitidos.</p>';
                }
            } else {
                // Caso a pasta de certificados não exista
                echo '<p style="font-size: 1.5rem; display: flex; justify-content: center; margin-top: 20px;">A pasta de certificados não foi encontrada.</p>';
            }
            ?>
        </div>

    </main>

    <!-- Chama a função Footer() para exibir o rodapé -->
    <?php Footer(); ?>
    <script src="js/menu.js"></script>
</body>

</html>