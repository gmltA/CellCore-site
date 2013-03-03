<?php
require_once dirname(__FILE__) . '/includes/config.php';
require_once dirname(__FILE__) . '/includes/database.inc.php';

function get_time($t)
{
  list($h, $m, $s) = explode(':', $t);
  $d = $h > 24 ? floor($h / 24) . ' д.' : '';
  
  if ($d)  $h -= 24*$d;
  
  return "{$d} {$h} ч. {$m} мин.";
}

function get_data()
{
    global $uptime_4, $uptime_1, $uptime_f, $uptime_100,
           $muptime_4, $muptime_1, $muptime_f, $muptime_100,
           $online_4, $honline_4, $aonline_4,
           $online_1, $honline_1, $aonline_1,
           $online_100, $honline_100, $aonline_100,
           $online_f, $honline_f, $aonline_f,
           $statex4, $statex1, $statefun, $statex100;
    db_set_active('');
    $muptime_4 = get_time(db_result(db_query('SELECT SEC_TO_TIME(Max(uptime)) FROM uptime WHERE realmid = 1')));
    $uptime_4 = get_time(db_result(db_query('SELECT SEC_TO_TIME(uptime) FROM uptime WHERE realmid=1 ORDER BY starttime DESC LIMIT 1')));
    $fp = @fsockopen('logon.riverrise.net' , 8085, $errno, $errstr, 1);
    if($fp >= 1){
    $statex4 = 'online';
    } else {
    $statex4 = 'offline';
    };
    $honline_4 = db_result(db_query('SELECT COUNT(*) FROM tcharx4.characters WHERE race IN (2, 5, 6, 8, 10) AND online = 1'));
    $aonline_4 = db_result(db_query('SELECT COUNT(*) FROM tcharx4.characters WHERE race IN (1, 3, 4, 7, 11) AND online = 1'));
    $online_4 = (int)$honline_4 + (int)$aonline_4;
    $muptime_1 = get_time(db_result(db_query('SELECT SEC_TO_TIME(Max(uptime)) FROM uptime WHERE realmid = 5')));
    $uptime_1 = get_time(db_result(db_query('SELECT SEC_TO_TIME(uptime) FROM uptime WHERE realmid=5 ORDER BY starttime DESC LIMIT 1')));
    $fp = @fsockopen('logon.riverrise.net' , 8087, $errno, $errstr, 1);
    if($fp >= 1){
    $statex1 = 'online';
    } else {
    $statex1 = 'offline';
    };
    $honline_1 = db_result(db_query('SELECT COUNT(*) FROM tcharfun.characters WHERE race IN (2, 5, 6, 8, 10) AND online = 1'));
    $aonline_1 = db_result(db_query('SELECT COUNT(*) FROM tcharfun.characters WHERE race IN (1, 3, 4, 7, 11) AND online = 1'));
    $online_1 = (int)$honline_1 + (int)$aonline_1;
    $muptime_100 = get_time(db_result(db_query('SELECT SEC_TO_TIME(Max(uptime)) FROM uptime WHERE realmid = 3')));
    $uptime_100 = get_time(db_result(db_query('SELECT SEC_TO_TIME(uptime) FROM uptime WHERE realmid = 3 ORDER BY starttime DESC LIMIT 1')));
    $fp = @fsockopen('logon.riverrise.net' , 8088, $errno, $errstr, 1);
    if($fp >= 1){
    $statex100 = 'online';
    } else {
    $statex100 = 'offline';
    };
    $honline_100 = db_result(db_query('SELECT COUNT(*) FROM tcharx100.characters WHERE race IN (2, 5, 6, 8, 10) AND online = 1'));
    $aonline_100 = db_result(db_query('SELECT COUNT(*) FROM tcharx100.characters WHERE race IN (1, 3, 4, 7, 11) AND online = 1'));
    $online_100 = (int)$honline_100 + (int)$aonline_100;
    $muptime_f = get_time(db_result(db_query('SELECT SEC_TO_TIME(Max(uptime)) FROM uptime WHERE realmid = 2')));
    $uptime_f = get_time(db_result(db_query('SELECT SEC_TO_TIME(uptime) FROM uptime WHERE realmid=2 ORDER BY starttime DESC LIMIT 1')));
    $fp = @fsockopen('logon.riverrise.net' , 8086, $errno, $errstr, 1);
    if($fp >= 1){
    $statefun = 'online';
    } else {
    $statefun = 'offline';
    };
    $honline_f = db_result(db_query('SELECT COUNT(*) FROM tcharx1.characters WHERE race IN (2, 5, 6, 8, 10) AND online = 1'));
    $aonline_f = db_result(db_query('SELECT COUNT(*) FROM tcharx1.characters WHERE race IN (1, 3, 4, 7, 11) AND online = 1'));
    $online_f = (int)$honline_f + (int)$aonline_f;
}

