-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: docker
-- ------------------------------------------------------
-- Server version	5.7.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_is_edited` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `Comments_comment_id_uindex` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comments`
--

/*!40000 ALTER TABLE `Comments` DISABLE KEYS */;
INSERT INTO `Comments` (`comment_id`, `photo_id`, `user_id`, `text`, `created_at`, `comment_is_edited`) VALUES (1,2,1,'Красота','2022-07-21 15:01:49',0),(3,2,4,'Няшка','2022-07-22 19:40:53',1),(5,6,1,'Не то','2022-07-21 15:01:49',0),(6,6,1,'ввв','2022-07-21 15:01:49',0),(15,2,5,'норм кися','2022-07-21 19:10:55',0),(19,0,0,NULL,'2022-07-22 15:12:40',0),(48,2,4,'Лесной','2022-07-22 18:35:00',0),(50,6,4,'кыся','2022-07-22 18:47:02',0),(51,6,4,'123','2022-07-22 18:53:24',0),(52,6,4,'котик123222','2022-07-22 19:02:04',1),(53,6,4,'ddd','2022-07-22 19:07:32',0),(54,6,4,'sadsadaddd','2022-07-22 19:09:17',1),(61,7,4,'','2022-07-23 07:16:51',0),(62,2,4,'sssss','2022-07-23 07:29:38',1),(63,2,4,'Привет, мир!','2022-07-23 07:40:05',1),(64,2,4,'ыфвфывыв','2022-07-23 07:54:48',0),(65,5,4,'на дереве? ','2022-07-23 08:21:15',0),(67,28,4,'что это?','2022-07-23 11:29:24',0);
/*!40000 ALTER TABLE `Comments` ENABLE KEYS */;
ALTER DATABASE `docker` CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`docker`@`%`*/ /*!50003 trigger comments_count
    after insert
    on Comments
    for each row
BEGIN
    UPDATE `Photo` SET `comments_count` = (SELECT COUNT(comment_id) FROM Comments WHERE Photo.photo_id = photo_id) WHERE photo_id = NEW.photo_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `docker` CHARACTER SET utf8mb3 COLLATE utf8_general_ci ;

--
-- Table structure for table `New_edited_comments`
--

DROP TABLE IF EXISTS `New_edited_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `New_edited_comments` (
  `new_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `parrent_comment` int(11) NOT NULL,
  UNIQUE KEY `new_edited_comment_new_comment_id_uindex` (`new_comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `New_edited_comments`
--

/*!40000 ALTER TABLE `New_edited_comments` DISABLE KEYS */;
INSERT INTO `New_edited_comments` (`new_comment_id`, `text`, `created_at`, `parrent_comment`) VALUES (1,'ddddddd','2022-07-22 16:17:32',3),(2,'ss11','2022-07-23 07:32:14',62),(3,'sssss','2022-07-23 07:35:43',62),(4,'кошачка! Привет!','2022-07-23 07:36:44',63),(5,'Кошечка! Привет!','2022-07-23 07:39:51',63),(6,'првиет мир!','2022-07-23 07:40:05',63);
/*!40000 ALTER TABLE `New_edited_comments` ENABLE KEYS */;

--
-- Table structure for table `Photo`
--

DROP TABLE IF EXISTS `Photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments_count` int(11) DEFAULT '0',
  `has_thumb` int(11) NOT NULL DEFAULT '0',
  `show_count` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0' COMMENT 'how added',
  `server_file_name` varchar(50) NOT NULL,
  UNIQUE KEY `pictures_picture_id_uindex` (`photo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo`
--

/*!40000 ALTER TABLE `Photo` DISABLE KEYS */;
INSERT INTO `Photo` (`photo_id`, `file_name`, `created_at`, `comments_count`, `has_thumb`, `show_count`, `user_id`, `server_file_name`) VALUES (2,'1.jpg','2022-07-21 18:34:49',8,1,343,4,'1.jpg'),(3,'2.jpg','2022-07-21 18:34:49',1,1,2,0,'2.jpg'),(4,'3.jpg','2022-07-21 18:34:49',0,1,6,0,'3.jpg'),(5,'4.jpg','2022-07-21 18:34:49',2,1,13,0,'4.jpg'),(6,'5.jpg','2022-07-21 18:34:49',7,1,31,0,'5.jpg'),(7,'6.jpg','2022-07-21 18:34:49',1,1,10,0,'6.jpg'),(8,'7.jpg','2022-07-21 18:34:49',NULL,1,1,0,'7.jpg'),(32,'222.jpg','2022-07-23 12:30:32',0,1,3,4,'048dd554a7db26d6064b7bac012dda9f.jpg');
/*!40000 ALTER TABLE `Photo` ENABLE KEYS */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(200) NOT NULL,
  `session_start` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `Users_email_uindex` (`email`),
  UNIQUE KEY `Users_user_id_uindex` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` (`user_id`, `email`, `created_at`, `password`, `session_start`) VALUES (1,'dd@dd.ru','2022-07-20 22:02:43','$2y$10$ZF5LBqHzOkwBXFdPkyYCYOWhVXGH.eCvYKPfSQttlawV81YaDYp2u','2022-07-20 22:02:43'),(4,'diakudza@dd.dd','2022-07-23 12:25:58','$2y$10$ATZndvYh3sXfeifqCbYZ/uuW47wwjHHC3jamO.UxM1QiZolmHDETm','2022-07-23 12:25:58'),(5,'kent@ya.ru','2022-07-21 19:10:41','$2y$10$bH3xYEdO7588DKZmC8Pgg.a9egPKZ4yltmdCItTzm5QTaox1p3wdS','2022-07-21 19:10:41');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-23 15:40:45
