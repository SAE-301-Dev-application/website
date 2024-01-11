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

  <script defer>
      document.addEventListener("DOMContentLoaded", () => {
          const SCENE_SEARCHING_POPUP = $("#search_scene_popup");

          function updateScenesList() {  console.log("UPDATING SCENES LIST.");
              const SCENES_LIST = $("section#current_scenes");

              $.get("<?= route("addScene.getScenes") ?>?festival=<?= $festival->getId() ?>", {})
                  .done(data => {
                      console.log(data);

                      data = JSON.parse(data);

                      SCENES_LIST.empty();

                      data.forEach(scene => {
                          switch (scene.size) {
                              case 1:
                                  scene.size_label = "petite";
                                  break;

                              case 2:
                                  scene.size_label = "moyenne";
                                  break;

                              case 3:
                                  scene.size_label = "grande";
                                  break;

                              default:
                                  scene.size_label = "inconnue";
                                  break;
                          }

                          SCENES_LIST.append(`
                          <div class=\"scene-container\">
                            <div class=\"scene-information\">
                              <h3 class=\"scene-name\">
                                  ${scene.name}
                              </h3>

                              <ul class=\"scene-details\">
                                <li>
                                  <i class=\"fa-solid fa-location-dot fa-fw\"></i>
                                  Longitude : ${scene.longitude} /
                                  Latitude : ${scene.latitude}
                                </li>

                                <li>
                                  <i class=\"fa-solid fa-up-right-and-down-left-from-center fa-fw\"></i>
                                  Taille :
                                  ${scene.size_label}
                                </li>

                                <li>
                                  <i class=\"fa-solid fa-chair fa-fw\"></i>
                                  Nombre de places :
                                  ${scene.max_seats}
                                </li>
                              </ul>
                            </div>

                            <button class=\"button-red remove-scene-button\" id=\"remove_scene_${scene.id}\">
                              <i class=\"fa-solid fa-trash\"></i>
                              Supprimer
                            </button>
                          </div>
                      `);
                      });
                });
          }

          function searchScene(search) {
              $.get("<?= route("addScene.searchScene") ?>", {
                  search,
              })
                  .done(data => {
                      console.log(data);
                  });
          }

          updateScenesList();

          $(document).on("click", "button[id^='remove_scene_']", e => {
              e.preventDefault();

              let button = $(e.currentTarget),
                  festivalId = button.attr("id").split('_')[2];

              $.post("<?= route("addScene.removeScene") ?>?festival=<?= $festival->getId() ?>&scene=" + festivalId,
                  {
                    festivalId,
                  })
                  .done(data => {
                      if (data === "success") {
                          updateScenesList();
                      } else {
                          button.after(`<p class="input-error">${data}</p>`);
                      }
                  });
              });

          $(document).on("submit", "form#initial_search_scene_form", e => {
              e.preventDefault();

              let searchValue = $("input#initial_search_scene_input").val();

              searchScene(searchValue);
              SCENE_SEARCHING_POPUP.removeClass("popup-hidden");
          });
      });
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
      "title" => "0 intervenants trouvés",
      "slot" => "",
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
        <div class="form-grid">
          <div class="main-container">
            <section id="initial_search_scene">
              <form id="initial_search_scene_form">
                <div class="form-component">
                  <label for="initial_search_scene_input">
                    <p>
                      Rechercher une scène :
                    </p>

                    <div class="form-input-button">
                      <input type="text"
                             name="search_scene"
                             id="initial_search_scene_input"
                             required />

                      <button class="button-blue">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Rechercher
                      </button>
                    </div>
                  </label>
                </div>
              </form>
            </section>

            <section id="current_scenes">
              <!--  -->
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
      </div>
    </section>
  </div>

  <?php
  Storage::component("FooterComponent");
  ?>
</div>
</body>
</html>