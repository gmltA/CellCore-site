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
    '#value' => 'Переместить'
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
        if ($character=db_fetch_array(db_query('SELECT account, guid, online FROM characters WHERE name=%s', $v['nick'])))
        {
            if ($character['account']==$account['id'])
            {
                if ($character['online']==1)
                {
                    $online=true;
                    break;
                }
                if ($freeze=db_result(db_query('SELECT spell FROM character_aura WHERE spell=9454 AND guid=%s', $character['guid'])))
                {
                    $fr=true;
                    break;
                }
                if ($cd= db_result(db_query('SELECT time FROM character_spell_cooldown WHERE (spell=8690 or spell=54401 or spell=54403 or spell=70195 or spell=75136) AND guid=%s LIMIT 1', $character['guid'])))
                {
                    if ($cd > time())
                    {
                        $cdexists=true;
                        break;
                    }
                    else
                    {
                        db_query('DELETE FROM character_spell_cooldown WHERE (spell=8690 or spell=54401 or spell=54403 or spell=70195 or spell=75136) AND guid=%s', $character['guid']);
                    }
                }
                if ($home=db_fetch_array(db_query('SELECT * FROM character_homebind WHERE guid=%s', $character['guid'])))
                {
                    db_query('UPDATE characters SET map=%s, position_x=%s, position_y=%s, position_z=%s, zone=%s WHERE guid=%s', $home['mapId'],$home['posX'],$home['posY'],$home['posZ'],$home['zoneId'], $character['guid']);
                    $time = time()+1800;
                    db_query('INSERT INTO character_spell_cooldown SET guid=%s, spell=%s, item=%s, time=%s',$character['guid'],8690,6948,$time);
                    db_query('INSERT INTO character_spell_cooldown SET guid=%s, spell=%s, item=%s, time=%s',$character['guid'],54401,6948,$time);
                    db_query('INSERT INTO character_spell_cooldown SET guid=%s, spell=%s, item=%s, time=%s',$character['guid'],54403,6948,$time);
                    db_query('INSERT INTO character_spell_cooldown SET guid=%s, spell=%s, item=%s, time=%s',$character['guid'],70195,6948,$time);
                    db_query('INSERT INTO character_spell_cooldown SET guid=%s, spell=%s, item=%s, time=%s',$character['guid'],75136,6948,$time);
                }
                if ($death=db_result(db_query('SELECT spell FROM  character_aura WHERE (spell = 20584 OR spell = 8326) AND guid=%s',$character['guid'])))
                {
                    db_query('DELETE FROM character_aura WHERE (spell = 20584 OR spell = 8326) AND guid=%s', $character['guid']);
                    db_query('DELETE FROM corpse WHERE guid=%s', $character['guid']);
                    db_query('UPDATE characters SET health=1 WHERE guid=%s', $character['guid']);
                    db_query('DELETE FROM character_aura WHERE spell=15007 AND guid=%s', $character['guid']);
                    db_query('INSERT INTO character_aura SET guid=%s, caster_guid=%s, item_guid=0, spell=15007, effect_mask=7, recalculate_mask=7, stackcount=1,
                          amount0=-75, amount1=-75, amount2=0, base_amount0=-76, base_amount1=-76, base_amount2=-1, maxduration=600000, remaintime=562692, remaincharges=0',$character['guid'], $character['guid']);
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

    // *********************************
    header('Location: /tool/unstuck/?done');
    exit;
  
} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Персонаж перемещён!</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Анстак</h3>
<p>
Данная опция позволяет телепортировать<br>
персонажа в локацию, которая является<br>
Вашим домом, если персонаж застрял или<br>
Вы потеряли над ним контроль.<br><br>
Нельзя использовать если:
    <blockquote>
    Персонаж находится в игре<br>
    Персонаж заморожен Гейм-мастером<br>
    Персонаж недавно уже использовал эту функцию
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px">

  <?php if (isset($miss)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Вы не можете переместить этого персонажа!</td></tr>
  <?php endif ?>

  <?php if (isset($nochar)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Персонаж не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($cdexists)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Сейчас Вы не можете использовать эту функцию! Попробуйте позже.</td></tr>
  <?php endif ?>

  <?php if (isset($online)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Персонаж находится в игре! Выйдите из мира и повторите операцию снова!</td></tr>
  <?php endif ?>

  <?php if (isset($fr)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Этот персонаж заморожен Гейм-мастером или Администратором. Операция невозможна!</td></tr>
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
