<?php
global $config;

$config['db']['host']                        = 'localhost';
$config['db']['user']                        = 'root';
$config['db']['password']                    = '';
$config['db']['db']                          = 'cabinet_db';
$config['db']['prefix']                      = 'site_';
$config['db']['driver']['site']              = 'mysql'; //values: mysql, mypdo

$config['website']['template']               = 'master'; // шаблон

$config['website']['main_url']               = 'http://localhost:81/';
$config['website']['session_domain']         = '.riverrise.net';

$config['website']['content_dir']            = 'content'; // CMS content directory (e.g. /content/...)

$config['website']['app_name']               = 'CellCore-site';
$config['website']['app_descr']              = 'Раскопатор';

$config['website']['locale']             	 = 'ru';

//$config['catalog_o']

$config['debug']                             = '0';
