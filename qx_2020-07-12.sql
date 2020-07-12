# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.4-m14-log)
# Database: qx
# Generation Time: 2020-07-12 07:51:38 +0000
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_active` WRITE;
/*!40000 ALTER TABLE `qx_active` DISABLE KEYS */;

INSERT INTO `qx_active` (`id`, `title`, `service_type_id`, `service_time`, `active_start_time`, `address`, `info`, `user`, `tel`, `place_latitude`, `place_longitude`, `place_address`, `place_name`, `create_time`, `modify_time`, `modify_num`, `add_user_id`, `active_end_time`, `recruit_start_time`, `recruit_end_time`)
VALUES
	(5,'依旧情深  依份温暖',9,'1.5',1594040400,'张家口市桥东区','','wer','123312','40.769062','114.885965','河北省张家口市桥东区长城西大街10号','张家口市人民政府',1594040462,NULL,0,2,1594126800,1594040400,1594299600),
	(6,'助学助梦 春蕾花开',8,'2',1594692000,'张家口市桥东区','','王某某','13000000000','40.769062','114.885965','河北省张家口市桥东区长城西大街10号','张家口市人民政府',1594532859,NULL,0,2,1594699200,1594519200,1594688400),
	(7,'文明交通执勤',7,'1',1594769400,'张家口市桥西区','','李某某','13000000000','40.81864','114.8841','河北省张家口市桥西区清水河中路','张家口市展览馆',1594533158,NULL,0,2,1594773000,1594510200,0),
	(8,'文化志愿服务活动',1,'1.5',1594859400,'张家口市宣化区','','赵某某','13000000000','40.608536','115.099535','河北省张家口市宣化区永安街8号','张家口市宣化区政府',1594533298,NULL,0,2,1594864800,1594686600,1594855800),
	(9,'课外实践活动',1,'2',1594945800,'张家口市怀来县','徒步清理城市垃圾、小广告','钱某某','13000000000','40.415593','115.517909','河北省张家口市怀来县府前街1号','怀来县政府',1594533426,NULL,0,2,1594953000,1594600200,1594686600),
	(10,'雷锋驿站值班',8,'1',1594665000,'张家口市桥西区','','吴某某','13000000000','40.82683','114.87181','河北省张家口市桥西区礼拜寺巷6号','张家口市第一医院',1594533676,NULL,0,2,1594668600,1594492200,0),
	(11,'文明交通指挥',7,'1.5',1594837800,'张家口市万全区','交通指挥','徐某某','13000000000','40.767030809','114.740490405','河北省张家口市万全区孔家庄镇民主东街39号','张家口市万全区人民政府',1594533788,NULL,0,2,1594843200,1594665000,0);

/*!40000 ALTER TABLE `qx_active` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_active_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_active_type`;

CREATE TABLE `qx_active_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT NULL COMMENT '1活动类型2活动时长',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_active_type` WRITE;
/*!40000 ALTER TABLE `qx_active_type` DISABLE KEYS */;

INSERT INTO `qx_active_type` (`id`, `name`, `type`)
VALUES
	(1,'文化教育',1),
	(2,'环保卫生',1),
	(7,'交通服务',1),
	(8,'关爱服务',1),
	(9,'其他',1),
	(10,'1',2),
	(11,'1.5',2),
	(12,'2',2);

/*!40000 ALTER TABLE `qx_active_type` ENABLE KEYS */;
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


# Dump of table qx_enter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_enter`;

CREATE TABLE `qx_enter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `active_id` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT '0',
  `start_dk_time` int(11) DEFAULT '0' COMMENT '打卡时间',
  `start_dk_place` text COMMENT '打卡地点json',
  `end_dk_time` int(11) DEFAULT '0',
  `end_dk_place` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_enter` WRITE;
/*!40000 ALTER TABLE `qx_enter` DISABLE KEYS */;

INSERT INTO `qx_enter` (`id`, `user_id`, `active_id`, `create_time`, `start_dk_time`, `start_dk_place`, `end_dk_time`, `end_dk_place`)
VALUES
	(1,7,6,0,0,NULL,0,NULL),
	(2,7,7,0,0,NULL,0,NULL);

/*!40000 ALTER TABLE `qx_enter` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_filter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_filter`;

CREATE TABLE `qx_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_filter` WRITE;
/*!40000 ALTER TABLE `qx_filter` DISABLE KEYS */;

INSERT INTO `qx_filter` (`id`, `keywords`, `update_time`)
VALUES
	(1,'121,we',1594353047);

/*!40000 ALTER TABLE `qx_filter` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;



# Dump of table qx_team
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_team`;

CREATE TABLE `qx_team` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `is_team` int(1) DEFAULT '0' COMMENT '1团体2社区',
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
	(86,'大境门街道',85,0,2,2),
	(87,'明德北街道',85,0,2,2),
	(88,'明德南街道',85,0,2,2),
	(89,'新华街街道',85,0,2,2),
	(90,'堡子里街道',85,0,2,2),
	(91,'南营坊街道',85,0,2,2),
	(92,'工人新村街道',85,0,2,2),
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
	(153,'印台沟社区',92,0,3,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_user` WRITE;
/*!40000 ALTER TABLE `qx_user` DISABLE KEYS */;

INSERT INTO `qx_user` (`id`, `real_name`, `id_number`, `sex`, `tel`, `team_id`, `pol_cou`, `hight_edu`, `area`, `address`, `create_time`, `openid`, `comm_id`)
VALUES
	(3,'李某某','110111198408052012',0,'13810761824',9,'中国共产党党员','博士研究生','桥东区','sfdsdf',1593450637,'1',40),
	(7,'张大禹','110111854210021212',0,'13810761824',9,'中国共产党党员','博士研究生','桥西区','北京市某某区',1594396995,'oz7m25Lbbgt6zqlOg08249Q6OWpQ',40),
	(5,'www','110111198405201203',0,'13810761824',9,'中国国民党革命委员会会员','技工学校','经济技术开发区','sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd',1593703339,'o1EqstzMtNwbKZUfl0hbcs-q17Ps',9);

/*!40000 ALTER TABLE `qx_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
