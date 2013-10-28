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

function getItemDetails($itemId)
{
	$item = Catalog::getInstance()->loadItem($itemId);

	$smarty = new Smarty_Studio($config['website']['template']);
	$smarty->assign('item', $item);

	return $smarty->fetch('bricks/catalog_item_data.tpl');
}

$action = $_REQUEST['action'];
switch ($action)
{
	case 'get_item_details':
        echo getItemDetails($_REQUEST['itemId']);
        break;
}

exit;
