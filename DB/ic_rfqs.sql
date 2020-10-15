/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : merchant_bay

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-10-15 14:08:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ic_rfqs`
-- ----------------------------
DROP TABLE IF EXISTS `ic_rfqs`;
CREATE TABLE `ic_rfqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rfq_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfq_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfq_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rfq_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of ic_rfqs
-- ----------------------------
