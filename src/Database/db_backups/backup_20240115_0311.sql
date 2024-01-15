-- Database creation
CREATE DATABASE `festiplan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE festiplan;

-- Table structure for table `utilisateur`
CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom_uti` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_uti` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_uti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_uti` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp_uti` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email_uti` (`email_uti`),
  UNIQUE KEY `login_uti` (`login_uti`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `utilisateur`
INSERT INTO utilisateur (id_utilisateur, nom_uti, prenom_uti, email_uti, login_uti, mdp_uti) VALUES ('1', 'Nom', 'Prénom', 'prenom.nom@mail.fr', 'login', '$2y$10$mM4zejhT6.hqMuQDjqD6c.9g2KlpLpnzty4dlaEF8JD0LP4MhPI0e');
INSERT INTO utilisateur (id_utilisateur, nom_uti, prenom_uti, email_uti, login_uti, mdp_uti) VALUES ('2', 'Dupont', 'Dupond', 'dupond.dupont@orange.fr', 'dupond', '$2y$10$tUKyNz2.33FU22j2J/GhKO4DNSHmLddbv3ihwGPSxT.wthehIu.HC');

-- Table structure for table `festival`
CREATE TABLE `festival` (
  `id_festival` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fe` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_fe` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illustration_fe` text COLLATE utf8mb4_unicode_ci,
  `date_debut_fe` date NOT NULL,
  `date_fin_fe` date NOT NULL,
  `id_createur` int(11) NOT NULL,
  PRIMARY KEY (`id_festival`),
  UNIQUE KEY `nom_fe` (`nom_fe`),
  KEY `id_createur` (`id_createur`),
  CONSTRAINT `festival_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `festival`
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('1', 'Festival 1 passé', 'Un festival de folie', NULL, '2024-01-01', '2024-01-03', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('2', 'Festival 2 passé', 'Un festival de folie', NULL, '2024-01-04', '2024-01-07', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('3', 'Festival 3 - Ex. planification', 'Un festival de folie', 'festival_659c4c758e872.gif', '2024-01-09', '2024-01-09', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('4', 'Festival 4', 'Un festival de folie', NULL, '2024-01-15', '2024-01-20', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('5', 'Festival 5', 'Un festival de folie', NULL, '2024-07-01', '2024-07-02', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('6', 'Festival 6', 'Un festival de folie', NULL, '2024-07-03', '2024-07-04', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('7', 'Festival 7', 'Un festival de folie', NULL, '2024-07-05', '2024-07-08', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('8', 'F\'Estivada 8', 'L\'Estivada est le Festival interrégional des cultures occitanes, créé en 1995 à l\'initiative de la ville de Rodez, qui a eu lieu tous les ans jusqu\'en 2022 la dernière semaine du mois de juillet. Il s\'agit du plus grand festival de musiques et chansons en langue occitane.', 'festival_65994c92430ec.png', '2024-07-11', '2024-07-13', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('9', 'Festival 10', 'Un festival de folie', NULL, '2024-07-30', '2024-07-31', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('10', 'Festival 11', 'Un festival de folie', NULL, '2024-07-09', '2024-07-10', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('11', 'Festival 12', 'Un festival de folie', NULL, '2024-07-10', '2024-07-20', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('12', 'Festival 13', 'Un festival de folie', NULL, '2024-07-16', '2024-07-17', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('13', 'Festival 14', 'Un festival de folie', NULL, '2024-07-18', '2024-07-19', '2');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('14', 'Festival 15', 'Un festival de folie', NULL, '2024-07-20', '2024-07-21', '1');
INSERT INTO festival (id_festival, nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur) VALUES ('15', 'Festival 16', 'Un festival de folie', NULL, '2024-07-22', '2024-07-29', '2');

-- Table structure for table `grij`
CREATE TABLE `grij` (
  `id_grij` int(11) NOT NULL AUTO_INCREMENT,
  `heure_debut_spectacles` time NOT NULL,
  `heure_fin_spectacles` time NOT NULL,
  `duree_min_entre_spectacles` time NOT NULL,
  `id_festival` int(11) NOT NULL,
  PRIMARY KEY (`id_grij`),
  KEY `id_festival` (`id_festival`),
  CONSTRAINT `grij_ibfk_1` FOREIGN KEY (`id_festival`) REFERENCES `festival` (`id_festival`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `grij`
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('1', '10:00:00', '23:00:00', '00:30:00', '1');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('2', '10:00:00', '23:00:00', '00:15:00', '2');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('3', '10:00:00', '23:00:00', '00:15:00', '3');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('4', '10:00:00', '23:00:00', '01:00:00', '4');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('5', '10:00:00', '23:00:00', '00:30:00', '5');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('6', '10:00:00', '23:00:00', '00:45:00', '6');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('7', '10:00:00', '23:00:00', '00:30:00', '7');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('8', '10:00:00', '23:00:00', '00:05:00', '8');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('9', '10:00:00', '23:00:00', '00:00:00', '9');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('10', '10:00:00', '23:00:00', '00:10:00', '10');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('11', '10:00:00', '23:00:00', '00:58:00', '11');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('12', '10:00:00', '23:00:00', '00:27:00', '12');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('13', '10:00:00', '23:00:00', '00:13:00', '13');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('14', '10:00:00', '23:00:00', '00:33:00', '14');
INSERT INTO grij (id_grij, heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival) VALUES ('15', '10:00:00', '23:00:00', '00:46:00', '15');

-- Table structure for table `scene`
CREATE TABLE `scene` (
  `id_scene` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sc` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taille_sc` int(11) NOT NULL COMMENT '1: Petite, 2: Moyenne, 3: Grande',
  `nb_max_spectateurs` int(11) DEFAULT NULL,
  `latitude_sc` float NOT NULL,
  `longitude_sc` float NOT NULL,
  PRIMARY KEY (`id_scene`),
  UNIQUE KEY `nom_sc` (`nom_sc`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `scene`
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('1', 'Scene 1', '1', '100', '-44.35', '2.56667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('2', 'Scene 2', '2', '200', '-44.35', '2.56667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('3', 'Scene 3', '3', '300', '44.35', '-2.56667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('4', 'Scene 4', '1', '100', '-44.35', '-2.56667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('5', 'Scene 5', '2', '200', '44.35', '2.56667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('6', 'Scene 6', '3', '300', '24.35', '12.5667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('7', 'Scene 7', '1', '100', '84.35', '82.5667');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('8', 'Scène principale', '2', '200', '35.5678', '-13.3456');
INSERT INTO scene (id_scene, nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc) VALUES ('9', 'Scène secondaire', '2', '200', '34.5678', '-12.3456');

-- Table structure for table `categorie`
CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `nom_cat` (`nom_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `categorie`
INSERT INTO categorie (id_categorie, nom_cat) VALUES ('3', 'Cirque');
INSERT INTO categorie (id_categorie, nom_cat) VALUES ('4', 'Danse');
INSERT INTO categorie (id_categorie, nom_cat) VALUES ('1', 'Musique');
INSERT INTO categorie (id_categorie, nom_cat) VALUES ('5', 'Projection de film');
INSERT INTO categorie (id_categorie, nom_cat) VALUES ('2', 'Théâtre');

-- Table structure for table `spectacle`
CREATE TABLE `spectacle` (
  `id_spectacle` int(11) NOT NULL AUTO_INCREMENT,
  `titre_sp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_sp` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illustration_sp` text COLLATE utf8mb4_unicode_ci,
  `duree_sp` int(11) NOT NULL,
  `taille_scene_sp` int(11) NOT NULL COMMENT '1: Petite, 2: Moyenne, 3: Grande',
  `id_createur` int(11) NOT NULL,
  PRIMARY KEY (`id_spectacle`),
  UNIQUE KEY `titre_sp` (`titre_sp`),
  KEY `id_createur` (`id_createur`),
  CONSTRAINT `spectacle_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `spectacle`
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('1', 'Concert Matt Pokora', 'Un spectacle de Matt Pokora à Rodez !', 'spectacle_65997074c8a4a.jpeg', '120', '1', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('2', 'Spectacle 2', 'Un spectacle de folie', NULL, '90', '2', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('3', 'Spectacle 3', 'Un spectacle de folie', NULL, '240', '3', '2');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('4', 'Spectacle 4', 'Un spectacle de folie', NULL, '120', '1', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('5', 'Spectacle 5', 'Un spectacle de folie', NULL, '180', '2', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('6', 'Spectacle 6', 'Un spectacle de folie', NULL, '50', '3', '2');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('7', 'Spectacle 7', 'Un spectacle de folie', NULL, '60', '1', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('8', 'Spectacle 8', 'Un spectacle de folie', NULL, '60', '2', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('9', 'Spectacle 9', 'Un spectacle de folie', NULL, '60', '3', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('10', 'Spectacle 10', 'Un spectacle de folie', NULL, '60', '1', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('11', 'Spectacle 11', 'Un spectacle de folie', NULL, '60', '2', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('12', 'Spectacle 12', 'Un spectacle de folie', NULL, '60', '3', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('13', 'Spectacle 13', 'Un spectacle de folie', NULL, '60', '1', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('14', 'Spectacle 14', 'Un spectacle de folie', NULL, '60', '2', '1');
INSERT INTO spectacle (id_spectacle, titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur) VALUES ('15', 'Spectacle 15', 'Un spectacle de folie', NULL, '60', '3', '1');

-- Table structure for table `intervenant`
CREATE TABLE `intervenant` (
  `id_intervenant` int(11) NOT NULL AUTO_INCREMENT,
  `nom_inter` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom_inter` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_inter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_intervenant`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `intervenant`
INSERT INTO intervenant (id_intervenant, nom_inter, prenom_inter, email_inter) VALUES ('1', 'Dupont', 'Jean', 'jean.dupont@example.com');
INSERT INTO intervenant (id_intervenant, nom_inter, prenom_inter, email_inter) VALUES ('2', 'Martin', 'Sophie', 'sophie.martin@example.com');

-- Table structure for table `festival_utilisateur`
CREATE TABLE `festival_utilisateur` (
  `id_festival` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_festival`,`id_utilisateur`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `festival_utilisateur_ibfk_1` FOREIGN KEY (`id_festival`) REFERENCES `festival` (`id_festival`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `festival_utilisateur_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `festival_utilisateur`
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('1', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('5', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('9', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('10', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('11', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('13', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('14', '1');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('2', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('3', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('4', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('6', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('7', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('8', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('12', '2');
INSERT INTO festival_utilisateur (id_festival, id_utilisateur) VALUES ('15', '2');

-- Table structure for table `festival_scene`
CREATE TABLE `festival_scene` (
  `id_festival` int(11) NOT NULL,
  `id_scene` int(11) NOT NULL,
  PRIMARY KEY (`id_festival`,`id_scene`),
  KEY `id_scene` (`id_scene`),
  CONSTRAINT `festival_scene_ibfk_1` FOREIGN KEY (`id_festival`) REFERENCES `festival` (`id_festival`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `festival_scene_ibfk_2` FOREIGN KEY (`id_scene`) REFERENCES `scene` (`id_scene`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `festival_scene`
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('1', '1');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '1');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('4', '1');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('1', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('2', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('4', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('5', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('6', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('7', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('8', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('9', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('10', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('11', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('12', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('13', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('14', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('15', '2');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('1', '3');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('2', '3');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '3');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '4');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('9', '4');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '5');
INSERT INTO festival_scene (id_festival, id_scene) VALUES ('3', '6');

-- Table structure for table `festival_categorie`
CREATE TABLE `festival_categorie` (
  `id_festival` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id_festival`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`),
  CONSTRAINT `festival_categorie_ibfk_1` FOREIGN KEY (`id_festival`) REFERENCES `festival` (`id_festival`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `festival_categorie_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `festival_categorie`
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('1', '1');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('3', '1');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('4', '1');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('8', '1');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('1', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('2', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('3', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('4', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('5', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('6', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('7', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('9', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('10', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('11', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('12', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('13', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('14', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('15', '2');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('1', '3');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('2', '3');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('3', '3');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('1', '4');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('3', '4');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('9', '4');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('1', '5');
INSERT INTO festival_categorie (id_festival, id_categorie) VALUES ('3', '5');

-- Table structure for table `festival_spectacle`
CREATE TABLE `festival_spectacle` (
  `id_festival` int(11) NOT NULL,
  `id_spectacle` int(11) NOT NULL,
  PRIMARY KEY (`id_festival`,`id_spectacle`),
  KEY `id_spectacle` (`id_spectacle`),
  CONSTRAINT `festival_spectacle_ibfk_1` FOREIGN KEY (`id_festival`) REFERENCES `festival` (`id_festival`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `festival_spectacle_ibfk_2` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id_spectacle`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `festival_spectacle`
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('1', '1');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '1');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('4', '1');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('8', '1');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('2', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('4', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('5', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('6', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('7', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('9', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('12', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('13', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('14', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('15', '2');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('2', '3');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '3');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '4');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '5');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('3', '6');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('10', '10');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('11', '12');
INSERT INTO festival_spectacle (id_festival, id_spectacle) VALUES ('9', '14');

-- Table structure for table `spectacle_categorie`
CREATE TABLE `spectacle_categorie` (
  `id_spectacle` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  PRIMARY KEY (`id_spectacle`,`id_categorie`),
  KEY `id_categorie` (`id_categorie`),
  CONSTRAINT `spectacle_categorie_ibfk_1` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id_spectacle`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spectacle_categorie_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `spectacle_categorie`
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('1', '1');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('3', '1');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('4', '1');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('2', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('3', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('4', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('5', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('6', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('7', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('8', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('9', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('10', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('11', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('12', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('13', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('14', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('15', '2');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('2', '3');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('3', '3');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('3', '4');
INSERT INTO spectacle_categorie (id_spectacle, id_categorie) VALUES ('9', '4');

-- Table structure for table `spectacle_intervenant`
CREATE TABLE `spectacle_intervenant` (
  `id_spectacle` int(11) NOT NULL,
  `id_intervenant` int(11) NOT NULL,
  `type_inter` int(11) NOT NULL COMMENT '1: Hors scène, 2: Sur scène',
  PRIMARY KEY (`id_intervenant`,`id_spectacle`),
  KEY `id_spectacle` (`id_spectacle`),
  CONSTRAINT `spectacle_intervenant_ibfk_1` FOREIGN KEY (`id_intervenant`) REFERENCES `intervenant` (`id_intervenant`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `spectacle_intervenant_ibfk_2` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id_spectacle`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data insertion for table `spectacle_intervenant`
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('1', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('2', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('3', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('4', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('5', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('6', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('7', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('8', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('9', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('10', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('11', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('12', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('13', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('14', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('15', '1', '1');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('2', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('3', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('4', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('5', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('6', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('7', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('8', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('9', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('10', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('11', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('12', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('13', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('14', '2', '2');
INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter) VALUES ('15', '2', '2');

DELIMITER //

-- Procedure afficherCategoriesFestival
CREATE DEFINER=`root`@`localhost` PROCEDURE `afficherCategoriesFestival`(
    IN id_festival INT
)
BEGIN
    SELECT c.nom_cat
    FROM festival_categorie fc
             INNER JOIN categorie c ON fc.id_categorie = c.id_categorie
    WHERE fc.id_festival = id_festival;
END//

-- Procedure afficherSpectaclesFestival
CREATE DEFINER=`root`@`localhost` PROCEDURE `afficherSpectaclesFestival`(
    IN id_festival INT
)
BEGIN
    SELECT s.titre_sp
    FROM festival_spectacle fs
             INNER JOIN spectacle s ON fs.id_spectacle = s.id_spectacle
    WHERE fs.id_festival = id_festival;
END//

-- Procedure ajouterFestivalCategorie
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterFestivalCategorie`(
    IN id_festival INT,
    IN id_categorie INT
)
BEGIN
    INSERT INTO festival_categorie (id_festival, id_categorie)
    VALUES (id_festival, id_categorie);
END//

-- Procedure ajouterFestivalScene
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterFestivalScene`(
    IN id_festival INT,
    IN id_scene INT
)
BEGIN
    INSERT INTO festival_scene (id_festival, id_scene)
    VALUES (id_festival, id_scene);
END//

-- Procedure ajouterFestivalSpectacle
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterFestivalSpectacle`(
    IN id_festival INT,
    IN id_spectacle INT
)
BEGIN
    INSERT INTO festival_spectacle (id_festival, id_spectacle)
    VALUES (id_festival, id_spectacle);
END//

-- Procedure ajouterFestivalUtilisateur
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterFestivalUtilisateur`(
    IN id_festival INT,
    IN id_utilisateur INT
)
BEGIN
    INSERT INTO festival_utilisateur (id_festival, id_utilisateur)
    VALUES (id_festival, id_utilisateur);
END//

-- Procedure ajouterGrij
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterGrij`(
    heuredebutspectacles TIME,
    heurefinspectacles TIME,
    dureeminentrespectacles TIME,
    idfestival INT
)
BEGIN
    IF heuredebutspectacles > heurefinspectacles THEN
        -- 45000 est pour un code d'erreur personnalisé pour date_deb > date_fin
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date de début doit être inférieure à la date de fin';
    END IF;

    INSERT INTO grij (heure_debut_spectacles, heure_fin_spectacles, duree_min_entre_spectacles, id_festival)
    VALUES (heuredebutspectacles, heurefinspectacles, dureeminentrespectacles, idfestival);
END//

-- Procedure ajouterIntervenant
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterIntervenant`(
    IN nom_inter VARCHAR(50),
    IN prenom_inter VARCHAR(25),
    IN email_inter VARCHAR(255)
)
BEGIN
    INSERT INTO intervenant (nom_inter, prenom_inter, email_inter)
    VALUES (nom_inter, prenom_inter, email_inter);
END//

-- Procedure ajouterScene
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterScene`(
    IN nom_sc VARCHAR(25),
    IN taille_sc INT,
    IN nb_max_spectateurs INT,
    IN latitude_sc FLOAT(5),
    IN longitude_sc FLOAT(5)
)
BEGIN
    INSERT INTO scene (nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc)
    VALUES (nom_sc, taille_sc, nb_max_spectateurs, latitude_sc, longitude_sc);
END//

-- Procedure ajouterSpectacleCategorie
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterSpectacleCategorie`(
    IN id_spectacle INT,
    IN id_categorie INT
)
BEGIN
    INSERT INTO spectacle_categorie (id_spectacle, id_categorie)
    VALUES (id_spectacle, id_categorie);
END//

-- Procedure ajouterSpectacleIntervenant
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterSpectacleIntervenant`(
    IN id_spectacle INT,
    IN id_intervenant INT,
    IN type_inter INT
)
BEGIN
    IF type_inter != 1 AND type_inter != 2 THEN
        -- 45000 est pour un code d'erreur personnalisé pour type_inter != 1 ou 2
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le type doit être 1 pour hors scène ou 2 pour sur scène';
    END IF;
    INSERT INTO spectacle_intervenant (id_spectacle, id_intervenant, type_inter)
    VALUES (id_spectacle, id_intervenant, type_inter);
END//

-- Procedure ajouterUtilisateur
CREATE DEFINER=`root`@`localhost` PROCEDURE `ajouterUtilisateur`(
    IN nom_uti VARCHAR(50),
    IN prenom_uti VARCHAR(25),
    IN email_uti VARCHAR(255),
    IN login_uti VARCHAR(25),
    IN mdp_uti VARCHAR(70)
)
BEGIN
    INSERT INTO utilisateur (nom_uti, prenom_uti, email_uti, login_uti, mdp_uti)
    VALUES (nom_uti, prenom_uti, email_uti, login_uti, mdp_uti);
END//

-- Procedure modifierFestival
CREATE DEFINER=`root`@`localhost` PROCEDURE `modifierFestival`(
    idfestival INT,
    nomfe VARCHAR(50),
    descriptionfe VARCHAR(1000),
    illustrationfe TEXT,
    datedebutfe DATE,
    datefinfe DATE
)
BEGIN
    IF datedebutfe > datefinfe THEN
        -- 45000 est pour un code d'erreur personnalisé pour datedeb > datefin
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date de début doit être inférieure à la date de fin';
    END IF;

    UPDATE festival
    SET nom_fe          = nomfe,
        description_fe  = descriptionfe,
        illustration_fe = illustrationfe,
        date_debut_fe   = datedebutfe,
        date_fin_fe     = datefinfe
    WHERE id_festival = idfestival;
END//

-- Procedure sauvegarderBdd
CREATE DEFINER=`root`@`localhost` PROCEDURE `sauvegarderBdd`()
BEGIN

    -- TODO

END//

-- Procedure supprimerFestival
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerFestival`(
    idfestival INT
)
BEGIN
    DELETE
    FROM festival
    WHERE id_festival = idfestival;
END//

-- Procedure supprimerFestivalScene
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerFestivalScene`(
    idfestival INT,
    idscene INT
)
BEGIN
    DELETE
    FROM festival_scene
    WHERE id_festival = idfestival
      AND id_scene = idscene;
END//

-- Procedure supprimerFestivalSpectacles
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerFestivalSpectacles`(
    idfestival INT,
    idspectacle INT
)
BEGIN
    DELETE
    FROM festival_spectacle
    WHERE id_festival = idfestival
      AND id_spectacle = idspectacle;
END//

-- Procedure supprimerFestivalUtilisateur
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerFestivalUtilisateur`(
    idfestival INT,
    idutilisateur INT
)
BEGIN
    DELETE
    FROM festival_utilisateur
    WHERE id_festival = idfestival
      AND id_utilisateur = idutilisateur;
END//

-- Procedure supprimerScene
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerScene`(
    idscene INT
)
BEGIN
    DELETE
    FROM scene
    WHERE id_scene = idscene;
END//

-- Procedure supprimerSpectacle
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerSpectacle`(
    idspectacle INT
)
BEGIN
    DELETE
    FROM spectacle
    WHERE id_spectacle = idspectacle;
END//

-- Procedure supprimerUtilisateur
CREATE DEFINER=`root`@`localhost` PROCEDURE `supprimerUtilisateur`(
    IN idutilisateur INT
)
BEGIN
    DELETE
    FROM utilisateur
    WHERE id_utilisateur = idutilisateur;
END//

-- Function ajouterFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `ajouterFestival`(
    nomfe VARCHAR(50),
    descriptionfe VARCHAR(1000),
    illustrationfe TEXT,
    datedebutfe DATE,
    datefinfe DATE,
    idcreateur INT
) RETURNS int(11)
BEGIN
    DECLARE idFestival INT;

    IF datedebutfe > datefinfe THEN
        -- 45000 est pour un code d'erreur personnalisé pour date_deb > date_fin
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La date de début doit être inférieure à la date de fin';
    END IF;

    INSERT INTO festival (nom_fe, description_fe, illustration_fe, date_debut_fe, date_fin_fe, id_createur)
    VALUES (nomfe, descriptionfe, illustrationfe, datedebutfe, datefinfe, idcreateur);

    -- Récupérer l'ID généré par l'insertion
    SET idFestival = LAST_INSERT_ID();

    RETURN idFestival;
END//

-- Function ajouterSpectacle
CREATE DEFINER=`root`@`localhost` FUNCTION `ajouterSpectacle`(
    titre_sp VARCHAR(50),
    description_sp VARCHAR(1000),
    illustration_sp TEXT,
    duree_sp INT,
    taille_scene_sp INT,
    id_createur INT
) RETURNS int(11)
BEGIN
    DECLARE idSpectacle INT;

    INSERT INTO spectacle (titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur)
    VALUES (titre_sp, description_sp, illustration_sp, duree_sp, taille_scene_sp, id_createur);

    -- Récupérer l'ID généré par l'insertion
    SET idSpectacle = LAST_INSERT_ID();

    RETURN idSpectacle;
END//

-- Function recupererIdFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `recupererIdFestival`(
    nom_fe VARCHAR(50)
) RETURNS int(11)
BEGIN
    DECLARE idFestival INT;

    SELECT fe.id_festival
    INTO idFestival
    FROM festival fe
    WHERE fe.nom_fe = nom_fe;

    RETURN idFestival;
END//

-- Function verifierFestivalComplet
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierFestivalComplet`(
    id_festival INT
) RETURNS tinyint(1)
BEGIN
    DECLARE valide BOOLEAN;

    IF verifierSceneFestival(id_festival)
        AND verifierSpectacleFestival(id_festival)
        AND verifierGrijFestival(id_festival) THEN
        SET valide = true;
    ELSE
        SET valide = false;
    END IF;

    RETURN valide;
END//

-- Function verifierFestivalExiste
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierFestivalExiste`(
    nomFestival VARCHAR(50)
) RETURNS tinyint(1)
BEGIN
    DECLARE resultat INT;

    SELECT COUNT(nom_fe)
    INTO resultat
    FROM festival
    WHERE nom_fe = nomFestival;

    IF resultat > 0 THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;

END//

-- Function verifierGrijFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierGrijFestival`(
    id_festival INT
) RETURNS tinyint(1)
BEGIN
    DECLARE nb_grij INT;

    SELECT COUNT(*)
    INTO nb_grij
    FROM grij g
    WHERE g.id_festival = id_festival;

    IF nb_grij > 0 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END//

-- Function verifierOrganisateurFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierOrganisateurFestival`(
    id_festival INT
) RETURNS tinyint(1)
BEGIN
    DECLARE nb_organisateur INT;

    SELECT COUNT(*)
    INTO nb_organisateur
    FROM festival_utilisateur fu
    WHERE fu.id_festival = id_festival;

    IF nb_organisateur > 0 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END//

-- Function verifierSceneFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierSceneFestival`(
    id_festival INT
) RETURNS tinyint(1)
BEGIN
    DECLARE nb_scene INT;

    SELECT COUNT(*)
    INTO nb_scene
    FROM festival_scene fs
    WHERE fs.id_festival = id_festival;

    IF nb_scene > 0 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END//

-- Function verifierSpectacleExiste
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierSpectacleExiste`(
    titreSpectacle VARCHAR(50)
) RETURNS tinyint(1)
BEGIN
    DECLARE resultat INT;

    SELECT COUNT(titre_sp)
    INTO resultat
    FROM spectacle
    WHERE titre_sp = titreSpectacle;

    IF resultat > 0 THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;

END//

-- Function verifierSpectacleFestival
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierSpectacleFestival`(
    id_festival INT
) RETURNS tinyint(1)
BEGIN
    DECLARE nb_spectacle INT;

    SELECT COUNT(*)
    INTO nb_spectacle
    FROM festival_spectacle fs
    WHERE fs.id_festival = id_festival;

    IF nb_spectacle > 0 THEN
        RETURN true;
    ELSE
        RETURN false;
    END IF;
END//

-- Function verifierTailleScene
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierTailleScene`(
    id_spectacle INT,
    id_scene INT
) RETURNS tinyint(1)
BEGIN
    DECLARE taille_scene_spectacle INT;
    DECLARE taille_scene INT;

    SELECT s.taille_scene_sp
    INTO taille_scene_spectacle
    FROM spectacle s
    WHERE s.id_spectacle = id_spectacle;

    SELECT sc.taille_sc
    INTO taille_scene
    FROM scene sc
    WHERE sc.id_scene = id_scene;

    IF taille_scene_spectacle > taille_scene THEN
        RETURN false;
    ELSE
        RETURN true;
    END IF;
END//

-- Function verifierUsageEmail
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierUsageEmail`(
    email VARCHAR(255)
) RETURNS tinyint(4)
BEGIN
    DECLARE presence_email TINYINT;

    SELECT COUNT(*) as count
    INTO presence_email
    FROM utilisateur
    WHERE email_uti = email;

    RETURN presence_email;
END//

-- Function verifierUsageLogin
CREATE DEFINER=`root`@`localhost` FUNCTION `verifierUsageLogin`(
    loginuti VARCHAR(25)
) RETURNS tinyint(4)
BEGIN
    DECLARE presence_login TINYINT;

    SELECT COUNT(*) as count
    INTO presence_login
    FROM utilisateur
    WHERE login_uti = loginuti;

    RETURN presence_login;
END//

DELIMITER ;
