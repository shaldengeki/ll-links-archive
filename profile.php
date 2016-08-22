<?php

//profile.php
//displays user profile.

include_once("includes.php");

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$userid = intval($_REQUEST['user']);
display_header("User Profile", $status);
display_user_profile($dbConn, $userid);
display_footer();
?>
