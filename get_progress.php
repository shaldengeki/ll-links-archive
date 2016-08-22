<?php

include_once("includes.php");

if (isset($_REQUEST['type']) && $_REQUEST['type'] != '') {
	$dbConn = connectSQL();

	$timecode = std_query($dbConn, "SELECT `value` FROM `indices`
							WHERE `name` = ".quote_smart($dbConn, $_REQUEST['type'])."
							LIMIT 1");
	if (mysqli_num_rows($timecode) < 1) {
		echo "No such timecode!";
	} else {
		$timecode = mysqli_fetch_assoc($timecode);
		echo $timecode['value'];
	}
}
?>
