<?php
global $config;

$config['db']['host']                        = 'localhost';
$config['db']['user']                        = 'root';
$config['db']['password']                    = '';
$config['db']['db']                          = 'cabinet_db';
$config['db']['prefix']                      = 'site_';
$config['db']['forum_db']                    = 'forum';
$config['db']['forum_prefix']                = 'ibf_';
$config['db']['driver']['site']              = 'mysql'; //values: mysql, mypdo
$config['db']['driver']['realm']             = 'mysql'; //values: mysql, mypdo

$config['website']['template']               = 'cell'; // шаблон

$config['website']['main_url']               = 'http://localhost:81/';
$config['website']['session_domain']         = '.riverrise.net';
$config['website']['panel_url']              = 'http://lk1.riverrise.net/';

$config['website']['content_dir']            = 'content'; // CMS content directory (e.g. /content/...)

$config['website']['app_name']               = 'CellCore-site';
$config['website']['app_descr']              = 'RiverRise.net | World of Warcraft.by';

$config['realms'] = array();

$config['realms'][] = array(
                    'name'			=>	'Frostmourne',             // Название реалма
                    'type'			=>	0,
                    'rates'			=>	'x4',                      // Рейты реалма (влияет на класс таблицы статистики)
                    'gamebuild'		=>	'3.3.5.12340',             // Версия билда
                    'name_img'		=>	'',
                    'realmlist'		=>	'logon.riverrise.net',     // Реалмлист

                    //status checker settings
                    'realm_host'	=>	'1',                      // ид реалма
                    'realm_port'	=>	'8085',                   // Порт логина стандарт 8085

                    //auth database settings
                    'db_host'		=>	'localhost',
                    'db_user'		=>	'root',
                    'db_pass'		=>	'',
                    'db'			=>	'auth',

                    //characters database settings
                    'char_db_host'	=>	'localhost',
                    'char_db_user'	=>	'root',
                    'char_db_pass'	=>	'',
                    'char_db'		=>	'characters',
);

$config['website']['banner_top']             = '1';
$config['website']['main_block']             = '2'; // 0 - static welcome block; 1 - slider/block; 2 - slider only

$config['local']                             = '1';
$config['debug']                             = '0';
