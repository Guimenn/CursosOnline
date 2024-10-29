<?php

$menuItems = [
    'Home' => '#home',
    'Cursos' => '#courses',
    'Benefícios' => '#benefits',
    'FAQ' => '#faq',
    'Contato' => '#contact'
];

function Menu($menuItems)
{
    echo 
    '<header class="header">
    <div class="logo">Estudo<span>Mind</span></div>
    <nav class="navbar">
        <ul>';
    foreach ($menuItems as $title => $link) {
        echo "<li><a href=\"$link\">$title</a></li>";
    }
    echo '</ul>
    </nav>
    <button class="btn-login">Login</button>
</header>';
}

function cursos()
{
    
}

$menuItems = [
    'Home' => '#home',
    'Cursos' => '#courses',
    'Benefícios' => '#benefits',
    'FAQ' => '#faq',
    'Contato' => '#contact'
];

Menu($menuItems);

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
        'image' => 'c-sharp.png'
    ],
    [
        'title' => 'Python',
        'image' => 'python.png'
    ],
    [
        'title' => 'C++',
        'image' => 'c-.png'
    ],


    [
        'title' => 'HTML',
        'image' => 'html.png'
    ],
    [
        'title' => 'JavaScript',
        'image' => 'js.png'
    ],
    [
        'title' => 'CSS',
        'image' => 'css-3.png'
    ],
    
    [
        'title'=> 'Java',   
        'image' => 'java.png'
    ],  
    [
        'title' => 'PHP',
        'image' => 'php.png'
    ],
    [
        'title' => 'ruby',
        'image' => 'ruby.png'
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


?>              