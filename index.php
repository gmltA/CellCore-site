<?php
require_once dirname(__FILE__) . '/libs/includes/config.php';
ob_start();
function chk($v, $k, $d = NULL) {
  return isset($v[$k]) ? $v[$k] : $d;
}

$page = current(explode('?', $_SERVER['REQUEST_URI']));
$page = trim($page, '/');
global $filename, $title, $pagen;

switch ($page)
{
    case 'registration':
    {
        $filename = dirname(__FILE__) . '/libs/registration.php';
        $title = "Регистрация нового пользователя";
        $pagen = "reg";
        break;
    }
    case 'stats':
    {
        $filename = dirname(__FILE__) . '/libs/stats.php';
        $title = "Статистика реалмов";
        $pagen = "stats";
        break;
    }
    case 'rules':
    {
        $filename = dirname(__FILE__) . '/libs/rules.txt';
        $title = "Правила игры на сервере";
        $pagen = "rules";
        break;
    }
    case 'tools':
    {
        $filename = dirname(__FILE__) . '/libs/tools.php';
        $title = "Доступные функции";
        $pagen = "tools";
        break;
    }
    case 'dumpcopy':
    {
        $filename = dirname(__FILE__) . '/libs/dump_copy.php';
        $title = "Доступные функции";
        $pagen = "tools";
        break;
    }
    case 'hideip':
    {
        $filename = dirname(__FILE__) . '/libs/hide_ip.php';
        $title = "Доступные функции";
        $pagen = "tools";
        break;
    }
    case 'adminsreg':
    {
        $filename = dirname(__FILE__) . '/libs/adminsreg.php';
        $title = "Доступные функции";
        $pagen = "tools";
        break;
    }

    case 'forum':
    {
        $filename = dirname(__FILE__) . '/libs/forum.php';
        $title = "Доступные функции";
        $pagen = "tools";
        break;
    }

    default:
    {
        $filename = dirname(__FILE__) . '/libs/main.txt';
        $title = "RiverRise.net | World of Warcraft.by";
        $pagen = "main";
        break;
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="robots" content="index,follow"/>
<meta name="keywords" content="Игровой сервер World Of Warcraft, бесплатный сервер вов, играть в вов, сервер вов, бесплатный сервер wow, поиграть в wow, играть в wow, сервер wow, wow 3.3.5., сервер wow 3.3.5, вов 3.3.5, wow wotlk, игровой сервер wotlk, CellCore, worlfowarcraft.by, riverrise.net, RiverRise"/>
<meta name="description" content="RiverRise.net\WorldOfWarcraft.by - это лучший бесплатный сервер WoW WOTLK со множеством уникальных особенностей!"/>
<meta http-equiv="Content-Language" content="ru"/>
<script src="/jquery.min.js" type="text/javascript"></script>
<script src="/jquery.cellAPI.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
$(init);

function init() {
    $('.nbutton').bind('click', current); 
}

function current()
{
    if ($(this).hasClass("active"))
        return;

    theButtons = $(".nbutton");

    $(this).addClass('active');
    /*if ($(this).hasClass('stats'))
    {
        $('#text_body').load('libs/stats.php');
        $('#title_box').text("Статистика реалмов");
    }
    else if ($(this).hasClass('rules'))
    {
        $('#text_body').load('libs/rules.txt');
        $('#title_box').text("Правила игры на сервере");
    }
    else if ($(this).hasClass('tools'))
    {
        $('#text_body').load('libs/tools.php');
        $('#title_box').text("Доступные функции");
        $('#bar').addClass('toolsbg');
    }*/
    for (var i = 0; i <= theButtons.length; i++) 
    {
        if ($(theButtons[i]).hasClass('active') && theButtons[i] != this)
        {
            $(theButtons[i]).removeClass('active');
            if ($(theButtons[i]).hasClass('tools'))
            {
                $('#bar').removeClass('toolsbg');
            }
        }
    }
}

window.oncontextmenu = function()
{
    return false;
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RiverRise.net - уникальный бесплатный сервер World of Warcraft</title>

<link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<?php
    require_once dirname(__FILE__) . '/libs/db.php';
    global $fDB;

    $member_id = $_COOKIE['member_id'];
    global $member_name;

    if ($member_id != 0)
    {
        $forum_data = $fDB->select('SELECT member_group_id, members_display_name, skin FROM ?_members WHERE member_id = ?d', $member_id);
        if ($forum_data || isset($_SESSION['username']))
            $member_name = "Logged in as <b>".$_SESSION['username']."</b>";
    }
    else
    {
        $member_name = "Hello, <b>Guest</b>";
        $forum_data['skin'] = $_COOKIE['guestSkinChoice'];
    }
    global $skin, $group;
    $group = 3;
    $group = $forum_data['member_group_id'];
    $skin = 'riverrise';
    if ($forum_data['skin'] == '55')
    {
        $skin = 'master';
    }
?>
<body class="<?php echo $skin?>">
<div class="content">
<header>
<div id="header_bar" class="clearfix">
    <div class="main_width">
        <div class="info user"><?php echo $member_name?></div>
    </div>
</div>
<div id="branding">
    <div class="main_width">
        <div id="logo">
            <a href='http://forum.riverrise.net' title='Перейти к списку форумов' rel="home" accesskey='1'>
            <img src='http://forum.riverrise.net/public/style_images/<?php echo ($skin == 'riverrise') ?  "CS" : $skin?>/logo.png' alt='Логотип'/></a>
        </div>
    </div>
</div>
<div id="primary_nav" class="clearfix">
    <div class="main_width">
        <ul>
            <li class="left active">
            <a href="http://riverrise.net" title="Перейти на сайт" rel="home">RiverRise.net</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net" title="Перейти к списку форумов">Форумы</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net/index.php?app=members&module=list" title="Перейти к списку пользователей">Пользователи</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net/index.php?app=tracker" title="Перейти к BugTracker'у">Ошибки</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net/index.php?app=gallery" title="Перейти к галереи">Галерея</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net/index.php?app=blog" title="Перейти к блогам">Блоги</a>
            </li>
            <li class="left">
            <a href="http://forum.riverrise.net/index.php?app=jawards" title="Перейти к списку наград">Награды</a>
            </li>
            <li class="right">
            <a href="http://data.riverrise.net/" title="Перейти к базе знаний">База знаний WoW</a>
            </li>
        </ul>
    </div>
</div>
</header>
<!--<?php// if ($group == 0 || $group == 1 || $group == 3 || $group == 14):?>
<div align="center" style="margin-top: 100px;">
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
<div class="wrapper">
<div class="left_column">
<div id="nav_buttons">
    <ul>
        <li>
            <a href="/"><div class="nbutton main <?php if ($pagen == "main") echo "active"?>" title="Главная страница"></div></a>
        </li>
        <li>
            <a href="/registration/"><div class="nbutton reg <?php if ($pagen == "reg") echo "active"?>" title="Регистрация пользователей"></div></a>
        </li>
        <li>
            <a href="/stats/"><div class="nbutton stats <?php if ($pagen == "stats") echo "active"?>" title="Состояние миров"></div></a>
        </li>
        <li>
            <a href="/rules/"><div class="nbutton rules <?php if ($pagen == "rules") echo "active"?>" title="Правила сервера"></div></a>
        </li>
        <li>
            <a href="http://lk.riverrise.net/"><div class="nbutton tools <?php if ($pagen == "tools") echo "active"?>" title="Личный кабинет"></div></a>
        </li>
    </ul>
</div>
</div>
<div class="right_column">
    <a href="http://forum.riverrise.net/topic/45746/">
        <div class="top_banner"></div>
    </a>
    <div class="standardbox">
        <div class="topbar">
            <div class="leftcorner"></div>
            <div class="rightcorner"></div>
            <div class="middle">
                <div class="rightfade"></div>
                <h1 class="title" id="title_box" ><?php echo $title;?></h1>
            </div>
        </div>
        <div class="middlebar <?php if ($pagen == "tools") echo "toolsbg"?>" id="bar">
        <?php if ($pagen != "tools" && $pagen != "stats"):?>
            <div class="backgroundhex main" id="hex_main">
            <!-- Это прозрачный блок-->
            </div>
            <div class="backgroundhex reg" id="hex_reg">
            <!-- Это прозрачный блок-->
            </div>
            <div class="backgroundhex stats" id="hex_stats">
            <!-- Это прозрачный блок-->
            </div>
            <div class="backgroundhex rules" id="hex_rules">
            <!-- Это прозрачный блок-->
            </div>
            <div class="backgroundhex tools" id="hex_tools">
            <!-- Это прозрачный блок-->
            </div>
        <?php endif?>
            <div class="line">
                <div class="description" id="text_body">
                    <?php include $filename ?>
                </div>
            </div>
        </div>
        <div class="bottombar">
            <div class="middle">
                <div class="leftcorner"></div>
                <div class="rightcorner"></div>
            </div>
        </div>
        <div class="shadowbar">
            <div class="line"></div>
            <div class="shadow"></div>
        </div>
    </div>
    
<?php
if ($pagen == "main")
{
    global $DB;
    $newsList = $DB->select('SELECT id, title, content, date FROM ?_news');

    foreach ($newsList as $key=>$newsEntry)
    {
        echo '<div class="standardbox">
                <div class="topbar">
                    <div class="leftcorner"></div>
                    <div class="rightcorner"></div>
                    <div class="middle">
                        <div class="rightfade"></div>
                        <h1 class="title" id="title_box" style="display: inline-block;">'.$newsEntry["title"].'</h1>
                        <span style="display: inline-block; height: 44px; line-height: 40px; float: right; font-size: 11px; color: #5D91A3;">'.$newsEntry["date"].'</span>
                    </div>
                </div>
                <div class="middlebar" id="bar">
                    <div class="line">
                        <div class="description" id="text_body">
                            '.$newsEntry["content"].'
                        </div>
                    </div>
                </div>
                <div class="bottombar">
                    <div class="middle">
                        <div class="leftcorner"></div>
                        <div class="rightcorner"></div>
                    </div>
                </div>
                <div class="shadowbar">
                    <div class="line"></div>
                    <div class="shadow"></div>
                </div>
            </div>';
    }
}
?>
</div>
<div class="clearfix" ></div>
</div>
</div>
    <?php include dirname(__FILE__) . '/footer.inc' ?>
</body>
</html>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter18260830 = new Ya.Metrika({id:18260830,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/18260830" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?php// endif ?>
