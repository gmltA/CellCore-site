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

$config['realms'] = array();

$config['realms'][] = array(
                    'name'=>'Frostmourne',  // Название реалма
                    'type'=>0, 
                    'rates'=>'x4',  // Рейты реалма
                    'gamebuild'=>'3.3.5.12340',  // Версия билда
                    'name_img'=>'',
                    'realmlist'=>'',   // Реалмлист

                    //status checker settings
                    'realm_host'=>'1',  // ид реалма
                    'realm_port'=>'8085',  // Порт логина стандарт 8085

                    //realmd database settings
                    'db_host'=>'localhost', // ип базы данных
                    'db_user'=>'root', // юзер
                    'db_pass'=>'root', // пароль
                    'db'=>'auth', // Название базы данных с аккаунтами

                    //world database settings
                    'world_db_host'=>'localhost', // ип базы данных
                    'world_db_user'=>'root', // юзер
                    'world_db_pass'=>'root', // пароль
                    'world_db'=>'world',      // Название базы данных с персонажеми

                    //characters database settings
                    'char_db_host'=>'localhost', // ип базы данных
                    'char_db_user'=>'root', // юзер
                    'char_db_pass'=>'root', // пароль
                    'char_db'=>'characters',      // Название базы данных мира
);

$config['local']                             = '1';
$config['debug']                             = '0';
?>
