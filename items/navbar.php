<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$menuItems = [
    'Home' => 'index.php',
    'Cursos' => 'cursos.php',
    'Acompanhamento' => 'acompanhamento.php',
    'FAQ' => '#faq',
    'Blog' => 'blog.php'
];

function Menu($menuItems)
{
    echo
    '<header">
     <nav class="navbar">
    <div class="logo">Estudo<span>Mind</span></div>
   
        <ul>';

    foreach ($menuItems as $title => $link) {
        echo "<li class=\"nav-item\"><a href=\"$link\" class=\"nav-link\">$title</a></li>";
    }

    echo '</ul>
    ';

    if (isset($_SESSION['usuario_email'])) {
        $usuario = $_SESSION['usuario'];
        echo '<div class="user-name">' . ucfirst(strtolower($usuario)) . ' <img src="img/user-interface.png" alt=" style="width: 25px; transform: translateY(6px);">
    <div class="logout-container">
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
 
</div>';
    } else {
        echo '<div class="btn-container">
        <a href="login-teste.php"><button class="btn-login">Login</button></a>
        <a href="login-teste.php"><button class="btn-register">Registre-se</button></a>
     </div>
    
     </div>
     ';
    }

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


    if (isset($_SESSION['usuario_email'])) {
        $usuario = $_SESSION['usuario'];
        echo '<div class="user-name">' . ucfirst(strtolower($usuario)) . ' <img src="img/user-interface.png" alt="" style="width: 25px; transform: translateY(6px);">
            <div class="logout-container">
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>';
    } else {
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