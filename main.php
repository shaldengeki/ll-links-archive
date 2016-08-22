<?php

//main.php
//homepage for authenticated users.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

if (isset($_POST['new_pw']) && isset($_POST['old_pw']) && isset($_POST['new_pw_2'])) {
	//user is transitioning their password.
	$transition_status = transition_password($dbConn, $_POST['old_pw'], $_POST['new_pw'], $_POST['new_pw_2']);
	if ($transition_status == -1) {
		$status = "Successfully transitioned password. You will have to log in again.";
	} elseif ($transition_status == -2) {
		$status = "Please fill all fields.";
	} elseif ($transition_status == -3) {
		$status = "Invalid old password. Please re-type your old password.";
	} elseif ($transition_status == -4) {
		$status = "New passwords do not match. Please re-type your new password.";
	} elseif ($transition_status == -5) {
		$status = "No transition needed.";
	}
}

display_header("Home", $status);

//check to see if user needs to transition their password.
if ($_SESSION['transition_pw'] == 1) {
	display_pw_transition_form();
} else {
	//display page.
	display_welcome();
}
display_footer();
?>
