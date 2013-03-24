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

define('PAGE_MAIN', 		0);
define('PAGE_STATS', 		1);
define('PAGE_REGISTRATION', 2);
define('PAGE_RULES', 		3);
define('PAGE_NEWS', 		4);
define('PAGE_NEWS_ENTRY', 	5);

// Forum skins
global $skins;
$skins = array(
    '42'	=>	'riverrise',
    '55'	=>	'master'
);
