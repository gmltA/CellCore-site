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
 
    db_set_active('_forum');// ативируем базу форума
    // проверяем в account, нет ли емэйла, на кторый пытаются зарегистрироваться!!!
    if ($massiv = db_fetch_array(db_query('SELECT name, email FROM ibf_members WHERE name=%s', $v['name'])))
    {
        if (empty($massiv['email']))
        {
            $emailisempty = true;
            break;
        }

        //проверяем на уникальность псевдонима
        if ($group = db_result(db_query('SELECT member_group_id FROM ibf_members WHERE name=%s', $massiv['name']))) 
        {
            if($group > 1)
            {
                $forumisactivated = true;
                break;
            }
        }

        db_set_active('');
        if (db_result(db_query('SELECT email FROM reg_queue WHERE email=%s', $massiv['email']))) 
        {
            $tryexists = true;
            break;
        }	

        // проверка на наличие попытки смены пароля в базе
        if ($date = db_result(db_query('SELECT date FROM reg_queue WHERE name=%s', $v['name'])))
        {
            if ($date < time())
            {
                db_query('DELETE FROM reg_queue WHERE name=%s', $v['name']); // удаляем запись, если устарела
            }
            else
            {
                $tryexists = true;
                break;
            }
        }

        $hash = md5(time().rand(1,1000));
        $nex_date = time()+86400;
        db_query('INSERT INTO reg_queue SET email = %s, uniq_hash = %s, date =%s ', $massiv['email'], $hash, $nex_date);

        $message = '<b>Приветствуем, '.strtoupper($v['name']).'</b><br><br>'; // формируем поле письма
        $message = $message.'Данное письмо было отослано Вам автоматически, так как была подана заявка на активацию учётной записи <b>'.strtoupper($v['name']).'</b> <a href="http://riverrise.net/">на нашем сервере</a><br>';
        $message = $message.'Если Вы действительно хотите задействовать этот аккаунт для использования других сервисов, перейдите по следующей ссылке.<br><b><a href="http://lk.riverrise.net/tool/forum_activation/?key='.$hash.'">http://lk.riverrise.net/tool/forum_activation/?key='.$hash.'</a></b><br><br>';
        $message = $message.'Если Вы считаете, что это письмо было отослано Вам по ошибке, просто проигнорируйте его.<br><br>';
        $message = $message.'<b>Приятной игры на сервере.</b><br> Администрация riverrise.net';

        require_once("mailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->From = 'service@riverrise.net';
        $mail->FromName = 'Администрация RiverRise.net';
        $mail->AddAddress($massiv['email']);
        $mail->Subject = "Запрос активации";
        $mail->Body = $message;
        $mail->isHTML(true);
        if(!$mail->Send())
        {
            $answer = $mail->ErrorInfo;
        }

        header('Location: /tool/forum_queue/?done');
        exit;
    }
    else
    {
        $no_acc = true;
        break;
    }
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

  <?php if (isset($emailisempty)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Отсутствует полчтовый ящик. Активация невозможна!</td></tr>
  <?php endif ?>

  <?php if (isset($tryexists)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">>Старый запрос активации ещё в силе!</td></tr>
  <?php endif ?>

  <?php if (isset($forumisactivated)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Учётная запись уже активирована.</td></tr>
  <?php endif ?>

  <?php if (isset($no_acc)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Учётная запись не найдена.</td></tr>
  <?php endif ?>


  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Имя пользователя</td><td>
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
  <tr><td colspan="2" style="line-height: 0.4em">&nbsp</td></tr>
  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>
  
</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
