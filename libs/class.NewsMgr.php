<?php

class NewsManager
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
            self::$instance = new NewsManager();
        }

        return self::$instance;
    }

	public static function getNewsEntryID($request)
	{
		$newsLink = explode('-', $request);

		return ($newsLink['0'] && is_numeric($newsLink['0'])) ? $newsLink['0'] : false;
	}

	public function loadNews($count, $begin = 0)
	{
		global $DB;

		$newsList = $DB->select('SELECT id, title, thumbnail, content, views, date, commentsEnabled FROM ?_news ORDER BY date DESC LIMIT ?d, ?d', $begin, $begin + $count);

		if (!$newsList)
		{
			return false;
		}

		foreach ($newsList as $key=>$newsEntry)
		{
			$newsList[$key]['content'] = self::buildCutContent($newsEntry['content']);
			$newsList[$key]['commentsNumber'] = self::loadCommentsNumber($newsEntry['id']);
			$newsList[$key]['link'] = self::buildNewsURI($newsEntry);
		}

		return $newsList;
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

	public function searchNews($query, $limit = 0)
	{
		global $DB;

		$query = explode('+', $query);

		$resultQuery = '';
		foreach ($query as $key => $sub)
		{
			$resultQuery = $resultQuery . ' +' . $sub;
		}

		if ($limit == 0)
		{
			$matchedNews = $DB->select('SELECT id, title, content, views, date, commentsEnabled FROM ?_news WHERE MATCH(title, content, keywords) AGAINST(? IN BOOLEAN MODE) ORDER BY date DESC', $resultQuery);
		}
		else
		{
			$matchedNews = $DB->select('SELECT id, title, content, views, date, commentsEnabled FROM ?_news WHERE MATCH(title, content, keywords) AGAINST(? IN BOOLEAN MODE) ORDER BY date DESC LIMIT ?d', $resultQuery, $limit);
		}

		foreach ($matchedNews as $key=>$newsEntry)
		{
			$matchedNews[$key]['content'] = self::removeCutDelimiter($newsEntry['content']);
			$matchedNews[$key]['commentsNumber'] = self::loadCommentsNumber($newsEntry['id']);
			$matchedNews[$key]['link'] = self::buildNewsURI($newsEntry);
		}

		return $matchedNews;
	}

	public function buildPagination($page)
	{
		global $DB;

		$newsCount = $DB->selectCell("SELECT COUNT(id) FROM ?_news");
		$total = intval(($newsCount - 1) / 5) + 1;

		if (empty($page) || $page < 0)
		{
			$page = 1;
		}
		if ($page > $total)
		{
			$page = $total;
		}

		if ($page != 1) $pervpage = '<a href= ./1><<</a>
                               <a href= ./'. ($page - 1) .'><</a> ';
		// ��������� ����� �� ������� ������
		if ($page != $total) $nextpage = ' <a href= ./'. ($page + 1) .'>></a>
										   <a href= ./' .$total. '>>></a>';

		// ������� ��� ��������� ������� � ����� �����, ���� ��� ����
		if ($page - 2 > 0) $page2left = ' <a href= ./'. ($page - 2) .'>'. ($page - 2) .'</a> | ';
		if ($page - 1 > 0) $page1left = '<a href= ./'. ($page - 1) .'>'. ($page - 1) .'</a> | ';
		if ($page + 2 <= $total) $page2right = ' | <a href= ./'. ($page + 2) .'>'. ($page + 2) .'</a>';
		if ($page + 1 <= $total) $page1right = ' | <a href= ./'. ($page + 1) .'>'. ($page + 1) .'</a>';

		return $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
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
