-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 12 août 2020 à 17:59
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
-- Structure de la table `armemagique`
--

DROP TABLE IF EXISTS `armemagique`;
CREATE TABLE IF NOT EXISTS `armemagique` (
  `idArmeMagique` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(150) NOT NULL,
  UNIQUE KEY `id_arme_magique` (`idArmeMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `armemagique`
--

INSERT INTO `armemagique` (`idArmeMagique`, `libelle`) VALUES
(1, 'Arbalète'),
(2, 'Arc'),
(3, 'Dague'),
(4, 'Epée'),
(5, 'Epée courte'),
(6, 'Faux'),
(7, 'Fléau'),
(8, 'Hache'),
(9, 'Lance'),
(10, 'Massue');

-- --------------------------------------------------------

--
-- Structure de la table `armuremagique`
--

DROP TABLE IF EXISTS `armuremagique`;
CREATE TABLE IF NOT EXISTS `armuremagique` (
  `idArmureMagique` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  UNIQUE KEY `id_armure_magique` (`idArmureMagique`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `armuremagique`
--

INSERT INTO `armuremagique` (`idArmureMagique`, `libelle`) VALUES
(1, 'Botte'),
(2, 'Brassard'),
(3, 'Ceinture'),
(4, 'Coiffe'),
(5, 'Épaulettes'),
(6, 'Gants'),
(7, 'Jambières'),
(8, 'Torse');

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
(1, 1, 5, 12, NULL, 10, 20),
(1, 2, 13, 17, NULL, 5, 20),
(1, 3, 18, 19, NULL, 1, 3),
(1, 4, 20, 20, NULL, 1, 100),
(1, 5, 1, 1, NULL, 1, 100);

-- --------------------------------------------------------

--
-- Structure de la table `effetdecouvert`
--

DROP TABLE IF EXISTS `effetdecouvert`;
CREATE TABLE IF NOT EXISTS `effetdecouvert` (
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idPossede` smallint(5) UNSIGNED NOT NULL,
  `effet` text NOT NULL,
  KEY `FK_effetdecouvert_idPersonnage` (`idPersonnage`),
  KEY `FK_effetdecouvert_idPossede` (`idPossede`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `effetmagique`
--

DROP TABLE IF EXISTS `effetmagique`;
CREATE TABLE IF NOT EXISTS `effetmagique` (
  `idEffetMagique` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` text NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `idEffectMagique` (`idEffetMagique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `enchante`
--

DROP TABLE IF EXISTS `enchante`;
CREATE TABLE IF NOT EXISTS `enchante` (
  `idEnchantement` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `idEffetMagique` smallint(5) UNSIGNED NOT NULL,
  UNIQUE KEY `idEnchantement` (`idEnchantement`),
  KEY `FK_enchante_idObjet` (`idObjet`) USING BTREE,
  KEY `FK_encahnte_idEffetMagique` (`idEffetMagique`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `famillemonstre`
--

DROP TABLE IF EXISTS `famillemonstre`;
CREATE TABLE IF NOT EXISTS `famillemonstre` (
  `idFamilleMonstre` tinyint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  UNIQUE KEY `idFamilleMonstre` (`idFamilleMonstre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `famillemonstre`
--

INSERT INTO `famillemonstre` (`idFamilleMonstre`, `libelle`) VALUES
(1, 'Gobelins'),
(2, 'Dragons'),
(3, 'Bandits'),
(4, 'Loups'),
(5, 'Ogres'),
(6, 'Trolls');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `loot`
--

INSERT INTO `loot` (`idLoot`, `libelle`, `poids`) VALUES
(1, 'Cuivre', '0.05'),
(2, 'Argent', '0.15'),
(3, 'Or', '0.25'),
(4, 'Objet magique', '5.00'),
(5, 'Objet maudit', '5.00');

-- --------------------------------------------------------

--
-- Structure de la table `malediction`
--

DROP TABLE IF EXISTS `malediction`;
CREATE TABLE IF NOT EXISTS `malediction` (
  `idMalediction` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id_malediction` (`idMalediction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `maudit`
--

DROP TABLE IF EXISTS `maudit`;
CREATE TABLE IF NOT EXISTS `maudit` (
  `idMaudit` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `idMalediction` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`idMaudit`),
  UNIQUE KEY `idMaudit` (`idMaudit`),
  KEY `FK_maudit_idObjet` (`idObjet`),
  KEY `FK_maudit_idMalediction` (`idMalediction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  KEY `FK_monstre_idFamilleMonstre` (`idFamilleMonstre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `monstre`
--

INSERT INTO `monstre` (`idMonstre`, `idFamilleMonstre`, `libelle`) VALUES
(1, 1, 'Gobelin'),
(2, NULL, 'Loup'),
(3, NULL, 'Troll'),
(4, NULL, 'Ours'),
(5, 1, 'Gobelin Mage'),
(6, 1, 'Gobelin Chef');

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
  `libelle` varchar(150) NOT NULL,
  PRIMARY KEY (`idObjet`),
  UNIQUE KEY `id_objet_magique` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `libelle`) VALUES
(1, 'anneau'),
(2, 'bâton'),
(3, 'sceptre'),
(4, 'parchemin'),
(5, 'potion'),
(6, 'baguette'),
(9, 'merveilleux'),
(10, 'amulette');

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
-- Structure de la table `possede`
--

DROP TABLE IF EXISTS `possede`;
CREATE TABLE IF NOT EXISTS `possede` (
  `idPossede` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idEnchante` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`idPossede`),
  UNIQUE KEY `idPossede` (`idPossede`),
  KEY `FK_possede_idPersonnage` (`idPersonnage`),
  KEY `FK_possede_idEnchante` (`idEnchante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Contraintes pour la table `effetdecouvert`
--
ALTER TABLE `effetdecouvert`
  ADD CONSTRAINT `FK_effetdecouvert_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`),
  ADD CONSTRAINT `FK_effetdecouvert_idPossede` FOREIGN KEY (`idPossede`) REFERENCES `possede` (`idPossede`);

--
-- Contraintes pour la table `enchante`
--
ALTER TABLE `enchante`
  ADD CONSTRAINT `FK_encahnte_idEffetMagique` FOREIGN KEY (`idEffetMagique`) REFERENCES `effetmagique` (`idEffetMagique`),
  ADD CONSTRAINT `FK_encahnte_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);

--
-- Contraintes pour la table `maudit`
--
ALTER TABLE `maudit`
  ADD CONSTRAINT `FK_maudit_idMalediction` FOREIGN KEY (`idMalediction`) REFERENCES `malediction` (`idMalediction`),
  ADD CONSTRAINT `FK_maudit_idObjet` FOREIGN KEY (`idObjet`) REFERENCES `objet` (`idObjet`);

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
-- Contraintes pour la table `possede`
--
ALTER TABLE `possede`
  ADD CONSTRAINT `FK_possede_idEnchante` FOREIGN KEY (`idEnchante`) REFERENCES `enchante` (`idEnchantement`),
  ADD CONSTRAINT `FK_possede_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
