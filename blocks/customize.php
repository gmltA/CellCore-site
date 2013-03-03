<?php
require_once dirname(__FILE__) . '/includes/config.php';

require_once dirname(__FILE__) . '/includes/database.inc.php';
require_once dirname(__FILE__) . '/includes/form.inc.php';

function get_ip()
{
    if (!$ip = $_SERVER['REMOTE_ADDR'])
    {
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
    '#id' => 'world',
    '#type' => 'select',
    '#options' => array(1 => 'Rise of Fallen (PvP x30)', 3 => 'Arena Tournament', 2 => 'Frostmourne (PvP x4)'),
    '#required' => true
  )
);


form_set('form',
  array(
    '#id' => 'name',
    '#type' => 'text',
    '#required' => true
  )
);


form_set('form',
  array(
    '#id' => 'pass',
    '#type' => 'password',
    '#required' => true
  )
);


form_set('form',
  array(
    '#id' => 'nick',
    '#type' => 'text',
    '#required' => true
  )
);

form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Изменить внешность'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

  db_set_active('');
  if ($account=db_fetch_array(db_query('SELECT id, username, sha_pass_hash FROM account WHERE username=%s', $v['name']))) {

    $pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
    if ($pass == $account['sha_pass_hash'])
    {
        switch ($v['world'])
        {
            case 1:
                db_set_active('_character_fun');
                $critap = 3000;
                $critfrost = 125;
                break;
            
            case 2:
                db_set_active('_character_x4');
                $critap = 3000;
                $critfrost = 80;
                break;
            
            case 3:
                db_set_active('_character_x1');
                $critap = 500;
                $critfrost = 20;
                break;
        }

        if ($character=db_fetch_array(db_query('SELECT * FROM characters WHERE name=%s',$v['nick'])))
        {
            if ($character['online']==1)
            {
                $online=true;
                break;
            }

            if ($character['account']!=$account['id'])
            {
                $miss = true;
                break;
            }

            if ($jail=db_result(db_query('SELECT times FROM jail WHERE guid=%s', $character['guid'])))
            {
                if ($jail>0)
                {
                    $wanted = true;
                    break;
                }	  
            }

            $ap = $character['arenaPoints'];
            $frost =  db_result(db_query('SELECT `count` FROM item_instance WHERE (itemEntry=49426 and owner_guid=%s)', $character['guid']));

            if ($ap<$critap)
            {
                $noap = true;
                break;
            }

            if ($frost<$critfrost)
            {
                $nofrost = true;
                break;
            }

            db_query('UPDATE characters SET at_login=%s WHERE name=%s',8, $v['nick']);
            $setfrost = $frost - $critfrost;
            $setarena = $ap - $critap;
            db_query('UPDATE item_instance SET count=%s WHERE owner_guid=%s and itemEntry=49426', $setfrost, $character['guid']);
            db_query('UPDATE characters SET arenaPoints=%s WHERE guid=%s',$setarena , $character['guid']);
        }
        else
        {
            $nochar = true;
            break;
        }
    }
    else
    {
        $wrongpass = true;
        break;
    }
  }
  else
  {
     $nochar = true;
     break;
  }
  
  // *********************************
  header('Location: /tool/customize/?done');
  exit;
  
} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Операция успешно завершена!<br></td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Изменение внешности</h3>
<p>
Приелся вид персонажа?<br>
Данная функция поможет внести разнообразие<br>
в облик Вашего героя: изменить цвет кожи,<br>
волос, выражение лица и даже пол!<br>
Требования:
    <blockquote>
    <b>x4</b> - 80 эмблем льда и 3000 АП`а<br>
    <b>x1</b> - 20 эмблем льда и 500 АП`а<br>
    <b>FUN</b> - 125 эмблем льда и 3000 АП`а<br>
    </blockquote>
Нельзя использовать если:
    <blockquote>
    Персонаж находится в игре<br>
    Персонаж был в тюрьме более двух раз<br>
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px">

  <?php if (isset($nochar)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Персонаж не найден.</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неправильный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($wanted)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж был в тюрьме более двух раз. Операция невозможна.</td></tr>
  <?php endif ?>

  <?php if (isset($online)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится в игре! Выйдите из мира и повторите операцию снова!</td></tr>
  <?php endif ?>

  <?php if (isset($miss)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится не на Вашем аккаунте!</td></tr>
  <?php endif ?>

  <?php if (isset($noap)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Недостаточно очков арены.</td></tr>
  <?php endif ?>

  <?php if (isset($nofrost)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Недостаточно эмблем льда.</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Мир</td><td><?php echo form_get('form','world', 'style="width: 170px"')?></td></tr>
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Логин</td><td>
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Пароль</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','pass', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  </td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Имя персонажа</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','nick')?></div>
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
