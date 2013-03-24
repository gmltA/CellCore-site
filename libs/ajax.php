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
	NewsManager::getInstance()->updateViewsCount($_POST['newsEntryID']);
elseif (isset($_POST['point']))
{
	global $config;
	
	$news = NewsManager::getInstance()->loadNews(5, $_POST['point']-5);
	
	$smarty = new Smarty_Studio($config['website']['template']);
	
	foreach ($news as $key => $newsEntry)
	{
		$smarty->assign('newsEntry', $newsEntry);
		echo $smarty->fetch('bricks/news.tpl');
	}
}
