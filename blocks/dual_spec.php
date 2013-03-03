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
    '#value' => 'Исправить'
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
            if ($character=db_fetch_array(db_query('SELECT account, guid, online FROM characters WHERE name=%s',$v['nick'])))
            {
                if ($character['account']==$account['id'])
                {
                    if ($character['online']==1)
                    {
                        $online=true;
                        break;
                    }
                    if ($dualSpecCount = db_result(db_query('SELECT spec FROM character_action WHERE spec = 1 and guid=%s', $character['guid'])))
                    {
                        if (!$first=db_result(db_query('SELECT spell FROM character_spell WHERE spell=63644 and guid=%s', $character['guid'])))
                        {
                            db_query('INSERT INTO character_spell SET spell=63644, guid=%s', $character['guid']);
                        }
                        if (!$first=db_result(db_query('SELECT spell FROM character_spell WHERE spell=63645 and guid=%s', $character['guid'])))
                        {
                            db_query('INSERT INTO character_spell SET spell=63645, guid=%s', $character['guid']);
                        }	     
                    }
                    else
                    {
                        $fail = true;
                        break;
                    }
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
        $nochar = true;
        break;
    }

  // *********************************
  header('Location: /tool/dual_spec/?done');
  exit;

} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 30px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Готово.<br><br>Если функция не помогла, обратитесь к Гейм-Мастеру.</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Исправление двойной специализации</h3>
<p>
Функция позволяет исправить<br>
частую ошибку, возникающую при<br>
использовании двойной специализации.<br>
Нельзя использовать если:
    <blockquote>
    Персонаж находится в игре<br>
    Персонаж ещё не обучился двойной специализации
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px">

  <?php if (isset($miss)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится не на Вашем аккаунте!</td></tr>
  <?php endif ?>

  <?php if (isset($nochar)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">>Персонаж не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($online)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится в игре! Выйдите из мира и повторите операцию снова!</td></tr>
  <?php endif ?>

  <?php if (isset($fail)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Вы ещё не обучились двойной специализации</td></tr>
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
