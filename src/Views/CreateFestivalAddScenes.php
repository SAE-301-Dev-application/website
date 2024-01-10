<?php

use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\DevelopmentUtilities\Debug;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ajouter une scène - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>

  <?php
  Storage::include("Js/async/ajax.js", importMethod: "defer");
  ?>

  <script defer>
    ajax("post", "<?= route("removeScene") ?>")
  </script>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div id="add-scene">
  <?php
  Storage::component("PopupComponent", [
      "id"    => "search_scene_popup",
      ""
  ]);

  Storage::component("HeaderComponent");
  ?>

  <div id="main">
    <section id="add-scene">
      <div class="title-container">
        <h2 class="title">
          Ajouter des scènes
        </h2>

        <a href="<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>" target="_blank">
          <button class="button-grey">
            <i class="fa-solid fa-eye"></i>
            Voir le festival
          </button>
        </a>
      </div>

      <div class="form-container">
        <form action="<?= route("festivals") ?>"
              method="post"
              enctype="multipart/form-data">

          <div class="form-grid">
              <div class="main-container">
                <section id="search_scene">
                  <div class="form-component">
                    <label for="search_scene_input">
                      <p>
                        Rechercher une scène :
                      </p>

                      <div class="form-input-button">
                        <input type="text" name="search_scene" id="search_scene_input" />

                        <button class="button-blue">
                          <i class="fa-solid fa-magnifying-glass"></i>
                          Rechercher
                        </button>
                      </div>
                    </label>
                  </div>
                </section>

                <section id="current_scenes">
                  <?php
                  foreach ($festival->getScenes() as $scene)
                  {
                  ?>
                  <div class="scene-container">
                    <div class="scene-information">
                      <h3 class="scene-name">
                          <?= $scene->getName() ?>
                      </h3>
                      
                      <ul class="scene-details">
                        <li>
                          <i class="fa-solid fa-location-dot fa-fw"></i>
                          Longitude : <?= $scene->getLongitude() ?> /
                          Latitude : <?= $scene->getLatitude() ?>
                        </li>

                        <li>
                          <i class="fa-solid fa-up-right-and-down-left-from-center fa-fw"></i>
                          Taille :
                          <?php
                          switch ($scene->getSize())
                          {
                              case 1:
                                echo "petite";
                                break;

                              case 2:
                                echo "moyenne";
                                break;

                              case 3:
                                echo "grande";
                                break;

                              default:
                                echo "inconnue";
                                break;
                          }
                          ?>
                        </li>

                        <li>
                          <i class="fa-solid fa-chair fa-fw"></i>
                          Nombre de places :
                          <?= $scene->getMaxSeats() ?>
                        </li>
                      </ul>
                    </div>

                    <button class="button-red">
                      <i class="fa-solid fa-trash"></i>
                      Supprimer
                    </button>
                  </div>
                  <?php
                  }
                  ?>
                </section>
              </div>

              <?php
              Storage::component("FormHelpBoxComponent", [
                  "icon" => "fa-regular fa-question-circle",
                  "title" => "Ajouter une scène au festival",
                  "content"
                  => "<p>
                        Pour ses représentations, un festival nécessite des scènes. Autrement dit, des lieux 
                        de représentations de spectacles.
                      </p>
                        
                      <p>
                        Saisissez le nom de la scène et sélectionnez parmi les résultats de recherche présentés.
                      </p>
                      
                      <p>
                        Vous pouvez, d’autre part, retirer des scènes de votre sélection en
                        cliquant sur son bouton Supprimer.
                      </p>",
              ]);
              ?>
          </div>

        </form>
      </div>
    </section>
  </div>

  <?php
  Storage::component("FooterComponent");
  ?>
</div>
</body>
</html>