<?php
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Models\Festival;
use MvcLite\Models\User;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Informations d'un festival - Festiplan</title>

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
  <div id="informations_festival_main">
      
    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="festival_informations">
        <div class="title-container">
          <h2 class="title">
            <?= $festival->getName() ?>
          </h2>

          <a href="<?= route("generatePlanification") ?>?id=<?= $festival->getId()?>">
            <button class="button-blue">
              <i class="fa-solid fa-plus"></i>
              Voir la planification
            </button>
          </a>
          
          <!-- Si l'utilisateur est responsable du festival -->
          <?php if (false && $festival->isUserOwner()) { ?>
            <!-- <a href="<?= "" // route("modifyFestival")?>?id=<?= "" // $festival->getId()?>"> -->
              <!-- <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Modifier festival
              </button> -->
            <!-- </a> -->
          <?php } ?>
        </div>

        <div class="form-container">
          <div class="left-side">
            <p class="categories">
              (<?php
                // Debug::dd($festival->getCategories());
                foreach ($festival->getCategories() as $categorie) {
                    echo $categorie->getName();
                    if ($categorie != $festival->getCategories()[count($festival->getCategories())-1]) {
                      echo ", ";
                    }
                }

                $isFestivalInProgress = $festival->isFestivalInProgress();
              ?>)
            </p>

            <div class="festival-preview">
              <div class="festival-picture<?= $isFestivalInProgress ? " border-in-progress" : "" ?>"
                  style="background: url('<?= $festival->getIllustration() ?>') center / cover no-repeat;">

                <?php if ($isFestivalInProgress) { ?>
                  <div class="filter-in-progress">
                    <p class="in-progress">en cours</p>
                  </div>
                <?php } ?>
              </div>
            </div>

            <h3 class="subtitle">
              GriJ :
            </h3>

            <div class="grij-grid">
              <div class="grij-colums">
                <p class="grij-column">
                  Début des spectacles :
                </p>
                <p class="grij-column">
                  Fin des spectacles :
                </p>
                <p class="grij-column">
                  Durée des pauses :
                </p>
              </div>

              <div class="grij-values">
                <p class="beginning grij-value">
                  15h00
                </p>
                <p class="ending grij-value">
                  22h00
                </p>
                <p class="duration grij-value">
                  60 minutes
                </p>
              </div>
            </div>
          </div>

          <div class="right-side">
            <div class="festival-data-row">
              <div class="description-container">
                <h3 class="subtitle">
                  Description :
                </h3>

                <p class="description-value">
                  <?= $festival->getDescription() ?>
                </p>
              </div>

              <div class="dates-container">
                  test
              </div>
            </div>

            <h3 class="subtitle">
              Spectacles :
            </h3>

            <!-- <a href="<?= "" // route("informationsSpectacle")//TODO mettre la route ?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Voir plus
              </button>
            </a> -->

            <!-- Si l'utilisateur est le responsable du festival -->
            <?php if ($festival->isUserOwner()) { ?>
              <a href="<?= route("")//TODO mettre la route ?>">
                <button class="button-blue">
                  <i class="fa-solid fa-plus"></i>
                  Ajouter spectacles
                </button>
              </a>
            <?php } ?>

            <?php
            //foreach ($festival->getSpectacles() as $spectacle) {?>

              <!-- <a href="<?= "" // route("informationsSpectacle") ?>?id=<?= "" // $spectacle->getId() ?>">
                <div class="festival-preview">
                  <div class="festival-picture"
                    style="background: url('<?= "" // $spectacle->getIllustration() ?>') center / cover no-repeat;">
                  </div>
                </div>
                <?= "" //$spectacle->getTitle(); ?>
              </a> -->

            <?php
              //}
            ?>

            <!-- <h3>
              Scènes:
            </h3> -->
            <!-- <a href="<?= "" // route("")//TODO mettre la route ?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Voir plus
              </button>
            </a> -->
            <!-- Si l'utilisateur est responsable du festival -->
            <?php if (false && $festival->isUserOwner()) { ?>
              <!-- <a href="<?= route("addScene")?>?festival=<?= $festival->getId() ?>">
                <button class="button-blue">
                  <i class="fa-solid fa-plus"></i>
                  Ajouter scènes
                </button>
              </a> -->
            <?php } ?>

            <?php
              // Debug::dd($festival->getCategories());
              // foreach ($festival->getScenes() as $scene) {
              ?>
            
            <!-- <div> -->
              <?php 
                // $size = $scene->getSize();

                // switch($scene->getSize()) {
                //   case 1:
                //     $size = "Petite";
                //     break;
                //   case 2:
                //     $size = "Moyenne";
                //     break;
                //   case 3:
                //     $size = "Grande";
                //     break;

                // }
                // echo $scene->getName()." (".$size.")";     
                // }
              ?>
            <!-- </div> -->

            <!-- <h3>
              Organisateurs:
            </h3> -->
            <!-- <a href="<?= "" // route("")//TODO mettre la route ?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Voir plus
              </button>
            </a> -->

            <!-- Si l'utilisateur est le responsable du festival -->
            <?php if (false && $festival->isUserOwner()) { ?>
            <a href="<?= route("")//TODO mettre la route ?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Ajouter organisateurs
              </button>
            </a>
            <?php } ?>
            <?php

              // $owner = $festival->getOwner();

              // echo $owner->getFirstname()." ".$owner->getLastname()."<br>".$owner->getLogin()."<br>Responsable<br><br>";

              // foreach ($festival->getOrganizers() as $user) {

              //   echo $user->getFirstname()." ".$user->getLastname()."<br>".$user->getLogin()."<br>Organisateur<br>";

              // }
            ?>
          </div>
        </div>
      </section>
    </div>

    <?php
    Storage::component("FooterComponent");
    ?>

  </div>
</body>
</html>