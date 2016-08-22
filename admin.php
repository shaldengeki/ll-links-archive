<?php

//admin.php
//displays user profile.

include_once("includes.php");

if (!logged_in() || !check_admin_user()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

if ($_REQUEST['action'] == 'delete' && $_REQUEST['userid'] != '') {
	// user is trying to delete a userid.
	// get the userlevel of the target user and compare it to that of this user.
	$target_user = std_query($dbConn, "SELECT `userlevel` FROM `users`
								WHERE `userid` = ".intval($_REQUEST['userid'])."
								LIMIT 1");
	if (mysqli_num_rows($target_user) < 1) {
		$status .= "No such user found. Please try again.";
	} else {
		$target_user = mysqli_fetch_assoc($target_user);
		if ($target_user['userlevel'] >= $_SESSION['userlevel']) {
			$status .= "You do not have permissions to delete this user.";
		} else {
			//otherwise go through with the delete attempt.
			$status = delete_userid($dbConn, intval($_REQUEST['userid']));
		}
	}
} elseif ($_REQUEST['action'] == 'edit' && $_POST['userid'] != '') {
	// user is trying to edit a user.
	// get the userlevel of the target user and compare it to that of this user.
	$target_user = std_query($dbConn, "SELECT `userlevel` FROM `users`
								WHERE `userid` = ".intval($_POST['userid'])."
								LIMIT 1");
	if (mysqli_num_rows($target_user) > 0) {
		$target_user = mysqli_fetch_assoc($target_user);
		if ($target_user['userlevel'] >= $_SESSION['userlevel']) {
			$status .= "You do not have permissions to modify this user.";
		} else {
			$status = edit_userid($dbConn, $_POST['userid'], $_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['userlevel']);		
		}
	} else {
		$status = edit_userid($_POST['userid'], $_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email'], $_POST['userlevel']);
	}
}

display_header("Admin", $status);

display_admin_panel($dbConn);

display_footer();
?>
