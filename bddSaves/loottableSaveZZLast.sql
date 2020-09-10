-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 10 sep. 2020 à 15:20
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

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
  `multiplier` tinyint(4) NOT NULL DEFAULT '1',
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
  `diceNumber` tinyint(4) NOT NULL DEFAULT '1',
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
(1, 6, 2, NULL, 1, 6, 10),
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagique`
--

INSERT INTO `effetmagique` (`idEffetMagique`, `idObjet`, `title`) VALUES
(2, 2, 'EffetMagiqueTest');

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquedescription`
--

INSERT INTO `effetmagiquedescription` (`idEffetMagiqueDescription`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Ce casque d’aspect normal révèle sa puissance quand son utilisateur l’enfile et prononce le mot de commande. Fait d’argent rutilant et d’acier poli, un casque de mille feux nouvellement créé est serti de 10 diamants, 20 rubis, 30 opales de feu et 40 opales, chacune de ces pierres étant magiques. À ce moment, les aspérités qu’il arbore donnent l’impression que le personnage porte une couronne enchâssée de pierres précieuses. Au moindre rai de lumière, le casque brille de mille feux, d’où son nom. Les fonctions des pierres sont les suivantes :'),
(2, 2, 'Le casque peut être utilisé une fois par round, mais chaque pierre perd son éclat après avoir utilisé son pouvoir. Tant que toutes ses pierres ne sont pas ternes, le casque de mille feux a les propriétés suivantes :'),
(3, 2, 'Une fois que toutes les pierres ont été utilisées, elles tombent en poussière et le casque perd tous ses pouvoirs. Toute pierre que l’on essaye d’extraire se brise automatiquement.'),
(4, 2, 'Si le porteur du casque est brûlé par un feu d’origine magique (malgré l’importante protection dont il bénéficie) et s’il rate un jet de Volonté (DD 15), une surcharge se produit et toutes les pierres restantes saturent et explosent instantanément. Les diamants deviennent des rayons prismatiques visant chacun une créature choisie au hasard parmi celles à portée (éventuellement le porteur lui-même), les rubis deviennent des murs de feu en ligne droite partant du porteur dans une direction aléatoire et les opales de feu deviennent des boules de feu centrées sur le porteur. Les opales et le casque lui-même sont détruits.');

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
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueinfos`
--

INSERT INTO `effetmagiqueinfos` (`idEffetMagiqueInfos`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Multiples puissantes '),
(2, 2, ' <span class=\"compobj\">NLS</span> 13 '),
(3, 2, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-objets-merveilleux-23.htm#23\">Création d’objets merveilleux</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-boule-de-feu.htm\">boule de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-detection-des-morts-vivants.htm\">détection des morts-vivants</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lame-de-feu.htm\">lame de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lumiere.htm\">lumière</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-mur-de-feu.htm\">mur de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-protection-contre-les-energies-destructives.htm\">protection contre les énergies destructives</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rayons-prismatiques.htm\">rayons prismatiques</a> '),
(4, 2, ' <span class=\"compobj\">Prix</span> 125 000 po '),
(5, 2, ' <span class=\"compobj\">Poids</span> 1,5 kg.');

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
(1, 2, 1);

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
(2, 1);

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
(9, 2, 'Animal');

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
(5, 1);

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
(30, 5, 'Tigre ');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueul`
--

INSERT INTO `effetmagiqueul` (`idEffetMagiqueUl`, `idEffetMagique`, `position`) VALUES
(1, 2, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueulcontent`
--

INSERT INTO `effetmagiqueulcontent` (`idEffetMagiqueUlContent`, `idEffetMagiqueUl`, `contenu`) VALUES
(1, 1, 'Diamant : rayons prismatiques (jet de sauvegarde DD 20)'),
(2, 1, 'Rubis : mur de feu'),
(3, 1, 'Opale de feu : boule de feu (10d6, jet de Réflexes DD 20 pour demi-dégâts)'),
(4, 1, 'Opale : lumière');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
  `fauxNom` varchar(255) DEFAULT NULL,
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
  `afficherNom` tinyint(1) NOT NULL DEFAULT '0',
  `afficherEffetMagique` tinyint(1) NOT NULL DEFAULT '0',
  `afficherMalediction` tinyint(1) NOT NULL DEFAULT '0',
  `afficherMateriau` tinyint(1) NOT NULL DEFAULT '0',
  `afficherInfos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idObjet`),
  UNIQUE KEY `id_objet_magique` (`idObjet`),
  KEY `FK_objet_idMalediction` (`idMalediction`),
  KEY `FK_objet_idMateriaux` (`idMateriaux`),
  KEY `FK_objet_idPersonnage` (`idPersonnage`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `idPersonnage`, `nom`, `fauxNom`, `bonus`, `type`, `prix`, `prixNonHumanoide`, `devise`, `idMalediction`, `categorie`, `idMateriaux`, `taille`, `degats`, `critique`, `facteurPortee`, `armure`, `bonusDexteriteMax`, `malusArmureTests`, `risqueEchecSorts`, `afficherNom`, `afficherEffetMagique`, `afficherMalediction`, `afficherMateriau`, `afficherInfos`) VALUES
(2, 1, 'objetTest', '', 3, 'Test', 1000, NULL, 'po', 1, NULL, 1, 'petit', '1d6', 'x3', '1.5m', 2, NULL, NULL, NULL, 0, 0, 0, 0, 0);

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
(1, 'intelligence'),
(2, 'force'),
(3, 'agilite'),
(4, 'sagesse'),
(5, 'constitution'),
(6, 'vitalite'),
(7, 'mana');

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
