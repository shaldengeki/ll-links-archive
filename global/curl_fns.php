<?php
//curl_fns.php
//commonly-used cURL functions.

function display_curl_error($curl_connection) {
	$info = curl_getinfo($curl_connection);
	echo "<strong>There was a cURL error!</strong>
	<pre>&nbsp;&nbsp;&nbsp;URL: ".$info['url']."<br />
	&nbsp;&nbsp;&nbsp;HTTP Code: ".$info['http_code']."<br />
	&nbsp;&nbsp;&nbsp;Redirects: ".$info['redirect_count']."<br />
	&nbsp;&nbsp;&nbsp;cURL error:<br />
	";
	echo curl_error($curl_connection)."</pre><br />
	";
}

function hitPage($page,$cookieString="",$referer="http://endoftheinter.net") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_URL, $page);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        $ret = curl_exec($ch);
		
		if (curl_error($ch)) {
//			display_curl_error($ch);
			curl_close($ch);
			return "SEINMA_ERROR";
		} else {
			curl_close($ch);
			return $ret;		
		}
}

function hitPageSSL($page, $cookieString="", $referer="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		if ($cookieString == "") {
			curl_setopt($ch, CURLOPT_COOKIEFILE, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEJAR, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
		} else {
			curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_URL, $page);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        $ret = curl_exec($ch);
		
		if (curl_error($ch)) {
			display_curl_error($ch);
			curl_close($ch);
			return "SEINMA_ERROR";
		} else {
			curl_close($ch);
			return $ret;		
		}
}

function hitPage_binary($page, $cookieString="",$referer="") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_URL, $page);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);		
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        $ret = curl_exec($ch);
		
		if (curl_error($ch)) {
			display_curl_error($ch);
			curl_close($ch);
			return "SEINMA_ERROR";
		} else {
			curl_close($ch);
			return $ret;		
		}
}

function hitPage_error($page,$cookieString="",$referer="") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_URL, $page);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        $ret = curl_exec($ch);
		
		if (curl_error($ch)) {
			$ret = curl_getinfo($ch);
			curl_close($ch);
			return $ret;
		} else {
			return false;		
		}
}

