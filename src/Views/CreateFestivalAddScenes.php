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

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<body>
<div id="add-scene">
    <?php
    Storage::component("HeaderComponent");
    ?>

  <div id="main">
    <section id="add-scene">
      <div class="title-container">
        <h2 class="title">
          Ajouter des scènes
        </h2>
      </div>

      <div class="form-container">
        <form action="<?= route("festivals") ?>"
              method="post"
              enctype="multipart/form-data">
          <div class="form-grid">
            <section id="general_information">
              <div class="form-duo">
                <div class="form-component">

                  <label for="scenes">
                    <p>
                      Rechercher une scène :
                    </p>
                    <input type="text" name="scenes" id="scenes"/>

                  </label>
                </div>

                <div class="form-component">
                  <button class="button-blue">
                    Rechercher
                  </button>
                </div>

                <div class="form-component">
                  <p class="scene">
                    Scene 1
                  </p>
                </div>

                <div class="form-component">
                  <button class="button-red" id="suppress1" name="suppress1">
                    Supprimer
                  </button>
                </div>

                <div class="form-component">
                  <p class="scene">
                    Scene 2
                  </p>
                </div>

                <div class="form-component">
                  <button class="button-red">
                    Supprimer
                  </button>
                </div>

                <div class="form-component">
                  <p class="scene">
                    Scene 3
                  </p>
                </div>

                <div class="form-component">
                  <button class="button-red">
                    Supprimer
                  </button>
                </div>
              </div>
            </section>

              <?php
              Storage::component("FormHelpBoxComponent", [
                  "icon" => "fa-regular fa-question-circle",
                  "title" => "Ajouter une scène au festival",
                  "content"
                  => "<p>
                            Pour ses représentations, un festival nécessite des scènes. Autrement dit, des lieux 
                            de représentations de spectacles. <br />
                          </p>
                            
                           Saisissez le nom de la scène et sélectionnez parmi les résultats de recherche présentés.<br/>
                            Vous pouvez, d’autre part, retirer des scènes de votre sélection en <br/>
                            cliquant sur son bouton Supprimer.
                          </p>",
              ]);
              ?>
          </div>

          <div class="buttons">
            <a href="<?= route("createFestival") ?>">
              <button class="button-grey" type="button">
                Annuler
              </button>
            </a>

            <button class="button-blue" type="submit">
              Ajouter les scènes
            </button>
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