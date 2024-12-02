<?php
    session_start(); // Inicia a sessão para manter informações do usuário entre as páginas
 
    // Inclui arquivos necessários
    include 'items/courses.php';
    include 'items/footer.php';
    include 'items/navbar.php';
 
    // Inicializa variáveis com valores padrões
    $cursoNome = filter_input(INPUT_GET, 'curso', FILTER_SANITIZE_STRING);
    $moduloNome = filter_input(INPUT_GET, 'modulo', FILTER_SANITIZE_STRING);
 
    // Verifica se o usuário está logado, verificando a sessão
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
 
 
        // Verifica se a função Menu existe e se o menu foi carregado
        if (function_exists('Menu') && !empty($menuItems)) {
            Menu($menuItems);
        } else {
            echo '<h1>Erro ao carregar o menu.</h1>';
        }
        echo '<h1>Por favor, faça o login para se inscrever.</h1>
            <script src="js/menu.js"></script>
    </body>
    </html>
    ';
        header('Refresh: 3; URL=login-teste.php');  // Redireciona para o login após 3 segundos
        exit;
    }
    // Função que verifica se o usuário já está inscrito no curso e módulo
    $inscrito = usuarioJaInscrito($cursoNome, $moduloNome);
 
    // Inicializa a sessão para armazenar os cursos concluídos e o progresso
    if (!isset($_SESSION['concluido'])) {
        $_SESSION['concluido'] = [];
    }
 
    if (!isset($_SESSION['progress'])) {
        $_SESSION['progress'] = 0;
    }
 
    // Recupera o email do usuário logado
    $usuario = $_SESSION['usuario_email'];
 
    // Recupera o curso e módulo a partir dos parâmetros na URL (GET)
    $cursoNome = isset($_GET['curso']) ? $_GET['curso'] : null;
    $moduloNome = isset($_GET['modulo']) ? $_GET['modulo'] : null;
 
    // Verifica se o curso e o módulo foram passados na URL
    if (!$cursoNome || !$moduloNome) {
        echo '<h2>Curso ou Módulo não encontrado!</h2>';
        exit;
    }
 
    // Diretório completo para o arquivo
    $diretorio = "concluidos/{$usuario}";
 
    if (!is_dir($diretorio)) {
        if (!mkdir($diretorio, 0755, true)) {
            echo 'Erro ao criar a pasta.';
        } else {
            echo '';
        }
    }
 
    // Caminho completo do arquivo
    $arquivo = $diretorio . "/{$cursoNome}_{$moduloNome}.txt";
 
    // Cria o diretório "acompanhamento" se não existir
    if (!is_dir('acompanhamento')) {
        mkdir('acompanhamento', 0777, true);
    }
 
    // Cria o arquivo de acompanhamento, caso não exista
    if (!file_exists($arquivo)) {
        file_put_contents($arquivo, '');
    }
 
    // Verifica se o curso e o módulo existem nos dados
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
 
    // Se o curso ou módulo não forem encontrados, exibe um erro
    if (!$cursoValido || !$moduloValido) {
        echo '<h2>Curso ou Módulo não encontrado!</h2>';
        exit;
    }
 
    // Função para salvar a inscrição do usuário no arquivo
    function inscreverNoCurso($curso, $modulo)
    {
        $usuario = $_SESSION['usuario_email'];
        $arquivo = "acompanhamento/{$usuario}.txt";
        file_put_contents($arquivo, "Curso: $curso, Módulo: $modulo\n", FILE_APPEND);
    }
 
    // Função para verificar se o usuário já está inscrito no curso e módulo
    function usuarioJaInscrito($curso, $modulo)
    {
        $usuario = $_SESSION['usuario_email'];
        $arquivo = "acompanhamento/{$usuario}.txt";
 
        if (file_exists($arquivo)) {
            $acompanhamentos = file($arquivo, FILE_IGNORE_NEW_LINES);
            foreach ($acompanhamentos as $acompanhamento) {
                if (strpos($acompanhamento, "Curso: $curso") !== false && strpos($acompanhamento, "Módulo: $modulo") !== false) {
                    return true;
                }
            }
        }
        return false;
    }
 
    // Verifica se o formulário foi enviado para inscrever o usuário
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inscrever'])) {
        if (!usuarioJaInscrito($cursoNome, $moduloNome)) {
            inscreverNoCurso($cursoNome, $moduloNome);
            $inscrito = true;
        }
    }
 
    // Carregar vídeos concluídos ao abrir a página
    if (file_exists($arquivo)) {
        $jaConcluido = file($arquivo, FILE_IGNORE_NEW_LINES);
        $_SESSION['concluido'] = $jaConcluido;
    }
 
    // Atualizar progresso com base nos vídeos carregados
    $progress = count($jaConcluido) * 20;
    $_SESSION['progress'] = $progress;
 
    // Recupera o progresso do usuário da sessão
    $progress = isset($_SESSION['progress']) ? $_SESSION['progress'] : 0;
    $jaConcluido = isset($_SESSION['concluido']) ? $_SESSION['concluido'] : [];
 
    // Itera sobre o array de cursos para encontrar o curso e módulo específicos
    $moduloAtual = null;
    foreach ($cursos as $curso) {
        if (isset($curso[$cursoNome]) && isset($curso[$cursoNome][$moduloNome])) {
            $moduloAtual = $curso[$cursoNome][$moduloNome];
            break;
        }
    }
 
    // Verifica se o botão "marcar como concluído" foi pressionado
    if (isset($_POST['marcar_concluido'])) {
        $video_id = $_POST['video_id'];
 
        if (!in_array($video_id, $jaConcluido)) {
            $jaConcluido[] = $video_id;
            $_SESSION['concluido'] = $jaConcluido;
            $progress += 20;
            $_SESSION['progress'] = $progress;
 
            if (!file_exists($arquivo)) {
                file_put_contents($arquivo, '');
            }
 
            if (is_writable($arquivo)) {
                $ids_concluidos = file($arquivo, FILE_IGNORE_NEW_LINES);
                if (!in_array($video_id, $ids_concluidos)) {
                    file_put_contents($arquivo, $video_id . "\n", FILE_APPEND);
                }
            } else {
                echo 'Erro: Não é possível gravar no arquivo.';
            }
        }
    }
 
    // Lê os IDs dos vídeos concluídos do arquivo
    if (file_exists($arquivo)) {
        $ids_concluidos = file($arquivo, FILE_IGNORE_NEW_LINES);
    } else {
        $ids_concluidos = [];
    }
 
    // Atualiza a barra de progresso com base nos vídeos concluídos
    $progress = 0;
    $progresso = count($ids_concluidos) * 20;
 
    // Diretório e arquivo para certificados
    $pasta_usuario = "certificados/{$usuario}/{$cursoNome}/";
    $arquivo_certificado = "{$pasta_usuario}{$moduloNome}.png";
 
 
    ?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($cursoNome); ?> - <?php echo htmlspecialchars($moduloNome); ?></title> <!-- Título da página, com o nome do curso e módulo, sanitizado para evitar XSS -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet"> <!-- Fonte Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Ícones Font Awesome -->
    <link rel="stylesheet" href="estilos/paginadecursos.css"> <!-- Estilos específicos da página de cursos -->
    <link rel="stylesheet" href="estilos/items.css"> <!-- Estilos gerais para itens na página -->
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-pgcursos.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"> <!-- Ícone da página -->

