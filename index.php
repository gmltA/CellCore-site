<?php
define('IS_IN_ENGINE', true);

require_once dirname(__FILE__) . '/libs/core.php';
require_once dirname(__FILE__) . '/revision_n';

global $user;
global $config;

$page = explode('/', $_SERVER['REQUEST_URI']);

switch ($page['1'])
{
	case 'ajax':
		include dirname(__FILE__) . '/libs/ajax.php';
		exit;

	case 'news':
		if (!$page['2'])
		{
			$layout = LayoutManager::buildPage(PAGE_NEWS, array(

				'newsList' => NewsManager::getInstance()->loadNews(5)

			));
			break;
		}

		if ($page['2'] == 'page')
		{
			if (!is_numeric($page['3']))
			{
				header('Location: ' . $config['website']['main_url'] . 'news/');
				break;
			}

			if ($newsPage = NewsManager::getInstance()->loadNews(5, $page['3']*5-5))
			{
				$layout = LayoutManager::buildPage(PAGE_NEWS_PART, array(

					'newsList' => $newsPage,
					'pagination' => NewsManager::getInstance()->buildPagination($page['3'])

				));
				break;
			}
			else
			{
				header('Location: ' . $config['website']['main_url'] . 'news/');
				break;
			}
		}

		$newsID = NewsManager::getNewsEntryID($page['2']);

		if (!$newsID && $page['2'])
		{
			header('Location: ' . $config['website']['main_url'] . 'news/');
			break;
		}

		$newsEntry = NewsManager::getInstance()->loadNewsEntry($newsID);

		if (!$newsEntry)
		{
			$layout = LayoutManager::buildPage(PAGE_ERROR_404);
			break;
		}

		$layout = LayoutManager::buildPage(PAGE_NEWS_ENTRY, array('newsEntry' => $newsEntry, 'title' => $newsEntry['title'],
																	'keywords' => $newsEntry['keywords'], 'description' => $newsEntry['description']));

		break;

	case 'search':
		$query = '';
		if (isset($_POST['search_query']))
		{
			$query = $_POST['search_query'];
		}
		elseif (isset($page['2']))
		{
			$query = $page['2'];
		}

		if ($query == '')
		{
			header('Location: /');
			exit;
		}

		$layout = LayoutManager::buildPage(PAGE_NEWS_SEARCH, array(

				'newsList' 	=> NewsManager::getInstance()->searchNews($query),
				'query' 	=> preg_replace ('/\+/', ' ', $query)

		));
		break;
	case 'stats':
		include dirname(__FILE__) . '/libs/stats.php';

		$layout = LayoutManager::buildPage(PAGE_STATS, array('realms' => GetRealmStats()));

		break;

	case 'rules':
		$layout = LayoutManager::buildPage(PAGE_RULES);

		break;

	case 'core':
		$layout = LayoutManager::buildPage(PAGE_CORE);

		break;

	case 'about':
		$layout = LayoutManager::buildPage(PAGE_ABOUT);

		break;


	case '':
	case 'main':
		$newsList = NewsManager::getInstance()->loadNews(3);
		if ($newsList)
		{
			$layout = LayoutManager::buildPage(PAGE_MAIN, array(

				'newsList' => NewsManager::getInstance()->loadNews(3)

				));
		}
		else
		{
			$layout = LayoutManager::buildPage(PAGE_MAIN, array());
		}

		break;

	default:
		$layout = LayoutManager::buildPage(PAGE_ERROR_404);

		break;
}

echo LayoutManager::render($layout);
