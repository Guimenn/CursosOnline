<?php
// Inicia a sessão para acessar os dados do usuário
session_start();

// Remove todas as variáveis de sessão
session_unset();

// Destroi a sessão atual, apagando todos os dados armazenados
session_destroy();

// Redireciona o usuário para a página inicial (index.php)
header("Location: index.php");

// Encerra a execução do script para garantir que nenhum outro código seja executado
exit();
?>