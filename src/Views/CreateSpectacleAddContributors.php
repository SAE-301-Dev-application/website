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
  Storage::include("Js/spectacle-add-contributor/popup.js", importMethod: "defer");
  ?>

  <script defer>  /* Usage d'une balise script pour le code source JS, car présence de PHP. */
      document.addEventListener("DOMContentLoaded", () => {
          const CONTRIBUTOR_SEARCHING_POPUP = $("#search_contributor_popup"),
                CONTRIBUTOR_SEARCHING_LIST = $("#contributor_searching_results"),
                CONTRIBUTORS_LIST = $("section#current_contributors");

          let loadedContributors = [];

          function updateContributorsList() {
              $.get("<?= route("addContributor.getContributors") ?>", {
                  spectacle: <?= $spectacle->getId() ?>,
              })
                  .done(data => {
                      data = JSON.parse(data);
                      loadedContributors = data;

                      CONTRIBUTORS_LIST.empty();

                      let selector;

                      data.forEach(contributor => {
                          selector = loadUserSelector(contributor);

                          CONTRIBUTORS_LIST.append(`
                          <div class=\"contributor-container\">
                            <div class=\"contributor-information\">
                              <h3 class=\"contributor-name\">
                                  ${contributor.firstname}
                                  ${contributor.lastname}
                              </h3>

                              <ul class=\"contributor-details\">
                                <li>
                                  <i class=\"fa-solid fa-at fa-fw\"></i>
                                  ${contributor.email}
                                </li>
                              </ul>
                            </div>

                            ${selector}
                          </div>
                          `);
                      });
                  });
          }

          function searchContributor(search) {
              $.get("<?= route("addContributor.searchContributor") ?>", {
                  search,
              })
                  .done(data => {
                      data = JSON.parse(data);

                      const SEARCH_RESULT_POPUP_TITLE = $("#search_contributor_popup > .popup > h3.popup-title");

                      let scenePlurality = data.length > 1 ? "s" : "";

                      SEARCH_RESULT_POPUP_TITLE.text(`${data.length} utilisateur${scenePlurality}
                                                      trouvé${scenePlurality}`);

                      CONTRIBUTOR_SEARCHING_LIST.empty();

                      let selector;

                      data.forEach(contributor => {
                          selector = loadUserSelector(contributor);

                          CONTRIBUTOR_SEARCHING_LIST.append(`
                          <div class=\"contributor-container\">
                            <div class=\"contributor-information\">
                              <h3 class=\"contributor-name\">
                                  ${contributor.firstname}
                                  ${contributor.lastname}
                              </h3>

                              <ul class=\"contributor-details\">
                                <li>
                                  <i class=\"fa-solid fa-at fa-fw\"></i>
                                  ${contributor.email}
                                </li>
                              </ul>
                            </div>

                            ${selector}
                          </div>
                          `);
                      });
                  });
          }

          updateContributorsList();

          $(document).on("change", "select[id^='manage_contributor_']", e => {
              e.preventDefault();

              let selector = $(e.currentTarget),
                  contributorId = selector.attr("id").split('_')[2];

              switch (selector.val()) {
                  case "add":
                      addContributor(contributorId);
                      break;

                  case "give":
                      giveSpectacle(contributorId);
                      break;

                  case "remove":
                      removeContributor(contributorId);
                      break;

                  default:
                      break;
              }

              updateContributorsList();
              searchContributor($("#initial_search_contributor_input").val());

              function addContributor(userId) {
                  $.post("<?= route("addContributor.addContributor") ?>",
                      {
                          spectacleId: <?= $spectacle->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          }
                      });
              }

              function giveSpectacle(userId) {
                  $.post("<?= route("addContributor.giveSpectacle") ?>",
                      {
                          spectacleId: <?= $spectacle->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          }
                      });
              }

              function removeContributor(userId) {
                  $.post("<?= route("addContributor.removeContributor") ?>",
                      {
                          spectacleId: <?= $spectacle->getId() ?>,
                          userId,
                      })
                      .done(data => {
                          if (data !== "success") {
                              selector.after(`<p class="input-error">${data}</p>`);
                          }
                      });
              }
          });

          $(document).on("submit", "form#initial_search_contributor_form", e => {
              e.preventDefault();

              let searchValue = $("input#initial_search_contributor_input").val();

              searchContributor(searchValue);
              CONTRIBUTOR_SEARCHING_POPUP.removeClass("popup-hidden");
              $("body").addClass("body-overflow-clip");
          });

          function loadUserSelector(user) {
              let dynamicOptions;

              if (loadedContributors.find(loadedContributor => loadedContributor.login === user.login)) {
                  dynamicOptions = `
                              <option value="give">
                                Céder le spectacle
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
                            <select id="manage_contributor_${user.id}">
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
<div id="add_contributor">
    <?php
    Storage::component("PopupComponent", [
        "id" => "search_contributor_popup",
        "title" => "0 utilisateur trouvé",
        "slot" => "<div id='contributor_searching_results'></div>",
    ]);

    Storage::component("HeaderComponent");
    ?>

  <div id="main">
    <section>
      <div class="title-container">
        <h2 class="title">
          Ajouter des intervenants
        </h2>

        <a href="<?= route("informationsSpectacle") ?>?id=<?= $spectacle->getId() ?>" target="_blank">
          <button class="button-grey">
            <i class="fa-solid fa-eye"></i>
            Voir le spectacle
          </button>
        </a>
      </div>

      <div class="form-container">
        <div class="form-grid">
          <div class="main-container">
            <section id="initial_search_contributor">
              <form id="initial_search_contributor_form">
                <div class="form-component">
                  <label for="initial_search_contributor_input">
                    <p>
                      Rechercher un utilisateur :
                    </p>

                    <div class="form-input-button">
                      <input type="text"
                             name="search_contributor"
                             id="initial_search_contributor_input"
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

            <section id="current_contributors">
              <!--  -->
            </section>
          </div>

            <?php
            Storage::component("FormHelpBoxComponent", [
                "icon" => "fa-regular fa-question-circle",
                "title" => "Ajouter un intervenant au spectacle",
                "content"
                => "<p>
                      Vous pouvez ajouter les utilisateurs participant à l’organisation du spectacle
                      directement sur le site. Pour ce faire, saisissez leur login et ajoutez-les.
                  </p>
                    
                  <p>
                    S’il ne sont pas inscrits sur le site, saisissez leur e-mail ainsi que leur nom et
                    prénom. Cela n’affectera pas leurs fonctions sur le spectacle.
                  </p>
                  
                  <p>
                    Il existe deux rôles de participant :<br>
                    - Sur Scène : Il fera sa prestation sur la scène.<br>
                    - Hors Scène : Il fera partit de l’équipe technique du spectacle.
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