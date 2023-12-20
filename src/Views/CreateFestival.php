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
  <title>Créer un festival - Festiplan</title>

  <!-- CSS -->
  <?php
    Storage::include("Css/ready.css");
  ?>


  <!-- JS -->
  <script src="../node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="../node_modules/gsap/dist/gsap.min.js" defer></script>

  <!-- <script src="../src/js/CreateFestival/picture-chooser.js" defer></script> -->

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <div id="create-festival">
    <?php
      $currentView = CreateFestival.php;  
      Storage::component("HeaderComponent");
    ?>

    <div id="main">
      <section id="all_festivals">
        <div class="title-container">
          <h2 class="title">
            Créer un festival
          </h2>
        </div>

        <div class="form-container">
          <form action="#">
            <div class="form-grid">
              <section id="general_information">
                <div class="form-component">
                  <label for="name">
                    <p>
                      Nom :
                    </p>
                    <input type="text" name="name" id="name" />
                  </label>
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
                    <label for="beginning_date">
                      <p>
                        Date de début :
                      </p>
                      <input type="date" name="beginning_date"
                            id="beginning_date" />
                    </label>
                  </div>

                  <div class="form-component">
                    <label for="ending_date">
                      <p>
                        Date de fin :
                      </p>
                      <input type="date" name="ending_date" id="ending_date" />
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