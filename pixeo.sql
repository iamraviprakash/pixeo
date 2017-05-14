-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: pixeo
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `GUser`
--

DROP TABLE IF EXISTS `GUser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GUser` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT NULL,
  `user_username` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_profilepic` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GUser`
--

LOCK TABLES `GUser` WRITE;
/*!40000 ALTER TABLE `GUser` DISABLE KEYS */;
INSERT INTO `GUser` VALUES (1,'RAVI PRAKASH','ravi.p15','ravi.p15@iiits.in','https://lh6.googleusercontent.com/-QXnCVe0NvbQ/AAAAAAAAAAI/AAAAAAAAADg/FuFqyPBoHdQ/s96-c/photo.jpg'),(2,'Ravi Prakash Singh','raviprakash.prince','raviprakash.prince@gmail.com','https://lh6.googleusercontent.com/-IsY2YqhGJq0/AAAAAAAAAAI/AAAAAAAAAAA/AHalGhpKqrQkRhN34UPD7fcW-hfTG-IKVg/s96-c/photo.jpg');
/*!40000 ALTER TABLE `GUser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL,
  `comment_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disliked_videos`
--

DROP TABLE IF EXISTS `disliked_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disliked_videos` (
  `user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disliked_videos`
--

LOCK TABLES `disliked_videos` WRITE;
/*!40000 ALTER TABLE `disliked_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `disliked_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `watch_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liked_videos`
--

DROP TABLE IF EXISTS `liked_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liked_videos` (
  `user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liked_videos`
--

LOCK TABLES `liked_videos` WRITE;
/*!40000 ALTER TABLE `liked_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `liked_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `video_name` varchar(1000) DEFAULT NULL,
  `video_path` varchar(1000) DEFAULT NULL,
  `videothumbnail_path` varchar(1000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT '0',
  `dislikes` int(11) DEFAULT '0',
  `upload_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (1,'Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series','\'Videos/Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series.mp4\'','\'Thumbnails/Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series.jpeg\'',1,0,0,'2017-05-08 18:51:00',0),(2,'Ik Vaari Aa _ Raabta _ Lyrcial Song _ Sushant Singh Rajput & Kriti Sanon _ Prita','\'Videos/Ik Vaari Aa _ Raabta _ Lyrcial Song _ Sushant Singh Rajput & Kriti Sanon _ Prita.mp4\'','\'Thumbnails/Ik Vaari Aa _ Raabta _ Lyrcial Song _ Sushant Singh Rajput & Kriti Sanon _ Prita.jpg\'',1,0,0,'2017-05-08 19:54:07',0),(8,'Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B.mp4','\'Videos/Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B.mp4\'','\'Thumbnails/Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B.jpg\'',1,0,0,'2017-05-09 21:32:47',0),(9,'Katy Perry - Roar (Official).mp4','\'Videos/Katy Perry - Roar (Official).mp4\'','\'Thumbnails/Katy Perry - Roar (Official).jpg\'',2,0,0,'2017-05-09 21:38:51',0),(10,'TRANSFORMERS 5- The Last Knight NEW TV Spot & Trailer (2017).mp4','\'Videos/TRANSFORMERS 5- The Last Knight NEW TV Spot & Trailer (2017).mp4\'','\'Thumbnails/TRANSFORMERS 5- The Last Knight NEW TV Spot & Trailer (2017).jpg\'',1,0,0,'2017-05-10 08:22:41',0);
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-10 17:04:18
