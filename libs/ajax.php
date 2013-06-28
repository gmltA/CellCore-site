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

function updateViewsCount($newsEntryId)
{
	if (!$newsEntryId)
	{
		return false;
	}

	NewsManager::getInstance()->updateViewsCount($newsEntryId);
}

function loadNews($currentPoint)
{
	global $config;

	$news = NewsManager::getInstance()->loadNews(5, $currentPoint*5-5);

	$smarty = new Smarty_Studio($config['website']['template']);

	if (!$news)
	{
		return 'empty';
	}

	$newsRender = "";

	foreach ($news as $key => $newsEntry)
	{
		$smarty->assign('newsEntry', $newsEntry);
		$newsRender = $newsRender . $smarty->fetch('bricks/news.tpl');
	}

	return $newsRender;
}

function searchNews($searchPattern)
{
	global $DB;
	global $config;

	$result = NewsManager::getInstance()->searchNews($searchPattern, 5);

	$smarty = new Smarty_Studio($config['website']['template']);

	foreach ($result as $key => $newsEntry)
	{
		$result[$key]['link'] = $config['website']['main_url'].'news/' . $newsEntry['id'] . '-' . url_slug($newsEntry['title'], array('transliterate' => true)) . '/';
		$result[$key]['short'] = substr(preg_replace('/\<.+\>/', '', $newsEntry['content']), 0, 100) . '...';;
	}

	$smarty->assign('newsList', $result);
	return $smarty->fetch('bricks/news_search.tpl');
}

function postComment($newsEntryId, $commentBody, $commentSubject, $commentTopic)
{
	NewsCommentManager::getInstance()->postComment($newsEntryId, $commentBody, $commentSubject, $commentTopic);
	$comments = NewsCommentManager::getInstance()->loadComments($newsEntryId);
	$newsEntry = array();
	$newsEntry['comments'] = $comments;

	$smarty = new Smarty_Studio($config['website']['template']);
	$smarty->assign('newsEntry', $newsEntry);

	return $smarty->fetch('bricks/news_comment_list.tpl');
}

$action = $_REQUEST['action'];
switch ($action)
{
    case 'update_views':
        echo updateViewsCount($_REQUEST['newsEntryID']);
        break;
	case 'load_news':
        echo loadNews($_REQUEST['point']);
        break;
	case 'search':
        echo searchNews($_REQUEST['search']);
        break;
	case 'post_comment':
        echo postComment($_REQUEST['newsId'], $_REQUEST['body'], $_REQUEST['subject'], $_REQUEST['topic']);
        break;
}

exit;
