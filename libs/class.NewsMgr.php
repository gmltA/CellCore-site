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
	
	public function loadNews($size)
	{
		global $DB;

		$newsList = $DB->select('SELECT id, title, content, views, date FROM ?_news ORDER BY date DESC LIMIT ?d', $size);
		foreach ($newsList as $key=>$newsEntry)
		{
			$newsList[$key]['link'] = self::buildNewsURI($newsEntry);
		}
		
		return $newsList;
	}

	public function loadNewsEntry($id)
	{
		global $DB;
		
		$newsEntry = $DB->selectRow('SELECT id, title, content, keywords, views, date FROM ?_news WHERE id = ?d LIMIT 1', $id);
		$newsEntry['description'] = self::buildDescription($newsEntry['content']);
		
		return $newsEntry;
	}

	public function updateViewsCount($id)
	{
		global $DB;
		
		$newsList = $DB->query('UPDATE ?_news SET views = views + 1 WHERE id = ?d', $id);
	}
	
	private static function buildDescription($content)
	{
		return substr(preg_replace('/\<.+\>/', '', $content), 0, 200) . '...';
	}
	
	private static function buildNewsURI($newsEntry)
	{
		global $config;
		
		return $config['website']['main_url'].'news/' . $newsEntry['id'] . '-' . url_slug($newsEntry['title'], array('transliterate' => true)) . '/';
	}
}
