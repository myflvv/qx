# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.4-m14-log)
# Database: qx
# Generation Time: 2020-07-31 17:22:32 +0000
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_active` WRITE;
/*!40000 ALTER TABLE `qx_active` DISABLE KEYS */;

INSERT INTO `qx_active` (`id`, `title`, `service_type_id`, `service_time`, `active_start_time`, `address`, `info`, `user`, `tel`, `place_latitude`, `place_longitude`, `place_address`, `place_name`, `create_time`, `modify_time`, `modify_num`, `add_user_id`, `active_end_time`, `recruit_start_time`, `recruit_end_time`)
VALUES
	(13,'test313',2,'1.5',1595132700,'dsfgw2','v vvvdfsd','test3','3423','40.768958698','114.887492349','河北省张家口市桥东区和谐东路','通泰写字城停车场-入口',1594787297,NULL,0,2,1595136300,1594873500,1595046300),
	(12,'test12',2,'1',1594870500,'testwww','t2w','rtest','1231','40.502560854','115.287100427','河北省张家口市下花园区府前街1号','张家口市下花园区人民政府',1594784342,NULL,0,2,1594874100,1594784100,0),
	(5,'依旧情深  依份温暖',9,'1.5',1594040400,'张家口市桥东区','','wer','123312','40.769062','114.885965','河北省张家口市桥东区长城西大街10号','张家口市人民政府',1594040462,NULL,0,2,1594126800,1594040400,1594299600),
	(6,'助学助梦 春蕾花开',8,'2',1594738644,'张家口市桥东区','','王某某','13000000000','40.769062','114.885965','河北省张家口市桥东区长城西大街10号','张家口市人民政府',1594532859,NULL,0,2,1594738644,1594519200,1594688400),
	(7,'文明交通执勤',7,'1',1594769400,'张家口市桥西区','','李某某1','13000000001','40.81864','114.8841','河北省张家口市桥西区清水河中路','张家口市展览馆',1594783412,NULL,0,2,1594773000,1594510200,0),
	(8,'文化志愿服务活动',1,'2',1594859400,'张家口市宣化区','test','赵某某1','13000000002','40.608536','115.099535','河北省张家口市宣化区永安街8号','张家口市宣化区政府',1594783768,NULL,0,2,1594873680,1594686600,0),
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
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_admin` WRITE;
/*!40000 ALTER TABLE `qx_admin` DISABLE KEYS */;

INSERT INTO `qx_admin` (`id`, `username`, `password`, `level`, `create_time`, `team_id`, `update_time`)
VALUES
	(1,'admin','b6377f4d74156322db20301c13e846a3',0,NULL,0,1596213197),
	(2,'张某某','b6377f4d74156322db20301c13e846a3',3,1593793275,118,1596212806);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_enter` WRITE;
/*!40000 ALTER TABLE `qx_enter` DISABLE KEYS */;

INSERT INTO `qx_enter` (`id`, `user_id`, `active_id`, `create_time`, `start_dk_time`, `start_dk_place`, `end_dk_time`, `end_dk_place`)
VALUES
	(1,11,8,0,1594738680,'{\"latitude\":39.74788,\"longitude\":116.14294,\"address\":\"\\u826f\\u4e61\\u5317\\u4eac\\u5e02\\u623f\\u5c71\\u533a\\u4eba\\u6c11\\u653f\\u5e9c(\\u653f\\u901a\\u8def\\u5317)\"}',1594738683,'{\"latitude\":39.74788,\"longitude\":116.14294,\"address\":\"\\u826f\\u4e61\\u5317\\u4eac\\u5e02\\u623f\\u5c71\\u533a\\u4eba\\u6c11\\u653f\\u5e9c(\\u653f\\u901a\\u8def\\u5317)\"}'),
	(4,7,8,0,0,NULL,0,NULL),
	(5,7,8,0,0,NULL,0,NULL);

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
	(1,'test1,test2',1596213413);

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
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_log` WRITE;
/*!40000 ALTER TABLE `qx_log` DISABLE KEYS */;

