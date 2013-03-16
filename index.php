<?php
require_once ('libs/core.php');

global $AuthMgr;
$authMgr = new AuthManager();

global $user;
$user = $authMgr->checkAuth();

session_start();

$page = explode('/', $_SERVER['REQUEST_URI']);

global $smarty;
global $skins;
global $config;

switch ($page['1'])
{
    case 'news':
		if ($page['2'] && is_numeric($page['2']))
		{
			$newsEntry = loadNewsEntry($page['2']);
			//@todo: handle 404 error properly
			if (!$newsEntry)
			{
				header('Location: '.$config['website']['main_url']);
				exit;
			}

			$smarty->assign('forumSkin', $skins[$user->GetSkin()]);
			$smarty->assign('user', $user);
			$smarty->assign('userName', $user->GetDisplayName());
			$smarty->assign('debug', '0');
			$smarty->assign('newsEntry', $newsEntry);
			$smarty->assign('title', $newsEntry['title']);
			$smarty->assign('keywords', $newsEntry['keywords']);
			$smarty->assign('description', "Description");
			$smarty->assign('panelURL', $config['website']['panel_url']);
			$template = 'main_news.tpl';
		}
		else  // All news
		{
			header('Location: '.$config['website']['main_url']);
			exit;
		}
        break;
	case 'stats':
        break;
    default:
        $newsList = loadNews(5);

        $smarty->assign('forumSkin', $skins[$user->GetSkin()]);
        $smarty->assign('user', $user);
        $smarty->assign('userName', $user->GetDisplayName());
        $smarty->assign('debug', '0');
        $smarty->assign('pagen', 'main');
        $smarty->assign('title', 'Just a title');
        $smarty->assign('newsList', $newsList);
        $smarty->assign('panelURL', $config['website']['panel_url']);
        $template = 'main.tpl';
        break;
}

echo $smarty->fetch($template);
?>
