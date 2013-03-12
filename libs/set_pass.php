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
    if(preg_match("/([a-z]+)/", $pass))
    {
        $strength++;
    }

    // буквы (большие)
    if(preg_match("/([A-Z]+)/", $pass))
    {
        $strength++;
    }

    // числа
    if(preg_match("/([0-9]+)/", $pass))
    {
        $strength++;
    }

    // символы
    if(preg_match("/(W+)/", $pass))
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

  $key=$_GET['key'];

db_set_active('');
if ($massiv=db_fetch_array(db_query('SELECT username, email, uniq_hash, date FROM passwd_queue WHERE uniq_hash=%s',$key)))do{
    if($massiv['date']<time())
    {
        db_result(db_query('DELETE FROM passwd_queue WHERE username=%s', $massiv['username'])); // удаляем запись, если устарела
        $oldrecord =  true;
        break;
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
            '#id' => 'pass',
            '#type' => 'password',
            '#required' => true
        )
    );

    form_set('form',
        array(
            '#id' => 'passreply',
            '#type' => 'password',
            '#required' => true
        )
    );      

    form_set('form',
        array(
            '#id' => 'sbm',
            '#type' => 'submit',
            '#value' => 'Сменить пароль'
        )
    );
      
    if (form_validate('form'))
    do {
        $v = form_values('form');

        // проверяем пароль для игры на безопасность
        if(сheckPass($v['pass'])<4)
        {
            $passwrong=true;
            break;
        }

        if($v['pass']!==$v['passreply'])
        {
            $wrongpasswords = true;
            break;
        }

        db_query('UPDATE account SET sha_pass_hash = SHA1(%s), v=0, s=0 where username = %s', strtoupper($massiv['username'] . ':' . $v['pass']), $massiv['username']);
        header('Location: /tool/set_password/?done');
        exit;
    } while (false);
  }while (false)
?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Пароль изменён.</td></tr>
</table>
</div>
</div>

<?php elseif(isset($massiv)): ?>

<?php echo form_get('form', 'header')?>
<div class="tool_desc" style="position: absolute">
<br>
<h3>Смена пароля</h3>
<p>
Забыли пароль или пострадали от взлома?<br>
Не беда, здесь Вы можете поменять пароль<br>
от своего аккаунта<br>
Требования к новому паролю:
    <blockquote>
    Длина должна превышать 8 символов.<br>
    Должен содержать:
        <blockquote>
        Большие буквы<br>
        Маленькие буквы<br>
        Цифры<br>
        Знаки (!$#%@)<br>
        </blockquote>
    <b>Не должен содержать символы из русского языка.</b>
    </blockquote>
</p>
</div>
<table width="100%">

  <?php if (isset($oldrecord)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Срок действия запроса на изменения пароля закончен! Начните все заново!</td></tr>
  <?php endif ?>

  <?php if (isset($passwrong)): ?>
      <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Пароль не удовлетворяет требованиям безопасности.</td></tr>
  <?php endif ?>

  <?php if (isset($wrongpasswords)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Пароли не совпдают.</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Новый пароль</td><td>
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
  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">Повторите пароль</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','passreply', 'style="width:300"')?></div>
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
