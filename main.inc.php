<?php
/*
Plugin Name: Bots Be Gone
Version: auto
Description: Do not allow visits from search engine robots
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=
Author: xppppp
Author URI: 
*/
if (!defined('PHPWG_ROOT_PATH'))
{
  die('Hacking attempt!');
}
function botsBeGone() {
    $bots = array(
	  'Googlebot',
	  'bingbot',
	  'Baiduspider',
	  'yandex',
	  'AhrefsBot',
	  'msnbot',
	  'Slurp',
	  'BLEXBot',
	  'VoilaBot',
	  );

    $bbg = false;
    if (isset($_SERVER["HTTP_USER_AGENT"]) and
	preg_match('/('.implode('|', $bots).')/i', $_SERVER['HTTP_USER_AGENT'])){
	$bbg = true;
	die("UA banned: ".$_SERVER['HTTP_USER_AGENT']);
    }
    if (isset($_SERVER["REMOTE_ADDR"])) {
	$hname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
	if (preg_match('/('.implode('|', $bots).')/i', $hname)) {
	    $bbg = true;
	    die("Remote banned: ".$hname." - ".$_SERVER["REMOTE_ADDR"]);
	}
    }
    return $bbg;
}

add_event_handler('loc_end_section_init',  'botsBeGone');
?>
