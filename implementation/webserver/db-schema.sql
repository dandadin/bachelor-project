/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

CREATE DATABASE iothome;
USE iothome;
DROP TABLE IF EXISTS `channels`;
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


DROP TABLE IF EXISTS `collection_devices`;
CREATE TABLE `collection_devices` (
  `coll_id` int NOT NULL,
  `device_id` int NOT NULL,
  PRIMARY KEY (`coll_id`,`device_id`),
  KEY `device_id` (`device_id`),
  CONSTRAINT `collection_devices_ibfk_1` FOREIGN KEY (`coll_id`) REFERENCES `collections` (`id`),
  CONSTRAINT `collection_devices_ibfk_2` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `collection_users`;
CREATE TABLE `collection_users` (
  `coll_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`coll_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `collection_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `collection_users_ibfk_2` FOREIGN KEY (`coll_id`) REFERENCES `collections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `collections`;
CREATE TABLE `collections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL,
  `domain_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domain_id` (`domain_id`),
  CONSTRAINT `collections_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `domains` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `devices`;
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


DROP TABLE IF EXISTS `domain_users`;
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


DROP TABLE IF EXISTS `domains`;
CREATE TABLE `domains` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `gateways`;
CREATE TABLE `gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `address` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `instances`;
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


DROP TABLE IF EXISTS `plans`;
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


DROP TABLE IF EXISTS `roles`;
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


DROP TABLE IF EXISTS `sequences`;
CREATE TABLE `sequences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `sequences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `steps`;
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


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` char(32) NOT NULL,
  `pwdhash` char(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_uniq` (`login`),
  UNIQUE KEY `id_uniq` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
