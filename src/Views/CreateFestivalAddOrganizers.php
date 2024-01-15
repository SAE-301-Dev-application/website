<?php

use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Session\Session;

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
  <title>Ajouter un organisateur - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>

  <?php
  Storage::include("Js/festival-add-organizer/popup.js", importMethod: "defer");
  ?>

  <script defer>  /* Usage d'une balise script pour le code source JS, car présence de PHP. */
      document.addEventListener("DOMContentLoaded", () => {
          const ORGANIZER_SEARCHING_POPUP = $("#search_organizer_popup"),
                ORGANIZER_SEARCHING_LIST = $("#organizer_searching_results"),
                ORGANIZERS_LIST = $("section#current_organizers");

          let loadedOrganizers = [];

          function updateOrganizersList() {
              $.get("<?= route("addOrganizer.getOrganizers") ?>", {
                  festival: <?= $festival->getId() ?>,
              })
                  .done(data => {
                      data = JSON.parse(data);
                      loadedOrganizers = data;

                      ORGANIZERS_LIST.empty();

                      let selector;

                      data.forEach(organizer => {
                          selector = loadUserSelector(organizer);

                          ORGANIZERS_LIST.append(`
                          <div class=\"organizer-container\">
                            <div class=\"organizer-information\">
                              <h3 class=\"organizer-name\">
                                  ${organizer.firstname}
                                  ${organizer.lastname}
                              </h3>

                              <ul class=\"organizer-details\">
                                <li>
                                  <i class=\"fa-solid fa-at fa-fw\"></i>
                                  ${organizer.email}
                                </li>
                              </ul>
                            </div>

                            <div class="action-container">
                              ${selector}
                            </div>
                          </div>
                          `);
                      });
                  });
          }

          function searchOrganizer(search) {
              $.get("<?= route("addOrganizer.searchOrganizer") ?>", {
                  search,
              })
                  .done(data => {
                      data = JSON.parse(data);

                      const SEARCH_RESULT_POPUP_TITLE = $("#search_organizer_popup > .popup > h3.popup-title");

                      let scenePlurality = data.length > 1 ? "s" : "";

                      SEARCH_RESULT_POPUP_TITLE.text(`${data.length} utilisateur${scenePlurality}
                                                      trouvé${scenePlurality}`);

                      ORGANIZER_SEARCHING_LIST.empty();

                      let selector;

                      data.forEach(organizer => {
                          selector = loadUserSelector(organizer);

                          ORGANIZER_SEARCHING_LIST.append(`
                          <div class=\"organizer-container\">
                            <div class=\"organizer-information\">
                              <h3 class=\"organizer-name\">
                                  ${organizer.firstname}
                                  ${organizer.lastname}
                              </h3>

                              <ul class=\"organizer-details\">
                                <li>
                                  <i class=\"fa-solid fa-at fa-fw\"></i>
                                  ${organizer.email}
                                </li>
                              </ul>
                            </div>

                            <div class="selector-container">
                              ${selector}
                            </div>
                          </div>
                          `);
                      });
                  });
          }

          updateOrganizersList();

          $(document).on("change", "select[id^='manage_organizer_']", e => {
              e.preventDefault();

              let selector = $(e.currentTarget),
                  organizerId = selector.attr("id").split('_')[2];

              switch (selector.val()) {
                  case "add":
                      addOrganizer(organizerId);
                      break;

                  case "give":
                      giveFestival(organizerId);
                      break;

                  case "remove":
                      removeOrganizer(organizerId);
                      break;

                  default:
                      break;
              }

              function addOrganizer(userId) {
                  $.post("<?= route("addOrganizer.addOrganizer") ?>",
                      {
                          festivalId: <?= $festival->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          } else {
                              updateOrganizersList();
                              searchOrganizer($("#initial_search_organizer_input").val());
                          }
                      });
              }

              function giveFestival(userId) {
                  $.post("<?= route("addOrganizer.giveFestival") ?>",
                      {
                          festivalId: <?= $festival->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          } else {
                              window.location
                                  = "<?= route("informationsFestival") ?>?id=<?= $festival->getId() ?>";
                          }
                      });
              }

              function removeOrganizer(userId) {
                  $.post("<?= route("addOrganizer.removeOrganizer") ?>",
                      {
                          festivalId: <?= $festival->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          } else {
                              updateOrganizersList();
                              searchOrganizer($("#initial_search_organizer_input").val());
                          }
                      });
              }
          });

          $(document).on("submit", "form#initial_search_organizer_form", e => {
              e.preventDefault();

              let searchValue = $("input#initial_search_organizer_input").val();

              searchOrganizer(searchValue);
              ORGANIZER_SEARCHING_POPUP.removeClass("popup-hidden");
              $("body").addClass("body-overflow-clip");
          });

          function loadUserSelector(user) {
              let dynamicOptions;

              if (loadedOrganizers.find(loadedOrganizer => loadedOrganizer.login === user.login)) {
                  dynamicOptions = `
                              <option value="give">
                                Céder le festival
                              </option>

                              <option value="remove">
                                Supprimer
                              </option>
                              `;
              } else {
                  dynamicOptions = `
                              <option value="add">
                                Ajouter
                              </option>
                              `;
              }

              return user.id !== <?= Session::getSessionId() ?>
                  ? `
                            <select id="manage_organizer_${user.id}">
                              <optgroup label="Sélectionnez une action :">
                                <option value="" selected>
                                  Sélectionnez une action
                                </option>

                                ${dynamicOptions}
                              </optgroup>
                            </select>
                          `
                  : "";
          }
      });
  </script>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div id="add_organizer">
    <?php
    Storage::component("PopupComponent", [
        "id" => "search_organizer_popup",
        "title" => "0 utilisateur trouvé",
        "slot" => "<div id='organizer_searching_results'></div>",
    ]);

    Storage::component("HeaderComponent");
    ?>

  <div id="main">
    <section>
      <div class="title-container">
        <h2 class="title">
          Ajouter des organisateurs
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
            <section id="initial_search_organizer">
              <form id="initial_search_organizer_form">
                <div class="form-component">
                  <label for="initial_search_organizer_input">
                    <p>
                      Rechercher un utilisateur :
                    </p>

                    <div class="form-input-button">
                      <input type="text"
                             name="search_organizer"
                             id="initial_search_organizer_input"
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

            <section id="current_organizers">
              <!--  -->
            </section>
          </div>

            <?php
            Storage::component("FormHelpBoxComponent", [
                "icon" => "fa-regular fa-question-circle",
                "title" => "Ajouter un organisateur au festival",
                "content"
                => "<p>
                    Vous n'êtes pas seul à vous occuper de ce festival ? Vous souhaitez ajouter des collaborateurs
                    afin de vous aider dans vos tâches de gestion ?
                  </p>
                    
                  <p>
                    Recherchez le compte de votre ou de vos collaborateurs, et ajoutez-les en un clic !
                  </p>
                  
                  <p>
                    Vous pouvez, d’autre part, retirer des collaborateurs de votre festival en
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