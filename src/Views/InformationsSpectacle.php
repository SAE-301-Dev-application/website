<?php
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Models\Festival;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Les Spectacles - Festiplan</title>

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
  <div id="spectacle_main">
      
    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="all_festivals">
        <div class="title-container">
          <h2 class="title">
            <?= $spectacle->getTitle() ?>
          </h2>

          <a href="<?= route("")//TODO mettre la route ?>">
            <button class="button-blue">
              <i class="fa-solid fa-plus"></i>
              Voir la planification
            </button>
          </a>

          <a href="<?= route("")//TODO mettre la route ?>">
            <button class="button-blue">
              <i class="fa-solid fa-plus"></i>
              Modifier festival
            </button>
          </a>
        </div>
        <?php
        // Debug::dd($festival->getCategories());
            foreach ($spectacle->getCategories() as $categorie) {
                echo $categorie->getName()." ";
            }
        ?>

        <div class="festival-preview">
          <div style="background: url('<?= $spectacle->getIllustration() ?>') center / cover no-repeat;">

                <div class="filter-in-progress">
                  <p>en cours</p>
                </div>

          </div>
        </div>

        <h3>
          Description:
        </h3>
        <p>
          <?= $spectacle->getDescription() ?>
        </p>

        <h3>
          Intervenants:
        </h3>
        <a href="<?= route("")//TODO mettre la route ?>">
          <button class="button-blue">
            <i class="fa-solid fa-plus"></i>
            Voir plus
          </button>
        </a>

        <!-- Si l'utilisateur est le responsable du festival -->
        <a href="<?= route("")//TODO mettre la route ?>">
          <button class="button-blue">
            <i class="fa-solid fa-plus"></i>
            Ajouter organisateurs
          </button>
        </a>
        <?php
            foreach ($spectacle->getContributor() as $contributor) {
                echo $contributor->getLastname() . " " . $contributor->getFirstname(). ", ";
            }
        ?>
      </section>
    </div>

    <?php
    Storage::component("FooterComponent");
    ?>

  </div>
</body>
</html>