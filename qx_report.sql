/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-13 18:21:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_report
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_report
-- ----------------------------
INSERT INTO `qx_report` VALUES ('1', '10', null, 'sdf', '1594668600', '2', null, '3');
