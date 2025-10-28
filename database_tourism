-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 28, 2025 at 01:27 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `societe tourisme`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitee`
--

DROP TABLE IF EXISTS `activitee`;
CREATE TABLE IF NOT EXISTS `activitee` (
  `Id_Activitee` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Image` text COLLATE utf8mb4_unicode_ci,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Cout_Visite` decimal(15,2) DEFAULT NULL,
  `Id_Type` int DEFAULT NULL,
  `Id_Ville` int NOT NULL,
  PRIMARY KEY (`Id_Activitee`),
  UNIQUE KEY `Nom` (`Nom`),
  KEY `Id_Type` (`Id_Type`),
  KEY `Id_Ville` (`Id_Ville`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activitee`
--

INSERT INTO `activitee` (`Id_Activitee`, `Nom`, `Image`, `Description`, `Cout_Visite`, `Id_Type`, `Id_Ville`) VALUES
(1, 'Après-midi escalade à Siurana', 'https://www.bing.com/images/search?view=detailV2&ccid=ufWIMIHm&id=0D15FDCA846E8A4464FF332EDFE4B9B5BE03616C&thid=OIP.ufWIMIHmuJrEE9CjyylGIwHaE8&mediaurl=https%3a%2f%2fwww.gosswiler.com%2fcontent%2f3.galleries%2f3.climb%2f11.siurana-margalef%2f67.desiree-siurana.jpg&cdnurl=https%3a%2f%2fth.bing.com%2fth%2fid%2fR.b9f5883081e6b89ac413d0a3cb294623%3frik%3dbGEDvrW55N8uMw%26pid%3dImgRaw%26r%3d0&exph=1367&expw=2048&q=siurana+escalade&FORM=IRPRST&ck=305313E1669A9312D17865650ABE4211&selectedIndex=8&itb=0', 'Découvrez la Catalogne à travers ses reliefs avec notre activité phare : l\'escalade en pleine nature. Vous serez encadrés du début à la fin par des professionnels afin que petits et grands y trouvent leur compte.', 29.99, 4, 4),
(2, 'Après-midi escalade à Arco', 'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2016/08/1b17e3ed7d66a708b16719483f03fe43.jpeg', 'L\'Italie a beaucoup à offrir et notamment des frissons ! Nous vous proposons une activité escalade sur la plus belle falaise italienne, lieu de certaines grandes compétitions d\'escalade.', 29.99, 4, 3),
(3, 'Après-midi escalade à Margalef', 'https://th.bing.com/th/id/R.9097fb95b9f8ded2222e7b89aabb88da?rik=NEC49MrbGJdcHQ&riu=http%3a%2f%2fgripped.com%2fwp-content%2fuploads%2f2015%2f03%2fml.jpg&ehk=0ZtlI3MdhKgHjTWFlmGLthePsaEUnKuFEr9xw%2fT2a8o%3d&risl=&pid=ImgRaw&r=0', 'Pour les passionnés d\'escalade, découvrez les falaises de Margalef comme jamais auparavant. Prenez votre temps pour grimper et profitez de la vue que vous aurez pendant toute la montée, vous ne verrez ceci qu\'ici.', 29.99, 4, 5),
(4, 'Plongée dans les nombreuses épaves de Saint-Malo', 'https://saintmalosecret.fr/wp-content/uploads/2018/05/H%C3%A9lice-Fetlar.jpg', 'Avec un guide de palanquée, vous pourrez explorer les épaves entourant Saint-Malo comme le Fetlar ou le Hilda. Admirez la faune et la flore très précieuse qui ont pris possession des lieux et nagez parmi eux. Pour débutants ou confirmés.', 34.99, 1, 12),
(5, 'Plongez parmi la vie sous-marine costa-ricaine', 'https://tse4.mm.bing.net/th/id/OIP.EH2_fnvBRHihijxIKH7T8AHaFj?cb=12ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3', 'Sur les iles Cocos au Costa-Rica, vous allez avoir l\'opportunité de faire de la plongée sous-marine pour contempler la faune et la flore costa-ricaine. Des poissons multicolores aux coraux gigantesques, vous serez émerveillés.', 34.99, 1, 11),
(6, 'Snorkeling dans la Méditerranée au large de Barcelone', NULL, 'Passez un moment de partage en famille lors de votre passage à Barcelone avec cette activité snorkeling dans les eaux barcelonaises. Découvrez la faune maritime cachée de la Catalogne en étant encadrés par des moniteurs professionnels', 34.99, 8, 16),
(7, 'Plongée dans les eaux catalognes au large de Tarragona', NULL, 'Lors de votre escale à Tarragona, vous aurez l\'opportunité de plonger dans la mer Méditerranée et découvrir sa faune et sa flore maritime unique', 29.99, 1, 17);

