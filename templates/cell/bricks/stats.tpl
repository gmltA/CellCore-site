{foreach from=$realms item=realm}
<div class="statbox" style="line-height: 15px;">
	<a href="http://forum.riverrise.net/index.php?showforum=5" class="realmname {$realm.class_name}"></a>
	<div class="state {$realm.state}"></div>
	<table class="stats">
	  <tr>
		<td width="14%">Всего онлайн</td>
		<td width="3%">
			{$realm.online}
		</td>
		<td width="15%">Максимальное время работы</td>
		<td width="10%">
			{$realm.max_uptime}
		</td>
	  </tr>
	  <tr>
		<td>Альянс онлайн</td>
		<td>
			{$realm.alliance_online}
		 </td>
		<td>Текущее время работы</td>
		<td class="uptime">
			{$realm.uptime}
		</td>
	  </tr>
	  <tr>
		<td>Орда онлайн</td>
		<td>
			{$realm.horde_online}
		</td>
	  </tr>
	</table>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
{/foreach}