INSERT INTO `qx_log` (`id`, `user_id`, `create_time`, `content`)
VALUES
	(48,NULL,1595865797,'admin[修改活动 test313]'),
	(47,NULL,1595779350,'admin[AdminID1推荐 首页幻灯片[]]'),
	(46,NULL,1595779333,'admin[AdminID1删除 首页幻灯片[文明交通执勤-报告]]'),
	(45,NULL,1595779071,'admin[AdminID1推荐 首页幻灯片[]]'),
	(44,NULL,1595779055,'admin[AdminID1 添加活动报告 ID7]'),
	(43,NULL,1595778701,'admin[AdminID1推荐 首页幻灯片[]]'),
	(42,NULL,1595778679,'admin[AdminID1删除 首页幻灯片[文化志愿服务活动]]'),
	(41,NULL,1595778633,'admin[AdminID1推荐 首页幻灯片[]]'),
	(40,NULL,1595778610,'admin[AdminID1推荐 首页幻灯片[]]'),
	(39,NULL,1595778577,'admin[AdminID1删除 首页幻灯片[test3-报告]]'),
	(38,NULL,1595778574,'admin[AdminID1删除 首页幻灯片[乌鲁木齐完成现有隔离人员核检1]]'),
	(49,NULL,1595947077,'admin[团队管理 添加-test2]'),
	(50,NULL,1595947142,'admin[团队管理 添加-test33]'),
	(51,NULL,1595947151,'admin[团队管理 删除-test33]'),
	(52,NULL,1595947158,'admin[团队管理 删除-test2]'),
	(53,NULL,1596209378,'admin[团队管理 添加-test1]'),
	(54,NULL,1596210286,'admin[团队管理 添加-test3]'),
	(55,NULL,1596210555,'admin[团队管理 添加-test2]'),
	(56,NULL,1596210584,'admin[团队管理 添加-test5]'),
	(57,NULL,1596210804,'admin[团队管理 添加-test6]'),
	(58,NULL,1596210823,'admin[团队管理 添加-test7]'),
	(59,NULL,1596211027,'admin[团队管理 添加-test8]'),
	(60,NULL,1596211045,'admin[团队管理 添加-test9]'),
	(61,NULL,1596211199,'admin[团队管理 添加-test1]'),
	(62,NULL,1596211272,'admin[团队管理 修改-test12]'),
	(63,NULL,1596211293,'admin[团队管理 添加-trade]'),
	(64,NULL,1596211301,'admin[团队管理 修改-trade1]'),
	(65,NULL,1596212585,'admin[人员管理 修改-99]'),
	(66,NULL,1596212678,'admin[人员管理 修改-99]'),
	(67,NULL,1596213167,'admin[退出]'),
	(68,NULL,1596213180,'admin[登录]'),
	(69,NULL,1596213201,'admin[退出]'),
	(70,NULL,1596213208,'admin[登录]'),
	(71,NULL,1596213224,'admin[活动管理 服务时长修改-1]'),
	(72,NULL,1596213272,'admin[活动管理 服务时长修改-1]'),
	(73,NULL,1596213620,'admin[AdminID1推荐 首页幻灯片[]]'),
	(74,NULL,1596213663,'admin[AdminID1推荐 首页幻灯片[]]'),
	(75,NULL,1596214041,'admin[AdminID1删除 首页幻灯片[乌鲁木齐完成现有隔离人员核检]]'),
	(76,NULL,1596214074,'admin[AdminID1推荐 首页幻灯片[]]'),
	(77,NULL,1596214113,'admin[AdminID1推荐 首页幻灯片[]]'),
	(78,NULL,1596214134,'admin[AdminID1推荐 首页幻灯片[]]'),
	(79,NULL,1596214145,'admin[AdminID1删除 首页幻灯片[文明交通指挥]]'),
	(80,NULL,1596214149,'admin[AdminID1删除 首页幻灯片[雷锋驿站值班]]'),
	(81,NULL,1596214155,'admin[AdminID1删除 首页幻灯片[乌鲁木齐完成现有隔离人员核检]]'),
	(82,NULL,1596214159,'admin[AdminID1删除 首页幻灯片[文明交通执勤]]'),
	(83,NULL,1596214216,'admin[AdminID1推荐 首页幻灯片[]]'),
	(84,NULL,1596214235,'admin[AdminID1推荐 首页幻灯片[]]'),
	(85,NULL,1596214370,'admin[AdminID1删除 首页幻灯片[文明交通指挥]]'),
	(86,NULL,1596214375,'admin[AdminID1删除 首页幻灯片[文明交通执勤]]'),
	(87,NULL,1596214397,'admin[AdminID1推荐 首页幻灯片[]]'),
	(88,NULL,1596214415,'admin[AdminID1推荐 首页幻灯片[]]'),
	(89,NULL,1596214447,'admin[AdminID1删除 首页幻灯片[文明交通指挥]]'),
	(90,NULL,1596215843,'admin[AdminID1推荐 首页幻灯片[]]'),
	(91,NULL,1596215856,'admin[AdminID1删除 首页幻灯片[文明交通指挥]]'),
	(92,NULL,1596215873,'admin[AdminID1推荐 首页幻灯片[]]'),
	(93,NULL,1596215905,'admin[AdminID1推荐 首页幻灯片[]]'),
	(94,NULL,1596215919,'admin[AdminID1删除 首页幻灯片[雷锋驿站值班]]'),
	(95,NULL,1596215923,'admin[AdminID1删除 首页幻灯片[文明交通指挥]]'),
	(96,NULL,1596215926,'admin[AdminID1删除 首页幻灯片[文明交通执勤]]'),
	(97,NULL,1596215968,'admin[AdminID1推荐 首页幻灯片[]]'),
	(98,NULL,1596215981,'admin[AdminID1删除 首页幻灯片[文明交通执勤]]'),
	(99,NULL,1596216024,'admin[AdminID1推荐 首页幻灯片[]]'),
	(100,NULL,1596216038,'admin[AdminID1删除 首页幻灯片[test313-报告]]'),
	(101,NULL,1596216129,'admin[团队管理 添加-test]'),
	(102,NULL,1596216136,'admin[团队管理 删除-test]');

