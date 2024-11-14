<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

function Footer() {
    echo'    <footer class="footer">
  <div class="container">
    <div class="section desenvolvedores">
      <h4>Desenvolvedores</h4>
      <p>Desenvolvido por <a href="#">EstudoMind</a></p>
      <p><a href="#">Política de Privacidade</a> | <a href="#">Termos de Uso</a></p>
    </div>

    <div class="section contato">
      <h4>Contato</h4>
      <p>Telefone: (11) 4002-8922</p>
      <p>Email: <a href="mailto:contato@estudomind.com.br">contato@estudomind.com.br</a></p>
    </div>

    <div class="section newsletter">
      <h4>Newsletter</h4>
      <p>Receba nossas novidades:</p>
      <form>
        <input type="email" placeholder="Seu e-mail" required>
        <button type="submit">Inscrever-se</button>
      </form>
    </div>

    <div class="section parceiros">
      <h4>Parceiros</h4>
      <ul>
        <li><a href="#">Guimen</a></li>
        <li><a href="#">libre000</a></li>
        <li><a href="#">Vini100365</a></li>
      </ul>
    </div>
  </div>

  <div class="social-icons">
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-linkedin-in"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>

  <div class="copyright">
    <p>&copy; 2024 EstudoMind. Todos os direitos reservados.</p>
  </div>
</footer>';
}

$benefits = [
    [
        'title' => 'Acesso vitalício',
        'icon' => 'fas fa-infinity',
        'description' => 'Compre uma vez e tenha acesso ao conteúdo para sempre.'
    ],
    [
        'title' => 'Atualizações constantes',
        'icon' => 'fas fa-sync-alt',
        'description' => 'Garanta que sempre estará aprendendo com o material mais recente.'
    ],
    [
        'title' => 'Certificado reconhecido',
        'icon' => 'fas fa-certificate',
        'description' => 'Adicione valor ao seu currículo com nossos certificados profissionais.'
    ],
    [
        'title' => 'Suporte 24/7',
        'icon' => 'fas fa-headset',
        'description' => 'Nosso time está disponível para tirar suas dúvidas a qualquer momento.'
    ]
];



$cursos = [
    [
        'title' => 'C#',
        'image' => 'c-sharp.png',
        'description' => 'Aprenda C# do zero ao avançado'
    ],
    [
        'title' => 'Python',
        'image' => 'python.png',
        'description' => 'Aprenda Python do zero ao avançado'

    ],
    [
        'title' => 'C++',
        'image' => 'c-.png',
        'description' => 'Aprenda C++ do zero ao avançado'
    ],


    [
        'title' => 'HTML',
        'image' => 'html.png',
        'description' => 'Aprenda HTML do zero ao avançado'
    ],
    [
        'title' => 'JavaScript',
        'image' => 'js.png',
        'description' => 'Aprenda JavaScript do zero ao avançado'
    ],
    [
        'title' => 'CSS',
        'image' => 'css-3.png',
        'description' => 'Aprenda CSS do zero ao avançado'
    ],

    [
        'title' => 'Java',
        'image' => 'java.png',
        'description' => 'Aprenda Java do zero ao avançado'
    ],
    [
        'title' => 'PHP',
        'image' => 'php.png',
        'description' => 'Aprenda PHP do zero ao avançado'
    ],
    [
        'title' => 'ruby',
        'image' => 'ruby.png',
        'description' => 'Aprenda Ruby do zero ao avançado'
    ],

];

$faqs = [
    [
        'question' => 'Como posso acessar o curso depois da compra?',
        'answer' => 'Após a compra, você receberá um link por e-mail para acessar sua conta e os cursos adquiridos.'
    ],
    [
        'question' => 'Os cursos tem certificado?',
        'answer' => 'Sim! Todos os cursos oferecem certificados válidos e reconhecidos.'
    ],
    [
        'question' => 'Preciso pagar para fazer o curso?',
        'answer' => 'Para se inscrever, visite nosso site, escolha o curso desejado e siga as instruções para registro e pagamento. Após a confirmação, você terá acesso imediato ao conteúdo.'
    ],
    [
        'question' => 'Posso fazer mais de um curso ao mesmo tempo?',
        'answer' => 'Claro, você pode se inscrever em quantos cursos desejar e estudar simultaneamente, conforme sua disponibilidade.'
    ],
    [
        'question' => 'Como faça para entrar em contato com o suporte se tiver dúvidas?',
        'answer' => 'Você pode entrar em contato com nossa equipe de suporte via e-mail ou através dos fóruns de discussão disponíveis na plataforma.'
    ]
];