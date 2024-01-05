<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Session\Session;

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Mon profil - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
  <div id="profile_main">

    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <h1 class="username">
        <?= Session::getUserAccount()->getFirstname() ?>
        <?= Session::getUserAccount()->getLastname() ?>
      </h1>
    </div>

    <?php
    Storage::component("FooterComponent");
    ?>

  </div>
</body>
</html>