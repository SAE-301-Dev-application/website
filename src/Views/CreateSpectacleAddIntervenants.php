<?php
use MvcLite\Engine\InternalResources\Storage;
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

  <!-- <script src="../src/js/CreateFestival/picture-chooser.js" defer></script> -->

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div id="create-festival">
    <?php
        Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="all_festivals">
        <div class="title-container">
          <h2 class="title">
            Ajouter des intervenants
          </h2>
        </div>

        <div class="form-container">
          <form action="#">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-component">
                  <label for="intervenants">
                    <p>
                      Ajouter un intervenants :
                    </p>
                    <input type="text" name="intervenants" id="intervenants" />
                  </label>
                  <button class="button-blue">
                    Ajouter
                  </button>
                </div>

                <div class="form-component">
                  <label for="description">
                    <p>
                      Description :
                    </p>
                    <textarea name="description" id="description" cols="30"
                              rows="8"></textarea>
                  </label>
                </div>

                <div class="form-duo">
                  <div class="form-component">
                    <label for="duration">
                      <p>
                        Durée :
                      </p>
                      <input type="number" name="duration"
                            id="duration" />
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="scene_size">
                      <p>
                        Taille de scène requise :
                      </p>
                      <select name="scene_size" id="scene_size">
                        <option value="small">petite</option>
                        <option value="medium">moyenne</option>
                        <option value="large">grande</option>
                      </select>
                    </label>
                  </div>
                </div>
              </section>

              <section id="categories">
                <p class="categories-label">
                  Catégories :
                </p>

                <div class="choices-container">
                  <label class="checkbox" for="choice1">
                    <input type="checkbox" name="choice" id="choice1" />
                    Catégorie 1
                  </label>

                  <label class="checkbox" for="choice2">
                    <input type="checkbox" name="choice" id="choice2" />
                    Catégorie 2
                  </label>
                </div>
              </section>

              <section id="picture">
                <div class="picture-preview"></div>

                <div class="picture-disclaimers">
                  <p>
                    Dimensions maximales :
                    <strong>800x600</strong>
                  </p>

                  <p>
                    Seules les images au format <strong>GIF</strong>,
                    <strong>PNG</strong>,
                    <strong>JPEG</strong> sont acceptées.
                  </p>
                </div>

                <div class="buttons">
                  <label for="picture_input">
                    <button class="button-grey" type="button" id="choose_picture">
                      Parcourir
                    </button>
                  </label>

                  <input type="file" name="picture"
                        id="picture_input" />
                </div>
              </section>
            </div>

            <div class="buttons">
              <button class="button-grey">
                Annuler
              </button>

              <button class="button-blue">
                Suivant
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