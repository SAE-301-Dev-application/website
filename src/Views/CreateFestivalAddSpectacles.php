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
  <title>Ajouter un spectacle - Festiplan</title>

  <!-- CSS -->
    <?php
    Storage::include("Css/ready.css");
    ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>

    <?php
    Storage::include("Js/festival-add-spectacle/popup.js", importMethod: "defer");
    ?>

  <script defer>
      document.addEventListener("DOMContentLoaded", () => {
          const SPECTACLES_LIST = $("section#current_spectacles"),
              SPECTACLES_SEARCHING_LIST = $("#spectacle_searching_results"),
              SPECTACLES_SEARCHING_POPUP = $("#search_spectacle_popup");

          let loadedSpectacles = [];

          function updateSpectaclesList() {
              console.log("UPDATING SPECTACLES LIST.");

              console.log("<?=$festival->getId()?>");
              $.get("<?= route("addSpectacle.getSpectacles") ?>?festival=<?= $festival->getId() ?>", {})
                  .done(data => {
                      console.log(data);

                      data = JSON.parse(data);
                      loadedSpectacles = data;
                      SPECTACLES_LIST.empty();


                      if (data.length) {
                      } else {
                          SPECTACLES_LIST.append(`
                          <div class="alert alert-grey">
                            <div class="alert-icon">
                              <i class="fa-solid fa-info-circle"></i>
                            </div>
                            <div class="alert-content">
                              <p>Aucun spectacle n'est lié à ce festival.</p>
                            </div>
                          </div>
                          `)
                      }


                      data.forEach(spectacle => {
                          switch (spectacle.taille_scene_sp) {
                              case 1:
                                  spectacle.taille_scene_sp_label = "petite";
                                  break;

                              case 2:
                                  spectacle.taille_scene_sp_label = "moyenne";
                                  break;

                              case 3:
                                  spectacle.taille_scene_sp_label = "grande";
                                  break;

                              default:
                                  spectacle.taille_scene_sp_label = "inconnue";
                                  break;
                          }

                          SPECTACLES_LIST.append(`
                          <div class=\"spectacle-container\">
                            <div class=\"spectacle-information\">
                              <h3 class=\"spectacle-name\">
                                  ${spectacle.titre_sp}
                              </h3>

                              <ul class=\"spectacle-details\">

                                <li>
                                  <i class=\"fa-solid fa-up-right-and-down-left-from-center fa-fw\"></i>
                                  Taille :
                                  ${spectacle.taille_scene_sp_label}
                                </li>
                              </ul>
                            </div>

                            <button class=\"button-red remove-spectacle-button\" id=\"remove_spectacle_${spectacle.id_spectacle}\">
                              <i class=\"fa-solid fa-trash\"></i>
                              Supprimer
                            </button>
                          </div>
                      `);
                      });
                  });
          }

          function searchSpectacle(search) {
              $.get("<?= route("addSpectacle.searchSpectacle") ?>", {
                  search,
              })
                  .done(data => {
                      data = JSON.parse(data);

                      const SEARCH_RESULT_POPUP_TITLE = $("#search_spectacle_popup > .popup > h3.popup-title");

                      let spectaclePlurality = data.length > 1 ? "s" : "";

                      SEARCH_RESULT_POPUP_TITLE.text(`${data.length} spectacle${spectaclePlurality} trouvé${spectaclePlurality}`);
                      SPECTACLES_SEARCHING_LIST.empty();

                      data.forEach(spectacle => {
                          let button;

                          if (loadedSpectacles.find(loadedSpectacle => loadedSpectacle.id_spectacle === spectacle.id_spectacle)) {
                              button = `
                                <button class=\"button-red remove-spectacle-button\" id=\"remove_spectacle_${spectacle.id_spectacle}\">
                                  <i class=\"fa-solid fa-trash\"></i>
                                  Supprimer
                                </button>`;
                          } else {
                              button = `
                                <button class=\"button-blue add-spectacle-button\" id=\"add_spectacle_${spectacle.id_spectacle}\">
                                  <i class=\"fa-solid fa-plus\"></i>
                                  Ajouter
                                </button>`;
                          }

                          switch (spectacle.taille_scene_sp) {
                              case 1:
                                  spectacle.taille_scene_sp_label = "petite";
                                  break;

                              case 2:
                                  spectacle.taille_scene_sp_label = "moyenne";
                                  break;

                              case 3:
                                  spectacle.taille_scene_sp_label = "grande";
                                  break;

                              default:
                                  spectacle.taille_scene_sp_label = "inconnue";
                                  break;
                          }

                          SPECTACLES_SEARCHING_LIST.append(`
                          <div class=\"spectacle-container\">
                            <div class=\"spectacle-information\">
                              <h3 class=\"spectacle-name\">
                                  ${spectacle.titre_sp}
                              </h3>

                              <ul class=\"spectacle-details\">
                                <li>
                                  <i class=\"fa-solid fa-up-right-and-down-left-from-center fa-fw\"></i>
                                  Taille :
                                  ${spectacle.taille_scene_sp_label}
                                </li>
                              </ul>
                            </div>

                            ${button}
                          </div>
                          `);
                      });
                  });
          }

          updateSpectaclesList();

          $(document).on("click", "button[id^='add_spectacle_']", e => {
              e.preventDefault();

              let button = $(e.currentTarget),
                  festivalId = button.attr("id").split('_')[2];

              $.post("<?= route("post.addSpectacle.addSpectacle") ?>?festival=<?= $festival->getId() ?>&spectacle="
                  + festivalId,
                  {
                      festivalId,
                  })
                  .done(data => {
                      console.log(data);
                      if (data === "success") {
                          updateSpectaclesList();

                          $(`#search_spectacle_popup button[id^="add_spectacle_${festivalId}"]`)
                              .replaceWith(`
                              <button class=\"button-red remove-spectacle-button\" id=\"remove_spectacle_${festivalId}\">
                                <i class=\"fa-solid fa-trash\"></i>
                                Supprimer
                              </button>
                              `);
                      } else {
                          button.after(`<p class="input-error">${data}</p>`);
                      }
                  });
          });

          $(document).on("click", "button[id^='remove_spectacle_']", e => {
              e.preventDefault();

              let button = $(e.currentTarget),
                  festivalId = button.attr("id").split('_')[2];

              $.post("<?= route("post.addSpectacle.removeSpectacle") ?>?festival=<?= $festival->getId() ?>&spectacle="
                  + festivalId,
                  {
                      festivalId,
                  })
                  .done(data => {
                      if (data === "success") {
                          updateSpectaclesList();

                          $(`#search_spectacle_popup button[id^="remove_spectacle_${festivalId}"]`)
                              .replaceWith(`
                              <button class=\"button-blue add-spectacle-button\" id=\"add_spectacle_${festivalId}\">
                                <i class=\"fa-solid fa-plus\"></i>
                                Ajouter
                              </button>
                              `);
                      } else {
                          button.after(`<p class="input-error">${data}</p>`);
                      }
                  });
          });

          $(document).on("submit", "form#initial_search_spectacle_form", e => {
              e.preventDefault();

              let searchValue = $("input#initial_search_spectacle_input").val();

              searchSpectacle(searchValue);
              SPECTACLES_SEARCHING_POPUP.removeClass("popup-hidden");
              $("body").addClass("body-overflow-clip");
          });
      });
  </script>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div id="add-spectacle">
    <?php
    Storage::component("PopupComponent", [
        "id" => "search_spectacle_popup",
        "title" => "0 spectacle trouvé",
        "slot" => "<div id='spectacle_searching_results'></div>",
    ]);

    Storage::component("HeaderComponent");
    ?>

  <div id="main">
    <section id="add-spectacle">
      <div class="title-container">
        <h2 class="title">
          Ajouter des spectacles
        </h2>

        <a href="<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>">
          <button class="button-grey">
            <i class="fa-solid fa-eye"></i>
            Voir le festival
          </button>
        </a>
      </div>

      <div class="form-container">
        <div class="form-grid">
          <div class="main-container">
            <section id="initial_search_spectacle">
              <form id="initial_search_spectacle_form">
                <div class="form-component">
                  <label for="initial_search_spectacle_input">
                    <p>
                      Rechercher un spectacle :
                    </p>

                    <div class="form-input-button">
                      <input type="text"
                             name="search_spectacle"
                             id="initial_search_spectacle_input"
                             required/>

                      <button class="button-blue">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Rechercher
                      </button>
                    </div>
                  </label>
                </div>
              </form>
            </section>

            <section id="current_spectacles">
              <!--  -->
            </section>
          </div>

            <?php
            Storage::component("FormHelpBoxComponent", [
                "icon" => "fa-regular fa-question-circle",
                "title" => "Ajouter un spectacle au festival",
                "content"
                => "<p>
                        Pour son déroulement, un festival nécessite des spectacles. Ceux-ci vont permettre 
                        d’animer le festival.
                      </p>
                        
                      <p>
                        Saisissez le nom du spectacle et sélectionnez parmi les résultats de recherche présentés.
                      </p>
                      
                      <p>
                        Vous pouvez, d’autre part, retirer des spectacles de votre sélection 
                        en cliquant sur son bouton Supprimer.
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