get_data();
?>
<div class="statbox" style="line-height: 15px;">
<a href="http://forum.riverrise.net/index.php?showforum=5" class="realmname x4"></a>
<div class="state <?php echo $statex4; ?>"></div>
<table class="stats">
  <tr>
    <td width="14%">Всего онлайн</td>
    <td width="3%">
        <?php
            echo $online_4;
        ?>
    </td>
    <td width="15%">Максимальное время работы</td>
    <td width="10%">
        <?php  
            echo $muptime_4;
        ?>
    </td>
  </tr>
  <tr>
    <td>Альянс онлайн</td>
    <td>
        <?php
            echo $aonline_4;
        ?>
     </td>
    <td>Текущее время работы</td>
    <td class="uptime">
        <?php
            echo $uptime_4;
       ?>
    </td>
  </tr>
  <tr>
    <td>Орда онлайн</td>
    <td>
        <?php
            echo $honline_4;
        ?>
     </td>
  </tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="statbox" style="line-height: 15px;">
<a href="http://forum.riverrise.net/index.php?showforum=237" class="realmname fun"></a>
<div class="state <?php echo $statefun; ?>"></div>
<table class="stats">
  <tr>
    <td width="14%">Всего онлайн</td>
    <td width="3%">
        <?php
            echo $online_f; 
        ?>
    </td>
    <td width="15%">Максимальное время работы</td>
    <td width="10%">
        <?php
            echo $muptime_f;
        ?>
    </td>
  </tr>
  <tr>
    <td>Альянс онлайн</td>
    <td>
        <?php
            echo $aonline_f;
        ?>
     </td>
    <td>Текущее время работы</td>
    <td class="uptime">
        <?php
            echo $uptime_f;
       ?>
    </td>
  </tr>
  <tr>
    <td>Орда онлайн</td>
    <td>
        <?php
            echo $honline_f;
        ?>
     </td>
  </tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="statbox" style="line-height: 15px;">
<a href="http://forum.riverrise.net/index.php?showforum=6" class="realmname x1"></a>
<div class="state <?php echo $statex1; ?>"></div>
<table class="stats">
  <tr>
    <td width="14%">Всего онлайн</td>
    <td width="3%">
        <?php
            echo $online_1;  
        ?>
    </td>
    <td width="15%">Максимальное время работы</td>
    <td width="10%">
        <?php
            echo $muptime_1;
        ?>
    </td>
  </tr>
  <tr>
    <td>Альянс онлайн</td>
    <td>
        <?php
            echo $aonline_1;
        ?>
     </td>
    <td>Текущее время работы</td>
    <td class="uptime">
        <?php
            echo $uptime_1;
       ?>
    </td>
  </tr>
  <tr>
    <td>Орда онлайн</td>
    <td>
        <?php
            echo $honline_1;
        ?>
     </td>
  </tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="statbox" style="line-height: 15px;">
<div class="realmname x100"></div>
<div class="state <?php echo $statex100; ?>"></div>
<table class="stats">
  <tr>
    <td width="14%">Всего онлайн</td>
    <td width="3%">
        <?php
            echo $online_100;  
        ?>
    </td>
    <td width="15%">Максимальное время работы</td>
    <td width="10%">
        <?php
            echo $muptime_100;
        ?>
    </td>
  </tr>
  <tr>
    <td>Альянс онлайн</td>
    <td>
        <?php
            echo $aonline_100;
        ?>
     </td>
    <td>Текущее время работы</td>
    <td class="uptime">
        <?php
            echo $uptime_100;
       ?>
    </td>
  </tr>
  <tr>
    <td>Орда онлайн</td>
    <td>
        <?php
            echo $honline_100;
        ?>
     </td>
  </tr>
</table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>