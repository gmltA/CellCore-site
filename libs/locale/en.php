<?php
if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

global $lang;

$lang = array(
    'id'				=>	'en',

	// general
	'main_page'			=>	'Main',
	'news_page'			=>	'News',
	'auth'				=>	'Auth',
	'register'			=>	'Register',
	'anonymous'			=>	'Anonymous',
	'search'			=>	'Search',
	'search_result_1'	=>	'Result of request',
	'search_result_2'	=>	'is',
	'records'			=>	'record;records;records',
	'hours'				=>	'h.',
	'minutes'			=>	'min.',

	// titles
	'title_catalog'		=>	'Каталог',
	'title_cat_search'	=>	'Поиск предметов',

	// error
	'404_title'			=>	'404 - Page not found',
	'404_description'	=>	'Page not found. Probably it was deleted or never existed.',

	// navigation
	'other_news'		=>	'Other news',
	'nav_up'			=>	'Up',
	'nav_back'			=>	'Back',

	// news
	'views'				=>	'Views',
	'comments'			=>	'Comments',
	'tags'				=>	'Tags',
	'full_news'			=>	'Full text',

	// footer
	'trademark_info'	=>	'All trademarks are the property of their respective owners.',
	'all_rights_reserved'=>'All rights reserved.',
);

?>