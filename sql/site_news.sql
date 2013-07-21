SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_news`
-- ----------------------------
DROP TABLE IF EXISTS `site_news`;
CREATE TABLE `site_news` (
  `id` bigint(32) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL COMMENT 'Image filename (in content/images/)',
  `content` text,
  `keywords` text,
  `views` bigint(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `commentsEnabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `title` (`title`,`content`,`keywords`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;