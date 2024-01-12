<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\DevelopmentUtilities\Debug;

$errors = $props->getValidator()->getErrors() ?? [];

$beginningHour = $grij->getBeginningSpectacleHour();

$endingHour = $grij->getEndingSpectacleHour();

$pauseValue = $grij->getMinDurationBetweenSpectacle();

// $beginningHour = $props->getRequest()->getInput("beginning_hour") ?? "";

// $endingHour = $props->getRequest()->getInput("ending_hour") ?? "";

// $pauseValue = $props->getRequest()->getInput("pause_value") ?? "";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Créer un festival - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>
  <?php
  Storage::include("Js/creation/picture-chooser.js", "js", "defer");
  ?>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div id="grij_festival">

    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="festival">
        <div class="title-container">
          <h2 class="title">
            Planification des spectacles
          </h2>
        </div>

        <div class="form-container">
          <form action="<?= route("horairesFestival") ?>"
                method="get"
                enctype="multipart/form-data">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-duo">
                  <div class="form-component">
                    <label for="beginning_hour">
                      <p>
                        Heure de début :
                      </p>

                      <input type="time"
                             name="beginning_hour"
                             id="beginning_hour"
                             value="<?= $beginningHour ?>"
                             required />

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "beginning_date",
                      ]);
                      ?>
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="ending_hour">
                      <p>
                        Heure de fin :
                      </p>

                      <input type="time"
                             name="ending_hour"
                             id="ending_hour"
                             value="<?= $endingHour ?>"
                             required />

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "ending_date",
                      ]);
                      ?>
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="pause_value">
                      <p>
                        Durée des pauses :
                      </p>

                      <input type="time"
                             name="pause_value"
                             id="pause_value"
                             value="<?= $pauseValue ?>"
                             required />

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "pause_value",
                      ]);
                      ?>
                    </label>
                  </div>
                </div>
              </section>

              <?php
              Storage::component("FormHelpBoxComponent", [
                  "icon" => "fa-regular fa-question-circle",
                  "title" => "Planification des spectacles",
                  "content"
                      => "<p>
                            La planification des représentations se fait automatiquement à la suite 
                            de la création d’un festival sur le site. <br />
                          </p>
                            
                            Pour nous permettre de vous proposer des horaires correspondant à vos 
                            contraintes et attentes, <br /> veuillez renseigner une heure de début et de 
                            fin des spectacles, ainsi que la durée de pause entre <br /> deux représentations. 
                            Pour ce dernier champ, prenez en compte le délai de nettoyage et préparation <br />
                            de la scène pour la prochaine représentation, par exemple.
                          </p>",
              ]);
              ?>
            </div>

            <div class="buttons">
              <a href="<?= route("festivals") ?>">
                <button class="button-grey" type="button">
                  Annuler
                </button>
              </a>

              <button class="button-blue" type="submit">
                Confirmer la GriJ
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