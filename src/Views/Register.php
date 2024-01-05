<?php
use MvcLite\Engine\InternalResources\Storage;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$hasRequest = $props->hasRequest();

$firstname = $hasRequest
    ? $props->getRequest()->getInput("firstname")
    : "";

$lastname = $hasRequest
    ? $props->getRequest()->getInput("lastname")
    : "";

$email = $hasRequest
    ? $props->getRequest()->getInput("email")
    : "";

$login = $hasRequest
    ? $props->getRequest()->getInput("login")
    : "";
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Créer un compte - Festiplan</title>

  <!-- CSS -->
  <?php
  Storage::include("Css/ready.css");
  ?>

  <!-- JS -->
  <script src="/website/node_modules/jquery/dist/jquery.min.js" defer></script>
  <script src="/website/node_modules/gsap/dist/gsap.min.js" defer></script>
  <?php
  Storage::include("Js/login-register/animation.js", "js", "defer");
  Storage::include("Js/login-register/register.js", "js", "defer");
  ?>

</head>
<body>
  <div id="register_main">
    <div class="left-side">
      <div class="background-filter"></div>

      <div class="side-contents">
        <h1 class="logo"></h1>

        <p class="slogan">
          Créer un festival n'a jamais été aussi simple.
        </p>

        <footer class="computer">
          2023 © Festiplan. IUT de Rodez.
        </footer>
      </div>
    </div>

    <div class="right-side">
      <h2 class="section-title">
        Accéder à mon espace
      </h2>

      <div class="form-container">
        <form action="<?= route('post.register') ?>" method="post">
          <div class="form-duo">
            <div class="form-component">
              <label for="firstname">
                <p>
                  Prénom :
                </p>

                <input type="text"
                       name="firstname"
                       id="firstname"
                       minlength="1"
                       maxlength="25"
                       value="<?= $firstname ?>"
                       required />

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
                       minlength="1"
                       maxlength="50"
                       value="<?= $lastname ?>"
                       required />

                <?php
                Storage::component("InputErrorComponent", [
                    "errors" => $errors,
                    "input" => "lastname",
                ]);
                ?>
              </label>
            </div>
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
                     required />

              <?php
              Storage::component("InputErrorComponent", [
                  "errors" => $errors,
                  "input" => "email",
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
                     minlength="3"
                     maxlength="25"
                     value="<?= $login ?>"
                     required />

              <?php
              Storage::component("InputErrorComponent", [
                  "errors" => $errors,
                  "input" => "login",
              ]);
              ?>
            </label>
          </div>

          <div class="form-duo">
            <div class="form-component">
              <label for="password">
                <p>
                  Mot de passe :
                </p>

                <input type="password"
                       name="password"
                       id="password"
                       required />

                <?php
                Storage::component("InputErrorComponent", [
                    "errors" => $errors,
                    "input" => "password",
                ]);
                ?>
              </label>
            </div>

            <div class="form-component">
              <label for="password">
                <p>
                  Confirmation :
                </p>

                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       required />

                <?php
                Storage::component("InputErrorComponent", [
                    "errors" => $errors,
                    "input" => "password_confirmation",
                ]);
                ?>
              </label>
            </div>
          </div>

          <div class="form-buttons-column">
            <div class="form-component">
              <button class="button-blue" type="submit">
                S'inscrire
              </button>
            </div>

            <hr />

            <div class="form-component">
              <a href="<?= route('index'); ?>">
                <button class="button-grey" type="button">
                  J'ai déjà un compte
                </button>
              </a>
            </div>
          </div>
        </form>
      </div>
      <footer class="mobile">
        2023 © Festiplan. IUT de Rodez.
      </footer>
    </div>
  </div>
</body>
</html>