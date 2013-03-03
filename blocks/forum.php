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

function get_time()
{
    return time();
}

function generatePasswordSalt($len=5)
{
    $salt = '';
    for ( $i = 0; $i < $len; $i++ )
    {
        $num   = mt_rand(33, 126);
        if ( $num == '92' )
        {
            $num = 93;
        }
        $salt .= chr( $num );
    }
    return $salt;
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

// поле для ввода логина
form_set('form',
  array(
    '#id' => 'seoname',
    '#type' => 'text',
    '#required' => true
  )
);

form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Зарегиться'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

  db_set_active('');
  // делаем выборку инициатора из базы
    if ($massiv=db_fetch_array(db_query('SELECT id, username, email, sha_pass_hash FROM account WHERE username=%s', $v['name'])))
    {

	$pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
        if ($pass !== $massiv['sha_pass_hash'])
        {
	   // db_set_active('_forum');
            // неправильный пароль     !!!!!!!
            $wrongpass = true;
            break;
        }
     
	db_set_active('_forum');// ативируем базу форума	

	// проверяем наличие форумного ака
	if (db_result(db_query('SELECT member_id FROM ibf_members WHERE name=%s', $v['name']))) 
        {
            $nameforum = true;
            break;
        }

        //проверяем на уникальность псевдонима
        if (db_result(db_query('SELECT member_id FROM ibf_members WHERE members_display_name=%s', $v['seoname']))) 
        {
            $seonameexits = true;
            break;
        }




        $forum_group_id=3;

        $forum_admin_mails=1;
        $forum_language=1;

        $forum_last_visit=get_time();

        $forum_login_key=md5(time() . $v['pass'] . $v['name']);
        $forum_login_key_expire=get_time() + 86400*100;

        $members_pass_salt=generatePasswordSalt(5);
        $members_pass_salt=str_replace( '\\', "\\\\", $members_pass_salt ); 
        $members_pass_hash=md5(md5($members_pass_salt) . md5($v['pass'])) ;

        db_query('INSERT INTO ibf_members SET name=%s, members_pass_salt=%s, members_pass_hash=%s, members_display_name=%s, members_seo_name=%s, members_l_display_name=%s, members_l_username=%s, 
              member_group_id=%s, email=%s, joined=%s, allow_admin_mails=%s, language=%s, last_visit=%s, member_login_key=%s, member_login_key_expire=%s', 
              $v['name'], $members_pass_salt, $members_pass_hash, $v['seoname'], $v['seoname'], $v['seoname'], $v['name'], $forum_group_id, $massiv['email'], get_time(), $forum_admin_mails,
              $forum_language, get_time(), $forum_login_key,  $forum_login_key_expire); 
	

    }
    else
    {
        $noacc = true;
        break;
    }

  header('Location: /tool/activation/?done');
  exit;

} while (false);

?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Готово.</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Активируйся на форуме!</h3>
<p>
Милости просим!!!
</p>
</div>
<table width="90%" style="margin-left: 100px;">

  <?php if (isset($noacc)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Аккаунт не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($nameforum)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Форумный уже существует!</td></tr>
  <?php endif ?>

  <?php if (isset($seonameexits)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Псевдоним уже занят!!!</td></tr>
  <?php endif ?>

  <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;"><b>Внимание!</b> Только для игроков х30!!! </td></tr>
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Псевдоним</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','seoname', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  </td></tr>
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>
  <tr><td>&nbsp</td></tr>

</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
