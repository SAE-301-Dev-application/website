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
    <title>Tableau de bord - Festiplan</title>

    <!-- CSS -->
    <?php
    Storage::include("Css/ready.css");
    ?>

    <!-- JS -->
    <script src="../node_modules/jquery/dist/jquery.min.js" defer></script>
    <script src="../node_modules/gsap/dist/gsap.min.js" defer></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>

<body>
    <div id="dashboard_main">
    <!--
    TODO:
    navbar
    main
    footer
    -->

        <header>
            <nav>
            <h1 class="logo"></h1>

            <div class="links">
                <a href="dashboard.html" class="active-link">
                <i class="fa-solid fa-home"></i>
                Tableau de bord
                </a>

                <a href="festivals.html">
                <i class="fa-solid fa-champagne-glasses"></i>
                Festivals
                </a>

                <a href="#">
                <i class="fa-solid fa-masks-theater"></i>
                Spectacles
                </a>
            </div>

            <div class="user-menu">
                <div class="user-name">
                <p>
                    <i class="fa-solid fa-angle-down"></i>
                    Utilisateur
                </p>
                </div>

                <div class="menu-dropdown-container">
                <div class="menu-dropdown">
                    <a href="#">
                    <i class="fa-solid fa-user fa-fw"></i>
                    Mon profil
                    </a>

                    <a href="#">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i>
                    Déconnexion
                    </a>
                </div>
                </div>
            </div>
            </nav>
        </header>

        <div id="main">
            <section id="latest_festivals">
            <div class="title-container">
                <h2 class="title">
                Derniers festivals
                </h2>
            </div>

            <div class="festivals-list">
                <div class="festival-preview">
                <div class="festival-picture"></div>

                <div class="festival-identity">
                    <h3 class="festival-name">
                    Festival name
                    </h3>

                    <p class="festival-description">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    Consequuntur delectus minus officiis porro possimus.
                    Ab at dignissimos eum harum in, ipsum, maxime porro possimus
                    provident quam quasi quo sint ullam.
                    </p>
                </div>

                <div class="festival-duration">
                    <div class="beginning-date">
                    01 janv. 2023
                    </div>

                    <div class="duration-arrow">
                    <svg width="61" height="19" viewBox="0 0 61 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L30.5 17.5L60.1045 1" stroke="#686868"/>
                    </svg>
                    </div>

                    <div class="ending-date">
                    02 janv. 2023
                    </div>
                </div>
                </div>
            </div>
            </section>
        </div>

        <footer class="grey-footer">
            <h1 class="logo"></h1>

            <div class="copyrights">
            2023 © Festiplan. IUT de Rodez.
            </div>

            <h1 class="logo"></h1>
        </footer>
    </div>
</body>
</html>