-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 29 août 2020 à 01:15
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

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
  `idEffetMagique` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `nom` text NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `idEffectMagique` (`idEffetMagique`),
  KEY `FK_effetmagique_idObjet` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

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
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `nom` varchar(150) NOT NULL,
  `bonus` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `effetMagique` int(11) DEFAULT NULL,
  `prix` int(11) NOT NULL,
  `prixNonHumanoide` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Structure de la table `tableobjet`
--

DROP TABLE IF EXISTS `tableobjet`;
CREATE TABLE IF NOT EXISTS `tableobjet` (
  `idTableObjet` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  UNIQUE KEY `idTable` (`idTableObjet`),
  KEY `FK_tableobjet_idObjet` (`idObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tableobjettitle`
--

DROP TABLE IF EXISTS `tableobjettitle`;
CREATE TABLE IF NOT EXISTS `tableobjettitle` (
  `idTableObjetTitle` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTableObjet` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`idTableObjetTitle`),
  UNIQUE KEY `idTableObjetTitle` (`idTableObjetTitle`),
  KEY `FK_tableobjettitle_idTableObjet` (`idTableObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tableobjettitlecontent`
--

DROP TABLE IF EXISTS `tableobjettitlecontent`;
CREATE TABLE IF NOT EXISTS `tableobjettitlecontent` (
  `idTableObjetTitleContent` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTableObjetTitle` smallint(5) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idTableObjetTitleContent`),
  UNIQUE KEY `idTableObjetTitleContent` (`idTableObjetTitleContent`),
  KEY `FK_tableobjettitlecontent_idTableObjetTitle` (`idTableObjetTitle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tableobjettr`
--

DROP TABLE IF EXISTS `tableobjettr`;
CREATE TABLE IF NOT EXISTS `tableobjettr` (
  `idTableObjetTr` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTableObjet` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`idTableObjetTr`),
  UNIQUE KEY `idTableObjetTr` (`idTableObjetTr`),
  KEY `FK_tableobjettr_idTableObjet` (`idTableObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tableobjettrcontent`
--

DROP TABLE IF EXISTS `tableobjettrcontent`;
CREATE TABLE IF NOT EXISTS `tableobjettrcontent` (
  `idTableObjetTrContent` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idTableObjetTr` mediumint(8) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  PRIMARY KEY (`idTableObjetTrContent`),
  UNIQUE KEY `idTableObjetTrContent` (`idTableObjetTrContent`),
  KEY `FK_tableobjettrcontent_idTableObjetTitle` (`idTableObjetTr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ulobjet`
--

DROP TABLE IF EXISTS `ulobjet`;
CREATE TABLE IF NOT EXISTS `ulobjet` (
  `idUlObjet` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`idUlObjet`),
  UNIQUE KEY `idUlObjet` (`idUlObjet`),
  KEY `FK_ulobjet_idObjet` (`idObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ulobjetcontent`
--

DROP TABLE IF EXISTS `ulobjetcontent`;
CREATE TABLE IF NOT EXISTS `ulobjetcontent` (
  `idUlObjetContent` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUlObjet` smallint(6) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  UNIQUE KEY `idUlObjetContent` (`idUlObjetContent`),
  KEY `FK_ulobjetcontent_idUlObjet` (`idUlObjet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD CONSTRAINT `FK_effetdecouvert_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`),
  ADD CONSTRAINT `FK_effetdecouvert_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`);

--
-- Contraintes pour la table `effetmagique`
--
ALTER TABLE `effetmagique`
  ADD CONSTRAINT `FK_effetmagique_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);

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
  ADD CONSTRAINT `FK_objet_idMalediction` FOREIGN KEY (`idMalediction`) REFERENCES `malediction` (`idMalediction`),
  ADD CONSTRAINT `FK_objet_idMateriaux` FOREIGN KEY (`idMateriaux`) REFERENCES `materiaux` (`idMateriaux`),
  ADD CONSTRAINT `FK_objet_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`);

--
-- Contraintes pour la table `tableobjet`
--
ALTER TABLE `tableobjet`
  ADD CONSTRAINT `FK_tableobjet_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);

--
-- Contraintes pour la table `tableobjettitle`
--
ALTER TABLE `tableobjettitle`
  ADD CONSTRAINT `FK_tableobjettitle_idTableObjet` FOREIGN KEY (`idTableObjet`) REFERENCES `tableobjet` (`idTableObjet`);

--
-- Contraintes pour la table `tableobjettitlecontent`
--
ALTER TABLE `tableobjettitlecontent`
  ADD CONSTRAINT `FK_tableobjettitlecontent_idTableObjetTitle` FOREIGN KEY (`idTableObjetTitle`) REFERENCES `tableobjettitle` (`idTableObjetTitle`);

--
-- Contraintes pour la table `tableobjettr`
--
ALTER TABLE `tableobjettr`
  ADD CONSTRAINT `FK_tableobjettr_idTableObjet` FOREIGN KEY (`idTableObjet`) REFERENCES `tableobjet` (`idTableObjet`);

--
-- Contraintes pour la table `tableobjettrcontent`
--
ALTER TABLE `tableobjettrcontent`
  ADD CONSTRAINT `FK_tableobjettrcontent_idTableObjetTitle` FOREIGN KEY (`idTableObjetTr`) REFERENCES `tableobjettr` (`idTableObjetTr`);

--
-- Contraintes pour la table `ulobjet`
--
ALTER TABLE `ulobjet`
  ADD CONSTRAINT `FK_ulobjet_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);

--
-- Contraintes pour la table `ulobjetcontent`
--
ALTER TABLE `ulobjetcontent`
  ADD CONSTRAINT `FK_ulobjetcontent_idUlObjet` FOREIGN KEY (`idUlObjet`) REFERENCES `ulobjet` (`idUlObjet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
