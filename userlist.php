<?php

//userlist.php
//lists users in LL.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$page = intval($_REQUEST['page']);
if ($page == 0) {
	$page = 1;
}

display_header("User List");

echo "<h1>User List</h1>";

switch ($_GET['sort']) {
	case 1:
		$sort = "`username`";
		break;
	case 2:
		$sort = "`created`";
		break;
	case 3:
		$sort = "`lastactive`";
		break;
	case 4:
		$sort = "(`good_tokens` + `contrib_tokens` - `bad_tokens`)";
		break;
	default:
		$sort = "`userid`";
		break;
}
if ($_GET['sortd'] == 1) {
	$sortd = "DESC";
}
else {
	$sortd = "ASC";
}

display_users($dbConn, "1=1", $sort." ".$sortd, 99999999999, $page);

display_footer();
?>
