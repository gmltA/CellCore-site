<?php
function conf_get($n, $d = NULL) {
  global $_conf;
  return isset($_conf[$n]) ? $_conf[$n][0] : $d;
}

function conf_set($n, $v) {
  global $_conf;
  isset($_conf[$n]) ? array_unshift($_conf[$n], $v) : $_conf[$n][0] = $v;
}

function conf_restore($n) {
  global $_conf;
  return (isset($_conf[$n]))  ? array_shift($_conf[$n]) : null;
}

// настройки подключения к БД
conf_set('db', array(
  'server' => 'localhost',
  'username' => 'web_site',
  'password' => 'siteweb_73',
  'db' => 'realmd',
));

// Character database
conf_set('db_character_fun', array(
  'server' => 'localhost', 
  'username' => 'web_site',
  'password' => 'siteweb_73', 
  'db' =>'tcharx30',
));

conf_set('db_character_x1', array(
  'server' => 'localhost', 
  'username' => 'web_site',
  'password' => 'siteweb_73', 
  'db' =>'tcharfun',
));

conf_set('db_character_x100', array(
  'server' => 'localhost', 
  'username' => 'web_site',
  'password' => 'siteweb_73', 
  'db' =>'tcharx100',
));


conf_set('db_character_x4', array(
  'server' => 'localhost', 
  'username' => 'web_site',
  'password' => 'siteweb_73', 
  'db' =>'tcharx4',
));

conf_set('db_forum', array(
  'server' => 'localhost', 
  'username' => 'web_site',
  'password' => 'siteweb_73', 
  'db' =>'forum',
));

conf_set('db_site', array(
  'server' => 'localhost',
  'username' => 'web_site',
  'password' => 'siteweb_73',
  'db' => 'cabinet_db',
));

?>
