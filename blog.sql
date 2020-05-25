-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 18 mai 2020 à 11:50
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `isValid` tinyint(4) NOT NULL DEFAULT '0',
  `author` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `validation_date` datetime DEFAULT NULL,
  `validator` int(11) DEFAULT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commentaire_validateur_idx` (`validator`),
  KEY `commentaire_auteur_idx` (`author`),
  KEY `commentaire_post_idx` (`post`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `isValid`, `author`, `creation_date`, `validation_date`, `validator`, `post`) VALUES
(1, 'Trop bien', 1, 1, '2020-05-07 11:01:16', '2020-05-07 09:20:00', 1, 1),
(2, 'Quatrième fils du roi Æthelwulf, Æthelred succède à son frère aîné Æthelberht sur le trône. Son bref règne est principalement marqué par la lutte contre les Vikings de la Grande Armée, qui envahissent le Wessex en 870. Æthelred et son frère cadet Alfred sont vaincus à la bataille de Reading en janvier 871, mais ils remportent la bataille d\'Ashdown quatre jours plus tard. Deux autres défaites s\'ensuivent pour les Anglais, à Basing fin janvier et à Meretun deux mois plus tard. Æthelred collabore par ailleurs avec le royaume voisin de Mercie, sur lequel règne son beau-frère Burgred, en alignant ses monnaies sur les siennes. C\'est la première frappe monétaire commune à tout le sud de l\'Angleterre.', 1, 1, '2020-05-15 15:36:33', NULL, 1, 1);

--
-- Déclencheurs `comment`
--
DROP TRIGGER IF EXISTS `comment_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `comment_BEFORE_INSERT` BEFORE INSERT ON `comment` FOR EACH ROW BEGIN
    SET NEW.creation_date := SYSDATE();
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `comment_BEFORE_UPDATE`;
DELIMITER $$
CREATE TRIGGER `comment_BEFORE_UPDATE` BEFORE UPDATE ON `comment` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `creation_date` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `chapo` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_auteur_idx` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `content`, `creation_date`, `author`, `chapo`, `title`, `modification_date`) VALUES
(1, 'Premier Texte', '2020-05-07 11:01:16', 1, 'blablou', 'test test', '2020-05-07 11:35:25'),
(2, 'Second Texte', '2020-05-07 11:01:16', 1, 'test2', 'Titre 2', '2020-05-11 14:28:39');

--
-- Déclencheurs `post`
--
DROP TRIGGER IF EXISTS `post_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `post_BEFORE_INSERT` BEFORE INSERT ON `post` FOR EACH ROW BEGIN
    SET NEW.creation_date := SYSDATE();
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `post_BEFORE_UPDATE`;
DELIMITER $$
CREATE TRIGGER `post_BEFORE_UPDATE` BEFORE UPDATE ON `post` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
    SET NEW.modification_date := SYSDATE();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `pseudo` varchar(45) NOT NULL,
  `mail_address` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` int(11) NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `pseudo`, `mail_address`, `password`, `active`, `creation_date`, `type`, `modification_date`) VALUES
(1, 'Florian', 'LEBOUL', 'florianleboul', 'florianleboul@gmail.com', '$2y$10$VNBcE3.BTj1NqXSGgCr1reMdymt.qB8IK4szHO', 1, '2020-05-07 11:01:16', 2, NULL),
(2, 'Emilie', 'MUSSET', 'emymbs', 'emilie.musset5@gmail.com', '$2y$10$FzhY4WdjHVWUzGX7kM2CxuUSV5QzGg7IqTteWx', 1, '2020-05-07 11:01:16', 1, NULL);

--
-- Déclencheurs `user`
--
DROP TRIGGER IF EXISTS `user_BEFORE_INSERT`;
DELIMITER $$
CREATE TRIGGER `user_BEFORE_INSERT` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
	SET NEW.creation_date := SYSDATE();
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `user_BEFORE_UPDATE`;
DELIMITER $$
CREATE TRIGGER `user_BEFORE_UPDATE` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
    SET NEW.modification_date := SYSDATE();
END
$$
DELIMITER ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `commentaire_auteur` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `commentaire_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `commentaire_validateur` FOREIGN KEY (`validator`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_auteur` FOREIGN KEY (`author`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