-- --------------------------------------------------------

--
-- Table structure for table `circuit_touristique`
--

DROP TABLE IF EXISTS `circuit_touristique`;
CREATE TABLE IF NOT EXISTS `circuit_touristique` (
  `Id_Circuit_Touristique` int NOT NULL AUTO_INCREMENT,
  `Image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Duree_Circuit` int DEFAULT NULL,
  `Prix_Inscription` decimal(15,2) DEFAULT NULL,
  `Nb_Places_Dispo` int DEFAULT NULL,
  `Date_Depart` datetime DEFAULT NULL,
  `Id_Ville` int NOT NULL,
  `Id_Ville_1` int NOT NULL,
  PRIMARY KEY (`Id_Circuit_Touristique`),
  KEY `Id_Ville` (`Id_Ville`),
  KEY `Id_Ville_1` (`Id_Ville_1`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `circuit_touristique`
--

INSERT INTO `circuit_touristique` (`Id_Circuit_Touristique`, `Image`, `Description`, `Duree_Circuit`, `Prix_Inscription`, `Nb_Places_Dispo`, `Date_Depart`, `Id_Ville`, `Id_Ville_1`) VALUES
(1, '', 'Faites le tour de la Catalogne dans un parcours sportif qui mêlera sports extrêmes et moments tranquilles de découverte en famille', 3, 120.00, 80, '1994-10-31 14:12:52', 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `Id_Client` int NOT NULL AUTO_INCREMENT,
  `Identifiant` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Prenom` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Client`),
  UNIQUE KEY `Identifiant` (`Identifiant`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Id_Client`, `Identifiant`, `Nom`, `Prenom`, `Email`) VALUES
(1, '115544526399878136451', 'LERAY', 'Hadrien', 'hadrienleray@jaimelespatates.com');

-- --------------------------------------------------------

--
-- Table structure for table `etape`
--

DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `Id_Etape` int NOT NULL AUTO_INCREMENT,
  `Ordre` int DEFAULT NULL,
  `Date_` datetime DEFAULT NULL,
  `Duree` int DEFAULT NULL,
  `Id_Circuit_Touristique` int NOT NULL,
  `Id_Activitee` int NOT NULL,
  PRIMARY KEY (`Id_Etape`),
  KEY `Id_Circuit_Touristique` (`Id_Circuit_Touristique`),
  KEY `Id_Activitee` (`Id_Activitee`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `etape`
--

INSERT INTO `etape` (`Id_Etape`, `Ordre`, `Date_`, `Duree`, `Id_Circuit_Touristique`, `Id_Activitee`) VALUES
(1, 1, '1995-10-31 14:19:45', 2, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `Id_Pays` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Pays`),
  UNIQUE KEY `Nom` (`Nom`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pays`
--

INSERT INTO `pays` (`Id_Pays`, `Nom`) VALUES
(28, 'Afrique du Sud'),
(25, 'Albanie'),
(8, 'Allemagne'),
(39, 'Andorre'),
(11, 'Arabie Saoudite'),
(35, 'Argentine'),
(10, 'Autriche'),
(36, 'Bahreïn'),
(23, 'Belgique'),
(38, 'Brésil'),
(29, 'Bulgarie'),
(47, 'Cambodge'),
(17, 'Canada'),
(32, 'Colombie'),
(45, 'Costa Rica'),
(15, 'Croatie'),
(16, 'Danemark'),
(19, 'Égypte'),
(2, 'Espagne'),
(50, 'Estonie'),
(51, 'Finlande'),
(1, 'France'),
(37, 'Géorgie'),
(9, 'Grèce'),
(18, 'Hongrie'),
(41, 'Israël'),
(5, 'Italie'),
(44, 'Jamaïque'),
(33, 'Jordanie'),
(52, 'Laos'),
(49, 'Lituanie'),
(43, 'Macao'),
(21, 'Malaisie'),
(46, 'Malte'),
(20, 'Maroc'),
(6, 'Mexique'),
(31, 'Norvège'),
(13, 'Pays-Bas'),
(42, 'Philippines'),
(14, 'Pologne'),
(40, 'Porto Rico'),
(12, 'Portugal'),
(24, 'République Dominicaine'),
(7, 'Royaume-Uni'),
(30, 'Singapour'),
(34, 'Slovénie'),
(26, 'Suède'),
(22, 'Suisse'),
(27, 'Tunisie'),
(4, 'Turquie'),
(48, 'Ukraine'),
(3, 'USA'),
(53, 'Venezuela');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `Id_Reservation` int NOT NULL AUTO_INCREMENT,
  `Date_Reservation` datetime DEFAULT NULL,
  `nb_personne` int NOT NULL,
  `Id_Statut` int DEFAULT NULL,
  `Id_Circuit_Touristique` int NOT NULL,
  `Id_Client` int NOT NULL,
  PRIMARY KEY (`Id_Reservation`),
  KEY `Id_Statut` (`Id_Statut`),
  KEY `Id_Circuit_Touristique` (`Id_Circuit_Touristique`),
  KEY `Id_Client` (`Id_Client`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`Id_Reservation`, `Date_Reservation`, `nb_personne`, `Id_Statut`, `Id_Circuit_Touristique`, `Id_Client`) VALUES
(1, '2025-10-28 14:24:24', 4, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `statut`
--

DROP TABLE IF EXISTS `statut`;
CREATE TABLE IF NOT EXISTS `statut` (
  `Id_Statut` int NOT NULL AUTO_INCREMENT,
  `Statut` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Statut`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statut`
--

INSERT INTO `statut` (`Id_Statut`, `Statut`) VALUES
(1, 'En Cours'),
(2, 'Validée'),
(3, 'Annulée');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `Id_Type` int NOT NULL AUTO_INCREMENT,
  `Type` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`Id_Type`, `Type`) VALUES
(1, 'Exploration Sous-Marine'),
(2, 'Kayak'),
(3, 'Randonnée'),
(4, 'Escalade'),
(5, 'Surf'),
(6, 'Ski'),
(7, 'Canyoning'),
(8, 'Snorkeling'),
(9, 'BMX'),
(10, 'Vélo'),
(11, 'Base Jumping'),
(12, 'Alpinisme');

-- --------------------------------------------------------

--
-- Table structure for table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
  `Id_Ville` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Id_Pays` int DEFAULT NULL,
  PRIMARY KEY (`Id_Ville`),
  UNIQUE KEY `Nom` (`Nom`),
  KEY `Id_Pays` (`Id_Pays`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ville`
--

INSERT INTO `ville` (`Id_Ville`, `Nom`, `Id_Pays`) VALUES
(1, 'Margegaj', 25),
(3, 'Arco', 5),
(4, 'Siurana', 2),
(5, 'Margalef', 2),
(6, 'Navágio', 9),
(7, 'Kjerag', 31),
(8, 'Kamarata', 53),
(9, 'Sipadan', 21),
(10, 'Islas Hormigas', 2),
(11, 'Islas Cocos', 45),
(12, 'Saint-Malo', 1),
(13, 'Belle île', 1),
(14, 'Quiberon', 1),
(15, 'Guidel', 1),
(16, 'Barcelone', 2),
(17, 'Tarragona', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitee`
--
ALTER TABLE `activitee`
  ADD CONSTRAINT `activitee_ibfk_1` FOREIGN KEY (`Id_Type`) REFERENCES `type` (`Id_Type`),
  ADD CONSTRAINT `activitee_ibfk_2` FOREIGN KEY (`Id_Ville`) REFERENCES `ville` (`Id_Ville`);

--
-- Constraints for table `circuit_touristique`
--
ALTER TABLE `circuit_touristique`
  ADD CONSTRAINT `circuit_touristique_ibfk_1` FOREIGN KEY (`Id_Ville`) REFERENCES `ville` (`Id_Ville`),
  ADD CONSTRAINT `circuit_touristique_ibfk_2` FOREIGN KEY (`Id_Ville_1`) REFERENCES `ville` (`Id_Ville`);

--
-- Constraints for table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `etape_ibfk_1` FOREIGN KEY (`Id_Circuit_Touristique`) REFERENCES `circuit_touristique` (`Id_Circuit_Touristique`),
  ADD CONSTRAINT `etape_ibfk_2` FOREIGN KEY (`Id_Activitee`) REFERENCES `activitee` (`Id_Activitee`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Id_Statut`) REFERENCES `statut` (`Id_Statut`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Id_Circuit_Touristique`) REFERENCES `circuit_touristique` (`Id_Circuit_Touristique`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`Id_Client`) REFERENCES `client` (`Id_Client`);

--
-- Constraints for table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`Id_Pays`) REFERENCES `pays` (`Id_Pays`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
