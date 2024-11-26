<?php
session_start();

// Função para inscrever o usuário em um curso e módulo
function inscreverCurso($email, $curso, $modulo) {
    $usuarios = [];
    $usuarioInscrito = false;

    // Lê o arquivo de usuários
    $linhas = file("usuarios.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        $dados = explode("|", $linha);
        if (count($dados) === 4) {
            list($nome, $emailArq, $senha, $cursos) = $dados;

            if ($emailArq === $email) {
                $cursosArray = $cursos ? explode(",", $cursos) : [];
                $cursoModulo = "$curso-$modulo";

                // Adiciona o curso-módulo se ainda não estiver inscrito
                if (!in_array($cursoModulo, $cursosArray)) {
                    $cursosArray[] = $cursoModulo;
                }

                // Atualiza a linha do usuário
                $usuarios[] = "$nome|$emailArq|$senha|" . implode(",", $cursosArray);
                $usuarioInscrito = true;
            } else {
                $usuarios[] = $linha; // Mantém as linhas dos outros usuários
            }
        }
    }

    // Adiciona o usuário se ele não foi encontrado no arquivo
    if (!$usuarioInscrito) {
        $nome = "NovoUsuário"; // Define um nome padrão para novos usuários
        $senha = "senha123"; // Define uma senha padrão (deve ser ajustado conforme o sistema)
        $usuarios[] = "$nome|$email|$senha|$curso-$modulo";
    }

    // Escreve o conteúdo atualizado de volta no arquivo
    file_put_contents("usuarios.txt", implode("\n", $usuarios));
}

// Verifica se os dados necessários foram enviados
if (isset($_POST['curso'], $_POST['modulo'], $_SESSION['usuario_email'])) {
    $email = $_SESSION['usuario_email'];
    $curso = $_POST['curso'];
    $modulo = $_POST['modulo'];

    // Chama a função para inscrever o usuário
    inscreverCurso($email, $curso, $modulo);

    // Redireciona para a página de acompanhamento
    header("Location: acompanhamento.php");
    exit();
} else {
    // Mensagem de erro caso faltem dados
    echo "Erro ao tentar inscrever-se. Verifique seus dados.";
}
?>
