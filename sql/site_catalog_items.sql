SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_catalog_items`
-- ----------------------------
DROP TABLE IF EXISTS `site_catalog_items`;
CREATE TABLE `site_catalog_items` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `thumbnail` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `category` varchar(20) NOT NULL DEFAULT '',
  `material` varchar(255) NOT NULL DEFAULT '',
  `region` varchar(20) NOT NULL DEFAULT '',
  `district` varchar(255) NOT NULL DEFAULT '',
  `town` varchar(255) NOT NULL DEFAULT '',
  `digging` varchar(255) NOT NULL DEFAULT '',
  `layer` varchar(20) NOT NULL DEFAULT '',
  `square` varchar(10) NOT NULL DEFAULT '',
  `fieldNumber` int(30) unsigned NOT NULL,
  `area` varchar(20) NOT NULL DEFAULT '',
  `homestead` varchar(20) DEFAULT '',
  `gps` varchar(30) DEFAULT '',
  `year` year(4) NOT NULL DEFAULT '2001',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `dating` varchar(20) DEFAULT NULL,
  `storagePlace` varchar(20) NOT NULL DEFAULT '',
  `notes` mediumtext,
  PRIMARY KEY (`id`),
  KEY `cost` (`title`),
  KEY `category_realm` (`category`,`material`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
