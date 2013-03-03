<?php

include_once dirname(__FILE__) . '/database.mysql.inc.php';

function db_is_active() {
  global $db_active;
  return is_resource($db_active);
}

function db_set_active($name = '') {
  global $db_active;
  // хранимые соединения
  static $db_conns;

  if (!isset($db_conns['conn' . $name])) {

    if (!$c = db_connect(conf_get('db' . $name))) {
      header_unavailable();
      trigger_error('db connection failed');
      exit;
    }

  $db_conns['conn' . $name] = $c;
  }

  // сохраняем имя предыдущего соединения
  $db_previous = $db_active;
  // делаем активным новое соединение
  $db_active = $db_conns['conn' . $name];

  // возвращаем ключ (название) последнего соединения (для его последующего восстановления)
  return array_search($db_previous, $db_conns);
}

/**
 * Функция отправки запроса. Пользуется вспомогательными функциями в подключенных файлах
 * получает запрос вида db_query('SELECT * FROM table WHERE id = %d, string = %s, float = %f', 15, 'str', 15.2);
 * чтобы выключить unbuffered_query: db_query(FALSE, 'SELECT * ... ', 'params');
 */
function db_query() {
  if (!db_is_active()) {
    db_set_active();
  }
  
  // данные для подстановки в запрос
  $args = func_get_args();

  $unbuffered = FALSE;

  // нужно вычленить query и flag of unbuffered (если есть)
  $query = array_shift($args);
  if (is_bool($query)) {
    $unbuffered = $query;
    $query = array_shift($args);
  }


  // заносим в функцию данные (инициализируем), чтобы не использовать глобальные
  // переменные, или сложную конструкцию в preg_replace
  _db_query_callback($args, TRUE);
  // подставляем вместо % значения, найденные результаты по порядку отправляются в
  // callback функцию, а там выбираются из посланных ранее аргументов в зависимости от знака после %
  $query = preg_replace_callback('/(%d|%s|%%|%f)/', '_db_query_callback', $query);
  
  // подставляем вместо {table} таблицу с нужным префиксом prefix_table
  $query = preg_replace('/\{([-a-zA-Z0-9_]*?)\}/', conf_get('db_prefix') . '$1', $query);

  // отлаживаем запросы
  if ($db_debug = conf_get('db_debug', FALSE)) {
    timer_start('db_debug');
  }

  $result = _db_query($query, $unbuffered);

  if ($db_debug) {
    echo '<p>query: '. $query
        .  '<br />rows: ' . db_num_rows($result) 
        .  '<br />error: ' . db_error()
        .  '<br />time: '. timer_read('db_debug') 
        .  '</p>';
  }

  if ($error = db_error()) {
    trigger_error($error, E_USER_WARNING);
  }

  return $result;
}

function _db_query_callback($match, $init = FALSE) {
  static $args = NULL;
  if ($init) {
    $args = $match;
    return;
  }

  switch ($match[1]) {
    case '%d':
      return (int) array_shift($args);
    case '%s':
      return db_escape_string(strval(array_shift($args)));
    case '%%':
      return '%';
    case '%f':
      return db_escape_string(strtr(floatval(array_shift($args)), ',', '.'));
  }
}
