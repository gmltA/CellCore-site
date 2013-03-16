<?php
require_once ('libs/db.php');
require_once ('libs/smarty.php');
require_once ('libs/defines.php');
require_once ('libs/class.User.php');
require_once ('libs/class.AuthMgr.php');

function loadNews($size)
{
	global $DB;
	
	$newsList = $DB->select('SELECT id, title, content, date FROM ?_news ORDER BY date DESC LIMIT ?d', $size);
	foreach ($newsList as $key=>$newsEntry)
	{
		$newsList[$key]['link'] = $config['website']['main_url'].'news/'.$newsEntry['id'];
	}
	
	return $newsList;
}

function loadNewsEntry($id)
{
	global $DB;
	
	$newsEntry = $DB->selectRow('SELECT id, title, content, keywords, date FROM ?_news WHERE id = ?d LIMIT 1', $id);
	
	return $newsEntry;
}
?>