<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'items.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EstudoMind - Transforme sua Carreira</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/styles.css">
    <link rel="stylesheet" href="estilos/items.css">
    
</head>

<body>
    <!-- Header.php -->
    <?php
    Menu($menuItems);
    ?>
    <!-- Seção Hero -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Educação <span>Inovadora</span> para Todos</h1>
            <p>Transforme sua carreira com nossos cursos online exclusivos e acessíveis.</p>
            <a href="#courses" class="btn-primary">Ver Cursos</a>
        </div>
        <div class="scroll-indicator" aria-label="Scroll down">
            <span>Scroll</span>
            <i class="fas fa-arrow-down"></i>
        </div>
    </section>

    <!-- Destaques -->
    <section id="features" class="features">
        <h2>Destaques</h2>
        <div class="feature-list">
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

    <!-- Cursos -->
    <section id="courses" class="courses benefits">
        <h2>Nossos Cursos</h2>
        <div class="course-list">

            <?php

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

    <!-- Benefícios -->
    <section class="benefits" id="benefits">
        <h2>Benefícios Exclusivos</h2>
        <p>Descubra tudo o que você pode conquistar com nossos cursos online de alta qualidade.</p>
        <div class="benefits-container">
            <?php

            foreach ($benefits as $benefit) {
                echo '<div class="benefit-card">'
                    . '<i class="fas ' . $benefit['icon'] . '"></i>'
                    . '<h3>' . $benefit['title'] . '</h3>'
                    . '<p>' . $benefit['description'] . '</p>'
                    . '</div>';
            }
            ?>

    </section>

    <!-- FAQ -->
    <section class="faq" id="faq">
       
            <h2 class="faq-title">Perguntas Frequentes</h2>
            <p class="faq-subtitle">Tire suas dúvidas rapidamente com nosso FAQ.</p>
            <?php
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

    <!-- Contato -->
    <section class="contact" id="contact">
        <h2>Entre em Contato</h2>
        <p>Envie uma mensagem e entraremos em contato em breve!</p>
        <form id="contact-form" aria-label="Formulário de Contato">
            <input type="text" id="name" placeholder="Seu Nome" required aria-required="true" aria-label="Nome">
            <input type="email" id="email" placeholder="Seu E-mail" required aria-required="true" aria-label="E-mail">
            <textarea id="message" rows="5" placeholder="Sua Mensagem" required aria-required="true" aria-label="Mensagem"></textarea>
            <button type="submit" class="btn-primary">Enviar Mensagem</button>
        </form>
        <p class="form-feedback" id="form-feedback" aria-live="polite"></p>
    </section>


    <!-- Rodapé -->
    <?php Footer(); ?>
<div>
     <div class="wave"></div>
     <div class="wave"></div>
     <div class="wave"></div>
  </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');

                question.addEventListener('click', () => {
                    const isOpen = answer.classList.contains('show');

                    // Fecha todas as respostas
                    document.querySelectorAll('.faq-answer').forEach(ans => {
                        ans.classList.remove('show');
                        ans.classList.add('hide');
                    });
                    document.querySelectorAll('.faq-question').forEach(q => {
                        q.classList.remove('open');
                    });

                    // Se não estava aberta, mostra a resposta clicada
                    if (!isOpen) {
                        answer.classList.remove('hide');
                        answer.classList.add('show');
                        question.classList.add('open'); // Adiciona classe para rotação do ícone
                    }
                });

                // Permitir que a pergunta seja ativada com o teclado
                question.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault(); // Evita o deslocamento da página
                        question.click(); // Simula o clique
                    }
                });
            });
        });
    </script>


</body>

</html>