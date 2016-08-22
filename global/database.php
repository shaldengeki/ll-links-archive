<?php

//database.php
//database functions for ll backup

function connectSQL() {
    $dbConn = mysqli_connect(DB_HOST,DB_USER, DB_PASSWORD)
        or die("Unable to connect to MySQL.");
    mysqli_select_db($dbConn, DB_NAME)
     or die("<body bgcolor = 'DDE3EB'>Error while connecting to database.<br>
                                      Time:&nbsp;".time()."<br>
                                      Db:&nbsp;".DB_NAME."</body>");
    return $dbConn;
}

function quote_smart($dbConn, $value) {
   if( is_array($value) ) {
       return array_map("quote_smart", $value);
   } else {
       if( get_magic_quotes_gpc() ) {
           $value = stripslashes($value);
       }
       if( $value == '' ) {
           $value = 'NULL';
       } if( !is_numeric($value) || $value[0] == '0' ) {
           $value = "'".mysqli_real_escape_string($dbConn, $value)."'";
       }
       return $value;
   }
}

function std_query($dbConn, $query) {
   //executes a query with standardized error message
   $result = mysqli_query($dbConn, $query)
      or die("Could not query MySQL database in ".$_SERVER['PHP_SELF'].".<br />
             ".mysqli_error($dbConn)."<br />
             Query: ".$query."<br />
            Time: ".time());
   return $result;
}

function fetchOneDbRow($dbConn, $query) {
	//executes a query assuming exactly one resultant row
	//returns false if the number of rows isn't exactly one
	//returns the associative array of the resultant row otherwise.
	$dbRowResource = std_query($dbConn, $query);
	if (mysqli_num_rows($dbRowResource) != 1) {
		return false;
	} else {
		return mysqli_fetch_assoc($dbRowResource);
	}
}

function delete_userid($dbConn, $userid) {
	//deletes a userID.
	// check that said userid exists and is lower userlevel than this user.
	// returns text status.
	$check_userid = std_query($dbConn, "SELECT * FROM `users`
								WHERE `userid` = ".intval($userid)."
								AND `userlevel` < ".intval($_SESSION['userlevel'])."
								LIMIT 1");
	if (mysqli_num_rows($check_userid) < 1) {
		$status = "Could not find userID ".$userid." to delete. Please try again. ";
	} else {
		//delete this user.
		$check_userid = mysqli_fetch_assoc($check_userid);
		$delete_userid = std_query($dbConn, "DELETE FROM `users`
									WHERE `userid` = ".intval($check_userid['userid'])."
									LIMIT 1");
		if (mysqli_error($dbConn)) {
			$status = "Could not delete userID ".intval($check_userid['userid']).". ";
		} else {
			$status = "Successfully deleted ".htmlentities($check_userid['username']).". ";
		}
	}
	return $status;
}

function edit_userid($dbConn, $userid, $username, $password1, $password2, $email, $userlevel) {
	// modifies a userID's user information.
	if ($userlevel >= $_SESSION['userlevel']) {
		return "You do not have permissions to set that userlevel. ";
	} elseif ($password1 != $password2) {
		return "The passwords you provided do not match. ";
	} elseif ($userid == '' || $username == '' || $email == '' || $userlevel == '') {
		return "You must specify all fields. ";
	}
	
	$check_userid = std_query($dbConn, "SELECT `userid`, `username` FROM `users`
								WHERE `userid` = ".intval($userid)."
								AND `userlevel` < ".intval($_SESSION['userlevel'])."
								LIMIT 1");
	if (mysqli_num_rows($check_userid) < 1) {
		//adding a user into the DB.
		if ($password1 == '' || $password2 == '') {
			return "You must specify all fields. ";
		}
		$insert_userid = std_query($dbConn, "INSERT INTO `users`
									SET `userid` = ".intval($userid).",
									`username` = ".quote_smart($dbConn, $username).", 
									`password_sha256` = ".quote_smart($dbConn, sha256($password1.PW_SALT)).", 
									`email` = ".quote_smart($dbConn, $email).", 
									`userlevel` = ".intval($userlevel).", 
									`verified` = 1");
		if (mysqli_error()) {
			$status = "Could not insert user. Please try again. ";
		} else {
			$status = "Successfully inserted ".htmlentities($check_userid['username']).". ";
		}
	} else {
		//modify this user.
		$check_userid = mysqli_fetch_assoc($check_userid);
		
		$password_update = "";
		if ($password1 != '') {
			$password_update = "`password_sha256` = ".quote_smart($dbConn, sha256($password1.PW_SALT)).", 
";
		}
		
		$modify_userid = std_query($dbConn, "UPDATE `users`
									SET ".$password_update."
									`email` = ".quote_smart($dbConn, $email).", 
									`userlevel` = ".intval($userlevel)."
									WHERE `userid` = ".intval($userid));
		if (mysqli_error()) {
			$status = "Could not modify userID ".intval($check_userid['userid']).". ";
		} else {
			$status = "Successfully modified ".htmlentities($check_userid['username']).". ";
		}
	}
	return $status;
}

function check_db_ll_up($dbConn) {
	//checks the db record to see if LL is up.
	$ll_up_index = fetchOneDbRow($dbConn, "SELECT `value` FROM `indices`
								WHERE `name` = 'll_up'
								LIMIT 1");
	if (!$ll_up_index) {
		return false;
	} else {
		return $ll_up_index['value'] == 1;
	}
}

function check_ll_up() {
	//checks to see if LL is online.
	$ll_frontpage = hitPageSSL("https://endoftheinter.net");
	if (strpos($ll_frontpage, "<form action=") === FALSE) {
		return false;
	} else {
		return true;
	}
}

function log_into_ll() {
	//logs server into LL for future inquiries.
		
	//log into LL.
	$cookieString = getLLlogincookie();
	
	if ($cookieString < 0) {
		//could not log in properly
		return false;
	} else {
		return $cookieString;
	}
}
?>
