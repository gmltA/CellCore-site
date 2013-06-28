SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `site_news_comments`
-- ----------------------------
DROP TABLE IF EXISTS `site_news_comments`;
CREATE TABLE `site_news_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique comment indetificator',
  `newsId` bigint(32) unsigned NOT NULL COMMENT 'News entry ID comment belongs to',
  `authorId` int(10) unsigned NOT NULL COMMENT 'User ID - author of the comment',
  `topicId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Upper comment (topic) ID',
  `subjectId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Subject user ID of the comment (if defined)',
  `date` datetime NOT NULL COMMENT 'Comment date and time',
  `body` text NOT NULL COMMENT 'Comment message text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