</head>

<body>
    <?php
    Menu($menuItems);  // Exibe o menu com os itens passados para a função Menu
    ?>
    <main>
        <div class="titles">
            <?php
            // Exibe a imagem e título do módulo
            echo '<img src="' . htmlspecialchars($moduloAtual['image']) . '" alt="Imagem do Módulo" style="max-width: 100px; height: auto;">';
            echo '<h2>' . htmlspecialchars($moduloAtual['titulo']) . "<br>" .  htmlspecialchars($moduloAtual['descricao']) . '</h2>';
            ?>
        </div>

        <!-- Div para exibir informações do curso -->
        <div class="course-info" id="courseInfo">
            <div class="course-status">
                <span class="info-label">Seu Estado</span>
                <?php
                // Se o certificado já foi emitido
                // Verifica se o certificado já foi emitido
                if (file_exists($arquivo_certificado)) {
                    echo '<div class="status-certificado">
                        <span>CERTIFICADO <br>JÁ EMITIDO</span>
                    </div>';
                } else {
                    // Se o progresso for 100%, exibe o botão para emitir o certificado
                    if ($progresso == 100) {
                        echo '<div style="margin-top: 20px; text-align: center;">
                    <form method="GET" action="gerar_certificado.php">
                        <input type="hidden" name="curso" value="' . htmlspecialchars($cursoNome) . '">
                        <input type="hidden" name="modulo" value="' . htmlspecialchars($moduloNome) . '">
                        <button type="submit" class="emitir-certificado">Emitir Certificado</button>
                    </form>
                </div>';
                    } else {
                        // Exibe o progresso do usuário (percentual)
                        echo isset($jaConcluido) ? '<span class="status-label" id="statusLabel">' . $progresso . '%</span>' : '';
                    }
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
                    <!-- Se o usuário já estiver inscrito, o botão fica desabilitado -->
                    <button type="submit" name="inscrever" <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'disabled class="inscrito"' : ''; ?> class="inscrever-button">
                        <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'Inscrito' : 'Inscrever-se'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Seção de vídeos -->
        <?php
        // Calcula o progresso do usuário com base nos vídeos concluídos
        foreach ($ids_concluidos as $id_concluido) {
            if (in_array($id_concluido, $_SESSION['concluido'])) {
                $progress += 20; // Incrementa 20% por vídeo concluído
            }
        }

        // Verifica se o usuário está inscrito e exibe a barra de progresso
        if (usuarioJaInscrito($cursoNome, $moduloNome)) {
            if (isset($progress)) {
                echo '<div class="progress-bar" style="display: block;">
                <div class="progress-bar-inner" style="width: ' . $progress . '%;"><span>' . $progress . '%</span></div>
              </div>';
            }
        } else {
            // Se o usuário não estiver inscrito, oculta a barra de progresso
            echo '<div class="progress-bar" style="display: none;">
            <div class="progress-bar-inner"></div>
          </div>';
        }
        ?>

        <!-- Seção dos vídeos do curso -->
        <section class="videos" id="videos">
            <h2 class="video-title"><br><?php echo htmlspecialchars($moduloNome); ?></h2>
            <?php
            // Verifica se há vídeos para o módulo
            if ($moduloAtual) {
                if (!empty($moduloAtual['videos']) && is_array($moduloAtual['videos'])) {
                    // Se o usuário estiver inscrito, exibe os vídeos
                    if (usuarioJaInscrito($cursoNome, $moduloNome)) {
                        foreach ($moduloAtual['videos'] as $video) {
                            // Verifica se o vídeo já foi concluído
                            $Concluido = in_array($video['id'], $jaConcluido);
                            echo '
                        <div class="video-item">
                            <h3 class="video-question">' . htmlspecialchars($video['titulo']) . '
                            <span class="faq-icon" aria-hidden="true">&#x25BC;</span></h3>
                            <div class="video-answer">
                                <iframe width="80%" height="516" src="' . htmlspecialchars($video['url']) . '" frameborder="0" allowfullscreen></iframe>
                                <form method="POST" class="button-video">
                                    <input type="hidden" name="video_id" value="' . $video['id'] . '">';

                            // Se o vídeo foi concluído, desabilita o botão de "Concluído"
                            if ($Concluido) {
                                echo '<button type="submit" name="marcar_concluido" class="concluir-video" style="background-color: red; cursor: not-allowed;" disabled>
                                    Já Concluído
                                  </button>';
                            } else {
                                // Caso contrário, o botão "Concluído" fica habilitado
                                echo '<button type="submit" name="marcar_concluido" class="concluir-video" ">
                                    Marcar Concluido
                                  </button>';
                            }

                            echo '
                                </form>
                            </div>
                        </div>';
                        }
                    } else {
                        // Caso o usuário não estiver inscrito, exibe uma mensagem pedindo para se inscrever
                        echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Você precisa se inscrever para acessar os vídeos.</p>';
                    }
                } else {
                    // Caso não haja vídeos no módulo
                    echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Nenhum vídeo encontrado para este módulo.</p>';
                }
            } else {
                // Caso o curso ou módulo não for encontrado
                echo '<p style="text-align: center; margin-top: 20px; font-weight: normal; font-size: 2rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); ">Curso ou módulo não encontrado!</p>';
            }
            ?>
        </section>
    </main>

    <?php Footer(); ?> <!-- Exibe o rodapé da página -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Biblioteca para alertas -->
    <script src="js/menu.js"></script>
    <script src="js/paginadecursos.js">
        const botaoInscricao = document.querySelector('.inscrever-button'); // Seleciona o botão de inscrição

        // Adiciona evento para marcar o usuário como inscrito quando clicar
        botaoInscricao.addEventListener('click', () => {
            if (usuarioJaInscrito(<?php echo $cursoNome; ?>, <?php echo $moduloNome; ?>)) {
                botaoInscricao.classList.add('inscrito');
                botaoInscricao.disabled = true;
            }
        });
    </script>
</body>

</html>