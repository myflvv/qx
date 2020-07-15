# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.4-m14-log)
# Database: qx
# Generation Time: 2020-07-15 16:43:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table qx_report_pic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_report_pic`;

CREATE TABLE `qx_report_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `active_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_report_pic` WRITE;
/*!40000 ALTER TABLE `qx_report_pic` DISABLE KEYS */;

INSERT INTO `qx_report_pic` (`id`, `report_id`, `path`, `active_id`)
VALUES
	(11,1,'20200714/7fc555040abfa1ffe18bae945c4670ad.png',7),
	(12,1,'20200714/0e2344c7bcdd13db4dbf1d642f96df02.png',7),
	(13,NULL,'20200716/6f7b4081903c4711a7b9141759c86762.jpg',10),
	(14,NULL,'20200716/8dc8c304c7d2ff78f9d9805386fa6525.jpg',10),
	(15,NULL,'20200716/120206c1e29f2abe7523af9b97c10580.jpg',10),
	(16,NULL,'20200716/2d09c2db74ea77f7250b78abf46d5067.jpg',10);

/*!40000 ALTER TABLE `qx_report_pic` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
