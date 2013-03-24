<?php
global $config;

$config['db']['host']                        = 'localhost';
$config['db']['user']                        = 'root';
$config['db']['password']                    = 'root';
$config['db']['db']                          = 'cabinet_db';
$config['db']['prefix']                      = 'site_';
$config['db']['forum_db']                    = 'forum';
$config['db']['forum_prefix']                = 'ibf_';
$config['db']['driver']['site']              = 'mysql'; //values: mysql, mypdo
$config['db']['driver']['realm']             = 'mysql'; //values: mysql, mypdo

$config['website']['template']               = 'cell'; // шаблон

$config['website']['main_url']               = 'http://localhost:81/';
$config['website']['panel_url']              = 'http://lk1.riverrise.net/';

$config['website']['app_descr']              = 'RiverRise.net | World of Warcraft.by'; 

$config['realms'] = array();

$config['realms'][] = array(
                    'name'=>'Frostmourne',                  // Название реалма
                    'type'=>0, 
                    'rates'=>'x4',                          // Рейты реалма (влияет на класс таблицы статистики)
                    'gamebuild'=>'3.3.5.12340',             // Версия билда
                    'name_img'=>'',
                    'realmlist'=>'logon.riverrise.net',     // Реалмлист

                    //status checker settings
                    'realm_host'=>'1',                      // ид реалма
                    'realm_port'=>'8085',                   // Порт логина стандарт 8085

                    //realmd database settings
                    'db_host'=>'localhost',
                    'db_user'=>'root',
                    'db_pass'=>'root',
                    'db'=>'auth',

                    //world database settings
                    'world_db_host'=>'localhost',
                    'world_db_user'=>'root',
                    'world_db_pass'=>'root',
                    'world_db'=>'world',

                    //characters database settings
                    'char_db_host'=>'localhost',
                    'char_db_user'=>'root',
                    'char_db_pass'=>'root',
                    'char_db'=>'characters',
);

$config['local']                             = '1';
$config['debug']                             = '0';
