<div align="center">

# SAÉ 301 - Développement d'une application | Festiplan

</div>

Ce projet a pour but de réaliser un site web pour la start-up **Festiplan**, permettant aux utilisateurs de créer et planifier des festivals et leur contenu.
Le principal avantage du site est la génération d'un planning après les informations nécessaires renseignées.
Ce site a été réalisé en PHP, HTML, CSS et JavaScript en utilisant le framework MVCLite.

## Installation du projet
Pour installer le projet, clônez le dépot GitHub dans un dossier avec la commande :\
`git clone https://github.com/SAE-301-Dev-application/website.git`

Si vous utilisez UwAmp en tant que serveur local, clônez le dossier "website" dans le dossier "www".

Connectez-vous à votre SGBD, via le panel phpMyAdmin par exemple, et exécutez le [script SQL de création de la base de données](https://drive.google.com/file/d/1fTX8Qq5t0OjFGtOYTDCt6fh9DNuaD3RE/view?usp=sharing).

Téléchargez et configurez [Node.js](https://nodejs.org/en/download) et [Composer](https://getcomposer.org/download/).
Vous aurez besoin d'ajouter [php8.3.1](https://www.php.net/downloads.php) (minimum) lors de la configuration de Composer.
Si vous êtes sur Windows, pensez à ajouter php au PATH avant d'installer Composer.

Une fois ceci fait, ouvrez un terminal ciblant le dossier racine du dossier créé par le clônage.
Exécutez les commandes `npm install` puis `composer install ; composer update`.

## Compilation pré-processeur du CSS.
Nous utilisons **SCSS** pour la définition du style des interfaces.
Il s'agit d'un langage dit **pré-processeur**, c'est-à-dire qu'il est ensuite converti en **CSS**.
Il permet une légèreté d'écriture grâce à l'apport des imbrications, variables et références aux éléments parents.

Sur Visual Studio Code, installez l'extension **Live Sass Compiler**.
Commencez par créer dans le dossier `src/Resources/Css/Views` les fichiers CSS avec le même nom que ceux de type SCSS ignorés dans le fichier *.gitignore*.

L'extension *Live Sass* vous permettra de compiler vos fichiers SCSS en fichiers CSS en cliquant sur `F1` puis en écrivant et exécutant `Live Sass: Watch Sass`.
Vous pouvez également re-compiler manuellement un fichier SCSS en CSS via la commande `Live Sass: Compile Current Sass File`.

Afin de lancer le framework CSS utilisé, ouvrez un terminal ciblant la racine du projet clôné, et exécutez la commande `npm run tailwindcss`.

### Technologies utilisées
- Framework MVC : [MVCLite](https://github.com/belicfr/MVCLite)
- Framework CSS : [TailwindCSS](https://tailwindcss.com/)
- SCSS (de SASS) : [SASS](https://sass-lang.com/)
- Composer : [Composer](https://getcomposer.org/)
- NodeJS : [NodeJS](https://nodejs.org/en)

## Contributeurs (Nom Prénom / E-Mail / Page GitHub)
- FABRE Florian / florian.fabre@iut-rodez.fr / [Florian](https://github.com/Odonata971)
- FAUGIÈRES Loïc / loic.faugieres@iut-rodez.fr / [Loïc](https://github.com/xGk93)
- GUIL Jonathan / jonathan.guil@iut-rodez.fr / -
- GUIRAUD Simon / simon.guiraud@iut-rodez.fr / [Simon](https://github.com/SyberSim)
- LACAM Samuel / samuel.lacam@iut-rodez.fr / [Samuel](https://github.com/SamuelLacam)

## Répartition des rôles selon les itérations SCRUM : 

| Sprints   | Florian       | Loïc          | Jonathan      | Simon         | Samuel         |
|-----------|---------------|---------------|---------------|---------------|----------------|
| Sprint 0  | Développeur   | SCRUM Master  | Développeur   | Product Owner |  Développeur   |
| Sprint 1  | Product Owner |  Développeur  | Développeur   | SCRUM master  |  Développeur   |
| Sprint 2  | SCRUM master  | Développeur   | Product Owner | Développeur   |  Développeur   |


## Liens

- GitHub :
  - Repository : https://github.com/SAE-301-Dev-application/website
  - Board agile : https://github.com/orgs/SAE-301-Dev-application/projects/5
- Google Drive : https://drive.google.com/drive/u/1/folders/0AIv7Byh6nxapUk9PVA
- Serveur Discord de discussions : https://discord.gg/jhcd7aprgZ
- Site internet Festiplan : https://festiplan-a2.000webhostapp.com/website

- Repository GitHub du projet Java : https://github.com/SAE-301-Dev-application/java-app






