-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour film_pierre-arthur
CREATE DATABASE IF NOT EXISTS `film_pierre-arthur` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `film_pierre-arthur`;

-- Listage de la structure de la table film_pierre-arthur. acteur
CREATE TABLE IF NOT EXISTS `acteur` (
  `id_acteur` int(11) NOT NULL AUTO_INCREMENT,
  `personne_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_acteur`),
  KEY `FK_acteur_personne` (`personne_id`),
  CONSTRAINT `FK_acteur_personne` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.acteur : ~6 rows (environ)
/*!40000 ALTER TABLE `acteur` DISABLE KEYS */;
INSERT INTO `acteur` (`id_acteur`, `personne_id`) VALUES
	(1, 6),
	(2, 7),
	(3, 8),
	(4, 9),
	(5, 10),
	(6, 11),
	(7, 12);
/*!40000 ALTER TABLE `acteur` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. appartenir
CREATE TABLE IF NOT EXISTS `appartenir` (
  `id_film` int(255) DEFAULT NULL,
  `id_genre` int(255) DEFAULT NULL,
  KEY `FK_appartenir_film` (`id_film`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `FK_appartenir_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_appartenir_genre` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.appartenir : ~5 rows (environ)
/*!40000 ALTER TABLE `appartenir` DISABLE KEYS */;
INSERT INTO `appartenir` (`id_film`, `id_genre`) VALUES
	(1, 4),
	(2, 2),
	(5, 6),
	(3, 1),
	(4, 1);
/*!40000 ALTER TABLE `appartenir` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. casting
CREATE TABLE IF NOT EXISTS `casting` (
  `film_id` int(11) DEFAULT NULL,
  `acteur_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  KEY `FK_casting_film` (`film_id`),
  KEY `FK_casting_acteur` (`acteur_id`),
  KEY `FK_casting_role` (`role_id`),
  CONSTRAINT `FK_casting_acteur` FOREIGN KEY (`acteur_id`) REFERENCES `acteur` (`id_acteur`),
  CONSTRAINT `FK_casting_film` FOREIGN KEY (`film_id`) REFERENCES `film` (`id_film`),
  CONSTRAINT `FK_casting_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.casting : ~1 rows (environ)
/*!40000 ALTER TABLE `casting` DISABLE KEYS */;
INSERT INTO `casting` (`film_id`, `acteur_id`, `role_id`) VALUES
	(1, 7, 1),
	(2, 5, 2);
/*!40000 ALTER TABLE `casting` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. film
CREATE TABLE IF NOT EXISTS `film` (
  `id_film` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL DEFAULT '0',
  `annee` int(11) NOT NULL DEFAULT '0',
  `duree` int(11) NOT NULL DEFAULT '0',
  `synopsis` text NOT NULL,
  `note5` int(11) DEFAULT NULL,
  `lien_affiche` varchar(255) DEFAULT NULL,
  `realisateur_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_film`),
  KEY `FK_film_realisateur` (`realisateur_id`),
  CONSTRAINT `FK_film_realisateur` FOREIGN KEY (`realisateur_id`) REFERENCES `realisateur` (`id_realisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.film : ~5 rows (environ)
/*!40000 ALTER TABLE `film` DISABLE KEYS */;
INSERT INTO `film` (`id_film`, `titre`, `annee`, `duree`, `synopsis`, `note5`, `lien_affiche`, `realisateur_id`) VALUES
	(1, 'Forrest Gump', 1994, 142, 'C\'est un mec trop con pour arrêter de courir', 0, 'https://www.google.com/url?sa=i&url=https%3A%2F%2Ffr.aleteia.org%2Fcategory%2Ftemoignage%2F&psig=AOvVaw2paDI-u_0cD36wSMDhFLsh&ust=1678891880680000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCNCb9OPV2_0CFQAAAAAdAAAAABAE', 2),
	(2, 'Fight club', 1999, 139, 'Pourvu d\'une situation des plus enviable, un jeune homme à bout de nerfs retrouve un équilibre relatif en compagnie de Marla, rencontrée dans un groupe d\'entraide. Il fait également la connaissance de Tyler Durden, personnage enthousiaste et charismatique.', 6, 'https://resize-elle.ladmedia.fr/rcrop/638,,forcex/img/var/plain_site/storage/images/loisirs/cinema/dossiers/films-a-voir-une-fois/fight-club-de-david-fincher/72577306-1-fre-FR/Fight-Club-de-David-Fincher.jpg', 3),
	(3, 'La route', 2009, 111, 'Il y a maintenant plus de dix ans que le monde a explosé. Personne ne sait ce qui s\'est passé. Ceux qui ont survécu se souviennent d\'un gigantesque éclair aveuglant, et puis plus rien. Plus d\'énergie, plus de végétation, plus de nourriture. Les derniers survivants rôdent dans un monde dévasté et couvert de cendre qui n\'est plus que l\'ombre de ce qu\'il fut.', 5, 'https://fr.web.img2.acsta.net/medias/nmedia/18/67/04/72/19193602.jpg', 4),
	(4, 'Le livre d\'Eli', 2010, 118, 'Trente ans après qu\'une guerre a dévasté le monde, Eli, un guerrier solitaire, erre dans un paysage en ruines, ramenant l\'espoir à l\'humanité. Un seul autre homme est conscient du pouvoir qu\'Eli ramène et il est déterminé à se l\'attribuer.', 5, 'https://fr.web.img6.acsta.net/medias/nmedia/18/73/75/37/19214558.jpg', 5),
	(5, 'Fullmetal Alchemist', 2001, 120, 'C\'est un manchot qui fait de la magie pour redonner un corp à son petit frère', 5, 'https://fr.web.img4.acsta.net/pictures/19/07/30/12/08/0075575.jpg', 1);
