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
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="estilos/acompanhamentos.css">
        <link rel="stylesheet" href="estilos/items.css">
        <style>
            
    </head>
    <body>
           Por favor, faça o login para se inscrever.
    </body>
    </html>
    ';


    exit;
}

// Recupera o curso e módulo da URL via GET
$cursoNome = isset($_GET['curso']) ? $_GET['curso'] : null;
$moduloNome = isset($_GET['modulo']) ? $_GET['modulo'] : null;

// Verificação para garantir que os dados de curso e módulo estão sendo passados
if (!$cursoNome || !$moduloNome) {
    echo '<h2>Curso ou Módulo não encontrado!</h2>';
    exit;
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

// Itera sobre o array principal para localizar o curso e módulo
foreach ($cursos as $curso) {
    if (isset($curso[$cursoNome]) && isset($curso[$cursoNome][$moduloNome])) {
        $moduloAtual = $curso[$cursoNome][$moduloNome];
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso: <?php echo htmlspecialchars($cursoNome); ?> - Módulo: <?php echo htmlspecialchars($moduloNome); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/paginadecursos.css">
    <link rel="stylesheet" href="estilos/items.css">
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
            <?php if ($inscrito): ?>
                <p>Você foi inscrito no curso com sucesso!</p>
            <?php else: ?>

        </div>

        <!-- Div para informações do curso -->
        <div class="course-info" id="courseInfo">
            <div class="course-status">
                <span class="info-label">Seu Estado</span>
                <span class="status-label">
                    0%
                </span>
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
                </form>
            </div>
        </div>

    <?php endif ?>
    <!-- Seção de vídeos -->
    <section class="videos" id="videos">
        <h2 class="video-title"><br><?php echo htmlspecialchars($moduloNome); ?></h2>
        <?php
        // Verifica se o módulo foi encontrado
        if ($moduloAtual) {
            // Exibe os vídeos do módulo, se existirem
            if (!empty($moduloAtual['videos']) && is_array($moduloAtual['videos'])) {
                foreach ($moduloAtual['videos'] as $video) {
                    echo '
                    <div class="video-item">
                        <h3 class="video-question">' . htmlspecialchars($video['titulo']) . '
                        <span class="faq-icon" aria-hidden="true">&#x25BC;</span></h3>
                        <div class="video-answer">
                            <iframe width="80%" height="516" src="' . htmlspecialchars($video['url']) . '" frameborder="0" allowfullscreen></iframe>
                            <form method="POST">
                                <input type="hidden" name="video_id" value="' . $video['id'] . '">
                                <button type="submit" name="marcar_concluido" class="concluir-video">Concluído</button>
                            </form>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Nenhum vídeo encontrado para este módulo.</p>';
            }
        } else {
            echo '<p>Curso ou módulo não encontrado!</p>';
        }
        ?>
    </section>



    </main>

    <?php Footer(); ?>
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