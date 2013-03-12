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
    $length = 6;
    $strength = 0;

    // длина пароля
    if (strlen($pass) > $length) 
    {
        $strength++;
    }

    // буквы (маленькие)
//    if (preg_match("/([a-z]+)/", $pass))
//    {
//        $strength++;
//    }

//    // буквы (большие)
//    if ( preg_match("/([A-Z]+)/", $pass))
//    {
//        $strength++;
//    }

    // Все буквы
    if ( preg_match("/([a-z-A-Z]+)/", $pass))
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

  $key=$_GET['key']; // получаем ключ из ссылки

  db_set_active('');
// проверяем ключи на валидность и дальше форумируем форму для ативации игрового ака
if ($massiv=db_fetch_array(db_query('SELECT email, uniq_hash, date, ip FROM reg_queue WHERE uniq_hash=%s',$key)))do{
// чистим запросы на регистрацию
    if ($massiv['date']<time())
    {
        db_result(db_query('DELETE FROM reg_queue WHERE uniq_hash=%s', $key)); // удаляем запись, если устарела
        $oldrecord = true;
        break;
    }

    // читаем куки, чтобы заблочить регистрацию
    if ($_COOKIE['af4e60020a836bf4f5eb5f686c2e6b7b'] == '070ed58dadf31b4706364598cd7326da')
    {
        $cookieexists = true;
        break;
    }
    if ($_COOKIE['member_id'] >0)
    {
        $cookieexists = true;
        break;
    }

    // проверяем запрос и актвиацию с одного ip, если разные, блочим регу.
    if ($massiv['ip'] !== get_ip())
    {
       $blackip =  true;
       break;
    }

    db_query('DELETE FROM reg_queue WHERE date < %s',get_time());

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

    // поле для ввода псевдонима
    form_set('form',
        array(
            '#id' => 'seoname',
            '#type' => 'text',
            '#required' => true
        )
    );

    // поле для ввода пароля для игры
    form_set('form',
        array(
            '#id' => 'gamepass',
            '#type' => 'password',
            '#required' => true
        )
    );

    // поле для повторного ввода пароля для игры
    form_set('form',
        array(
            '#id' => 'gamepassreply',
            '#type' => 'password',
            '#required' => true
        )
    );

    // поле для ввода пароля для форума
    form_set('form',
        array(
            '#id' => 'forumpass',
            '#type' => 'password',
            '#required' => true
        )
    );

    // поле для повторого ввода пароля для форума
    form_set('form',
        array(
            '#id' => 'forumpassreply',
            '#type' => 'password',
            '#required' => true
        )
    );

    // кнопка активации
    form_set('form',
        array(
            '#id' => 'sbm',
            '#type' => 'submit',
            '#value' => 'Активировать'
        )
    );
      
    if (form_validate('form'))
    do {
        $v = form_values('form');

        // проверяем, белый ли айпишник
        if ($date = db_result(db_query('SELECT date FROM black_ip WHERE ip=%s', get_ip())))
        {
            // пользователь забанен
            if (time()<$date)
            {
                $blackip = true;
                break;
            }
            else
            {
                db_query('DELETE FROM black_ip where ip=%s',get_ip());
            }
        }

        if (db_result(db_query('SELECT date FROM account WHERE last_ip=%s and UNIX_TIMESTAMP(last_login)>%s', get_ip(), time()-86400)))
        {
         $blackip = true;
         break;
         }

        // проверяем на уникальность логин
        if (db_result(db_query('SELECT username FROM account WHERE username=%s', $v['name'])))
        {
            $loginexists = true;
            break;
        }

        // блокируем логин с @, всё равно зайти не смогут
        $pos = strpos($v['name'], "@");
        if ($pos !== false)
        {
            $badlogin = true;
            break;
        }

        db_set_active('_forum');// ативируем базу форума

        //проверяем на уникальность псевдонима
        if (db_result(db_query('SELECT member_id FROM ibf_members WHERE members_display_name=%s', $v['seoname']))) 
        {
            $seonameexits = true;
            break;
        }

        // проверка на одинаковый логин и псевдоним
        if ($v['name']==$v['seoname'])
        {
            $names=true;
            break;
        }
          
        // проверка на одинаковые пароли
        if ($v['gamepass']==$v['forumpass'])
        {
            $passwords=true;
            break;
        }

        // проверка на одинаковые пароли
        if ($v['gamepass']!==$v['gamepassreply'])
        {
            $gamepasswords=true;
            break;
        }	

        // проверка на одинаковые пароли
        if ($v['forumpass']!==$v['forumpassreply'])
        {
            $forumpasswords=true;
            break;
        }

        // проверяем пароль для игры на безопасность
        if (сheckPass($v['gamepass'])<3)
        {
            $gamepasswrong=true;
            break;
        }

        // проверяем пароль для игры на безопасность
        if (сheckPass($v['forumpass'])<3)
        {
            $forumpasswrong=true;
            break;
        }

        // регистрируем игровой аккаунт
        db_set_active('');// ативируем базу realmd
        db_query('INSERT INTO account SET username=%s, sha_pass_hash=SHA1(%s), email=%s', strtoupper($v['name']), strtoupper($v['name'] . ':' . $v['gamepass']), $massiv['email']);
        db_query('DELETE FROM reg_queue WHERE uniq_hash=%s', $key); // удаляем запрос на регистрацию

        $forum_group_id=3;

        $forum_admin_mails=1;
        $forum_language=1;

        $forum_last_visit=get_time();

        $forum_login_key=md5(time() . $v['passforum'] . $v['name']);
        $forum_login_key_expire=get_time() + 86400*100;

        $members_pass_salt=generatePasswordSalt(5);
        $members_pass_salt=str_replace( '\\', "\\\\", $members_pass_salt ); 
        $members_pass_hash=md5(md5($members_pass_salt) . md5($v['forumpass'])) ;

        db_set_active('_forum');// ативируем базу форума
        db_query('INSERT INTO ibf_members SET name=%s, members_pass_salt=%s, members_pass_hash=%s, members_display_name=%s, members_seo_name=%s, members_l_display_name=%s, members_l_username=%s, 
              member_group_id=%s, email=%s, joined=%s, allow_admin_mails=%s, language=%s, last_visit=%s, member_login_key=%s, member_login_key_expire=%s', 
              $v['name'], $members_pass_salt, $members_pass_hash, $v['seoname'], $v['seoname'], $v['seoname'], $v['name'], $forum_group_id, $massiv['email'], get_time(), $forum_admin_mails,
              $forum_language, get_time(), $forum_login_key,  $forum_login_key_expire); 

        db_set_active('');// ативируем базу realmd
        $next_date = time()+86400 * 1; // время до разблокировки ip
        db_query('INSERT INTO black_ip SET ip=%s, date=%s',get_ip(),$next_date); // помечаем ip как черный на 1 дней
        setcookie('af4e60020a836bf4f5eb5f686c2e6b7b', '070ed58dadf31b4706364598cd7326da', time()+86400*1, '/'); // записываем куку на 30 дней, харош тута и пару дней мот?

        db_query('DELETE FROM reg_queue WHERE uniq_hash=%s', $key); // удаляем запись псоле регистрации

        header('Location: /tool/activation/?done');
        exit;
    } while (false);
}while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Активация успешно завершена!</td></tr>
</table>
</div>
</div>

