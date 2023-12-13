# Développement statique de Festiplan
Cette version a pour objectif de concrétiser l'interface modélisée sur 
**Figma** avec les librairies et technologies qui seront utilisées sur le 
produit final.

## Installation du projet.
Pour installer le projet, vous devez clôner le dépôt GitHub, à la branche 
`static`.

Une fois ceci fait, ouvrez un terminal ciblant le dossier racine du dossier 
créé par le clônage, et lancez la commande `npm install`.

## Compilation pré-processeur du CSS.
Nous utilisons **SCSS** pour la définition du style des interfaces. Il 
s'agit d'un langage dit **pré-processeur**, c'est-à-dire qu'il est ensuite 
converti en **CSS** pur. Il permet une légèreté d'écriture grâce à l'apport 
des imbrications, variables et références aux éléments parents.

Afin de lancer le convertisseur **SCSS → CSS**, ouvrez un terminal ciblant 
la racine du projet clôné, et lancez la commande `npm run dev`.

---
🔗 **Maquettes Figma :** [cliquer ici](https://www.figma.com/file/cLVqCZBhZ2x1X67TSpMvsY/Maquette-Festiplan?type=design&node-id=0%3A1&mode=design&t=UZZhdu5YVisIvoPA-1)