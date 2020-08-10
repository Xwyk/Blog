CREATE DATABASE  IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `blog`;
-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: blog
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `isValid` tinyint(1) NOT NULL,
  `author` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `validation_date` datetime DEFAULT NULL,
  `validator` int(11) DEFAULT NULL,
  `post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `commentaire_validateur_idx` (`validator`),
  KEY `commentaire_auteur_idx` (`author`),
  KEY `commentaire_post_idx` (`post`),
  CONSTRAINT `commentaire_auteur` FOREIGN KEY (`author`) REFERENCES `user` (`id`),
  CONSTRAINT `commentaire_post` FOREIGN KEY (`post`) REFERENCES `post` (`id`),
  CONSTRAINT `commentaire_validateur` FOREIGN KEY (`validator`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,'Trop bien',1,1,'2020-05-07 11:01:16','2020-05-07 09:20:00',1,1),(2,'Quatrième fils du roi Æthelwulf, Æthelred succède à son frère aîné Æthelberht sur le trône. Son bref règne est principalement marqué par la lutte contre les Vikings de la Grande Armée, qui envahissent le Wessex en 870. Æthelred et son frère cadet Alfred sont vaincus à la bataille de Reading en janvier 871, mais ils remportent la bataille d\'Ashdown quatre jours plus tard. Deux autres défaites s\'ensuivent pour les Anglais, à Basing fin janvier et à Meretun deux mois plus tard. Æthelred collabore par ailleurs avec le royaume voisin de Mercie, sur lequel règne son beau-frère Burgred, en alignant ses monnaies sur les siennes. C\'est la première frappe monétaire commune à tout le sud de l\'Angleterre.',1,1,'2020-05-15 15:36:33','0000-00-00 00:00:00',1,1),(3,'pouloulou',0,3,'2020-08-03 12:26:37','0000-00-00 00:00:00',NULL,1),(4,'a',0,3,'2020-08-03 12:50:58','0000-00-00 00:00:00',NULL,1),(5,'zea',1,3,'2020-08-03 12:51:01','0000-00-00 00:00:00',NULL,1),(6,'fghdh',1,3,'2020-08-03 12:51:04','0000-00-00 00:00:00',NULL,1),(7,'hgfd',0,3,'2020-08-03 12:51:06','0000-00-00 00:00:00',NULL,1),(8,'dhgf',0,3,'2020-08-03 12:51:09','0000-00-00 00:00:00',NULL,1),(9,'fgdhs',0,3,'2020-08-03 12:51:11','0000-00-00 00:00:00',NULL,1),(10,'hfgdh,n',0,3,'2020-08-03 12:51:14','0000-00-00 00:00:00',NULL,1),(11,' hdsfhyjk yu rksht',0,3,'2020-08-03 12:51:17','0000-00-00 00:00:00',NULL,1),(12,'yhsfrklnhkl rtd',0,3,'2020-08-03 12:51:25','0000-00-00 00:00:00',NULL,1),(13,'jfgh',0,3,'2020-08-03 12:51:35','0000-00-00 00:00:00',NULL,1),(14,'comm2',1,3,'2020-08-03 13:42:44','2020-08-03 17:08:32',NULL,2),(15,'bonjour',0,3,'2020-08-03 16:29:45','2020-08-03 16:30:00',NULL,1),(16,'hfgvbc    vcbx',0,1,'2020-08-04 09:13:09','2020-08-04 13:58:37',NULL,1),(17,'hibou',0,1,'2020-08-04 13:59:31','2020-08-05 17:11:18',NULL,1);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `comment_BEFORE_INSERT` BEFORE INSERT ON `comment` FOR EACH ROW BEGIN
    SET NEW.creation_date := SYSDATE();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `comment_BEFORE_UPDATE` BEFORE UPDATE ON `comment` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
    IF OLD.isvalid = 0 AND NEW.isValid = 1
    THEN
		SET NEW.validation_date := SYSDATE();
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `creation_date` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `chapo` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `modification_date` datetime NOT NULL,
  `picture` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_auteur_idx` (`author`),
  CONSTRAINT `post_auteur` FOREIGN KEY (`author`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,'Premier Texte','2020-05-07 11:01:16',1,'blablou','test test','2020-08-10 12:19:05','https://static-pepper.dealabs.com/threads/thread_large/default/1944894_2.jpg'),(2,'Second Texte','2020-05-07 11:01:16',1,'test2','Titre 2','2020-05-11 14:28:39',NULL),(3,'hgf','2020-08-05 16:05:03',1,'hgf','hgf','2020-08-05 16:05:03',NULL),(4,'hgf','2020-08-05 16:06:30',1,'hgf','hgf','2020-08-05 16:06:30',NULL),(5,'hgf','2020-08-05 16:06:45',1,'hgf','hgf','2020-08-05 16:06:45',NULL),(6,'hgf','2020-08-05 16:07:24',1,'hgf','hgf','2020-08-05 16:07:24',NULL),(7,'hgf','2020-08-05 16:08:13',1,'hgf','hgftyrdh','2020-08-05 16:08:13',NULL),(8,'hgf','2020-08-05 16:08:24',1,'hgf','hgftyrdh','2020-08-05 16:08:24',NULL),(9,'hgf','2020-08-05 16:09:03',1,'hgf','hgftyrdh','2020-08-05 16:09:03',NULL),(10,'hgf','2020-08-05 16:10:32',1,'hgf','hgftyrdh','2020-08-05 16:10:32',NULL),(11,'hgf','2020-08-05 16:10:39',1,'hgf','hgftyrdh','2020-08-05 16:10:39',NULL),(12,'hgf','2020-08-05 16:10:44',1,'hgf','hgftyrdh','2020-08-05 16:10:44',NULL),(13,'fd','2020-08-05 16:11:06',1,'fd','fd','2020-08-05 16:11:06',NULL),(14,'fd','2020-08-05 16:11:34',1,'fd','fd','2020-08-05 16:11:34',NULL),(15,'fd','2020-08-05 16:11:45',1,'fd','fd','2020-08-05 16:11:45',NULL),(16,'fd','2020-08-05 16:12:04',1,'fd','fd','2020-08-05 16:12:04',NULL),(17,'fd','2020-08-05 16:12:07',1,'fd','fd','2020-08-05 16:12:07',NULL),(18,'fd','2020-08-05 16:12:17',1,'fd','fd','2020-08-05 16:12:17',NULL),(19,'fd','2020-08-05 16:13:17',1,'fd','fd','2020-08-05 16:13:17',NULL),(20,'fd','2020-08-05 16:13:30',1,'fd','fd','2020-08-05 16:13:30',NULL),(21,'cxvcx','2020-08-05 17:28:27',3,'xvc','cx','2020-08-05 17:28:27',NULL),(22,'bonjour','2020-08-05 17:29:09',3,'gils de pute','mange tes morts','2020-08-05 17:29:09',NULL),(23,'iyujnvfgsh sdwfb','2020-08-10 12:51:48',1,'zryetreu','azerty','2020-08-10 12:51:48',NULL),(24,'gdfsgh','2020-08-10 12:53:39',1,'ghfdqgh','fdsvbgfds','2020-08-10 12:53:39',NULL),(25,'gdfsgh','2020-08-10 12:54:24',1,'ghfdqgh','fdsvbgfds','2020-08-10 12:54:24',NULL),(26,'gdfsgh','2020-08-10 12:56:18',1,'ghfdqgh','fdsvbgfds','2020-08-10 12:56:18','.\\images\\c522d3b9213a3b8a103eac78cd1ceebb.jpg');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `post_BEFORE_INSERT` BEFORE INSERT ON `post` FOR EACH ROW BEGIN
    SET NEW.creation_date := SYSDATE();
    SET NEW.modification_date := NEW.creation_date;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `post_BEFORE_UPDATE` BEFORE UPDATE ON `post` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
    SET NEW.modification_date := SYSDATE();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `token` (
  `value` varchar(64) COLLATE utf8_bin NOT NULL,
  `user` int(11) NOT NULL,
  `generation_date` datetime NOT NULL,
  `expiration_date` datetime NOT NULL,
  PRIMARY KEY (`value`),
  UNIQUE KEY `value_UNIQUE` (`value`),
  KEY `token_user_idx` (`user`),
  CONSTRAINT `token_user` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES ('01848ff96a3a544a978efd23105518a16da1db581e02e040c6b089e1165b533d',1,'2020-08-10 10:51:34','2020-08-10 10:52:34');
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `pseudo` varchar(45) NOT NULL,
  `mail_address` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` int(11) NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Florian','LEBOUL','florianleboul','florianleboul@gmail.com','$2y$10$jpXMgcNrzQxKM/IRh4dA9.yDxcB.8HvK7nMlJtWM83BZqvpdGJwv2',1,'2020-05-07 11:01:16',2,'2020-08-03 13:57:40'),(2,'Emilie','MUSSET','emymbs','emilie.musset5@gmail.com','$2y$10$jpXMgcNrzQxKM/IRh4dA9.yDxcB.8HvK7nMlJtWM83BZqvpdGJwv2',1,'2020-05-07 11:01:16',1,'2020-08-03 13:57:40'),(3,'FLORIAN','LEBOUL','loreal','loreal@babtou.fr','$2y$10$jpXMgcNrzQxKM/IRh4dA9.yDxcB.8HvK7nMlJtWM83BZqvpdGJwv2',1,'2020-08-03 12:24:37',1,'2020-08-03 10:25:20'),(4,'','','','','',0,'2020-08-03 13:57:40',1,'2020-08-03 13:57:40'),(5,'efs','fds','fsd','florian@gmail.com','$2y$10$LLE5rQ4rFAVrA284v6bTIOv0mb7kd9UbIqVRQeZFe5fBfvtuBcSvm',0,'2020-08-10 08:52:30',1,'2020-08-10 08:52:30');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `user_BEFORE_INSERT` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
	SET NEW.creation_date := SYSDATE();
    SET NEW.modification_date := NEW.creation_date;
    SET NEW.active := 0;
    SET NEW.type := 1;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `user_BEFORE_UPDATE` BEFORE UPDATE ON `user` FOR EACH ROW BEGIN
	SET NEW.creation_date := OLD.creation_date;
    SET NEW.modification_date := SYSDATE();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping events for database 'blog'
--

--
-- Dumping routines for database 'blog'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-10 13:12:30
