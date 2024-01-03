# Festiplan

## Développement du projet sur le framework MVCLite
Cette version du site à pour objectif de créer la version dynamique du site en utilisant les vues de la version statique en créant le modèle et le contrôleur de celles-ci en utilisant le framework MVCLite.

## Installation du projet
Pour installer le projet, clônez le dépot GitHub et déplacez-vous sur la branche version-mvclite.

Télécharger Node.js et Composer (si vous ne l'avez pas déjà).


Une fois ceci fait, ouvrez un terminal ciblant le dossier racine du dossier 
créé par le clônage, et lancez la commande `npm install`, `npm run tailwindcss`.

## Compilation pré-processeur du CSS.
Nous utilisons **SCSS** pour la définition du style des interfaces. Il 
s'agit d'un langage dit **pré-processeur**, c'est-à-dire qu'il est ensuite 
converti en **CSS** pur. Il permet une légèreté d'écriture grâce à l'apport 
des imbrications, variables et références aux éléments parents.

Afin de lancer le convertisseur **SCSS → CSS**, ouvrez un terminal ciblant 
la racine du projet clôné, et lancez la commande `npm run dev`.

## Technologies utilisées
- Framework MVC : [MVCLite](https://github.com/belicfr/MVCLite)
- Framework CSS : [TailwindCSS](https://tailwindcss.com/)
- SCSS (de SASS) : [SASS](https://sass-lang.com/)
- Composer : [Composer](https://getcomposer.org/)
- NodeJS : [NodeJS](https://nodejs.org/en)