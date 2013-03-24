<?php
define('IS_IN_ENGINE', true);

require_once dirname(__FILE__) . '/libs/core.php';

session_start();

global $user;
global $config;

$page = explode('/', $_SERVER['REQUEST_URI']);

switch ($page['1'])
{
    case 'ajax':
		include dirname(__FILE__) . '/libs/ajax.php';
		exit;
		
	case 'news':
		if (!$newsID = NewsManager::getNewsEntryID($page['2']))
		{
			header('Location: ' . $config['website']['main_url']);
			exit;
		}
		
		$newsEntry = NewsManager::getInstance()->loadNewsEntry($newsID);
		
		//@todo: handle 404 error properly
		if (!$newsEntry)
		{
			header('Location: ' . $config['website']['main_url']);
			exit;
		}
		
		$layout = LayoutManager::buildPage(PAGE_NEWS_ENTRY, array('newsEntry' => $newsEntry, 'title' => $newsEntry['title'],
																	'keywords' => $newsEntry['keywords'], 'description' => $newsEntry['description']));
		
        break;
		
	case 'stats':
		include dirname(__FILE__) . '/libs/stats.php';
		
		$layout = LayoutManager::buildPage(PAGE_STATS, array('realms' => GetRealmStats()));
		
        break;
		
    default:
		$layout = LayoutManager::buildPage(PAGE_MAIN, array(
		
			'newsList' => NewsManager::getInstance()->loadNews(5)
			
			));
		
        break;
}

echo LayoutManager::render($layout);
