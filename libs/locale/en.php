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
	'main_page'			=>	'Main page',
	'news_page'			=>	'News',
	'auth'				=>	'Login',
	'register'			=>	'Register',
	'anonymous'			=>	'Anonymous',
	'search'			=>	'Search',
	'records'			=>	'record;records;records',
	'found'				=>	'found;found;found',
	'hours'				=>	'h.',
	'minutes'			=>	'min.',
	'close'				=>	'Close',
	
	// titles
	'title_about'		=>	'About',
	'title_about_ext'	=>	'Project info',
	'title_catalog'		=>	'Database',
	'title_cat_search'	=>	'Database search',
	'title_catalog_add'	=>	'Add new item',

	// error
	'404_title'			=>	'404 - Page not found',
	'404_description'	=>	'Page not found.',

	// navigation
	'other_news'		=>	'More news',
	'nav_up'			=>	'Up',
	'nav_back'			=>	'Back',

	// news
	'views'				=>	'Views',
	'comments'			=>	'Comments',
	'tags'				=>	'Tags',
	'full_news'			=>	'Full version',
	'full_news_entry'	=>	'Full version &raquo;',

	// catalog
	'catalog_welcome'	=>	'Welcome to DataBase.',
	'move_to_catalog'	=> 	'Go to catalog &raquo;',
	'detailed_info'		=> 	'Full information',
	'show_detailed_info'=> 	'Details &raquo;',
	'details'			=> 	'Details',
	'on_your_request'	=>	'result of your request: ',
	'there_are_items'	=>	'There are ',
	'item_decl'			=>	' item; items; items',
	'show_filter'		=>	'Show filter',
	'filter'			=>	'Filter iteems',
	'clear'				=>	'Reset filter',
	'add_item'			=>	'Add item to DataBase',
	'item_add_success'	=>	'New item added successfully',
	'item_add_fail'		=>	'Error during new item registration',
	
	// item data
	'item_id'			=>	'ID',
	'image'				=>	'Image',
	'image_URL'			=>	'Image URL',
	'thumbnail_URL'		=>	'Thumbnail URL',
	'no_image'			=>	'No image',
	'category'			=>	'Category',
	'material'			=>	'Material',
	'region'			=>	'Region',
	'district'			=>	'District',
	'town'				=>	'Town',
	'digging'			=>	'Digging',
	'square'			=>	'Square',
	'layer'				=>	'Layer',
	'field_number'		=>	'Field number',
	'area'				=>	'Area',
	'homestead'			=>	'Homestead',
	'gps_coordinates'	=>	'GPS coordinates',
	'year'				=>	'Year',
	'dating'			=>	'Dating',
	'storage'			=>	'Storing palce',
	'title'				=>	'Title',
	'description'		=>	'Desription',
	'notes'				=>	'Notes',

	// footer
	'all_rights_reserved'=>'All rights reserved.',
);

?>