<?php
if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

$server_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']));
if (!$server_ajax)
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

if (isset($_POST['newsEntryID']))
{
	NewsManager::getInstance()->updateViewsCount($_POST['newsEntryID']);
}
elseif (isset($_POST['point']))
{
	global $config;
	
	$news = NewsManager::getInstance()->loadNews(5, $_POST['point']*5-5);
	
	$smarty = new Smarty_Studio($config['website']['template']);
	
	if (!$news)
	{
		echo 'empty';
		exit;
	}
	
	foreach ($news as $key => $newsEntry)
	{
		$smarty->assign('newsEntry', $newsEntry);
		echo $smarty->fetch('bricks/news.tpl');
	}
}
elseif (isset($_POST['search']))
{
	global $DB;
	global $config;
	
	$query = explode(' ', $_POST['search']);
	$resultQuery = '';
	foreach($query as $key => $sub)
	{
		$resultQuery = $resultQuery . ' +' . $sub;
	}

	$result = $DB->select('SELECT id, title, content FROM ?_news WHERE MATCH(title, content, keywords) AGAINST(? IN BOOLEAN MODE) LIMIT 5', $resultQuery);
	$smarty = new Smarty_Studio($config['website']['template']);
	
	foreach ($result as $key => $newsEntry)
	{
		$result[$key]['link'] = $config['website']['main_url'].'news/' . $newsEntry['id'] . '-' . url_slug($newsEntry['title'], array('transliterate' => true)) . '/';
		$result[$key]['short'] = substr(preg_replace('/\<.+\>/', '', $newsEntry['content']), 0, 100) . '...';;
	}
	
	$smarty->assign('newsList', $result);
	echo $smarty->fetch('bricks/news_search.tpl');
}
