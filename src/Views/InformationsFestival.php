<?php
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Models\Festival;

$festivalsUploadsPath = Storage::getResourcesPath() . "/Medias/Images/FestivalsUploads/";
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
            <!-- A rendre dynamique -->
            <?= $name ?>
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
        <!-- A rendre dynamique -->
        <?php
            foreach ($categories as $categorie) {
                echo $categorie;
            }
        ?>
        
        <div>
          <!-- A rendre dynamique -->
          <img src="<?= $festivalsUploadsPath . $illustration ?>" alt="logo du festival">

        </div>









        <div class="festivals-grid">

          <?php for ($i = $startIndex, $count = 1;
                     $count <= 6 && $i < count($festivals);
                     $i++, $count++) {
          
          $isFestivalInProgress = $festivals[$i]["en_cours_fe"] === 1;
          ?>

          <a href="<?= route("dashboard") ?>"> <!--?festival=<?= ""//$festivals[$i]["id_festival"] ?>"> TODO changer pour page festival -->
            <div class="festival-preview">
              <div class="festival-picture<?= $isFestivalInProgress ? " border-in-progress" : "" ?>"
                  style="background: url('<?= Festival::getImagePathByName($festivals[$i]["illustration_fe"]) ?>') center / cover no-repeat;">
                <?php if ($isFestivalInProgress) { ?>
                <div class="filter-in-progress">
                  <p>en cours</p>
                </div>
                <?php } ?>
              </div>

              <div class="festival-identity">
                <h3 class="festival-name">
                <?= $festivals[$i]["nom_fe"] ?>
                </h3>

                <p class="festival-description">
                <?= $festivals[$i]["description_fe"] ?>
                </p>
              </div>
            </div>
          </a>

          <?php } ?>

        </div>
      </section>

      <div class="pagination">
        <div class="previous-links<?= $previousVisibility ?>">
          <a href="<?= route("festivals") ?>?indice=0">
            <i class="fa-solid fa-angles-left"></i>
          </a>

          <a href="<?= route("festivals") ?>?indice=<?= $startIndex - 6 ?>">
            <i class="fa-solid fa-angle-left"></i>
          </a>
        </div>

        <div class="next-links<?= $nextVisibility ?>">
          <a href="<?= route("festivals") ?>?indice=<?= $startIndex + 6 ?>">
            <i class="fa-solid fa-angle-right"></i>
          </a>

          <a href="<?= route("festivals") ?>?indice=<?= $indexLastPage ?>">
            <i class="fa-solid fa-angles-right"></i>
          </a>
        </div>
      </div>
    </div>

    <?php
    Storage::component("FooterComponent");
    ?>

  </div>
</body>
</html>