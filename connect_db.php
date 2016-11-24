<?php
error_reporting(0);

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'botnet');

if (!$db=@mysql_connect(DB_HOST, DB_USER, DB_PASS))
{
	die ("<b>Doslo je do greske prilikom spajanja na MySQL...</b>");
}

if (!mysql_select_db(DB_NAME, $db))
{
	die ("<b>Greska prilikom biranja baze!</b>");
}

// Podesavanja linkova - Error pages 404

$defconPass = "user+pass"; // Defcon podaci. Obavezno + mora da bude. (PRIMER = kevia+keviapass)

$sajt_name = "GameHoster.biz"; // Naziv sajta
$sajt_link = "http://gamehoster.biz"; // Link sajta zeljenog sajta

// Kategorije

$allow_method_normal = array(
	'DNS'				=> 'DNS',
	'DNS-Sec'			=> 'DNS-Sec',
	'NTP'				=> 'NTP',
	'SNMP'				=> 'SNMP',
	'TFTP'				=> 'TFTP',
	'OVH'				=> 'OVH',
	'STORM'				=> 'STORM',
	'NINJA'				=> 'NINJA',
	'SOURCE'			=> 'SOURCE',
	'REK'				=> 'REK',
	'PROLAND'			=> 'PROLAND',
	'PiSoland'			=> 'PiSoland',
	'XSYN'				=> 'XSYN',
	'XACK'				=> 'XACK',
	'XMAS'				=> 'XMAS'
);

$allow_method_premium = array(
	'TS3-Droper'		=> 'TS3-Droper',
	'TS3-Fuck'			=> 'TS3-Fuck',
	'PortMap'			=> 'PortMap',
	'WOLF'				=> 'WOLF',
	'ABUSE'				=> 'ABUSE',
	'GRENADE'			=> 'GRENADE'
);

$allow_method_game_premium = array(
	'GK_Steam'			=> 'GK_Steam',
	'GK_Samp'			=> 'GK_Samp',
	'GK_MTA'			=> 'GK_MTA',
	'GK_Minecraft'		=> 'GK_Minecraft',
	'GK_Cod'			=> 'GK_Cod',
	'GK_BF'				=> 'GK_BF',
	'GK_CS'				=> 'GK_CS',
	'GK_Quake'			=> 'GK_Quake',
	'GK_Vicesity'		=> 'GK_Vicesity',
	'GK_TF'				=> 'GK_TF',
	'GK_MoH'			=> 'GK_MoH'
);

?>