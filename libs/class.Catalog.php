<?php

class Catalog
{
    protected static $instance;

    private function __construct()
	{
	}

    private function __clone()
	{
	}

    private function __wakeup()
	{
	}

    public static function getInstance()
	{
        if (is_null(self::$instance))
		{
            self::$instance = new Catalog();
        }

        return self::$instance;
    }

	public static function getNewsEntryID($request)
	{
		$newsLink = explode('-', $request);

		return ($newsLink['0'] && is_numeric($newsLink['0'])) ? $newsLink['0'] : false;
	}
	
	public function loadItem($itemID)
	{
		global $DB;

		$item = $DB->selectRow('SELECT id, thumbnail, image, category, material, monument, digging, year, title, code FROM ?_catalog_items WHERE id = ?d', $itemID);

		if (!$item)
		{
			return false;
		}

		return $item;
	}

	public function loadItems($count, $begin = 0)
	{
		global $DB;

		$itemList = $DB->select('SELECT id, thumbnail, image, category, material, monument, digging, year, title, code FROM ?_catalog_items ORDER BY id ASC LIMIT ?d, ?d', $begin, $count);

		if (!$itemList)
		{
			return false;
		}

		return $itemList;
	}

	public function loadNewsEntry($id)
	{
		global $DB;

		$newsEntry = $DB->selectRow('SELECT id, title, content, keywords, views, date, commentsEnabled FROM ?_news WHERE id = ?d LIMIT 1', $id);

		if (!$newsEntry)
		{
			return false;
		}

		$newsEntry['content'] = self::removeCutDelimiter($newsEntry['content']);

		$newsEntry['description'] = self::buildDescription($newsEntry['content']);
		$newsEntry['comments'] = array();
		if ($comments = NewsCommentManager::getInstance()->loadComments($id))
			$newsEntry['comments'] = $comments;

		return $newsEntry;
	}

	public function searchItems($query, $limit = 0)
	{
		global $DB;

		$query = explode('+', $query);

		$resultQuery = '';
		foreach ($query as $key => $sub)
		{
			$resultQuery = $resultQuery . ' ' . $sub;
		}

		if ($limit == 0)
		{
			$matchedItems = $DB->select('SELECT id, thumbnail, image, category, material, monument, digging, year, title, code FROM ?_catalog_items' . $resultQuery . ' ORDER BY id ASC');
		}
		else
		{
			$matchedItems = $DB->select('SELECT id, thumbnail, image, category, material, monument, digging, year, title, code FROM ?_catalog_items' . $resultQuery . ' ORDER BY id ASC LIMIT ?d', $limit);
		}

		return $matchedItems;
	}
	
	public function getCategories()
	{
		global $DB;
		
		$categories = $DB->select('SELECT id, name, caption_ru FROM ?_catalog_categories');

		return $categories;
	}

	public function buildPagination($page)
	{
		global $DB;

		$newsCount = $DB->selectCell("SELECT COUNT(id) FROM ?_catalog_items");
		$total = intval(($newsCount - 1) / 5) + 1;

		if (empty($page) || $page < 0)
		{
			$page = 1;
		}
		if ($page > $total)
		{
			$page = $total;
		}

		if ($page != 1) $pervpage = '<li><a href= ./1>&laquo;</a></li>
                               <li><a href= ./'. ($page - 1) .'><</a></li> ';
		// Проверяем нужны ли стрелки вперед
		if ($page != $total) $nextpage = '<li><a href= ./'. ($page + 1) .'>></a></li>
										   <li><a href= ./' .$total. '>&raquo;</a></li>';

		// Находим две ближайшие станицы с обоих краев, если они есть
		if ($page - 2 > 0) $page2left = '<li><a href= ./'. ($page - 2) .'>'. ($page - 2) .'</a></li>';
		if ($page - 1 > 0) $page1left = '<li><a href= ./'. ($page - 1) .'>'. ($page - 1) .'</a></li>';
		if ($page + 2 <= $total) $page2right = '<li><a href= ./'. ($page + 2) .'>'. ($page + 2) .'</a></li>';
		if ($page + 1 <= $total) $page1right = '<li><a href= ./'. ($page + 1) .'>'. ($page + 1) .'</a></li>';

		return '<ul class="pagination">'.$pervpage.$page2left.$page1left.'<li class="active"><a>'.$page.'</a></li>'.$page1right.$page2right.$nextpage.'</ul>';
	}

	public function updateViewsCount($id)
	{
		global $DB;

		$newsList = $DB->query('UPDATE ?_news SET views = views + 1 WHERE id = ?d', $id);
	}

	private static function buildCutContent($content)
	{
		$content = preg_replace('/' . NOCUT_START . '(\w||\W)+' . NOCUT_END_R . '/', '', $content);
		return current(explode(CUT_DELIMITER, $content));
	}

	private static function removeCutDelimiter($content)
	{
		$target = array(CUT_DELIMITER, NOCUT_START, NOCUT_END);
		return str_replace($target, '', $content);
	}

	private static function buildDescription($content)
	{
		return cut_string(preg_replace('/\<.+\>/', ' ', $content), 200) . '...';
	}

	private static function buildNewsURI($newsEntry)
	{
		global $config;

		return $config['website']['main_url'].'news/' . $newsEntry['id'] . '-' . url_slug($newsEntry['title'], array('transliterate' => true)) . '/';
	}

	private static function loadCommentsNumber($newsEntryId)
	{
		global $DB;

		return $DB->selectCell('SELECT COUNT(id) FROM ?_news_comments WHERE newsId = ?d', $newsEntryId);
	}
}
