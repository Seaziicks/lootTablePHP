-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 05 oct. 2020 à 20:33
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
-- Base de données :  `u418341279_loottable`
--

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `idCompetence` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idCompetenceParente` smallint(5) UNSIGNED DEFAULT NULL,
  `titre` varchar(95) NOT NULL,
  `niveau` tinyint(4) NOT NULL DEFAULT 0,
  `icone` varchar(255) DEFAULT NULL,
  `contenu` text NOT NULL,
  `etat` varchar(19) NOT NULL DEFAULT 'locked',
  `optionnelle` tinyint(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `idCompetence` (`idCompetence`),
  KEY `FK_competence_idPersonnage` (`idPersonnage`),
  KEY `FK_competence_idCompetenceParente` (`idCompetenceParente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`idCompetence`, `idPersonnage`, `idCompetenceParente`, `titre`, `niveau`, `icone`, `contenu`, `etat`, `optionnelle`) VALUES
(1, 1, NULL, 'Jet de lave', 1, 'jet_de_lave.png', 'Projette un jet de lave qui inflige 1D4 de dégâts + bonusIntelligence.\r\nSurcharge de 15.', 'selected', 0),
(2, 1, 1, 'Javelot de Lave', 0, 'javelot_de_lave.png', 'Lance un javelot de lave qui inflige 2D6 de dégâts + bonusIntelligence. Fait reculer la cible de 1 case.\r\nSurcharge de 25.', 'unlocked', 0),
(3, 1, 1, 'Colonne de lave', 0, 'colonne_de_lave.png', 'Charge une colonne de lave à un endroit ciblé. Lors du tour suivant, la colonne de lave jaillira automatiquement, infligeant 3D2 + bonusIntelligence.\r\nSurcharge de 15.', 'unlocked', 0),
(4, 1, 2, 'Vague de Lave', 0, 'vague_de_lave.png', 'Cette vague inflige 3D6 + bonusIntelligence.\r\nElle s’étale sur 3 cases devant le magmaticien, et avance sur 4 cases.\r\nSurcharge de 30.', 'locked', 0),
(5, 1, 3, 'Pluie de lave', 0, 'pluie_de_lave.png', 'La pluie inflige sur chaque case 2D3 + bonusIntelligence.\r\nSurcharge de 20.', 'locked', 0),
(6, 1, NULL, 'Canalisation', 3, 'canalisation.png', 'Permet de réduire la surcharge de 1D20 + bonusIntelligence.\r\nQuand la surcharge atteint son maximum, la magie du magmaticien explose, infligeant 1D8 + bonusIntelligence autour de lui, et il subît 50% de ces dégâts.\r\nIl peut décider de contrôler la zone d\'explosion pour la réduire à un demi-cercle. Cela inflige alors 50% de dégâts de plus aux entités touchées, et au magmaticien.', 'selected', 0);

-- --------------------------------------------------------

--
-- Structure de la table `competencecontenu`
--

