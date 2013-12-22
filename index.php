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
			$w = array();
			$filter = array();
			$filter['category'] = $_POST['filter_category'] ? $_POST['filter_category'] : '';
			$filter['material'] = $_POST['filter_material'] ? $_POST['filter_material'] : '';
			$filter['district'] = $_POST['filter_district'] ? $_POST['filter_district'] : '';
			$filter['town'] = $_POST['filter_town'] ? $_POST['filter_town'] : '';
			$filter['digging'] = $_POST['filter_dig'] ? $_POST['filter_dig'] : '';
			$filter['year'] = $_POST['filter_year'] ? $_POST['filter_year'] : '';
			$filter['title'] = $_POST['filter_title'] ? $_POST['filter_title'] : '';
			if (($_POST['filter_category']))
			{
				$w[] = "category='" . $filter['category'] . "'";
			}
			if (($_POST['filter_material']))
			{
				$w[] = "material='" . $filter['material'] . "'";
			}
			if (($_POST['filter_district']))
			{
				$w[] = "district='" . $filter['district'] . "'";
			}
			if (($_POST['filter_town']))
			{
				$w[] = "town='" . $filter['town'] . "'";
			}
			if (($_POST['filter_dig']))
			{
				$w[] = "digging='" . $filter['digging'] . "'";
			}
			if (($_POST['filter_year']))
			{
				$w[] = "year='" . $filter['year'] . "'";
			}
			if (($_POST['filter_title']))
			{
				$w[] = "title='" . $filter['title'] . "'";
			}
			$query = implode($w, ' AND ');

		if ($query)
		{
			$query = ' WHERE ' . $query;
		}
		
		$hasFilter = false;
		
		foreach ($filter as $key => $value)
		{
			if ($value != '')
				$hasFilter = true;
		}

		$layout = LayoutManager::buildPage(PAGE_CATALOG_SEARCH, array(

				'items' 	=> Catalog::getInstance()->searchItems($query),
				'filterContent' => Catalog::getInstance()->getFilters(),
				'isFilterApplied' => $hasFilter,
				'filterTokens' => $filter,
				'query' 	=> preg_replace ('/\+/', ' ', $query),
				'searchResult' 	=> 1
		));
		break;

	case 'about':
		$layout = LayoutManager::buildPage(PAGE_ABOUT);

		break;
	
	case 'catalog':
		if (!$page['2'])
		{
			header('Location: ' . $config['website']['main_url'] . 'catalog/page/1');
			exit;
		}

		if ($page['2'] == 'page')
		{
			if (!is_numeric($page['3']))
			{
				header('Location: ' . $config['website']['main_url'] . 'catalog/page/1');
				break;
			}

			if ($items = Catalog::getInstance()->loadItems(5, $page['3']*5-5))
			{
				$layout = LayoutManager::buildPage(PAGE_CATALOG_PART, array(

					'items' => $items,
					'filterContent'=> Catalog::getInstance()->getFilters(),
					'dbSize' => Catalog::getInstance()->getDBSize(),
					'pagination' => Catalog::getInstance()->buildPagination($page['3'])

				));
				break;
			}
			else
			{
				header('Location: ' . $config['website']['main_url'] . 'catalog/page/1');
				break;
			}
		}
		else if ($page['2'] == 'object')
		{
			if (!is_numeric($page['3'])) // @todo: handle 404
			{
				if ($_SERVER['HTTP_REFERER'])
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				else
					header('Location: ' . $config['website']['main_url'] . 'catalog/page/1');

				break;
			}

			if ($item = Catalog::getInstance()->loadItem($page['3']))
			{
				$layout = LayoutManager::buildPage(PAGE_CATALOG_ITEM, array(

					'item' => $item,

				));
				break;
			}
			else // @todo: handle 404
			{
				header('Location: ' . $config['website']['main_url'] . 'catalog/page/1');
				break;
			}
		}
		
	case 'additem':
		if ($_POST['data'])
		{
			$data = $_POST['data'];
			foreach ($data as $key => $value)
			{
				if (!$value)
					unset($data[$key]);
			}
			$keys = implode(array_keys($data), ', ');
			$DB->query('INSERT INTO ?_catalog_items (' . $keys . ') VALUES (?a)', array_values($data));
			$layout = LayoutManager::buildPage(PAGE_CATALOG_ADD_ITEM, array(

					'result' => 'success',

				));
		}
		else
			$layout = LayoutManager::buildPage(PAGE_CATALOG_ADD_ITEM);

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
