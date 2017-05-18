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
  `user_name` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_profilepic` varchar(500) NOT NULL,
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
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `comment_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `fk_commentsVideoId` (`video_id`),
  KEY `fk_commentsUserId` (`user_id`),
  CONSTRAINT `fk_commentsUserId` FOREIGN KEY (`user_id`) REFERENCES `GUser` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_commentsVideoId` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
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
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  KEY `fk_dislikedVideosVideoId` (`video_id`),
  KEY `fk_dislikedVideosUserId` (`user_id`),
  CONSTRAINT `fk_dislikedVideosUserId` FOREIGN KEY (`user_id`) REFERENCES `GUser` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_dislikedVideosVideoId` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disliked_videos`
--

LOCK TABLES `disliked_videos` WRITE;
/*!40000 ALTER TABLE `disliked_videos` DISABLE KEYS */;
INSERT INTO `disliked_videos` VALUES (1,9),(1,3);
/*!40000 ALTER TABLE `disliked_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `watch_time` datetime DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_historyUserId` (`user_id`),
  KEY `fk_historyVideoId` (`video_id`),
  CONSTRAINT `fk_historyUserId` FOREIGN KEY (`user_id`) REFERENCES `GUser` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_historyVideoId` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,2,'2017-05-15 00:17:00'),(1,3,'2017-05-15 09:59:47'),(1,9,'2017-05-17 14:33:21'),(1,10,'2017-05-17 21:52:39');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liked_videos`
--

DROP TABLE IF EXISTS `liked_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liked_videos` (
  `user_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  KEY `fk_likedVideosVideoId` (`video_id`),
  KEY `fk_likedVideosUserId` (`user_id`),
  CONSTRAINT `fk_likedVideosUserId` FOREIGN KEY (`user_id`) REFERENCES `GUser` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_likedVideosVideoId` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`) ON DELETE CASCADE
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
  `video_name` varchar(1000) NOT NULL,
  `video_path` varchar(1000) NOT NULL,
  `videothumbnail_path` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL,
  `likes` int(11) DEFAULT '0',
  `dislikes` int(11) DEFAULT '0',
  `upload_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) DEFAULT '0',
  `video_description` varchar(2000) DEFAULT NULL,
  `video_size` float NOT NULL,
  PRIMARY KEY (`video_id`),
  KEY `fk_videosUserId` (`user_id`),
  CONSTRAINT `fk_videosUserId` FOREIGN KEY (`user_id`) REFERENCES `GUser` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (2,'Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B','\'Videos/Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B.mp4\'','\'Thumbnails/Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B.jpg\'',2,38,4,'2017-05-15 00:06:03',5,'Baarish - Lyrical - Half Girlfriend - Arjun K & Shraddha K - Ash King & Shashaa Tirupati - Tanishk B',21.6),(3,'Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series','\'Videos/Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series.mp4\'','\'Thumbnails/Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series.jpg\'',1,3,1,'2017-05-15 00:06:15',1,'Itna Tumhe Full Audio Song _ Yaseer Desai & Shashaa Tirupati _ Abbas-Mustan _ T-Series',10.2),(9,'John Legend - Vevo Go Shows- All Of Me','\'Videos/John Legend - Vevo Go Shows- All Of Me.mp4\'','\'Thumbnails/John Legend - Vevo Go Shows- All Of Me.jpg\'',1,0,0,'2017-05-16 17:33:56',1,'John Legend - Vevo Go Shows- All Of Me',19.0587),(10,'Katy Perry - Roar (Official)','\'Videos/Katy Perry - Roar (Official).mp4\'','\'Thumbnails/Katy Perry - Roar (Official).jpg\'',1,0,0,'2017-05-16 21:26:21',1,'Katy Perry - Roar (Official)',24.1602);
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

-- Dump completed on 2017-05-18 10:56:56
