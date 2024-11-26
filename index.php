<?php
// Inicia a sessão, caso ainda não esteja ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Importa itens necessários para a página
require_once 'items/items.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Meta tags essenciais -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstudoMind - Transforme sua Carreira</title>

    <!-- Importação de fontes e ícones -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/styles.css" media="all">
    <link rel="stylesheet" href="estilos/media-query/mq-index.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

    <!-- Fallback de fonte padrão -->
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
        }
    </style>
</head>

<body>
    <!-- Menu de navegação dinâmico -->
    <?php Menu($menuItems); ?>

    <!-- Seção Hero: introdução principal do site -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Educação <span>Inovadora</span> para Todos</h1>
            <p>Transforme sua carreira com nossos cursos online exclusivos e acessíveis.</p>
            <a href="#courses" class="btn-primary">Ver Cursos</a>
        </div>
        <!-- Indicador visual para rolar a página -->
        <div class="scroll-indicator" aria-label="Scroll down">
            <span>Scroll</span>
            <i class="fas fa-arrow-down"></i>
        </div>
    </section>

    <!-- Seção de Destaques -->
    <section id="features" class="features">
        <h2>Destaques</h2>
        <div class="feature-list">
            <!-- Cada item representa um destaque -->
            <div class="feature-item">
                <i class="fas fa-globe"></i>
                <h3>Acesso Global</h3>
                <p>Estude onde e quando quiser, sem limites.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-certificate"></i>
                <h3>Certificação Valiosa</h3>
                <p>Ganhe certificados reconhecidos pelo mercado.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-user-friends"></i>
                <h3>Comunidade Ativa</h3>
                <p>Faça networking com estudantes e profissionais.</p>
            </div>
        </div>
    </section>

    <!-- Seção de Cursos -->
    <section id="courses" class="courses benefits">
        <h2>Nossos Cursos</h2>
        <div class="course-list">
            <?php
            // Gera dinamicamente cartões de cursos com base nos dados do array $cursos
            foreach ($cursos as $course) {
                if (isset($course['image']) && isset($course['title'])) {
                    echo '<div class="course-card">';
                    echo '<img src="img-cursos/' . $course['image'] . '" alt="' . $course['title'] . '">';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>

    <!-- Seção de Benefícios -->
    <section class="benefits" id="benefits">
        <h2>Benefícios Exclusivos</h2>
        <p>Descubra tudo o que você pode conquistar com nossos cursos online de alta qualidade.</p>
        <div class="benefits-container">
            <?php
            // Exibe cartões de benefícios dinamicamente
            foreach ($benefits as $benefit) {
                echo '<div class="benefit-card">'
                    . '<i class="fas ' . $benefit['icon'] . '"></i>'
                    . '<h3>' . $benefit['title'] . '</h3>'
                    . '<p>' . $benefit['description'] . '</p>'
                    . '</div>';
            }
            ?>
        </div>
    </section>

    <!-- Seção de Perguntas Frequentes -->
    <section class="faq" id="faq">
        <h2 class="faq-title">Perguntas Frequentes</h2>
        <p class="faq-subtitle">Tire suas dúvidas rapidamente com nosso FAQ.</p>
        <?php
        // Renderiza as perguntas e respostas dinamicamente
        foreach ($faqs as $faq) {
            if (isset($faq['question']) && isset($faq['answer'])) {
                echo '
                <div class="faq-item">
                    <h3 class="faq-question" tabindex="0">
                        ' . $faq['question'] . '
                        <span class="faq-icon" aria-hidden="true">&#x25BC;</span>
                    </h3>
                    <div class="faq-answer">
                        ' . $faq['answer'] . '
                    </div>
                </div>
                ';
            }
        }
        ?>
    </section>

    <!-- Seção de Contato -->
    <section class="contact" id="contact">
        <h2>Entre em Contato</h2>
        <p>Envie uma mensagem e entraremos em contato em breve!</p>
        <form id="contact-form" aria-label="Formulário de Contato">
            <!-- Campos do formulário com atributos de acessibilidade -->
            <input type="text" id="name" placeholder="Seu Nome" required aria-required="true" aria-label="Nome">
            <input type="email" id="email" placeholder="Seu E-mail" required aria-required="true" aria-label="E-mail">
            <textarea id="message" rows="5" placeholder="Sua Mensagem" required aria-required="true" aria-label="Mensagem"></textarea>
            <button type="submit" class="btn-primary">Enviar Mensagem</button>
        </form>
        <p class="form-feedback" id="form-feedback" aria-live="polite"></p>
    </section>

    <!-- Rodapé -->
    <?php Footer(); ?>

    <!-- Animação de ondas no rodapé -->
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <!-- Script para o comportamento da seção FAQ -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("menu-toggle").addEventListener("click", function() {
            const navbar = document.querySelector(".navbar");
            navbar.classList.toggle("active");
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');

                // Alterna entre mostrar e esconder a resposta ao clicar
                question.addEventListener('click', () => {
                    const isOpen = answer.classList.contains('show');

                    // Fecha todas as respostas antes de abrir a nova
                    document.querySelectorAll('.faq-answer').forEach(ans => {
                        ans.classList.remove('show');
                        ans.classList.add('hide');
                    });
                    document.querySelectorAll('.faq-question').forEach(q => {
                        q.classList.remove('open');
                    });

                    // Abre a resposta clicada, se não estiver aberta
                    if (!isOpen) {
                        answer.classList.remove('hide');
                        answer.classList.add('show');
                        question.classList.add('open');
                    }
                });

                // Suporte para ativação via teclado
                question.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        question.click();
                    }
                });
            });
        });
    </script>
</body>

</html>