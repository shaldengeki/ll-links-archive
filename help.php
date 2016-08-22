<?php

//help.php
//help page for ll backup.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

display_header("Help", $status);

display_help();

display_footer();
?>