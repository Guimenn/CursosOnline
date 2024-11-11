<?php
session_start();  // Inicia a sessão
// Incluindo o arquivo com os cursos
include 'courses.php';  // O arquivo deve definir a variável $cursos

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_email'])) {
    echo 'Por favor, faça o login para se inscrever.';
    header("Refresh: 2; url=login-teste.php");  // Redireciona após 2 segundos
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
function inscreverNoCurso($curso, $modulo) {
    $usuario = $_SESSION['usuario_email'];  // Pegando o usuário logado
    $arquivo = "acompanhamento/acompanhamentos_{$usuario}.txt";  // Arquivo específico por usuário
    file_put_contents($arquivo, "Curso: $curso, Módulo: $modulo\n", FILE_APPEND);
}

// Função para verificar se o usuário já está inscrito no curso e módulo específicos
function usuarioJaInscrito($curso, $modulo) {
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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso: <?php echo htmlspecialchars($cursoNome); ?> - Módulo: <?php echo htmlspecialchars($moduloNome); ?></title>
</head>

<body>
    <h1>Curso: <?php echo htmlspecialchars($cursoNome); ?></h1>
    <h2>Módulo: <?php echo htmlspecialchars($moduloNome); ?></h2>
    
    <?php
    // Verifique se o curso e módulo existem antes de exibir
    if (isset($cursos[$cursoNome][$moduloNome])) {
        // Exibe o módulo e a descrição
        $modulo = $cursos[$cursoNome][$moduloNome];
        echo '<img src="img-cursos/' . htmlspecialchars($modulo['image']) . '" alt="' . htmlspecialchars($modulo['description']) . '" />';
        echo '<p>' . htmlspecialchars($modulo['description']) . '</p>';
    } 
    ?>

    <!-- Botão de Inscrição -->
    <?php if ($inscrito): ?>
        <p>Você foi inscrito no curso com sucesso!</p>
    <?php else: ?>
        <form method="POST">
            <button type="submit" name="inscrever" <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'disabled' : ''; ?>>
                <?php echo usuarioJaInscrito($cursoNome, $moduloNome) ? 'Inscrito' : 'Inscrever-se'; ?>
            </button>
        </form>
    <?php endif; ?>
    <?php Footer(); ?>
</body>

</html>
