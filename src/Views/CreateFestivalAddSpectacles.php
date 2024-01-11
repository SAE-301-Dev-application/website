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

  <script defer>
      document.addEventListener("DOMContentLoaded", () => {
          function updateSpectaclesList() {  console.log("UPDATING SPECTACLES LIST.");
              const SPECTACLES_LIST = $("section#current_spectacles");

              $.get("<?= route("addSpectacle.getSpectacles") ?>?festival=<?= $festival->getId() ?>", {})
                  .done(data => {
                      console.log(data);

                      data = JSON.parse(data);

                      SPECTACLES_LIST.empty();

                      data.forEach(spectacle => {
                          switch (spectacle.size) {
                              case 1:
                                  spectacle.size_label = "petite";
                                  break;

                              case 2:
                                  spectacle.size_label = "moyenne";
                                  break;

                              case 3:
                                  spectacle.size_label = "grande";
                                  break;

                              default:
                                  spectacle.size_label = "inconnue";
                                  break;
                          }

                          SPECTACLES_LIST.append(`
                          <div class=\"spectacle-container\">
                            <div class=\"spectacle-information\">
                              <h3 class=\"spectacle-name\">
                                  ${spectacle.name}
                              </h3>

                              <ul class=\"spectacle-details\">
                                <li>
                                  <i class=\"fa-solid fa-location-dot fa-fw\"></i>
                                  Longitude : ${spectacle.longitude} /
                                  Latitude : ${spectacle.latitude}
                                </li>

                                <li>
                                  <i class=\"fa-solid fa-up-right-and-down-left-from-center fa-fw\"></i>
                                  Taille :
                                  ${spectacle.size_label}
                                </li>
                              </ul>
                            </div>

                            <button class=\"button-red remove-spectacle-button\" id=\"remove_spectacle_${spectacle.id}\">
                              <i class=\"fa-solid fa-trash\"></i>
                              Supprimer
                            </button>
                          </div>
                      `);
                      });
                });
          }

          updateSpectaclesList();

          $(document).on("click", "button[id^='remove_spectacle_']", e => {
          e.preventDefault();

          let button = $(e.currentTarget),
              festivalId = button.attr("id").split('_')[2];

          $.post("<?= route("addSpectacle.removeSpectacle") ?>?festival=<?= $festival->getId() ?>&spectacle=" + festivalId, {
              festivalId,
            })
            .done(data => {
                if (data === "success") {
                    updateSpectaclesList();
                } else {
                    button.after(`<p class="input-error">${data}</p>`);
                }
            });
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
      "id"    => "search_spectacle_popup",
      ""
  ]);

  Storage::component("HeaderComponent");
  ?>

  <div id="main">
    <section id="add-spectacle">
      <div class="title-container">
        <h2 class="title">
          Ajouter des spectacles
        </h2>

        <a href="<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>" target="_blank">
          <button class="button-grey">
            <i class="fa-solid fa-eye"></i>
            Voir le festival
          </button>
        </a>
      </div>

      <div class="form-container">
        <form action="<?= route("festivals") ?>"
              method="post"
              enctype="multipart/form-data">

          <div class="form-grid">
              <div class="main-container">
                <section id="search_spectacle">
                  <div class="form-component">
                    <label for="search_spectacle_input">
                      <p>
                        Rechercher un spectacle :
                      </p>

                      <div class="form-input-button">
                        <input type="text" name="search_spectacle" id="search_spectacle_input" />

                        <button class="button-blue">
                          <i class="fa-solid fa-magnifying-glass"></i>
                          Rechercher
                        </button>
                      </div>
                    </label>
                  </div>
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