# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.4-m14-log)
# Database: qx
# Generation Time: 2020-07-06 17:23:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table qx_active
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_active`;

CREATE TABLE `qx_active` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `service_type_id` int(11) DEFAULT '0',
  `service_time` varchar(11) DEFAULT NULL,
  `active_start_time` int(11) DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  `place_latitude` varchar(255) DEFAULT NULL,
  `place_longitude` varchar(255) DEFAULT NULL,
  `place_address` varchar(255) DEFAULT NULL,
  `place_name` varchar(255) DEFAULT NULL,
  `create_time` int(20) DEFAULT NULL,
  `modify_time` int(20) DEFAULT NULL,
  `modify_num` int(1) DEFAULT '0',
  `add_user_id` int(11) DEFAULT NULL,
  `active_end_time` int(11) DEFAULT '0',
  `recruit_start_time` int(11) DEFAULT '0',
  `recruit_end_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_active` WRITE;
/*!40000 ALTER TABLE `qx_active` DISABLE KEYS */;

INSERT INTO `qx_active` (`id`, `title`, `service_type_id`, `service_time`, `active_start_time`, `address`, `info`, `user`, `tel`, `place_latitude`, `place_longitude`, `place_address`, `place_name`, `create_time`, `modify_time`, `modify_num`, `add_user_id`, `active_end_time`, `recruit_start_time`, `recruit_end_time`)
VALUES
	(1,'dddd',1,'1',NULL,'vfg','de','23','3434','39.74788','116.14294','北京市房山区政通路','良乡北京市房山区人民政府(政通路北)',1594013028,NULL,0,1,NULL,NULL,0),
	(2,'wer',1,'1',1594014540,'wer','wer','wer','wer','','','','',1594015008,NULL,0,1,NULL,NULL,0),
	(3,'sdfwew',1,'1',1594015800,'wew','3erw','we','werwer','39.74788','116.14294','北京市房山区政通路','良乡北京市房山区人民政府(政通路北)',1594015859,NULL,0,1,NULL,NULL,0),
	(4,'werw',1,'1',1594040160,'','','wer','1213123','','','','',1594040223,NULL,0,2,1594126560,1594040160,1594212960),
	(5,'werwe',1,'1.5',1594040400,'dsfwe','','wer','123312','39.74788','116.14294','北京市房山区政通路','良乡北京市房山区人民政府(政通路北)',1594040462,NULL,0,2,1594126800,1594040400,1594299600);

/*!40000 ALTER TABLE `qx_active` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_admin`;

CREATE TABLE `qx_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `level` int(1) DEFAULT '0',
  `create_time` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_admin` WRITE;
/*!40000 ALTER TABLE `qx_admin` DISABLE KEYS */;

INSERT INTO `qx_admin` (`id`, `username`, `password`, `level`, `create_time`, `team_id`)
VALUES
	(1,'admin','b6377f4d74156322db20301c13e846a3',0,NULL,0),
	(2,'张某某','b6377f4d74156322db20301c13e846a3',3,1593793275,9);

/*!40000 ALTER TABLE `qx_admin` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_log`;

CREATE TABLE `qx_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_log` WRITE;
/*!40000 ALTER TABLE `qx_log` DISABLE KEYS */;

INSERT INTO `qx_log` (`id`, `user_id`, `create_time`, `content`)
VALUES
	(1,NULL,1592749116,'admin[退出]'),
	(2,NULL,1592749124,'[登录]'),
	(3,NULL,1592749323,'admin[团队管理 修改-test12]'),
	(4,NULL,1592749465,'admin[团队管理 添加-test3]'),
	(5,NULL,1592749474,'admin[团队管理 删除-test3]'),
	(6,NULL,1594022763,'[我的成员 [张某某] 删除 []]'),
	(7,NULL,1594022766,'[我的成员 [张某某] 删除 []]'),
	(8,NULL,1594022768,'[我的成员 [张某某] 删除 []]'),
	(9,NULL,1594022770,'[我的成员 [张某某] 删除 []]'),
	(10,NULL,1594022772,'[我的成员 [张某某] 删除 []]'),
	(11,NULL,1594023022,'[我的成员 [张某某] 删除 []]'),
	(12,NULL,1594023030,'[我的成员 [张某某] 删除 []]'),
	(13,NULL,1594023058,'[我的成员 [张某某] 删除 []]'),
	(14,NULL,1594023248,'[我的成员 [张某某] 删除 []]'),
	(15,NULL,1594023251,'[我的成员 [张某某] 删除 []]'),
	(16,NULL,1594023255,'[我的成员 [张某某] 删除 []]'),
	(17,NULL,1594023345,'[我的成员 [张某某] 删除 []]'),
	(18,NULL,1594023438,'[我的成员 [张某某] 删除 []]'),
	(19,NULL,1594024048,'[我的成员 [张某某] 删除 []]');