/*!40000 ALTER TABLE `qx_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_news`;

CREATE TABLE `qx_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_news` WRITE;
/*!40000 ALTER TABLE `qx_news` DISABLE KEYS */;

INSERT INTO `qx_news` (`id`, `title`, `content`, `create_time`, `admin_id`, `pic`)
VALUES
	(6,'乌鲁木齐完成现有隔离人员核检','<p><span style=\"color: rgb(64, 64, 64); font-family: &quot;Microsoft Yahei&quot;; font-size: 16px; text-align: justify; text-indent: 32px;\">&nbsp; &nbsp; 【#乌鲁木齐完成现有隔离人员核酸检测#】7月19日下午，乌鲁木齐市疾控中心主任芮宝玲介绍，截至7月19日8时，乌鲁木齐市对现有的集中隔离医学观察和居家隔离医学观察人员已全部完成新冠肺炎核酸检测工作。目前增加的确诊病例和无症状感染者全部来自接受隔离医学观察人员，#乌鲁木齐疾控提醒市民不必过度恐慌#。针对传染源的溯源工作正在进行中，将进一步加大流行病学调查力度，确保不漏一人，尽快查清病源，坚决控制疫情的蔓延。</span></p><p><span style=\"color: rgb(64, 64, 64); font-family: &quot;Microsoft Yahei&quot;; font-size: 16px; text-align: justify; text-indent: 32px;\"></span><img src=\"/uploads/20200720/32b08581d7f78233c10b8f7e90eb9d71.jpg\" style=\"width: 671px;\"><span style=\"color: rgb(64, 64, 64); font-family: &quot;Microsoft Yahei&quot;; font-size: 16px; text-align: justify; text-indent: 32px;\"><br></span>\r\n                                            </p>',1595175306,1,NULL),
	(7,'水位急降7米！湖北恩施一片狼藉 ','<p><br><img src=\"/uploads/20200720/41de3692b2b535a595f08bb8b60dd709.jpg\" style=\"width: 671px;\"></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">7</span><span class=\"s2\" style=\"font-kerning: none;\">月</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">18</span><span class=\"s2\" style=\"font-kerning: none;\">日，恩施市体育馆路，工作人员正将一辆水淹的汽车送修。</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">（湖北日报全媒记者</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">蔡俊</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">摄）</span></p><p class=\"p2\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: Times; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49); min-height: 19px;\"><span class=\"s2\" style=\"font-kerning: none;\"></span><br></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">湖北日报全媒记者</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">翟兴波</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">刘畅</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">林晶</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">通讯员</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">杜瑞芳</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">7</span><span class=\"s2\" style=\"font-kerning: none;\">月</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">18</span><span class=\"s2\" style=\"font-kerning: none;\">日凌晨，洪水渐退。</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">街巷黄泥淤积狼藉遍地，地下车库积水滞留污痕上墙，树枝丫上挂着垃圾袋和漂浮物，恩施州城被洪水严重肆虐。</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">家园，需要一起守护！</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">恩施市</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">9000</span><span class=\"s2\" style=\"font-kerning: none;\">余名党员下沉社区，迅速带领志愿者、义工和普通群众进行灾后重启，尽快让山城家园恢复美丽容颜。</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">水位急降</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\"> </span><span class=\"s2\" style=\"font-kerning: none;\">积水全退</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">“</span><span class=\"s2\" style=\"font-kerning: none;\">水位已经下降</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">7</span><span class=\"s2\" style=\"font-kerning: none;\">米左右。</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">”7</span><span class=\"s2\" style=\"font-kerning: none;\">月</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">18</span><span class=\"s2\" style=\"font-kerning: none;\">日傍晚，在清江河边值守的恩施州城舞阳办事处官坡党委副书记刘俊锋，指着清江边的一处观测点说。水流虽仍湍急，但已明显回落。湖北日报全媒记者看到，水位标识已从高峰期的</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">418.9</span><span class=\"s2\" style=\"font-kerning: none;\">米降到</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">412</span><span class=\"s2\" style=\"font-kerning: none;\">米左右。</span></p><p class=\"p1\" style=\"margin-bottom: 0px; text-align: justify; text-indent: 32px; font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 16px; line-height: normal; font-family: &quot;Songti SC&quot;; color: rgb(49, 49, 49); -webkit-text-stroke-color: rgb(49, 49, 49);\"><span class=\"s2\" style=\"font-kerning: none;\">清江东路桔园街是恩施中心城区最热闹的地段，</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">17</span><span class=\"s2\" style=\"font-kerning: none;\">日距离清江</span><span class=\"s1\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; line-height: normal; font-family: Times; font-kerning: none;\">50</span><span class=\"s2\" style=\"font-kerning: none;\">多米以内的堤外街道满是积水，现已全部退去。警戒线的区域车辆畅通无阻。</span></p>',1595175643,1,NULL);

