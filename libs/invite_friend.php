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
    '#id' => 'friend',
    '#type' => 'text',
    '#required' => true
  )
);

form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Отправить приглашение'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

  db_set_active('');
  // делаем выборку инициатора из базы
    if ($massiv=db_fetch_array(db_query('SELECT id, username, sha_pass_hash FROM account WHERE username=%s', $v['name'])))
    {
        // проверяем пароль
        $pass = SHA1(strtoupper($v['name'] . ':' . $v['pass']));
        if ($pass == $massiv['sha_pass_hash'])
        {
            // ищем друга
            if ($friend=db_fetch_array(db_query('SELECT username, email, recruiter from account WHERE username=%s',$v['friend'])))
            {
                // проверяем есть ли у емейл
                if ($friend['email'] == '')
                {
                    // отсутствует емейл   !!!!!!!
                    $noemail = true;
                    break;
                }
                // проверяем есть ли у друга друга
                if ($friend['recruiter'] != 0)
                {
                    // есть друг
                    $friendbusy = true;
                    break;
                }
                // проверяем на одинаковые логины
                if ($v['friend'] == $v['name'])
                {
                    $likelogins = true;
                    break;
                }

                if ($count=db_result(db_query('SELECT count(*) AS count FROM account where recruiter=%s', $massiv['id'])))
                {
                    if ($count>=20)
                    {
                        $nomore = true;
                        break;
                    }
                }

                // срок действия приглашения
                $next_date = time()+86400;
                // генерируем хэш приглашения
                $hash =  md5(time() . rand(1,1000));
                // добавляем приглашине в базу
                db_query('INSERT INTO friend_invite SET username=%s, date=%s, recruiter=%s, uniq_hash=%s', $v['name'], $next_date, $friend['username'], $hash);

                // отправляем письмо другу
                $message = '<b>Приветствуем, '.strtoupper($friend['username']).'</b><br><br>'; // формируем поле письма
                $message = $message.'Данное письмо было отослано Вам автоматически, так как <b>'.$v['name'].'</b> пожелал добавить Вас в друзья <a href="http://riverrise.net/">на нашем сервере</a><br>';
                $message = $message.'Если Вы согласны стать другом <b>'.strtoupper($v['name']).'</b>, перейдите по следующей ссылке, чтобы завершить операцию.<br><b><a href="http://riverrise.net/tool/confirm_friend/?key='.$hash.'">http://riverrise.net/tool/confirm_friend/?key='.$hash.'</a></b><br><br>';
                $message = $message.'Если Вы считаете, что это письмо было отослано Вам по ошибке, просто проигнорируйте его.<br><br>';
                $message = $message.'<b>Приятной игры на сервере.</b><br> Администрация riverrise.net';

                require_once('mailer/class.phpmailer.php');
                $mail = new PHPMailer();
                $mail->From = 'invite_friend@riverrise.net';
                $mail->FromName = 'Администрация RiverRise.net';
                $mail->AddAddress($friend['email']);
                $mail->Subject  = 'Приглашение стать другом на riverrise.net от '.$v['name'];
                $mail->Body=$message;
                $mail->isHTML(true);
                if(!$mail->Send())
                {
                    $answer=$mail->ErrorInfo;
                }
            }
            else
            {
                // друг не найден
                $nofriend = true;
                break;
            }
        }
        else
        {
            // неправильный пароль     !!!!!!!
            $wrongpass = true;
            break;
        }
    }
    else
    {
        $noacc = true;
        break;
    }

  header('Location: /tool/invite_friend/?done');
  exit;

} while (false);

?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Вашему другу отправлено приглашение.</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Пригласи друга!</h3>
<p>
Хотите дружить не только в реальной жизни,<br>
но и в игре?<br>
Не проблема! Пригласите игрока дружить с<br>
Вами с помощью этой функции.<br>
Вас обоих ждут следующие преимущества:
    <blockquote>
    В <b>3</b> раза ускоренный набор опыта.<br>
    Призыв друга к себе раз в час.<br>
    Приглашённый может отдать один уровень<br>
    пригласившему игроку за каждые два<br>
    набранных уровня.
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px;">

  <?php if (isset($noacc)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Аккаунт не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($noemail)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Аккаунт Вашего друга не прикреплён к почтовому ящику.</td></tr>
  <?php endif ?>

  <?php if (isset($friendbusy)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Ваш друг уже с кем-то играет.</td></tr>
  <?php endif ?>

  <?php if (isset($likelogins)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Ваш логин и логин вашего друга не должны совпадать.</td></tr>
  <?php endif ?>

  <?php if (isset($nofriend)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Аккаунт друга не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неверный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($nomore)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Вы не можете больше приглашать друзей.</td></tr>
  <?php endif ?>

  <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;"><b>Внимание!</b> Функция работает только в мире FrostMourne (x4 PvP)</td></tr>
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Логин друга</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','friend', 'style="width:300"')?></div>
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
