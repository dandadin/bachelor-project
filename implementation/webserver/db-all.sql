CREATE DATABASE iothome;

-- MariaDB dump 10.19  Distrib 10.5.23-MariaDB, for Linux (x86_64)
--
-- Host: iothome.cz    Database: iothome
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `device_id` int NOT NULL,
  `comm_type` int NOT NULL,
  `value_type` int NOT NULL,
  `update_freq` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_id` (`device_id`),
  CONSTRAINT `channels_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES (57,'Vypinani',35,3,1,100),(58,'Barva',35,3,3,100),(59,'Zapinani',36,3,1,100),(60,'Barva',36,3,3,100),(61,'Vypinani',37,3,1,100),(62,'Barva',37,3,3,100),(63,'Zapinani',38,3,1,100),(64,'Barva',38,3,3,100);
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection_devices`
--

DROP TABLE IF EXISTS `collection_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection_devices` (
  `coll_id` int NOT NULL,
  `device_id` int NOT NULL,
  PRIMARY KEY (`coll_id`,`device_id`),
  KEY `device_id` (`device_id`),
  CONSTRAINT `collection_devices_ibfk_1` FOREIGN KEY (`coll_id`) REFERENCES `collections` (`id`),
  CONSTRAINT `collection_devices_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_devices`
--

LOCK TABLES `collection_devices` WRITE;
/*!40000 ALTER TABLE `collection_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `collection_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collection_users`
--

