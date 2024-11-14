<?php


$menuItems = [
    'Home' => 'index.php',
    'Cursos' => 'cursos.php',
    'Acompanhamento' => 'acompanhamento.php',
    'FAQ' => '#faq',
    'Contato' => '#contact'
];

function Menu($menuItems)
{
    echo
    '<header style=" height: 74px;">
    <div class="header">
    <div class="logo">Estudo<span>Mind</span></div>
    <nav class="navbar">
        <ul>';

    foreach ($menuItems as $title => $link) {
        echo "<li><a href=\"$link\">$title</a></li>";
    }

    echo '</ul>
    </nav>';

    if (isset($_SESSION['usuario_email'])) {
        $usuario = $_SESSION['usuario'];
        echo "<div class='user-name'>" . ucfirst(strtolower($usuario)) . " <img src='img/user-interface.png' alt='' style='width: 25px; transform: translateY(6px);'>
    <div class='logout-container'>
        <a href='logout.php' class='btn-logout'>Logout</a>
    </div>
</div>";
    } else {
        echo '<div class="btn-container">';
        echo '<a href="login-teste.php"><button class="btn-login">Login</button></a>';
        echo '<a href="login-teste.php"><button class="btn-register">Registre-se</button></a>';
        echo '</div>';
    }

    echo '</div></header>';
}

?>