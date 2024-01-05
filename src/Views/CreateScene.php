<?php
use MvcLite\Engine\InternalResources\Storage;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$hasRequest = $props->hasRequest();

$name = $hasRequest
    ? $props->getRequest()->getInput("name")
    : "";

$maxSeats = $hasRequest
    ? $props->getRequest()->getInput("max_seats")
    : "";

$longitude = $hasRequest
    ? $props->getRequest()->getInput("longitude")
    : "";

$latitude = $hasRequest
    ? $props->getRequest()->getInput("latitude")
    : "";

$size = $hasRequest
    ? $props->getRequest()->getInput("size")
    : "";
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

  <!-- <script src="../src/js/CreateFestival/picture-chooser.js" defer></script> -->

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div id="create_festival">

    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="creation_form">
        <div class="title-container">
          <h2 class="title">
            Créer une scène
          </h2>
        </div>

        <div class="form-container">
          <form action="<?= route("post.createScene") ?>" method="post" enctype="multipart/form-data">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-component">
                  <label for="name">
                    <p>
                      Nom :
                    </p>
                    <input type="text" name="name" id="name" value="<?= $name ?>" />
                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "name",
                    ]);
                    ?>
                  </label>
                </div>

                <div class="form-component">
                  <label for="max_seats">
                    <p>
                      Nombre de spectateurs maximum :
                    </p>
                    <input type="number" name="max_seats" id="max_seats">
                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "max_seats",
                    ]);
                    ?>
                  </label>
                </div>

                <div class="form-duo">
                  <div class="form-component">
                    <label for="longitude">
                      <p>
                        Longitude :
                      </p>
                      <input type="number" step="0.01" name="longitude"
                            id="longitude" />
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="latitude">
                      <p>
                        Latitude :
                      </p>
                      <input type="number" step="0.01" name="latitude" id="latitude" />
                    </label>
                  </div>
                </div>

                <div class="form-component">
                  <label for="size">
                    <p>
                      Taille :
                    </p>
                    <select name="size" id="size">
                      <optgroup label="Sélectionnez une taille :">
                        <option value="1">
                          Petite
                        </option>

                        <option value="2">
                          Moyenne
                        </option>

                        <option value="3">
                          Grande
                        </option>
                      </optgroup>
                    </select>
                  </label>
                </div>
              </section>

              <?php
              Storage::component("FormHelpBoxComponent", [
                  "icon" => "fa-regular fa-question-circle",
                  "title" => "Ajouter une scène",
                  "content"
                      => "<p>
                            Les scènes sont des lieux où peuvent se dérouler les spectacles planifiés sur 
                            nos services. <br />
                            
                            Ces scènes sont sélectionnables par tous, bien que leur disponibilité dépende 
                            des créneaux réservés.
                          </p>
                    
                          <p>
                            Chaque scène détient un nom unique, une limite de places, des coordonnées sous le format 
                            lagiture / longitude, ainsi qu’une taille type (petite, moyenne ou grande).
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
                Créer le festival
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