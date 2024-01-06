<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\DevelopmentUtilities\Debug;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$hasRequest = $props->hasRequest();

$title = $hasRequest
    ? $props->getRequest()->getInput("title")
    : "";

$description = $hasRequest
    ? $props->getRequest()->getInput("description")
    : "";

$duration = $hasRequest
    ? $props->getRequest()->getInput("duration")
    : "";

$sceneSize = $hasRequest
    ? $props->getRequest()->getInput("scene_size")
    : "";

$smallCheck = $sceneSize === "small"
    ? "checked"
    : "";

$mediumCheck = $sceneSize === "medium"
    ? "checked"
    : "";

$largeCheck = $sceneSize === "large"
    ? "checked"
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
    = $hasRequest && $props->getRequest()->getInput("film_screening") !== null
          ? "checked"
          : false;

$illustrationPath = ROUTE_PATH_PREFIX
    . "src/Resources/Medias/Images/default_illustration.png";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Créer un spectacle - Festiplan</title>

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
  <div id="create_spectacle">

    <?php
    Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="spectacle">
        <div class="title-container">
          <h2 class="title">
            Créer un spectacle
          </h2>
        </div>

        <div class="form-container">
          <form action="<?= route("post.createSpectacle") ?>"
                method="post"
                enctype="multipart/form-data">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-component">
                  <label for="title">
                    <p>
                      Titre :
                    </p>

                    <input type="text"
                           name="title"
                           id="title"
                           maxlength="50"
                           value="<?= $title ?>"
                           required />

                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "title",
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
                    <label for="duration">
                      <p>
                        Durée :
                      </p>

                      <input type="number"
                             name="duration"
                             id="duration"
                             min="1"
                             max="1680"
                             value="<?= $duration ?>"
                             required />

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "duration",
                      ]);
                      ?>
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="scene_size">
                      <p>
                        Taille de scène requise :
                      </p>

                      <select name="scene_size"
                              id="scene_size"
                              required>
                        <option value="small"<?= $smallCheck ?>>Petite</option>
                        <option value="medium"<?= $mediumCheck ?>>Moyenne</option>
                        <option value="large"<?= $largeCheck ?>>Grande</option>
                      </select>

                      <?php
                      Storage::component("InputErrorComponent", [
                          "errors" => $errors,
                          "input" => "scene_size",
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
                           id="music_choice"
                           <?= $musicCategoryCheck ?> />
                    Concert
                  </label>

                  <label class="checkbox" for="theater">
                    <input type="checkbox"
                           name="theater"
                           id="theater_choice"
                           <?= $theaterCategoryCheck ?> />
                    Pièce de théâtre
                  </label>

                  <label class="checkbox" for="circus">
                    <input type="checkbox"
                           name="circus"
                           id="circus_choice"
                           <?= $circusCategoryCheck ?> />
                    Cirque
                  </label>

                  <label class="checkbox" for="dance">
                    <input type="checkbox"
                           name="dance"
                           id="dance_choice"
                           <?= $danceCategoryCheck ?> />
                    Danse
                  </label>

                  <label class="checkbox" for="film_screening">
                    <input type="checkbox"
                           name="film_screening"
                           id="film_screening_choice"
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
                  <img src=<?= $illustrationPath ?>
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

                  <input type="file" name="illustration"
                         id="picture_input"
                         accept=".png,.jpeg,.gif" />
                </div>

                <?php
                Storage::component("InputErrorComponent", [
                    "errors" => $errors,
                    "input" => "illustration",
                ]);
                ?>
              </section>
            </div>

            <div class="buttons">
              <a href="<?= route("spectacles") ?>">
                <button class="button-grey" type="button">
                  Annuler
                </button>
              </a>

              <button class="button-blue" type="submit">
                Créer le spectacle
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