<?php
session_start();  // Inicia a sessão
// Incluindo o arquivo com os cursos
include 'items/courses.php';  // O arquivo deve definir a variável $cursos
include 'items/footer.php';
include 'items/navbar.php';

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

    $inscrito = usuarioJaInscrito($cursoNome, $moduloNome);


    if (function_exists('Menu') && !empty($menuItems)) {
        Menu($menuItems);
    } else {
        echo '<h1>Erro ao carregar o menu.</h1>';
    }

    echo '<h1>Por favor, faça o login para se inscrever.</h1>
</body>
</html>
';
    header('Refresh: 3; URL=login-teste.php');
    exit;
}

if (!isset($_SESSION['concluido'])) {
    $_SESSION['concluido'] = [];
}

if (!isset($_SESSION['progress'])) {
    $_SESSION['progress'] = 0;
}


$usuario = $_SESSION['usuario_email'];  // Recuperar o email do usuário logado

// Recupera o curso e módulo da URL via GET
$cursoNome = isset($_GET['curso']) ? $_GET['curso'] : null;
$moduloNome = isset($_GET['modulo']) ? $_GET['modulo'] : null;

// Verificação para garantir que os dados de curso e módulo estão sendo passados
if (!$cursoNome || !$moduloNome) {
    echo '<h2>Curso ou Módulo não encontrado!</h2>';
    exit;
}

$arquivo = "concluidos/concluidos_{$usuario}_{$cursoNome}_{$moduloNome}.txt";
// Criar o diretório "acompanhamento" se ele não existir
if (!is_dir('acompanhamento')) {
    mkdir('acompanhamento', 0777, true);
}

// Criar o arquivo se ele não existir
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, '');
}

// Verifica se o curso e módulo existem nos dados
$cursoValido = false;
$moduloValido = false;

foreach ($cursos as $curso) {
    if (array_key_exists($cursoNome, $curso)) {
        $cursoValido = true;
        if (array_key_exists($moduloNome, $curso[$cursoNome])) {
            $moduloValido = true;
        }
    }
}

if (!$cursoValido || !$moduloValido) {
    echo '<h2>Curso ou Módulo não encontrado!</h2>';
    exit;
}

// Função para salvar a inscrição do usuário
function inscreverNoCurso($curso, $modulo)
{
    $usuario = $_SESSION['usuario_email'];  // Pegando o usuário logado
    $arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";  // Arquivo específico por usuário

    file_put_contents($arquivo, "Curso: $curso, Módulo: $modulo\n", FILE_APPEND);
}

// Função para verificar se o usuário já está inscrito no curso e módulo específicos
function usuarioJaInscrito($curso, $modulo)
{
    $usuario = $_SESSION['usuario_email'];  // Pegando o usuário logado
    $arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";  // Arquivo específico por usuário
    if (file_exists($arquivo)) {
        $acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);
        foreach ($acompanhamentos as $acompanhamento) {
            if (strpos($acompanhamento, "Curso: $curso") !== false && strpos($acompanhamento, "Módulo: $modulo") !== false) {
                return true;  // Já está inscrito no curso e módulo
            }
        }
    }
    return false;  // Não está inscrito no curso e módulo
}

// Flag para verificar se já foi inscrito
$inscrito = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inscrever'])) {
    if (!usuarioJaInscrito($cursoNome, $moduloNome)) {
        inscreverNoCurso($cursoNome, $moduloNome);
        $inscrito = true;  // Marca como inscrito
    }
}

$moduloAtual = null;


$progress = isset($_SESSION['progress']) ? $_SESSION['progress'] : 0;
$jaConcluido = isset($_SESSION['concluido']) ? $_SESSION['concluido'] : [];

// Itera sobre o array principal para localizar o curso e módulo
foreach ($cursos as $curso) {
    if (isset($curso[$cursoNome]) && isset($curso[$cursoNome][$moduloNome])) {
        $moduloAtual = $curso[$cursoNome][$moduloNome];
        break;
    }
}

// Verificar se o botão foi clicado
if (isset($_POST['marcar_concluido'])) {
    $video_id = $_POST['video_id'];

    // Verifica se o vídeo já foi concluído (na sessão)
    if (!in_array($video_id, $jaConcluido)) {
        // Adicionar o ID do vídeo à sessão
        $jaConcluido[] = $video_id;

        // Atualizar o progresso
        $progress = isset($jaConcluido) ? $progress : 0;
        $progress += 20;
        if (!file_exists($arquivo)) {
            file_put_contents($arquivo, '');
        }

        // Se o arquivo for gravável, salva o ID do vídeo
        if (is_writable($arquivo)) {
            // Verifica se o ID do vídeo já não está no arquivo para evitar duplicação
            $ids_concluidos = file($arquivo, FILE_IGNORE_NEW_LINES);
            if (!in_array($video_id, $ids_concluidos)) {
                file_put_contents($arquivo, $video_id . "\n", FILE_APPEND);
            }
        } else {
            echo 'Erro: Não é possível gravar no arquivo.';
        }
    }
}

// Ler IDs concluídos do arquivo
if (file_exists($arquivo)) {
    $ids_concluidos = file($arquivo, FILE_IGNORE_NEW_LINES);
} else {
    $ids_concluidos = [];
}

