<?php

if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

// Pages

define('PAGE_MAIN',				'main');
define('PAGE_NEWS',				'news');
define('PAGE_ABOUT',			'about');
define('PAGE_NEWS_PART',		'news_page');
define('PAGE_NEWS_ENTRY',		'news_entry');
define('PAGE_NEWS_SEARCH',		'news_search');
define('PAGE_CATALOG',			'catalog');
define('PAGE_CATALOG_PART',		'catalog_page');
define('PAGE_CATALOG_ENTRY',	'catalog_entry');
define('PAGE_CATALOG_SEARCH',	'catalog_search');
define('PAGE_CATALOG_ITEM',		'catalog_item');
define('PAGE_CATALOG_ADD_ITEM',	'catalog_add_item');

// CMS
define('CUT_DELIMITER', '{cut}');
define('NOCUT_START', '{nocut}');
define('NOCUT_END', '{/nocut}');
define('NOCUT_END_R', '{\/nocut}');
