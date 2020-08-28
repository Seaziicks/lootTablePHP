-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 28 août 2020 à 15:02
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagique`
--

INSERT INTO `effetmagique` (`idEffetMagique`, `libelle`, `description`) VALUES
(1, 'Feu (faible)', 'Permet d\'allumer une flamme de faible puissance, 3 fois par jour max.');

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
  `libelle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id_malediction` (`idMalediction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `materiaux`
--

DROP TABLE IF EXISTS `materiaux`;
CREATE TABLE IF NOT EXISTS `materiaux` (
  `idMateriaux` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` int(11) NOT NULL,
  `effet` int(11) NOT NULL,
  PRIMARY KEY (`idMateriaux`),
  UNIQUE KEY `idMateriaux` (`idMateriaux`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `nom` varchar(150) NOT NULL,
  `bonus` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `effetMagique` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `prixNonHumanoide` int(11) NOT NULL,
  `devise` int(11) NOT NULL,
  `malediction` int(11) NOT NULL,
  `categorie` int(11) NOT NULL,
  `materiau` int(11) NOT NULL,
  `taille` int(11) NOT NULL,
  `degats` int(11) NOT NULL,
  `critique` int(11) NOT NULL,
  `facteurPortee` int(11) NOT NULL,
  `armure` int(11) NOT NULL,
  `bonusDexteriteMax` int(11) NOT NULL,
  `malusArmureTests` int(11) NOT NULL,
  `risqueEchecSorts` int(11) NOT NULL,
  PRIMARY KEY (`idObjet`),
  UNIQUE KEY `id_objet_magique` (`idObjet`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `nom`, `bonus`, `type`, `effetMagique`, `prix`, `prixNonHumanoide`, `devise`, `malediction`, `categorie`, `materiau`, `taille`, `degats`, `critique`, `facteurPortee`, `armure`, `bonusDexteriteMax`, `malusArmureTests`, `risqueEchecSorts`) VALUES
(1, 'anneau', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'bâton', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'sceptre', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'parchemin', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'potion', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'baguette', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'merveilleux', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 'amulette', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
-- Contraintes pour la table `dropchancebis`
--
ALTER TABLE `dropchancebis`
  ADD CONSTRAINT `FK_dropChanceBis_idLoot` FOREIGN KEY (`idLoot`) REFERENCES `loot` (`idLoot`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_dropChanceBis_idMonstre` FOREIGN KEY (`idMonstre`) REFERENCES `monstre` (`idMonstre`) ON UPDATE CASCADE;

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
