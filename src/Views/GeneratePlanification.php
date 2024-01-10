<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\DevelomentUtilities\Debug;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Génération de la planification - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>
  <script src="/website/node_modules/fullcalendar/index.global.min.js" defer></script>

  <?php
  Storage::include("Js/planification/generation.js", importMethod: "defer");
  ?>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div id="generate_planification_main">

  <?php
  Storage::component("HeaderComponent");
  ?>

  <div id="main">
    <section id="planification">
      <div class="title-container">
        <h2 class="title">
          Génération de la planification
        </h2>

      </div>

      <div class="calendar-container">
        <div id='calendar'></div>
      </div>
    </section>
  </div>

  <?php
  Storage::component("FooterComponent");
  ?>

</div>
</body>
</html>