/*!40000 ALTER TABLE `qx_news` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_pic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_pic`;

CREATE TABLE `qx_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `modify_time` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `val_id` int(11) DEFAULT NULL,
  `sort` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_pic` WRITE;
/*!40000 ALTER TABLE `qx_pic` DISABLE KEYS */;

INSERT INTO `qx_pic` (`id`, `path`, `title`, `modify_time`, `type`, `val_id`, `sort`)
VALUES
	(7,'/uploads/20200726/064d3d1f33aaa530354745658ebf9bf4.jpg','',1595778633,'news',7,0),
	(8,'/uploads/20200726/348b151da964915aff316a66e9e06743.jpg','',1595778701,'active',8,0),
	(10,'/uploads/20200727/da47821993ab5fb23b79e14fa266a85c.jpg','',1595779350,'report',7,0);

/*!40000 ALTER TABLE `qx_pic` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_report
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_report`;

CREATE TABLE `qx_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active_id` int(11) DEFAULT NULL,
  `pic` text,
  `info` text,
  `create_time` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_num` int(1) DEFAULT '0' COMMENT '修改次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_report` WRITE;
/*!40000 ALTER TABLE `qx_report` DISABLE KEYS */;

INSERT INTO `qx_report` (`id`, `active_id`, `pic`, `info`, `create_time`, `admin_id`, `update_time`, `update_num`)
VALUES
	(8,8,NULL,'清江东路桔园街是恩施中心城区最热闹的地段，17日距离清江50多米以内的堤外街道满是积水，现已全部退去。警戒线的区域车辆畅通无阻。\r\n\r\n位于这一街区的九立方商城是恩施最大的商业体。公司负责人郭施红带着记者进入商城内部，渍水印记在墙面仍清晰可见，高达腰部。“昨日，洪水从5个侧门渗入，淹没了地下三层和地上一层。”他说，目前正组织100余员工用高压水龙清洗地面。',1595175802,1,NULL,3),
	(9,7,NULL,'测试',1595779055,1,NULL,3);

