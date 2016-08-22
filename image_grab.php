<?php

include_once("./global/include_globals.php");

$url = $_REQUEST['url'];
if ($url != '') {
	$image_header = hitPageSSL_header($url, "", '');
	$content_type = get_enclosed_string($image_header, 'Content-Type: ', 'Accept-Ranges:');
	if (strpos($content_type, 'image') === FALSE) {
		exit;
	}
	$image = hitPageSSL($url, $'');
	header("Content-type: ".$content_type);
	echo $image;
	exit;
}
?>
