<?php

use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\User;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$firstname = $props->getRequest()->getInput("firstname") ?? Session::getUserAccount()->getFirstname();
$lastname = $props->getRequest()->getInput("lastname") ?? Session::getUserAccount()->getLastname();
$login = $props->getRequest()->getInput("login") ?? Session::getUserAccount()->getLogin();
$email = $props->getRequest()->getInput("email") ?? Session::getUserAccount()->getEmail();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Mon profil - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>
  <?php
  Storage::include("Js/profile/navigation-links-manager.js", importMethod: "defer");
  Storage::include("Js/profile/delete-account.js", importMethod: "defer");
  ?>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body>
<div id="profile_main">

  <?php
  Storage::component("PopupComponent", [
      "id" => "popup_confirm_account_deleting",
      "title" => "Confirmation de désinscription",

      "slot" => "<p class='question'>Êtes-vous sûr de vouloir vous désinscrire de la plateforme ?</p>
                  <p><i class='fa-solid fa-warning fa-2xl'></i> <strong>Attention</strong>, cette action est irréversible et le compte ne pourra pas être récupéré.</p>
                  <p>Tous les festivals et les spectacles dont vous êtes responsable seront également supprimés.</p>",

      "buttons" => "<form id='password_form'>
                      <div class='form-component'>
                        <label for='password_verification'>
                          <p>
                              Saisissez votre mot de passe :
                          </p>

                          <input type='password'
                                name='password_verification'
                                id='password_verification' />

                          <ul>
                            <li class='input-error'>
                            </li>
                          </ul>
                        </label>
                      </div>

                      <div class='buttons'>
                        <button class='button-grey' type='button' id='popup_cancel_button'>Annuler</button>
                        <button class='button-red' id='popup_confirm_button'>Se désinscrire <i class='fa-solid fa-right-from-bracket'></i></button>
                      </div>
                    </form>",
  ]);
  ?>

  <?php
  Storage::component("HeaderComponent");
  ?>

  <div id="main">
    <h1 class="username">
      <?= Session::getUserAccount()->getFirstname() ?>
      <?= Session::getUserAccount()->getLastname() ?>
    </h1>

    <div class="main-grid">
      <div class="left-side">
        <div class="menu-container">
          <a class="link active-link" href="#my_profile">
            Mon profil
          </a>

          <a class="link" href="#my_festivals">
            Mes festivals
          </a>

          <a class="link" href="#my_spectacles">
            Mes spectacles
          </a>

          <a class="link" href="#settings">
            Paramètres
          </a>
        </div>
      </div>

      <div class="main-side">
        <section id="my_profile">
          <div class="section-title-container">
            <div class="left-side">
              <h3 class="section-title">
                Mon profil
              </h3>
            </div>
          </div>

          <div class="forms-container">
            <form action="<?= route("post.profile.generalInformation.save") ?>" method="post">
              <div class="form-component">
                <label for="firstname">
                  <p>
                    Prénom :
                  </p>

                  <input type="text"
                         name="firstname"
                         id="firstname"
                         value="<?= $firstname ?>"
                         maxlength="<?= User::FIRSTNAME_MAX_LENGTH ?>"/>

                  <?php
                  Storage::component("InputErrorComponent", [
                      "errors" => $errors,
                      "input" => "firstname",
                  ]);
                  ?>
                </label>
              </div>

              <div class="form-component">
                <label for="lastname">
                  <p>
                    Nom de famille :
                  </p>

                  <input type="text"
                         name="lastname"
                         id="lastname"
                         value="<?= $lastname ?>"
                         maxlength="<?= User::LASTNAME_MAX_LENGTH ?>"/>

                  <?php
                  Storage::component("InputErrorComponent", [
                      "errors" => $errors,
                      "input" => "lastname",
                  ]);
                  ?>
                </label>
              </div>

              <div class="form-component">
                <label for="login">
                  <p>
                    Login :
                  </p>

                  <input type="text"
                         name="login"
                         id="login"
                         value="<?= $login ?>"
                         minlength="<?= User::LOGIN_MIN_LENGTH ?>"
                         maxlength="<?= User::LOGIN_MAX_LENGTH ?>"/>

                  <?php
                  Storage::component("InputErrorComponent", [
                      "errors" => $errors,
                      "input" => "login",
                  ]);
                  ?>
                </label>
              </div>

              <div class="form-component">
                <label for="email">
                  <p>
                    Adresse e-mail :
                  </p>

                  <input type="email"
                         name="email"
                         id="email"
                         value="<?= $email ?>"
                         minlength="<?= User::EMAIL_MIN_LENGTH ?>"
                         maxlength="<?= User::EMAIL_MAX_LENGTH ?>"/>

                  <?php
                  Storage::component("InputErrorComponent", [
                      "errors" => $errors,
                      "input" => "email",
                  ]);
                  ?>
                </label>
              </div>

              <div class="form-buttons">
                <button class="button-blue">
                  <i class="fa-solid fa-save fa-xl"></i>
                  Enregistrer
                </button>

                <a href="<?= route("profile") ?>">
                  <button class="button-grey" type="button">
                    <i class="fa-solid fa-eraser fa-xl"></i>
                    Réinitialiser
                  </button>
                </a>
              </div>
            </form>

            <form action="<?= route("post.profile.newPassword.save") ?>" method="post">
              <div class="form-component">
                <label for="current_password">
                  <p>
                    Mot de passe actuel :
                  </p>

                  <input type="password"
                         name="current_password"
                         id="current_password"/>

                  <?php
                  Storage::component("InputErrorComponent", [
                      "errors" => $errors,
                      "input" => "current_password",
                  ]);
                  ?>
                </label>
              </div>

              <div class="form-duo">
                <div class="form-component">
                  <label for="new_password">
                    <p>
                      Nouveau mot de passe :
                    </p>

                    <input type="password"
                           name="new_password"
                           id="new_password"/>

                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "new_password",
                    ]);
                    ?>
                  </label>
                </div>

                <div class="form-component">
                  <label for="new_password_confirmation">
                    <p>
                      Confirmation :
                    </p>

                    <input type="password"
                           name="new_password_confirmation"
                           id="new_password_confirmation"/>

                    <?php
                    Storage::component("InputErrorComponent", [
                        "errors" => $errors,
                        "input" => "new_password_confirmation",
                    ]);
                    ?>
                  </label>
                </div>
              </div>

              <div class="form-buttons">
                <button class="button-blue">
                  <i class="fa-solid fa-lock fa-xl"></i>
                  Modifier mon mot de passe
                </button>
              </div>
            </form>
          </div>
        </section>

        <section id="my_festivals">
          <div class="section-title-container">
            <div class="left-side">
              <h3 class="section-title">
                Mes festivals
              </h3>

              <a href="<?= route("createFestival") ?>">
                <button class="button-blue">
                  Créer un festival
                </button>
              </a>
            </div>
          </div>

          <div class="festivals-container">
            <?php
            if (count($myFestivals)) {
                  foreach ($myFestivals as $festival) {
                      ?>
                    <div class="festival-preview">
                      <div class="festival-picture"
                           style="background: url('<?= $festival->getIllustration() ?>') center / cover no-repeat;"></div>

                      <div class="festival-identity">
                        <div class="festival-header">
                          <div class="festival-name-container">
                            <h3 class="festival-name">
                                <?= $festival->getName() ?>
                            </h3>

                            <i class="fa-solid fa-warning fa-2xl"
                               title="La configuration de ce festival n'est pas terminée !"></i>
                          </div>

                          <div class="festival-buttons-container">
                            <button class="button-grey">
                              <i class="fa-solid fa-pen"></i>
                              Éditer
                            </button>

                            <button class="button-red">
                              <i class="fa-solid fa-trash"></i>
                              Supprimer
                            </button>
                          </div>
                        </div>

                        <p class="festival-description">
                            <?= $festival->getDescription() ?>
                        </p>
                      </div>
                    </div>
                      <?php
                  }
              } else {
            ?>
              <div class="alert alert-grey">
                <div class="alert-icon">
                  <i class="fa-solid fa-info-circle"></i>
                </div>
                <div class="alert-content">
                  <p>
                    Vous n'organisez aucun festival.
                  </p>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </section>

        <section id="my_spectacles">
          <div class="section-title-container">
            <div class="left-side">
              <h3 class="section-title">
                Mes spectacles
              </h3>
            </div>
          </div>

          <div class="festivals-container">
            <?php
            if (count($mySpectacles)) {
                  foreach ($mySpectacles as $spectacle) {
                      ?>
                    <div class="festival-preview">
                      <div class="festival-picture"
                           style="background: url('<?= $spectacle->getIllustration() ?>') center / cover no-repeat;"></div>

                      <div class="festival-identity">
                        <div class="festival-header">
                          <div class="festival-name-container">
                            <h3 class="festival-name">
                                <?= $spectacle->getTitle() ?>
                            </h3>

                            <i class="fa-solid fa-warning fa-2xl"></i>
                          </div>

                          <div class="festival-buttons-container">
                            <button class="button-grey">
                              <i class="fa-solid fa-pen"></i>
                              Éditer
                            </button>

                            <button class="button-red">
                              <i class="fa-solid fa-trash"></i>
                              Supprimer
                            </button>
                          </div>
                        </div>

                        <p class="festival-description">
                            <?= $spectacle->getDescription() ?>
                        </p>
                      </div>
                    </div>
                      <?php
                  }
              } else {
            ?>
              <div class="alert alert-grey">
                <div class="alert-icon">
                  <i class="fa-solid fa-info-circle"></i>
                </div>
                <div class="alert-content">
                  <p>
                    Vous n'êtes responsable d'aucun spectacle.
                  </p>
                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </section>

        <section id="settings">
          <div class="section-title-container">
            <div class="left-side">
              <h3 class="section-title">
                Paramètres
              </h3>
            </div>
          </div>

          <div class="buttons-container">
            <button class="button-red" id="delete_account_button">
              Se désinscrire
              <i class="fa-solid fa-right-from-bracket"></i>
            </button>
          </div>
        </section>
      </div>
    </div>
  </div>

  <?php
  Storage::component("FooterComponent");
  ?>
</div>
</body>
</html>