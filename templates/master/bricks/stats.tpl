{foreach from=$realms item=realm}
	<div class="statbox">
		<a href="{$realm.stat_link}" class="realmname {$realm.class_name}"></a>
		<div class="state {$realm.state}"></div>
		<table class="stats">
		  <tr>
			<td width="14%">{$lang.full_online}</td>
			<td width="3%">
				{$realm.online}
			</td>
			<td width="15%">{$lang.max_uptime}</td>
			<td width="10%">
				{$realm.max_uptime}
			</td>
		  </tr>
		  <tr>
			<td>{$lang.alliance_online}</td>
			<td>
				{$realm.alliance_online}
			 </td>
			<td>{$lang.current_uptime}</td>
			<td class="uptime">
				{$realm.uptime}
			</td>
		  </tr>
		  <tr>
			<td>{$lang.horde_online}</td>
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