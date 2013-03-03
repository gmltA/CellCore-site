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

  $key=$_GET['key']; // получаем ключ из ссылки

db_set_active('');
// проверяем ключи на валидность и дальше форумируем форму для ативации игрового ака
if ($massiv=db_fetch_array(db_query('SELECT username, uniq_hash, date, recruiter FROM friend_invite WHERE uniq_hash=%s',$key)))
do{
    // чистим запросы на регистрацию
    if($massiv['date']<time())
    {
        db_result(db_query('DELETE FROM friend_invite WHERE uniq_hash=%s', $key)); // удаляем запись, если устарела
        $oldrecord =  true;
        break;
    }
    //db_query('DELETE FROM friend_invite WHERE date < %s', get_time());

    form_set(
        array(
            '#id' => 'form',
            '#action' => '',
            '#method' => 'post',
            '#js' => true
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

    // кнопка активации
    form_set('form',
        array(
            '#id' => 'sbm',
            '#type' => 'submit',
            '#value' => 'Принять приглашение'
        )
    );
          
    if (form_validate('form'))
    do{
        $v = form_values('form');
        $pass = SHA1(strtoupper($massiv['recruiter'] . ':' . $v['pass']));

        //проверяем пароль от ака
        if ($massiv2=db_fetch_array(db_query('SELECT sha_pass_hash, recruiter FROM account WHERE username=%s', $massiv['recruiter'])))
        {
            if($massiv2['sha_pass_hash'] != $pass)
            {
                $wrongpass = true;
                break;
            }

            if ($massiv2['recruiter'] != 0)
            {
                $friendbusy =  true;
                break;
            }
        }

        // прописываем друзей
        if ($id=db_result(db_query('SELECT id FROM account WHERE username=%s', $massiv['username'])))
        {
            db_query('UPDATE account SET recruiter=%s where username=%s', $id, $massiv['recruiter']);
        }
        else
        {
            $nofriend = true;
            break;
        }

        db_query('DELETE FROM friend_invite where uniq_hash=%s', $key);
        header('Location: /tool/confirm_friend/?done');
        exit;
    }while (false);
}while (false)
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Вас успешно добавили в друзья!</td></tr>
</table>
</div>
</div>

<?php elseif(isset($massiv)): ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Вам предложили дружбу!</h3>
<p>
Вас ждут следующие преимущества:
    <blockquote>
    В <b>3</b> раза ускоренный набор опыта.<br>
    Призыв друга к себе раз в час.<br>
    Приглашённый может отдать один уровень<br>
    пригласившему игроку за каждые два<br>
    набранных уровня.
    </blockquote>
</p>
</div>
<table width="90%" style="margin-left: 100px">

  <?php if (isset($false)): ?>
      <tr><td colspan="2" style="color: red"><?php echo $out?></td></tr>
  <?php endif ?>

  <?php if (isset($oldrecord)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Срок действия приглашения истёк!</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpass)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Неправильный пароль!</td></tr>
  <?php endif ?>

  <?php if (isset($nofriend)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Акаунт вашего друга не найден!</td></tr>
  <?php endif ?>

  <?php if (isset($friendbusy)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Вы уже с кем-то играете!</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Ваш пароль</td><td>
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
