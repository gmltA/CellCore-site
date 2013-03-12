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
    '#id' => 'email',
    '#type' => 'text',
    '#required' => true,
    '#reg_ex' => REGEX_EMAIL
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
    '#value' => 'Зарегистрироваться'
  )
);

if (form_validate('form')) do {
  $v = form_values('form');

    db_set_active('');
    if (db_result(db_query('SELECT username FROM account WHERE username=%s', $v['name'])))
    {
        $exists = true;
        break;
    }

  db_query('INSERT INTO account SET username=%s, sha_pass_hash=SHA1(%s), email=%s, last_ip=%s, expansion=2',
                strtoupper($v['name']), strtoupper($v['name'] . ':' . $v['pass']), $v['email'], get_ip());

  header('Location: /tool/verysreg/?done');
  exit;

} while (false);
?>

<?php if (isset($_GET['done'])): ?>
<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Вы зарегистрировались на сервере. Для начала игры пропишите в реалм листе set realmlist riverrise.net.</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <?php if (isset($exists)): ?>
      <tr><td colspan="2" style="color: red">Пользователь с таким логином уже существует. Выберите другой.</td></tr>
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">eMail</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','email', 'style="width:300"')?></div>
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