// Atualizar barra de progresso
$progress = 0;
$progress = count($ids_concluidos) * 20;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cursoNome); ?> - <?php echo htmlspecialchars($moduloNome); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/paginadecursos.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <style>
        .progress-bar {
            width: 78%;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 30px;
        }

        .progress-bar-inner {
            height: 100%;
            background-color: #24d162;
            transition: width 0.5s;
        }

        .progress-bar-inner span {
            justify-content: center;
            display: flex;
        }


        .emitir-certificado {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #004BFA;
            /* Cor personalizada */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .emitir-certificado:hover {
            background-color: #0038D7;
            /* Cor personalizada */
        }
    </style>
</head>

<body>
    <?php
    Menu($menuItems);
    ?>
    <main>
        <div class="titles">

            <?php
            echo '<img src="' . htmlspecialchars($moduloAtual['image']) . '" alt="Imagem do Módulo" style="max-width: 100px; height: auto;">';
            echo '<h2>' . htmlspecialchars($moduloAtual['titulo']) . "<br>" .  htmlspecialchars($moduloAtual['descricao']) . '</h2>';


            ?>

            <!-- Botão de Inscrição -->

        </div>

        <!-- Div para informações do curso -->
        <div class="course-info" id="courseInfo">
            <div class="course-status">
                <span class="info-label">Seu Estado</span>
                <?php if ($progress == 100) {
                    echo '    <div style="margin-top: 20px; text-align: center;">
                        <form method="POST" action="emitir_certificado.php">
                            <button type="submit" class="emitir-certificado">
                                Emitir Certificado
                            </button>
                        </form>
                    </div>
                    ';
                } else {
                    echo isset($jaConcluido) ? '<span class="status-label" id="statusLabel">' . $progress . '%</span>' : '';
                }
                ?>



            </div>
            <div class="divider"></div>
            <div class="course-price">
                <span class="info-label">Preço</span>
                <span class="price-label">Grátis</span>
            </div>
            <div class="divider"></div>
            <div class="course-enroll">
                <span class="info-label">Comece Agora</span>
                <form method="POST">
                    <button type="submit" name="inscrever" <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'disabled class="inscrito"' : ''; ?> class="inscrever-button">
                        <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'Inscrito' : 'Inscrever-se'; ?>
                    </button>
                </form>

            </div>
        </div>


        <!-- Seção de vídeos -->
        <?php



        foreach ($ids_concluidos as $id_concluido) {
            if (in_array($id_concluido, $_SESSION['concluido'])) {
                $progress += 20; // Incrementa 25% para cada vídeo concluído
            }
        }
       

        // Verificar se o usuário está inscrito e exibir a barra de progresso apenas se estiver
        if (usuarioJaInscrito($cursoNome, $moduloNome)) {
            // Exibir a barra de progresso apenas se o usuário estiver inscrito
            if (isset($progress)) {
                echo '<div class="progress-bar" style="display: block;">
                <div class="progress-bar-inner" style="width: ' . $progress . '%;"><span>' . $progress . '%</span></div>
              </div>';
            }
        } else {
            // Se o usuário não estiver inscrito, ocultar a barra de progresso
            echo '<div class="progress-bar" style="display: none;">
            <div class="progress-bar-inner"></div>
          </div>';
        }
        ?>


        <section class="videos" id="videos">
            <h2 class="video-title"><br><?php echo htmlspecialchars($moduloNome); ?></h2>
            <?php
            if ($moduloAtual) {
                if (!empty($moduloAtual['videos']) && is_array($moduloAtual['videos'])) {
                    if (usuarioJaInscrito($cursoNome, $moduloNome)) {
                        foreach ($moduloAtual['videos'] as $video) {
                            // Verificar se o vídeo já foi concluído
                            $Concluido = in_array($video['id'], $jaConcluido);
                            echo '
                        <div class="video-item">
                            <h3 class="video-question">' . htmlspecialchars($video['titulo']) . '
                            <span class="faq-icon" aria-hidden="true">&#x25BC;</span></h3>
                            <div class="video-answer">
                                <iframe width="80%" height="516" src="' . htmlspecialchars($video['url']) . '" frameborder="0" allowfullscreen></iframe>
                                <form method="POST">
                                    <input type="hidden" name="video_id" value="' . $video['id'] . '">';

                            // Lógica para o botão
                            if ($Concluido) {
                                // Se o vídeo já foi concluído, desabilitar o botão
                                echo '<button type="submit" name="marcar_concluido" class="concluir-video" style="background-color: red;" disabled>
                                    Já Concluído
                                  </button>';
                            } else {
                                // Se o vídeo ainda não foi concluído, o botão é clicável
                                echo '<button type="submit" name="marcar_concluido" class="concluir-video" style="background-color: green;">
                                    Concluído
                                  </button>';
                            }

                            echo '
                                </form>
                            </div>
                        </div>';
                        }
                    } else {
                        echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Você precisa se inscrever para acessar os vídeos.</p>';
                    }
                } else {
                    echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Nenhum vídeo encontrado para este módulo.</p>';
                }
            } else {
                echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Curso ou módulo não encontrado!</p>';
            }
            ?>
        </section>



    </main>

    <?php Footer(); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="js/paginadecursos.js">
        const botaoInscricao = document.querySelector('.inscrever-button');

        botaoInscricao.addEventListener('click', () => {
            if (usuarioJaInscrito(<?php echo $cursoNome; ?>, <?php echo $moduloNome; ?>)) {
                botaoInscricao.classList.add('inscrito');
                botaoInscricao.disabled = true;
            }
        });
    </script>

</body>

</html>