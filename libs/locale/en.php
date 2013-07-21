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
	'anonymous'			=>	'Anonymous',
	'search'			=>	'Search',
	'search_result_1'	=>	'Result of request',
	'search_result_2'	=>	'is',
	'records'			=>	'record;records;records',
	'hours'				=>	'h.',
	'minutes'			=>	'min.',
	
	// titles
	'title_stats'		=>	'Realm status',
	'title_news'		=>	'Server news',
	'title_search'		=>	'Search news',
	'title_rules'		=>	'Rules',
	'title_core'		=>	'Core',
	'title_about'		=>	'About',
	
	// error
	'404_title'			=>	'404 - Page not found',
	'404_description'	=>	'Page not found. Probably it was deleted or never existed.',

	// header
	'to_site'			=>	'Go to site',
	'to_forum'			=>	'Go to forum',
	'to_users'			=>	'Go to users',
	'to_tracker'		=>	'Go to BugTracker',
	'to_gallery'		=>	'Go to gallery',
	'to_blogs'			=>	'Go to blogs',
	'to_awards'			=>	'Go to awards',
	'to_db'				=>	'Go to knowledge DB',
	
	'forum'				=>	'Forum',
	'users'				=>	'Users',
	'tracker'			=>	'BugTracker',
	'gallery'			=>	'Gallery',
	'blogs'				=>	'Blogs',
	'awards'			=>	'Awards',
	'db'				=>	'WoW knowledge DB',

	// navigation
	'other_news'		=>	'Other news',
	'nav_up'			=>	'Up',
	'nav_back'			=>	'Back',

	// news
	'views'				=>	'Views',
	'comments'			=>	'Comments',
	'tags'				=>	'Tags',
	'full_news'			=>	'Full text',

	// comments
	'new_comment'		=>	'New comment',
	'post_comment'		=>	'Post comment',
	'posting_comment'	=>	'Posting comment',
	'preview_comment'	=>	'Preview',
	'edit_comment'		=>	'Edit',

	// stats
	'full_online'		=>	'Overall online',
	'alliance_online'	=>	'Alliance online',
	'horde_online'		=>	'Horde online',
	'max_uptime'		=>	'Maximum uptime',
	'current_uptime'	=>	'Current uptime',

	// footer
	'trademark_info'	=>	'All trademarks are the property of their respective owners.',
	'all_rights_reserved'=>'All rights reserved.',
);

?>