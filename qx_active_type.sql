/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-09 17:42:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_active_type
-- ----------------------------
DROP TABLE IF EXISTS `qx_active_type`;
CREATE TABLE `qx_active_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` int(1) DEFAULT NULL COMMENT '1活动类型2活动时长',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_active_type
-- ----------------------------
INSERT INTO `qx_active_type` VALUES ('1', 'dsfwe111121', '1');
INSERT INTO `qx_active_type` VALUES ('2', '2.5', '2');
