SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_catalog_items`
-- ----------------------------
DROP TABLE IF EXISTS `site_catalog_items`;
CREATE TABLE `site_catalog_items` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `thumbnail` varchar(255) NOT NULL DEFAULT '/content/images/default_thumb.png',
  `image` varchar(255) NOT NULL DEFAULT '',
  `category` varchar(20) NOT NULL DEFAULT 'undefined',
  `material` varchar(255) NOT NULL DEFAULT 'undefined',
  `region` varchar(20) NOT NULL DEFAULT 'unknown',
  `district` varchar(255) NOT NULL DEFAULT 'unknown',
  `town` varchar(255) NOT NULL DEFAULT 'unknown',
  `digging` varchar(255) NOT NULL DEFAULT 'unknown',
  `layer` varchar(20) NOT NULL DEFAULT 'unknown',
  `square` varchar(10) NOT NULL DEFAULT 'unknown',
  `fieldNumber` varchar(30) NOT NULL DEFAULT 'unknown',
  `area` varchar(20) NOT NULL DEFAULT 'unknown',
  `homestead` varchar(20) DEFAULT 'unknown',
  `gps` varchar(30) DEFAULT 'unknown',
  `year` year(4) NOT NULL DEFAULT '0000',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `dating` varchar(20) DEFAULT 'undefined',
  `storagePlace` varchar(20) NOT NULL DEFAULT 'unknown',
  `notes` mediumtext,
  PRIMARY KEY (`id`),
  KEY `cost` (`title`),
  KEY `category_realm` (`category`,`material`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
