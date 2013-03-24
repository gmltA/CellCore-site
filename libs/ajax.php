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

updateViewsCount($_REQUEST['newsEntryID']);
