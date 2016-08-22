<?php

include_once("includes.php");

//check if this user is already logged in.
if (logged_in()) {
    header("Location: main.php");
	exit;
}

//check for login.
if ($_POST['username'] != '') {
    $login_status = login($dbConn, $_POST['username'], $_POST['password']);
    if ($login_status == -1) {
        //success. redirect to where the user needs to go.
		if ($_REQUEST['r'] != '') {
			header("Location: ".$_REQUEST['r']);
			exit;
		} else {
			header("Location: main.php");
			exit;
		}
    }
    elseif ($login_status == -2) {
        //bad username.
        $status .= "Bad username.";
    }
    else {
        $status .= "Invalid password. Maybe you forgot it? You can reset it <a href = 'verifyacct.php?u=".$login_status."'>here</a>.";
    }
}

if ($_REQUEST['page'] == 'register' && REGISTRATION_OPEN) {
	//get number of accounts remaining.
	$number_accts = std_query($dbConn, "SELECT COUNT(*) FROM `users` WHERE `userid` > 0");
	$number_accts = mysqli_fetch_assoc($number_accts);
	$number_accts = $number_accts['COUNT(*)'];
	$remaining_accts = MAX_USERS - $number_accts;
	if ($remaining_accts <= 0) {
		$remaining_accts = 0;
		display_verification_error("We're sorry, but we have reached the maximum number of accounts on this site. Please try again later when more slots have opened up.");
		exit;
	}

	switch ($_REQUEST['step']) {

		case "check" :
			//check if user is already verified.
			if (check_user_verified($dbConn, intval($_POST['userid']))) {
				display_verification_error("This user is already verified.");
				exit;
			}
			//check if user is already in database.
			if (!check_user_in_db($dbConn, intval($_POST['userid']))) {
				//add this userid.
				if (!add_unconfirmed_user($dbConn, intval($_POST['userid']), $_POST['password'])) {
					display_verification_error("We encountered an error while adding your user entry. Please try again.");
					exit;
				}
			}
			
			$_SESSION['userid'] = intval($_POST['userid']);

			if ($_SESSION['user_code'] === false) {
				display_verification_error("Could not log into LL. Please refresh the page. If this does not work, please try re-registering.");
				exit;
			}
			
			//set this user's verification code.
			if (!set_user_verification_code($dbConn, $_SESSION['userid'], $_SESSION['user_code'])) {
				display_verification_error("We encountered an error while processing your registration. Please try again.");
				exit;
			}
			
			//check if user has added information to profile.
			if (check_userinfo_has_code($dbConn, $_SESSION['userid'])) {
				//check if this user is already verified.
				if (check_user_verified($dbConn, $_SESSION['userid'])) {
					display_verification_error("This user is already verified.");
					exit;
				}
				else {
					//success! change this user to be verified.
					set_user_verified($dbConn, $_SESSION['userid']);
					user_unset_verification_code($dbConn, $_SESSION['userid']);					
					//log user in and send them to password-setting form.
					echo "Success! You may now log in at the <a href = 'index.php'>main page.</a>";
				}
			}
			else {
				user_unset_verification_code($dbConn, $_SESSION['userid']);
				display_verification_error("You have not added the verification code to your profile. Please try again!");
			}
			break;
			
		default :
			//ask for userid and password, set user code.
			//give this user a new verification code.
			
			if ($_SESSION['user_code'] == '') {
				$_SESSION['user_code'] = generate_user_verification_code();
			}
			echo "<h1>Registration</h1>
			<h2>There are <strong>".$remaining_accts."</strong> accounts remaining!</h2>
			Please enter your account information.<br />
			<form action = 'index.php?page=register&step=check' method = 'post'>
			UserID:&nbsp;&nbsp;<input name = 'userid' size = '6' /><br />
			Desired Password:&nbsp;&nbsp;<input name = 'password' type = 'password' /><font color='red'><---- DO NOT MAKE THIS YOUR LL PASSWORD GODDAMN</font><br />
			<strong>Please enter this code somewhere in your LL profile:</strong> ".$_SESSION['user_code']."<br /><br />
			<input type = 'submit' value = 'Next step' />
			</form>";
			break;
	}
}
else {
		//display login page.
		display_header();
		start_html();
		display_footer();
}
?>
