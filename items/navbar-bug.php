<?php

// Define menu items as an associative array
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
    '<header style=" height: 74px;">
    <div class="header">
    <div class="logo">Estudo<span>Mind</span></div>
    <nav class="navbar">
        <ul>';

    // Iterate over menu items and create list items for each
    foreach ($menuItems as $title => $link) {
        echo "<li><a href=\"$link\">$title</a></li>";
    }

    echo '</ul>
    </nav>';

    // Check if the user is logged in
    if (isset($_SESSION['usuario_email'])) {
        echo '<div class="btn-container">';
        echo '<a href="login-teste.php"><button class="btn-login">Login</button></a>';
        echo '<a href="login-teste.php"><button class="btn-register">Registre-se</button></a>';
        echo '</div>';
    }

    echo '</div></header>';
}

?>
