<?php

/**
 * Управление формами
 * 
 *
 * 02.06.2008 Fix select, regex, changeable
 * 17.07.2008 fix regex_email
 * 19.08.2008 minlength
 * 28.06.2008 form.select.type, select.required (NOT NULL)
 * 03.07.2008 label fixed
 * 07.07.2008 ctype -> is_numeric
 * 09.07.2008 пустая строка в select
 * 05.08.2008 changeable + required
 */

define('REGEX_EMAIL', '^[-0-9a-zA-Z_.]+@[-0-9a-zA-Z_.]+\.[a-zA-Z]{2,3}$');
define('REGEX_PHONE', '^[-0-9\(\)\s\+\,]{5,50}$');
define('REGEX_EMAIL_PHONE', '^(([-0-9a-z_.A-Z]+@[-0-9a-zA-Z_.]+\.[a-zA-Z]{2,3})|([-\s\+\d\,\(\)]{5,50}))$');
define('REGEX_USERNAME', '^[a-zA-Zа-яА-Я\s.ё]{5,50}$');
define('REGEX_SAFECHARS', '^[-a-zA-Zа-яА-Я0-9\s.\,\)\(ё]+$');


function form_set($form, $elem = NULL, $prop = NULL, $value = NULL) {
  global $forms;
  if ($prop) {
    $form[$elem][$prop] = $value;
    return;
  }

  if ($elem) {
    $elem = _form_escape($elem);
    $forms[$form][$elem['id']] = $elem;

    if ($elem['type'] == 'file') {
      $forms[$form]['header']['enctype'] = 'multipart/form-data';
      $forms[$form]['header']['method'] = 'post';
    }

    return;
  }

  // создаем новую форму
  $form = _form_escape($form);
  $form['type'] = 'header';
  $forms[$form['id']] = array('header' => $form);
}

function _form_escape($params) {
  $retarr = array();
  foreach($params as $var => $val) {
    $var = ltrim($var, '#');
    $retarr[$var] = $val;
  }
  return $retarr;
}

/**
 * form_get('myform')
 * form_get('myform', 'header');
 * form_get('myform', 'myelem', 'class="bla"');
 */
