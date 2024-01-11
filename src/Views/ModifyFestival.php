<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Festival;

$errors = $props->getValidator()->getErrors() ?? [];

$name = $festival->getName();

$description = $festival->getDescription();

$beginningDate = $festival->getBeginningDate();

$endingDate = $festival->getEndingDate();

$illustrationPath = $festival->getIllustration();

$categories = $festival->getCategories();

$musicCategoryCheck = "";

$theaterCategoryCheck = "";

$circusCategoryCheck = "";

$danceCategoryCheck = "";

$filmScreeningCategoryCheck = "";

//Debug::dd($categories);

foreach ($categories as $categorie) {
  switch($categorie->getName()) {
    case "Cirque":
      $circusCategoryCheck = "checked";
      break;
    case "Danse":
      $danceCategoryCheck = "checked";
      break;
    case "Musique":
      $musicCategoryCheck = "checked";
      break;
    case "Projection de film":
      $filmScreeningCategoryCheck = "checked";
      break;
    case "Théâtre":
      $theaterCategoryCheck = "checked";
      break;
  }
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Modification de festival - Festiplan</title>

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
            Modification de festival
          </h2>
        </div>

        <div class="form-container">
          <form action="<?= route("post.createFestival") ?>"
                method="post"
                enctype="multipart/form-data">
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

                      <?php
                        $isFestivalInProgress = $festival->isFestivalInProgress();
                      ?>
                      <input type="date"
                             name="beginning_date"
                             id="beginning_date"
                             value="<?= $beginningDate ?>"
                             required 
                             <?= $isFestivalInProgress ? "disabled" : "" ?> />
                        
                      <?= $isFestivalInProgress ? "Festival déjà commencé" : "";?>

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
                           id="music_choice"
                           <?= $musicCategoryCheck ?> />
                    Musique
                  </label>

                  <label class="checkbox" for="theater">
                    <input type="checkbox"
                           name="theater"
                           id="theater_choice"
                           <?= $theaterCategoryCheck ?> />
                    Théâtre
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
                         accept=".png,.jpeg,.jpg,.gif" />
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
              <a href="<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>">
                <button class="button-grey" type="button">
                  Annuler
                </button>
              </a>

              <button class="button-blue" type="submit">
                Modifier le festival
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