SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_slider_content`
-- ----------------------------
DROP TABLE IF EXISTS `site_slider_content`;
CREATE TABLE `site_slider_content` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entry ID',
  `contentImage` varchar(255) NOT NULL COMMENT 'Image filename (in content/images/)',
  `description` text NOT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT 'Entry link',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