DROP TABLE IF EXISTS `competencecontenu`;
CREATE TABLE IF NOT EXISTS `competencecontenu` (
  `idCompetenceContenu` smallint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idCompetence` smallint(5) UNSIGNED NOT NULL,
  `niveauCompetenceRequis` tinyint(4) DEFAULT NULL,
  `contenu` text NOT NULL,
  UNIQUE KEY `idCompetenceContenu` (`idCompetenceContenu`),
  KEY `FK_competenceContenu_idCompetence` (`idCompetence`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `competencecontenu`
--

INSERT INTO `competencecontenu` (`idCompetenceContenu`, `idCompetence`, `niveauCompetenceRequis`, `contenu`) VALUES
(1, 1, NULL, 'Projette un jet de lave qui inflige 1D4 de dégâts + bonusIntelligence.'),
(2, 1, NULL, 'Surcharge de 15.'),
(3, 2, NULL, 'Lance un javelot de lave qui inflige 2D6 de dégâts + bonusIntelligence. Fait reculer la cible de 1 case.'),
(4, 2, NULL, 'Surcharge de 25.'),
(5, 3, NULL, 'Charge une colonne de lave à un endroit ciblé.'),
(6, 3, NULL, 'Lors du tour suivant, la colonne de lave jaillira automatiquement, infligeant 3D2 + bonusIntelligence.'),
(7, 3, NULL, 'Surcharge de 15.'),
(8, 4, NULL, 'Cette vague inflige 3D6 + bonusIntelligence.'),
(9, 4, NULL, 'Elle s’étale sur 3 cases devant le magmaticien, et avance sur 4 cases.'),
(10, 4, NULL, 'Surcharge de 30.'),
(11, 5, NULL, 'La pluie inflige sur chaque case 2D3 + bonusIntelligence.'),
(12, 5, NULL, 'Surcharge de 20.'),
(13, 6, NULL, 'Permet de réduire la surcharge de 1D20 + bonusIntelligence.'),
(14, 6, NULL, 'Quand la surcharge atteint son maximum, la magie du magmaticien explose, infligeant 1D8 + bonusIntelligence autour de lui, et il subît 50% de ces dégâts.'),
(15, 6, 2, 'Il peut décider de contrôler la zone d\'explosion pour la réduire à un demi-cercle. Cela inflige alors 50% de dégâts de plus aux entités touchées, et au magmaticien.');

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
  `idEffetMagiqueDecouvert` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `idObjet` smallint(5) UNSIGNED NOT NULL,
  `effet` text NOT NULL,
  UNIQUE KEY `idEffetMagiqueDecouvert` (`idEffetMagiqueDecouvert`),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`idMalediction`),
  UNIQUE KEY `id_malediction` (`idMalediction`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `idNiveau` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idPersonnage` smallint(5) UNSIGNED NOT NULL,
  `niveau` tinyint(3) UNSIGNED NOT NULL,
  `intelligence` tinyint(4) NOT NULL,
  `forces` tinyint(4) NOT NULL,
  `agilite` tinyint(4) NOT NULL,
  `sagesse` tinyint(4) NOT NULL,
  `constitution` tinyint(4) NOT NULL,
  `vitalite` tinyint(4) NOT NULL,
  `deVitalite` tinyint(3) UNSIGNED NOT NULL,
  `vitaliteNaturelle` tinyint(4) NOT NULL,
  `mana` tinyint(4) NOT NULL,
  `deMana` tinyint(3) UNSIGNED NOT NULL,
  `manaNaturel` tinyint(4) NOT NULL,
  UNIQUE KEY `idNiveau` (`idNiveau`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `afficherNom` tinyint(1) NOT NULL DEFAULT 0,
  `afficherEffetMagique` tinyint(1) NOT NULL DEFAULT 0,
  `afficherMalediction` tinyint(1) NOT NULL DEFAULT 0,
  `afficherMateriau` tinyint(1) NOT NULL DEFAULT 0,
  `afficherInfos` tinyint(1) NOT NULL DEFAULT 0,
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
  `niveauEnAttente` tinyint(3) UNSIGNED NOT NULL,
  `deVitaliteNaturelle` tinyint(4) UNSIGNED NOT NULL DEFAULT 8,
  `deManaNaturel` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`idPersonnage`),
  UNIQUE KEY `idPersonnage` (`idPersonnage`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`idPersonnage`, `nom`, `niveau`, `niveauEnAttente`, `deVitaliteNaturelle`, `deManaNaturel`) VALUES
(0, 'Aucun personnage', 127, 0, 8, 0),
(1, '?', 0, 1, 8, 0),
(2, 'Drakcouille', 0, 0, 8, 0),
(8, 'Rocktar', 0, 0, 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `progressionpersonnage`
--

DROP TABLE IF EXISTS `progressionpersonnage`;
CREATE TABLE IF NOT EXISTS `progressionpersonnage` (
  `idProgressionPersonnage` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `niveau` tinyint(3) UNSIGNED NOT NULL,
  `statistiques` tinyint(1) NOT NULL DEFAULT 0,
  `nombreStatistiques` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `pointCompetence` tinyint(1) NOT NULL DEFAULT 0,
  `nombrePointsCompetences` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  UNIQUE KEY `idProgressionPersonnage` (`idProgressionPersonnage`),
  UNIQUE KEY `niveau` (`niveau`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `progressionpersonnage`
--

INSERT INTO `progressionpersonnage` (`idProgressionPersonnage`, `niveau`, `statistiques`, `nombreStatistiques`, `pointCompetence`, `nombrePointsCompetences`) VALUES
(1, 1, 1, 150, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `statistique`
--

DROP TABLE IF EXISTS `statistique`;
CREATE TABLE IF NOT EXISTS `statistique` (
  `idStatistique` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(20) NOT NULL,
  PRIMARY KEY (`idStatistique`),
  UNIQUE KEY `idStatistique` (`idStatistique`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `statistique`
--

INSERT INTO `statistique` (`idStatistique`, `libelle`) VALUES
(3, 'agilite'),
(5, 'constitution'),
(11, 'deMana'),
(8, 'deVitalite'),
(2, 'force'),
(1, 'intelligence'),
(9, 'mana'),
(10, 'manaNaturel'),
(4, 'sagesse'),
(6, 'vitalite'),
(7, 'vitaliteNaturelle');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idPersonnage` smallint(5) UNSIGNED DEFAULT NULL,
  `isGameMaster` tinyint(1) NOT NULL DEFAULT 0,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `idUser` (`idUser`),
  KEY `FK_user_idPersonnage` (`idPersonnage`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `idPersonnage`, `isGameMaster`, `isAdmin`) VALUES
(1, 'Jraam', 'banane00002', 1, 0, 1),
(13, 'JraamBis', 'banane00002', 2, 0, 0),
(14, 'admin', 'adminadmin', NULL, 0, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `competence`
--
ALTER TABLE `competence`
  ADD CONSTRAINT `FK_competence_idCompetenceParente` FOREIGN KEY (`idCompetenceParente`) REFERENCES `competence` (`idCompetence`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_competence_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `competencecontenu`
--
ALTER TABLE `competencecontenu`
  ADD CONSTRAINT `FK_competenceContenu_idCompetence` FOREIGN KEY (`idCompetence`) REFERENCES `competence` (`idCompetence`);

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

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_idPersonnage` FOREIGN KEY (`idPersonnage`) REFERENCES `personnage` (`idPersonnage`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
