<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>О ядре - RiverRise.net</title>
<link href="/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="tool_logo core"></div>
<div class="middle_plate" style="margin-top: 200px;">
<div class="wrapper">
<div class="middle_placeholder" style="min-height: 750px;">
<div class="breadcrumb breadcrumbsub">
<div class="left"></div>
<div class="center">
<div class="ref">
<div class="contents">
<div class="link"><a href="/">Главная</a></div>
<div class="arrowsm"></div>
<div class="text">О проекте</div>
</div>
</div>
</div>
<div class="right"></div>
</div>
<div class="content">
    <div class="about_p_core"></div>
    <div class="sub_">
    <div style="float: right;">
    <script src="http://widgets.twimg.com/j/2/widget.js"></script>
        <script>
        new TWTR.Widget({
          version: 2,
          type: 'profile',
          rpp: 5,
          interval: 30000,
          width: 260,
          height: 400,
          theme: {
            shell: {
              background: '#2b2b2b',
              color: '#ffffff'
            },
            tweets: {
              background: '#000000',
              color: '#ffffff',
              links: '#05a8ed'
            }
          },
          features: {
            scrollbar: false,
            loop: false,
            live: false,
            hashtags: true,
            timestamp: true,
            avatars: false,
            behavior: 'all'
          }
        }).render().setUser('CellCoreProject').start();
        </script>
    </div>
        <b>CellCore</b> - проект, представляющий собой модифицированный и доработанный эмулятор TrinityCore и модифицированную базу данных, основанную на слиянии YTDB и TDB.
        Основными особенностями ядра являются:
        <ul>
        <li><b>Работоспособность</b> заклинаний\квестов\подземелий\праздников значительно выше по сравнению с TrinityCore и некоторыми другими модификациями этого ядра
        <li><b>Уникальность</b> скриптов квестов\праздников\подземелий, которая позволит Вам испытать то, что Вы никогда не сможете опробовать на других проектах
        <li><b>Стабильность</b> значительно выше, по сравнению с другими ядрами такого уровня модификации
        <li><b>Защищённость</b> ядра обеспечивает 2 Античит-системы вкупе с различными уникальными доработками, включая используемый на официальном сервере клиент Warden
        </ul>
    </div>
</div>
    <?php include dirname(__FILE__) . '/footer.inc' ?>
</div>
</div>
</body>
</html>
