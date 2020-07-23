/*
Navicat MySQL Data Transfer

Source Server         : 192.168.175.16
Source Server Version : 50728
Source Host           : 192.168.175.16:3306
Source Database       : qx

Target Server Type    : MYSQL
Target Server Version : 50728
File Encoding         : 65001

Date: 2020-07-23 17:26:26
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for qx_pic
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qx_pic
-- ----------------------------
INSERT INTO `qx_pic` VALUES ('2', '/uploads/20200723/db51f0b7c319351e265c53fabd4d6cc1.png', '乌鲁木齐完成现有隔离人员核检1', '1595489022', 'news', '6', '5');
INSERT INTO `qx_pic` VALUES ('5', '/uploads/20200723/47a798a457b66414b5097b695bfbbdfe.png', '', '1595491338', 'report', '13', '1');
