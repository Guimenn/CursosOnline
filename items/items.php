<?php

// Inicia a sessão, caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();  // Inicia a sessão PHP para que informações do usuário possam ser armazenadas e acessadas
}

// Define os itens de menu que aparecerão na navegação
$menuItems = [
    'Home' => 'index.php',
    'Cursos' => 'cursos.php',
    'Acompanhamento' => 'acompanhamento.php',
    'Sobre Nós' => 'sobreNos.php',
    'Fórum' => 'forum.php'
];

// Função para exibir o menu de navegação
function Menu($menuItems)
{
    // Início do HTML para o menu de navegação
    echo
    '<header">
     <nav class="navbar">
    <div class="logo">Estudo<span>Mind</span></div>
   
        <ul>';

    // Loop para gerar os itens de navegação a partir do array $menuItems
    foreach ($menuItems as $title => $link) {
        echo "<li class=\"nav-item\"><a href=\"$link\" class=\"nav-link\">$title</a></li>";
    }

    echo '</ul>
    ';

    // Verifica se o usuário está logado (presença de sessão com email)
    if (isset($_SESSION['usuario_email'])) {
        // Se o usuário estiver logado, exibe o nome do usuário e a opção de logout
        $usuario = $_SESSION['usuario'];  // Recupera o nome do usuário da sessão
        echo '<div class="user-name">' . ucfirst(strtolower($usuario)) . ' <img src="img/user-interface.png" alt=" style="width: 25px; transform: translateY(6px);">
    <div class="logout-container">
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
 
</div>';
    } else {
        // Se o usuário não estiver logado, exibe botões de login e registro
        echo '<div class="btn-container">
        <a href="login-teste.php"><button class="btn-login">Login</button></a>
        <a href="login-teste.php"><button class="btn-register">Registre-se</button></a>
     </div>
    
     </div>
     ';
    }

    // Parte do menu que fica visível em dispositivos móveis (ícone de menu)
    echo '
     <div class="mobile-menu-icon">
     <button onclick="menuShow()"><img class="icon" src="img/menu-icon.svg"></button>
     </div>
        </nav>
    <div class="mobile-menu">
        <ul>';

    // Loop para gerar os itens de navegação também no menu mobile
    foreach ($menuItems as $title => $link) {
        echo "<li class=\"nav-item\"><a href=\"$link\" class=\"nav-link\">$title</a></li>";
    }

    echo '</ul>';

    // Exibe a opção de logout ou login no menu mobile, conforme o status da sessão
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

    // Fim do menu mobile
    echo '

    </div>
    </header>';
}

