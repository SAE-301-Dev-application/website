<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\DevelopmentUtilities\Debug;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$hasRequest = $props->hasRequest();

$name = $hasRequest
    ? $props->getRequest()->getInput("name")
    : "";

$description = $hasRequest
    ? $props->getRequest()->getInput("description")
    : "";

$beginningDate = $hasRequest
    ? $props->getRequest()->getInput("beginning_date")
    : "";

$endingDate = $hasRequest
    ? $props->getRequest()->getInput("ending_date")
    : "";

$musicCategoryCheck
    = $hasRequest && $props->getRequest()->getInput("music") !== null
          ? "checked"
          : "";

$theaterCategoryCheck
    = $hasRequest && $props->getRequest()->getInput("theater") !== null
          ? "checked"
          : "";

$circusCategoryCheck
    = $hasRequest && $props->getRequest()->getInput("circus") !== null
          ? "checked"
          : "";

$danceCategoryCheck
    = $hasRequest && $props->getRequest()->getInput("dance") !== null
          ? "checked"
          : "";

$filmScreeningCategoryCheck
    = $hasRequest && $props->getRequest()->getInput("film-screening") !== null
          ? "checked"
          : false;
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
  <div id="create_festival">

    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="festival">
        <div class="title-container">
          <h2 class="title">
            Créer un festival
          </h2>
        </div>

        <div class="form-container">
          <form action="<?= route("post.createFestival") ?>" method="post">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-component">
                  <label for="name">
                    <p>
                      Nom :
                    </p>

                    <input type="text"
                           name="name"
                           id="name"
                           maxlength="50"
                           value="<?= $name ?>"
                           required />

                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "name",
                    ]);
                    ?>
                  </label>
                </div>

                <div class="form-component">
                  <label for="description">
                    <p>
                      Description :
                    </p>

                    <textarea name="description"
                              id="description"
                              cols="30"
                              rows="8"
                              maxlength="1000"
                              required><?= $description ?></textarea>

                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "description",
                    ]);
                    ?>
                  </label>
                </div>

                <div class="form-duo">
                  <div class="form-component">
                    <label for="beginning_date">
                      <p>
                        Date de début :
                      </p>

                      <input type="date"
                             name="beginning_date"
                             id="beginning_date"
                             value="<?= $beginningDate ?>"
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
                    <label for="ending_date">
                      <p>
                        Date de fin :
                      </p>

                      <input type="date"
                             name="ending_date"
                             id="ending_date"
                             value="<?= $endingDate ?>"
                             required />

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "ending_date",
                      ]);
                      ?>
                    </label>
                  </div>
                </div>
              </section>

              <section id="categories">
                <p class="categories-label">
                  Catégories :
                </p>

                <div class="choices-container">
                  <label class="checkbox" for="music">
                    <input type="checkbox"
                           name="music"
                           id="music-choice"
                           <?= $musicCategoryCheck ?> />
                    Musique
                  </label>

                  <label class="checkbox" for="theater">
                    <input type="checkbox"
                           name="theater"
                           id="theater-choice"
                           <?= $theaterCategoryCheck ?> />
                    Théâtre
                  </label>

                  <label class="checkbox" for="circus">
                    <input type="checkbox"
                           name="circus"
                           id="circus-choice"
                           <?= $circusCategoryCheck ?> />
                    Cirque
                  </label>

                  <label class="checkbox" for="dance">
                    <input type="checkbox"
                           name="dance"
                           id="dance-choice"
                           <?= $danceCategoryCheck ?> />
                    Danse
                  </label>

                  <label class="checkbox" for="film-screening">
                    <input type="checkbox"
                           name="film-screening"
                           id="film-screening-choice"
                           <?= $filmScreeningCategoryCheck ?> />
                    Projection de film
                  </label>
                </div>

                <?php
                Storage::component("InputErrorComponent", [
                    "errors" => $errors,
                    "input" => "categories",
                ]);
                ?>
              </section>

              <section id="picture">
                <div class="picture-preview">
                  <img src=<?= "/website/src/Resources/Medias/Images/"
                             . "FestivalsUploads/festival_default_illustration.png" ?>
                       alt="Image de prévisualisation"
                       id="preview-img" />
                </div>

                <div class="picture-disclaimers">
                  <p>
                    Dimensions maximales :
                    <strong>800x600</strong>
                  </p>

                  <p>
                    Seules les images au format <strong>GIF</strong>,
                    <strong>PNG</strong>, <strong>JPEG</strong>
                    sont acceptées.
                  </p>
                </div>

                <div class="buttons">
                  <label for="picture_input">
                    <button class="button-grey" type="button" id="choose_picture">
                      Parcourir
                    </button>
                  </label>

                  <input type="file" name="picture"
                         id="picture_input"
                         accept=".png,.jpeg,.gif" />
                </div>
              </section>
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