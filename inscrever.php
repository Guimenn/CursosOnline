<?php
session_start();

// Função para inscrever o usuário no curso
function inscreverCurso($email, $curso, $modulo) {
    $usuarios = [];
    $usuarioInscrito = false;

    // Carrega o conteúdo do arquivo
    $linhas = file("usuarios.txt", FILE_IGNORE_NEW_LINES);
    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);
        if (count($dados) === 4) {
            list($nome, $emailArq, $senha, $cursos) = $dados;

            if ($emailArq === $email) {
                $cursosArray = $cursos ? explode(",", $cursos) : [];
                $cursoModulo = $curso . "-" . $modulo;

                // Adiciona o curso e módulo se ainda não estiver inscrito
                if (!in_array($cursoModulo, $cursosArray)) {
                    $cursosArray[] = $cursoModulo;
                }

                $usuarios[] = "$nome|$emailArq|$senha|" . implode(",", $cursosArray);
                $usuarioInscrito = true;
            } else {
                $usuarios[] = $linha;
            }
        }
    }

    // Se o usuário não estiver inscrito, adiciona a inscrição
    if (!$usuarioInscrito) {
        // Adiciona o usuário ao arquivo caso ele não esteja inscrito
        $usuarios[] = "$nome|$email|$senha|$curso-$modulo";
    }

    // Salva as alterações no arquivo
    file_put_contents("usuarios.txt", implode("\n", $usuarios));
}

// Verifica se o usuário está logado e se os dados de curso e módulo foram passados
if (isset($_POST['curso'], $_POST['modulo'], $_SESSION['usuario_email'])) {
    $email = $_SESSION['usuario_email'];
    $curso = $_POST['curso'];
    $modulo = $_POST['modulo'];
    
    inscreverCurso($email, $curso, $modulo);

    header("Location: acompanhamento.php"); // Redireciona para a página de acompanhamento
    exit();
} else {
    echo "Erro ao tentar inscrever-se. Verifique seus dados.";
}
?>
