<?php
require_once dirname(__FILE__) . '/includes/config.php';

require_once dirname(__FILE__) . '/includes/database.inc.php';
require_once dirname(__FILE__) . '/includes/form.inc.php';

form_set(
  array(
    '#id' => 'form',
    '#action' => '',
    '#method' => 'post'
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
    '#id' => 'user',
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
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Выполнить'  )
);


if (form_validate('form'))
{
    db_set_active('');
    $v = form_values('form');
    if ($user = db_result(db_query('SELECT id FROM account WHERE sha_pass_hash=SHA1(%s)', strtoupper($v['user'] . ':' . $v['pass']) )))
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
        db_query('DELETE FROM account_data WHERE account=%d', $user);

        db_set_active('');
    }
}
?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Мир</td><td><?php echo form_get('form','world', 'style="width: 170px"')?></td></tr>
    <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Логин</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','user', 'style="width:300"')?></div>
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
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>

</table>
<?php echo form_get('form', 'footer')?>

<h3 style="color: rgb(177, 195, 210);">Включаем все аддоны, выходим из игры, удаляем папку WTF, чистим кэш, обновляем аддоны, производим эту операцию и наслаждаемся ;) </h3>
