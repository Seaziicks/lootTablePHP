-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 26 sep. 2020 à 23:24
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetdecouvert`
--

INSERT INTO `effetdecouvert` (`idEffetMagiqueDecouvert`, `idPersonnage`, `idObjet`, `effet`) VALUES
(1, 0, 2, 'Tout ce que je peux en dire, c\'est que c\'est une \"Faucille de la mort qui tue la vie et tout\" ...'),
(2, 0, 2, 'Deuxième effet découvert : Je me suis trompé sur le premier. En fait cet objet sert à servir le thé.'),
(5, 0, 2, 'Troisième effet : Le café, peut-être ?'),
(6, 0, 2, 'Dans mon sommeil, j\'ai cru entendre l\'objet dire : \"Error 418, I\'m a teapot.\". Probablement que c\'était bien le thé !'),
(19, 2, 2, 'Effet personnel, que seul moi peut voir !');

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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagique`
--

INSERT INTO `effetmagique` (`idEffetMagique`, `idObjet`, `title`) VALUES
(2, 2, 'EffetMagiqueTest'),
(36, 27, 'Alliances bénies'),
(37, 28, 'Ami du chapardeur'),
(38, 29, 'Amitié avec les animaux'),
(39, 30, 'Attaque tournoyante'),
(40, 31, 'Barrière mentale'),
(41, 32, 'Bonté inflexible'),
(42, 33, 'Affaiblissante'),
(43, 34, 'Allié'),
(44, 35, 'Affaiblissante'),
(45, 36, 'Ami du chapardeur'),
(46, 39, 'Alliances bénies'),
(47, 39, 'Amitié avec les animaux'),
(48, 40, 'Contrôle des éléments et élémentaires'),
(49, 40, 'Dragonaux'),
(50, 44, 'Allonge'),
(51, 44, 'Allié'),
(52, 44, 'Ancrage'),
(53, 49, 'Antiprojectile'),
(54, 49, 'Âme liée'),
(55, 49, 'Affaiblissante'),
(56, 49, 'Alerte'),
(57, 50, 'Colère'),
(58, 50, 'Contagieuse'),
(59, 50, 'Cornelame'),
(60, 50, 'Corbeau blanc'),
(61, 50, 'Acérée'),
(62, 51, 'Alliances bénies'),
(63, 52, 'Alliances bénies'),
(64, 53, 'Alliances bénies'),
(65, 54, 'Alliances bénies'),
(66, 55, 'Alliances bénies'),
(67, 56, 'Alliances bénies'),
(68, 57, 'Alliances bénies'),
(69, 58, 'Alliances bénies');

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
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquedescription`
--

INSERT INTO `effetmagiquedescription` (`idEffetMagiqueDescription`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Ce casque d’aspect normal révèle sa puissance quand son utilisateur l’enfile et prononce le mot de commande. Fait d’argent rutilant et d’acier poli, un casque de mille feux nouvellement créé est serti de 10 diamants, 20 rubis, 30 opales de feu et 40 opales, chacune de ces pierres étant magiques. À ce moment, les aspérités qu’il arbore donnent l’impression que le personnage porte une couronne enchâssée de pierres précieuses. Au moindre rai de lumière, le casque brille de mille feux, d’où son nom. Les fonctions des pierres sont les suivantes :'),
(2, 2, 'Le casque peut être utilisé une fois par round, mais chaque pierre perd son éclat après avoir utilisé son pouvoir. Tant que toutes ses pierres ne sont pas ternes, le casque de mille feux a les propriétés suivantes :'),
(3, 2, 'Une fois que toutes les pierres ont été utilisées, elles tombent en poussière et le casque perd tous ses pouvoirs. Toute pierre que l’on essaye d’extraire se brise automatiquement.'),
(4, 2, 'Si le porteur du casque est brûlé par un feu d’origine magique (malgré l’importante protection dont il bénéficie) et s’il rate un jet de Volonté (DD 15), une surcharge se produit et toutes les pierres restantes saturent et explosent instantanément. Les diamants deviennent des rayons prismatiques visant chacun une créature choisie au hasard parmi celles à portée (éventuellement le porteur lui-même), les rubis deviennent des murs de feu en ligne droite partant du porteur dans une direction aléatoire et les opales de feu deviennent des boules de feu centrées sur le porteur. Les opales et le casque lui-même sont détruits.'),
(98, 36, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(99, 36, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(100, 36, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(101, 37, 'Quand il est activé, cet anneau d\'acier attire tout objet métallique non fixé situé dans un rayon de 30 cm et ne pesant pas plus de 30 g (généralement, une pièce, un bijou ou une petite clef). Les objets n\'ont pas besoin d\'être ferreux, il leur suffit de contenir du métal, quel qu\'il soit. Un ami du chapardeur confère également un bonus de  5 aux tests d\'Escamotage impliquant des objets métalliques.'),
(102, 38, 'Sur commande, cet anneau affecte l’animal désigné comme si le personnage venait de lancer le sort charme-animal.'),
(103, 39, 'Le porteur de cet anneau représentant un tourbillon stylisé peut utiliser le don Attaque en rotation comme une attaque standard, au lieu d\'une attaque à outrance.'),
(104, 39, 'et anneau n\'a aucun effet sur une créature n\'ayant pas le don Attaque en rotation.'),
(105, 40, 'Dans la plupart des cas, cet anneau est en or massif finement ouvragé. Son porteur est immunisé en permanence contre les sorts détection de pensées et détection du mensonge, ainsi que contre toutes les tentatives faites pour déterminer son alignement par magie.'),
(106, 41, 'Cet anneau en or est orné de divers runes signifiant \"Bien \"Bonté\" et autres sens similaires. Il est porté par les agents du bien qui craignent que la magie les fasse retourner contre leur cause.'),
(107, 41, 'Le porteur de cet anneau est immunisé contre tout effet modifiant son alignement vers un alignement non-bon. De plus, le porteur considère un acte maléfique comme un acte suicidaire dans le cadre des sorts ou effets de charme et coercition.'),
(108, 41, 'Cet anneau vient avec quelques restrictions, bien que son porteur ne les considèrent que rarement comme tel. Premièrement, le porteur de cet anneau est incapable de lancer des sorts dotés du registre du Mal. Et deuxièmement, le porteur de cet anneau subit un malus de -2 aux jets d\'attaque contre les créatures du sous-type Bien.'),
(109, 41, 'Toute créature mauvaise essayant de porter cet anneau acquiert aussitôt deux niveaux négatifs, qui persistent jusqu’à ce qu’elle se débarrasse de l’anneau. Ces niveaux négatifs n’entraîne jamais une perte de niveau réelle, mais aucun sort, pas même restauration, ne permet de le résorber tant que l’aventurier conserve l’anneau.'),
(110, 42, 'Sur un coup critique, cette arme inflige un affaiblissement temporaire de 1d6 2 points de Force en plus de ses dégâts habituels. La résistance à la magie est applicable. Arcs, arbalètes et frondes ainsi conçus confèrent la propriété affaiblissante à leurs munitions.'),
(111, 43, 'Un bouclier ayant cette propriété spéciale est décorée d\'anneaux. Ces anneaux semblent se liés avec ceux d\'autres boucliers d\'allié quand ils sont mis côte à côte.'),
(112, 43, 'Le bonus d\'altération d\'un bouclier d\'allié augmente de  1 pour chaque allié adjacent portant aussi un bouclier d\'allié.'),
(113, 44, 'Sur un coup critique, cette arme inflige un affaiblissement temporaire de 1d6 2 points de Force en plus de ses dégâts habituels. La résistance à la magie est applicable. Arcs, arbalètes et frondes ainsi conçus confèrent la propriété affaiblissante à leurs munitions.'),
(114, 45, 'Quand il est activé, cet anneau d\'acier attire tout objet métallique non fixé situé dans un rayon de 30 cm et ne pesant pas plus de 30 g (généralement, une pièce, un bijou ou une petite clef). Les objets n\'ont pas besoin d\'être ferreux, il leur suffit de contenir du métal, quel qu\'il soit. Un ami du chapardeur confère également un bonus de  5 aux tests d\'Escamotage impliquant des objets métalliques.'),
(115, 46, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(116, 47, 'Sur commande, cet anneau affecte l’animal désigné comme si le personnage venait de lancer le sort charme-animal.'),
(117, 46, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(118, 46, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(119, 48, 'Il existe quatre sortes d’anneaux de contrôle des éléments, tous aussi puissants les uns que les autres. Tous ressemblent à des anneaux magiques de moindre puissance jusqu’à ce que l’intégralité de leurs pouvoirs soit réveillée (voir ci-dessous), mais ils ont certaines propriétés en commun.'),
(120, 48, 'Les élémentaires originaires du plan auquel l’anneau est lié ne peuvent pas attaquer le porteur de l’anneau, ni même l’approcher à moins de 1,50 mètre. Si le personnage le souhaite, il peut tenter de charmer l’élémentaire (comme à l’aide du sort charme-monstre, jet de Volonté DD 17 pour annuler), mais cela l’oblige à abandonner la protection dont il dispose. Si le charme échoue, l’anneau ne protège plus le porteur et aucune autre tentative de charme n’est possible.'),
(121, 49, 'Ces (plusieurs) anneaux de laiton ressemblent à des serpents ou à des dragons se mordant la queue. Ils sont créés par les membres du Culte du Dragon et sont tenus en haute estime par les plus hauts représentants de cette organisation. Le Culte en a réalisé près de soixante-dix jusqu\'à présent. Le porteur d\'un tel anneau dispose des pouvoirs suivants :'),
(122, 48, 'Les créatures originaires du plan auquel l’anneau est lié subissent un malus de–1 aux jets d’attaque contre le porteur de l’anneau. Dans le même temps, le personnage bénéficie d’un bonus de résistance de  2 à tous les jets de sauvegarde contre les attaques de ces créatures extraplanaires, tandis que lui-même les combat avec davantage de facilité, grâce à un bonus de moral de  4 à toutes les attaques. Enfin, toutes les armes qu’il utilise ignorent la réduction des dégâts dont la créature bénéficie éventuellement et ceci quelles que soient les propriétés que son arme puisse posséder ou non.'),
(123, 48, 'Le porteur de l’anneau peut discuter avec les créatures natives du plan avec lequel l’anneau est lié. Ces entités sont conscientes qu’il porte un anneau apparenté à leur élément et lui montrent un grand respect si leur alignement est similaire. En cas d’alignement contraire, les créatures craignent le personnage s’il est puissant. Par contre, s’il est faible, elles le haïssent et n’ont qu’un seul but : le tuer. La réaction des entités élémentaires (respect, crainte ou haine) est déterminée selon les cas.'),
(124, 48, 'Le possesseur d’un anneau de contrôle des éléments subit un malus à certains jets de sauvegarde, comme indiqué ci-dessous :'),
(125, 48, 'En plus des propriétés détaillées ci-dessus, chaque anneau possède des pouvoirs dépendant de son type :'),
(126, 48, 'Anneau de contrôle des éléments (Air)'),
(127, 48, 'Cet anneau semble n’être qu’un anneau de feuille morte tant qu’une condition bien précise n’a pas été remplie, comme le fait de plonger l’anneau dans de l’eau bénite, de tuer seul un élémentaire de l’Air, ou toute autre tâche adéquate. Il doit être réactivé chaque fois qu’il change de porteur.'),
(128, 48, 'Anneau de contrôle des éléments (Eau)'),
(129, 48, 'Cet anneau se comporte comme un anneau de marche sur l’onde tant que la condition déterminée n’a pas été remplie.'),
(130, 48, 'Anneau de contrôle des éléments (Feu)'),
(131, 48, 'Cet anneau se comporte comme un anneau majeur de résistance aux énergies destructives ( feu) tant que la condition déterminée n’a pas été remplie.'),
(132, 48, 'Anneau de contrôle des éléments (Terre)'),
(133, 48, 'Cet anneau se comporte comme un anneau de fusion dans la pierre tant que la condition déterminée n’a pas été remplie.'),
(134, 50, 'Une armure d\'allonge défend son porteur contre les attaques éloignées. Elle confère un bonus de circonstance de  6 à la CA contre les attaques de corps à corps portées par des créatures non-adjacentes.'),
(135, 51, 'Un bouclier ayant cette propriété spéciale est décorée d\'anneaux. Ces anneaux semblent se liés avec ceux d\'autres boucliers d\'allié quand ils sont mis côte à côte.'),
(136, 51, 'Le bonus d\'altération d\'un bouclier d\'allié augmente de  1 pour chaque allié adjacent portant aussi un bouclier d\'allié.'),
(137, 52, 'Un personnage portant une armure ou un bouclier accompagné de cette propriété spéciale est quasiment indéracinable en combat. Il bénéficie en effet d\'un bonus d\'altération de  5 aux tests de caractéristique visant à résister aux tentatives de bousculade, de croc-en-jambe ou de renversement.'),
(138, 53, 'Cette propriété spéciale ne peut être placée que sur une arme de corps à corps. Une arme antiprojectile protège son porteur comme si celui-ci possédait le don Parade de projectile. Une fois par round, quand le personnage devrait normalement être frappé par une arme à distance, l\'arme détourne le projectile. Le personnage doit voir venir l\'attaque et ne pas être pris au dépourvu. Parer un projectile n\'est pas considéré comme étant une action. Il est impossible de détourner les projectiles hors normes, comme un rocher ou une flèche acide de Melf.'),
(139, 54, 'Une arme d\'âme liée est une arme ayant la capacité d\'être utilisée comme un réceptacle à essentia.'),
(140, 55, 'Sur un coup critique, cette arme inflige un affaiblissement temporaire de 1d6 2 points de Force en plus de ses dégâts habituels. La résistance à la magie est applicable. Arcs, arbalètes et frondes ainsi conçus confèrent la propriété affaiblissante à leurs munitions.'),
(141, 54, 'Pour chaque point d\'essentia investie dans une arme d\'âme liée, l\'arme augmente son bonus d\'altération de 1 (pour un maximum de  5). Une arme d\'âme liée à une capacité max dépendant non pas du niveau de son utilisateur mais de sa puissance. Une arme d\'âme liée mineure à une capacité de 2, une majeure de 4.'),
(142, 54, 'De plus, une arme d\'âme liée peut être lié aux chakras suivants pour obtenir des effets supplémentaires :'),
(143, 56, 'Le porteur d\'une arme d\'alerte ne perd jamais son bonus de Dextérité lorsqu\'il se trouve pris au dépourvu (de la même manière que s\'il disposait de la capacité esquive instinctive). Cette propriété ne donne aucun avantagé particulier aux personnages qui disposent de la capacité esquive instinctive.'),
(144, 54, ': le porteur gagne un bonus d\'intuition de  2 à ses jets pour confirmer un coup critique avec cette arme.'),
(145, 54, ': le personnage gagne un bonus d\'intuition de  2 à ses jets d\'initiative s\'il a cette arme à main.'),
(146, 54, ': le personnage peut, une fois par round, relancer toute chance de rater une cible à cause de son camouflage.'),
(147, 57, 'Une arme de colère n\'ajoute pas son bonus d\'altération aux jets d\'attaque, mais ajoute le double de celui-ci aux jets de dégâts.'),
(148, 58, 'Parfois utilisée par les seigneurs putrides de Talona ou les séides des plus sinistres des Magiciens Rouges, cette arme abominable infecte immédiatement la créature qu\'elle blesse, sans la moindre période d\'incubation. Toute créature touchée doit réussir un jet de Vigueur (DD 12) pour éviter de contracter la fièvre des marais. Cette maladie inflige 1d3 points d\'affaiblissement temporaire de Dextérité et 1d3 points d\'affaiblissement temporaire de Constitution. Le sujet continue à souffrir des effets de la maladie jusqu\'à guérir naturellement ou être soigné par magie. Une victime infectée plusieurs fois de suite ne subit pas d\'effet supplémentaire : soit le sujet est atteint par la fièvre, soit il ne l\'est pas.'),
(149, 59, 'Cette propriété ne peut être placée que sur une arme de corps à corps. Elle fut mise au point par les gnomes et les halfelins pour leur permettre de se servir d\'armes plus grandes. Un halfelin ou un gnome est considéré comme étant de taille M pour déterminer s\'il peut utiliser une cornelame et si elle est légère, à une main ou deux mains. Ainsi, une épée longue  1 cornelame de taille M est normalement considérée comme une arme à deux mains pour une créature de taille P et impose un malus de -2 sur les jets d\'attaque, mais un gnome ou un halfelin peut la tenir à une main sans malus. L\'arme ne change pas pour ce qui est de la formation à son maniement ou des dons comme Arme de prédilection. Elle ne présente aucune particularité pour une créature autre qu\'un gnome ou un halfelin.'),
(150, 57, 'Ainsi, une épée longue  3 de colère possède un bonus d\'altération de  0 aux jets d\'attaque, mais de  6 aux jets de dégâts.'),
(151, 59, 'La plupart des cornelames sont des épées courtes ou longues de taille M dont la lame est recourbée, même s\'il arrive, à de rares occasions, que des épieux, des lances ou des piques reçoivent cette propriété spéciale. Les premières cornelames furent fabriquées à partir de cornes ou de ramures d\'animaux et la plupart sont encore ornées de fragments de cornes ou de motifs évoquant des cornes.'),
(152, 60, 'Une arme du Corbeau blanc confère un bonus de  1 aux jets d\'attaque portée avec elle si son porteur connait au moins une manoeuvre du Corbeau blanc. Ce bonus passe à  3 lorsque le porteur initie une manoeuvre du Corbeau blanc ou qu\'il utilise une posture du Corbeau blanc.'),
(153, 61, 'Cette propriété ne peut être placée que sur des armes de corps à corps tranchantes ou perforantes. La zone de critique possible d’une arme acérée est doublée par rapport à une arme ordinaire. Par exemple, une épée longue ordinaire a une zone de critique possible de 19–20, tandis que celle d’une épée longue  1 acérée est de 17–20. Les effets de cette propriété ne se cumulent pas avec des effets similaires étendant la zone de critique possible, comme le sort affûtage ou le don Science du critique.'),
(154, 62, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(155, 62, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(156, 62, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(157, 63, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(158, 63, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(159, 63, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(160, 64, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(161, 64, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(162, 64, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(163, 65, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(164, 65, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(165, 65, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(166, 66, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(167, 66, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(168, 66, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(169, 67, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(170, 67, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(171, 67, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(172, 68, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(173, 68, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(174, 68, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.'),
(175, 69, 'Ces anneaux peuvent prendre des apparences très variées et vont toujours par paire. Ils sont créés pour deux personnes précises, et n\'ont aucun effet portés par une autre personne. Les deux anneaux doivent être portées par la bonne personne pour que leurs effets soient actifs.'),
(176, 69, 'Un porteur d\'une alliance bénie connait l\'état de santé de l\'autre porteur comme par un effet de Rapport, si ce n\'est que les barrières planaires ne bloquent pas cet effet. De plus, chaque porteur peut communiquer avec l\'autre comme apr un sort de Message.'),
(177, 69, 'Le prix indiqué est le prix de base de l\'objet, mais les alliances bénies sont souvent décorés de pierres précieuses qui en augmente le prix.');

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
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueinfos`
--

