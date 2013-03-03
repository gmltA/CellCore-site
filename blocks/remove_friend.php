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


form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Удалить статус друга'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

    db_set_active('');
    // делаем выборку инициатора из базы
    if ($account=db_fetch_array(db_query('SELECT id, username, sha_pass_hash, recruiter FROM account WHERE username=%s', $v['name'])))
    {
        // проверяем пароль
        $pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
        if ($pass == $account['sha_pass_hash'])
        {
            if ($account['recruiter'] == 0)
            {
                $norec = true;
                break;
            }
            else
            {
                db_query('UPDATE account SET recruiter=0 where id=%s', $account['id']);
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
        $noacc = true;
        break;
    }

  // *********************************
  header('Location: /tool/remove_friend/?done');
  exit;

} while (false);

?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Статус "Друг" удалён!</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($norec)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Вы не имеете статуса "Друг"!</td></tr>
  <?php endif ?>

  <?php if (isset($noacc)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Аккаунт не найден!</td></tr>
  <?php endif ?>

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
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>  
</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
