<?php

//user.php
//user functions for ll backup.

function check_user_in_db($dbConn, $userid) {
	//checks if user is already in database.
	$check_user = std_query($dbConn, "SELECT COUNT(*) FROM `users`
							WHERE `userid` = ".intval($userid)."
							LIMIT 1");
	$check_user = mysqli_fetch_assoc($check_user);
	if ($check_user['COUNT(*)'] == 1) {
		return true;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function add_unconfirmed_user($dbConn, $userid, $password) {
	//get user data from LL and add an unverified user into the DB.
	//returns the verification code.
	//log into LL.
	$cookieString = getLLlogincookie();
	if ($cookieString < 0) {
			echo "Could not log into LL. Please try again.";
			exit;
	}
	
	//get this userid's information.
	$user_profile = hitPageSSL("https://endoftheinter.net/profile.php?user=".intval($userid), $cookieString);
	if (!$user_profile) {
		return false;
	}
	
	$username = get_enclosed_string($user_profile, "<td>User Name</td>
      <td>", " (");
	$signature = get_enclosed_string($user_profile, '<td>Signature</td>
      <td>', '</td>');
	$quote = get_enclosed_string($user_profile, '<td>Quote</td>
      <td>', '</td>');
	$email = get_enclosed_string($user_profile, '<td>Email Address</td>
      <td>', '</td>');
	$im = get_enclosed_string($user_profile, '<td>Instant Messaging</td>
      <td>', '</td>');
	$verification_code = generate_user_verification_code();
	$verified = 0;
	
	$password = SHA256($password.PW_SALT);
	
	$add_user = std_query($dbConn, "INSERT INTO `users`
							SET `userid` = ".intval($userid).", 
							`username` = ".quote_smart($dbConn, $username).", 
							`signature` = ".quote_smart($dbConn, $signature).", 
							`quote` = ".quote_smart($dbConn, $quote).", 
							`email` = ".quote_smart($dbConn, $email).", 
							`im` = ".quote_smart($dbConn, $im).", 
							`verification_code` = '".$verification_code."', 
							`verified` = 0, 
							`password_sha256` = '".$password."'");
	if (!mysqli_error($dbConn)) {
		return $verification_code;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function generate_user_verification_code() {
	//generates a random alphanumeric+caps string to put in the user's profile somewhere.
	$characters[] = "0";
	$characters[] = "1";
	$characters[] = "2";
	$characters[] = "3";
	$characters[] = "4";
	$characters[] = "5";
	$characters[] = "6";
	$characters[] = "7";
	$characters[] = "8";
	$characters[] = "9";
	$characters[] = "A";
	$characters[] = "B";
	$characters[] = "C";
	$characters[] = "D";
	$characters[] = "E";
	$characters[] = "F";
	$characters[] = "G";
	$characters[] = "H";
	$characters[] = "I";
	$characters[] = "J";
	$characters[] = "K";
	$characters[] = "L";
	$characters[] = "M";
	$characters[] = "N";
	$characters[] = "O";
	$characters[] = "P";
	$characters[] = "Q";
	$characters[] = "R";
	$characters[] = "S";
	$characters[] = "T";
	$characters[] = "U";
	$characters[] = "V";
	$characters[] = "W";
	$characters[] = "X";
	$characters[] = "Y";
	$characters[] = "Z";
	$characters[] = "a";
	$characters[] = "b";
	$characters[] = "c";
	$characters[] = "d";
	$characters[] = "e";
	$characters[] = "f";
	$characters[] = "g";
	$characters[] = "h";
	$characters[] = "i";
	$characters[] = "j";
	$characters[] = "k";
	$characters[] = "l";
	$characters[] = "n";
	$characters[] = "o";
	$characters[] = "p";
	$characters[] = "q";
	$characters[] = "r";
	$characters[] = "s";
	$characters[] = "t";
	$characters[] = "u";
	$characters[] = "v";
	$characters[] = "w";
	$characters[] = "x";
	$characters[] = "y";
	$characters[] = "z";
	for ($str_length = 0; $str_length < 20; $str_length++) {
		$string .= $characters[rand(0, count($characters))];
	}

	return $string;
	exit;
}

function check_userinfo_has_code($dbConn, $userid) {
	//checks a user's LL page to see if they have entered their code somewhere.
	//log into LL.
	$cookieString = getLLlogincookie();
	if (!$cookieString) {
			echo "Could not log into LL. Please try again.";
			exit;
	}
	
	//get this user's verification code.
	$verification_code = std_query($dbConn, "SELECT `verification_code` FROM `users`
									WHERE `userid` = ".intval($userid)."
									LIMIT 1");
	if (mysqli_num_rows($verification_code) < 1) {
		return false;
		exit;
	}
	else {
		$verification_code = mysqli_fetch_assoc($verification_code);
		//get this userid's information.
		$user_profile = hitPageSSL("http://endoftheinter.net/profile.php?user=".intval($userid), $cookieString);
		
		if (strpos($user_profile, $verification_code['verification_code']) === FALSE) {
			return false;
			exit;
		}
		else {
			return true;
			exit;
		}
	}	
}

function set_user_verification_code($dbConn, $userid, $code) {
	$set_code = std_query($dbConn, "UPDATE `users`
							SET `verification_code` =  '".$code."'
							WHERE `userid` = ".intval($userid)."
							LIMIT 1");
	if (!mysqli_error()) {
		return true;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function check_user_verified($dbConn, $userid) {
	//checks to see if a user is verified.
	$verified = std_query($dbConn, "SELECT `userid` FROM `users`
							WHERE `userid` = ".intval($userid)."
							AND `verified` = 1");
							
	if (mysqli_num_rows($verified) > 0) {
		return true;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function set_user_verified($dbConn, $userid) {
	//sets a user as verified.
	$set_verified = std_query($dbConn, "UPDATE `users`
								SET `verified` = 1
								WHERE `userid` = ".intval($userid)."
								LIMIT 1");
	if (!mysqli_error($dbConn)) {
		return true;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function user_regenerate_verification_code($dbConn, $userid) {
	//gives user a new verification code.
	$verification_code = generate_user_verification_code();
	
	$update_user = std_query($dbConn, "UPDATE `users`
							SET `verification_code` = '".$verification_code."'
							WHERE `userid` = ".intval($userid)."
							LIMIT 1");
	if (!mysqli_error($dbConn)) {
		return $verification_code;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function user_unset_verification_code($dbConn, $userid) {
	//unsets a user's verification code.
	$unset = std_query($dbConn, "UPDATE `users`
						SET `verification_code` = ''
						WHERE `userid` = ".intval($userid)."
						LIMIT 1");
	if (!mysqli_error($dbConn)) {
		return true;
		exit;
	}
	else {
		return false;
		exit;
	}
}

function logged_in() {
	if ($_SESSION['logged_in'] != 23844372847) {
		return false;
		exit;
	}
	else {
		return true;
		exit;
	}
}

function login($dbConn, $username, $password) {
    //tries to log a user in.
    if ($username == '' || $password == '') {
        //blank field. return error.
        return false;
		exit;
    }

    //try to get get the username this person is trying to login as.
    $try_user = std_query($dbConn, "SELECT * FROM `users`
                            WHERE `username` = ".quote_smart($dbConn, $username)."
                            LIMIT 1");

    //check number of results.
    if (mysqli_num_rows($try_user) != 1) {
        return -2;
		exit;
    }
    else {
        $try_user = mysqli_fetch_assoc($try_user);
    }
	
    //check password.
	//transition to sha256.
	if ($try_user['password_sha256'] != '') {
		//user has already transitioned their password.
		if (sha256($password.PW_SALT) != $try_user['password_sha256']) {
			//wrong password. log and return error.
			$update_usermap = update_usermap($dbConn, $try_user['userid'], $_SERVER['REMOTE_ADDR'], time(), 1);
			return -3;
			exit;
		}
		//this person checks out. log him in.
		$update_usermap = update_usermap($dbConn, $try_user['userid'], $_SERVER['REMOTE_ADDR'], time(), 0);
		$_SESSION = $try_user;
		$_SESSION['logged_in'] = 23844372847;
		return -1;
		exit;
	} else {
		//user has not transitioned their password.
		if (SHA1($password.PW_SALT) != $try_user['password']) {
			//wrong password. log and return error.
			$update_usermap = update_usermap($dbConn, $try_user['userid'], $_SERVER['REMOTE_ADDR'], time(), 1);
			return -3;
			exit;
		} else {
			//correct password, non-transitioned. prompt user to transition.
			$update_usermap = update_usermap($dbConn, $try_user['userid'], $_SERVER['REMOTE_ADDR'], time(), 0);
			$_SESSION = $try_user;
			$_SESSION['logged_in'] = 23844372847;
			$_SESSION['transition_pw'] = 1;
			return -1;
			exit;
		}
	}
}

function update_usermap($dbConn, $userid, $ip, $time, $type) {
	//inserts a usermap entry for a userid and IP at a time.
	//check to see if user has logged on at this IP within the past three minutes.
	$check_usermap = std_query($dbConn, "SELECT `usermapid` FROM `usermap`
								WHERE `userid` = ".intval($userid)."
								AND `ip` = ".quote_smart($dbConn, $ip)."
								AND `time` >= ".(intval($time) - 180)."
								AND `type` = ".intval($type)."
								LIMIT 1");
	if (mysqli_num_rows($check_usermap) > 1) {
		return -2;
		exit;
	} else {
		//otherwise, insert a usermap entry.
		$insert_usermap = std_query($dbConn, "INSERT INTO `usermap`
									SET `userid` = ".intval($userid).", 
									`ip` = ".quote_smart($dbConn, $ip).", 
									`type` = ".intval($type).", 
									`time` = ".intval($time));
		if (mysqli_error()) {
			return -3;
			exit;
		} else {
			return -1;
			exit;
		}
	}
}

function get_user_last_login($dbConn, $userid) {
	//returns the unix timestamp of a user's last login.
	//if null, returns 0.
	
	$get_usermap = std_query($dbConn, "SELECT `time` FROM `usermap`
								WHERE `userid` = ".intval($userid)."
                AND `type` = 0
								ORDER BY `time` DESC
								LIMIT 1");
	if (mysqli_num_rows($get_usermap) != 1) {
		return 0;
	} else {
		$get_usermap = mysqli_fetch_assoc($get_usermap);
		return $get_usermap['time'];
	}
}

function transition_password($dbConn, $old_pw, $new_pw, $new_pw_2) {
	//transitions a user's password to SHA256.
	//check to see if everything is non-null.
	if ($old_pw == '' || $new_pw == '' || $new_pw_2 == '') {
		//blank field. return error.
		return -2;
		exit;
	} elseif (SHA1($old_pw.PW_SALT) != $_SESSION['password']) {
		//old password incorrect. return error.
		return -3;
		exit;
	} elseif ($new_pw != $new_pw_2) {
		//new passwords do not match.
		return -4;
		exit;
	}
	//check to see if user's pw needs to be transitioned.
	$check_transition = std_query($dbConn, "SELECT `password_sha256` FROM `users`
									WHERE `userid` = ".intval($_SESSION['userid'])."
									LIMIT 1");
	$check_transition = mysqli_fetch_assoc($check_transition);
	if ($check_transition['password_sha256'] != '') {
		return -5;
		exit;
	}
	
	//otherwise, transition password.
	$transition_pw = std_query($dbConn, "UPDATE `users`
								SET `password_sha256` = '".sha256($new_pw.PW_SALT)."', 
								`password` = ''
								WHERE `userid` = ".intval($_SESSION['userid'])."
								LIMIT 1");
	unset($_SESSION);
	session_destroy();
	
	return -1;
	exit;
}

function userlevel_to_text($userlevel) {
	//converts an int userlevel to its text description.
	switch ($userlevel) {
		case 1 :
			return "User";
			break;
		case 2 :
			return "Superuser";
			break;
		case 3 :
			return "Admin";
			break;
		default :
			return "Unknown";
			break;
	}
}

function userstatus_to_text($status) {
	//converts an int user status to its text description.
	switch($status) {
		case 1:
			return "Banned";
			break;
		case 2:
			return "Suspended";
			break;
		case 0:
			return "Normal";
			break;
		default:
			return "Unknown";
			break;
	}
}

function usermap_type_to_text($type) {
	//converts an int usermap login attempt type to its text description.
	switch($type) {
		case 0:
			return "Success";
			break;
		case 1:
			return "Failure";
			break;
		default:
			return "Unknown";
			break;
	}
}

function check_super_user() {
	//checks to see if this user is a super-user.
	if ($_SESSION['userlevel'] < 2) {
		return false;
		exit;
	}
	else {
		return true;
		exit;
	}
}

function check_admin_user() {
	//checks to see if this user is an administrator.
	if ($_SESSION['userlevel'] < 3) {
		return false;
		exit;
	}
	else {
		return true;
		exit;
	}
}
?>
