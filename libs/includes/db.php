<?php
require_once dirname(__FILE__) . '/DbSimple/Connect.php';

global $config;

$DB = new DbSimple_Connect($config['db']['driver']['site'].'://'.$config['db']['user'].':'.$config['db']['password'].'@'.$config['db']['host'].'/'.$config['db']['db']);

$DB->setErrorHandler('databaseErrorHandler');
$DB->setIdentPrefix($config['db']['prefix']);

$fDB = new DbSimple_Connect($config['db']['driver']['site'].'://'.$config['db']['user'].':'.$config['db']['password'].'@'.$config['db']['host'].'/'.$config['db']['forum_db']);

$fDB->setErrorHandler('databaseErrorHandler');
$fDB->setIdentPrefix($config['db']['forum_prefix']);

$rDB = array();
$cDB = array();
$wDB = array();
foreach ($config['realms'] as $key=>$realm)
{
    $rDB[$key] = new DbSimple_Connect($config['db']['driver']['realm'].'://'.$realm['db_user'].':'.$realm['db_pass'].'@'.$realm['db_host'].'/'.$realm['db']);
    $rDB[$key]->setErrorHandler('databaseErrorHandler');

    $cDB[$key] = new DbSimple_Connect($config['db']['driver']['realm'].'://'.$realm['char_db_user'].':'.$realm['char_db_pass'].'@'.$realm['char_db_host'].'/'.$realm['char_db']);
    $cDB[$key]->setErrorHandler('databaseErrorHandler');
}

function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;

    header('HTTP/1.1 503 Service Temporarily Unavailable');
        echo '<html><head><title>Страница временно недоступна</title></head><body><center>';
        echo '<br><br><br><br><h1><font color="#444444">Ой.</font></h1>';
        echo '<br><h2><font color="#444444">Страница, на которую вы пытаетесь попасть, временно недоступна.</font></h2>';
        echo '<br><h2><font color="#444444">Попробуйте зайти немного позже.</font></h2>';
        echo '<br><br><h3><font color="#444444">Код ошибки: '.$message.'</font></h3>';
        echo '</center></body></html>';

    exit();
}
