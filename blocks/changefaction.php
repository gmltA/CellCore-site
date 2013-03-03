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
    '#id' => 'world',
    '#type' => 'select',
    '#options' => array(1 => 'Rise of Fallen (x30)', 3 => 'Arena Tournament', 2 => 'Frostmourne (PvP x4)'),
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
    '#value' => 'Сменить фракцию'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

    db_set_active('');
    if ($account=db_fetch_array(db_query('SELECT id, username, sha_pass_hash FROM account WHERE username=%s', $v['name'])))
    {
        $pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
        if ($pass == $account['sha_pass_hash'])
        {
            switch ($v['world'])
            {
                case 1:
                    db_set_active('_character_fun');
                    $critarena2x2 = 2200;
                    $critarena3x3 = 1900;
                    $critap = 6000;
                    $critach = 150;
                    $critfrost = 200;
                    break;
                    
                case 2:
                    db_set_active('_character_x4');
                    $critarena2x2 = 2300;
                    $critarena3x3 = 2000;
                    $critap = 7000;
                    $critach = 300;
                    $critfrost = 300;
                    break;

                case 3:
                    db_set_active('_character_x1');
                    $critarena2x2 = 0;
                    $critarena3x3 = 0;
                    $critap = 2000;
                    $critach = 300;
                    $critfrost = 50;
                    break;
            }

            // берем количество игроков по фракциям
            $horde = db_result(db_query(' SELECT count(`guid`) FROM characters WHERE `race` in (2, 5, 6, 8, 10) and level=80'));
            $alliance = db_result(db_query(' SELECT count(`guid`) FROM characters WHERE `race` in (1, 3, 4, 7, 11) and level=80'));

            // считаем соотношение игроков по фракциям и разрешаем/запрещаем трансфер
            if ($alliance>$horde)
            {
                $ratio = 100-(($horde*100)/$alliance);
                if ($ratio>5)
                {
                    $transfersite="H";
                }
                else
                {
                    $transfersite="B";
                }
            }
            else
            {
                $ratio = 100-(($alliance*100)/$horde);
                if ($ratio>5)
                {
                    $transfersite="A";
                }
                else
                {
                    $transfersite="B";
                }
            }
            // ****************************
            // ****************************

            // выдираем персонажа
            if ($character=db_fetch_array(db_query('SELECT * FROM characters WHERE name=%s',$v['nick'])))
            {
                // проверяем на онлайн
                if ($character['online']==1)
                {
                    $online=true;
                    break;
                }
                
                //проверяем, относится ли персонаж к этому акку
                if ($character['account']!=$account['id'])
                {
                    $miss = true;
                    break;
                }

                //проверяем уровень персонажа
                if ($character['level']!=80)
                {
                    $nolevel = true;
                    break;
                }

                // проверяем на тюрьму
                if ($jail=db_result(db_query('SELECT times FROM jail WHERE guid=%s', $character['guid'])))
                {
                    if ($jail>0 && $v['world'] != 1)
                    {
                        $wanted = true;
                        break;
                    }
                }

                // здесь будет оплата за трансффер
                $arena2x2 = db_result(db_query('SELECT matchMakerRating FROM character_arena_stats WHERE guid=%s and slot=0', $character['guid']));
                $arena3x3 = db_result(db_query('SELECT matchMakerRating FROM character_arena_stats WHERE guid=%s and slot=1', $character['guid']));
                $ap = $character['arenaPoints'];
                $frost =  db_result(db_query('SELECT `count` FROM item_instance WHERE (itemEntry=49426 and owner_guid=%s)', $character['guid']));
                $ach = db_result(db_query('SELECT COUNT(`guid`) FROM character_achievement WHERE guid=%s', $character['guid']));
                  
                // обрубаем скрипт по арена 2 на 2
                if ($arena2x2<$critarena2x2)
                {
                    $noarena2x2 = true;
                    break;
                }
                // обрубаем скрипт по арена 3 на 3
                if ($arena3x3<$critarena3x3)
                {
                    $noarena3x3 = true;
                    break;
                }
                // обрубаем скрипт апу
                if ($ap<$critap)
                {
                    $noap = true;
                    break;
                }

                // обрубаем скрипт по фросту
                if ($frost<$critfrost)
                {
                    $nofrost = true;
                    break;
                }

                // обрубаем скрипт по ачивам
                if ($ach<$critach)
                {
                    $noach = true;
                    break;
                }

                $arr = array(1,3,4,7,11);
                // пначинаем трансфер для альянс -> орда
                if (in_array($character['race'], $arr))
                {
                    if ($transfersite=="H" || $transfersite=="B")
                    {
                        db_query('UPDATE characters SET at_login=%s WHERE name=%s',64, $v['nick']);
                        $setfrost = $frost - $critfrost;
                        $setarena = $ap - $critap;
                        db_query('UPDATE item_instance SET count = %s WHERE owner_guid=%s and itemEntry=49426', $setfrost, $character['guid']);
                        db_query('UPDATE characters set arenaPoints = %s WHERE guid=%s',$setarena , $character['guid']);
                        db_query('INSERT INTO transfer SET guid=%s, date=%s',  $character['guid'], time());
                    }
                    // запрещаем трансфер в орду и завершаем скрипт
                    else
                    {
                        $notransferH = true;
                        break;
                    }
                }
                // начинаем трансфер альянс -> орда
                else
                {
                    if ($transfersite=="A" || $transfersite=="B")
                    {
                        db_query('UPDATE characters SET at_login=%s WHERE name=%s',64, $v['nick']);
                        $setfrost = $frost - $critfrost;
                        $setarena = $ap - $critap;
                        db_query('UPDATE item_instance SET count = %s WHERE owner_guid=%s and itemEntry=49426', $setfrost, $character['guid']);
                        db_query('UPDATE characters set arenaPoints = %s WHERE guid=%s',$setarena , $character['guid']);
                        db_query('INSERT INTO transfer SET guid=%s, date=%s',  $character['guid'], time());
                    }
                    // запрещаем трансфер
                    else
                    {
                        $notransferA = true;
                        break;
                    }
                }
            }
            // прерываем скрипт, если чар не найден
            else
            {
                $nochar = true;
                break;
            }
        }
        // прерываем скрипт, если не соответсвует пароль
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
  header('Location: /tool/changefaction/?done');
  exit;
  
} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Операция успешно завершена!</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Смена фракции</h3>
<p>
Хотите играть с друзьями за другую фракцию?<br>
Нет ничего проще! Вы можете воспользоваться<br>
такой услугой на нашем сервере.<br>
Требования:
    <blockquote>
        <table style="margin-left: -40px; border-style: solid; border-color: rgb(177, 195, 210); border-width: 1px; box-shadow: 0px 0px 15px rgb(177, 195, 210); border-collapse: collapse;">
            <tr><td>&nbsp</td><th>MMR 2x2</th><th>MMR 3x3</th><th>Arena</th><th>Frost</td><th>Achievement</th></tr>
            <tr><th>x4</th><td>2300</td><td>2000</td><td>7000</td><td>300</td><td>300</td></tr>
            <tr><th>x2</th><td>0</td><td>0</td><td>2000</td><td>50</td><td>300</td></tr>
            <tr><th>FUN</th><td>2200</td><td>1900</td><td>6000</td><td>200</td><td>150</td></tr>
        </table>
    </blockquote>
