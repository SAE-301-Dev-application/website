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
      <section id="festival">
        <div class="title-container no-mb">
          <h2 class="title">
            <?= $festival->getName() ?>
          </h2>

          <?php
          if ($festival->getGriJWithId() !== null)
          {
          ?>
          <div class="buttons">
            <a href="<?= route("generatePlanification") ?>?id=<?= $festival->getId()?>">
              <button class="button-blue">
                <i class="fa-regular fa-calendar-days"></i>
                Voir la planification
              </button>
            </a>

            <a href="#">
              <button class="button-grey">
                <i class="fa-solid fa-pen"></i>
                Modifier le festival
              </button>
            </a>
          </div>
          <?php
          }
          ?>
        </div>

        <p class="festival-categories">
          <?php
          $categoriesNames = [];

          foreach ($festival->getCategories() as $category)
          {
            $categoriesNames[] = $category->getName();
          }

          echo implode(', ', $categoriesNames);
          ?>
        </p>

        <div class="festival-grid">
          <div class="left-side">
            <div class="festival-picture
                        <?php
                        if ($festival->isInProgress())
                        {
                          echo "border-in-progress";
                        }
                        ?>"
                 style="background-image: url('<?= $festival->getIllustration() ?>');">

              <?php
              if ($festival->isInProgress())
              {
              ?>
              <div class="filter-in-progress">
                <p>
                  en cours
                </p>
              </div>
              <?php
              }
              ?>

            </div>

            <section id="grij">
              <div class="section-title-container short-size">
                <div class="left-side">
                  <h3 class="section-title">
                    Horaires des spectacles :
                  </h3>
                </div>
              </div>

              <p>
                <strong>
                  Début des spectacles :
                </strong>

                <?=
                $festival->getGriJWithId() !== null
                    ? $festival
                        ->getGriJWithId()[0]
                        ->getBeginningSpectacleHourWithFormat("%Hh%i")
                    : "non défini"
                ?>
              </p>

              <p>
                <strong>
                  Fin des spectacles :
                </strong>

                <?=
                $festival->getGriJWithId() !== null
                    ? $festival
                        ->getGriJWithId()[0]
                        ->getEndingSpectacleHourWithFormat("%Hh%i")
                    : "non défini"
                ?>
              </p>

              <p>
                <strong>
                  Durée des pauses :
                </strong>

                <?=
                $festival->getGriJWithId() !== null
                    ? $festival
                        ->getGriJWithId()[0]
                        ->getMinDurationBetweenSpectacleWithFormat("%H heure(s) %i minute(s)")
                    : "non défini"
                ?>
              </p>
            </section>
          </div>

          <div class="main-side">
            <section id="description">
              <div class="section-title-container">
                <div class="left-side">
                  <h3 class="section-title">
                    Description :
                  </h3>
                </div>
              </div>

              <div class="content">
                <div class="description">
                  <p>
                    <?= $festival->getDescription() ?>
                  </p>
                </div>

                <div class="duration">
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
              </div>
            </section>

            <section id="spectacles">
              <div class="section-title-container">
                <div class="left-side">
                  <h3 class="section-title">
                    Spectacles :
                  </h3>
                </div>

                <div class="right-side">
                  <div class="buttons">
                    <button class="button-grey">
                      <i class="fa-solid fa-angle-down"></i>
                      Voir tout (<?= count($festival->getSpectacles()) ?>)
                    </button>

                    <a href="<?= route("addSpectacle") ?>?festival=<?= $festival->getId() ?>"
                       target="_blank">
                      <button class="button-blue">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter un spectacle
                      </button>
                    </a>
                  </div>
                </div>
              </div>

              <div class="spectacles-grid">
                <?php
                foreach ($festival->getSpectacles() as $spectacle)
                {
                ?>
                <a href="<?= route("informationsSpectacle") ?>?id=<?= $spectacle->getId() ?>">
                  <div class="spectacle-card">
                    <div class="spectacle-picture"
                         style="background-image: url('<?= $spectacle->getIllustration() ?>')"></div>

                    <div class="spectacle-presentation">
                      <h4 class="spectacle-name">
                          <?= $spectacle->getTitle() ?>
                      </h4>

                      <p class="spectacle-location">
                        <i class="fa-solid fa-location-dot"></i>
                        spectacle_location
                      </p>
                    </div>
                  </div>
                </a>
                <?php
                }
                ?>
              </div>
            </section>

            <section id="organizers">
              <div class="section-title-container">
                <div class="left-side">
                  <h3 class="section-title">
                    Organisateurs :
                  </h3>
                </div>

                <div class="right-side">
                  <div class="buttons">
                    <a href="#">
                      <button class="button-grey">
                        <i class="fa-solid fa-angle-down"></i>
                        Voir tout (<?= count($festival->getOrganizers()) ?>)
                      </button>
                    </a>

                    <a href="<?= route("addOrganizer") ?>?festival=<?= $festival->getId() ?>">
                      <button class="button-blue">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter un organisateur
                      </button>
                    </a>
                  </div>
                </div>
              </div>

              <div class="organizers-grid">
                <?php
                
                foreach ($festival->getOrganizers() as $organizer)
                {
                ?>
                <div class="organizer-card">
                  <h4 class="organizer-name">
                    <?= $organizer->getFirstname() ?>
                    <?= $organizer->getLastname() ?>
                  </h4>

                  <p class="organizer-role">
                    <?= $festival->getOwner()->getId() == $organizer->getId()
                            ? "Responsable"
                            : "Organisateur"
                    ?>
                  </p>
                </div>
                <?php
                }
                ?>
              </div>
            </section>
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