function form_get($form, $id = 'header', $misc = FALSE) {
  global $forms;

  if ($id == 'footer') {
    return '</form>';
  }

  $elem = $forms[$form][$id];
  $elem['name'] = $elem['id'];

  switch ($elem['type']) {
    case 'header':
      unset($elem['type'], $elem['name']);
      return '<form' . _form_propsline($elem, $misc) . '><input type="hidden" name="' . $elem['id'] . '">'; 

    case 'textarea':
      $value = chk($elem, 'value');
      unset($elem['value']);
      return '<textarea' . _form_propsline($elem, $misc) . '>' . $value . '</textarea>';

    // если передан label - то возвращаем массив
    case 'checkbox':
      $checked = chk($elem, 'checked') ? ' checked ' : '';
      $disabled = chk($elem, 'disabled') ? ' disabled ' : '';
      $label = chk($elem, 'label');

      unset($elem['checked'], $elem['disabled'], $elem['label']);

      return $label ? array('checkbox' => '<input' . _form_propsline($elem, $misc . $checked . $disabled) . '>',
                                   'label' => '<label for=' . $elem['id'] . '>' . $label . '</label>') :
                           '<input' . _form_propsline($elem, $misc . $checked . $disabled) . '>';


    case 'select':
      $options = $elem['options'];
      $values = (array) chk($elem, 'value');
      if ($multiple = chk($elem, 'multiple')) {
        $multiple = 'multiple';
        $elem['name'] = $elem['name'] . '[]';
      }

      unset($elem['options'], $elem['value'], $elem['multiple'], $elem['type']); 

      foreach ($options as $k => $v) {
        $sel = in_array($k, $values) ? 'selected' : '';
        $options[$k] = "<option value=\"$k\" $sel>$v";
      }
     
      return '<select' . _form_propsline($elem, $misc) . ' ' . $multiple . '>' . implode('', $options) . '</select>';

    case 'textgroup':
      $values = (array) chk($elem, 'value');
      $options = $elem['options'];

      $id = $elem['id'];
      $elem['type'] = 'text';
      unset($elem['id'], $elem['options'], $elem['value']);

      $retarr = array();

      foreach ($options as $name => $value) {

        $elem['value'] = isset($values[$name]) ? $values[$name] : $value;
        $elem['name'] = $id . '[' . $name . ']';
        $elem['id'] = $id . '_' . $name;

        $retarr[$name] = '<input' . _form_propsline($elem, $misc) . '>';
        unset($elem['id'], $elem['value'], $elem['name']);
      }
      return $retarr; 

    case 'selectgroup':
      $values = (array) chk($elem, 'value');
      $options = $elem['options'];
      $elem['type'] = 'select';
      $id = $elem['id'];
      unset($elem['id'], $elem['options'], $elem['value']);

      $retarr = array();

      foreach ($options as $name => $opt) {

        $elem['name'] = $id . '[' . $name . ']';
        $elem['id'] = $id . '_' . $name;
        $selected = chk($values, $name);

        foreach ($opt as $k => $v) {

//if ($k === 0 && $selected === 0) die('sssssss');

          $sel = $selected !== '' && $k == $selected ? 'selected="selected"' : '';

          $opt[$k] = "<option value=\"$k\" $sel>$v";
        }
        $retarr[$name] = '<select' . _form_propsline($elem, $misc) . '>' . implode('', $opt) . '</select>';
      }   

      return $retarr;

    case 'radiogroup':
      $elem['type'] = 'radio';

    case 'checkboxgroup':
      $options = $elem['options'];
      $checked = (array) chk($elem, 'value');
      $id = $elem['id'];
      $elem['name'] = $elem['type'] == 'radio' ? $id : $id . '[]';
      $elem['type'] = $elem['type'] == 'radio' ? 'radio' : 'checkbox';
      unset($elem['options'], $elem['checked'], $elem['id']);

      $retarr = array();
      foreach ($options as $value => $label) {
        $elem['value'] = $value;
        $elem['id'] = $id . '_' . $value;
        $chk = in_array($value, $checked) ? ' checked ' : '';
        $retarr[$value] = array('checkbox' => '<input' . _form_propsline($elem, $misc . $chk) . '>',
                                         'label' => '<label for=' . $elem['id'] . '>' . $label . '</label>');
        unset($elem['value'], $elem['id']);
      }   
      return $retarr;

    case 'image':
    case 'submit':
      // fix bug umbigues: id & name & type
      unset($elem['id']);

    case 'file':
    default:
      return '<input' . _form_propsline($elem, $misc) . ' >';

  }
}

function _form_propsline($elem, $misc) {
  $retval = '';
  foreach($elem as $var => $val) {
    $retval .= " $var=\"$val\"";
  }
  return $retval . ' ' . $misc;
}

/**
 * Выбираем значения формы: все или по полю
 */
function form_values($form, $elem = FALSE, $prop = FALSE) {
  global $forms;

  if ($prop) {
    return chk($forms[$form][$elem], $prop);
  }

  if ($elem) {
    return chk($forms[$form][$elem], 'value');
  }


  $retval = array();
  foreach ($forms[$form] as $var => $val) {
    if ($val['type'] == 'header' || $val['type'] == 'submit') {
      continue;
    }

    $retval[$var] = chk($val, 'value');
  }
  return $retval;
}




