/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-16 18:15:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_news
-- ----------------------------
DROP TABLE IF EXISTS `qx_news`;
CREATE TABLE `qx_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `create_time` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_news
-- ----------------------------
INSERT INTO `qx_news` VALUES ('1', 'sd', 'cvbcxbcb', null, '1', null);
