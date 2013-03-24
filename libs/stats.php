<?php

if (!defined('IS_IN_ENGINE'))
{
    header('HTTP/1.1 403 Forbidden');
    die('<h1>403 Forbidden</h1>');
}

function GetRealmStats()
{
	global $config;
	global $rDB;
	global $cDB;

	$stats = array();
	foreach ($config['realms'] as $key=>$realm)
	{
		$uptimeData = $rDB[$key]->selectRow('SELECT SEC_TO_TIME(MAX(uptime)) AS max_uptime, SEC_TO_TIME(uptime) AS uptime FROM uptime WHERE realmid = ?d ORDER BY starttime DESC LIMIT 1', $realm['realm_host']);
		
		$horde_online = $cDB[$key]->selectCell('SELECT COUNT(*) FROM characters WHERE race IN (2, 5, 6, 8, 10) AND online = 1');
		$alliance_online = $cDB[$key]->selectCell('SELECT COUNT(*) FROM characters WHERE race IN (1, 3, 4, 7, 11) AND online = 1');
		$online = (int)$horde_online + (int)$alliance_online;
		
		$fp = @fsockopen($realm['realmlist'], $realm['realm_port'], $errno, $errstr, '1');
		$state = ($fp) ? 'online' : 'offline';
		$stats[] = array(
			'class_name' 		=> 	$realm['rates'],
			'online' 			=> 	$online,
			'alliance_online' 	=> 	$alliance_online,
			'horde_online'		=>	$horde_online,
			'uptime'			=>	get_time($uptimeData['uptime']),
			'max_uptime'		=>	get_time($uptimeData['max_uptime']),
			'state'				=>	$state
		);
	}
	return $stats;
}
