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
    '#options' => array(1 => 'Rise of Fallen (PvP x30)', 3 => 'Arena Tournament', 2 => 'Frostmourne (PvP x4)'),
    '#required' => true
  )
);

// поле для ввода логина
form_set('form',
  array(
    '#id' => 'name',
    '#type' => 'text',
    '#required' => true
  )
);

// поле для ввода пароля для игры
form_set('form',
  array(
    '#id' => 'pass',
    '#type' => 'password',
    '#required' => true
  )
);

// поле для ввода ника
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
    '#value' => 'Восстановить'
  )
);

if (form_validate('form')) do {
  $v = form_values('form');
 
    db_set_active('');
    // делаем выборку инициатора из базы
    if ($account=db_fetch_array(db_query('SELECT id, username, sha_pass_hash FROM account WHERE username=%s', $v['name'])))
    {
        // проверяем пароль
        $pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
        if ($pass == $account['sha_pass_hash'])
        {
            switch ($v['world'])
            {
                case 1:
                    db_set_active('_character_fun');
                    break;

                case 2:
                    db_set_active('_character_x4');
                    break;

                case 3:
                    db_set_active('_character_x1');
                    break;
            }
            if ($character=db_fetch_array(db_query('SELECT deleteInfos_Account, class, deleteInfos_Name, guid, online FROM characters WHERE deleteInfos_Name=%s',$v['nick'])))
            {
                if ($character['deleteInfos_Account']==$account['id'])
                {
                    if ($jail=db_result(db_query('SELECT times FROM jail WHERE guid=%s', $character['guid'])))
                    {
                        if ($jail>=3)
                        {
                            $wanted = true;
                            break;
                        }
                    }
                    if ($character['class']==6)
                    {
                        if ($dk=db_result(db_query('SELECT class FROM characters WHERE account=%s and class=6', $character['deleteInfos_Account'])))
                        {
                            $dkexists=true;
                            break;
                        }	  
                    }
                    db_query('UPDATE characters SET account=%s, name=%s, deleteInfos_Account=NULL, deleteInfos_Name=NULL, deleteDate=NULL WHERE guid=%s', $character['deleteInfos_Account'],
                        $character['deleteInfos_Name'], $character['guid']);
                }
                else
                {
                    $miss = true;
                    break;
                }
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
        $wrongpass = true;
        break;
    }

  // *********************************
  header('Location: /tool/char_restore/?done');
  exit;

} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Персонаж восстановлен!</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Восстановление персонажа</h3>
<p>
Случайно удалили своего героя или пострадали от взлома?<br>
Теперь это не так страшно: с помощью этой функции<br>
Вы всегда можете восстановить своего героя.<br>
Нельзя использовать если:
    <blockquote>
    Персонаж не сохранился в корзине<br>
    Уровень Вашего персонажа не превышал 70<br>
    Персонаж был в тюрьме более двух раз<br>
    Если Вы пытаетесь восстановить Рыцаря Смерти<br>
    но у Вас на аккаунте уже есть персонаж этого класса.
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px">

  <?php if (isset($miss)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится не на Вашем аккаунте!</td></tr>
  <?php endif ?>

  <?php if (isset($nochar)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Персонажа нет в корзине!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($wanted)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">У персонажа статус WANTED, восстановление только через Администрацию!</td></tr>
  <?php endif ?>

  <?php if (isset($dkexists)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">У вас уже есть Рыцарь Смерти!</td></tr>
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