/*!40000 ALTER TABLE `qx_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_team
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_team`;

CREATE TABLE `qx_team` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `is_team` int(1) DEFAULT '0' COMMENT '是否是团体',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_team` WRITE;
/*!40000 ALTER TABLE `qx_team` DISABLE KEYS */;

INSERT INTO `qx_team` (`id`, `name`, `pid`, `sort`, `level`, `is_team`)
VALUES
	(1,'机关',0,0,1,0),
	(2,'纪委监委',1,0,2,0),
	(3,'区委办',1,0,2,0),
	(4,'组织部',1,0,2,0),
	(5,'宣传部',1,0,2,0),
	(6,'社科联',1,0,2,0),
	(7,'统战部',1,0,2,0),
	(8,'政法委',1,0,2,0),
	(9,'网络安全和信息化委员会办公室',1,0,2,0),
	(10,'编委办',1,0,2,0),
	(11,'区直机关工委',1,0,2,0),
	(12,'巡察办',1,0,2,0),
	(13,'信访局',1,0,2,0),
	(14,'老干部局',1,0,2,0),
	(15,'督查办公室',1,0,2,0),
	(16,'党校',1,0,2,0),
	(17,'档案馆',1,0,2,0),
	(18,'国教办',1,0,2,0),
	(19,'总工会',1,0,2,0),
	(20,'团委',1,0,2,0),
	(21,'妇联',1,0,2,0),
	(22,'文联',1,0,2,0),
	(23,'工商联',1,0,2,0),
	(24,'残联',1,0,2,0),
	(25,'人大办公室',1,0,2,0),
	(26,'政协办公室',1,0,2,0),
	(27,'法院',1,0,2,0),
	(28,'检察院',1,0,2,0),
	(29,'政府办',1,0,2,0),
	(30,'发展和改革局',1,0,2,0),
	(31,'教育体育和科学技术局',1,0,2,0),
	(32,'工信局',1,0,2,0),
	(33,'民政局',1,0,2,0),
	(34,'司法局',1,0,2,0),
	(35,'财政局',1,0,2,0),
	(36,'人社局',1,0,2,0),
	(37,'住房和城乡建设局',1,0,2,0),
	(38,'城市管理综合行政执法局',1,0,2,0),
	(39,'团体',0,0,1,1),
	(40,'第一中学志愿服务团队',39,0,2,0),
	(41,'第四中学服务队',39,0,2,0),
	(42,'市职教中心志愿者队',39,0,2,0),
	(43,'正博高中志愿服务队',39,0,2,0),
	(44,'大境门街道暖阳志愿者服务队',39,0,2,0),
	(45,'南营坊青扬志愿服务队',39,0,2,0),
	(46,'赐儿山社区乐民之家志愿服务队',39,0,2,0),
	(47,'西沟社区暖阳志愿者服务队',39,0,2,0),
	(48,'西山底社区暖阳志愿者服务队',39,0,2,0),
	(49,'河北北方学院附属第一医院志愿服务队',39,0,2,0),
	(50,'华新园社区团体服务队',39,0,2,0),
	(51,'二中志愿服务队',39,0,2,0),
	(52,'尚峰购物广场志愿服务队',39,0,2,0),
	(53,'普法宣传志愿服务队',39,0,2,0),
	(54,'环境卫生管理处志愿服务队',39,0,2,0),
	(55,'第一医院志愿服务队',39,0,2,0),
	(56,'助残志愿者团体',39,0,2,0),
	(57,'巾帼志愿者服务队',39,0,2,0),
	(58,'学校',0,0,1,0),
	(59,'第九中学',58,0,2,0),
	(60,'第十六中学',58,0,2,0),
	(61,'第十九中学',58,0,2,0),
	(62,'第二十中学',58,0,2,0),
	(63,'东窑子中学',58,0,2,0),
	(64,'大境门小学',58,0,2,0),
	(65,'逸夫回族小学',58,0,2,0),
	(66,'蒙古营小学',58,0,2,0),
	(67,'下东营小学',58,0,2,0),
	(68,'明德路小学',58,0,2,0),
	(69,'新华小学',58,0,2,0),
	(70,'书院巷小学',58,0,2,0),
	(71,'长青路小学',58,0,2,0),
	(72,'通顺街小学',58,0,2,0),
	(73,'西豁子小学',58,0,2,0),
	(74,'南菜园小学',58,0,2,0),
	(75,'清河路小学',58,0,2,0),
	(76,'北新村小学',58,0,2,0),
	(77,'东窑子小学',58,0,2,0),
	(78,'南天门小学',58,0,2,0),
	(79,'永丰堡小学',58,0,2,0),
	(80,'苏家桥小学',58,0,2,0),
	(81,'桥西幼儿园',58,0,2,0),
	(82,'民族幼儿园',58,0,2,0),
	(83,'双语幼儿园',58,0,2,0),
	(84,'东窑幼儿园',58,0,2,0),
	(85,'镇街',0,0,1,0),
	(86,'大境门街道',85,0,2,0),
	(87,'明德北街道',85,0,2,0),
	(88,'明德南街道',85,0,2,0),
	(89,'新华街街道',85,0,2,0),
	(90,'堡子里街道',85,0,2,0),
	(91,'南营坊街道',85,0,2,0),
	(92,'工人新村街道',85,0,2,0),
	(93,'东窑子镇',85,0,2,0),
	(94,'外东窑村',85,0,2,0),
	(95,'东湾子村',85,0,2,0),
	(96,'孤石村',85,0,2,0),
	(97,'虎头梁村',85,0,2,0),
	(98,'瓦盆窑村',85,0,2,0),
	(99,'永丰堡村',85,0,2,0),
	(100,'五墩村',85,0,2,0),
	(101,'翠屏庵村',85,0,2,0),
	(102,'马家梁村',85,0,2,0),
	(103,'南茶坊村',85,0,2,0),
	(104,'石匠窑村',85,0,2,0),
	(105,'元宝山村',85,0,2,0),
	(106,'四岔村',85,0,2,0),
	(107,'稍道沟村',85,0,2,0),
	(108,'南天门村',85,0,2,0),
	(109,'菜市村',85,0,2,0),
	(110,'清河村',85,0,2,0),
	(111,'红旗营村',85,0,2,0),
	(112,'土井子村',85,0,2,0),
	(113,'苏家桥村',85,0,2,0),
	(114,'西山底社区',86,0,3,0),
	(115,'黄土场社区',86,0,3,0),
	(116,'西沟社区',86,0,3,0),
	(117,'西岔社区',86,0,3,0),
	(118,'平门路社区',86,0,3,0),
	(119,'沁馨苑社区',86,0,3,0),
	(120,'附属医院社区',87,0,3,0),
	(121,'蒙古营社区',87,0,3,0),
	(122,'西沙河社区',87,0,3,0),
	(123,'中学街社区',87,0,3,0),
	(124,'营城子社区',87,0,3,0),
	(125,'清河园社区',87,0,3,0),
	(126,'长青路社区',88,0,3,0),
	(127,'永丰街社区',88,0,3,0),
	(128,'白山南社区',88,0,3,0),
	(129,'白山北社区',88,0,3,0),
	(130,'元台子社区',88,0,3,0),
	(131,'金鼎社区',89,0,3,0),
	(132,'华新园社区',89,0,3,0),
	(133,'南瓦一社区',89,0,3,0),
	(134,'南瓦二社区',89,0,3,0),
	(135,'北瓦社区',89,0,3,0),
	(136,'新华街社区',89,0,3,0),
	(137,'西豁子社区',89,0,3,0),
	(138,'新华苑社区',89,0,3,0),
	(139,'赐儿山社区',89,0,3,0),
	(140,'鼓楼西社区',90,0,3,0),
	(141,'武城街社区',90,0,3,0),
	(142,'北关街社区',90,0,3,0),
	(143,'南城壕社区',90,0,3,0),
	(144,'教场坡社区',91,0,3,0),
	(145,'天宝南苑社区',91,0,3,0),
	(146,'南茶坊社区',91,0,3,0),
	(147,'西坝岗社区',91,0,3,0),
	(148,'建设桥社区',91,0,3,0),
	(149,'宏景嘉苑社区',91,0,3,0),
	(150,'南新村社区',92,0,3,0),
	(151,'北新村社区',92,0,3,0),
	(152,'新村南路社区',92,0,3,0),
	(153,'印台沟社区',92,0,3,0),
	(157,'test12',0,8,1,0),
	(158,'test1-121',157,0,2,0);

/*!40000 ALTER TABLE `qx_team` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_user`;

CREATE TABLE `qx_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `real_name` varchar(255) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `sex` int(1) DEFAULT '0',
  `tel` varchar(20) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `pol_cou` varchar(255) DEFAULT NULL COMMENT '政治面貌',
  `hight_edu` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `comm_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_user` WRITE;
/*!40000 ALTER TABLE `qx_user` DISABLE KEYS */;

INSERT INTO `qx_user` (`id`, `real_name`, `id_number`, `sex`, `tel`, `team_id`, `pol_cou`, `hight_edu`, `area`, `address`, `create_time`, `openid`, `comm_id`)
VALUES
	(3,'李某某','110111198408052012',0,'13810761824',9,'中国共产党党员','博士研究生','桥东区','sfdsdf',1593450637,'1',40),
	(5,'www','110111198405201203',0,'13810761824',9,'中国国民党革命委员会会员','技工学校','经济技术开发区','sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd',1593703339,'o1EqstzMtNwbKZUfl0hbcs-q17Ps',9);

/*!40000 ALTER TABLE `qx_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
