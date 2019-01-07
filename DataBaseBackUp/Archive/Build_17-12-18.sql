-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: encrypted_chat
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `encrypted_chat`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `encrypted_chat` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `encrypted_chat`;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `mId` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `fromUser` int(11) NOT NULL,
  `toUser` int(11) NOT NULL,
  `timeSend` datetime NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `isEdited` tinyint(1) NOT NULL,
  PRIMARY KEY (`mId`),
  KEY `fk_fromUser` (`fromUser`),
  KEY `fk_toUser` (`toUser`),
  CONSTRAINT `fk_fromUser` FOREIGN KEY (`fromUser`) REFERENCES `users` (`uId`),
  CONSTRAINT `fk_toUser` FOREIGN KEY (`toUser`) REFERENCES `users` (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'HELLO WORLD! AND SWITZERLAND TOO!',6,7,'2018-12-02 19:48:59',0,1),(2,'wut u mean hello world nigga??',7,6,'2018-12-03 21:01:51',0,0),(3,'wut u mean hello world nigga??',7,6,'2018-12-03 21:02:16',0,0),(4,'BOI HE FINNA BUT DO IT',6,7,'2018-12-03 21:02:23',0,0),(5,'Nigga u up?',7,6,'2018-12-04 10:26:39',0,0),(6,'Fuckers in school telling me, always in the barber shop Chief Keef ainâ€™t bout this, Chief Keef ainâ€™t bout that My boy a BD on fucking Lamron and them He, he they say that nigga donâ€™t be putting in no work SHUT THE FUCK UP! Y\'all niggas ainâ€™t know shit All ya motherfuckers talk about Chief Keef ainâ€™t no hitta Chief Keef ainâ€™t this Chief Keef a fake SHUT THE FUCK UP Y\'all donâ€™t live with that nigga Y\'all know that nigga got caught with a ratchet Shootin\' at the police and shit Nigga been on probation since fuckin, I donâ€™t know when! Motherfuckers stop fuckin\' playin\' him like that Them niggas savages out there If I catch another motherfucker talking sweet about Chief Keef Iâ€™m fucking beating they ass! Iâ€™m not fucking playing no more You know those niggas role with Lil\' Reese and them',6,7,'2018-12-04 10:28:14',1,0),(8,'Hello World! 11.12.18',6,7,'2018-12-11 09:16:35',0,0),(9,'Hello World! 12.12.18',6,7,'2018-12-11 11:26:24',0,0);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `eMail` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `profilePicName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (6,'pedro','winkler','go@fuckyourself.com','$2y$10$nLqZobCA0DrvVDoRIZksnuNN9WLnclv8qNk/CgoUcyGyC..2LEfLC','DamnLongNeck',NULL),(7,'pedro','winkler','go@fuckyourself.com','$2y$10$AKqZjj1mUqbnevEnqqS4Cuaj6/j.jFsdtWW/mTz65Ry4Sgusr7.m.','New_UserName',NULL),(8,'pedro','winkler','go@fuckyourself.com','$2y$10$zMH/rj00CFo/ZU1nNUryf.JBFwXIkng/r8AOJbuKUInceJQ4uMfYy','testUser02',NULL),(9,'pedro','winkler','go@fuckyourself.com','$2y$10$rRbc.sbVQ/.lYOzGVLEwvuESWUi9DewdaRT3ToSDXG4NCszP2BfOS','testUser02',NULL),(10,'pedro','winkler','go@fuckyourself.com','$2y$10$nl8Xq4pknnVuLLURa.oOJumA62zrfkBCpukIBsqUxSv3VCWCuKvAu','testUser02',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-17 20:25:19
