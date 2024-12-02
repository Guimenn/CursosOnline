<?php

// Inicia a sessão caso ainda não esteja iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão para permitir o armazenamento de dados entre páginas
}

// Define os itens do menu (links para navegação)
$menuItems = [
    'Home' => 'index.php', // Página inicial
    'Cursos' => 'cursos.php', // Página de cursos
    'Acompanhamento' => 'acompanhamento.php', // Página de acompanhamento
    'FAQ' => '#faq', // Ancoragem para seção FAQ
    'Contato' => '#contact' // Ancoragem para seção de contato
];

// Função para exibir o menu de navegação
function Menu($menuItems)
{
    echo '
    <header style="height: 74px;">
    <div class="header">
        <div class="logo">Estudo<span>Mind</span></div>
        <nav class="navbar">
            <ul class="navbar-list">';

    // Cria a lista de links do menu
    foreach ($menuItems as $title => $link) {
        echo "<li><a href=\"$link\">$title</a></li>";
    }

    echo '</ul>
        <div class="hamburger-menu" onclick="toggleMenu()">&#9776;</div> <!-- Menu móvel -->
    </nav>';

    // Verifica se o usuário está logado
    if (isset($_SESSION['usuario_email'])) {
        $usuario = $_SESSION['usuario']; // Nome do usuário logado
        // Exibe nome do usuário com opção de logout
        echo "<div class='user-name'>" . ucfirst(strtolower($usuario)) . " <img src='img/user-interface.png' alt='' style='width: 25px; transform: translateY(6px);'>
        <div class='logout-container'>
            <a href='logout.php' class='btn-logout'>Logout</a> <!-- Botão de logout -->
        </div>
    </div>";
    } else {
        // Caso o usuário não esteja logado, exibe as opções de login e registro
        echo '<div class="btn-container">';
        echo '<a href="login-teste.php"><button class="btn-login">Login</button></a>';
        echo '<a href="login-teste.php"><button class="btn-register">Registre-se</button></a>';
        echo '</div>';
    }

    echo '</div></header>'; // Fecha o header
}

// Função para exibir o rodapé
function Footer()
{
    echo '<footer class="footer">
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
        <input type="email" placeholder="Seu e-mail" required> <!-- Campo para email -->
        <button type="submit">Inscrever-se</button> <!-- Botão de inscrição -->
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
  <div class="social-icons"> <!-- Ícones de redes sociais -->
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-linkedin-in"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>
  <div class="copyright">
    <p>&copy; 2024 EstudoMind. Todos os direitos reservados.</p> <!-- Copyright -->
  </div>
</footer>';
}

// Benefícios apresentados no site
$benefits = [
    [
        'title' => 'Acesso vitalício', // Título do benefício
        'icon' => 'fas fa-infinity', // Ícone associado
        'description' => 'Compre uma vez e tenha acesso ao conteúdo para sempre.' // Descrição do benefício
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

// Lista de cursos disponíveis
$cursos = [
    [
        'title' => 'C#', // Nome do curso
        'image' => 'c-sharp.png', // Imagem do curso
        'description' => 'Aprenda C# do zero ao avançado' // Descrição do curso
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
        'title' => 'Ruby',
        'image' => 'ruby.png',
        'description' => 'Aprenda Ruby do zero ao avançado'
    ]
];

// FAQ com perguntas frequentes
$faqs = [
    [
        'question' => 'Como posso acessar o curso depois da compra?', // Pergunta
        'answer' => 'Após a compra, você receberá um link por e-mail para acessar sua conta e os cursos adquiridos.' // Resposta
    ],
    [
        'question' => 'Os cursos têm certificado?',
        'answer' => 'Sim! Todos os cursos oferecem certificados válidos e reconhecidos.'
    ],
    [
        'question' => 'Preciso pagar para fazer o curso?',
        'answer' => 'Para se inscrever, escolha o curso desejado, registre-se e complete o pagamento.'
    ],
    [
        'question' => 'Posso fazer mais de um curso ao mesmo tempo?',
        'answer' => 'Sim, você pode se inscrever em quantos cursos desejar e estudar simultaneamente.'
    ],
    [
        'question' => 'Como faço para entrar em contato com o suporte?',
        'answer' => 'Você pode entrar em contato por e-mail ou através dos fóruns de discussão na plataforma.'
    ]
];