Нельзя использовать если:
    <blockquote>
    Персонаж находится в игре<br>
    Персонаж был в тюрьме<br>
    Фракции не сбалансированы<br>
    </blockquote>
</p>
</div>
<table width="100%">

  <?php if (isset($nochar)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Персонаж не найден.</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неправильный пароль.</td></tr>
  <?php endif ?>

  <?php if (isset($wanted)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж был в тюрьме. Операция невозможна.</td></tr>
  <?php endif ?>

  <?php if (isset($online)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится в игре! Выйдите из мира и повторите операцию снова!</td></tr>
  <?php endif ?>

  <?php if (isset($notransferA) || isset($notransferH)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Эта фракция преобладает на реалме. Процедура невозможна.</td></tr>
  <?php endif ?>

  <?php if (isset($miss)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится не на Вашем аккаунте!</td></tr>
  <?php endif ?>

  <?php if (isset($noarena2x2)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Недостаточный рейтинг 2х2</td></tr>
  <?php endif ?>

  <?php if (isset($noarena3x3)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Недостаточный рейтинг 3х3</td></tr>
  <?php endif ?>

  <?php if (isset($noap)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Недостаточно очков арены.</td></tr>
  <?php endif ?>

  <?php if (isset($nofrost)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Недостаточно эмблем льда.</td></tr>
  <?php endif ?>

  <?php if (isset($noach)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Недостаточно выполненных достижений.</td></tr>
  <?php endif ?>

  <?php if (isset($nolevel)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Ваш персонаж ещё не достиг 80-го уровня.</td></tr>
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
                        <div class="text"><?php echo form_get('form','nick', 'style="width:300"')?></div>
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
