<?php
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Session\Session;

$errors = $props->hasValidator()
    ? $props->getValidator()->getErrors()
    : [];

$hasRequest = $props->hasRequest();

$firstname = $hasRequest
    ? $props->getRequest()->getInput("firstname")
    : Session::getUserAccount()->getFirstname();

$lastname = $hasRequest
    ? $props->getRequest()->getInput("lastname")
    : Session::getUserAccount()->getLastname();

$login = $hasRequest
    ? $props->getRequest()->getInput("login")
    : Session::getUserAccount()->getLogin();

$email = $hasRequest
    ? $props->getRequest()->getInput("email")
    : Session::getUserAccount()->getEmail();

\MvcLite\Engine\DevelopmentUtilities\Debug::dump($errors);
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
    ?>

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
  <div id="profile_main">

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
            <h3 class="section-title">
              Mon profil
            </h3>

            <form action="<?= route("post.profile.save") ?>" method="post">
              <div class="form-component">
                <label for="firstname">
                  <p>
                    Prénom :
                  </p>

                  <input type="text"
                         name="firstname"
                         id="firstname"
                         value="<?= $firstname ?>" />
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
                         value="<?= $lastname ?>" />
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
                         value="<?= $login ?>" />
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
                         value="<?= $email ?>" />
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
          </section>

          <section id="my_festivals">
            <h3 class="section-title">
              Mes festivals
            </h3>

            <div class="festivals-container">
              <div class="festival-preview">
                <div class="festival-picture"></div>

                <div class="festival-identity">
                  <div class="festival-header">
                    <div class="festival-name-container">
                      <h3 class="festival-name">
                        Festival name
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
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Consequuntur delectus minus officiis porro possimus.
                    Ab at dignissimos eum harum in, ipsum, maxime porro possimus
                    provident quam quasi quo sint ullam.
                  </p>
                </div>
              </div>
            </div>
          </section>

          <section id="my_spectacles">
            <h3 class="section-title">
              Mes spectacles
            </h3>

            <div class="festivals-container">
              <div class="festival-preview">
                <div class="festival-picture"></div>

                <div class="festival-identity">
                  <div class="festival-header">
                    <div class="festival-name-container">
                      <h3 class="festival-name">
                        Spectacle name
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
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Consequuntur delectus minus officiis porro possimus.
                    Ab at dignissimos eum harum in, ipsum, maxime porro possimus
                    provident quam quasi quo sint ullam.
                  </p>
                </div>
              </div>
            </div>
          </section>

          <section id="settings">
            <h3 class="section-title">
              Paramètres
            </h3>

            <div class="buttons-container">
              <a class="button-link" href="<?= route("logout") ?>">
                <button class="button-red">
                  Se désinscrire
                  <i class="fa-solid fa-right-from-bracket"></i>
                </button>
              </a>
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