-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db683917835.db.1and1.com
-- Généré le :  Dim 16 Juillet 2017 à 17:38
-- Version du serveur :  5.5.55-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--

--

-- --------------------------------------------------------

--
-- Structure de la table `approvals`
--

CREATE TABLE IF NOT EXISTS `approvals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `approval` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `approvals`
--

INSERT INTO `approvals` (`id`, `approval`) VALUES
(1, 'En attente'),
(2, 'Accepté'),
(3, 'Signalé'),
(4, 'Masqué'),
(5, 'Supprimé');

-- --------------------------------------------------------

--
-- Structure de la table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_state` int(11) NOT NULL,
  `date_last_modif` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ChaptersStates_idx` (`id_state`),
  KEY `ChaptersUsers_idx` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chapter` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `user_name` varchar(80) NOT NULL,
  `comment` longtext NOT NULL,
  `id_approval` int(11) NOT NULL DEFAULT '1',
  `date_written` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `CommentsChapters_idx` (`id_chapter`),
  KEY `CommentsApprovals_idx` (`id_approval`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Structure de la table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `states`
--

INSERT INTO `states` (`id`, `state`) VALUES
(1, 'Brouillon'),
(2, 'Publié'),
(3, 'Supprimé');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(80) NOT NULL,
  `surname` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `date_last_login` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `name`, `surname`, `password`, `salt`, `date_last_login`) VALUES
(2, 'jforte', 'jforte@iiidees.com', 'Jean', 'Forteroche', '5e37ef8770e7e23397b6b9bb9e3ddf225fe0fad51065167c39b37e03af131f307042aeda433357bf48573f40907eb314ade9ee37145de792ac7c66681ad6279f', 'oANRdKNKWDQz#Srqjo2M#!&sB%ggyiDOoV@%M%9GnxDAxuhRgMz@gqiTBm927Pkt', '2017-07-16 17:34:17'),
(3, 'epetit', 'e.petit18@laposte.net', 'Emmanuel', 'Petit', '418d4ae2e653be6ed520838e6fae14faddab9530108f7e23fe5769764689abca9238bb79f028c9e666c9aa3455b0996bf6839b08c25bf2ce2549278e12a488b2', '0Vm?teWBBKIA6z2mmldkgtY0o*prGe2WlC&S#GudC%IM6tgnLArkw#2#k9rdim?z', '2017-07-16 17:10:56');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `ChaptersStates` FOREIGN KEY (`id_state`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ChaptersUsers` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `CommentsApprovals` FOREIGN KEY (`id_approval`) REFERENCES `approvals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `CommentsChapters` FOREIGN KEY (`id_chapter`) REFERENCES `chapters` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