// Função para exibir o rodapé da página
function Footer()
{
    // HTML do rodapé
    echo '    <footer class="footer">
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
        <li><a href="#">Guimen</a></li>  <!-- Lista de parceiros -->
        <li><a href="#">libre000</a></li>
        <li><a href="#">Vini100365</a></li>
      </ul>
    </div>
  </div>

  <div class="social-icons">
    <!-- Links para redes sociais -->
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

// Lista de benefícios oferecidos pelos cursos
$benefits = [
    [
        'title' => 'Acesso vitalício',
        'icon' => 'fas fa-infinity',  // Ícone Font Awesome
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

// Lista de cursos disponíveis na plataforma
$cursos = [
    [
        'title' => 'C#',
        'image' => 'c-sharp.png',  // Imagem representando o curso
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
        'title' => 'Ruby',
        'image' => 'ruby.png',
        'description' => 'Aprenda Ruby do zero ao avançado'
    ]
];

// Lista de perguntas frequentes (FAQs)
$faqs = [
    [
        'question' => 'Como posso acessar o curso?',
        'answer' => 'Para se inscrever, registre-se e escolha o curso desejado.'
    ],
    [
        'question' => 'Os cursos tem certificado?',
        'answer' => 'Sim! Todos os cursos oferecem certificados válidos e reconhecidos.'
    ],
    [
        'question' => 'Preciso pagar para fazer o curso?',
        'answer' => 'Não! Nossa plataforma oferece cursos gratuitos para todos os interessados.'
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

$cardsobrenos = [
    [
        'title' => 'HTML',
        'texto' => 'Base estrutural das páginas web.
                            Define a estrutura e o conteúdo de sites.',
    ],
    [
        'title' => 'JavaScript',
        'texto' => 'Adiciona interatividade e dinamismo às páginas web.
                            Essencial para o desenvolvimento front-end.',
    ],
    [
        'title' => 'PHP',
        'texto' => 'Quer liderar equipes, organizar seu tempo ou melhorar sua comunicação? Nossos cursos de desenvolvimento pessoal ajudam você a desbloquear todo o seu potencial.',
    ],
    [
        'title' => 'Python',
        'texto' => 'Conhecido pela simplicidade e versatilidade.
                            Utilizado em desenvolvimento web, ciência de dados, automação e inteligência artificial.',
    ],
    [
        'title' => 'Java',
        'texto' => 'Popular na criação de aplicativos robustos e corporativos.
                            Base para o desenvolvimento de aplicativos Android.',
    ],
    [
        'title' => 'Ruby',
        'texto' => 'Linguagem elegante eácil de usar.
                            Combinado com o framework Rails, é ideal para desenvolvimento ágil de aplicações web.',
    ],
    [
        'title' => 'C++',
        'texto' => 'Linguagem de alto desempenho.
                            Amplamente utilizada em sistemas operacionais, jogos e aplicações de baixo nível.',
    ],
    [
        'title' => 'C#',
        'texto' => 'Desenvolvido pela Microsoft para o ecossistema Windows.
                            Muito usado em jogos com Unity e aplicações empresariais.',
    ],
];

$comentarios = [
    [
        'nome' => 'Ana Souza',
        'mensagem' => '"Sempre quis aprender algo novo, mas nunca tive tempo ou dinheiro. Com esses cursos gratuitos, consegui desenvolver habilidades incríveis e até mudei de carreira. Super recomendo!"'
    ],
    [
        'nome' => 'Carlos Mendes',
        'mensagem' => '"Achei que cursos gratuitos seriam básicos, mas me surpreendi com a qualidade. O material é incrível, os exercícios são dinâmicos, e os certificados realmente fazem diferença no mercado de trabalho."'
    ],
    [
        'nome' => 'Mariana Oliveira',
        'mensagem' => '"A flexibilidade é o que mais me encanta! Consigo estudar quando as crianças dormem, sem pressa, e ainda me sinto acompanhada com o suporte que eles oferecem. Estou amando!"'
    ],

];

$mid2cards = [
    [
        'title' => 'Totalmente Acessíveis',
        'icon' => 'fas fa-globe',
        'texto' => 'Com uma conexão à internet, vocé tem o mundo do aprendizado ao alcance das suas.macas.'
    ],
    [
        'title' => 'Certificação Garantida',
        'icon' => 'fas fa-certificate',
        'texto' => 'Conclua o curso e receba um certificado digital sem custo adicional! Com ele, vocé pode provar suas novas habilidades e abrir portas no mercado de trabalho.'
    ],
    [
        'title' => 'Materiais Exclusivos',
        'icon' => 'fas fa-book',
        'texto' => 'Desenvolvemos cada curso com carinho e atenção aos detalhes, garantindo que vocé tenha acesso ao melhor conteúdo, organizado e prático para facilitar o aprendizado.'
    ]
];

$vantagens = [
    [
        'title' => 'Aprendizado Dinâmico',
        'icon' => 'fas fa-chalkboard-teacher',
        'texto' => 'Nada de aulas monótonas! Usamos vídeos, quizzes e simulados para garantir que vocé aproveite cada momento do estudo.'
    ],
    [
        'title' => 'Comunidade Ativa',
        'icon' => 'fas fa-users',
        'texto' => 'Faça parte de uma comunidade global de estudantes como vocé! Participe de fóruns, tire dúvidas e compartilhe experiências.'
    ],
    [
        'title' => 'Suporte Amigo',
        'icon' => 'fas fa-headset',
        'texto' => 'Nossa equipe está sempre disponível para ajudar com dúvidas ou dificuldades, tornando sua experiência a mais tranquila possibile.'
    ]
];
