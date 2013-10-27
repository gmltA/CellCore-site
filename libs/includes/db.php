<?php
require_once dirname(__FILE__) . '/DbSimple/Connect.php';

global $config;

$DB = new DbSimple_Connect($config['db']['driver']['site'].'://'.$config['db']['user'].':'.$config['db']['password'].'@'.$config['db']['host'].'/'.$config['db']['db']);

$DB->setErrorHandler('databaseErrorHandler');
$DB->setIdentPrefix($config['db']['prefix']);

function databaseErrorHandler($message, $info)
{
    // ���� �������������� @, ������ �� ������.
    if (!error_reporting()) return;

    header('HTTP/1.1 503 Service Temporarily Unavailable');
        echo '<html><head><title>�������� �������� ����������</title></head><body><center>';
        echo '<br><br><br><br><h1><font color="#444444">��.</font></h1>';
        echo '<br><h2><font color="#444444">��������, �� ������� �� ��������� �������, �������� ����������.</font></h2>';
        echo '<br><h2><font color="#444444">���������� ����� ������� �����.</font></h2>';
        echo '<br><br><h3><font color="#444444">��� ������: '.$message.'</font></h3>';
        echo '</center></body></html>';

    exit();
}
