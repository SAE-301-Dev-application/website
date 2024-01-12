<?php
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Models\Festival;
use MvcLite\Models\Grij;
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

          <?php if (Grij::getGriJByFestivalId($festival->getId()) !== null) { ?>
            <a href="<?= route("generatePlanification") ?>?id=<?= $festival->getId()?>">
              <button class="button-blue">
                <i class="fa-solid fa-plus"></i>
                Voir la planification
              </button>
            </a>
          <?php } ?>
          
          <!-- Si l'utilisateur est responsable du festival -->
          <?php if ($festival->isUserOwner()) { ?>
            <div class="buttons">
              <a href="<?= route("modifyFestival")?>?id=<?= $festival->getId()?>">
                <button class="button-blue">
                  <i class="fa-solid fa-plus"></i>
                  Modifier festival
                </button>
              </a>
            </div>
          <?php } ?>
        </div>

        <div class="form-container">
          <div class="left-side">
            <p class="categories">
              (<?php
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

            <div class="grij-title-row">
              <div class="grij-title">
                <h3 class="subtitle">
                  GriJ :
                </h3>
              </div>
              
              <!-- N'est pas dans la maquette -->
              <!-- <div class="add-button">
                <a href="<?= route("grijFestival")?>?id=<?= $festival->getId()?>">
                  <button class="button-blue">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter GriJ
                  </button>
                </a>
              </div> -->
            </div>

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
                  <?= $grij !== null ?
                      $grij->getBeginningSpectacleHourWithFormat("%Hh%i") :
                      "non défini"?>
                </p>
                <p class="ending grij-value">
                  <?= $grij !== null ?
                      $grij->getEndingSpectacleHourWithFormat("%Hh%i") : 
                      "non défini" ?>
                </p>
                <p class="duration grij-value">
                  <?= $grij !== null ?
                      $grij->getMinDurationBetweenSpectacleWithFormat("%H heure(s) %i minute(s)") :
                      "non défini" ?>
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
                  <?= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras volutpat nisl libero, et bibendum dolor mattis at. Aenean tincidunt sit amet neque vitae varius. Aenean a pulvinar risus. In dignissim faucibus urna, et bibendum elit luctus in. In hac habitasse platea dictumst. Vivamus risus ligula, viverra vel maximus a, tincidunt et augue. Sed leo nisl, euismod id ni"//$festival->getDescription() ?>
                </p>
              </div>

              <div class="festival-duration">
                <div class="beginning-date">
                <?= $festival->getBeginningDateWithFormat("%d %b. %Y") ?>
                </div>

                <div class="duration-arrow">
                <svg width="61" height="19" viewBox="0 0 61 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L30.5 17.5L60.1045 1" stroke="#686868"/>
                </svg>
                </div>

                <div class="ending-date">
                <?= $festival->getEndingDateWithFormat("%d %b. %Y") ?>
                </div>
              </div>
            </div>

            <div class="spectacles-container">
              <div class="spectacles-title-row">
                <div class="data-title">
                  <h3 class="subtitle">
                    Spectacles :
                  </h3>
                </div>

                <div class="buttons">
                  <a href="<?= route("") // TODO mettre la route ?>">
                    <button class="button-blue">
                      <i class="fa-solid fa-plus"></i>
                      Voir plus
                    </button>
                  </a>

                  <!-- Si l'utilisateur est le responsable du festival -->
                  <?php if ($festival->isUserOwner()) { ?>
                    <a href="<?= route("")//TODO mettre la route ?>">
                      <button class="button-blue">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter spectacles
                      </button>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <div class="spectacles-grid">
                <?php
                foreach ($festival->getSpectaclesWithLimit(5) as $spectacle) {?>

                  <div>
                    <a href="<?= route("informationsSpectacle") ?>?id=<?= $spectacle->getId() ?>">
                      <div class="festival-preview">
                        <div class="festival-picture"
                          style="background: url('<?= $spectacle->getIllustration() ?>') center / cover no-repeat;">
                        </div>
                      </div>
                      <?= $spectacle->getTitle(); ?>
                    </a>
                  </div>

                <?php
                }
                ?>
              </div>
            </div>

            <div class="scenes-container">
              <div class="spectacles-title-row">
                <div class="data-title">
                  <h3 class="subtitle">
                    Scènes :
                  </h3>
                </div>
                
                <div class="buttons">
                  <a href="<?= route("")//TODO mettre la route ?>">
                    <button class="button-blue">
                      <i class="fa-solid fa-plus"></i>
                      Voir plus
                    </button>
                  </a>

                  <!-- Si l'utilisateur est responsable du festival -->
                  <?php if ($festival->isUserOwner()) { ?>
                    <a href="<?= route("addScene")?>?festival=<?= $festival->getId() ?>">
                      <button class="button-blue">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter scènes
                      </button>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <div class="scenes-grid">
                <?php
                foreach ($festival->getScenesWithLimit(6) as $scene) {
                  $size = $scene->getSize();

                  switch ($scene->getSize()) {
                    case 1:
                      $size = "Petite";
                      break;
                    case 2:
                      $size = "Moyenne";
                      break;
                    case 3:
                      $size = "Grande";
                      break;

                  }

                  echo "<div class=\"name\">";
                  echo $scene->getName()." (".$size.")";
                  echo "</div>";
                }
                ?>
              </div>
            </div>

            <div class="users-container">
              <div class="users-title-row">
                <div class="data-title">
                  <h3 class="subtitle">
                    Organisateurs :
                  </h3>
                </div>
                
                <div class="buttons">
                  <a href="<?= route("")//TODO mettre la route ?>">
                    <button class="button-blue">
                      <i class="fa-solid fa-plus"></i>
                      Voir plus
                    </button>
                  </a>

                  <!-- Si l'utilisateur est responsable du festival -->
                  <?php if ($festival->isUserOwner()) { ?>
                    <a href="<?= route("")?>?festival=<?= $festival->getId() ?>">
                      <button class="button-blue">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter organisateurs
                      </button>
                    </a>
                  <?php } ?>
                </div>
              </div>

              <div class="users-grid">
                <?php
                  $owner = $festival->getOwner();

                  echo $owner->getFirstname()." ".$owner->getLastname()."<br>".$owner->getLogin()."<br>Responsable<br><br>";

                  foreach ($festival->getOrganizersWithLimit(2) as $user) {
                ?>
                  
                  <div class="name">
                    <?= $user->getFirstname() . " " . $user->getLastname() ?>
                  </div>

                  <div class="login">
                    <?= $user->getLogin() ?>
                  </div>
                  
                  <div class="role">
                    Organisateur
                  </div>

                <?php } ?>
              </div>
            </div>
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