function hitPage_header($url,$referer="", $cookieString="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
		curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
        $ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function hitPageSSL_header($url,$referer="", $cookieString="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
		curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
        $ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function hitPageSSL_binary($page, $cookieString="", $referer="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		if ($cookieString == "") {
			curl_setopt($ch, CURLOPT_COOKIEFILE, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEJAR, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
		} else {
			curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_URL, $page);
		curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        $ret = curl_exec($ch);
		
		if (curl_error($ch)) {
			display_curl_error($ch);
			curl_close($ch);
			return "SEINMA_ERROR";
		} else {
			curl_close($ch);
			return $ret;		
		}
}

function hitForm($url,$formFields,$referer="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIEFILE, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
		curl_setopt($ch, CURLOPT_COOKIEJAR, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formFields);
        $ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function hitFormSSL($url,$formFields,$referer="",$cookieString="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		if ($cookieString == "") {
			curl_setopt($ch, CURLOPT_COOKIEFILE, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
			curl_setopt($ch, CURLOPT_COOKIEJAR, "K:\\llanimu.ath.cx\\cURL\\cookies.txt");
		} else {
			curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $formFields);
        curl_setopt($ch, CURLOPT_URL, $url);
		$ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function postHeader($url,$postFields="",$referer="http://endoftheinter.net/") {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		
        $ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function postHeaderSSL($url,$postFields="",$referer="") {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13;");
		curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		
        $ret = curl_exec($ch);
		if (curl_error($ch)) {
			display_curl_error($ch);
		}
        curl_close($ch);
		
        return $ret;
}

function get_enclosed_string($haystack, $needle1, $needle2, $offset=0) {
	if ($needle1 == "") {
		$needle1_pos = 0;
	} else {
		$needle1_pos = strpos($haystack, $needle1, $offset) + strlen($needle1);
		if ($needle1_pos === FALSE) {
			return false;
		}
	}
	if ($needle2 == "") {
		$needle2_pos = strlen($haystack);
	} else {
		$needle2_pos = strpos($haystack, $needle2, $needle1_pos);
		if ($needle2_pos === FALSE) {
			return false;
		}
	}
	if ($needle1_pos > $needle2_pos || $needle1_pos < 0 || $needle2_pos < 0 || $needle1_pos > strlen($haystack) || $needle2_pos > strlen($haystack)) {
		return false;
	}
	
    $enclosed_string = substr($haystack, $needle1_pos, $needle2_pos - $needle1_pos);
    return $enclosed_string;
}

function get_last_enclosed_string($haystack, $needle1, $needle2) {
	//this is the smallest possible enclosed string.
	//position of first needle is as close to the end of the haystack as possible.
	if ($needle1 == "") {
		$needle1_pos = 0;
	} else {
		$needle1_pos = strrpos($haystack, $needle1) + strlen($needle1);
		if ($needle1_pos === FALSE) {
			return false;
		}
	}
	if ($needle2 == "") {
		$needle2_pos = strlen($haystack);
	} else {
		$needle2_pos = strpos($haystack, $needle2, $needle1_pos);
		if ($needle2_pos === FALSE) {
			return false;
		}
	}
    $enclosed_string = substr($haystack, $needle1_pos, $needle2_pos - $needle1_pos);
    return $enclosed_string;
}

function get_biggest_enclosed_string($haystack, $needle1, $needle2) {
	//this is the largest possible enclosed string.
	//position of last needle is as close to the end of the haystack as possible.
	
	if ($needle1 == "") {
		$needle1_pos = 0;
	} else {
		$needle1_pos = strpos($haystack, $needle1) + strlen($needle1);
		if ($needle1_pos === FALSE) {
			return false;
		}
	}
	if ($needle2 == "") {
		$needle2_pos = strlen($haystack);
	} else {
		$needle2_pos = strrpos($haystack, $needle2, $needle1_pos);
		if ($needle2_pos === FALSE) {
			return false;
		}
	}
    $enclosed_string = substr($haystack, $needle1_pos, $needle2_pos - $needle1_pos);
    return $enclosed_string;
}

function parseCookieHeader($string) {
	//takes a header return string and returns a formatted cookie string.
	$string_array = explode("\r\n", $string);
	$cookieString = "";
	foreach ($string_array as $line) {
		if(!strncmp($line, "Set-Cookie:", 11)) {
			$cookiestr = trim(substr($line, 11, -1));
			$cookie = explode(';', $cookiestr);
			$cookie = explode('=', $cookie[0]);
			$cookiename = trim(array_shift($cookie)); 
			$cookiearr[$cookiename] = trim(implode('=', $cookie));
		}
	}
	if (is_array($cookiearr)) {
		foreach ($cookiearr as $key=>$value) {
			$cookieString .= "$key=$value; ";
		}
	}
	return $cookieString;
}

function getMALlogincookie($username=MAL_USER, $password=MAL_PASSWORD) {
	//logs into MAL and returns the cookie header string.
    //login to MAL.
	$cookieHeader = postHeader('http://myanimelist.net/login.php', 'username='.$username.'&password='.$password.'&sublogin=Login');
	
	if (strpos($cookieHeader, 'Set-Cookie: ') === FALSE) {
		//wrong login data or something.
		return -2;
	}
	//set cookie userid and phpsessid values.
	$cookieString = 'A='.get_enclosed_string($cookieHeader, ' A=', ';').'; B='.get_enclosed_string($cookieHeader, ' B=', '; ');

	//hit the LL club page.
	$ll_club_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members", $cookieString);
	
	if (!(strpos($ll_club_members, 'Username:') === FALSE)) {
		//not logged in correctly.
		return -3;
	}

	return $cookieString;
}

function getLLlogincookie($username=ETI_USER, $password=ETI_PASSWORD) {
	//logs into LL and returns the cookie header string.
	if ($username == "ETI_USER") {
		//check to see if llAnimuBot is running.
		exec("ps aux | grep llAnimuBot", $checkBot);
		$botRunning = false;
		foreach ($checkBot as $line) {
			if (preg_match("/^(root).*(python\ llAnimuBot\.py)/", $line) > 0 || preg_match("/^(1000).*(SCREEN\ \-S\ llAnimuBot)/", $line) > 0) {
				$botRunning = true;
			}
		}	
		if ($botRunning) {
			//read string directly from the cookie file.
			$cookieString = file_get_contents("/home/shaldengeki/llAnimuBot/cookieString.txt");
			if ($cookieString) {
				return $cookieString;
			}
		}
	}
	//login to luelinks.
	$loginFields = "b=".urlencode($username)."&p=".urlencode($password)."&r=";
	$cookieHeader = postHeaderSSL('https://endoftheinter.net/index.php', $loginFields);

	if (!(strpos($cookieHeader, 'Sie bitte 15 Minuten') === FALSE)) {
		//too many failed login attempts. wait 15 minutes.
		return -1;
	} elseif (strpos($cookieHeader, 'session=') === FALSE) {
		//not logged in correctly.
		return -2;
	}
	
	//set cookie userid and phpsessid values.
	$cookieString = 'PHPSESSID='.get_enclosed_string($cookieHeader, ' PHPSESSID=', ';').'; userid='.get_enclosed_string($cookieHeader, ' userid=', '; ').'; session='.get_enclosed_string($cookieHeader, ' session=', '; ').';';

	//check if logged in correctly.
	$mainpage = hitPageSSL("https://endoftheinter.net/main.php", $cookieString);
	
	if (!(strpos($mainpage, '<body onload="document.') === FALSE)) {
		//not logged in correctly.
		return -3;
	}
	return $cookieString;
}
function getgomTVlogincookie($username=GOMTV_USER, $password=GOMTV_PASSWORD) {
	//logs into gomTV and returns the cookie header string.
	
    //login to gomTV.	
	$loginFields = "mb_username=".urlencode($username)."&mb_password=".urlencode($password)."&cmd=login&rememberme=0";
//	$loginFields = "mb_username=GOMTV_USER&mb_password=GOMTV_PASSWORD&cmd=login&rememberme=0";
	$cookieHeader = postHeader('http://www.gomtv.net/user/loginProcess.gom', $loginFields, "http://www.gomtv.net/");

	if (!(strpos($cookieHeader, 'Sie bitte 15 Minuten') === FALSE)) {
		//too many failed login attempts. wait 15 minutes.
		return -1;
	} elseif (strpos($cookieHeader, 'membernick=') === FALSE) {
		//not logged in correctly.
		return -2;
	}
	
	//set cookie values.
	$cookieString = parseCookieHeader($cookieHeader)." path=/; domain=gomtv.net";
	
	//check if logged in correctly.
	$mainpage = hitPage("http://www.gomtv.net/", $cookieString);
/*
	if (!(strpos($mainpage, 'Log out') === FALSE)) {
		//not logged in correctly.
//		return -3;
	}
*/
	echo "<pre>Cookie Header: ".$cookieHeader."<br />
	Cookie String: ".$cookieString."<br /></pre>
	"/*.$mainpage*/;

	return $cookieString;
}

function getlatestSATID($cookieString) {
	//now, search for the latest SAT.
	$sat_search = hitPageSSL("http://boards.endoftheinter.net/search.php?s_aw=season+anime+and+animu&board=42&submit=Submit", $cookieString);

	if ($sat_search == "SEINMA_ERROR") {
		$curl_repeat_errors++;
		if ($curl_repeat_errors >= 5) {
			//if enough repeated errors are encountered, attempt to login again.
			$curl_repeat_errors = 0;
			$cookieString = getLLlogincookie();
			$sat_search = hitPageSSL("http://boards.endoftheinter.net/search.php?s_aw=season+anime+and+animu&board=42&submit=Submit", $cookieString);
			$login_attempts++;
			if ($login_attempts == 5) {
				//if enough login attempts are made, throw error message and exit.
				echo "5 login attempts reached.";
				exit;
			}
		}
	} elseif ($curl_repeat_errors > 0) {
			$curl_repeat_errors = 0;
	}

	//get latest SAT topicid.
	$sat_id = get_enclosed_string($sat_search, 'Last Post</th></tr><tr><td><a href="//boards.endoftheinter.net/showmessages.php?board=42&amp;topic=', '">');

	return intval($sat_id);
}

function addLLtopicpageposts($current_page, $topic_url, $ch, $page_num) {
	global $topic_parallel_curl, $curl_repeat_errors, $login_attempts, $cookieString, $ll_username, $ll_password, $postData, $messageid_list;

	$page_num = get_enclosed_string($topic_url, '&page=', '');
	$topicid = get_enclosed_string($topic_url, '&topic=', '&page=');
	
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);    
    if ($httpcode !== 200) {
        $curl_repeat_errors++;
		if ($curl_repeat_errors >= 5) {
			//if enough repeated errors are encountered, attempt to login again.
			$curl_repeat_errors = 0;
			$cookieString = getLLlogincookie($ll_username, $ll_password);
			$login_attempts++;
/*			if ($login_attempts == 5) {
				//if enough login attempts are made, throw error message and exit.
				echo "5 login attempts reached while updating links. Last (unupdated) linkid was at ".$link_id.". <a href = 'update_ll_stats.php?mode=resume&last_id=".$link_id."'>Click here</a> to resume.";
				$link_parallel_curl->
				exit;
			}*/
		}
		$topic_parallel_curl->startRequest($topic_url, 'addLLtopicpageposts', $page_num);
    } elseif ($curl_repeat_errors > 0) {
		$curl_repeat_errors = 0;
	}

	//get the number of messages on this page.
	$message_count = substr_count($current_page, '<b>From:</b> <a href="//endoftheinter.net/profile.php?user=');
	$message_position = strpos($current_page, '<b>From:</b> <a href="//endoftheinter.net/profile.php?user=');

	//now go through all the messages.
	for ($post_index = 1; $post_index <= $message_count; $post_index++) {
		$userid = get_enclosed_string($current_page, '<a href="//endoftheinter.net/profile.php?user=', '">', $message_position);
		$username = get_enclosed_string($current_page, '">', '</a>', $message_position);
		$date = strtotime(get_enclosed_string($current_page, '<b>Posted:</b> ', ' | <a href="', $message_position));
		$messageid = get_enclosed_string($current_page, '<a href="/message.php?id=', '&amp;', $message_position);
		$messagetext = get_enclosed_string($current_page, ' class="message">', '</td><td class="userpic">', $message_position);

		//check to make sure that this post isn't already in the table.
		if ($messageid_list[$messageid] != 1) {
			//add to query.
			$postData[] = '(' . intval($messageid) . ', ' . intval($topicid) . ', ' . intval($userid) . ', ' . quote_smart($dbConn, $username) . ', ' . intval($date) . ', ' . quote_smart($dbConn, $messagetext) . ')';
/*			$add_post = std_query($dbConn, "INSERT INTO `posts`
									SET `ll_messageid` = ".intval($messageid).", 
									`ll_topicid` = ".intval($topicid).",
									`userid` = ".intval($userid).", 
									`username` = ".quote_smart($dbConn, $username).", 
									`date` = ".intval($date).", 
									`messagetext` = ".quote_smart($dbConn, $messagetext));*/
			$posts_added++;
		}
		$message_position = strpos($current_page, '<b>From:</b> <a href="//endoftheinter.net/profile.php?user=', $message_position+1);
	}
}

function fixLLposttimestamp($current_page, $page_url, $ch, $messageid) {
	global $message_curl, $curl_repeat_errors, $login_attempts, $cookieString, $ll_username, $ll_password;

	$topicid = get_enclosed_string($page_url, '&topic=', '&r=');
	
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);    
    if ($httpcode !== 200) {
        $curl_repeat_errors++;
		if ($curl_repeat_errors >= 5) {
			//if enough repeated errors are encountered, attempt to login again.
			$curl_repeat_errors = 0;
			$cookieString = getLLlogincookie($ll_username, $ll_password);
			$login_attempts++;
/*			if ($login_attempts == 5) {
				//if enough login attempts are made, throw error message and exit.
				echo "5 login attempts reached while updating links. Last (unupdated) linkid was at ".$link_id.". <a href = 'update_ll_stats.php?mode=resume&last_id=".$link_id."'>Click here</a> to resume.";
				$link_parallel_curl->
				exit;
			}*/
		}
		$message_curl->startRequest($topic_url, 'fixLLposttimestamp', $messageid);
    } elseif ($curl_repeat_errors > 0) {
		$curl_repeat_errors = 0;
	}

	//get the timestamp of this message.
	$timestamp = strtotime(get_enclosed_string($current_page, '<b>Posted:</b> ', '</div>'));

	if ($timestamp) {
		//update message timestamp.
		$update_message = std_query($dbConn, "UPDATE `posts`
								SET `date` = ".intval($timestamp)." 
								WHERE `ll_messageid` = ".intval($messageid)."
								LIMIT 1");
	}
}

function construct_updated_anime_list($mal_link, $type="anime") {
	//makes a new MAL anime list from scratch.
	//log in as me (yay)
	
	$cookieString = getMALlogincookie();
	if ($cookieString == -2) {
		//wrong login data or something.
		throw_error("Could not log into MAL. Maybe I've been banned, or MAL is down?");
		exit;	
	} elseif ($cookieString == -3) {
		//wrong login data or something.
		throw_error("Could not log into MAL. Maybe I've been banned, or MAL is down?");
		exit;
	}
	
	//check to make sure this anime exists.
	$mal_anime_page = hitPage($mal_link, $cookieString);
	if (strpos($mal_anime_page, "myanimelist.net") === FALSE || !(strpos($mal_link, 'mal_anime.php') === FALSE)) {
		//not a MAL page (probably).
		throw_error("This is not a MAL url. Please check your input.");
		exit;
	}
	$anime_name = get_enclosed_string($mal_anime_page, '<title>', ' - MyAnimeList.net</title>');
	if (!$anime_name) {
		//not a MAL anime (probably).
		throw_error("This is not a MAL anime url. Please check your input.");
		exit;
	}
	
	//hit the LL club page.
	$ll_club_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members", $cookieString);
	
	//insert timecode for now.
	$dbConn = connectSQL();
	$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
									SET `timecode` = '".md5($_REQUEST['timecode'])."', 
									`time_added` = ".time().",
									`progress` = 0");	

	//get the total number of pages of members.
	$total_members = get_enclosed_string($ll_club_members, 'Total Members: ', ',');
	$total_pages = intval($total_members/36);
	
	//set the unformatted status array.
	$status_array[1] = "currently watching";
	$status_array[2] = "completed";
	$status_array[3] = "on-hold";
	$status_array[4] = "plan to watch";
	$status_array[5] = "dropped";
	
	$progress_increment = 0;
	
	//now loop over each page.
	for ($page_number = 0; $page_number <= $total_pages; $page_number++) {

		$page_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members&show=".($page_number*36), $cookieString);

		//get just the portion of the page that we need.
		$member_listing[$page_number] = get_enclosed_string($page_members, '<td align="center"  class="borderClass">', '</table>');
		
		$first_friend = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="')+strlen('<div style="margin-bottom: 7px;"><a href="');
		$friend_end = 0;
		
		//get number of friends on this page.
		$friend_total_number = substr_count($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="');
		
		//loop over this section of text, extracting members.
		for ($friend_number = 1; $friend_number <= $friend_total_number; $friend_number++) {
		
			//grab their username.
			$friend_start = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="', $friend_end)+strlen('<div style="margin-bottom: 7px;"><a href="http://myanimelist.net/profile/');
			if ($friend_start <= $first_friend && $friend_number != 1) {
				//we've reached the end of this page (and probably the entire friends listing). end loop.
				break;
			}
			$friend_end = strpos($member_listing[$page_number], '">', $friend_start);
			$friend_username = substr($member_listing[$page_number], $friend_start, $friend_end - $friend_start);
			
			//hit their animelist.
			$pagehits = 0;
			do {
				$friend_animelist = hitPage("http://myanimelist.net/malappinfo.php?u=".$friend_username."&status=all&type=".$type);
				$pagehits++;
			} while ($friend_animelist == "SEINMA_ERROR" && $pagehits < 10);
			if ($friend_animelist == "SEINMA_ERROR") {
				echo "Unable to successfully hit http://myanimelist.net/malappinfo.php?u=".$friend_username."&status=all after 10 attempts.";
			} else {
				$friend_rating = 0;
				$friend_status = 6;
				//find their rating for this anime (if it exists).
				if (strpos($friend_animelist, $anime_name) === FALSE ) {
					//this anime doesn't exist on their list.
				} else {
					$anime_rating_section = get_enclosed_string($friend_animelist, "<series_title><![CDATA[".$anime_name."]]></series_title>", '</'.$type.'>');
					if (!$anime_rating_section) {
						//user has not watched anime.
						$friend_rating = 0;
						$friend_status = 6;
					} else {
						$friend_rating = get_enclosed_string($anime_rating_section, "<my_score>", "</my_score>");
						//get this friend's status of the animu.
						//get a list of positions for category headings so we can compare their positions to that of the rating.
						$friend_status = get_enclosed_string($anime_rating_section, "<my_status>", "</my_status>");
					}
				}
			}
			//store in arrays for sorting afterwards.
			$friend_list["$friend_username"] = $friend_rating;
			$friend_statuses["$friend_username"] = $friend_status;
			
			$progress_increment++;
			if ($progress_increment > 10) {
				//update progress.
				$update_progress = std_query($dbConn, "UPDATE `progress`
												SET `progress` = ".round(($page_number * 36 + $friend_number) / $total_members, 4)."
												WHERE `timecode` = '".md5($_REQUEST['timecode'])."'
												LIMIT 1");
				if (mysqli_affected_rows() < 1) {
					//someone's removed the progress row in the MySQL db. halt execution.
					exit;
				}
				$progress_increment = 0;
			}
		}
	}

	//remove timecode.
	$remove_timecode = std_query($dbConn, "DELETE FROM `progress`
								WHERE `timecode` = '".md5($_REQUEST['timecode'])."'
								LIMIT 1");

	return array($anime_name, $friend_list, $friend_statuses);
}

function process_MAL_club_anime_page($page_members, $link_url, $ch, $parameters) {
	global $mal_parallel_curl,$member_listing,$friend_list,$friend_statuses,$progress_increment;
	$page_number = intval(get_enclosed_string($link_url, '&show=', ''))/36;
	$anime_name = $parameters[0];
	$type = $parameters[1];
	$total_members = $parameters[2];
	$timecode = $parameters[3];
	//get just the portion of the page that we need.
	$member_listing[$page_number] = get_enclosed_string($page_members, '<td align="center"  class="borderClass">', '</table>');
	
	$first_friend = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="')+strlen('<div style="margin-bottom: 7px;"><a href="');
	$friend_end = 0;
	
	//get number of friends on this page.
	$friend_total_number = substr_count($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="');
	
	//loop over this section of text, extracting members.
	for ($friend_number = 1; $friend_number <= $friend_total_number; $friend_number++) {
	
		//grab their username.
		$friend_start = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="', $friend_end)+strlen('<div style="margin-bottom: 7px;"><a href="http://myanimelist.net/profile/');
		if ($friend_start <= $first_friend && $friend_number != 1) {
			//we've reached the end of this page (and probably the entire friends listing). end loop.
			break;
		}
		$friend_end = strpos($member_listing[$page_number], '">', $friend_start);
		$friend_username = substr($member_listing[$page_number], $friend_start, $friend_end - $friend_start);
		
		//hit their animelist and process it.
		$mal_parallel_curl->startRequest("http://myanimelist.net/malappinfo.php?u=".$friend_username."&status=all&type=".$type, 'getMALAnimeScoreFromUserXML', array($friend_username,$type,$anime_name,$page_number,$friend_number,$total_members,$_REQUEST['timecode']));
	}
}

function getMALAnimeScoreFromUserXML($xmlPage, $link_url, $ch, $parameters) {
	//given a malappinfo.php XML result, finds the requested anime's status and score and adds it to the friend statuses and scores arrays.
	global $mal_parallel_curl,$member_listing,$friend_list,$friend_statuses,$progress_increment;
	$friend_username = $parameters[0];
	$type = $parameters[1];
	$anime_name = $parameters[2];
	$page_number = $parameters[3];
	$friend_number = $parameters[4];
	$total_members = $parameters[5];
	$timecode = $parameters[6];
	
	if (strpos($xmlPage, "<myanimelist>") === FALSE) {
		$mal_parallel_curl->startRequest("http://myanimelist.net/malappinfo.php?u=".$friend_username."&status=all&type=".$type, 'getMALAnimeScoreFromUserXML', array($friend_username,$type,$anime_name,$page_number,$friend_number,$total_members,$_REQUEST['timecode']));
	} else {
		$friend_rating = 0;
		$friend_status = 7;
		//find their rating for this anime (if it exists).
		if (strpos($xmlPage, $anime_name) === FALSE ) {
			//this anime doesn't exist on their list.
		} else {
			$anime_rating_section = get_enclosed_string($xmlPage, "<series_title>".$anime_name."</series_title>", '</'.$type.'>');
			if (!$anime_rating_section || $anime_rating_section == '' || !(strpos($anime_rating_section, "<myanimelist>") === FALSE)) {
				//user has not watched anime.
				$friend_rating = 0;
				$friend_status = 7;
			} else {
				$friend_rating = get_enclosed_string($anime_rating_section, "<my_score>", "</my_score>");
				//get this friend's status of the animu.
				//get a list of positions for category headings so we can compare their positions to that of the rating.
				$friend_status = get_enclosed_string($anime_rating_section, "<my_status>", "</my_status>");
			}
		}
		if ($friend_status != 7) {
			//store in arrays for sorting afterwards.
			$friend_list["$friend_username"] = $friend_rating;
			$friend_statuses["$friend_username"] = $friend_status;
		}
				
		$progress_increment++;
		if ($progress_increment % 10 == 0) {
			//update progress.
			$update_progress = std_query($dbConn, "UPDATE `progress`
											SET `progress` = ".round($progress_increment / $total_members, 4)."
											WHERE `timecode` = '".md5($timecode)."'
											LIMIT 1");
			if (mysqli_affected_rows() < 1) {
				//someone's removed the progress row in the MySQL db. halt execution.
				exit;
			}
		}
	}
}

function construct_updated_anime_list_parallel($mal_link, $type="anime") {
	//makes a new MAL anime list from scratch.
	global $mal_parallel_curl,$member_listing,$friend_list,$friend_statuses,$progress_increment;

	//log in as me (yay)
	$cookieString = getMALlogincookie();
	if ($cookieString == -2) {
		//wrong login data or something.
		throw_error("Could not log into MAL. Maybe I've been banned, or MAL is down?");
		exit;	
	} elseif ($cookieString == -3) {
		//wrong login data or something.
		throw_error("Could not log into MAL. Maybe I've been banned, or MAL is down?");
		exit;
	}
	
	//check to make sure this anime exists.
	$mal_anime_page = hitPage($mal_link, $cookieString);
	if (strpos($mal_anime_page, "myanimelist.net") === FALSE || !(strpos($mal_link, 'mal_anime.php') === FALSE)) {
		//not a MAL page (probably).
		throw_error("This is not a MAL url. Please check your input.");
		exit;
	}
	$anime_name = get_enclosed_string($mal_anime_page, '<title>', ' - MyAnimeList.net</title>');
	if (!$anime_name) {
		//not a MAL anime (probably).
		throw_error("This is not a MAL anime url. Please check your input.");
		exit;
	}
	
	//hit the LL club page.
	$ll_club_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members", $cookieString);
	
	//insert timecode for now.
	connectSQL();
	$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
									SET `timecode` = '".md5($_REQUEST['timecode'])."', 
									`time_added` = ".time().",
									`progress` = 0");	

	//get the total number of pages of members.
	$total_members = get_enclosed_string($ll_club_members, 'Total Members: ', ',');
	$total_pages = intval($total_members/36);
	
	//set the unformatted status array.
	$status_array[1] = "currently watching";
	$status_array[2] = "completed";
	$status_array[3] = "on-hold";
	$status_array[4] = "plan to watch";
	$status_array[5] = "dropped";
	
	$friend_list = array();
	$friend_statuses = array();
	$progress_increment = 0;
	$curl_request_options = array(
		CURLOPT_COOKIE => $cookieString,
		CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;",
		CURLOPT_ENCODING => "gzip,deflate",
		CURLOPT_REFERER => "",
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_MAXREDIRS => 2
	);
	$mal_parallel_curl = new ParallelCurl(20, $curl_request_options);
	//now loop over each page.
	for ($page_number = 0; $page_number <= $total_pages; $page_number++) {
		$mal_parallel_curl->startRequest("http://myanimelist.net/clubs.php?id=6871&action=view&t=members&show=".($page_number*36), 'process_MAL_club_anime_page', array($anime_name,$type,$total_members,$_REQUEST['timecode']));
	}
	$mal_parallel_curl->finishAllRequests();

	//remove timecode.
	$remove_timecode = std_query($dbConn, "DELETE FROM `progress`
								WHERE `timecode` = '".md5($_REQUEST['timecode'])."'
								LIMIT 1");

	return array($anime_name, $friend_list, $friend_statuses);
}

function process_MAL_club_friend_page($friend_profile, $link_url, $ch, $parameters) {

	global $mal_parallel_curl,$total_members,$friend_list,$friend_manga_list,$friend_shared_list,$friend_manga_shared_list;
	$friend_number = $parameters[0];
	$timecode = $parameters[1];
	
	//if this is the current user's profile then don't include them in the results.
	if (!(strpos($friend_profile, 'font-weight: bold; text-align: right;">') === FALSE)) {
		//grab their username, shared anime count, and compatibility.
		$friend_username = get_enclosed_string($friend_profile, '<h1><div style="float: right;"><small><a href="http://myanimelist.net/animelist/', '">');
		$friend_shared_count = get_enclosed_string($friend_profile, '</div>Anime You Share (', ')</div>');
		$friend_compatibility = get_enclosed_string($friend_profile, 'font-weight: bold; text-align: right;">', '%</div>');
		$friend_manga_compatibility = get_enclosed_string($friend_profile, 'font-weight: bold; text-align: right;">', '%</div>', strpos($friend_profile, 'font-weight: bold; text-align: right;">')+1);
		$friend_manga_shared_count = get_enclosed_string($friend_profile, '</div>Manga You Share (', ')</div>');
		
		//make sure that blank compatibilities are being set to 0.
		if (intval($friend_compatibility) == 0) {
			$friend_compatibility = 0;
		}
		if (intval($friend_manga_compatibility) == 0) {
			$friend_manga_compatibility = 0;
		}
		if (intval($friend_shared_count) == 0) {
			$friend_shared_count = 0;
		}
		if (intval($friend_manga_shared_count) == 0) {
			$friend_manga_shared_count = 0;
		}
		
		//store in arrays for sorting afterwards.
		$friend_list["$friend_username"] = $friend_compatibility;
		$friend_manga_list["$friend_username"] = $friend_manga_compatibility;
		$friend_shared_list["$friend_username"] = $friend_shared_count;
		$friend_manga_shared_list["$friend_username"] = $friend_manga_shared_count;
		
		if ($friend_number % 5 == 0) {
			//update progress.
			$update_progress = std_query($dbConn, "UPDATE `progress`
											SET `progress` = ".round($friend_number/$total_members, 4)."
											WHERE `timecode` = '".md5($timecode)."'
											LIMIT 1");
			if (mysqli_affected_rows() < 1) {
				//someone's removed the progress row in the MySQL db. halt execution.
				exit;
			}
		}
	}
}

function construct_updated_friend_list_parallel($username, $password, $userid, $php_sessid, $timecode, $sats_only) {
	//makes a new MAL friend list from scratch.
	global $mal_parallel_curl,$friend_number,$total_members,$friend_list,$friend_manga_list,$friend_shared_list,$friend_manga_shared_list;

	if ($username != '' && $password != '') {
		//user is sending a MAL username and password.
		$cookieString = getMALlogincookie($username, $password);
		if ($cookieString == -2) {
			//wrong login data or something.
			throw_error("Could not log in with those credentials. Please try re-entering them.");
			exit;	
		} elseif ($cookieString == -3) {
			//wrong login data or something.
			throw_error("Could not access MAL page after login. Maybe you've been banned, or MAL is down?");
			exit;
		}
	} else {
		//user is sending a php sessid and userid for MAL.
		//string to imitate a MAL login. included with each cURL request.
		$cookieString = 'A='.$userid.'; B=' . $php_sessid;
	}

	connectSQL();
	$friend_list = array();
	$friend_shared_list = array();
	$friend_manga_list = array();
	$friend_manga_shared_list = array();

	if ($sats_only == "true") {
		//we're just getting those users in the SAT table.
		//insert timecode for now.
		$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
										SET `timecode` = '".md5($timecode)."', 
										`time_added` = ".time().",
										`progress` = 0");
		
		//get the users in the table.
		$sat_users = std_query($dbConn, "SELECT `mal_username` FROM `users`
								WHERE `mal_username` != ''");
		$total_members = mysqli_num_rows($sat_users);
		
		$friend_number = 1;
		$friend_list = array();
		$curl_request_options = array(
			CURLOPT_COOKIE => $cookieString,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;",
			CURLOPT_ENCODING => "gzip,deflate",
			CURLOPT_REFERER => "",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 2
		);
		$mal_parallel_curl = new ParallelCurl(20, $curl_request_options);
		//now loop over each page.
		while ($sat_user = mysqli_fetch_assoc($sat_users)) {
			//hit this friend's profile.
			$mal_parallel_curl->startRequest("http://myanimelist.net/profile/".$sat_user['mal_username'], 'process_MAL_club_friend_page', array($friend_number,$timecode));
			$friend_number++;
		}
		$mal_parallel_curl->finishAllRequests();
	} else {
		//hit the LL club page, we're getting everybody.
		$ll_club_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members", $cookieString);
		
		if (!(strpos($ll_club_members, 'Username:') === FALSE)) {
			//wrong login data or something.
			throw_error("Could not log in with those credentials. Please try re-entering them.");
			exit;
		}
		
		//insert timecode for now.
		$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
										SET `timecode` = '".md5($timecode)."', 
										`time_added` = ".time().",
										`progress` = 0");
		
		//get the total number of pages of members.
		$total_members = get_enclosed_string($ll_club_members, 'Total Members: ', ',');
		$total_pages = intval($total_members/36);
		
		$progress_increment = 0;
		
		//now loop over each page.
		$curl_request_options = array(
			CURLOPT_COOKIE => $cookieString,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;",
			CURLOPT_ENCODING => "gzip,deflate",
			CURLOPT_REFERER => "",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 2
		);		
		$mal_parallel_curl = new ParallelCurl(20, $curl_request_options);
		for ($page_number = 0; $page_number <= $total_pages; $page_number++) {

			$page_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members&show=".($page_number*36), $cookieString);

			//get just the portion of the page that we need.
			$member_listing[$page_number] = get_enclosed_string($page_members, '<td align="center"  class="borderClass">', '</table>');
			
			$first_friend = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="')+strlen('<div style="margin-bottom: 7px;"><a href="');
			$friend_end = 0;
			
			//loop over this section of text, extracting members.
			for ($friend_number = 1; $friend_number <= 36; $friend_number++) {
				//get the profile link to this friend.
				$friend_start = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="', $friend_end)+strlen('<div style="margin-bottom: 7px;"><a href="');
				if ($friend_start <= $first_friend && $friend_number != 1) {
					//we've reached the end of this page (and probably the entire friends listing). end loop.
					break;
				}
				$friend_end = strpos($member_listing[$page_number], '">', $friend_start);
				$friend_link = substr($member_listing[$page_number], $friend_start, $friend_end - $friend_start);
				
				$mal_parallel_curl->startRequest($friend_link, 'process_MAL_club_friend_page', array(($page_number*36 + $friend_number),$timecode));

/*				
				//hit this friend's profile.
				do {
					$friend_profile = hitPage($friend_link, $cookieString);
					$pagehits++;
				} while ($friend_profile == "SEINMA_ERROR" && $pagehits < 10);
				if ($friend_profile == "SEINMA_ERROR") {
					echo "Unable to successfully hit ".$friend_link." after 10 attempts.";
				}

				//if this is the current user's profile then don't include them in the results.
				if (!(strpos($friend_profile, 'font-weight: bold; text-align: right;">') === FALSE)) {
					//grab their username, shared anime count, and compatibility.
					$friend_username = get_enclosed_string($friend_profile, '<h1><div style="float: right;"><small><a href="http://myanimelist.net/animelist/', '">');
					$friend_shared_count = get_enclosed_string($friend_profile, '</div>Anime You Share (', ')</div>');
					$friend_compatibility = get_enclosed_string($friend_profile, 'font-weight: bold; text-align: right;">', '%</div>');
					$friend_manga_compatibility = get_enclosed_string($friend_profile, 'font-weight: bold; text-align: right;">', '%</div>', strpos($friend_profile, 'font-weight: bold; text-align: right;">')+1);
					$friend_manga_shared_count = get_enclosed_string($friend_profile, '</div>Manga You Share (', ')</div>');
					
					//make sure that blank compatibilities are being set to 0.
					if (intval($friend_compatibility) == 0) {
						$friend_compatibility = 0;
					}
					if (intval($friend_manga_compatibility) == 0) {
						$friend_manga_compatibility = 0;
					}
					if (intval($friend_shared_count) == 0) {
						$friend_shared_count = 0;
					}
					if (intval($friend_manga_shared_count) == 0) {
						$friend_manga_shared_count = 0;
					}
					
					//store in arrays for sorting afterwards.
					$friend_list["$friend_username"] = $friend_compatibility;
					$friend_manga_list["$friend_username"] = $friend_manga_compatibility;
					$friend_shared_list["$friend_username"] = $friend_shared_count;
					$friend_manga_shared_list["$friend_username"] = $friend_manga_shared_count;
					
					if ($friend_number % 5 == 0) {
						//update progress.
						$update_progress = std_query($dbConn, "UPDATE `progress`
														SET `progress` = ".round(($page_number*36 + $friend_number)/$total_members, 4)."
														WHERE `timecode` = '".md5($timecode)."'
														LIMIT 1");
						if (mysqli_affected_rows() < 1) {
							//someone's removed the progress row in the MySQL db. halt execution.
							exit;
						}
					}
				}*/
			}
		}
		$mal_parallel_curl->finishAllRequests();
	}
	
	//remove timecode.
	$remove_timecode = std_query($dbConn, "DELETE FROM `progress`
								WHERE `timecode` = '".md5($timecode)."'
								LIMIT 1");
	
	return array($friend_list, $friend_shared_list, $friend_manga_list, $friend_manga_shared_list);
}

function process_MAL_club_anime_stats_page($friend_profile, $link_url, $ch, $parameters) {

	global $mal_parallel_curl,$total_members,$friend_list;
	$friend_number = $parameters[0];
	$timecode = $parameters[1];
	
	//if this is the current user's profile then don't include them in the results.
	if (!(strpos($friend_profile, 'font-weight: bold; text-align: right;">') === FALSE)) {
		//grab their username, shared anime count, and compatibility.
		$friend_username = get_enclosed_string($friend_profile, '<h1><div style="float: right;"><small><a href="http://myanimelist.net/animelist/', '">');
		$time = get_enclosed_string($friend_profile, '<span title="Days">', '</span>');
		$watching = get_enclosed_string($friend_profile, 'Watching</span></td>
		<td align="center">', '</td>');
		$completed = get_enclosed_string($friend_profile, 'Completed</span></td>
		<td align="center">', '</td>');
		$onhold = get_enclosed_string($friend_profile, 'On Hold</span></td>
		<td align="center">', '</td>');
		$dropped = get_enclosed_string($friend_profile, 'Dropped</span></td>
		<td align="center">', '</td>');
		$plantowatch = get_enclosed_string($friend_profile, 'Plan to Watch</span></td>
		<td align="center">', '</td>');
		
		//store in arrays for sorting afterwards.
		$friend_list[$friend_username]["time"] = $time;
		$friend_list[$friend_username]["watching"] = $watching;
		$friend_list[$friend_username]["completed"] = $completed;
		$friend_list[$friend_username]["onhold"] = $onhold;
		$friend_list[$friend_username]["dropped"] = $dropped;
		$friend_list[$friend_username]["plantowatch"] = $plantowatch;
		
		if ($friend_number % 5 == 0) {
			//update progress.
			$update_progress = std_query($dbConn, "UPDATE `progress`
											SET `progress` = ".round($friend_number/$total_members, 4)."
											WHERE `timecode` = '".md5($timecode)."'
											LIMIT 1");
			if (mysqli_affected_rows() < 1) {
				//someone's removed the progress row in the MySQL db. halt execution.
				exit;
			}
		}
	}
}

function construct_updated_anime_stats_list_parallel($timecode, $sats_only) {
	//makes a new MAL friend list from scratch.
	global $mal_parallel_curl,$friend_number,$total_members,$friend_list;

	connectSQL();
	$friend_list = array();
	if ($sats_only == "true") {
		//we're just getting those users in the SAT table.
		//insert timecode for now.
		$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
										SET `timecode` = '".md5($timecode)."', 
										`time_added` = ".time().",
										`progress` = 0");
		
		//get the users in the table.
		$sat_users = std_query($dbConn, "SELECT `mal_username` FROM `users`
								WHERE `mal_username` != ''");
		$total_members = mysqli_num_rows($sat_users);
		
		$friend_number = 1;
		$friend_list = array();
		$curl_request_options = array(
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;",
			CURLOPT_ENCODING => "gzip,deflate",
			CURLOPT_REFERER => "",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 2
		);
		$mal_parallel_curl = new ParallelCurl(20, $curl_request_options);
		//now loop over each page.
		while ($sat_user = mysqli_fetch_assoc($sat_users)) {
			//hit this friend's profile.
			$mal_parallel_curl->startRequest("http://myanimelist.net/profile/".$sat_user['mal_username'], 'process_MAL_club_anime_stats_page', array($friend_number,$timecode));
			$friend_number++;
		}
		$mal_parallel_curl->finishAllRequests();
	} else {
		//hit the LL club page, we're getting everybody.
		$ll_club_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members", $cookieString);
		
		if (!(strpos($ll_club_members, 'Username:') === FALSE)) {
			//wrong login data or something.
			throw_error("Could not log in with those credentials. Please try re-entering them.");
			exit;
		}
		
		//insert timecode for now.
		$insert_timecode = std_query($dbConn, "INSERT INTO `progress`
										SET `timecode` = '".md5($timecode)."', 
										`time_added` = ".time().",
										`progress` = 0");
		
		//get the total number of pages of members.
		$total_members = get_enclosed_string($ll_club_members, 'Total Members: ', ',');
		$total_pages = intval($total_members/36);
		
		$progress_increment = 0;
		
		//now loop over each page.
		$curl_request_options = array(
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.6;",
			CURLOPT_ENCODING => "gzip,deflate",
			CURLOPT_REFERER => "",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 2
		);		
		$mal_parallel_curl = new ParallelCurl(20, $curl_request_options);
		for ($page_number = 0; $page_number <= $total_pages; $page_number++) {

			$page_members = hitPage("http://myanimelist.net/clubs.php?id=6871&action=view&t=members&show=".($page_number*36), $cookieString);

			//get just the portion of the page that we need.
			$member_listing[$page_number] = get_enclosed_string($page_members, '<td align="center"  class="borderClass">', '</table>');
			
			$first_friend = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="')+strlen('<div style="margin-bottom: 7px;"><a href="');
			$friend_end = 0;
			
			//loop over this section of text, extracting members.
			for ($friend_number = 1; $friend_number <= 36; $friend_number++) {
				//get the profile link to this friend.
				$friend_start = strpos($member_listing[$page_number], '<div style="margin-bottom: 7px;"><a href="', $friend_end)+strlen('<div style="margin-bottom: 7px;"><a href="');
				if ($friend_start <= $first_friend && $friend_number != 1) {
					//we've reached the end of this page (and probably the entire friends listing). end loop.
					break;
				}
				$friend_end = strpos($member_listing[$page_number], '">', $friend_start);
				$friend_link = substr($member_listing[$page_number], $friend_start, $friend_end - $friend_start);
				$mal_parallel_curl->startRequest($friend_link, 'process_MAL_club_anime_stats_page', array(($page_number*36 + $friend_number),$timecode));
			}
		}
		$mal_parallel_curl->finishAllRequests();
	}
	
	//remove timecode.
	$remove_timecode = std_query($dbConn, "DELETE FROM `progress`
								WHERE `timecode` = '".md5($timecode)."'
								LIMIT 1");
	
	return $friend_list;
}

function getTopicSubdomain($topicID, $cookieString) {
	//sets the proper subdomain for this topic.
	$subdomain = "boards";
	$first_page = hitPageSSL("http://".$subdomain.".endoftheinter.net/showmessages.php?board=42&topic=".intval($topicID), $cookieString);
	if (!(strpos($first_page, '404 - Not Found') === FALSE)) {
		$subdomain = "archives";
	}
	return $subdomain;
}

function getTopicTitle($topic_html) {
	//returns the topic title from a topic page's html.
	return trim(get_enclosed_string($topic_html, "<head><title>End of the Internet - ", "</title>"));
}

function getTopicCurrentPage($topic_html) {
	//returns the topic's current page number from a topic page's html.
	return intval(get_enclosed_string($topic_html, 'Page ', ' of'));
}

function getTopicTotalPages($topic_html) {
	//returns the number of pages in a topic from a topic page's html.
	return intval(get_enclosed_string($topic_html, ' of <span>', '</span>'));
}

function getTopicPostArray($topic_html) {
	//returns an array of posts on this topic page.
	$array_posts = explode('</div></td></tr></table></div>', $topic_html);
	return array_slice($array_posts, 0, -1);
}

function getTopicPostCount($topic_html) {
	//returns the number of posts on this topic page.
	return (substr_count($topic_html, '</td></tr></table></div>') - 1);
}

function getPostTime($topic_html) {
	//returns the UNIX timestamp of a post in a topic message listing.
	return intval(strtotime(get_enclosed_string($topic_html, '<b>Posted:</b> ', ' |')));
}

function setTopicDescriptionFromFirstPage($first_page, $topic_url, $ch, $parameters) {
	//sets topic description from a topic page and sets it.
	//checks to see if topic length is set, and if it is not, calls a request to set it.
	global $satParallelCurl, $topic_list;
	
	$topicID = $parameters[0];
	$subdomain = $parameters[1];
	$dbConn = $parameters[2];
	
	$description = getTopicTitle($first_page);
	$topic_list[$topicID]['description'] = $description;
	
/*	echo "Updating topicID ".$topicID." description with ".$description."!
"; */
	
	$update_topic_description = std_query($dbConn, "UPDATE `topics`
										SET `description` = ".quote_smart($dbConn, $description)."
										WHERE `ll_topicid` = ".intval($topicID)."
										LIMIT 1");
										
	if ($topic_list[$topicID]['length'] == 0) {
		//if the time duration of this topic is unset, call a request to set it.
		$startTopicTime = getPostTime($first_page);
		$lastPageNum = getTopicTotalPages($first_page);
		$satParallelCurl->startRequest("https://".$subdomain.".endoftheinter.net/showmessages.php?board=42&topic=".$topicID."&page=".$lastPageNum, 'setTopicLengthFromLastPage', array($topicID, $subdomain, $startTopicTime, $lastPageNum, $dbConn));		
	}
}

function setTopicLengthFromLastPage($last_page, $topic_url, $ch, $parameters) {
	//gets topic length from the last page of a topic and first-post time information passed in $parameters, and sets it.
	//checks to see if topic postcount is set, and if it is not, calls a function to calculate and set it.
	global $satParallelCurl, $topic_list;

	$topicID = $parameters[0];
	$subdomain = $parameters[1];
	$startTopicTime = $parameters[2];
	$lastPageNum = $parameters[3];
	$dbConn = $parameters[4];
	
	$topicPostArray = getTopicPostArray($last_page);
	
	$endTopicTime = getPostTime(array_pop($topicPostArray));
	$length = $endTopicTime - $startTopicTime;
	
	$topic_list[$topicID]['length'] = $length;
		
	$update_topic_length = std_query($dbConn, "UPDATE `topics`
										SET `length` = ".intval($length)."
										WHERE `ll_topicid` = ".intval($topicID)."
										LIMIT 1");
										
	if ($topic_list[$topicID]['posts'] == 0) {
		//if the number of posts in this topic is unset, update it.
		$setTopicPosts = setTopicPostsFromLastPage($dbConn, $last_page, $lastPageNum, $topicID);
	}

}

function setTopicPostsFromLastPage($dbConn, $last_page, $lastPageNum, $topicID) {
	//gets topic postcount from the last page of a topic and sets it for the given topicID.
	global $topic_list;
	$lastPagePosts = getTopicPostCount($last_page);

	$posts = 50*($lastPageNum-1) + $lastPagePosts;
	if ($posts > 0) {
		$topic_list[$topicID]['posts'] = $posts;
		$update_topic_posts = std_query($dbConn, "UPDATE `topics`
											SET `posts` = ".intval($posts)."
											WHERE `ll_topicid` = ".intval($topicID)."
											LIMIT 1");
	}
}

function setUserPostPagesFromFirstPage($first_page, $topic_url, $ch, $parameters) {
	//gets the number of pages that a user posted in a given topic.
	//then calls an additional request for the last page to find the precise number of posts for said user.
	global $satParallelCurl;
	$userID = $parameters[0];
	$topicID = $parameters[1];
	$subdomain = $parameters[2];
	$dbConn = $parameters[3];
	
	//make a call to the last page of the user's posts and set their number of posts in this topic.
	$lastPageNum = getTopicTotalPages($first_page);
	
	$satParallelCurl->startRequest("https://".$subdomain.".endoftheinter.net/showmessages.php?board=42&topic=".$topicID."&u=".$userID."&page=".$lastPageNum, 'setUserTopicPostsFromLastPage', array($userID, $topicID, $subdomain, $lastPageNum, $dbConn));	
}

function setUserTopicPostsFromLastPage($last_page, $topic_url, $ch, $parameters) {
	//gets the total number of posts a user made in a topic and sets it.
	global $satParallelCurl, $users_topics_array, $users_posts_processed, $topic_count_array;
	$userID = $parameters[0];
	$topicID = $parameters[1];
	$subdomain = $parameters[2];
	$lastPageNum = $parameters[3];
	$dbConn = $parameters[4];

	$lastPagePosts = getTopicPostCount($last_page);

	//update array.
	$numPosts = (($lastPageNum-1)*50 + $lastPagePosts);

	if ($numPosts < 0) {
		$numPosts = 0;
	}
	
	$users_posts_processed[$userID] += $numPosts;
	$users_topics_array[$userID][$topic_count_array[$topicID]] = $numPosts;
	
}

?>
