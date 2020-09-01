-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 01 sep. 2020 à 21:06
-- Version du serveur :  10.4.10-MariaDB
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
-- Base de données :  `loottable`
--

-- --------------------------------------------------------

--
-- Structure de la table `dropchance`
--

DROP TABLE IF EXISTS `dropchance`;
CREATE TABLE IF NOT EXISTS `dropchance` (
  `idMonstre` smallint(5) UNSIGNED NOT NULL,
  `idLoot` smallint(5) UNSIGNED NOT NULL,
  `minRoll` tinyint(4) NOT NULL,
  `maxRoll` tinyint(4) NOT NULL,
  `niveauMonstre` tinyint(4) DEFAULT NULL,
  `multiplier` tinyint(4) NOT NULL DEFAULT 1,
  `dicePower` int(11) NOT NULL,
  PRIMARY KEY (`idMonstre`,`idLoot`),
  KEY `FK_dropchance_idLoot` (`idLoot`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dropchance`
--

INSERT INTO `dropchance` (`idMonstre`, `idLoot`, `minRoll`, `maxRoll`, `niveauMonstre`, `multiplier`, `dicePower`) VALUES
(1, 1, 1, 1, NULL, 1, 100),
(1, 2, 5, 12, NULL, 10, 20),
(1, 3, 13, 17, NULL, 3, 10),
(1, 4, 18, 19, NULL, 1, 3),
(1, 5, 20, 20, NULL, 1, 100),
(5, 1, 1, 1, NULL, 1, 100),
(5, 2, 2, 10, NULL, 25, 20),
(5, 3, 11, 15, NULL, 10, 8),
(5, 4, 16, 18, NULL, 1, 8),
(5, 5, 19, 20, NULL, 1, 100);

-- --------------------------------------------------------

--
-- Structure de la table `dropchancebis`
--

DROP TABLE IF EXISTS `dropchancebis`;
CREATE TABLE IF NOT EXISTS `dropchancebis` (
  `idMonstre` smallint(5) UNSIGNED NOT NULL,
  `roll` tinyint(4) NOT NULL,
  `idLoot` smallint(5) UNSIGNED DEFAULT NULL,
  `niveauMonstre` tinyint(4) DEFAULT NULL,
  `diceNumber` tinyint(4) NOT NULL DEFAULT 1,
  `dicePower` tinyint(4) NOT NULL,
  `multiplier` smallint(6) NOT NULL,
  PRIMARY KEY (`idMonstre`,`roll`),
  UNIQUE KEY `idMonstre` (`idMonstre`,`roll`),
  KEY `FK_dropChanceBis_idLoot` (`idLoot`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dropchancebis`
--

INSERT INTO `dropchancebis` (`idMonstre`, `roll`, `idLoot`, `niveauMonstre`, `diceNumber`, `dicePower`, `multiplier`) VALUES
(1, 1, 1, NULL, 1, 100, 1),
(1, 6, 2, NULL, 1, 6, 1),
(1, 7, 2, NULL, 1, 8, 10),
(1, 8, 2, NULL, 1, 10, 10),
(1, 9, 2, NULL, 1, 12, 10),
(1, 10, 3, NULL, 1, 8, 10),
(1, 11, 3, NULL, 1, 10, 10),
(1, 12, 3, NULL, 1, 12, 1),
(1, 13, 3, NULL, 2, 10, 10),
(1, 14, 4, NULL, 1, 6, 5),
(1, 15, 4, NULL, 1, 8, 5),
(1, 16, 4, NULL, 1, 10, 5),
(1, 17, 4, NULL, 1, 12, 5),
(1, 18, 5, NULL, 1, 10, 2),
(1, 19, 5, NULL, 1, 20, 2),
(1, 20, 6, NULL, 1, 100, 1);

-- --------------------------------------------------------

--
-- Structure de la table `effetdecouvert`
--

DROP TABLE IF EXISTS `effetdecouvert`;
CREATE TABLE IF NOT EXISTS `effetdecouvert` (
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `effet` text NOT NULL,
  KEY `FK_effetdecouvert_idPersonnage` (`idPersonnage`),
  KEY `FK_effetdecouvert_idPossede` (`idObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `effetmagique`
--

DROP TABLE IF EXISTS `effetmagique`;
CREATE TABLE IF NOT EXISTS `effetmagique` (
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`idEffetMagique`),
  UNIQUE KEY `idEffectMagique` (`idEffetMagique`),
  KEY `FK_effetmagique_idObjet` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagique`
--

INSERT INTO `effetmagique` (`idEffetMagique`, `idObjet`, `title`) VALUES
(2, 2, 'EffetMagiqueTest'),
(3, 6, 'Alliances bénies'),
(4, 7, 'Alliances bénies'),
(5, 8, 'Contact d’adamantium'),
(6, 9, 'Contact d’adamantium'),
(7, 10, 'Contact d’adamantium'),
(8, 11, 'Contact d’adamantium'),
(9, 12, 'Contact d’adamantium'),
(10, 13, 'Contact d’adamantium'),
(11, 14, 'Contact d’adamantium'),
(12, 15, 'Contact d’adamantium'),
(13, 16, 'Contact d’adamantium'),
(14, 17, 'Contact d’adamantium'),
(15, 18, 'Feu d’étoiles');

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquedescription`
--

DROP TABLE IF EXISTS `effetmagiquedescription`;
CREATE TABLE IF NOT EXISTS `effetmagiquedescription` (
  `idEffetMagiqueDescription` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idEffetMagiqueDescription`),
  UNIQUE KEY `idObjetDescription` (`idEffetMagiqueDescription`),
  KEY `FK_effetmagiquedescription_idEffetMagique` (`idEffetMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquedescription`
--

INSERT INTO `effetmagiquedescription` (`idEffetMagiqueDescription`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Ce casque d’aspect normal révèle sa puissance quand son utilisateur l’enfile et prononce le mot de commande. Fait d’argent rutilant et d’acier poli, un casque de mille feux nouvellement créé est serti de 10 diamants, 20 rubis, 30 opales de feu et 40 opales, chacune de ces pierres étant magiques. À ce moment, les aspérités qu’il arbore donnent l’impression que le personnage porte une couronne enchâssée de pierres précieuses. Au moindre rai de lumière, le casque brille de mille feux, d’où son nom. Les fonctions des pierres sont les suivantes :'),
(2, 2, 'Le casque peut être utilisé une fois par round, mais chaque pierre perd son éclat après avoir utilisé son pouvoir. Tant que toutes ses pierres ne sont pas ternes, le casque de mille feux a les propriétés suivantes :'),
(3, 2, 'Une fois que toutes les pierres ont été utilisées, elles tombent en poussière et le casque perd tous ses pouvoirs. Toute pierre que l’on essaye d’extraire se brise automatiquement.'),
(4, 2, 'Si le porteur du casque est brûlé par un feu d’origine magique (malgré l’importante protection dont il bénéficie) et s’il rate un jet de Volonté (DD 15), une surcharge se produit et toutes les pierres restantes saturent et explosent instantanément. Les diamants deviennent des rayons prismatiques visant chacun une créature choisie au hasard parmi celles à portée (éventuellement le porteur lui-même), les rubis deviennent des murs de feu en ligne droite partant du porteur dans une direction aléatoire et les opales de feu deviennent des boules de feu centrées sur le porteur. Les opales et le casque lui-même sont détruits.'),
(5, 3, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(6, 3, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(7, 3, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(8, 4, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(9, 4, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(10, 4, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(11, 5, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(12, 6, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(13, 7, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(14, 8, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(15, 9, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(16, 10, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(17, 11, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(18, 12, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(19, 13, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(20, 14, 'Cet anneau en adamantium permet à son porteur de réaliser des attaques naturelles et des attaques de corps à corps comme s’il maniait une arme en adamantium.'),
(21, 15, 'Cet anneau possède deux modes d’opération, l’un quand le porteur est dans une pièce sombre ou la nuit à l’extérieur et l’autre quand il est en sous-sol ou à l’intérieur de nuit.'),
(22, 15, 'De nuit sous un ciel dégagé ou dans une zone d’ombre ou de ténèbres, l’anneau de feu d’étoiles peut produire les effets suivants, sur ordre de son porteur.'),
(23, 15, 'La première fonction spéciale, boules de foudre, libère 1 à 4 sphères d’électricité, au choix du porteur. Ces globes luisants ressemblent à ceux générés par le sort lumières dansantes, et le personnage les contrôle de la même façon. Les boules de foudre ont une portée de 36 mètres et une durée d’existence de 4 rounds. Le porteur peut les déplacer de 36 mètres par round. Elles font environ un mètre de diamètre et se dissipent dès qu’elles arrivent à 1,50 mètre d’une créature, cette dernière encaissant une décharge d’électricité dont la violence est inversement proportionnelle au nombre de sphères créées.'),
(24, 15, 'Une fois la fonction activée, les boules de foudre peuvent être libérées au gré du porteur, et ce jusqu’au lever du soleil (à condition de ne pas dépasser la limite choisie). Plusieurs boules peuvent être libérées au cours d’un même round.'),
(25, 15, 'La seconde fonction spéciale, étoiles filantes, fait apparaître des comètes miniatures dotées d’une longue queue étincelante. Chaque semaine, l’anneau peut libérer 3 étoiles filantes, simultanément ou une par une. Chacun de ces projectiles inflige 12 points de dégâts au moment de l’impact puis explose comme une boule de feu, infligeant 24 points de dégâts de feu supplémentaires sur une étendue de 1,50 mètre de rayon.'),
(26, 15, 'Toute créature frappée de plein fouet par une étoile filante encaisse la totalité des dégâts dus à l’impact et à l’explosion. Quant à celles qui sont seulement prises dans la zone dangereuse, elles ne sont pas affectées par l’impact et ont droit à un jet de Réflexes (DD 13) pour n’essuyer que la moitié des dégâts dus à l’explosion. La portée maximale des étoiles filantes est de 21 mètres. Après avoir parcouru cette distance, elles explosent automatiquement, à moins d’avoir heurté un obstacle ou une créature au préalable. Elles se déplacent en ligne droite, et quiconque se trouve sur leur trajectoire doit réussir un jet de Réflexes (DD 13) sous peine d’être touché et de provoquer l’explosion.'),
(27, 15, 'La nuit en intérieur, ou en sous-sol à tout moment de la journée, l’anneau de feu d’étoiles a les pouvoirs suivants.'),
(28, 15, 'La pluie d’étincelles prend la forme d’un nuage d’étincelles violettes jaillissant de l’anneau et parcourant une distance de 6 mètres dans un arc de 3 mètres de large à sa base. Les créatures prises dans la zone d’effet subissent 2d8 points de dégâts d’électricité chacune si elles ne portent ni armes ni armures en métal. Une cible qui porte une armure métallique ou une arme en métal subit 4d8 points de dégâts d’électricité.');

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiqueinfos`
--

DROP TABLE IF EXISTS `effetmagiqueinfos`;
CREATE TABLE IF NOT EXISTS `effetmagiqueinfos` (
  `idEffetMagiqueInfos` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idEffetMagiqueInfos`),
  UNIQUE KEY `idObjetInfos` (`idEffetMagiqueInfos`),
  KEY `FK_effetmagiqueinfos_idEffetMagique` (`idEffetMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueinfos`
--

INSERT INTO `effetmagiqueinfos` (`idEffetMagiqueInfos`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Multiples puissantes '),
(2, 2, ' <span class=\"compobj\">NLS</span> 13 '),
(3, 2, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-objets-merveilleux-23.htm#23\">Création d’objets merveilleux</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-boule-de-feu.htm\">boule de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-detection-des-morts-vivants.htm\">détection des morts-vivants</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lame-de-feu.htm\">lame de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lumiere.htm\">lumière</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-mur-de-feu.htm\">mur de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-protection-contre-les-energies-destructives.htm\">protection contre les énergies destructives</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rayons-prismatiques.htm\">rayons prismatiques</a> '),
(4, 2, ' <span class=\"compobj\">Prix</span> 125 000 po '),
(5, 2, ' <span class=\"compobj\">Poids</span> 1,5 kg.'),
(6, 3, '<span class=\"divi\">Divination</span> faible '),
(7, 3, ' <span class=\"compobj\">NLS</span> 3 '),
(8, 3, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(9, 3, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(10, 4, '<span class=\"divi\">Divination</span> faible '),
(11, 4, ' <span class=\"compobj\">NLS</span> 3 '),
(12, 4, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(13, 4, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(14, 5, '<span class=\"transmu\">Transmutation</span> puissante '),
(15, 5, ' <span class=\"compobj\">NLS</span> 12 '),
(16, 5, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(17, 5, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(18, 5, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(19, 6, '<span class=\"transmu\">Transmutation</span> puissante '),
(20, 6, ' <span class=\"compobj\">NLS</span> 12 '),
(21, 6, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(22, 6, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(23, 6, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(24, 7, '<span class=\"transmu\">Transmutation</span> puissante '),
(25, 7, ' <span class=\"compobj\">NLS</span> 12 '),
(26, 7, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(27, 7, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(28, 7, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(29, 8, '<span class=\"transmu\">Transmutation</span> puissante '),
(30, 8, ' <span class=\"compobj\">NLS</span> 12 '),
(31, 8, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(32, 8, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(33, 8, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(34, 9, '<span class=\"transmu\">Transmutation</span> puissante '),
(35, 9, ' <span class=\"compobj\">NLS</span> 12 '),
(36, 9, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(37, 9, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(38, 9, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(39, 10, '<span class=\"transmu\">Transmutation</span> puissante '),
(40, 10, ' <span class=\"compobj\">NLS</span> 12 '),
(41, 10, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(42, 10, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(43, 10, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(44, 11, '<span class=\"transmu\">Transmutation</span> puissante '),
(45, 11, ' <span class=\"compobj\">NLS</span> 12 '),
(46, 11, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(47, 11, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(48, 11, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(49, 12, '<span class=\"transmu\">Transmutation</span> puissante '),
(50, 12, ' <span class=\"compobj\">NLS</span> 12 '),
(51, 12, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(52, 12, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(53, 12, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(54, 13, '<span class=\"transmu\">Transmutation</span> puissante '),
(55, 13, ' <span class=\"compobj\">NLS</span> 12 '),
(56, 13, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(57, 13, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(58, 13, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(59, 14, '<span class=\"transmu\">Transmutation</span> puissante '),
(60, 14, ' <span class=\"compobj\">NLS</span> 12 '),
(61, 14, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-contact-d-adamantium.htm\">contact d’adamantium</a> '),
(62, 14, ' <span class=\"compobj\">Prix</span> 120 000 po '),
(63, 14, ' <span class=\"compobj\">Coût</span> 60 000 po   4 800 PX.'),
(64, 15, '<span class=\"evoca\">Évocation</span> puissante '),
(65, 15, ' <span class=\"compobj\">NLS</span> 12 '),
(66, 15, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-boule-de-feu.htm\">boule de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-eclair.htm\">éclair</a>, lueur féerique et lumière '),
(67, 15, ' <span class=\"compobj\">Prix</span> 50 000 po.');

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquetable`
--

DROP TABLE IF EXISTS `effetmagiquetable`;
CREATE TABLE IF NOT EXISTS `effetmagiquetable` (
  `idEffetMagiqueTable` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`idEffetMagiqueTable`),
  UNIQUE KEY `idTable` (`idEffetMagiqueTable`),
  KEY `FK_effetmagiquetable_idEffetMagique` (`idEffetMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetable`
--

INSERT INTO `effetmagiquetable` (`idEffetMagiqueTable`, `idEffetMagique`, `position`) VALUES
(1, 2, 1),
(2, 15, 3);

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquetabletitle`
--

DROP TABLE IF EXISTS `effetmagiquetabletitle`;
CREATE TABLE IF NOT EXISTS `effetmagiquetabletitle` (
  `idEffetMagiqueTableTitle` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagiqueTable` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`idEffetMagiqueTableTitle`),
  UNIQUE KEY `idTableObjetTitle` (`idEffetMagiqueTableTitle`),
  KEY `FK_effetmagiquetabletitle_idEffetMagiqueTable` (`idEffetMagiqueTable`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletitle`
--

INSERT INTO `effetmagiquetabletitle` (`idEffetMagiqueTableTitle`, `idEffetMagiqueTable`) VALUES
(1, 1),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquetabletitlecontent`
--

DROP TABLE IF EXISTS `effetmagiquetabletitlecontent`;
CREATE TABLE IF NOT EXISTS `effetmagiquetabletitlecontent` (
  `idEffetMagiqueTableTitleContent` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagiqueTableTitle` smallint(5) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idEffetMagiqueTableTitleContent`),
  UNIQUE KEY `idTableObjetTitleContent` (`idEffetMagiqueTableTitleContent`),
  KEY `FK_effetmagiquetabletitlecontent_idEffetMagiqueTableTitle` (`idEffetMagiqueTableTitle`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletitlecontent`
--

INSERT INTO `effetmagiquetabletitlecontent` (`idEffetMagiqueTableTitleContent`, `idEffetMagiqueTableTitle`, `contenu`) VALUES
(1, 1, 'Gris'),
(2, 1, 'Rouille'),
(3, 1, 'Ocre'),
(4, 2, '1d100'),
(5, 2, 'Animal'),
(6, 2, '1d100'),
(7, 2, 'Animal'),
(8, 2, '1d100'),
(9, 2, 'Animal'),
(10, 3, 'Nombre de boules de foudre'),
(11, 3, 'Dégâts');

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquetabletr`
--

DROP TABLE IF EXISTS `effetmagiquetabletr`;
CREATE TABLE IF NOT EXISTS `effetmagiquetabletr` (
  `idEffetMagiqueTableTr` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagiqueTable` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`idEffetMagiqueTableTr`),
  UNIQUE KEY `idTableObjetTr` (`idEffetMagiqueTableTr`),
  KEY `FK_effetmagiquetabletr_idEffetMagiqueTable` (`idEffetMagiqueTable`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletr`
--

INSERT INTO `effetmagiquetabletr` (`idEffetMagiqueTableTr`, `idEffetMagiqueTable`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 2),
(8, 2),
(9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiquetabletrcontent`
--

DROP TABLE IF EXISTS `effetmagiquetabletrcontent`;
CREATE TABLE IF NOT EXISTS `effetmagiquetabletrcontent` (
  `idEffetMagiqueTableTrContent` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagiqueTableTr` mediumint(8) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idEffetMagiqueTableTrContent`),
  UNIQUE KEY `idTableObjetTrContent` (`idEffetMagiqueTableTrContent`),
  KEY `FK_effetmagiquetabletrcontent_idEffetMagiqueTableTr` (`idEffetMagiqueTableTr`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletrcontent`
--

INSERT INTO `effetmagiquetabletrcontent` (`idEffetMagiqueTableTrContent`, `idEffetMagiqueTableTr`, `contenu`) VALUES
(1, 1, '01–15'),
(2, 1, 'Belette'),
(3, 1, '01–30'),
(4, 1, 'Glouton'),
(5, 1, '01–20'),
(6, 1, 'Destrier lourd'),
(7, 2, '16–25'),
(8, 2, 'Blaireau'),
(9, 2, '31–60'),
(10, 2, 'Loup'),
(11, 2, '21–50'),
(12, 2, 'Lion'),
(13, 3, '26–40'),
(14, 3, 'Chat'),
(15, 3, '61–75'),
(16, 3, 'Ours noir'),
(17, 3, '51–80'),
(18, 3, 'Ours brun'),
(19, 4, '41–70'),
(20, 4, 'Chauve-souris'),
(21, 4, '76–100'),
(22, 4, 'Sanglier'),
(23, 4, '81–90'),
(24, 4, 'Rhinocéros'),
(25, 5, '71–100'),
(26, 5, 'Rat'),
(27, 5, ' '),
(28, 5, ' '),
(29, 5, '91–100'),
(30, 5, 'Tigre '),
(31, 6, '4'),
(32, 6, '1d6 points de dégâts d’électricité chacune'),
(33, 7, '3'),
(34, 7, '2d6 points de dégâts d’électricité chacune'),
(35, 8, '2'),
(36, 8, '3d6 points de dégâts d’électricité chacune'),
(37, 9, '1'),
(38, 9, '4d6 points de dégâts d’électricité');

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiqueul`
--

DROP TABLE IF EXISTS `effetmagiqueul`;
CREATE TABLE IF NOT EXISTS `effetmagiqueul` (
  `idEffetMagiqueUl` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`idEffetMagiqueUl`),
  UNIQUE KEY `idUlObjet` (`idEffetMagiqueUl`),
  KEY `FK_effetmagiqueul_idEffetMagique` (`idEffetMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueul`
--

INSERT INTO `effetmagiqueul` (`idEffetMagiqueUl`, `idEffetMagique`, `position`) VALUES
(1, 2, 1),
(2, 15, 2),
(3, 15, 7);

-- --------------------------------------------------------

--
-- Structure de la table `effetmagiqueulcontent`
--

DROP TABLE IF EXISTS `effetmagiqueulcontent`;
CREATE TABLE IF NOT EXISTS `effetmagiqueulcontent` (
  `idEffetMagiqueUlContent` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idEffetMagiqueUl` smallint(6) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idEffetMagiqueUlContent`),
  UNIQUE KEY `idUlObjetContent` (`idEffetMagiqueUlContent`),
  KEY `FK_effetmagiqueulcontent_idEffetMagiqueUl` (`idEffetMagiqueUl`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueulcontent`
--

INSERT INTO `effetmagiqueulcontent` (`idEffetMagiqueUlContent`, `idEffetMagiqueUl`, `contenu`) VALUES
(1, 1, 'Diamant : rayons prismatiques (jet de sauvegarde DD 20)'),
(2, 1, 'Rubis : mur de feu'),
(3, 1, 'Opale de feu : boule de feu (10d6, jet de Réflexes DD 20 pour demi-dégâts)'),
(4, 1, 'Opale : lumière'),
(5, 2, 'Boules de foudre (spécial, 1 fois par nuit)'),
(6, 2, 'Étoiles filantes (spécial, 3 par semaine)'),
(7, 2, 'Lumière (2 fois par nuit)'),
(8, 2, 'Lumières dansantes (1 fois par heure)'),
(9, 3, 'Lueur féerique (2 fois par jour)'),
(10, 3, 'Pluie d’étincelles (spécial, 1 fois par jour)');

-- --------------------------------------------------------

--
-- Structure de la table `famillemonstre`
--

DROP TABLE IF EXISTS `famillemonstre`;
CREATE TABLE IF NOT EXISTS `famillemonstre` (
  `idFamilleMonstre` tinyint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  UNIQUE KEY `idFamilleMonstre` (`idFamilleMonstre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `famillemonstre`
--

INSERT INTO `famillemonstre` (`idFamilleMonstre`, `libelle`) VALUES
(1, 'Gobelins'),
(2, 'Dragons'),
(3, 'Bandits'),
(4, 'Loups'),
(5, 'Ogres'),
(6, 'Trolls'),
(7, 'Ours');

-- --------------------------------------------------------

--
-- Structure de la table `loot`
--

DROP TABLE IF EXISTS `loot`;
CREATE TABLE IF NOT EXISTS `loot` (
  `idLoot` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(150) NOT NULL,
  `poids` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`idLoot`),
  UNIQUE KEY `id_loot` (`idLoot`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `loot`
--

INSERT INTO `loot` (`idLoot`, `libelle`, `poids`) VALUES
(1, 'Objet maudit', '5.00'),
(2, 'Cuivre', '0.05'),
(3, 'Argent', '0.15'),
(4, 'Electrum', '0.25'),
(5, 'Or', '0.40'),
(6, 'Objet magique', '5.00');

-- --------------------------------------------------------

--
-- Structure de la table `malediction`
--

DROP TABLE IF EXISTS `malediction`;
CREATE TABLE IF NOT EXISTS `malediction` (
  `idMalediction` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idMalediction`),
  UNIQUE KEY `id_malediction` (`idMalediction`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `malediction`
--

INSERT INTO `malediction` (`idMalediction`, `nom`, `description`) VALUES
(1, 'Test', 'Test malediction');

-- --------------------------------------------------------

--
-- Structure de la table `materiaux`
--

DROP TABLE IF EXISTS `materiaux`;
CREATE TABLE IF NOT EXISTS `materiaux` (
  `idMateriaux` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(95) NOT NULL,
  `effet` text NOT NULL,
  PRIMARY KEY (`idMateriaux`),
  UNIQUE KEY `idMateriaux` (`idMateriaux`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `materiaux`
--

INSERT INTO `materiaux` (`idMateriaux`, `nom`, `effet`) VALUES
(1, 'Test', 'Test materiau');

-- --------------------------------------------------------

--
-- Structure de la table `monstre`
--

DROP TABLE IF EXISTS `monstre`;
CREATE TABLE IF NOT EXISTS `monstre` (
  `idMonstre` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idFamilleMonstre` tinyint(5) UNSIGNED DEFAULT NULL,
  `libelle` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idMonstre`),
  UNIQUE KEY `id_monstre` (`idMonstre`) USING BTREE,
  UNIQUE KEY `libelleMonstre` (`libelle`) USING BTREE,
  KEY `FK_monstre_idFamilleMonstre` (`idFamilleMonstre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `monstre`
--

INSERT INTO `monstre` (`idMonstre`, `idFamilleMonstre`, `libelle`) VALUES
(1, 1, 'Gobelin'),
(2, 4, 'Loup'),
(3, 6, 'Troll'),
(4, 7, 'Ours'),
(5, 1, 'Mage Gobelin'),
(6, 1, 'Chef Gobelin'),
(7, 7, 'Mam\'Ours'),
(8, 7, 'Pap\'Ours'),
(9, NULL, 'Sanglier');

-- --------------------------------------------------------

--
-- Structure de la table `monte`
--

DROP TABLE IF EXISTS `monte`;
CREATE TABLE IF NOT EXISTS `monte` (
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idStatistique` tinyint(4) UNSIGNED NOT NULL,
  `niveau` tinyint(4) NOT NULL,
  `valeur` tinyint(4) UNSIGNED NOT NULL,
  PRIMARY KEY (`idPersonnage`,`idStatistique`,`niveau`) USING BTREE,
  KEY `Fk_monte_idStatistique` (`idStatistique`),
  KEY `idPersonnage` (`idPersonnage`,`idStatistique`,`niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `monte`
--

INSERT INTO `monte` (`idPersonnage`, `idStatistique`, `niveau`, `valeur`) VALUES
(1, 1, 0, 18),
(1, 1, 3, 2),
(1, 1, 5, 2),
(1, 2, 0, 8),
(1, 3, 0, 8),
(1, 4, 0, 14),
(1, 7, 0, 30);

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

DROP TABLE IF EXISTS `objet`;
CREATE TABLE IF NOT EXISTS `objet` (
  `idObjet` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPersonnage` smallint(5) UNSIGNED DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `bonus` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `prixNonHumanoide` float DEFAULT NULL,
  `devise` varchar(25) NOT NULL DEFAULT 'po',
  `idMalediction` smallint(5) UNSIGNED DEFAULT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `idMateriaux` smallint(5) UNSIGNED DEFAULT NULL,
  `taille` varchar(19) DEFAULT NULL,
  `degats` varchar(15) DEFAULT NULL,
  `critique` varchar(9) DEFAULT NULL,
  `facteurPortee` varchar(9) DEFAULT NULL,
  `armure` int(11) DEFAULT NULL,
  `bonusDexteriteMax` int(11) DEFAULT NULL,
  `malusArmureTests` int(11) DEFAULT NULL,
  `risqueEchecSorts` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`idObjet`),
  UNIQUE KEY `id_objet_magique` (`idObjet`),
  KEY `FK_objet_idMalediction` (`idMalediction`),
  KEY `FK_objet_idMateriaux` (`idMateriaux`),
  KEY `FK_objet_idPersonnage` (`idPersonnage`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `idPersonnage`, `nom`, `bonus`, `type`, `prix`, `prixNonHumanoide`, `devise`, `idMalediction`, `categorie`, `idMateriaux`, `taille`, `degats`, `critique`, `facteurPortee`, `armure`, `bonusDexteriteMax`, `malusArmureTests`, `risqueEchecSorts`) VALUES
(2, 1, 'objetTest', NULL, 'Test', 1000, NULL, 'po', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 'Alliances bénies', NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 'Alliances bénies', NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 'Contact d’adamantium', NULL, 'Anneau', 120000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 'Feu d’étoiles', NULL, 'Anneau', 50000, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

DROP TABLE IF EXISTS `personnage`;
CREATE TABLE IF NOT EXISTS `personnage` (
  `idPersonnage` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `niveau` tinyint(4) NOT NULL,
  PRIMARY KEY (`idPersonnage`),
  UNIQUE KEY `idPersonnage` (`idPersonnage`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`idPersonnage`, `nom`, `niveau`) VALUES
(1, '?', 3);

-- --------------------------------------------------------

--
-- Structure de la table `statistique`
--

DROP TABLE IF EXISTS `statistique`;
CREATE TABLE IF NOT EXISTS `statistique` (
  `idStatistique` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`idStatistique`),
  UNIQUE KEY `idStatistique` (`idStatistique`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `statistique`
--

INSERT INTO `statistique` (`idStatistique`, `libelle`) VALUES
(1, 'Intelligence'),
(2, 'Force'),
(3, 'Agilite'),
(4, 'Sagesse'),
(5, 'Constitution'),
(6, 'Vitalite'),
(7, 'Mana');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dropchance`
--
ALTER TABLE `dropchance`
  ADD CONSTRAINT `FK_dropchance_idLoot` FOREIGN KEY (`idLoot`) REFERENCES `loot` (`idLoot`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_dropchance_idMonstre` FOREIGN KEY (`idMonstre`) REFERENCES `monstre` (`idMonstre`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `dropchancebis`
--
ALTER TABLE `dropchancebis`
  ADD CONSTRAINT `FK_dropChanceBis_idLoot` FOREIGN KEY (`idLoot`) REFERENCES `loot` (`idLoot`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_dropChanceBis_idMonstre` FOREIGN KEY (`idMonstre`) REFERENCES `monstre` (`idMonstre`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetdecouvert`
--
ALTER TABLE `effetdecouvert`
  ADD CONSTRAINT `FK_effetdecouvert_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_effetdecouvert_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagique`
--
ALTER TABLE `effetmagique`
  ADD CONSTRAINT `FK_effetmagique_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquedescription`
--
ALTER TABLE `effetmagiquedescription`
  ADD CONSTRAINT `FK_effetmagiquedescription_idEffetMagique` FOREIGN KEY (`idEffetMagique`) REFERENCES `effetmagique` (`idEffetMagique`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiqueinfos`
--
ALTER TABLE `effetmagiqueinfos`
  ADD CONSTRAINT `FK_effetmagiqueinfos_idEffetMagique` FOREIGN KEY (`idEffetMagique`) REFERENCES `effetmagique` (`idEffetMagique`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquetable`
--
ALTER TABLE `effetmagiquetable`
  ADD CONSTRAINT `FK_effetmagiquetable_idEffetMagique` FOREIGN KEY (`idEffetMagique`) REFERENCES `effetmagique` (`idEffetMagique`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquetabletitle`
--
ALTER TABLE `effetmagiquetabletitle`
  ADD CONSTRAINT `FK_effetmagiquetabletitle_idEffetMagiqueTable` FOREIGN KEY (`idEffetMagiqueTable`) REFERENCES `effetmagiquetable` (`idEffetMagiqueTable`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquetabletitlecontent`
--
ALTER TABLE `effetmagiquetabletitlecontent`
  ADD CONSTRAINT `FK_effetmagiquetabletitlecontent_idEffetMagiqueTableTitle` FOREIGN KEY (`idEffetMagiqueTableTitle`) REFERENCES `effetmagiquetabletitle` (`idEffetMagiqueTableTitle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquetabletr`
--
ALTER TABLE `effetmagiquetabletr`
  ADD CONSTRAINT `FK_effetmagiquetabletr_idEffetMagiqueTable` FOREIGN KEY (`idEffetMagiqueTable`) REFERENCES `effetmagiquetable` (`idEffetMagiqueTable`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiquetabletrcontent`
--
ALTER TABLE `effetmagiquetabletrcontent`
  ADD CONSTRAINT `FK_effetmagiquetabletrcontent_idEffetMagiqueTableTr` FOREIGN KEY (`idEffetMagiqueTableTr`) REFERENCES `effetmagiquetabletr` (`idEffetMagiqueTableTr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiqueul`
--
ALTER TABLE `effetmagiqueul`
  ADD CONSTRAINT `FK_effetmagiqueul_idEffetMagique` FOREIGN KEY (`idEffetMagique`) REFERENCES `effetmagique` (`idEffetMagique`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `effetmagiqueulcontent`
--
ALTER TABLE `effetmagiqueulcontent`
  ADD CONSTRAINT `FK_effetmagiqueulcontent_idEffetMagiqueUl` FOREIGN KEY (`idEffetMagiqueUl`) REFERENCES `effetmagiqueul` (`idEffetMagiqueUl`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `monstre`
--
ALTER TABLE `monstre`
  ADD CONSTRAINT `FK_monstre_idFamilleMonstre` FOREIGN KEY (`idFamilleMonstre`) REFERENCES `famillemonstre` (`idFamilleMonstre`);

--
-- Contraintes pour la table `monte`
--
ALTER TABLE `monte`
  ADD CONSTRAINT `Fk_monte_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_monte_idStatistique` FOREIGN KEY (`idStatistique`) REFERENCES `statistique` (`idStatistique`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `objet`
--
ALTER TABLE `objet`
  ADD CONSTRAINT `FK_objet_idMalediction` FOREIGN KEY (`idMalediction`) REFERENCES `malediction` (`idMalediction`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_objet_idMateriaux` FOREIGN KEY (`idMateriaux`) REFERENCES `materiaux` (`idMateriaux`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_objet_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
