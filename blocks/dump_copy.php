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

// поле для ввода логина
form_set('form',
  array(
    '#id' => 'guid',
    '#type' => 'text',
    '#required' => true
  )
);

form_set('form',
  array(
    '#id' => 'sbm',
    '#type' => 'submit',
    '#value' => 'Скопировать'
  )
);



if (form_validate('form')) do {
  $v = form_values('form');

  if(file_exists('/home/vovka/serv/tworld_x4/bin/' . $v['guid'])){
    copy('/home/vovka/serv/tworld_x4/bin/' . $v['guid'], '/home/vovka/serv/tworld_x1/bin/' . $v['guid']);
  }
  else {
   $error = true;
   break;
  }

//  unlink('/home/vovka/serv/tworld_x4/bin/'.$v['guid']);

  // *********************************
//  header('Location: /tool/dump_copy/?done');
  exit;

} while (false);

?>

<?php if (isset($_GET['done'])): ?>

<div class="result_box">
<div class="result_content">
    <h3>Результат</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: #07d100; text-shadow: 0px 0px 8px #07d100;">Перенесен</td></tr>
</table>
</div>
</div>

<?php else: ?>

<?php echo form_get('form', 'header')?>
<table width="100%">

  <?php if (isset($error)): ?>
      <tr><td>&nbsp</td><td style="color: red; text-shadow: 0px 0px 8px red;">Произошла ошибка!</td></tr>
  <?php endif ?>

  <tr><td align="right" style="padding-right: 15px; color: #FFFFFF; text-shadow: 0px 0px 8px white;">GUID</td><td>
  <div class="breadcrumb">
    <div class="left"></div>
            <div class="center">
                <div class="ref">
                    <div class="contents_i">
                        <div class="text"><?php echo form_get('form','guid', 'style="width:300"')?></div>
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
