<?php

if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

// User status
define('USER_STATUS_NONE', 			0);
define('USER_STATUS_LOGGEDIN', 		1);
define('USER_STATUS_FORUM_DATA', 	2);
define('USER_STATUS_FAIL', 			3);

// Pages

define('PAGE_MAIN', 		'main');
define('PAGE_NEWS', 		'news');
define('PAGE_CORE', 		'core');
define('PAGE_ABOUT', 		'about');
define('PAGE_STATS', 		'stats');
define('PAGE_RULES', 		'rules');
define('PAGE_ERROR_404', 	'error');
define('PAGE_NEWS_PART', 	'news_page');
define('PAGE_NEWS_ENTRY', 	'news_entry');
define('PAGE_NEWS_SEARCH', 	'news_search');

// Forum skins
global $skins;
$skins = array(
    '42'	=>	'riverrise',
    '55'	=>	'master'
);

// CMS
define('CUT_DELIMITER', '{cut}');
