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
    <title>Connexion - Festiplan</title>

    <?php
    Storage::include("Css/ready.css");
    ?>
</head>
<body>
    <div id="index_main">
        <div class="left-side">
            <div class="background-filter"></div>

            <div class="side-contents">
                <h1 class="logo"></h1>

                <p class="slogan">
                    Créer un festival n'a jamais été aussi simple.
                </p>

                <footer>
                    2023 © Festiplan. IUT de Rodez.
                </footer>
            </div>
        </div>

        <div class="right-side">
            <h2 class="section-title">
                Accéder à mon espace
            </h2>

            <div class="form-container">
                <form action="#" method="post">
                    <div class="form-component">
                        <label for="login">
                            <p>
                                Login :
                            </p>

                            <input type="text"
                                   name="login"
                                   id="login"
                                   required />
                        </label>
                    </div>

                    <div class="form-component">
                        <label for="password">
                            <p>
                                Mot de passe :
                            </p>

                            <input type="password"
                                   name="password"
                                   id="password"
                                   required />
                        </label>
                    </div>

                    <div class="form-buttons-column">
                        <div class="form-component">
                            <button class="button-blue" type="submit">
                                Connexion
                            </button>
                        </div>

                        <hr />

                        <div class="form-component">
                            <a href="<?= route('register') ?>">
                                <button class="button-grey" type="button">
                                    Créer mon compte
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>