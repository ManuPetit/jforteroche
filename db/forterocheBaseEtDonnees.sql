-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db683917835.db.1and1.com
-- Généré le :  Mer 19 Juillet 2017 à 15:30
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

--
-- Contenu de la table `chapters`
--

INSERT INTO `chapters` (`id`, `title`, `content`, `id_user`, `id_state`, `date_last_modif`) VALUES
(1, 'Qui commence par où les romans finissent', '<p>Le mariage de M. <em><strong>Robert Darzac</strong></em> et de Mlle <em><strong>Mathilde Stangerson</strong></em> eut lieu &agrave; Paris, &agrave; Saint-Nicolas-du-Chardonnet, le 6 avril 1895, dans la plus stricte intimit&eacute;. Un peu plus de deux ann&eacute;es s&rsquo;&eacute;taient donc &eacute;coul&eacute;es depuis les &eacute;v&eacute;nements que j&rsquo;ai rapport&eacute;s dans un pr&eacute;c&eacute;dent ouvrage, &eacute;v&eacute;nements si sensationnels qu&rsquo;il n&rsquo;est point t&eacute;m&eacute;raire d&rsquo;affirmer ici qu&rsquo;un aussi court laps de temps n&rsquo;avait pu faire oublier le fameux Myst&egrave;re de la Chambre Jaune&hellip; Celui-ci &eacute;tait encore si bien pr&eacute;sent &agrave; tous les esprits que la petite &eacute;glise e&ucirc;t &eacute;t&eacute; certainement envahie par une foule avide de contempler les h&eacute;ros d&rsquo;un drame qui avait passionn&eacute; le monde, si la c&eacute;r&eacute;monie nuptiale n&rsquo;avait &eacute;t&eacute; tenue tout &agrave; fait secr&egrave;te, ce qui avait &eacute;t&eacute; assez facile dans cette paroisse &eacute;loign&eacute;e du quartier des &eacute;coles. Seuls, quelques amis de M. Darzac et du professeur Stangerson, sur la discr&eacute;tion desquels on pouvait compter, avaient &eacute;t&eacute; invit&eacute;s. J&rsquo;&eacute;tais du nombre ; j&rsquo;arrivai de bonne heure &agrave; l&rsquo;&eacute;glise, et mon premier soin, naturellement, fut d&rsquo;y chercher Joseph Rouletabille. J&rsquo;avais &eacute;t&eacute; un peu d&eacute;&ccedil;u en ne l&rsquo;apercevant pas, mais il ne faisait point de doute pour moi qu&rsquo;il d&ucirc;t venir et, dans cette attente, je me rapprochai de ma&icirc;tre Henri-Robert et de ma&icirc;tre Andr&eacute; Hesse qui, dans la paix et le recueillement de la petite chapelle Saint-Charles, &eacute;voquaient tout bas les plus curieux incidents du proc&egrave;s de Versailles, que l&rsquo;imminente c&eacute;r&eacute;monie leur remettait en m&eacute;moire. Je les &eacute;coutais distraitement en examinant les choses autour de moi.</p>\r\n<p>Mon Dieu ! que votre Saint-Nicolas-du-Chardonnet est une chose triste ! D&eacute;cr&eacute;pite, l&eacute;zard&eacute;e, crevass&eacute;e, sale, non point de cette salet&eacute; auguste des &acirc;ges, qui est la plus belle parure de la pierre, mais de cette malpropret&eacute; orduri&egrave;re et poussi&eacute;reuse qui semble particuli&egrave;re &agrave; ces quartiers Saint-Victor et des Bernardins, au carrefour desquels elle se trouve si singuli&egrave;rement ench&acirc;ss&eacute;e, cette &eacute;glise, si sombre au dehors, est lugubre dedans. Le ciel, qui para&icirc;t plus &eacute;loign&eacute; de ce saint lieu que de partout ailleurs, y d&eacute;verse une lumi&egrave;re avare qui a toutes les peines du monde &agrave; venir trouver les fid&egrave;les &agrave; travers la crasse s&eacute;culaire des vitraux. Avez-vous lu les Souvenirs d&rsquo;enfance et de jeunesse, de Renan ? Poussez alors la porte de Saint-Nicolas-du-Chardonnet et vous comprendrez comment l&rsquo;auteur de la Vie de J&eacute;sus, qui &eacute;tait enferm&eacute; &agrave; c&ocirc;t&eacute;, dans le petit s&eacute;minaire adjacent de l&rsquo;abb&eacute; Dupanloup et qui n&rsquo;en sortait que pour venir prier ici, d&eacute;sira mourir. Et c&rsquo;est dans cette obscurit&eacute; fun&egrave;bre, dans un cadre qui ne paraissait avoir &eacute;t&eacute; invent&eacute; que pour les deuils, pour tous les rites consacr&eacute;s aux tr&eacute;pass&eacute;s, qu&rsquo;on allait c&eacute;l&eacute;brer le mariage de Robert Darzac et de Mathilde Stangerson ! J&rsquo;en con&ccedil;us une grande peine et, tristement impressionn&eacute;, en tirai un f&acirc;cheux augure.</p>', 2, 2, '2017-07-16 17:34:45'),
(2, 'La Dordogne coule....', '<p>&Agrave; c&ocirc;t&eacute; de moi, ma&icirc;tres Henri-Robert et Andr&eacute; Hesse bavardaient toujours, et le premier avouait au second qu&rsquo;il n&rsquo;avait &eacute;t&eacute; d&eacute;finitivement tranquillis&eacute; sur le sort de Robert Darzac et de Mathilde Stangerson, m&ecirc;me apr&egrave;s l&rsquo;heureuse issue du proc&egrave;s de Versailles, qu&rsquo;en apprenant la mort officiellement constat&eacute;e de leur impitoyable ennemi : Fr&eacute;d&eacute;ric Larsan. On se rappelle peut-&ecirc;tre que c&rsquo;est quelques mois apr&egrave;s l&rsquo;acquittement du professeur en Sorbonne que se produisit la terrible catastrophe de La Dordogne, paquebot transatlantique qui faisait le service du <strong>Havre</strong> &agrave; <strong>New-York</strong>.</p>\r\n<h2>Par temps de brouillard</h2>\r\n<p>La nuit, sur les bancs de Terre-Neuve, La Dordogne avait &eacute;t&eacute; abord&eacute;e par un trois-m&acirc;ts dont l&rsquo;avant &eacute;tait entr&eacute; dans sa chambre des machines. Et, pendant que le navire abordeur s&rsquo;en allait &agrave; la d&eacute;rive, le paquebot avait coul&eacute; &agrave; pic, en dix minutes. C&rsquo;est tout juste si une trentaine de passagers dont les cabines se trouvaient sur le pont, eurent le temps de sauter dans les chaloupes. Ils furent recueillis le lendemain par un bateau de p&ecirc;che qui rentra aussit&ocirc;t &agrave; Saint-Jean. Les jours suivants, l&rsquo;oc&eacute;an rejeta des centaines de morts parmi lesquels on retrouva Larsan. Les documents que l&rsquo;on d&eacute;couvrit, soigneusement cousus et dissimul&eacute;s dans les v&ecirc;tements d&rsquo;un cadavre, attest&egrave;rent, cette fois, que Larsan avait v&eacute;cu ! Mathilde Stangerson &eacute;tait d&eacute;livr&eacute;e enfin de ce fantastique &eacute;poux que, gr&acirc;ce aux facilit&eacute;s des lois am&eacute;ricaines, elle s&rsquo;&eacute;tait donn&eacute; en secret, aux heures imprudentes de sa trop confiante jeunesse. Cet affreux<br />bandit dont le v&eacute;ritable nom, illustre dans les fastes judiciaires, &eacute;tait Ballmeyer, et qui l&rsquo;avait jadis &eacute;pous&eacute;e sous le nom de Jean<br />Roussel, ne viendrait plus se dresser criminellement entre elle et celui qui, depuis de si longues ann&eacute;es, silencieusement et h&eacute;ro&iuml;quement l&rsquo;aimait. J&rsquo;ai rappel&eacute;, dans Le Myst&egrave;re de la Chambre Jaune, tous les d&eacute;tails de cette retentissante affaire, l&rsquo;une des plus curieuses qu&rsquo;on puisse relever dans les annales de la cour d&rsquo;assises, et qui aurait eu le plus tragique d&eacute;nouement sans l&rsquo;intervention quasi g&eacute;niale de ce petit reporter de dix-huit ans, Joseph Rouletabille, qui fut le seul &agrave; d&eacute;couvrir, sous les traits du c&eacute;l&egrave;bre agent de la s&ucirc;ret&eacute; Fr&eacute;d&eacute;ric Larsan, Ballmeyer lui-m&ecirc;me !&hellip; La mort accidentelle et, nous pouvons le dire, providentielle du mis&eacute;rable avait sembl&eacute; devoir mettre un terme &agrave; tant d&rsquo;&eacute;v&eacute;nements dramatiques et elle ne fut point &ndash; avouons-le &ndash; l&rsquo;une des moindres causes de la gu&eacute;rison rapide de Mathilde Stangerson, dont la raison avait &eacute;t&eacute; fortement &eacute;branl&eacute;e par les myst&eacute;rieuses horreurs du Glandier.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 2, 2, '2017-07-16 16:51:02'),
(3, 'Le retour de Rouletabille', '<p>Je ne savais point que Rouletabille f&ucirc;t pieux et son ardente pri&egrave;re m&rsquo;&eacute;tonna. Quand il releva la t&ecirc;te, ses yeux &eacute;taient pleins de larmes. Il ne les cachait pas ; il ne se pr&eacute;occupait nullement de ce qui se passait autour de lui ; il &eacute;tait tout entier &agrave; sa pri&egrave;re et peut-&ecirc;tre &agrave; son chagrin. Quel chagrin ? Ne devait-il pas &ecirc;tre heureux d&rsquo;assister &agrave; une union d&eacute;sir&eacute;e de tous ? Le bonheur de Robert Darzac et de Mathilde Stangerson n&rsquo;&eacute;tait-il point son oeuvre ?&hellip; Apr&egrave;s tout, c&rsquo;&eacute;tait peut-&ecirc;tre de bonheur que pleurait le jeune homme. Il se releva et alla se dissimuler dans la nuit d&rsquo;un pilier. Je n&rsquo;eus garde de l&rsquo;y suivre, car je voyais bien qu&rsquo;il d&eacute;sirait rester seul.</p>\r\n<p>Et puis, c&rsquo;&eacute;tait le moment o&ugrave; <em><strong>Mathilde Stangerson</strong></em> faisait son entr&eacute;e dans l&rsquo;&eacute;glise, au bras de son p&egrave;re. Robert Darzac marchait derri&egrave;re eux. Comme ils &eacute;taient chang&eacute;s tous les trois ! Ah ! le drame du Glandier avait pass&eacute; bien douloureusement sur ces trois &ecirc;tres ! Mais, chose extraordinaire, Mathilde Stangerson n&rsquo;en paraissait que plus belle encore ! Certes, ce n&rsquo;&eacute;tait plus cette magnifique personne, ce marbre vivant, cette antique divinit&eacute;, cette froide beaut&eacute; pa&iuml;enne qui suscitait, sur ses pas, dans les f&ecirc;tes officielles de la Troisi&egrave;me R&eacute;publique, auxquelles la situation en vue de son p&egrave;re la for&ccedil;ait d&rsquo;assister, un discret murmure d&rsquo;admiration extasi&eacute;e ; il semblait, au<br />contraire, que la fatalit&eacute;, en lui faisant expier si tard une imprudence commise si jeune, ne l&rsquo;avait pr&eacute;cipit&eacute;e dans une crise momentan&eacute;e de d&eacute;sespoir et de folie que pour lui faire quitter ce masque de pierre derri&egrave;re lequel se cachait l&rsquo;&acirc;me la plus d&eacute;licate et la plus tendre. Et c&rsquo;est cette &acirc;me, encore inconnue, qui rayonnait ce jour-l&agrave;, me semblait-il, du plus suave et du plus charmant &eacute;clat, sur le pur ovale de son visage, dans ses yeux pleins d&rsquo;une tristesse heureuse, sur son front poli comme l&rsquo;ivoire, o&ugrave; se lisait l&rsquo;amour de tout ce qui &eacute;tait beau et de tout ce qui &eacute;tait bon.</p>\r\n<p>Quant &agrave; sa toilette, j&rsquo;avouerai sottement que je ne me la rappelle plus et qu&rsquo;il me serait impossible de dire m&ecirc;me la couleur de sa robe. Mais ce dont je me souviens, par exemple, c&rsquo;est de l&rsquo;expression &eacute;trange que prit soudain son regard en ne d&eacute;couvrant point parmi nous celui qu&rsquo;elle cherchait. Elle ne parut redevenir tout &agrave; fait calme et ma&icirc;tresse d&rsquo;elle-m&ecirc;me que lorsqu&rsquo;elle eut enfin aper&ccedil;u Rouletabille derri&egrave;re son pilier. Elle lui sourit et nous sourit aussi, &agrave; notre tour.</p>', 2, 2, '2017-07-16 16:54:29'),
(4, 'Le provencal', '<p>&laquo; Elle a encore ses yeux de folle ! &raquo;</p>\r\n<p>Je me retournai vivement pour voir qui avait prononc&eacute; cette phrase abominable. C&rsquo;&eacute;tait un pauvre sire, que Robert Darzac, dans sa bont&eacute;, avait fait nommer aide de laboratoire, chez lui, &agrave; la Sorbonne. Il se nommait Brignolles et &eacute;tait vaguement cousin du mari&eacute;. Nous ne connaissions point d&rsquo;autre parent &agrave; M. Darzac, dont la famille &eacute;tait originaire du midi. Depuis longtemps, M. Darzac avait perdu son p&egrave;re et sa m&egrave;re ; il n&rsquo;avait ni fr&egrave;re ni soeur et semblait avoir rompu toute relation avec son pays, d&rsquo;o&ugrave; il n&rsquo;avait rapport&eacute; qu&rsquo;un ardent d&eacute;sir de r&eacute;ussir, une facult&eacute; de travail exceptionnelle, une intelligence solide et un besoin naturel d&rsquo;affection et de d&eacute;vouement qui avait trouv&eacute; avidement l&rsquo;occasion de se satisfaire aupr&egrave;s du professeur Stangerson et de sa fille. Il avait aussi rapport&eacute; de la Provence, son pays natal, un doux accent qui avait fait d&rsquo;abord sourire ses &eacute;l&egrave;ves de la Sorbonne, mais que ceux-ci avaient aim&eacute; bient&ocirc;t comme une musique agr&eacute;able et discr&egrave;te qui att&eacute;nuait un peu l&rsquo;aridit&eacute; n&eacute;cessaire des cours de leur jeune ma&icirc;tre, d&eacute;j&agrave; c&eacute;l&egrave;bre.</p>\r\n<p>Un beau matin du printemps pr&eacute;c&eacute;dent, il y avait par cons&eacute;quent un an environ de cela, Robert Darzac leur avait pr&eacute;sent&eacute; Brignolles. Il venait tout droit d&rsquo;Aix o&ugrave; il avait &eacute;t&eacute; pr&eacute;parateur de physique et o&ugrave; il avait d&ucirc; commettre quelque faute disciplinaire qui l&rsquo;avait jet&eacute; tout &agrave; coup sur le pav&eacute; ; mais il s''&eacute;tait souvenu &agrave; temps qu&rsquo;il &eacute;tait parent de M. Darzac, avait pris le train pour Paris et avait su si bien attendrir le fianc&eacute; de Mathilde Stangerson que celui-ci, le prenant en piti&eacute;, avait trouv&eacute; le moyen de l&rsquo;associer &agrave; ses travaux. &Agrave; ce moment, la sant&eacute; de Robert Darzac &eacute;tait loin d&rsquo;&ecirc;tre florissante. Elle subissait le contrecoup des formidables &eacute;motions qui l&rsquo;avaient assaillie au Glandier et en cour d&rsquo;assises ; mais on e&ucirc;t pu croire que la gu&eacute;rison, d&eacute;sormais assur&eacute;e, de Mathilde, et que la perspective<br />de leur prochain hymen auraient la plus heureuse influence sur l&rsquo;&eacute;tat moral et, par contrecoup, sur l&rsquo;&eacute;tat physique du professeur.</p>\r\n<p>Or, nous remarqu&acirc;mes tous au contraire que, du jour o&ugrave; il s&rsquo;adjoignit ce Brignolles, dont le concours devait lui &ecirc;tre, disait-il, d&rsquo;un pr&eacute;cieux soulagement, la faiblesse de M. Darzac ne fit qu&rsquo;augmenter. Enfin, nous constat&acirc;mes aussi que Brignolles ne portait pas chance, car deux f&acirc;cheux accidents se produisirent coup sur coup au cours d&rsquo;exp&eacute;riences qui semblaient cependant ne devoir pr&eacute;senter aucun danger : le premier r&eacute;sulta de l&rsquo;&eacute;clatement inopin&eacute; d&rsquo;un tube de Gessler dont les d&eacute;bris eussent pu dangereusement blesser M. Darzac et qui ne blessa que Brignolles, lequel en conservait encore aux mains quelques cicatrices. Le second, qui aurait pu &ecirc;tre extr&ecirc;mement grave, arriva &agrave; la suite de l&rsquo;explosion stupide d&rsquo;une petite lampe &agrave; essence, au-dessus de laquelle M. Darzac &eacute;tait justement pench&eacute;. La&nbsp; flamme faillit lui br&ucirc;ler la figure ; heureusement, il n&rsquo;en fut rien, mais elle lui flamba les cils et lui occasionna, pendant quelque temps, des troubles de la vue, si bien qu&rsquo;il ne pouvait plus supporter que difficilement la pleine lumi&egrave;re du soleil.</p>', 2, 1, '2017-07-17 15:49:04');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `id_chapter`, `id_parent`, `user_name`, `comment`, `id_approval`, `date_written`) VALUES
(1, 1, 0, 'Jeannot', 'Ce roman s''annonce grandiose. J''attends la suite avec impatience.', 2, '2017-07-16 11:37:30'),
(2, 1, 1, 'Pierrot', 'Grandiose, il faut pas éxagéré, ce n''est que le début...', 2, '2017-07-16 16:46:13'),
(3, 2, 0, 'Janette', 'Super cette histoire de paquebot.', 2, '2017-07-16 16:51:48'),
(4, 1, 2, 'Jeannot', 'Oui, peut être que j''ai un peu exagéré... lol...', 2, '2017-07-16 16:55:08'),
(5, 1, 2, 'Marina', 'Si, grandiose est le bon mot !!', 3, '2017-07-16 16:58:11'),
(6, 1, 1, 'Cécile', 'Vous êtes si vrai dans votre commentaire...', 2, '2017-07-16 16:58:49'),
(7, 1, 0, 'Justine', 'Quelle début d''histoire..', 2, '2017-07-16 16:59:18'),
(8, 2, 0, 'Patrice', 'C''est pas du tout sensas. c''est pas chouette du tout de la m***e!!', 4, '2017-07-16 16:59:54'),
(9, 2, 3, 'Capitaine Haddock', 'Il manque que Kate Wislet et on sera dans le Titanic ....', 3, '2017-07-16 17:00:54'),
(10, 2, 0, 'Julien', 'On aurait pu aller à la pêche...', 1, '2017-07-16 17:02:06'),
(11, 2, 3, 'Christian', 'C''est une drôle d''histoire en effet...', 1, '2017-07-16 17:02:30'),
(12, 2, 0, 'Jacquet', 'Du grand art, on retrouve bien ici la plume de Jean Forteroche.', 1, '2017-07-16 17:07:04'),
(13, 1, 7, 'John', 'En effet quelle histoire... Incroyable !!!', 1, '2017-07-16 17:08:02'),
(14, 1, 0, 'Philou', 'Superbe... superbe... superbe...', 1, '2017-07-16 17:08:24'),
(15, 2, 0, 'Jacquet', 'Le premier chapitre n''était que le début... Ca continue de plus belle.', 1, '2017-07-16 17:09:07'),
(16, 1, 2, 'Marcel', 'Si il a raison de dire cela.', 1, '2017-07-16 17:10:18'),
(17, 2, 0, 'Suzane', 'Quelle merveilleuse histoire', 1, '2017-07-16 17:19:53'),
(18, 1, 7, 'Gina', 'Je suis une grande fan, et c''est une joie de découvrir un nouveau roman de Jean Forteroche.', 1, '2017-07-16 17:20:28'),
(19, 1, 6, 'Jack', 'Oui Cécile, d''accord avec vous.', 1, '2017-07-16 17:21:11'),
(20, 1, 1, 'Jojo la frite', 'Oui vous avez entièrement raison!', 1, '2017-07-16 17:21:46'),
(21, 2, 0, 'Céline Aivitable', 'Superbe histoire. Merci de la partager avec tous les internautes.', 1, '2017-07-16 17:23:32'),
(22, 1, 1, 'Joel', 'Oui c''est vraiment très bien. Merci Jean', 1, '2017-07-16 17:33:33'),
(23, 1, 7, 'Noemie', 'Superbe', 1, '2017-07-16 19:29:33'),
(24, 2, 0, 'Titine', 'Ah ce magnifique bateau, qu''est la Dordogne...', 1, '2017-07-17 10:55:21'),
(25, 1, 2, 'babar', 'on essaie la mécanique des messages', 1, '2017-07-17 11:05:49'),
(26, 1, 7, 'Joselin', 'En effet Suzanne, c''est de la balle cette histoire....', 1, '2017-07-17 15:14:35'),
(27, 1, 7, 'Joel', 'En route pour de nouvelles aventures de ce rustre de Malineaux...', 1, '2017-07-18 12:57:33');

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
(2, 'jforte', 'jforte@iiidees.com', 'Jean', 'Forteroche', '5e37ef8770e7e23397b6b9bb9e3ddf225fe0fad51065167c39b37e03af131f307042aeda433357bf48573f40907eb314ade9ee37145de792ac7c66681ad6279f', 'oANRdKNKWDQz#Srqjo2M#!&sB%ggyiDOoV@%M%9GnxDAxuhRgMz@gqiTBm927Pkt', '2017-07-17 15:48:22'),
(3, 'epetit', 'e.petit18@laposte.net', 'Emmanuel', 'Petit', '0f2000771bbe39b82779c2944de95f0f3e477b33fc94a9913aec310b6b771e095d92f3af2d58e699aa0f9e5cfa742b9b59a6c3128478ccfd5f74e0b5cb54fcc8', 'h&kB87!Ivsv#9bBQzd25ro!vHMd@KY8FwcjMuv3RpGu0JWviPUpEZf1Yd8?w!zmt', '2017-07-17 14:56:41');

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
