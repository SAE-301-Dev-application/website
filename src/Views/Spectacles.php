<?php
use MvcLite\Engine\InternalResources\Storage;

$page = $props->getRequest()->getParameter("page") ?? 1;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Les spectacles - Festiplan</title>

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
  <div id="spectacles_main">
      
    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="all_spectacles">
        <div class="title-container">
          <h2 class="title">
          Tous les spectacles
          </h2>

          <a href="<?= route("createSpectacle") ?>">
            <button class="button-blue">
              <i class="fa-solid fa-plus"></i>
              Créer un spectacle
            </button>
          </a>
        </div>

        <div class="spectacles-grid">

          <?php
          foreach ($spectacles as $spectacle)
          {
          ?>

          <a href="<?= route("dashboard") ?>"> <!--?id=<?= ""//$spectacles[$i]->getId() ?>"> TODO changer pour page spectacle -->
            <div class="spectacle-preview">
              <div class="spectacle-picture"
                   style="background: url('<?= $spectacle->getIllustration() ?>') center / cover no-repeat;">
              </div>

              <div class="spectacle-identity">
                <h3 class="spectacle-title">
                <?= $spectacle->getTitle() ?>
                </h3>

                <p class="spectacle-description">
                <?= $spectacle->getDescription() ?>
                </p>
              </div>
            </div>
          </a>

          <?php } ?>

        </div>
      </section>

      <div class="pagination">
        <div class="previous-links">
          <?php
          if ($page > 1)
          {
          ?>
          <a href="<?= route("spectacles") ?>?page=1">
            <i class="fa-solid fa-angles-left"></i>
          </a>

          <a href="<?= route("spectacles") ?>?page=<?= $page - 1 ?>">
            <i class="fa-solid fa-angle-left"></i>
          </a>
          <?php
          }
          ?>
        </div>

        <div class="next-links">
          <?php
          if ($page < $pagesCount)
          {
          ?>
          <a href="<?= route("spectacles") ?>?page=<?= $page + 1 ?>">
            <i class="fa-solid fa-angle-right"></i>
          </a>

          <a href="<?= route("spectacles") ?>?page=<?= $pagesCount ?>">
            <i class="fa-solid fa-angles-right"></i>
          </a>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <?php
    Storage::component("FooterComponent");
    ?>

  </div>
</body>
</html>