<header>
    <nav>
    <h1 class="logo"></h1>

    <div class="links">
        <a href="Dashboard.php" <?php echo $currentView; echo isset($currentView) && $currentView == "Dashboard.php" ? "class=\"active-link\"" : "" ?>>
        <i class="fa-solid fa-home"></i>
        Tableau de bord
        </a>

        <a href="Festivals.php"<?php echo isset($currentView) && $currentView == "Festivals.php" ? "class=\"active-link\"" : "" ?>>
        <i class="fa-solid fa-champagne-glasses"></i>
        Festivals
        </a>

        <a href="#" <?php echo isset($currentView) && $currentView == "#" ? "class=\"active-link\"" : "" ?>>
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