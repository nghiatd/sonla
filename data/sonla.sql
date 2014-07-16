/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : sonla

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2014-05-06 22:20:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_business`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_business`;
CREATE TABLE `tbl_business` (
  `BUSINESS_id` int(11) NOT NULL AUTO_INCREMENT,
  `BUSINESS_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_CategoryId` int(11) NOT NULL,
  `BUSINESS_CreatedDate` date NOT NULL,
  `BUSINESS_Status` enum('ACTIVATE','HOT','DISABLED') COLLATE utf8_unicode_ci NOT NULL,
  `BUSINESS_Deleted` int(11) NOT NULL,
  `BUSINESS_DeletedDate` date NOT NULL,
  `BUSINESS_CreatedUserId` int(11) NOT NULL,
  PRIMARY KEY (`BUSINESS_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_business
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_cat_categories`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cat_categories`;
CREATE TABLE `tbl_cat_categories` (
  `CAT_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Category id',
  `CAT_Code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Category code',
  `CAT_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name in English',
  `CAT_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name in Vietnamese',
  `CAT_Description_en` text COLLATE utf8_unicode_ci COMMENT 'Description in English',
  `CAT_Description_vi` text COLLATE utf8_unicode_ci COMMENT 'Description in Vietnamese',
  `CAT_ParentId` int(11) NOT NULL DEFAULT '0' COMMENT 'Parent id of categories',
  `CAT_Sort` int(11) NOT NULL DEFAULT '9999' COMMENT 'Sort number of cat',
  `CAT_Status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status of cat to allowed show or hide',
  `CAT_LastActivity` int(11) NOT NULL COMMENT 'Last activity time',
  PRIMARY KEY (`CAT_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_cat_categories
-- ----------------------------
INSERT INTO `tbl_cat_categories` VALUES ('1', 'intro', 'Introduce', 'Giới thiệu', null, null, '0', '0', '1', '1387004410');
INSERT INTO `tbl_cat_categories` VALUES ('2', 'news', 'News', 'Tin tức', null, null, '0', '1', '1', '1387004410');
INSERT INTO `tbl_cat_categories` VALUES ('3', 'org', 'Organize', 'Tổ chức', null, null, '0', '2', '1', '1387004410');
INSERT INTO `tbl_cat_categories` VALUES ('4', 'business', 'Business', 'Doanh nghiệp', null, null, '0', '3', '1', '1387004410');
INSERT INTO `tbl_cat_categories` VALUES ('5', 'citizen', 'Citizen', 'Công dân', null, null, '0', '4', '1', '1387004410');
INSERT INTO `tbl_cat_categories` VALUES ('6', 'tourer', 'Tourer', 'Du khách', null, null, '0', '5', '1', '0');
INSERT INTO `tbl_cat_categories` VALUES ('7', null, 'anh hung dan toc', 'anh hung dan toc', 'anh hung dan toc', 'anh hung dan toc', '6', '1', '1', '1398591406');

-- ----------------------------
-- Table structure for `tbl_citizen`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_citizen`;
CREATE TABLE `tbl_citizen` (
  `CITIZEN_id` int(11) NOT NULL AUTO_INCREMENT,
  `CITIZEN_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `CITIZEN_CategoryId` int(11) NOT NULL,
  `CITIZEN_CreatedDate` date NOT NULL,
  `CITIZEN_Status` tinyint(1) NOT NULL DEFAULT '1',
  `CITIZEN_Deleted` int(11) DEFAULT NULL,
  `CITIZEN_DeletedDate` date DEFAULT NULL,
  `CITIZEN_CreatedUserId` int(11) NOT NULL,
  `CITIZEN_Sort` int(4) NOT NULL,
  `CITIZEN_LastActivity` int(11) NOT NULL,
  PRIMARY KEY (`CITIZEN_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_citizen
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_faq`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_faq`;
CREATE TABLE `tbl_faq` (
  `FAQ_Id` int(11) NOT NULL AUTO_INCREMENT,
  `FAQ_Title` varchar(255) DEFAULT NULL,
  `FAQ_Name` varchar(125) DEFAULT NULL,
  `FAQ_Address` varchar(125) DEFAULT NULL,
  `FAQ_Email` varchar(125) DEFAULT NULL,
  `FAQ_Status` tinyint(4) DEFAULT NULL,
  `FAQ_CategoryId` int(11) NOT NULL,
  `FAQ_Content` text,
  `FAQ_CreatedDate` date DEFAULT NULL,
  `FAQ_Answer` text,
  `FAQ_LastActivity` int(11) DEFAULT NULL,
  PRIMARY KEY (`FAQ_Id`),
  KEY `fk_faq_faq_categories1` (`FAQ_CategoryId`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tbl_faq
-- ----------------------------
INSERT INTO `tbl_faq` VALUES ('1', 'Chỉ tiêu giáo viên cấp 3', 'Lèo Thị Hương', '', 'dsfsdfsdf', '1', '1', null, null, '<p>sadsdsdsaddfdsfsdfsdf</p>', '1398631958');
INSERT INTO `tbl_faq` VALUES ('2', 'Chế độ chish sách', 'tập thẻ', null, null, '1', '2', 'cho em hỏi hiện giờ giáo viên cấp 3 chưa có chỉ tiêu ạ? em chờ từ tháng 6 tới giờ vẫn chưa có. Em muốn hỏi bao giờ thì mới có ạ? ', '2014-04-27', null, null);

-- ----------------------------
-- Table structure for `tbl_faq_categories`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_faq_categories`;
CREATE TABLE `tbl_faq_categories` (
  `FAQ_CAT_Id` int(11) NOT NULL AUTO_INCREMENT,
  `FAQ_CAT_Code` varchar(125) DEFAULT NULL,
  `FAQ_CAT_Name_en` varchar(125) DEFAULT NULL,
  `FAQ_CAT_Name_vi` varchar(125) DEFAULT NULL,
  `FAQ_CAT_Status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`FAQ_CAT_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_faq_categories
-- ----------------------------
INSERT INTO `tbl_faq_categories` VALUES ('1', 'business', 'Business', 'Dành cho doanh nghiệp', '1');
INSERT INTO `tbl_faq_categories` VALUES ('2', 'citizen', 'Citizen', 'Dành cho công dân', '1');
INSERT INTO `tbl_faq_categories` VALUES ('3', 'tourer', 'Tourer', 'Dành cho du khách', '1');

-- ----------------------------
-- Table structure for `tbl_intro`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_intro`;
CREATE TABLE `tbl_intro` (
  `INTRO_id` int(11) NOT NULL AUTO_INCREMENT,
  `INTRO_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_CategoryId` int(11) NOT NULL,
  `INTRO_CreatedDate` date NOT NULL,
  `INTRO_Status` enum('ACTIVATE','HOT','DISABLED') COLLATE utf8_unicode_ci NOT NULL,
  `INTRO_Deleted` int(11) NOT NULL,
  `INTRO_DeletedDate` date NOT NULL,
  `INTRO_CreatedUserId` int(11) NOT NULL,
  PRIMARY KEY (`INTRO_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_intro
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_news`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_news`;
CREATE TABLE `tbl_news` (
  `NEWS_id` int(11) NOT NULL AUTO_INCREMENT,
  `NEWS_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_CategoryId` int(11) NOT NULL,
  `NEWS_CreatedDate` date NOT NULL,
  `NEWS_Status` enum('ACTIVATE','HOT','DISABLED') COLLATE utf8_unicode_ci NOT NULL,
  `NEWS_Deleted` int(11) NOT NULL,
  `NEWS_DeletedDate` date NOT NULL,
  `NEWS_CreatedUserId` int(11) NOT NULL,
  PRIMARY KEY (`NEWS_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_news
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_org`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_org`;
CREATE TABLE `tbl_org` (
  `ORG_id` int(11) NOT NULL AUTO_INCREMENT,
  `ORG_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `ORG_CategoryId` int(11) NOT NULL,
  `ORG_CreatedDate` date NOT NULL,
  `ORG_Status` enum('ACTIVATE','HOT','DISABLED') COLLATE utf8_unicode_ci NOT NULL,
  `ORG_Deleted` int(11) NOT NULL,
  `ORG_DeletedDate` date NOT NULL,
  `ORG_CreatedUserId` int(11) NOT NULL,
  PRIMARY KEY (`ORG_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_org
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_tourer`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tourer`;
CREATE TABLE `tbl_tourer` (
  `TOURER_id` int(11) NOT NULL AUTO_INCREMENT,
  `TOURER_Name_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Description_vi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Description_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Content_vi` text COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_Content_en` text COLLATE utf8_unicode_ci NOT NULL,
  `TOURER_CategoryId` int(11) NOT NULL,
  `TOURER_CreatedDate` date NOT NULL,
  `TOURER_Status` tinyint(1) NOT NULL DEFAULT '1',
  `TOURER_Deleted` int(11) DEFAULT NULL,
  `TOURER_DeletedDate` date DEFAULT NULL,
  `TOURER_CreatedUserId` int(11) NOT NULL,
  `TOURER_Sort` int(4) NOT NULL,
  `TOURER_LastActivity` int(11) NOT NULL,
  PRIMARY KEY (`TOURER_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_tourer
-- ----------------------------
INSERT INTO `tbl_tourer` VALUES ('3', 'có 1 không 2 lan', 'sffsdfsdfsdf', 'sdfsdfsdfsdf', '', '', '<p>dvdvdv</p>', '<p>dsfdsfsdf</p>', '8', '0000-00-00', '1', null, null, '1', '9999', '1398200179');
INSERT INTO `tbl_tourer` VALUES ('4', 'xcxzczxczxc', 'xzczxcxzczxczxc', 'xzczxczxc', 'zxczxczxc', 'xzczxcxzc', '<p>xcxzczxc</p>', '<p>zxcxzczxczxc</p>', '7', '0000-00-00', '1', null, null, '1', '1', '1398594396');

-- ----------------------------
-- Table structure for `tbl_user_geoip`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_geoip`;
CREATE TABLE `tbl_user_geoip` (
  `USER_GEO_Ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ip of user',
  `USER_GEO_Country` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Country name',
  `USER_GEO_State` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'State name',
  `USER_GEO_City` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'City name',
  PRIMARY KEY (`USER_GEO_Ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user_geoip
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_user_loginattempts`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_loginattempts`;
CREATE TABLE `tbl_user_loginattempts` (
  `USER_ATT_DateTime` int(11) NOT NULL COMMENT 'Access time of user',
  `USER_ATT_Ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Ip of user',
  `USER_ATT_Location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Location of user',
  `USER_ATT_Success` int(11) NOT NULL COMMENT 'Access status success or fail',
  `USER_ATT_UserName` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User name access',
  `USER_ATT_Area` enum('CLIENT','ADMIN') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Admin or Client page that user login',
  PRIMARY KEY (`USER_ATT_DateTime`,`USER_ATT_Ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user_loginattempts
-- ----------------------------
INSERT INTO `tbl_user_loginattempts` VALUES ('1398442908', '127.0.0.1', 'localhost', '1', 'dungnt', 'ADMIN');
INSERT INTO `tbl_user_loginattempts` VALUES ('1398563043', '127.0.0.1', 'localhost', '1', 'dungnt', 'ADMIN');
INSERT INTO `tbl_user_loginattempts` VALUES ('1398575602', '127.0.0.1', 'localhost', '1', 'dungnt', 'ADMIN');
INSERT INTO `tbl_user_loginattempts` VALUES ('1399389020', '127.0.0.1', 'localhost', '1', 'dungnt', 'ADMIN');

-- ----------------------------
-- Table structure for `tbl_user_userlevels`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_userlevels`;
CREATE TABLE `tbl_user_userlevels` (
  `USER_LEV_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Level id',
  `USER_LEV_Alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Level name',
  `USER_LEV_IsAdmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'This user level is admin or not',
  PRIMARY KEY (`USER_LEV_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user_userlevels
-- ----------------------------
INSERT INTO `tbl_user_userlevels` VALUES ('1', 'Top Administrator', '1');
INSERT INTO `tbl_user_userlevels` VALUES ('2', 'Administrator', '1');
INSERT INTO `tbl_user_userlevels` VALUES ('3', 'Member', '0');

-- ----------------------------
-- Table structure for `tbl_user_userslist`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user_userslist`;
CREATE TABLE `tbl_user_userslist` (
  `USER_Id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User id',
  `USER_Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User name',
  `USER_Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User email',
  `USER_Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User password',
  `USER_Challenge` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'As token to check login',
  `USER_Level` int(11) NOT NULL COMMENT 'Refer to User level table',
  `USER_Status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'User status - allowed access or not',
  `USER_LastActivity` int(11) NOT NULL COMMENT 'User last activity time',
  PRIMARY KEY (`USER_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tbl_user_userslist
-- ----------------------------
INSERT INTO `tbl_user_userslist` VALUES ('1', 'dungnt', 'dungnt@ntvn.vn', '33520be94cbbd02ca8988f325a54c5a8ba0e4270c295777eff26439d18089be1', '16a5a185199995b5fc5c638bf20c3aee750de9825d1a1dabcff64793a5debc14', '1', '1', '1399389531');
