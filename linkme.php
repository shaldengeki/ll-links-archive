<?php

//linkme.php
//individual link fetcher for LL linksys.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

if ($_REQUEST['l'] == 'random') {
    //random link. get highest linkid.
	do {
		$linkid_max = std_query($dbConn, "SELECT `linkid` FROM `links`
								ORDER BY `linkid` DESC
								LIMIT 1;");
		$linkid_max = mysqli_fetch_assoc($linkid_max);

		$_REQUEST['l'] = rand(1, $linkid_max['linkid']);
		$this_link = std_query($dbConn, "SELECT * FROM `links`
								WHERE `linkid` = ".intval($_REQUEST['l'])."
								LIMIT 1");
	} while (mysqli_num_rows($this_link) < 1);
}

$l = intval($_REQUEST['l']);

//get information for this link.
$link_info = std_query($dbConn, "SELECT * FROM `links`
                        WHERE `linkid` = ".quote_smart($dbConn, $l)."
                        LIMIT 1");
if (mysqli_num_rows($link_info) < 1) {
    //no such link.
    display_header("Error");
    echo "<h1>Oh noes!</h1>
<h2><em>Invalid link!</em></h2>
";
    display_footer();
    exit;
}
$link_info = mysqli_fetch_assoc($link_info);

display_header($link_info['title']);
display_link($dbConn, $link_info);
display_footer();
?>
