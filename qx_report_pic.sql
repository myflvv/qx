/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-14 18:21:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_report_pic
-- ----------------------------
DROP TABLE IF EXISTS `qx_report_pic`;
CREATE TABLE `qx_report_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_report_pic
-- ----------------------------
INSERT INTO `qx_report_pic` VALUES ('11', '1', '20200714/7fc555040abfa1ffe18bae945c4670ad.png');
INSERT INTO `qx_report_pic` VALUES ('12', '1', '20200714/0e2344c7bcdd13db4dbf1d642f96df02.png');