INSERT INTO `effetmagiqueinfos` (`idEffetMagiqueInfos`, `idEffetMagique`, `contenu`) VALUES
(1, 2, 'Multiples puissantes '),
(2, 2, ' <span class=\"compobj\">NLS</span> 13 '),
(3, 2, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-objets-merveilleux-23.htm#23\">Création d’objets merveilleux</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-boule-de-feu.htm\">boule de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-detection-des-morts-vivants.htm\">détection des morts-vivants</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lame-de-feu.htm\">lame de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lumiere.htm\">lumière</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-mur-de-feu.htm\">mur de feu</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-protection-contre-les-energies-destructives.htm\">protection contre les énergies destructives</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rayons-prismatiques.htm\">rayons prismatiques</a> '),
(4, 2, ' <span class=\"compobj\">Prix</span> 125 000 po '),
(5, 2, ' <span class=\"compobj\">Poids</span> 1,5 kg.'),
(78, 36, '<span class=\"divi\">Divination</span> faible '),
(79, 36, ' <span class=\"compobj\">NLS</span> 3 '),
(80, 36, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(81, 36, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(82, 37, '<span class=\"transmu\">Transmutation</span> faible '),
(83, 37, ' <span class=\"compobj\">NLS</span> 12 '),
(84, 37, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-manipulation-a-distance.htm\">manipulation à distance</a> '),
(85, 37, ' <span class=\"compobj\">Prix</span> 2 500 po.'),
(86, 38, '<span class=\"enchen\">Enchantement</span> faible '),
(87, 38, ' <span class=\"compobj\">NLS</span> 3 '),
(88, 38, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-charme-animal.htm\">charme-animal</a> '),
(89, 38, ' <span class=\"compobj\">Prix</span> 10 800 po.'),
(90, 39, '<span class=\"transmu\">Transmutation</span> faible '),
(91, 39, ' <span class=\"compobj\">NLS</span> 4 '),
(92, 39, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, Attaque en rotation '),
(93, 39, ' <span class=\"compobj\">Prix</span> 8 000 po.'),
(94, 40, '<span class=\"abju\">Abjuration</span> faible '),
(95, 40, ' <span class=\"compobj\">NLS</span> 3 '),
(96, 40, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-antidetection.htm\">antidétection</a> '),
(97, 40, ' <span class=\"compobj\">Prix</span> 8 000 po.'),
(98, 41, '<span class=\"abju\">Abjuration</span> [Bien] faible '),
(99, 41, ' <span class=\"compobj\">NLS</span> 5 '),
(100, 41, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, le créateur doit être bon '),
(101, 41, ' <span class=\"compobj\">Prix</span> 4 000 po.'),
(102, 42, '<span class=\"necro\">Nécromancie</span> faible '),
(103, 42, ' <span class=\"compobj\">NLS</span> 5 '),
(104, 42, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, rayon d’affaiblissement '),
(105, 42, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(106, 43, '<span class=\"abju\">Abjuration</span> faible '),
(107, 43, ' <span class=\"compobj\">NLS</span> 5 '),
(108, 43, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a> '),
(109, 43, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(110, 44, '<span class=\"necro\">Nécromancie</span> faible '),
(111, 44, ' <span class=\"compobj\">NLS</span> 5 '),
(112, 44, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, rayon d’affaiblissement '),
(113, 44, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(114, 45, '<span class=\"transmu\">Transmutation</span> faible '),
(115, 45, ' <span class=\"compobj\">NLS</span> 12 '),
(116, 45, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-manipulation-a-distance.htm\">manipulation à distance</a> '),
(117, 45, ' <span class=\"compobj\">Prix</span> 2 500 po.'),
(118, 47, '<span class=\"enchen\">Enchantement</span> faible '),
(119, 47, ' <span class=\"compobj\">NLS</span> 3 '),
(120, 46, '<span class=\"divi\">Divination</span> faible '),
(121, 47, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-charme-animal.htm\">charme-animal</a> '),
(122, 46, ' <span class=\"compobj\">NLS</span> 3 '),
(123, 47, ' <span class=\"compobj\">Prix</span> 10 800 po.'),
(124, 46, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(125, 46, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(126, 49, '<span class=\"divi\">Divination</span> puissante '),
(127, 49, ' <span class=\"compobj\">NLS</span> 15 '),
(128, 49, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-communication-a-distance.htm\">communication à distance</a>, détection des pensées, <a href=\"http://www.gemmaline.com/sorts/sort-nom-don-des-langues.htm\">don des langues</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-image-silencieuse.htm\">image silencieuse</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-lien-telepathique-de-rary.htm\">lien têlépathique de Rary</a> '),
(129, 49, ' <span class=\"compobj\">Prix</span> 25 000 po.'),
(130, 48, '<span class=\"invo\">Invocation</span> puissante '),
(131, 48, ' <span class=\"compobj\">NLS</span> 15 '),
(132, 48, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, convocation de monstres VI, ainsi que tous les autres sorts que l’anneau met à la disposition de son porteur '),
(133, 48, ' <span class=\"compobj\">Prix</span> 200 000 po.'),
(134, 50, '<span class=\"invo\">Invocation</span> faible '),
(135, 51, '<span class=\"abju\">Abjuration</span> faible '),
(136, 50, ' <span class=\"compobj\">NLS</span> 5 '),
(137, 52, '<span class=\"transmu\">Transmutation</span> faible '),
(138, 51, ' <span class=\"compobj\">NLS</span> 5 '),
(139, 52, ' <span class=\"compobj\">NLS</span> 5 '),
(140, 50, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-armure-de-mage.htm\">armure de mage</a> '),
(141, 51, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a> '),
(142, 52, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-force-de-taureau.htm\">force de taureau</a> '),
(143, 50, ' <span class=\"compobj\">Prix</span> bonus de  2.'),
(144, 51, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(145, 52, ' <span class=\"compobj\">Prix</span>  3 750 po.'),
(146, 53, '<span class=\"transmu\">Transmutation</span> légère '),
(147, 55, '<span class=\"necro\">Nécromancie</span> faible '),
(148, 53, ' <span class=\"compobj\">NLS</span> 5 '),
(149, 55, ' <span class=\"compobj\">NLS</span> 5 '),
(150, 53, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-bouclier-entropique.htm\">bouclier entropique</a> '),
(151, 56, '<span class=\"transmu\">Transmutation</span> faible '),
(152, 55, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, rayon d’affaiblissement '),
(153, 53, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(154, 55, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(155, 56, ' <span class=\"compobj\">NLS</span> 7 '),
(156, 54, '<span class=\"transmu\">Transmutation</span> modérée (mineure) ou puissante (majeure) '),
(157, 56, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, capacité esquive instinctive '),
(158, 54, ' <span class=\"compobj\">NLS</span> 6 (mineure) ou 18 (majeure) '),
(159, 56, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(160, 54, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-arme-magique.htm\">arme magique</a>, doit avoir une réserve d’essentia de 2 (mineure) ou 4 (majeure) '),
(161, 54, ' <span class=\"compobj\">Prix</span> bonus de  1 (mineure) ou  3 (majeure).'),
(162, 58, '<span class=\"necro\">Nécromancie</span> faible '),
(163, 59, '<span class=\"transmu\">Transmutation</span> faible '),
(164, 57, '<span class=\"transmu\">Transmutation</span> faible '),
(165, 58, ' <span class=\"compobj\">NLS</span> 7 '),
(166, 57, ' <span class=\"compobj\">NLS</span> 3 '),
(167, 59, ' <span class=\"compobj\">NLS</span> 10 '),
(168, 58, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-contagion.htm\">contagion</a> '),
(169, 61, '<span class=\"transmu\">Transmutation</span> modérée '),
(170, 60, 'Evocation faible '),
(171, 57, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, Attaque en puissance,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-arme-magique.htm\">arme magique</a> '),
(172, 59, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-reduction-d-objet.htm\">réduction d’objet</a> '),
(173, 58, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(174, 60, ' <span class=\"compobj\">NLS</span> 5 '),
(175, 61, ' <span class=\"compobj\">NLS</span> 10 '),
(176, 57, ' <span class=\"compobj\">Prix</span>  850 po.'),
(177, 59, ' <span class=\"compobj\">Prix</span> bonus de  2.'),
(178, 60, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>, le créateur doit connaître au moins une manoeuvre du Corbeau blanc '),
(179, 61, '   <a href=\"http://www.gemmaline.com/dons/dons-creation-d-armes-et-armures-magiques-22.htm#22\">Création d’armes et armures magiques</a>,   <a href=\"http://www.gemmaline.com/sorts/sort-nom-affutage.htm\">affûtage</a> '),
(180, 61, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(181, 60, ' <span class=\"compobj\">Prix</span> bonus de  1.'),
(182, 62, '<span class=\"divi\">Divination</span> faible '),
(183, 62, ' <span class=\"compobj\">NLS</span> 3 '),
(184, 62, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(185, 62, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(186, 63, '<span class=\"divi\">Divination</span> faible '),
(187, 63, ' <span class=\"compobj\">NLS</span> 3 '),
(188, 63, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(189, 63, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(190, 64, '<span class=\"divi\">Divination</span> faible '),
(191, 64, ' <span class=\"compobj\">NLS</span> 3 '),
(192, 64, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(193, 64, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(194, 65, '<span class=\"divi\">Divination</span> faible '),
(195, 65, ' <span class=\"compobj\">NLS</span> 3 '),
(196, 65, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(197, 65, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(198, 66, '<span class=\"divi\">Divination</span> faible '),
(199, 66, ' <span class=\"compobj\">NLS</span> 3 '),
(200, 66, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(201, 66, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(202, 67, '<span class=\"divi\">Divination</span> faible '),
(203, 67, ' <span class=\"compobj\">NLS</span> 3 '),
(204, 67, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(205, 67, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(206, 68, '<span class=\"divi\">Divination</span> faible '),
(207, 68, ' <span class=\"compobj\">NLS</span> 3 '),
(208, 68, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(209, 68, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).'),
(210, 69, '<span class=\"divi\">Divination</span> faible '),
(211, 69, ' <span class=\"compobj\">NLS</span> 3 '),
(212, 69, ' <a href=\"http://www.gemmaline.com/dons/dons-creation-d-anneaux-magiques-21.htm#21\">Création d’anneaux magiques</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-message.htm\">message</a>, <a href=\"http://www.gemmaline.com/sorts/sort-nom-rapport.htm\">rapport</a> '),
(213, 69, ' <span class=\"compobj\">Prix</span> 7 600 po (la paire).');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetable`
--

INSERT INTO `effetmagiquetable` (`idEffetMagiqueTable`, `idEffetMagique`, `position`) VALUES
(1, 2, 1),
(6, 48, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletitle`
--

INSERT INTO `effetmagiquetabletitle` (`idEffetMagiqueTableTitle`, `idEffetMagiqueTable`) VALUES
(1, 1),
(2, 1),
(7, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

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
(18, 7, 'Élément (ok)'),
(19, 7, 'Malus au jet de sauvegarde');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiquetabletr`
--

INSERT INTO `effetmagiquetabletr` (`idEffetMagiqueTableTr`, `idEffetMagiqueTable`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(22, 6),
(23, 6),
(24, 6),
(25, 6);

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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

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
(63, 22, 'Air'),
(64, 22, '–2 contre les effets magiques liés à la terre'),
(65, 23, 'Eau'),
(66, 23, '–2 contre les effets magiques liés au feu'),
(67, 24, 'Feu'),
(68, 24, '–2 contre les effets magiques liés à l’eau ou au froid'),
(69, 25, 'Terre'),
(70, 25, '–2 contre les effets magiques liés à l’air ou à l’électricité');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueul`
--

INSERT INTO `effetmagiqueul` (`idEffetMagiqueUl`, `idEffetMagique`, `position`) VALUES
(1, 2, 1),
(18, 49, 1),
(19, 48, 7),
(20, 48, 9),
(21, 48, 11),
(22, 48, 13);

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
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `effetmagiqueulcontent`
--

INSERT INTO `effetmagiqueulcontent` (`idEffetMagiqueUlContent`, `idEffetMagiqueUl`, `contenu`) VALUES
(1, 1, 'Diamant : rayons prismatiques (jet de sauvegarde DD 20)'),
(2, 1, 'Rubis : mur de feu'),
(3, 1, 'Opale de feu : boule de feu (10d6, jet de Réflexes DD 20 pour demi-dégâts)'),
(4, 1, 'Opale : lumière'),
(101, 18, 'Verbalement (comme avec don des langues} ou télépathiquement (comme avec lien télépathique de Rary), le porteur peut communiquer avec tous les dragons qui se trouvent à portée de vue.'),
(102, 18, 'Il peut lancer une image silencieuse d\'un dragon une fois par jour et jusqu\'à une distance de 18 m. Le dragon ressemble à un dragon déjà rencontré par le porteur. Ce pouvoir est généralement utilisé comme moyen de se faire reconnaître ou en guise de diversion.'),
(103, 18, 'Il peut transmettre un appel à un dragon mauvais ou à une draco-liche de sa connaissance. La cible de ce pouvoir sait immédiatement où se trouve le porteur de l\'anneau et il lui est facile de le retrouver s\'il désire répondre à l\'appel, bien qu\'il n\'y soit en rien obligé. L\'appel reste actif jusqu\'à ce que l\'anneau soit retiré, que le porteur l\'annule ou qu\'il décède.'),
(104, 19, 'Bourrasque (2 fois par jour)'),
(105, 19, 'Éclair multiple (1 fois par semaine)'),
(106, 19, 'Feuille morte (usage illimité, porteur uniquement)'),
(107, 19, 'Marche dans les airs (1 fois par jour, porteur uniquement)'),
(108, 19, 'Mur de vent (usage illimité)'),
(109, 19, 'Résistance aux énergies destructives (électricité) (usage illimité, porteur uniquement)'),
(110, 20, 'Contrôle de l’eau (2 fois par semaine)'),
(111, 20, 'Création d’eau (usage illimité)'),
(112, 20, 'Marche sur l’onde (usage illimité)'),
(113, 20, 'Mur de glace (1 fois par jour)'),
(114, 20, 'Respiration aquatique (usage illimité)'),
(115, 20, 'Tempête de grêle (2 fois par semaine)'),
(116, 21, 'Colonne de feu (2 fois par semaine)'),
(117, 21, 'Mains brûlantes (usage illimité)'),
(118, 21, 'Mur de feu (1 fois par jour)'),
(119, 21, 'Pyrotechnie (2 fois par jour)'),
(120, 21, 'Résistance aux énergies destructives (feu) (comme un anneau majeur de résistance aux énergies destructives ( feu))'),
(121, 21, 'Sphère de feu (2 fois par jour)'),
(122, 22, 'Fusion dans la pierre (usage illimité, porteur uniquement)'),
(123, 22, 'Ramollissement de la terre et de la pierre (usage illimité)'),
(124, 22, 'Façonnage de la pierre (2 fois par jour)'),
(125, 22, 'Peau de pierre (1 fois par semaine, porteur uniquement)'),
(126, 22, 'Passe-muraille (2 fois par semaine)'),
(127, 22, 'Mur de pierre (1 fois par jour)');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `materiaux`
--

INSERT INTO `materiaux` (`idMateriaux`, `nom`, `effet`) VALUES
(1, 'Test', 'Test materiau'),
(8, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(9, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(10, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(11, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(12, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(13, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(14, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(15, '<a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a>', 'Pèse 500 g de moins, bonus de circonstance de  1 aux tests de Déguisement'),
(16, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(17, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(18, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(19, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.'),
(20, '<a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a>', 'Considéré comme d\'alignement bon face à une réduction des dégâts.');

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
(1, 1, 6, 2),
(1, 1, 7, 0),
(1, 2, 0, 8),
(1, 2, 6, 0),
(1, 2, 7, 0),
(1, 3, 0, 8),
(1, 3, 6, 0),
(1, 3, 7, 0),
(1, 4, 0, 14),
(1, 4, 6, 0),
(1, 4, 7, 0),
(1, 5, 0, 13),
(1, 5, 6, 0),
(1, 5, 7, 0),
(1, 6, 0, 0),
(1, 6, 6, 0),
(1, 6, 7, 0),
(1, 7, 0, 30),
(1, 7, 6, 1),
(1, 7, 7, 1),
(1, 8, 0, 5),
(1, 8, 1, 1),
(1, 8, 6, 5),
(1, 8, 7, 7),
(1, 9, 0, 0),
(1, 9, 6, 0),
(1, 9, 7, 0),
(1, 10, 0, 8),
(1, 10, 1, 7),
(1, 10, 6, 0),
(1, 10, 7, 0),
(1, 11, 0, 0),
(1, 11, 6, 0),
(1, 11, 7, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `objet`
--

INSERT INTO `objet` (`idObjet`, `idPersonnage`, `nom`, `fauxNom`, `bonus`, `type`, `prix`, `prixNonHumanoide`, `devise`, `idMalediction`, `categorie`, `idMateriaux`, `taille`, `degats`, `critique`, `facteurPortee`, `armure`, `bonusDexteriteMax`, `malusArmureTests`, `risqueEchecSorts`, `afficherNom`, `afficherEffetMagique`, `afficherMalediction`, `afficherMateriau`, `afficherInfos`) VALUES
(2, 0, 'objetTest', 'Faucille de la mort qui tue la vie et tout', 3, 'Test', 1000, NULL, '0', 1, NULL, 1, 'petit', '1', 'x3', '1.5m', 2, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(27, 1, 'Alliances bénies', 'Anneaux de fers', NULL, 'Anneau', 7600, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(28, 1, 'Ami du chapardeur', 'Anneau de pierre', NULL, 'Anneaux', 2500, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(29, 1, 'Amitié avec les animaux', NULL, NULL, 'Anneau', 10800, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(30, 1, 'Attaque tournoyante', 'Anneau de lys', NULL, 'Anneau', 8000, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(31, 1, 'Barrière mentale', 'Anneau de protection mental', NULL, 'Anneau', 8000, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 0, 0, 0),
(32, 1, 'Bonté inflexible', 'Anneau de magie d\'abjuration', NULL, 'Anneau', 4000, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 1),
(33, 1, '<a href=\"http://www.gemmaline.com/arme-dague-coup-de-poing.htm\">Dague coup-de-poing</a> Minuscule en <a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a> Affaiblissante', 'Petite dague', 1, 'Armes de corps à corps légères', 0, 0, 'po', NULL, 'Armes de corps à corps légères', 8, 'Minuscule', '1d1', 'x3', '—', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(34, 1, '<a href=\"http://www.gemmaline.com/armure-robe-lourde.htm\">Robe lourde</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a> Allié', 'Robinnette', 1, 'Vêtements', 262, 262, '0', NULL, 'Vêtements', 9, 'Infime', NULL, NULL, NULL, 1, NULL, NULL, '0 %', 0, 1, 1, 1, 1),
(35, 1, '<a href=\"http://www.gemmaline.com/arme-dague-coup-de-poing.htm\">Dague coup-de-poing</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a> Affaiblissante', NULL, 1, 'Armes de corps à corps légères', 0, 0, 'po', NULL, 'Armes de corps à corps légères', 10, 'Infime', '1d0', 'x3', '—', NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(36, 1, 'Ami du chapardeur', 'Anneau magique', NULL, 'Anneau', 2500, 0, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(37, 1, 'Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(38, 1, 'Alliances bénies', NULL, NULL, 'Anneau', 10800, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(39, 1, 'AnneauAlliances bénies & Amitié avec les animaux', NULL, NULL, 'Anneau', 10800, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(40, 1, 'Anneau Contrôle des éléments et élémentaires & Dragonaux', 'Anneau puissant', NULL, 'Anneau', 25000, 0, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0),
(43, 1, '<a href=\"http://www.gemmaline.com/armure-robe-lourde.htm\">Robe lourde</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a> Allié & Allonge & Ancrage', NULL, 1, 'Vêtements', 4012, 262, 'po', NULL, 'Vêtements', 14, 'Infime', NULL, NULL, NULL, 1, 10, 0, '0 %', 0, 0, 0, 0, 0),
(44, 1, '<a href=\"http://www.gemmaline.com/armure-robe-lourde.htm\">Robe lourde</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#cameleondoyant\">Caméléondoyant</a> Allié & Allonge & Ancrage', 'Robe lourde', 1, 'Vêtements', 4012, 262, 'po', NULL, 'Vêtements', 15, 'Infime', NULL, NULL, NULL, 1, NULL, NULL, '0 %', 0, 0, 0, 0, 0),
(48, 1, '<a href=\"http://www.gemmaline.com/arme-dague-coup-de-poing.htm\">Dague coup-de-poing</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a> Affaiblissante & Alerte & Âme liée & Antiprojectile', NULL, 1, 'Armes de corps à corps légères', 0, NULL, 'po', NULL, 'Armes de corps à corps légères', 18, 'Infime', '1d0', 'x3', '—', NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0),
(49, 1, '<a href=\"http://www.gemmaline.com/arme-dague-coup-de-poing.htm\">Dague coup-de-poing</a> Infime en <a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a> Affaiblissante & Alerte & Âme liée & Antiprojectile', NULL, 1, 'Armes de corps à corps légères', 0, NULL, 'po', NULL, 'Armes de corps à corps légères', 19, 'Infime', '1d0', 'x3', '—', NULL, NULL, NULL, NULL, 1, 1, 0, 0, 0),
(50, 0, '<a href=\"http://www.gemmaline.com/arme-durelame-chondathienne.htm\">Durelame chondathienne</a> Moyenne en <a href=\"http://www.gemmaline.com/materiaux.htm#acier-ignifie\">Acier ignifié</a> Colère & Contagieuse & Corbeau blanc & Cornelame & Acérée', NULL, 1, 'Armes de corps à corps à une main', 850, NULL, 'po', NULL, 'Armes de corps à corps à une main', 20, 'Moyenne', '1d8', '19–20/x2', '—', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(51, 0, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(52, 0, 'Anneau Alliances bénies', 'FauxNom', NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(53, 0, 'Anneau Alliances bénies', 'FauxNom', NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0),
(54, 0, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(55, 0, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(56, 0, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(57, 0, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0),
(58, 1, 'Anneau Alliances bénies', NULL, NULL, 'Anneau', 7600, NULL, 'po', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, 0, 0);

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
(1, '?', 7, 0, 8, 0),
(2, 'Drakcouille', 5, 0, 8, 0),
(8, 'Rocktar', 5, 0, 8, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `progressionpersonnage`
--

INSERT INTO `progressionpersonnage` (`idProgressionPersonnage`, `niveau`, `statistiques`, `nombreStatistiques`, `pointCompetence`, `nombrePointsCompetences`) VALUES
(3, 3, 0, 0, 1, 1),
(4, 4, 1, 2, 0, 0),
(16, 5, 0, 0, 0, 0),
(17, 6, 1, 2, 1, 1),
(20, 7, 0, 0, 0, 0),
(21, 8, 1, 2, 0, 0),
(22, 9, 0, 0, 1, 1),
(23, 10, 1, 2, 0, 0),
(50, 11, 0, 0, 0, 0),
(51, 12, 0, 0, 0, 0),
(67, 13, 0, 0, 0, 0),
(73, 14, 0, 0, 0, 0),
(74, 15, 0, 0, 0, 0),
(75, 16, 0, 0, 0, 0);

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
