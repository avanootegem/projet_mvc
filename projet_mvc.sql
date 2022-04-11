-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 11 avr. 2022 à 14:10
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `id_movie` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  `spoiler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comment`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `id_movie`, `id_user`, `comment`, `post_date`, `spoiler`) VALUES
(1, 1, 1, 'Bon film', '2022-04-08 00:28:35', 0);

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id_movie` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year(4) DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `synopsis` text COLLATE utf8mb4_unicode_ci,
  `id_type` int(11) DEFAULT NULL,
  `released` tinyint(1) NOT NULL,
  `favorite` tinyint(1) NOT NULL,
  `redirect` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_movie`),
  KEY `id_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id_movie`, `title`, `year`, `poster`, `synopsis`, `id_type`, `released`, `favorite`, `redirect`) VALUES
(1, 'Harry Potter à l\'école des sorciers', 2001, 'harryPotter1.jpg', 'Orphelin, le jeune Harry Potter peut enfin quitter ses tyranniques oncle et tante Dursley lorsqu\'un curieux messager lui révèle qu\'il est un sorcier. À 11 ans, Harry va enfin pouvoir intégrer la légendaire école de sorcellerie de Poudlard, y trouver une famille digne de ce nom et des amis, développer ses dons, et préparer son glorieux avenir.', 1, 1, 1, 0),
(2, 'Harry Potter et la chambre des secrets', 2002, 'harryPotter2.jpg', 'L\'elfe Dobby a bien tenté d\'empêcher Harry de retourner à l\'École des Sorciers, frappée d\'une terrible malédiction, mais Harry n\'est pas près de laisser choir ses amis. Après une fugue et une rentrée scolaire plutôt chaotique, voici notre valeureux sorcier intégré à Poudlard. Les forces maléfiques n\'ont qu\'à bien se tenir.', 1, 1, 1, 0),
(3, 'Harry Potter et le Prisonnier d\'Azkaban', 2004, 'harryPotter3.jpg', 'Sirius Black, un dangereux sorcier criminel, s\'échappe de la sombre prison d\'Azkaban avec un seul et unique but : se venger d\'Harry Potter, entré avec ses amis Ron et Hermione en troisième année à l\'école de sorcellerie de Poudlard, où ils auront aussi à faire avec les terrifiants Détraqueurs.', 1, 1, 0, 0),
(4, 'Harry Potter et la Coupe de Feu', 2005, 'harryPotter4.jpg', 'La quatrième année à l\'école de Poudlard est marquée par le Tournoi des trois sorciers. Les participants sont choisis par la fameuse coupe de feu qui est à l\'origine d\'un scandale. Elle sélectionne Harry Potter alors qu\'il n\'a pas l\'âge légal requis !', 1, 1, 0, 0),
(5, 'Harry Potter et l\'Ordre du Phénix', 2007, 'harryPotter5.jpg', 'Alors qu\'il entame sa cinquième année d\'études à Poudlard, Harry Potter découvre que la communauté des sorciers ne semble pas croire au retour de Voldemort, convaincue par une campagne de désinformation orchestrée par le Ministre de la Magie Cornelius Fudge.', 1, 1, 1, 0),
(6, 'Harry Potter et le Prince de sang-mêmé', 2009, 'harryPotter6.jpg', 'L\'étau démoniaque de Voldemort se resserre sur l\'univers des `Moldus\' et le monde de la sorcellerie. Poudlard a cessé d\'être un havre de paix, le danger rode au coeur du château. Cependant, Dumbledore est plus décidé que jamais à préparer Harry à son combat final, désormais imminent.', 1, 1, 0, 0),
(7, 'Harry Potter et les Reliques de la Mort - 1ère Partie', 2010, 'harryPotter7.jpg', 'Le dénouement des aventures du jeune sorcier, commencées sept éditions plus tôt, approche. Plus terrifiant et puissant que jamais, Voldemort, accompagné de ses fidèles servants, les Mangemorts, contrôle quasiment l\'ensemble du monde des sorciers. Pour le vaincre, Harry, Ron et Hermione n\'ont d\'autre choix que de détruire les Horcruxes, garants de l\'immortalité du Seigneur des Ténèbres. Seulement, leur mission n\'est pas sans risques.', 1, 1, 0, 0),
(8, 'Harry Potter et les Reliques de la Mort - 2ème Partie', 2011, 'harryPotter8.jpg', 'Dans la 2e Partie de cet épisode final, le combat entre les puissances du bien et du mal de l\'univers des sorciers se transforme en guerre sans merci. Les enjeux n\'ont jamais été si considérables et personne n\'est en sécurité. Mais c\'est Harry Potter qui peut être appelé pour l\'ultime sacrifice alors que se rapproche l\'ultime épreuve de force avec Voldemort.', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `participate`
--

DROP TABLE IF EXISTS `participate`;
CREATE TABLE IF NOT EXISTS `participate` (
  `id_participate` int(11) NOT NULL AUTO_INCREMENT,
  `id_movie` int(11) NOT NULL,
  `id_person` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id_participate`),
  KEY `id_movie` (`id_movie`),
  KEY `id_person` (`id_person`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participate`
--

INSERT INTO `participate` (`id_participate`, `id_movie`, `id_person`, `id_role`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 2),
(4, 1, 4, 2),
(5, 2, 1, 1),
(6, 2, 2, 2),
(7, 2, 3, 2),
(8, 2, 4, 2),
(9, 3, 5, 1),
(10, 3, 2, 2),
(11, 3, 3, 2),
(12, 3, 4, 2),
(13, 4, 6, 1),
(14, 4, 2, 2),
(15, 4, 3, 2),
(16, 4, 4, 2),
(17, 5, 7, 1),
(18, 5, 2, 2),
(19, 5, 3, 2),
(20, 5, 4, 2),
(21, 6, 7, 1),
(22, 6, 2, 2),
(23, 6, 3, 2),
(24, 6, 4, 2),
(25, 7, 7, 1),
(26, 7, 2, 2),
(27, 7, 3, 2),
(28, 7, 4, 2),
(29, 8, 7, 1),
(30, 8, 2, 2),
(31, 8, 3, 2),
(32, 8, 4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `person`
--

DROP TABLE IF EXISTS `person`;
CREATE TABLE IF NOT EXISTS `person` (
  `id_person` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` text COLLATE utf8mb4_unicode_ci,
  `birthdate` date NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `person`
--

INSERT INTO `person` (`id_person`, `firstname`, `lastname`, `picture`, `birthdate`, `biography`) VALUES
(1, 'Chris', 'Colombus', NULL, '1958-09-10', 'Chris Columbus effectue ses études secondaires dans une bourgade de l\'Ohio et développe son imagination créatrice en dessinant des storyboards et en réalisant de petits films de fiction en Super-8. À 21 ans, durant ses études de cinéma à la Tisch School of the Arts de New York, il vend son premier script, Jocks, l\'histoire semi-autobiographique d\'un jeune lycéen catholique qui tente de devenir joueur de football.'),
(2, 'Daniel', 'Radcliffe', NULL, '1989-07-23', 'Daniel Radcliffe, né le 23 juillet 1989 dans le quartier londonien de Fulham, est un acteur et producteur britannique.\r\n\r\nIl devient mondialement célèbre en jouant le rôle de Harry Potter dans la série de films du même nom, entre 2001 et 2011. Daniel Radcliffe est alors l\'un des acteurs les mieux payés au monde, acquérant une grande popularité et un succès critique. Il est nommé pour de nombreuses récompenses et en remporte plusieurs pour ce rôle.'),
(3, 'Emma', 'Watson', NULL, '1990-04-15', 'Emma Watson, née le 15 avril 1990 à Paris, en France, est une actrice britannique. Elle est devenue célèbre en jouant, de son enfance en 2001 à l\'âge adulte en 2011, le rôle d\'Hermione Granger, l\'un des trois rôles principaux dans la série des films Harry Potter. Elle est nommée pour de nombreuses récompenses pour son rôle, et en remporte plusieurs.'),
(4, 'Rupert', 'Grint', NULL, '1988-08-24', 'Rupert Grint, né le 24 août 1988 à Harlow dans l\'Essex, est un acteur et producteur britannique.\r\n\r\nIl devient mondialement célèbre en interprétant Ron Weasley, l\'un des trois rôles principaux dans la série des films Harry Potter, aux côtés de Daniel Radcliffe et Emma Watson. Durant les dix premières années de sa carrière, Grint est nommé pour de nombreuses récompenses et en remporte plusieurs.'),
(5, 'Alfonso', 'Cuarón', NULL, '1961-11-28', 'Alfonso Cuarón passe son enfance à proximité des studios Churubusco à Mexico. Il filme ses premières images à 12 ans lorsqu\'il reçoit une caméra. Après ses études secondaires, il étudie la philosophie à l\'Université nationale autonome du Mexique (UNAM) et le cinéma au CUEC (Centro Universitario de Estudios Cinematográficos), section de la même université. Pendant ses études au Centre universitaire d\'études cinématographiques, il rencontre la future mère de son fils Jonas, le réalisateur Carlos Marcovich et le directeur de photographie Emmanuel Lubezki. En leur compagnie, il réalise son premier court métrage, Vengeance is Mine. Ce dernier déclenche une controverse, notamment pour le choix de la langue de tournage (anglais et non espagnol) et lui vaut d\'être renvoyé de la faculté.'),
(6, 'Mike', 'Newell', NULL, '1942-03-28', 'Mike Newell est un réalisateur et producteur britannique né le 28 mars 1942 à St Albans (Hertfordshire) en Angleterre.\r\n\r\nIl se fait connaître du grand public en réalisant notamment les films Quatre mariages et un enterrement en 1994 (pour lequel il remporte un BAFTA Award) et Harry Potter et la Coupe de feu en 2005.'),
(7, 'David', 'Yates', NULL, '1963-10-08', 'David Yates, né le 8 octobre 1963 à St Helens dans le Merseyside, est un réalisateur, scénariste et producteur britannique.\r\n\r\nIl consacre ses premières années de carrière à la réalisation de courts-métrages et de projets télévisés. Plus tard, il acquiert une reconnaissance grâce à son travail sur la mini-série politique Jeux de pouvoir et sur le téléfilm Sex Traffic. C\'est en prenant la direction des quatre derniers films Harry Potter (à partir de Harry Potter et l\'Ordre du Phénix en 2007), puis des films de la série dérivée Les Animaux fantastiques2 (à partir de 2016), qu\'il acquiert une notoriété mondiale. En 2018, il devient, grâce au film Les Animaux fantastiques : Les Crimes de Grindelwald, le cinquième réalisateur le plus rentable de l\'histoire du cinéma.');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `role_type`) VALUES
(1, 'Realisateur'),
(2, 'Acteur');

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `movie_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `movie_type`) VALUES
(1, 'Fantastique'),
(2, 'Action'),
(3, 'Aventure'),
(4, 'Horreur'),
(5, 'Drame'),
(6, 'Science-fiction');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` datetime NOT NULL,
  `reset_token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `confirmed_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `admin`) VALUES
(1, 'Aurelien', 'aurelien@gmail.com', '$2y$10$cYwnEi2dlUc7qF6rYYeh1.B/c/yrxgCh103UKyL9eqjvJMxLTuQcW', NULL, '2021-01-11 11:46:53', NULL, NULL, NULL, 3),
(2, 'Vincent', 'vincent@gmail.com', '$2y$10$/XLURx3ahHbKfoNtjBn9aepY.AarcZdm/RdZ4AKhaVsq4coJtRMs6', NULL, '2021-01-11 11:47:08', NULL, NULL, NULL, 3),
(3, 'Mehdi', 'mehdi@gmail.com', '$2y$10$Wy6gMIhj7Ni9YmYO9WGp7eVScNMbX3o83y3OI4/SDs0ZW9OzRxg86', NULL, '2021-01-11 11:47:25', NULL, NULL, NULL, 1),
(4, 'Axopen', 'fausseadresse@gmail.com', '$2y$10$phy0joqgi4SxmybWs5D8P.6GlgOgvFTbWjER1erNGDwyzpnPWyR9K', NULL, '2022-04-11 13:21:33', NULL, NULL, NULL, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`);

--
-- Contraintes pour la table `participate`
--
ALTER TABLE `participate`
  ADD CONSTRAINT `participate_ibfk_1` FOREIGN KEY (`id_movie`) REFERENCES `movies` (`id_movie`),
  ADD CONSTRAINT `participate_ibfk_2` FOREIGN KEY (`id_person`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `participate_ibfk_3` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
