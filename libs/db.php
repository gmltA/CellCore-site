<?php
require_once dirname(__FILE__) . '/includes/config.php';
require_once dirname(__FILE__) . '/includes/DbSimple/Connect.php';

global $config;

$DB = new DbSimple_Connect($config['db']['driver']['site'].'://'.$config['db']['user'].':'.$config['db']['password'].'@'.$config['db']['host'].'/'.$config['db']['db']);

$DB->setErrorHandler('databaseErrorHandler');
$DB->setIdentPrefix($config['db']['prefix']);

$fDB = new DbSimple_Connect($config['db']['driver']['site'].'://'.$config['db']['user'].':'.$config['db']['password'].'@'.$config['db']['host'].'/'.$config['db']['forum_db']);

$fDB->setErrorHandler('databaseErrorHandler');
$fDB->setIdentPrefix($config['db']['forum_prefix']);

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
?>