DROP TABLE IF EXISTS `collection_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collection_users` (
  `coll_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`coll_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `collection_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `collection_users_ibfk_2` FOREIGN KEY (`coll_id`) REFERENCES `collections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collection_users`
--

LOCK TABLES `collection_users` WRITE;
/*!40000 ALTER TABLE `collection_users` DISABLE KEYS */;
INSERT INTO `collection_users` VALUES (1,1),(2,1),(3,1),(1,2),(2,2),(1,4);
/*!40000 ALTER TABLE `collection_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL,
  `domain_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domain_id` (`domain_id`),
  CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collections`
--

LOCK TABLES `collections` WRITE;
/*!40000 ALTER TABLE `collections` DISABLE KEYS */;
INSERT INTO `collections` VALUES (1,'Skupina 1',1),(2,'Skupina 2',1),(3,'Skupina 3',1);
/*!40000 ALTER TABLE `collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `location` char(64) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gateway_id` int NOT NULL,
  `domain_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gateway_id` (`gateway_id`),
  KEY `devices_ibfk_2` (`domain_id`),
  CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`gateway_id`) REFERENCES `gateways` (`id`),
  CONSTRAINT `devices_ibfk_2` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (35,'automaticke zarizeni 2','Misin pokoj','2024-03-29 20:40:06','2024-04-07 22:11:08',3,2),(36,'automaticke zarizenicko malickate','Danuv pokoj','2024-03-29 20:48:22','2024-03-29 20:50:01',4,2),(37,'automaticke zarizeni 2','Misin pokoj','2024-03-29 20:48:22','2024-03-29 20:50:01',4,1),(38,'automaticke','Danuv pokoj','2024-03-29 20:50:07','2024-04-07 22:11:08',3,1);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domain_users`
--

DROP TABLE IF EXISTS `domain_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domain_users` (
  `domain_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  PRIMARY KEY (`domain_id`,`user_id`,`role_id`),
  KEY `user_id` (`user_id`),
  KEY `domain_users_ibfk_1` (`role_id`),
  CONSTRAINT `domain_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `domain_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domain_users`
--

LOCK TABLES `domain_users` WRITE;
/*!40000 ALTER TABLE `domain_users` DISABLE KEYS */;
INSERT INTO `domain_users` VALUES (0,2,6),(1,2,1),(1,2,2),(2,2,1),(2,2,2),(1,4,1),(1,4,2),(2,4,5),(1,39,3),(2,39,3);
/*!40000 ALTER TABLE `domain_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domains`
--

LOCK TABLES `domains` WRITE;
/*!40000 ALTER TABLE `domains` DISABLE KEYS */;
INSERT INTO `domains` VALUES (1,'Firma 11'),(2,'Firma 2'),(4,'Domain 3');
/*!40000 ALTER TABLE `domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gateways`
--

DROP TABLE IF EXISTS `gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `address` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateways`
--

LOCK TABLES `gateways` WRITE;
/*!40000 ALTER TABLE `gateways` DISABLE KEYS */;
INSERT INTO `gateways` VALUES (1,'GW 1','192.168.1.2'),(2,'GW 2','gw.google.com:12345'),(3,'pokus','A1:B2:C3'),(4,'pokusik','A1:B2:C3:D4'),(5,'danda','http://dandadin.eu/personal');
/*!40000 ALTER TABLE `gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instances`
--

DROP TABLE IF EXISTS `instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances` (
  `id` int NOT NULL AUTO_INCREMENT,
  `seq_id` int NOT NULL,
  `step_id` int NOT NULL,
  `step_ts` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instances_ibfk_1` (`seq_id`),
  KEY `instances_ibfk_2` (`step_id`),
  CONSTRAINT `instances_ibfk_1` FOREIGN KEY (`seq_id`) REFERENCES `sequences` (`id`),
  CONSTRAINT `instances_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instances`
--

LOCK TABLES `instances` WRITE;
/*!40000 ALTER TABLE `instances` DISABLE KEYS */;
INSERT INTO `instances` VALUES (11,5,2,'2037-12-19 06:06:37'),(13,5,2,'2037-12-19 06:15:07');
/*!40000 ALTER TABLE `instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `seq_id` int NOT NULL,
  `period` int DEFAULT '0',
  `offset` int DEFAULT '0',
  `last_ts` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plans_ibfk_1` (`seq_id`),
  CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`seq_id`) REFERENCES `sequences` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `can_edit_colls` tinyint(1) DEFAULT '0',
  `can_edit_users` tinyint(1) DEFAULT '0',
  `can_edit_devices` tinyint(1) DEFAULT '0',
  `can_edit_gateways` tinyint(1) DEFAULT '0',
  `can_edit_all` tinyint(1) DEFAULT '0',
  `can_list_colls` tinyint(1) DEFAULT '0',
  `can_list_users` tinyint(1) DEFAULT '0',
  `can_list_devices` tinyint(1) DEFAULT '0',
  `can_list_gateways` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin',1,1,1,1,0,1,1,1,1),(2,'local',1,1,1,1,0,1,1,1,1),(3,'user',0,0,0,0,0,1,1,1,1),(5,'nuzak',0,0,0,0,0,0,0,0,0),(6,'developer',0,0,0,0,1,0,0,0,0);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sequences`
--

DROP TABLE IF EXISTS `sequences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sequences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sequences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sequences`
--

LOCK TABLES `sequences` WRITE;
/*!40000 ALTER TABLE `sequences` DISABLE KEYS */;
INSERT INTO `sequences` VALUES (5,'sequence',4),(6,'seq',4),(10,'test',4),(11,'tst teq',4),(12,'testovaci',4);
/*!40000 ALTER TABLE `sequences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idx` int NOT NULL,
  `seq_id` int NOT NULL,
  `channel_id` int NOT NULL,
  `value` char(128) NOT NULL,
  `delay_before` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `steps_ibfk_1` (`seq_id`),
  KEY `steps_ibfk_2` (`channel_id`),
  CONSTRAINT `steps_ibfk_1` FOREIGN KEY (`seq_id`) REFERENCES `sequences` (`id`),
  CONSTRAINT `steps_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channels` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (1,1,5,57,'offfffffff',4),(2,2,5,57,'stop',1000),(6,1,10,57,'1sgsb',22),(7,1,11,57,'avadv',11),(8,1,12,57,'value1',60),(9,2,12,57,'value2',60),(10,3,12,57,'value3',60);
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` char(32) NOT NULL,
  `pwdhash` char(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_uniq` (`login`),
  UNIQUE KEY `id_uniq` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1111','6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'),(2,'admin','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918'),(4,'test','9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08'),(39,'karel','973607a4ae7b4cf7d96a100b0fb07e8519cc4f70441d41214a9f811577bb06cc');
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

-- Dump completed on 2024-05-16 18:05:56
