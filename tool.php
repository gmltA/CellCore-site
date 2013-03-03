<?php
ob_start();
function chk($v, $k, $d = NULL) {
  return isset($v[$k]) ? $v[$k] : $d;
}
global $file, $title, $logo;
$page = current(explode('?', $_SERVER['REQUEST_URI']));
$page = trim($page, '/');
switch ($page)
{
    case 'tool/acc_ban':
    case 'tool/char_ban':
    case 'tool/unstuck':
    case 'tool/pets':
    case 'tool/dual_spec':
    case 'tool/char_restore':
    case 'tool/customize':
    case 'tool/changefaction':
    case 'tool/changerace':
    case 'tool/invite_friend':
    case 'tool/confirm_friend':
    case 'tool/remove_friend':
    case 'tool/change_password':
    case 'tool/set_password':
    case 'tool/control':
        header('Location: http://lk.riverrise.net/');
        exit;
        break;
    case 'tool/registration':
        $file = dirname(__FILE__) . '/blocks/registration.php';
        $title = 'Регистрация';
        //$logo = 'registration';
        break;
    case 'tool/activation':
        $file = dirname(__FILE__) . '/blocks/activation.php';
        $title = 'Активация';
        //$logo = 'registration';
        break;
    case 'tool/kompromat':
        $file = dirname(__FILE__) . '/blocks/logs.php';
        $title = 'Логи';
        break;
    case 'tool/verysreg':
        $file = dirname(__FILE__) . '/blocks/adminsreg.php';
        $title = 'Упрощённая регистрация';
        break;
    /*case 'tool/forum_queue':
        $file = dirname(__FILE__) . '/blocks/forum_queue.php';
        $title = 'Запрос на активацию форума';
        break;
    case 'tool/forum_activation':
        $file = dirname(__FILE__) . '/blocks/forum_activation.php';
        $title = 'Активация форума';
        break;*/

    default:
        $file = 'Service page. Go ahead!';
        $title = '0x0000000';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?> - WorldOfWarcraft.by</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="tool_logo <?php echo $logo?>"></div>
<div class="middle_plate">
<div class="wrapper">
<div class="middle_placeholder">
<div class="breadcrumb breadcrumbsub">
<div class="left"></div>
<div class="center">
<div class="ref">
<div class="contents">
<div class="link"><a href="/">Главная</a></div>
<div class="arrowsm"></div>
<div class="link"><a href="/tools/">Инструменты</a></div>
<div class="arrowsm"></div>
<div class="text"><?php echo $title; ?></div>
</div>
</div>
</div>
<div class="right"></div>
</div>
<?php
require_once dirname(__FILE__) . '/blocks/includes/config.php';
require_once dirname(__FILE__) . '/blocks/includes/database.inc.php';
$member_id = $_COOKIE['member_id'];
global $group;
$group = 3;
if ($member_id != 0)
{
    db_set_active('_forum');
    $group = db_fetch_array(db_query('SELECT member_group_id FROM ibf_members WHERE member_id=%s', $member_id));
}
?>

<!--<?php// if ($group == 0 || $group == 1 || $group == 3 || $group == 14):?>
<div class="middle_placeholder" align="center" style="min-height: 400px; margin-top: 50px;">
<div class="result_box" style="margin: 0; padding: 0;" >
<div class="result_content">
    <h3 style="color: red;">Access denied!</h3>
    <table width="100%" style="margin-top: 50px;">
    <tr><td colspan="2" style="color: red; text-shadow: 0px 0px 8px red;">Либо вам запрещён сюда доступ, либо очистите cookies и авторизируйтесь на форуме!</td></tr>
</table>
</div>
</div>
</div>-->
<?php// else:?>

<?php 
if ($title != '0x0000000')
        include $file;
      else
        echo '<h3 style="color: #a6f2ff; text-align: center;">'.$file.'</h3><hr>';?>
</div>
<div class="landing-footer">
        <div class="footer">
            <a href="/core/" class="logo-core"></a>
            <a href="/about/" class="logo-dev"></a>
            <div class="footercontents">
                <div class="footercontents_int">
                    <div class="links">
                        <a href="http://besthost.by/" target="_blank">Лучший хостинг</a>
                        <span class="spacer">|</span>
                        <a href="http://vitebsk.biz/" target="_blank">Vitebsk.biz</a>
                        <span class="spacer">|</span>
                        <a href="http://metki.by/" target="_blank">Карта Беларуси</a>
                        <span class="spacer">|</span>
                        <a href="http://twitter.com/CellCoreProject" target="_blank">Follow us on Twitter - @CellCoreProject</a>
                    </div>
                    <br/>
                    <br/>
                    <p class="dark">
                     Все товарные знаки являются собственностью соответствующих владельцев. 
                    <br/>
                     © worldowarcraft.by 2008-<?php echo date('Y')?> г. Все права защищены. 
                    </p>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
<?php// endif ?>
