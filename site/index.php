<?php
include("cursos.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Card HTML + CSS</title>

  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,600;1,200;1,400;1,600&display=swap"
    rel="stylesheet" />
    <link rel="stylesheet" href="index.css" />
</head>

<body>

  <main>
    <section>
      <div class="fundo">
        <div class="titulo">
          <h1>Nossos cursos</h1>
     
        </div>
      </div>
    </section>

  
    <div class="neon-border">




      <?php
      foreach ($cursos as $curso) {

        foreach ($curso as $linguagemdeprogramacao) {
          echo '<div class="row">';
          foreach ($linguagemdeprogramacao as $modulodoscursos => $valoresdosmodulos) {
            echo '
            <div class="card '. $valoresdosmodulos['cor'] .'">
              <h2>' . $modulodoscursos . '</h2>
              <p>' . $valoresdosmodulos['descricao'] . '</p>
              <img class="image" src="' . $valoresdosmodulos['image'] . '" alt="" class="'. $valoresdosmodulos['cor'] .'" />
              <button class="button '. $valoresdosmodulos['cor'] .'">Ver curso </button>
            </div>
            ';
          }
          echo '</div>';
        }
      }
      ?>
    </div>
</main>
</body>
</html>