/*!40000 ALTER TABLE `qx_report` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table qx_report_pic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `qx_report_pic`;

CREATE TABLE `qx_report_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `active_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_report_pic` WRITE;
/*!40000 ALTER TABLE `qx_report_pic` DISABLE KEYS */;

INSERT INTO `qx_report_pic` (`id`, `report_id`, `path`, `active_id`)
VALUES
	(22,NULL,'20200720/578c0dde11546eb8b099ad8908b76d99.jpg',8),
	(23,NULL,'20200726/e4895012d080e302e0afc76be9fa15e7.jpg',7);

/*!40000 ALTER TABLE `qx_report_pic` ENABLE KEYS */;
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
  `is_team` int(1) DEFAULT '0' COMMENT '1团体2社区',
  `is_town` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_team` WRITE;
/*!40000 ALTER TABLE `qx_team` DISABLE KEYS */;

INSERT INTO `qx_team` (`id`, `name`, `pid`, `sort`, `level`, `is_team`, `is_town`)
VALUES
	(1,'机关',0,0,1,0,0),
	(2,'纪委监委',1,0,2,0,0),
	(3,'区委办',1,0,2,0,0),
	(4,'组织部',1,0,2,0,0),
	(5,'宣传部',1,0,2,0,0),
	(6,'社科联',1,0,2,0,0),
	(7,'统战部',1,0,2,0,0),
	(8,'政法委',1,0,2,0,0),
	(9,'网络安全和信息化委员会办公室',1,0,2,0,0),
	(10,'编委办',1,0,2,0,0),
	(11,'区直机关工委',1,0,2,0,0),
	(12,'巡察办',1,0,2,0,0),
	(13,'信访局',1,0,2,0,0),
	(14,'老干部局',1,0,2,0,0),
	(15,'督查办公室',1,0,2,0,0),
	(16,'党校',1,0,2,0,0),
	(17,'档案馆',1,0,2,0,0),
	(18,'国教办',1,0,2,0,0),
	(19,'总工会',1,0,2,0,0),
	(20,'团委',1,0,2,0,0),
	(21,'妇联',1,0,2,0,0),
	(22,'文联',1,0,2,0,0),
	(23,'工商联',1,0,2,0,0),
	(24,'残联',1,0,2,0,0),
	(25,'人大办公室',1,0,2,0,0),
	(26,'政协办公室',1,0,2,0,0),
	(27,'法院',1,0,2,0,0),
	(28,'检察院',1,0,2,0,0),
	(29,'政府办',1,0,2,0,0),
	(30,'发展和改革局',1,0,2,0,0),
	(31,'教育体育和科学技术局',1,0,2,0,0),
	(32,'工信局',1,0,2,0,0),
	(33,'民政局',1,0,2,0,0),
	(34,'司法局',1,0,2,0,0),
	(35,'财政局',1,0,2,0,0),
	(36,'人社局',1,0,2,0,0),
	(37,'住房和城乡建设局',1,0,2,0,0),
	(38,'城市管理综合行政执法局',1,0,2,0,0),
	(39,'团体',0,0,1,1,0),
	(40,'第一中学志愿服务团队',39,0,2,0,0),
	(41,'第四中学服务队',39,0,2,0,0),
	(42,'市职教中心志愿者队',39,0,2,0,0),
	(43,'正博高中志愿服务队',39,0,2,0,0),
	(44,'大境门街道暖阳志愿者服务队',39,0,2,0,0),
	(45,'南营坊青扬志愿服务队',39,0,2,0,0),
	(46,'赐儿山社区乐民之家志愿服务队',39,0,2,0,0),
	(47,'西沟社区暖阳志愿者服务队',39,0,2,0,0),
	(48,'西山底社区暖阳志愿者服务队',39,0,2,0,0),
	(49,'河北北方学院附属第一医院志愿服务队',39,0,2,0,0),
	(50,'华新园社区团体服务队',39,0,2,0,0),
	(51,'二中志愿服务队',39,0,2,0,0),
	(52,'尚峰购物广场志愿服务队',39,0,2,0,0),
	(53,'普法宣传志愿服务队',39,0,2,0,0),
	(54,'环境卫生管理处志愿服务队',39,0,2,0,0),
	(55,'第一医院志愿服务队',39,0,2,0,0),
	(56,'助残志愿者团体',39,0,2,0,0),
	(57,'巾帼志愿者服务队',39,0,2,0,0),
	(58,'学校',0,0,1,0,0),
	(59,'第九中学',58,0,2,0,0),
	(60,'第十六中学',58,0,2,0,0),
	(61,'第十九中学',58,0,2,0,0),
	(62,'第二十中学',58,0,2,0,0),
	(63,'东窑子中学',58,0,2,0,0),
	(64,'大境门小学',58,0,2,0,0),
	(65,'逸夫回族小学',58,0,2,0,0),
	(66,'蒙古营小学',58,0,2,0,0),
	(67,'下东营小学',58,0,2,0,0),
	(68,'明德路小学',58,0,2,0,0),
	(69,'新华小学',58,0,2,0,0),
	(70,'书院巷小学',58,0,2,0,0),
	(71,'长青路小学',58,0,2,0,0),
	(72,'通顺街小学',58,0,2,0,0),
	(73,'西豁子小学',58,0,2,0,0),
	(74,'南菜园小学',58,0,2,0,0),
	(75,'清河路小学',58,0,2,0,0),
	(76,'北新村小学',58,0,2,0,0),
	(77,'东窑子小学',58,0,2,0,0),
	(78,'南天门小学',58,0,2,0,0),
	(79,'永丰堡小学',58,0,2,0,0),
	(80,'苏家桥小学',58,0,2,0,0),
	(81,'桥西幼儿园',58,0,2,0,0),
	(82,'民族幼儿园',58,0,2,0,0),
	(83,'双语幼儿园',58,0,2,0,0),
	(84,'东窑幼儿园',58,0,2,0,0),
	(85,'镇街',0,0,1,0,0),
	(86,'大境门街道',85,0,2,2,1),
	(87,'明德北街道',85,0,2,2,1),
	(88,'明德南街道',85,0,2,2,1),
	(89,'新华街街道',85,0,2,2,1),
	(90,'堡子里街道',85,0,2,2,1),
	(91,'南营坊街道',85,0,2,2,1),
	(92,'工人新村街道',85,0,2,2,1),
	(93,'东窑子镇',85,0,2,2,1),
	(94,'外东窑村',93,0,3,0,1),
	(95,'东湾子村',93,0,3,0,1),
	(96,'孤石村',93,0,3,0,1),
	(97,'虎头梁村',93,0,3,0,1),
	(98,'瓦盆窑村',93,0,3,0,1),
	(99,'永丰堡村',93,0,3,0,1),
	(100,'五墩村',93,0,3,0,1),
	(101,'翠屏庵村',93,0,3,0,1),
	(102,'马家梁村',93,0,3,0,1),
	(103,'南茶坊村',93,0,3,0,1),
	(104,'石匠窑村',93,0,3,0,1),
	(105,'元宝山村',93,0,3,0,1),
	(106,'四岔村',93,0,3,0,1),
	(107,'稍道沟村',93,0,3,0,1),
	(108,'南天门村',93,0,3,0,1),
	(109,'菜市村',93,0,3,0,1),
	(110,'清河村',93,0,3,0,1),
	(111,'红旗营村',93,0,3,0,1),
	(112,'土井子村',93,0,3,0,1),
	(113,'苏家桥村',93,0,3,0,1),
	(114,'西山底社区',86,0,3,0,1),
	(115,'黄土场社区',86,0,3,0,1),
	(116,'西沟社区',86,0,3,0,1),
	(117,'西岔社区',86,0,3,0,1),
	(118,'平门路社区',86,0,3,0,1),
	(119,'沁馨苑社区',86,0,3,0,1),
	(120,'附属医院社区',87,0,3,0,1),
	(121,'蒙古营社区',87,0,3,0,1),
	(122,'西沙河社区',87,0,3,0,1),
	(123,'中学街社区',87,0,3,0,1),
	(124,'营城子社区',87,0,3,0,1),
	(125,'清河园社区',87,0,3,0,1),
	(126,'长青路社区',88,0,3,0,1),
	(127,'永丰街社区',88,0,3,0,1),
	(128,'白山南社区',88,0,3,0,1),
	(129,'白山北社区',88,0,3,0,1),
	(130,'元台子社区',88,0,3,0,1),
	(131,'金鼎社区',89,0,3,0,1),
	(132,'华新园社区',89,0,3,0,1),
	(133,'南瓦一社区',89,0,3,0,1),
	(134,'南瓦二社区',89,0,3,0,1),
	(135,'北瓦社区',89,0,3,0,1),
	(136,'新华街社区',89,0,3,0,1),
	(137,'西豁子社区',89,0,3,0,1),
	(138,'新华苑社区',89,0,3,0,1),
	(139,'赐儿山社区',89,0,3,0,1),
	(140,'鼓楼西社区',90,0,3,0,1),
	(141,'武城街社区',90,0,3,0,1),
	(142,'北关街社区',90,0,3,0,1),
	(143,'南城壕社区',90,0,3,0,1),
	(144,'教场坡社区',91,0,3,0,1),
	(145,'天宝南苑社区',91,0,3,0,1),
	(146,'南茶坊社区',91,0,3,0,1),
	(147,'西坝岗社区',91,0,3,0,1),
	(148,'建设桥社区',91,0,3,0,1),
	(149,'宏景嘉苑社区',91,0,3,0,1),
	(150,'南新村社区',92,0,3,0,1),
	(151,'北新村社区',92,0,3,0,1),
	(152,'新村南路社区',92,0,3,0,1),
	(153,'印台沟社区',92,0,3,0,1);

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
  `duration` float DEFAULT '0' COMMENT '服务时长',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

LOCK TABLES `qx_user` WRITE;
/*!40000 ALTER TABLE `qx_user` DISABLE KEYS */;

INSERT INTO `qx_user` (`id`, `real_name`, `id_number`, `sex`, `tel`, `team_id`, `pol_cou`, `hight_edu`, `area`, `address`, `create_time`, `openid`, `comm_id`, `duration`)
VALUES
	(3,'李某某','1101111984080520xx',0,'13810761824',9,'中国共产党党员(保留团籍)','博士研究生','桥东区','sfdsdf',1593450637,'1',40,0),
	(7,'张小小','110111854210021212',1,'13810761824',9,'中国共产党党员','博士研究生','桥西区','北京市某某区',1594396995,'oz7m25Lbbgt6zqlOg08249Q6OWpQ',40,2),
	(5,'www','110111198405201203',0,'13810761824',9,'中国国民党革命委员会会员','技工学校','经济技术开发区','sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsd',1593703339,'o1EqstzMtNwbKZUfl0hbcs-q17Ps',9,1.5),
	(8,'6666',NULL,0,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,0,12),
	(9,'777',NULL,0,NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,0,11),
	(10,'8888',NULL,0,NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,0,2),
	(11,'99','1101111984080511xx',0,'1300000000',62,'中国共产党党员(保留团籍)','博士研究生','桥东区','xxx',NULL,NULL,0,13),
	(12,'12',NULL,0,NULL,114,NULL,NULL,NULL,NULL,NULL,NULL,0,12),
	(13,'13',NULL,0,NULL,115,NULL,NULL,NULL,NULL,NULL,NULL,0,20),
	(14,'3434',NULL,0,NULL,94,NULL,NULL,NULL,NULL,NULL,NULL,0,55),
	(15,'2323',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(16,'5433',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(17,'sdf',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(18,'werw',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(19,'rwe',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(20,'cc',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(21,'43',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(22,'535',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(23,'fbv',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0),
	(24,'erte',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0);

/*!40000 ALTER TABLE `qx_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