<?php elseif (isset($massiv)): ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Активация</h3>
<p>
Логины и пароли от форума и игры<br>
<b>Не могут совпадать.</b><br><br>
Требования к паролю:
    <blockquote>
    Длина должна превышать 6 символов.<br>
    Должен содержать:
        <blockquote>
        Буквы<br>
        Цифры<br>
        Знаки (!$#%)<br>
        </blockquote>
    <b>Не должен содержать символы<br>
    из русского языка.</b>
    </blockquote>
</p>
</div>
<table width="100%" style="margin-left: 140px">

  <?php if (isset($false)): ?>
      <tr><td colspan="2" style="color: red"><?php echo $out?></td></tr>
  <?php endif ?>

  <?php if (isset($oldrecord)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Срок действия Вашего запроса истёк! Начните регистрацию заново!</td></tr>
  <?php endif ?>

  <?php if (isset($cookieexists) || isset($blackip)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Отказано в регистрации!</td></tr>
  <?php endif ?>

  <?php if (isset($badlogin)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Логин содержит недопустимые символы!</td></tr>
  <?php endif ?>

  <?php if (isset($blackip)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Отказано в активации.</td></tr>
  <?php endif ?>

  <?php if (isset($names)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Логин и псевдоним не должны совпадать в целях безопасности.</td></tr>
  <?php endif ?>

  <?php if (isset($passwords)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароли не должны совпадать в целях безопаности.</td></tr>
  <?php endif ?>

  <?php if (isset($gamepasswrong)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароль для игры не удовлетворяет требованиям безопасности.</td></tr>
  <?php endif ?>

  <?php if (isset($forumpasswrong)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароль для форума не удовлетворяет требованиям безопасности.</td></tr>
  <?php endif ?>

  <?php if (isset($loginexists)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пользователь с таким логином уже существует.</td></tr>
  <?php endif ?>

  <?php if (isset($seonameexits)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пользователь с таким псевдонимом уже существует.</td></tr>
  <?php endif ?>

  <?php if (isset($gamepasswords)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароли для игры не совпадают.</td></tr>
  <?php endif ?>

  <?php if (isset($forumpasswords)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароли для форума не совпадают.</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Логин</td><td width="18%">
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Пароль для игры</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','gamepass', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
   <td align="right" width="16%" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Введите ещё раз</td><td>
   <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','gamepassreply', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
  </td></tr>
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Пароль для форума</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','forumpass', 'style="width:300"')?></div>
                    </div>
                </div>
            </div>
        <div class="right"></div>
   </div>
   <td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Введите ещё раз</td><td>
   <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','forumpassreply', 'style="width:300"')?></div>
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
