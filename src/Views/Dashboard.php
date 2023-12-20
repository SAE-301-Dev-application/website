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

        <?php
            $currentView = "Dashboard.php";  
            Storage::component("HeaderComponent");
        ?>

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
        
        <?php
        Storage::component("FooterComponent");
        ?>

    </div>
</body>
</html>