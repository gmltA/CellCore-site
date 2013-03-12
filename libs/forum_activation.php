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

function get_time()
{
    return time();
}

//************************
// хрень для форума

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

// конец хрения для форума
//***********************

// проверка пароля на сложность
function сheckPass($pass)
{
    $length = 8;
    $strength = 0;

    // длина пароля
    if (strlen($pass) > $length) 
    {
        $strength++;
    }

    // буквы (маленькие)
    if (preg_match("/([a-z]+)/", $pass))
    {
        $strength++;
    }

    // буквы (большие)
    if (preg_match("/([A-Z]+)/", $pass))
    {
        $strength++;
    }

    // числа
    if (preg_match("/([0-9]+)/", $pass))
    {
        $strength++;
    }

    // символы
    if (preg_match("/(W+)/", $pass))
    {
        $strength++;
    }

    // обрубаем нахер кириллицу
    if (preg_match("/^[а-я-A-Я]+$/i", $pass))
    {
        $strength = 0;
    }

    return $strength;
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
            '#id' => 'seoname',
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
            '#value' => 'Активировать'
        )
    );

$key=$_GET['key'];
db_set_active('');

if ($massiv = db_fetch_array(db_query('SELECT * FROM reg_queue WHERE uniq_hash=%s', $key)))
do {
    if ($massiv['date'] < time())
    {
        db_query('DELETE FROM reg_queue WHERE uniq_hash=%s', $key); // удаляем запись, если устарела
        db_query('DELETE FROM reg_queue WHERE date <' . get_time()); // удаляем старые записи
        $oldrecord = true;
        break;
    }

    db_query('DELETE FROM reg_queue WHERE date <' . get_time()); // удаляем старые записи

    if (form_validate('form'))
    do {
        $v = form_values('form');

        db_set_active('_forum');

        //проверяем на активацию
        if ($mas = db_fetch_array(db_query('SELECT name, email FROM ibf_members WHERE email=%s and member_group_id>1',$massiv['email'])))
        {
            if (!empty($mas['email']))
            {
                $accountexists = true;	
                break;
            }
        }

        //проверяем на активацию
        if (db_result(db_query('SELECT member_id FROM ibf_members WHERE members_display_name=%s', $v['seoname'])))
        {
            $seonameexits = true;
            break;
        }

        // проверка на одинаковый логин и псевдоним
        if ($massiv['name'] == $v['seoname'])
        {
            $names = true;
            break;
        }

        // проверяем пароль для игры на безопасность
        if (сheckPass($v['pass']) < 4)
        {
            $passwrong = true;
            break;
        }

        $forum_group_id = 3;

        $forum_admin_mails = 1;
        $forum_language = 1;

        $forum_last_visit = get_time();

        $forum_login_key = md5(time() . $v['pass'] . $massiv['name']);
        $forum_login_key_expire = get_time() + 86400*100;

        $members_pass_salt = generatePasswordSalt(5);
        $members_pass_salt = str_replace( '\\', "\\\\", $members_pass_salt ); 
        $members_pass_hash = md5(md5($members_pass_salt) . md5($v['pass']));

        db_query('UPDATE ibf_members SET members_pass_salt=%s, members_pass_hash=%s, members_display_name=%s, members_seo_name=%s, members_l_display_name=%s, members_l_username=%s, 
              member_group_id=%s, email=%s, joined=%s, allow_admin_mails=%s, language=%s, last_visit=%s, member_login_key=%s, member_login_key_expire=%s where name=%s', 
              $members_pass_salt, $members_pass_hash, $v['seoname'], $v['seoname'], $v['seoname'], $massiv['name'], $forum_group_id, $massiv['email'], get_time(), $forum_admin_mails,
              $forum_language, get_time(), $forum_login_key,  $forum_login_key_expire, $massiv['name']); 

        db_set_active('');
        db_query('DELETE FROM reg_queue WHERE uniq_hash=%s', $key);

        header('Location: /tool/forum_activation/?done');
        exit;
    } while (false);
} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Учётная запись активирована!</td></tr>
</table>
</div>
</div>

<?php elseif(isset($v)): ?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <?php if (isset($oldrecord)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Срок действия Вашего запроса истёк! Начните активацию заново!</td></tr>
  <?php endif ?>

  <?php if (isset($seonameexits)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пользователь с таким псевдонимом уже существует, выберите другой!</td></tr>
  <?php endif ?>

  <?php if (isset($names)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Логин и псевдоним должны отличаться в целях безопастности!</td></tr>
  <?php endif ?>

  <?php if (isset($passwrong)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароль не удовлетворяет требованиям безопастности!</td></tr>
  <?php endif ?>

  <?php if (isset($accountexists)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">У вас уже есть один активированный аккаунт!</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Псевдоним</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form', 'seoname', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  </td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Пароль для игры</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form', 'pass', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>
  
</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
