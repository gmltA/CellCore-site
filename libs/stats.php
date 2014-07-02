<?php

if (!defined('IS_IN_ENGINE'))
{
	header('HTTP/1.1 403 Forbidden');
	die('<h1>403 Forbidden</h1>');
}

require_once dirname(__FILE__) . '/defines.php';

function GetRealmStats()
{
	global $config;
	global $rDB;
	global $cDB;

	$stats = array();
	foreach ($config['realms'] as $key=>$realm)
	{
		$uptimeData = $rDB[$key]->selectRow('SELECT SEC_TO_TIME(uptime) AS uptime FROM uptime WHERE realmid = ?d ORDER BY starttime DESC LIMIT 1', $realm['realm_host']);
		$maxUptimeData = $rDB[$key]->selectRow('SELECT SEC_TO_TIME(MAX(uptime)) AS max_uptime FROM uptime WHERE realmid = ?d LIMIT 1', $realm['realm_host']);

		$racelist_horde = "";
		$racelist_alliance = "";
		if ($realm['gamebuild'] == GAMEBUILD_WOTLK)
		{
			$racelist_horde = RACE_ALL_HORDE_WOTLK;
			$racelist_alliance = RACE_ALL_ALLIANCE_WOTLK;
		}
		elseif ($realm['gamebuild'] == GAMEBUILD_CATA)
		{
			$racelist_horde = RACE_ALL_HORDE_CATA;
			$racelist_alliance = RACE_ALL_ALLIANCE_CATA;
		}

		if ($racelist_horde == "")
			die("Wrong gamebuild");

		$horde_online = $cDB[$key]->selectCell('SELECT COUNT(*) FROM characters WHERE race IN (' .  $racelist_horde . ') AND online = 1');
		$alliance_online = $cDB[$key]->selectCell('SELECT COUNT(*) FROM characters WHERE race IN (' . $racelist_alliance . ') AND online = 1');
		$online = (int)$horde_online + (int)$alliance_online;

		$fp = @fsockopen($realm['realmlist'], $realm['realm_port'], $errno, $errstr, '1');
		$state = ($fp) ? 'online' : 'offline';
		$stats[] = array(
			'class_name' 		=> 	$realm['rates'],
			'stat_link' 		=> 	$realm['stat_link'],
			'online' 			=> 	$online,
			'alliance_online' 	=> 	$alliance_online,
			'horde_online'		=>	$horde_online,
			'uptime'			=>	get_time($uptimeData['uptime']),
			'max_uptime'		=>	get_time($maxUptimeData['max_uptime']),
			'state'				=>	$state
		);
	}
	return $stats;
}
