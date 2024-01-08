<?php

use MvcLite\Engine\Session\Session;

?>


<header>
  <nav>
    <h1 class="logo"></h1>

    <div class="links">
      <a href="<?= route("dashboard") ?>"
         <?= $props->getProps()["currentRoute"]->getPath() == "/dashboard" ? "class=\"active-link\"" : "" ?>>

        <i class="fa-solid fa-home"></i>
        Tableau de bord

      </a>

      <a href="<?= route("festivals") ?>"
         <?= $props->getProps()["currentRoute"]->getPath() == "/festivals" ? "class=\"active-link\"" : "" ?>>

        <i class="fa-solid fa-champagne-glasses"></i>
        Festivals

      </a>

      <a href="#"
         <?= $props->getProps()["currentRoute"]->getPath() == "#" ? "class=\"active-link\"" : "" ?>>

        <i class="fa-solid fa-masks-theater"></i>
        Spectacles

      </a>
  </div>

  <div class="user-menu">
    <div class="user-name">
    <p>
      <i class="fa-solid fa-angle-down"></i>
      <?= Session::getUserAccount()->getFirstname() ?>
      <?= Session::getUserAccount()->getLastname() ?>
    </p>
    </div>

    <div class="menu-dropdown-container">
    <div class="menu-dropdown">
      <a href="<?= route("profile") ?>">
        <i class="fa-solid fa-user fa-fw"></i>
        Mon profil
      </a>

      <a href="<?= route("logout") ?>">
        <i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i>
        Déconnexion
      </a>
    </div>
    </div>
  </div>
  </nav>
</header>