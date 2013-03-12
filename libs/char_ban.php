<?php
require_once dirname(__FILE__) . '/includes/config.php';

require_once dirname(__FILE__) . '/includes/database.inc.php';
require_once dirname(__FILE__) . '/includes/form.inc.php';

function get_ip() {
  if (!$ip = $_SERVER['REMOTE_ADDR']) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }

  return $ip == 'unknown' ? false : $ip;
}

form_set(
  array(
    '#id' => 'form',
    '#action' => '',
    '#method' => 'post',
    '#js' => true
  )
);


form_set('form',
  array(
    '#id' => 'name',
    '#type' => 'text',
    '#required' => true,
  )
);


form_set('form',
  array(
    '#id' => 'realms',
    '#type' => 'select',
    '#options' => array('key' => 'Rise of Fallen (x30)', 'key2' => 'Arena Tournament', 'key3' => 'Frostmourne (x4)'),
    '#selected' => 'key'
  )
);


form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Проверить'
  )
);

if (form_validate('form')) {
  $v = form_values('form');

  if ($v['realms'] == 'key') {
    db_set_active('_character_fun');// ативируем базу чаров

    if ($massiv = db_fetch_array(db_query('select t1.* from character_banned t1 inner join characters t2 ON t2.guid=t1.guid where t2.name=%s and active=1', $v['name']))) {

      $out = '';

      $out .= '<table style="font-size: 11px !important;">';
      $out .= '<tr><td width="20%" align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Ник: </td><td width="60%" style="color: red; text-shadow: 0px 0px 8px red;">'.$v['name'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.date("Y-m-d H:i:s", $massiv['bandate']).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата разбана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.($massiv['bandate'] == $massiv['unbandate'] ? 'Навсегда' : date("Y-m-d H:i:s", $massiv['unbandate'])).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Кем забанен: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['bannedby'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Причина бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['banreason'].'</td></tr>';
      $out .= '</table>';
    }
    else {
      $out .= '<table width="100%" style="margin-top: 50px;">';
      $out .= '<tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;"">Вам повезло, пока вас еще не забанили!</td></tr>';
      $out .= '</table>';
    }


  }

  if ($v['realms'] == 'key2') {
    db_set_active('_character_x1');// ативируем базу чаров

    if ($massiv = db_fetch_array(db_query('select t1.* from character_banned t1 inner join characters t2 ON t2.guid=t1.guid where t2.name=%s and active=1', $v['name']))) {

      $out = '';

      $out .= '<table style="font-size: 11px !important;">';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Ник: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$v['name'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.date("Y-m-d H:i:s", $massiv['bandate']).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата разбана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.($massiv['bandate'] == $massiv['unbandate'] ? 'Навсегда' : date("Y-m-d H:i:s", $massiv['unbandate'])).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Кем забанен: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['bannedby'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Причина бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['banreason'].'</td></tr>';
      $out .= '</table>';
    }
    else {
      $out .= '<table width="100%" style="margin-top: 50px;">';
      $out .= '<tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;"">Вам повезло, пока вас еще не забанили!</td></tr>';
      $out .= '</table>';
    }


  }

  if ($v['realms'] == 'key3') {
    db_set_active('_character_x4');// ативируем базу чаров

    if ($massiv = db_fetch_array(db_query('select t1.* from character_banned t1 inner join characters t2 ON t2.guid=t1.guid where t2.name=%s and active=1', $v['name']))) {

      $out = '';

      $out .= '<table width="100%" style="font-size: 11px !important;">';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Ник: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$v['name'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.date("Y-m-d H:i:s", $massiv['bandate']).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Дата разбана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.($massiv['bandate'] == $massiv['unbandate'] ? 'Навсегда' : date("Y-m-d H:i:s", $massiv['unbandate'])).'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Кем забанен: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['bannedby'].'</td></tr>';
      $out .= '<tr><td align="right" style="color: #01b2f1; text-shadow: 0px 0px 8px black;">'.'Причина бана: </td><td style="color: red; text-shadow: 0px 0px 8px red;">'.$massiv['banreason'].'</td></tr>';
      $out .= '</table>';
    }
    else {
      $out .= '<table width="100%" style="margin-top: 50px;">';
      $out .= '<tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;"">Вам повезло, пока вас еще не забанили!</td></tr>';
      $out .= '</table>';
    }
  }
};
?>

<?php if (isset($out)): ?>
<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <?php echo $out?>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<table width="100%" style="margin-left: 50px;">
  <tr><td align=right style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Реалм</td><td><?php echo form_get('form', 'realms', 'style="width: 170px"')?></td></tr>
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Ник</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','name', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  </td></tr>
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>
</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
