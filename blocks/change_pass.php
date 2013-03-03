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
    '#id' => 'name',
    '#type' => 'text',
    '#required' => true,
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

    db_set_active('');
    if ($massiv=db_fetch_array(db_query('SELECT sha_pass_hash, email FROM account WHERE username=%s', $v['name'])))
    {
        // проверка на пустое мыло
        if (empty($massiv['email']))
        {
            $emailisempty = true;
            break;
        }

        // проверка на наличие попытки смены пароля в базе
        if ($date=db_result(db_query('SELECT date FROM passwd_queue WHERE username=%s', $v['name'])))
        {
            if ($date<time())
            {
                db_result(db_query('DELETE FROM passwd_queue WHERE username=%s', $v['name'])); // удаляем запись, если устарела
            }
            else
            {
                $tryexists = true;
                break;
            }
        }
        
        $hash =  md5(time() . rand(1,1000));
        $nex_date = time()+86400;
        db_query('INSERT into passwd_queue SET username = %s, email = %s, uniq_hash = %s, date =%s ', $v['name'], $massiv['email'], $hash, $nex_date);

        $message = '<b>Приветствуем, '.strtoupper($v['name']).'</b><br><br>'; // формируем поле письма
        $message = $message.'Данное письмо было отослано Вам автоматически, так как была подана заявка на изменение пароля от аккаунта <b>'.strtoupper($v['name']).'</b> <a href="http://riverrise.net/">на нашем сервере</a><br>';
        $message = $message.'Если Вы действительно хотите изменить пароль от аккаунта, перейдите по следующей ссылке.<br><b><a href="http://riverrise.net/tool/set_password/?key='.$hash.'">http://riverrise.net/tool/set_password/?key='.$hash.'</a></b><br><br>';
        $message = $message.'Если Вы считаете, что это письмо было отослано Вам по ошибке, просто проигнорируйте его.<br><br>';
        $message = $message.'<b>Приятной игры на сервере.</b><br> Администрация riverrise.net';

        require_once("mailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->From = 'service@riverrise.net';
        $mail->FromName = 'Администрация RiverRise.net';
        $mail->AddAddress($massiv['email']);
        $mail->Subject  =  "Запрос на смену пароля";
        $mail->Body=$message;
        $mail->isHTML(true);
        if (!$mail->Send())
        {
            $answer=$mail->ErrorInfo;
        }

        header('Location: /tool/change_password/?done');
        exit;
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
<table width="90%" style="margin-left: 100px">

  <?php if (isset($emailisempty)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Смена пароля для этого аккаунта невозможна. Отсутсвует емэйл!</td></tr>
  <?php endif ?>

  <?php if (isset($tryexists)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Еще активен старый запрос на изменения пароля для этого аккаунта!</td></tr>
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

  <tr><td></td><td><?php echo form_get('form', 'sbm', 'style="width: 170px"')?></td></tr>
  <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">При неудачной попытке смена пароля будет доступна только через день!</td></tr>

</table>
<?php echo form_get('form', 'footer')?>

<?php endif ?>