/*!40000 ALTER TABLE `film` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. genre
CREATE TABLE IF NOT EXISTS `genre` (
  `id_genre` int(11) NOT NULL AUTO_INCREMENT,
  `nom_genre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.genre : ~6 rows (environ)
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` (`id_genre`, `nom_genre`) VALUES
	(1, 'post_apo'),
	(2, 'policier'),
	(3, 'horreur'),
	(4, 'comedie'),
	(5, 'romance'),
	(6, 'fantastique');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. personne
CREATE TABLE IF NOT EXISTS `personne` (
  `id_personne` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL DEFAULT '0',
  `prenom` varchar(50) NOT NULL DEFAULT '0',
  `sexe` varchar(50) NOT NULL DEFAULT '0',
  `date_naissance` date DEFAULT NULL,
  PRIMARY KEY (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.personne : ~12 rows (environ)
/*!40000 ALTER TABLE `personne` DISABLE KEYS */;
INSERT INTO `personne` (`id_personne`, `nom`, `prenom`, `sexe`, `date_naissance`) VALUES
	(1, 'Arakawa', 'Hiromu', 'F', '1972-05-08'),
	(2, 'Zemeckis', 'Robert', 'H', '1952-05-14'),
	(3, 'Fincher', 'David', 'H', '1962-08-28'),
	(4, 'Hillcoat', 'John', 'H', '1960-03-14'),
	(5, 'Hughes', 'Albert', 'H', '1972-04-01'),
	(6, 'Washington', 'Denzel', 'H', '1954-12-28'),
	(7, 'Mortensen', 'Viggo', 'H', '1958-10-20'),
	(8, 'Theron', 'Charlize', 'F', '1975-08-07'),
	(9, 'Norton ', 'Edward', 'H', '1969-08-18'),
	(10, 'Pitt', 'Brad', 'H', '1963-12-18'),
	(11, 'Helena', 'Bonham Carter', 'F', '1966-05-26'),
	(12, 'Hanks', 'Tom', 'H', '1956-07-09');
/*!40000 ALTER TABLE `personne` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. realisateur
CREATE TABLE IF NOT EXISTS `realisateur` (
  `id_realisateur` int(11) NOT NULL AUTO_INCREMENT,
  `personne_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_realisateur`),
  KEY `FK_realisateur_personne` (`personne_id`),
  CONSTRAINT `FK_realisateur_personne` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id_personne`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.realisateur : ~5 rows (environ)
/*!40000 ALTER TABLE `realisateur` DISABLE KEYS */;
INSERT INTO `realisateur` (`id_realisateur`, `personne_id`) VALUES
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5);
/*!40000 ALTER TABLE `realisateur` ENABLE KEYS */;

-- Listage de la structure de la table film_pierre-arthur. role
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Listage des données de la table film_pierre-arthur.role : ~7 rows (environ)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id_role`, `nom_role`) VALUES
	(1, 'Forrest'),
	(2, 'Tyler'),
	(3, 'Marla'),
	(4, 'Richard Chesler'),
	(5, 'Eli'),
	(6, 'Le père'),
	(7, 'Edward Elric');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