function form_validate($form) {
  global $forms;
  $valid = TRUE;

  // ищем скрытое поле - флаг отправки формы
  if (!isset($_REQUEST[$form])) {
    return FALSE;
  }

  $form = &$forms[$form];
  foreach ($form as $id => $elem) {
    if ($elem['type'] == 'header' || $elem['type'] == 'submit') {
      continue;
    }

    if ($elem['type'] == 'file') {
      $form[$id]['value'] = array($_FILES[$id]['tmp_name'], basename($_FILES[$id]['name']));
      continue;
    }

    // элементы этого типа между собой мало чем связаны
    // проверяем каждое значение поля
    if ($elem['type'] == 'textgroup') {
      $tmp = $elem;
      $tmp['type'] = 'text';
      unset($tmp['options'], $tmp['value']);
      $elem_id = $elem['id'];
     
      foreach ($elem['options'] as $var => $opt) {
        $r = chk($_REQUEST, $elem_id);
        $r = chk($r, $var);

        if (!_form_validate($tmp, $r)) { 
          $form[$id]['options'][$var] = '';
          $valid = FALSE;
        }
        else {
          $form[$id]['options'][$var] = $r;
          $form[$id]['value'][$var] = $r;
        }
      }
      // проверили поля нашег элемента и переходим к следующему элементу
      continue;
    }

    if ($elem['type'] == 'selectgroup') {
      $tmp = $elem;
      $tmp['type'] = 'text';
      unset($tmp['options'], $tmp['value'], $form[$id]['value']);
      $elem_id = $elem['id'];

      foreach ($elem['options'] as $var => $opt) {
        $r = chk($_REQUEST, $elem_id);
        $r = chk($r, $var);

        // если поле required, оно не может быть NULL
        if (chk($elem, 'required') && $r == '') {
          $valid = FALSE;
          $form[$id]['value'][$var] = '';  
          continue;
        }

        $form[$id]['value'][$var] = $r;
        
      }

      continue;
    }

    $value = chk($_REQUEST, $id);

    // если элемент принадлежит к группе,
    // проверяем его наличие в группе
    if ($elem['type'] == 'checkboxgroup' || $elem['type'] == 'radiogroup' || $elem['type'] == 'select') {


      // если поле required, оно не может быть NULL
      if (!chk($elem, 'required') && !$value) {
       $form[$id]['value'] = NULL;  
        continue;
      }



      elseif (chk($elem, 'required') && ($value === NULL || $value === '')) {
        $valid = FALSE;
        continue;
      }



      if (!chk($elem, 'changeable')) {
        foreach ((array) $value as $v) {
          if (!array_key_exists($v, $elem['options'])) {
            $valid = FALSE;
            continue;
          }
        }
      }


    }
    // textarea, text
    elseif (!_form_validate($elem)) {
      $valid = FALSE;
      continue;
    }


    // вставляем правильный результат
    $form[$id]['value'] = chk($_REQUEST, $id);  
  }

  return $valid;
}



function _form_validate($elem, $value = NULL) {
  $valid = TRUE;
  $id = $elem['id'];
  $value = !is_null($value) ? $value : chk($_REQUEST, $id);


  // если не возвращено значение, но элемент обязательный
  if (!$value) {
    return chk($elem, 'required') ? FALSE : TRUE;
  }

  foreach ($elem as $rule => $rulval) {
    switch ($rule) {
      case 'reg_ex':
        $valid = preg_match('/' . $rulval . '/', $value) ? $valid : FALSE;
        break;

      case 'numeric':
        list ($from, $to) = explode(',', $rulval);
        $valid = is_numeric($value) ? $valid : FALSE;
        $value = (int) $value;
        $valid = ($value >= $from && $value <= $to) ? $valid : FALSE;
        break;

      case 'alpha':
        $valid = ctype_alpha($value) ? $valid : FALSE;
        break;

      case 'alnum':
        $valid = ctype_alnum($value) ? $valid : FALSE;
        break;

      case 'maxlength':
        $valid = strlen($value) <= $rulval ? $valid : FALSE;
        break;

      case 'minlength':
        $valid = strlen($value) >= $rulval ? $valid : FALSE;
        break;

      case 'less':
        $valid = $value < chk($_REQUEST, $rulval) ? $valid : FALSE;
        break;

      case 'equal':
        $valid = $value === chk($_REQUEST, $rulval) ? $valid : FALSE;
        break;

      case 'great':
        $valid = $value > chk($_REQUEST, $rulval) ? $valid : FALSE;
        break;
    }
  }

  return $valid;
}

/*

form_set(
  array(
    '#id' => 'my_form',
    '#action' => '',
    '#method' => 'post',
    '#js' => true
  )
);

form_set('my_form',
  array(
    '#id' => 'email',
    '#type' => 'text',
    '#required' => true,
    '#message' => 'error message',
    '#reg_ex' => REGEX_EMAIL
  )
);

form_set('my_form',
  array(
    '#id' => 'sf',
    '#type' => 'select',
    '#options' => array('hello', 'world'),
    'multiple' => true
  )
);
*/