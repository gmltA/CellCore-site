<?php
/*
 * Убрал проверку, поддерживает ли сервер mysql
 * Добавил set_names, NULL вместо FALSE
 */

function db_connect($set) {

  if (!$conn = mysql_connect($set['server'], $set['username'], $set['password'], TRUE)) {
    return FALSE;
  }

  if (!mysql_select_db($set['db'], $conn)) {
    return FALSE;
  }

  mysql_query("SET NAMES 'utf8';");
  return $conn;
}


/**
 * Определяем ошибку
 */
function db_error() {
  global $db_active;
  return mysql_error();
}

/**
 * Helper function for db_query()
 */
function _db_query($query, $unbuffered) {
  global $db_active;
  $query_type = strtoupper(substr(trim($query),0,6));

  // unbuffered - you can start working on the result set immediately after the first row 
  // has been retrieved: you don't have to wait until the complete SQL query has been performed.
  // Но нельзя послать такой запрос: foreach ($row = mysql_fetch_row()) query based on $row data
  $result = $unbuffered ? mysql_unbuffered_query($query, $db_active) : mysql_query($query, $db_active);

  if (db_error()) {
    trigger_error($query);
  }

  if ($result) {
    switch ($query_type) {
      case 'SELECT':
      case '(SELEC':
        return $result;
      case 'INSERT':
        return mysql_insert_id($db_active);
      default:
        return mysql_affected_rows($db_active);
    }
  }
  else {
    return NULL;
  }
}

/**
 * Количество записей
 */
function db_num_rows($result) {
  return mysql_num_rows($result);
}

/**
 * Получаем значение
 */
function db_fetch_array($result, $type = MYSQL_ASSOC) {
  $res = mysql_fetch_array($result, $type);
  return $res ? $res : NULL;
}

function db_fetch($result) {
  $res = db_fetch_array($result, MYSQL_NUM);
  return $res ? $res : NULL;
}

/**
 * Получение отдельной записи
 */
function db_result($result, $index = 0) {
  $row = mysql_fetch_row($result);
  mysql_free_result($result);
  return $row ? $row[$index] : NULL;
}

/**
 * Список, возможно возвращение поля по ключу
 */
function db_list($result, $key = FALSE, $delete_key = FALSE) {
  $ret = array();
  while ($r = db_fetch_array($result)) {
    if ($key) {
      $k = $r[$key];
      if ($delete_key) {
        unset($r[$key]);
      }
      $ret[$k] = $r;
    }
    else {
      $ret[] = $r;
    }
  }
  mysql_free_result($result);
  return $ret ? $ret : NULL;
}

/**
 * Список значений одного поля
 */
function db_rows($result) {
  $retval = array();
  while ($r = db_fetch($result)) {
    $retval[] = $r[0];
  }
  mysql_free_result($result);
  return $retval ? $retval : NULL;
}

/**
 *
 */
function db_hash($result, $name, $value) {
  $ret = array();
  while ($r = mysql_fetch_array($result, MYSQL_ASSOC)) {  
    $n = $r[$name];
    $v = $r[$value];     
    $ret[$n] = $v;
  }
  mysql_free_result($result);
  return $ret ? $ret : NULL;
}


/**
 * Затронуто
 */
function db_affected_rows() {
  global $db_active;
  return mysql_affected_rows($db_active);
}

/**
 * Экранируем
 */
function db_escape_string($text) {
  global $db_active;
  return "'". mysql_real_escape_string($text, $db_active) ."'";
}

/**
 * Проверка на существование таблицы
 */
function db_table_exists($table) {
  return db_num_rows(db_query("SHOW TABLES LIKE '$table'"));
}

function db_close() {
  global $db_active;
  mysql_close($db_active);
}

function db_free_result($result) {
  return mysql_free_result($result);
}