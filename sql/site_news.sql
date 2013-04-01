SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_news`
-- ----------------------------
DROP TABLE IF EXISTS `site_news`;
CREATE TABLE `site_news` (
  `id` bigint(32) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `content` text,
  `keywords` text,
  `views` bigint(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  FULLTEXT (title,content,keywords)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
