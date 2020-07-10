/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-10 17:47:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_enter
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_enter
-- ----------------------------
INSERT INTO `qx_enter` VALUES ('1', '3', '5', '0', '0', null, '0', null);
