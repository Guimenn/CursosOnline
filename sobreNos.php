<?php
session_start();
include 'items/items.php';
include 'items/courses.php';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Importação de fontes do Google e ícones FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Importação de estilos principais e de media queries -->
    <link rel="stylesheet" href="estilos/sobreNos.css">
    <link rel="stylesheet" href="estilos/items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-items.css">
    <link rel="stylesheet" href="estilos/media-query/mq-sobrenos.css">
    <!-- Biblioteca de animação ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <!-- Favicon do site -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

    <title>Sobre Nós - EstudoMind</title>
</head>

<body>
    <?php
    Menu($menuItems);
    ?>
    <main>
        <section class="portifolio">
            <h2>O "Estudo<span style="color: var(--cor1);"> Mind"</span></h2>
        </section>
        <section class="mid_1">
            <div>
                <div class="title">
                    <h3>Nossos cursos online!</h3>
                    <p>Explore o futuro da educação! Nossos cursos online são gratuitos, acessíveis e projetados para oferecer as ferramentas que você precisa para alcançar seus objetivos pessoais e profissionais.</p>
                </div>
                <div class="content-mid_1">
                    <h3>Aprenda no seu ritmo, do jeito que você quiser</h3>
                    <p>Você já parou para pensar no quanto aprender pode mudar a sua vida? Com os nossos cursos online gratuitos, essa mudança está ao seu alcance! Estude quando e onde quiser, no seu ritmo, e tenha acesso a um vasto catálogo de conteúdos desenvolvidos para transformar sonhos em realidade.</p>

                    <div class="mid_1-comentario">
                        <p>"O conhecimento é o melhor investimento que você pode fazer, pois seus rendimentos são ilimitados."</p>
                    </div>
                    <p>Nossos cursos foram criados para atender a todas as idades, níveis e áreas de interesse. É hora de investir em você mesmo!</p>
                </div>

            </div>
        </section>
        <section class="mid_2">
            <div class="title2">

                <h3>Por que<br> escolher<br> nossos<br> cursos?</h3>
                <img src="img/porque.png" alt="">
            </div>
            <div class="mid_2-cards">
                <?php
                foreach ($mid2cards as $card) {
                    echo '<article>
                                <i class="' . $card['icon'] . '"></i>
                                <h4>' . $card['title'] . '</h4>
                                <p>' . $card['texto'] . '</p>
                            </article>';
                }

                ?>
                <!--
                <article>
                    <h4>Totalmente Acessíveis</h4>
                    <p>Com uma conexão à internet, você tem o mundo do aprendizado ao alcance das suas mãos. Estude do celular, tablet ou computador, sem precisar sair de casa ou gastar com transporte.</p>
                </article>
                <article>
                    <h4>Certificação Garantida</h4>
                    <p>Conclua o curso e receba um certificado digital sem custo adicional! Com ele, você pode provar suas novas habilidades e abrir portas no mercado de trabalho.</p>
                </article>
                <article>
                    <h4>Materiais Exclusivos</h4>
                    <p>Desenvolvemos cada curso com carinho e atenção aos detalhes, garantindo que você tenha acesso ao melhor conteúdo, organizado e prático para facilitar o aprendizado.</p>
                </article>
-->
            </div>
        </section>
        <section class="mid_3">
            <h3>O que nossos cursos oferecem?</h3>
            <div class="mid_3-content">

                <?php
                foreach ($cardsobrenos as $card) {
                    echo '<article class="type">
                            <h4>' . $card['title'] . '</h4>
                            <p>' . $card['texto'] . '</p>
                        </article>';
                }

                ?>
            </div>

        </section>
        <section class="mid_4">
            <h3>Depoimentos de quem já fez parte dessa jornada</h3>
            <div class="comentarios">
                <div class="comentarios-img"><img src="img/comentarios.png" alt=""></div>
                <ul>

                    <?php
                    foreach ($comentarios as $comentario) {
                        echo '<li class="coment_user">
                                   
                                    <div class="coment_user-img">
                                     <h5>' . $comentario['nome'] . '</h5>
                                        <p>"' . $comentario['mensagem'] . '"</p>
                                        <img src="./img/user-interface.png" alt="">
                                    </div>
                                </li>';
                    }
                    ?>

                </ul>
            </div>
        </section>
        <section class="mid_5">
            <h3>Nossas vantagens!</h3>
            <div class="mid_5-vants">
                <ul>
                    <?php
                    foreach ($vantagens as $vantagem) {
                        echo '<li>
                            <i class="' . $vantagem['icon'] . '"></i>
                            <p><strong>' . $vantagem['title'] . ':</strong><br>' . $vantagem['texto'] . '</p>
                        </li>';
                    }

                    ?>
                </ul>
            </div>
        </section>



    </main>
    <?php Footer(); ?>
    <script src="js/menu.js"></script>
    <script>
        ScrollReveal({
            duration: 300
        });

        const elements = ['.mid_1', '.mid_3', '.mid_5'];
        const elementos = ['.mid_2-card', '.mid_4'];

        elements.forEach((element) => {
            ScrollReveal().reveal(element, {
                duration: 1000,
                distance: '50px',
                easing: 'ease-in-out',
                origin: 'left'
            });
        });
        elementos.forEach((elemento) => {
            ScrollReveal().reveal(elemento, {
                duration: 1000,
                distance: '100px',
                easing: 'ease-in-out',
                origin: 'right'
            });
        });
    </script>
</body>

</html>