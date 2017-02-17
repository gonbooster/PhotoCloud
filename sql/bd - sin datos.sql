/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.20 : Database - photocloud
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`photocloud` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;

USE `photocloud`;

/*Table structure for table `album` */

DROP TABLE IF EXISTS `album`;

CREATE TABLE `album` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` int(11) DEFAULT NULL,
  `Etiqueta` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Privacidad` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'private',
  `Fecha` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Usuario` (`Usuario`),
  CONSTRAINT `album_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `foto` */

DROP TABLE IF EXISTS `foto`;

CREATE TABLE `foto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` int(11) DEFAULT NULL,
  `Album` int(11) DEFAULT NULL,
  `Etiqueta` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Imagen` longblob NOT NULL,
  `Fecha` datetime NOT NULL,
  `VisitasSocios` int(11) NOT NULL DEFAULT '0',
  `VisitasInvitados` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `Usuario` (`Usuario`),
  KEY `foto_ibfk_2` (`Album`),
  CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`Album`) REFERENCES `album` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

/*Table structure for table `report` */

DROP TABLE IF EXISTS `report`;

CREATE TABLE `report` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Reportador` int(11) NOT NULL,
  `Reportado` int(11) NOT NULL,
  `Album` int(11) DEFAULT NULL,
  `Foto` int(11) DEFAULT NULL,
  `Fecha` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Reportador` (`Reportador`),
  KEY `Reportado` (`Reportado`),
  KEY `Album` (`Album`),
  KEY `Foto` (`Foto`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`Reportador`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`Reportado`) REFERENCES `usuario` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `report_ibfk_3` FOREIGN KEY (`Album`) REFERENCES `album` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `report_ibfk_4` FOREIGN KEY (`Foto`) REFERENCES `foto` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Nombre` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido1` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Apellido2` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Fecha` datetime NOT NULL,
  `Rango` int(1) NOT NULL DEFAULT '0',
  `TamanoRestante` float(8,2) NOT NULL DEFAULT '102400.00',
  `Estado` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'disabled',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
