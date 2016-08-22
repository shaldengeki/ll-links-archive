<?php

//includes all necessary files.

//define some constants.
define("PW_SALT", "LONG_PW_SALT");
define("MAX_USERS", 500);
define("START_TIME", microtime(true));
define("REGISTRATION_OPEN", false);

define("MAL_USER", "MAL_USER");
define("MAL_PASSWORD", "MAL_PASSWORD");
define("ETI_USER", "ETI_USER");
define("ETI_PASSWORD", "ETI_PASSWORD");
define("GOMTV_USER", "GOMTV_USER");
define("GOMTV_PASSWORD", "GOMTV_PASSWORD");
define("DB_USER", "DB_USER");
define("DB_PASSWORD", "DB_PASSWORD");
define("DB_NAME", "DB_NAME");
define("DB_HOST", "DB_HOST");

//include library files.
include_once($_SERVER['DOCUMENT_ROOT']."/global/sha256.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/global/database.php");
include_once($_SERVER['DOCUMENT_ROOT']."/global/curl_fns.php");
include_once($_SERVER['DOCUMENT_ROOT']."/global/user.php");
include_once($_SERVER['DOCUMENT_ROOT']."/global/display.php");

@session_start();

$dbConn = connectSQL();

//only allow access to non-mods if LL is down.
if (logged_in() && !check_super_user()) {
	if (check_db_ll_up()) {
		echo "<h1>LL is online! Go forth and rejoice, my bretheren!</h1>
	<h2>(this site is only up when LL is down)</h2>";
		exit;
	}
}

?>
