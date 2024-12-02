<?php

// Função para exibir A NAVBAR (PÁGINAS COM CONFLITOS ENTRE ARRAYS DO ITEMS.PHP)

// Verifica se a sessão ainda não foi iniciada, e se não, inicia uma nova sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define um array associativo com os itens de menu, onde a chave é o nome da opção e o valor é o link
$menuItems = [
    'Home' => 'index.php',
    'Cursos' => 'cursos.php',
    'Acompanhamento' => 'acompanhamento.php',
    'Sobre Nós' => 'sobreNos.php',
    'Fórum' => 'forum.php'
];

// Função para gerar o menu na página
function Menu($menuItems)
{
    echo
    '<header">
     <nav class="navbar">
    <div class="logo">Estudo<span>Mind</span></div>
   
        <ul>';

    // Itera sobre os itens do menu e cria uma lista de links para cada item
    foreach ($menuItems as $title => $link) {
        echo "<li class=\"nav-item\"><a href=\"$link\" class=\"nav-link\">$title</a></li>";
    }
    echo '</ul>
    ';

    // Verifica se o usuário está logado (se existe a variável de sessão 'usuario_email')
    if (isset($_SESSION['usuario_email'])) {
        // Recupera o nome do usuário da sessão e exibe o nome junto com um ícone
        $usuario = $_SESSION['usuario'];
        echo '<div class="user-name">' . ucfirst(strtolower($usuario)) . ' <img src="img/user-interface.png" alt=" style="width: 25px; transform: translateY(6px);">
    <div class="logout-container">
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
 
</div>';
    } else {
        // Caso o usuário não esteja logado, exibe os botões de login e registro
        echo '<div class="btn-container">
        <a href="login-teste.php"><button class="btn-login">Login</button></a>
        <a href="login-teste.php"><button class="btn-register">Registre-se</button></a>
     </div>
    
     </div>
     ';
    }

    // Seção do ícone de menu móvel (para dispositivos móveis)
    echo '
     <div class="mobile-menu-icon">
     <button onclick="menuShow()"><img class="icon" src="img/menu-icon.svg"></button>
     </div>
        </nav>
    <div class="mobile-menu">
        <ul>';
    foreach ($menuItems as $title => $link) {
        echo "<li class=\"nav-item\"><a href=\"$link\" class=\"nav-link\">$title</a></li>";
    }
    echo '</ul>';

    // Se o usuário estiver logado, exibe o nome do usuário e o botão de logout no menu móvel
    if (isset($_SESSION['usuario_email'])) {
        $usuario = $_SESSION['usuario'];
        echo '<div class="user-name">' . ucfirst(strtolower($usuario)) . ' <img src="img/user-interface.png" alt="" style="width: 25px; transform: translateY(6px);">
            <div class="logout-container">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>';
    } else {
        // Caso o usuário não esteja logado, exibe os botões de login e registro no menu móvel
        echo '<div class="btn-container">
            <a href="login-teste.php"><button class="btn-login">Login</button></a>
            <a href="login-teste.php"><button class="btn-register">Registre-se</button></a>
         </div>';
    }
    echo '

    </div>
    </header>';
}
?>
