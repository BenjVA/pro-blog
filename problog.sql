-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 05 juil. 2023 à 07:51
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `problog`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` mediumtext NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `short` mediumtext NOT NULL,
  `content` longtext NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Article_User` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `createdAt`, `updatedAt`, `short`, `content`, `published`, `idUser`) VALUES
(4, 'Premier article ', '2023-04-18 16:18:07', '2023-05-22 14:30:30', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean velit lorem, ullamcorper at fringilla et, pellentesque ac justo. Quisque vitae eros non leo tempus tincidunt. Phasellus id ultrices lorem, nec interdum orci. Aenean tristique tincidunt dictum. Aenean et metus eget sapien consectetur aliquet. Morbi a massa vitae metus eleifend consectetur. Morbi hendrerit id neque quis iaculis. Integer lobortis, neque non fringilla lacinia, mauris ipsum gravida odio, iaculis pellentesque nibh nulla et arcu. Aenean consectetur non lacus id iaculis. ', ' Etiam in dui eget metus tristique euismod ac eu arcu. Aliquam erat volutpat. Proin laoreet augue sed lacus tristique elementum. Vestibulum risus dui, venenatis vitae nisi eu, feugiat mattis mauris. Fusce turpis nunc, vestibulum vel pellentesque eu, dictum et magna. Etiam at fringilla arcu, ac vestibulum nisi. Fusce volutpat dolor vitae felis interdum molestie eget non tortor. Donec quis lacinia nibh. Proin pretium rhoncus enim, pellentesque tristique urna. Donec tristique varius semper. Praesent vulputate leo id mauris hendrerit pellentesque.\r\n\r\nVestibulum id nisl porta, ornare dolor sit amet, porttitor mi. Integer rhoncus vulputate fringilla. Sed cursus quam non diam condimentum maximus eget vel tellus. Sed vehicula ac risus non pulvinar. Vestibulum ligula sapien, tincidunt sit amet nibh maximus, fringilla interdum arcu. Nullam imperdiet ac magna id lobortis. Sed arcu arcu, gravida quis justo non, tristique feugiat massa. Etiam congue semper diam eget semper. Aenean nisi risus, rhoncus vel faucibus ut, tincidunt at orci. Donec rutrum erat massa, ac tincidunt velit iaculis ut. Maecenas vel interdum nulla. Mauris sit amet augue at sapien convallis finibus a lacinia sem. In velit mauris, tincidunt rutrum auctor nec, consectetur eu turpis. ', 1, 1),
(5, 'Deuxième article', '2023-04-18 17:18:07', '2023-05-22 14:30:30', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean velit lorem, ullamcorper at fringilla et, pellentesque ac justo. Quisque vitae eros non leo tempus tincidunt. Phasellus id ultrices lorem, nec interdum orci. Aenean tristique tincidunt dictum. Aenean et metus eget sapien consectetur aliquet. Morbi a massa vitae metus eleifend consectetur. Morbi hendrerit id neque quis iaculis. Integer lobortis, neque non fringilla lacinia, mauris ipsum gravida odio, iaculis pellentesque nibh nulla et arcu. Aenean consectetur non lacus id iaculis. ', ' Etiam in dui eget metus tristique euismod ac eu arcu. Aliquam erat volutpat. Proin laoreet augue sed lacus tristique elementum. Vestibulum risus dui, venenatis vitae nisi eu, feugiat mattis mauris. Fusce turpis nunc, vestibulum vel pellentesque eu, dictum et magna. Etiam at fringilla arcu, ac vestibulum nisi. Fusce volutpat dolor vitae felis interdum molestie eget non tortor. Donec quis lacinia nibh. Proin pretium rhoncus enim, pellentesque tristique urna. Donec tristique varius semper. Praesent vulputate leo id mauris hendrerit pellentesque.\r\n\r\nVestibulum id nisl porta, ornare dolor sit amet, porttitor mi. Integer rhoncus vulputate fringilla. Sed cursus quam non diam condimentum maximus eget vel tellus. Sed vehicula ac risus non pulvinar. Vestibulum ligula sapien, tincidunt sit amet nibh maximus, fringilla interdum arcu. Nullam imperdiet ac magna id lobortis. Sed arcu arcu, gravida quis justo non, tristique feugiat massa. Etiam congue semper diam eget semper. Aenean nisi risus, rhoncus vel faucibus ut, tincidunt at orci. Donec rutrum erat massa, ac tincidunt velit iaculis ut. Maecenas vel interdum nulla. Mauris sit amet augue at sapien convallis finibus a lacinia sem. In velit mauris, tincidunt rutrum auctor nec, consectetur eu turpis. ', 1, 1),
(6, 'Troisième article', '2023-04-18 18:18:07', '2023-05-22 14:30:30', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean velit lorem, ullamcorper at fringilla et, pellentesque ac justo. Quisque vitae eros non leo tempus tincidunt. Phasellus id ultrices lorem, nec interdum orci. Aenean tristique tincidunt dictum. Aenean et metus eget sapien consectetur aliquet. Morbi a massa vitae metus eleifend consectetur. Morbi hendrerit id neque quis iaculis. Integer lobortis, neque non fringilla lacinia, mauris ipsum gravida odio, iaculis pellentesque nibh nulla et arcu. Aenean consectetur non lacus id iaculis. ', ' Etiam in dui eget metus tristique euismod ac eu arcu. Aliquam erat volutpat. Proin laoreet augue sed lacus tristique elementum. Vestibulum risus dui, venenatis vitae nisi eu, feugiat mattis mauris. Fusce turpis nunc, vestibulum vel pellentesque eu, dictum et magna. Etiam at fringilla arcu, ac vestibulum nisi. Fusce volutpat dolor vitae felis interdum molestie eget non tortor. Donec quis lacinia nibh. Proin pretium rhoncus enim, pellentesque tristique urna. Donec tristique varius semper. Praesent vulputate leo id mauris hendrerit pellentesque.\r\n\r\nVestibulum id nisl porta, ornare dolor sit amet, porttitor mi. Integer rhoncus vulputate fringilla. Sed cursus quam non diam condimentum maximus eget vel tellus. Sed vehicula ac risus non pulvinar. Vestibulum ligula sapien, tincidunt sit amet nibh maximus, fringilla interdum arcu. Nullam imperdiet ac magna id lobortis. Sed arcu arcu, gravida quis justo non, tristique feugiat massa. Etiam congue semper diam eget semper. Aenean nisi risus, rhoncus vel faucibus ut, tincidunt at orci. Donec rutrum erat massa, ac tincidunt velit iaculis ut. Maecenas vel interdum nulla. Mauris sit amet augue at sapien convallis finibus a lacinia sem. In velit mauris, tincidunt rutrum auctor nec, consectetur eu turpis. ', 1, 1),
(7, 'Quatrième article', '2023-05-01 08:28:51', '2023-05-22 14:30:30', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus metus maximus feugiat tincidunt. Vestibulum volutpat neque a facilisis fringilla. Ut dapibus nec lorem at hendrerit. Curabitur nec arcu pulvinar, elementum tellus eget, luctus justo. Donec vulputate enim augue. Cras tincidunt diam ac neque commodo, sed vulputate turpis finibus. Sed leo quam, ultrices sit amet elit sed, vestibulum malesuada odio. Ut vulputate sapien felis, ac lobortis eros elementum ac. Nulla facilisi. Phasellus malesuada, nulla vitae tincidunt eleifend, sem nibh mattis justo, quis maximus nibh magna ut ante. Pellentesque laoreet luctus nibh id venenatis. Duis tristique venenatis commodo. ', ' Integer odio leo, commodo vel mi in, fringilla aliquet libero. Quisque volutpat diam non nisi placerat maximus. Nam a condimentum mi. Cras tempus purus non gravida vehicula. Donec semper dolor pellentesque odio dictum blandit. Sed vehicula felis massa, viverra dapibus tortor tincidunt nec. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vulputate urna erat. Aliquam a bibendum urna. Ut in est nibh. Nulla efficitur erat sed tristique dignissim.\r\n\r\nNunc laoreet neque magna, eget pulvinar tellus porta vel. Aenean pharetra dapibus ex, in sollicitudin urna semper ac. Suspendisse ornare velit in augue mollis mollis. Fusce augue turpis, vehicula eu vulputate quis, vulputate id libero. Aenean non tortor auctor, interdum quam at, finibus nisl. Donec finibus non nulla sed pharetra. Phasellus sed aliquam lorem. Cras accumsan faucibus nisi, non rutrum ligula pellentesque eget. Pellentesque tempus est nec augue pretium viverra. Quisque ultrices et diam vel commodo. In egestas, risus at sollicitudin facilisis, dui lectus consectetur lorem, nec accumsan nulla magna at nisl. Nulla vitae dapibus lorem. Nulla eget mi erat. Nam porttitor nisl semper odio viverra imperdiet. Sed nec ex tellus. ', 1, 1),
(8, 'Cinquième article', '2023-05-01 08:28:51', '2023-05-22 14:30:30', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus metus maximus feugiat tincidunt. Vestibulum volutpat neque a facilisis fringilla. Ut dapibus nec lorem at hendrerit. Curabitur nec arcu pulvinar, elementum tellus eget, luctus justo. Donec vulputate enim augue. Cras tincidunt diam ac neque commodo, sed vulputate turpis finibus. Sed leo quam, ultrices sit amet elit sed, vestibulum malesuada odio. Ut vulputate sapien felis, ac lobortis eros elementum ac. Nulla facilisi. Phasellus malesuada, nulla vitae tincidunt eleifend, sem nibh mattis justo, quis maximus nibh magna ut ante. Pellentesque laoreet luctus nibh id venenatis. Duis tristique venenatis commodo. ', ' Integer odio leo, commodo vel mi in, fringilla aliquet libero. Quisque volutpat diam non nisi placerat maximus. Nam a condimentum mi. Cras tempus purus non gravida vehicula. Donec semper dolor pellentesque odio dictum blandit. Sed vehicula felis massa, viverra dapibus tortor tincidunt nec. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vulputate urna erat. Aliquam a bibendum urna. Ut in est nibh. Nulla efficitur erat sed tristique dignissim.\r\n\r\nNunc laoreet neque magna, eget pulvinar tellus porta vel. Aenean pharetra dapibus ex, in sollicitudin urna semper ac. Suspendisse ornare velit in augue mollis mollis. Fusce augue turpis, vehicula eu vulputate quis, vulputate id libero. Aenean non tortor auctor, interdum quam at, finibus nisl. Donec finibus non nulla sed pharetra. Phasellus sed aliquam lorem. Cras accumsan faucibus nisi, non rutrum ligula pellentesque eget. Pellentesque tempus est nec augue pretium viverra. Quisque ultrices et diam vel commodo. In egestas, risus at sollicitudin facilisis, dui lectus consectetur lorem, nec accumsan nulla magna at nisl. Nulla vitae dapibus lorem. Nulla eget mi erat. Nam porttitor nisl semper odio viverra imperdiet. Sed nec ex tellus. ', 1, 1),
(9, 'Article écrit sur site, modif title2', '2023-06-16 10:18:51', '2023-06-16 13:31:23', 'j\'adore l\'écriture, modif short2', 'oui j\'aime beaucoup ça, surtout quand ça modifie correctement 2', 1, 7),
(10, 'Deuxieme article écrit sur le site', '2023-06-16 15:18:18', '2023-07-04 12:34:02', 'court résumé ici', 'oergjhipoejhgrpioqejgrpoeqijgrpoeqijgrepoirjgeoqirg', 1, 7),
(14, 'ddz', '2023-06-21 13:39:58', '2023-06-21 13:39:58', 'zdzd', 'zdzd', 0, 7),
(19, 'article', '2023-06-29 12:40:23', '2023-06-29 12:40:23', 'article', 'article', 0, 9),
(20, 'bonjour', '2023-06-29 13:25:34', '2023-06-29 13:25:34', 'bonjour', 'bonjour', 0, 7),
(24, 'e(u-', '2023-06-29 14:35:25', '2023-06-29 14:35:25', 'e(-ue(u-', 'e(u-e(u-', 0, 7),
(25, 'TITRE ICI', '2023-07-04 11:43:26', '2023-07-04 11:43:26', 'LIJEHGLKJQBDGRLJKBkjngfdlkjng', 'mknjvfdklmjngsdkmlnjgskmldnjgtm', 0, 7),
(26, 'ngrnrtetrhzrthhrt', '2023-07-04 11:57:58', '2023-07-04 11:57:58', 'rthhrthrtrhtrhthrt', 'rththrthrtrhtrhhrt', 0, 7);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idUser` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_Comment_User1` (`idUser`),
  KEY `fk_Comment_Article1` (`idArticle`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `createdAt`, `idUser`, `idArticle`, `published`) VALUES
(1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2023-05-30 11:52:23', 1, 4, 1),
(2, 'Why do we use it?\r\n\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-l', '2023-06-01 09:59:29', 2, 8, 1),
(3, ' page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes b', '2023-06-01 11:59:29', 1, 7, 1),
(4, 'bonjour premier commentaire', '2023-06-13 12:58:07', 7, 4, 1),
(5, 'Commentaire non validé', '2023-06-13 13:09:00', 7, 4, 1),
(6, 'bonjour', '2023-06-13 13:14:18', 7, 4, 1),
(7, 'bonjour 2', '2023-06-13 13:15:11', 7, 4, 1),
(9, 'zagregrez', '2023-06-21 12:09:12', 7, 9, 1),
(10, 'commentaire', '2023-06-21 12:09:44', 7, 9, 1),
(11, 'commentaire', '2023-06-21 12:10:41', 7, 9, 1),
(12, 'commentaire', '2023-06-21 12:21:41', 7, 9, 1),
(14, 'comm', '2023-06-21 13:20:11', 7, 10, 1),
(27, 'erjejytr', '2023-06-21 14:46:38', 7, 10, 1),
(29, 'commenat', '2023-07-04 11:55:18', 7, 10, 0),
(30, 'brrtbrrbt', '2023-07-04 11:58:45', 7, 10, 0),
(31, 'zdddzz', '2023-07-04 12:34:10', 7, 10, 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(177) NOT NULL,
  `mail` varchar(70) NOT NULL,
  `isAdmin` tinyint(1) DEFAULT '2',
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `mail`, `isAdmin`, `password`) VALUES
(1, 'BenjVA', 'ben.valette@live.fr', 1, NULL),
(2, 'testuser', 'email@exemple.com', 2, '$2y$10$LWPc1hC/JzlHgQ1k9OwLR.S6R0Ij9JjvVxEwyDuqKhHe3h31T7Ge6'),
(7, 'Admin', 'admin@exemple.com', 1, '$2y$10$8A8swQ24sGnXPIGaselOVOy9EUEHmJciiL1g7m0W/rCpEJbUhN3L2'),
(8, 'User', 'gmail@exemple.com', 2, '$2y$10$o0XowiyvFMhRZhXfrsqDAuOAyp1jnce/KqFbsW1uQs0wY/UD6deiS'),
(9, 'User2', 'gmail2@exemple.com', 2, '$2y$10$8b7tfHsGWxs.F860oYfmNOxGC6IQ1SdmYSEgRNTIi3BRKZO81OGYu'),
(10, 'User3', 'user3@exemple.com', 2, '$2y$10$4jQlPvTFfh13gmXCDu5vl.v1nhdngmcE4cWPk2otN3ElXDo1WeT.a'),
(11, 'User4', 'user4@exemple.com', 2, '$2y$10$wzDymKTgMp1rck/17EsCtOwJf82MRJ5F.UN2NKuNCUsx2BH0.buH6'),
(12, 'user6', 'user6@exemple.com', 2, '$2y$10$v9MdOf0dqb6QE.OFjk94N.OtZyouuyNMSFsTr1ZQeUX0dafpSOCKe'),
(13, 'user7', 'user7@exemple.com', 2, '$2y$10$xrXYq76ii0Do9G67JMxwuOL9TYws6s3FMUWng4QpsAGHaISfp.HZW');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_Article_User` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_Comment_Article1` FOREIGN KEY (`idArticle`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Comment_User1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
