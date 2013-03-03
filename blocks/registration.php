<?php
require_once dirname(__FILE__) . '/includes/config.php';
require_once dirname(__FILE__) . '/includes/database.inc.php';
require_once dirname(__FILE__) . '/includes/form.inc.php';

// Permit or forbid registration
global $reg_state;
$reg_state = true;

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
    '#id' => 'email',
    '#type' => 'text',
    '#required' => true,
    '#reg_ex' => REGEX_EMAIL
  )
);

form_set('form',
  array(
    '#id' => 'agree',
    '#type' => 'checkbox',
    '#required' => true
  )
);

form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Отправить запрос'
  )
);

if (form_validate('form')) do {
  $v = form_values('form');

  $mas = explode("@", $v['email']);
  
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
    if (!$reg_state)
    {
        break;
    }
    db_set_active('');
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

    if (db_result(db_query('SELECT last_login FROM account WHERE last_ip=%s and UNIX_TIMESTAMP(last_login)>%s', get_ip(), time()-86400)))
    {
      $blackip = true;
      break;
    }

    // проверяем в account, нет ли емэйла, на кторый пытаются зарегистрироваться!!!
    if (db_result(db_query('SELECT username FROM account WHERE email=%s', $v['email'])))
    {
        $emailexists = true;
        break;
    }
    // проверяем в reg_queue, нет ли емэйла, на кторый пытаются зарегистрироваться!!!
    if (db_result(db_query('SELECT email FROM reg_queue WHERE email=%s', $v['email'])))
    {
        $emailexists = true;
        break;
    }

    // проверяем в reg_queue, нет ли емэйла, на кторый пытаются зарегистрироваться!!!
    if (db_result(db_query('SELECT domain FROM black_domain WHERE domain=%s', $mas[1])))
    {
        $blackemail = true;
        break;
    }

    $hash =  md5(time() . rand(1,1000)); // генерируем кэш для идентифиации уникального пользователя
    $nex_date = time()+86400;
    db_query('INSERT into reg_queue SET email = %s, uniq_hash = %s, date = %s,ip=%s ', $v['email'], $hash, $nex_date, get_ip());

    $message = '<b>Служба технической поддержки <a href="http://riverrise.net/">RiverRise.net</a> / <a href="http://worldofwarcraft.by/">WorldOfWarcraft.by</a> приветствует Вас.</b><br><br>'; // формируем поле письма
    $message = $message.'Данное письмо было отослано Вам автоматически, так как была подана заявка на регистрацию <b>новой учётной записи</b> <a href="http://riverrise.net/">на нашем сервере</a><br>';
    $message = $message.'Если Вы действительно хотите создать новый аккаунт, перейдите по следующей ссылке.<br><b><a href="http://riverrise.net/tool/activation/?key='.$hash.'">http://riverrise.net/tool/activation/?key='.$hash.'</a></b><br><br>';
    $message = $message.'Если Вы считаете, что это письмо было отослано Вам по ошибке, просто проигнорируйте его.<br><br>';
    $message = $message.'<b>Надеемся, Вам у нас понравится.</b><br> Администрация riverrise.net / worldofwarcraft.by';

    require_once("mailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->From = 'donotreplay@riverrise.net';
    $mail->FromName = 'Администрация RiverRise.net';
    $mail->AddAddress($v['email']);
    $mail->Subject  =  "Запрос на регистрацию";
    $mail->Body=$message;
    $mail->isHTML(true);
    if(!$mail->Send())
    {
        $answer=$mail->ErrorInfo;
    }

    header('Location: /registration/?done');
    exit;
} while (false);
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">На Ваш почтовый ящик отправлено письмо с дальнейшими инструкциями.</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <?php if (isset($cookieexists) || isset($blackip)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Отказано в регистрации: Вероятно у Вас уже есть аккаунт!</td></tr>
  <?php endif ?>

  <?php if (isset($emailexists)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пользователь с таким емэйлом уже существует или ожидает регистрации.</td></tr>
  <?php endif ?>

  <?php if (isset($blackemail)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Запрещенный почтовый ящик.</td></tr>
  <?php endif ?>

  <?php if (!$reg_state): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Регистрация закрыта.</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Почтовый ящик</td><td>
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
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td></td><td style="color: #FFFFFF; text-shadow: 0px 0px 8px black;"><?php echo form_get('form', 'agree')?> с <a href="/rules/" target="_blank">правилами</a> и <a href="http://eu.blizzard.com/ru-ru/company/legal/" target="_blank">юридическими документами Blizzard Entertainment</a> согласен</td></tr>
  <!--<tr><td></td><td style="color: #FFFFFF; text-shadow: 0px 0px 8px black;">Если у Вас уже есть учётная запись, но она не активирована, Вы можете <a href="/tool/forum_queue/">активировать</a> её.</td></tr>-->
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>

</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
