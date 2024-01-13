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
  <title>Les festivals - Festiplan</title>

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
  <div id="festivals_main">
      
    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="all_festivals">
        <div class="title-container">
          <h2 class="title">
          Tous les festivals
          </h2>

          <div class="buttons">
            <a href="<?= route("createFestival") ?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Créer un festival
              </button>
            </a>

            <a href="<?= route("profile") ?>#my_festivals">
              <button class="button-grey">
                <i class="fa-solid fa-champagne-glasses"></i>
                Mes festivals
              </button>
            </a>
          </div>
        </div>

        <div class="festivals-grid">

          <?php
          foreach ($festivals as $festival)
          {
              $isFestivalInProgress = $festival->isInProgress();
          ?>

          <a href="<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>">
            <div class="festival-preview">
              <div class="festival-picture<?= $isFestivalInProgress ? " border-in-progress" : "" ?>"
                  style="background: url('<?= $festival->getIllustration() ?>') center / cover no-repeat;">

                <?php if ($isFestivalInProgress) { ?>
                    <div class="filter-in-progress">
                      <p>en cours</p>
                    </div>
                <?php } ?>

              </div>

              <div class="festival-identity">
                <h3 class="festival-name">
                <?= $festival->getName() ?>
                </h3>

                <p class="festival-description">
                <?= $festival->getDescription() ?>
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
          <a href="<?= route("festivals") ?>?page=1">
            <i class="fa-solid fa-angles-left"></i>
          </a>

          <a href="<?= route("festivals") ?>?page=<?= $page - 1 ?>">
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
          <a href="<?= route("festivals") ?>?page=<?= $page + 1 ?>">
            <i class="fa-solid fa-angle-right"></i>
          </a>

          <a href="<?= route("festivals") ?>?page=<?= $pagesCount ?>">
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