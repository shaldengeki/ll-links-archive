<?php

//usermap.php
//displays usermap for a given userid or IP.

include_once("includes.php");

if (!logged_in() || !check_admin_user()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

display_header("Usermap", $status);

display_usermap($dbConn, $_REQUEST['userid'], $_REQUEST['ip']);

display_footer();
?>
