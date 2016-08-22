<?php

//display.php
//display functions for ll backup.

function start_html() {
	//displays standard outside menu.
	echo "<h1>Y helo thar!</h1>
	Don't have an account? Sync your LL account <a href = 'index.php?page=register'>here!</a><br />
	<form action = 'index.php?r=".urlencode($_REQUEST['r'])."' method = 'post'>
	Username:\t\t<input name = 'username' /><br />
	Password:\t\t<input type = 'password' name = 'password' /><br />
	<input type = 'submit' value = 'Log In' />
	</form>
	";
}

function display_verification_error($error) {
	//displays a standard verification error.
	echo "<h1>Error!</h1>
	$error<br /><br />
	<a href = 'index.php?page=register'>Go back</a>";
	return;
}

function display_pw_transition_form() {
	//displays password transition form.
	echo "<h1>Password Migration</h1>
	In order to migrate to a new password encryption format, you must re-enter your password. Please do so at this time.<br />
	<form action='main.php' method='post'>
		Old password: <input type = 'password' length = '20' name = 'old_pw' /><br />
		New password: <input type = 'password' length = '20' name = 'new_pw' /><br />
		Confirm new password: <input type = 'password' length = '20' name = 'new_pw_2' /><br />
		<input type = 'submit' value = 'Change Password' />
	</form>";
}

function display_header($title=FALSE, $status=FALSE) {
    //displays header stuff.
    $title = htmlentities($title);
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <link rel = "shortcut icon" href = "/favicon.ico" />
  <script type="text/javascript" src="/base.js"></script>
  <script type="text/javascript" src="/static/llbackup.js"></script>  
  <script type="text/javascript" src="/static/selects.js"></script>
  ';
	if (current_filename() == "/admin.php") {
		echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>  
  ';
	}
    if ($title) { //logged in.
        echo '<link rel = "stylesheet" type = "text/css" href = "/style/ncss.css" />
  <title>LL Backup: '.$title.'</title>';
    }
    else {
        echo '<link rel = "stylesheet" type = "text/css" href = "/style/main.css" />
  <title>Linksys, lawls</title>';
    }
    echo '
</head>
';
    if (current_filename() == "/index.php") {
        echo '<body>
    ';
    }
    elseif (current_filename() == "/main.php") {
        echo '<body id = "luelinks" class = "classic" >
    ';
    }
    else {
        echo '<body id = "'.str_replace(".php", "", current_filename()).'" class = "classic" >
    ';
    }
    if ($title) { //logged in.
        echo '  <table class="classic">
    <tr>
        ';
        display_menu_topbar();
        echo '</tr>
    <tr>
        ';
        display_menu_sidebar();
        echo '<td>
    ';
    }
	if ($status) {
		echo "<em>".$status."</em><br />
	";
	}
}

function display_login_form() {
    //displays login form.

    echo "<div id = 'login'><h1>Please log in.</h1>
<form action = 'index.php' method = 'post'>
    <p>
        <label>Username:<br />
        <input name = 'username' size='20'  /></label>
    </p>
    <p>
    <label>Password:<br />
        <input type = 'password' name = 'password' size='20' /></label>
    </p>
    <p>
    <input type = 'submit' value = 'Log In' />
    </p>
</form>
</div>
";
}

function display_menu_sidebar() {
    //displays the sidebar menu
    echo '<th class="classic3" valign="top" width="150">
        <a href="/main.php">Home</a><br />
        <a href="/links.php?mode=all">All links</a><br />
        <a href="/links.php?mode=fav">Favorites</a><br />
        <a href="/links.php?mode=search">Search</a><br />
        <a href="/userlist.php">User List</a><br />
';
	if (check_admin_user()) {
		echo '				<a href="/admin.php">Admin</a><br />
';
	}
	echo '                <a href="/logout.php">Logout</a><br />

        <a href="/help.php">Help</a>
      </th>
    ';
}

function display_menu_topbar() {
    //displays the topbar menu
    echo '<th class="title">LUELinks</th>
      <th>
        <a href="/links.php?mode=new">New links</a> |
        <a href="/links.php?mode=top">Top rated links</a> |
        <a href="/links.php?mode=topweek">Links of the week</a> |
        <a href="/linkme.php?l=random">Random link</a> |
      </th>
    ';
}

function display_userbar() {
	echo '<div class="userbar"><a href="/profile.php?user='.$_SESSION['userid'].'">'.$_SESSION['username'].'</a>: <span id="userbar_pms" style="display:none"><a href="/priv.php">Private Messages (<span id="userbar_pms_count">0</span>)</a> | </span><a href="//wiki.endoftheinter.net/index.php/Help:Rules">Help</a></div>
';
}

function display_users($dbConn, $user_query, $order, $limit, $curr_page) {
	//displays the users meeting the condition in the user query.

	display_userbar();

    $user_list = std_query($dbConn, "SELECT COUNT(*) FROM `ll_users`
                            WHERE ".$user_query."
                            ORDER BY ".$order."
                            LIMIT ".$limit);
    $user_list = mysqli_fetch_assoc($user_list);
    $num_pages = ceil($user_list['COUNT(*)'] / 50);
    if ($num_pages > 1) {
        //multiple pages of links.
        $page_list = paginate($num_pages, '<a href="/userlist.php?&amp;page=', $curr_page);
        echo display_page_nav($curr_page, $num_pages, '<a href="/userlist.php?&amp;page=');
    }

	//get the row number of the first link on this page.
	$first_user_row = ($curr_page-1)*50;	
    //now list 50 users at most on the currently selected page.
    echo '<table class="grid">
    <tr>
      <th><a href="/userlist.php?user=&sort=1&sortd=';
    if (!(strpos($order, "`username` ASC") === FALSE)) {
		echo 1;
    }
    else {
		echo 2;
    }
    echo '">Username</a></th>
      <th><a href="/userlist.php?user=&sort=2&sortd=';
    if (!(strpos($order, "`date_joined` ASC") === FALSE)) {
		echo 1;
    }
    else {
		echo 2;
    }
   echo '">Date Joined</a></th>

      <th><a href="/userlist.php?user=&sort=3&sortd=';
    if (!(strpos($order, "`last_active` ASC") === FALSE)) {
		echo 1;
    }
    else {
		echo 2;
    }
    echo '">Last Active</a></th>
      <th><a href="/userlist.php?user=&sort=4&sortd=';
    if (!(strpos($order, "(`good_tokens` + `contrib_tokens` - `bad_tokens`) ASC") === FALSE)) {
		echo 1;
    }
    else {
		echo 2;
    }
    echo '">Tokens</a></th>
    </tr>
    ';
    $row_no = 0;
	$user_list = std_query($dbConn, "SELECT * FROM `ll_users`
				WHERE ".$user_query."
				ORDER BY ".$order."
				LIMIT ".($first_user_row).", 50;");
    while ($user = mysqli_fetch_assoc($user_list)) {
	echo '<tr>
      <td><a href="/profile.php?user='.$user['userid'].'">'.htmlentities($user['username']).'</a></td>
      <td>'.($user['created'] == 0 ? '' : date('m/d/y h:i:s A', $user['created'])).'</td>
      <td>'.($user['lastactive'] == 0 ? '' : date('m/d/y h:i:s A', $user['lastactive'])).'</td>
      <td>'.($user['good_tokens'] + $user['contrib_tokens'] - $user['bad_tokens']).'</td>
    </tr>
    ';
        $row_no++;
        if ($row_no > 1) {
            $row_no = 0;
        }
    }
    echo '</table>
'.$page_list;
}

function display_user_profile($dbConn, $userid) {
	//displays a user's profile.
	
	//first, get their user information.
	$user_info = std_query($dbConn, "SELECT * FROM `ll_users`
							WHERE `userid` = ".intval($userid)."
							LIMIT 1");
	if (mysqli_num_rows($user_info) < 1) {
		echo "<h2><em>User doesn't exist</em></h2>";
	} else {
		$user_info = mysqli_fetch_assoc($user_info);
		echo '<h1>User Information Page</h1>
';
	display_userbar();
	echo '<table class="grid">
    <tr>
      <th colspan="2">Current Information for '.$user_info['username'].'</th>
    </tr>

    <tr>
      <td>User Name</td>
      <td>'.$user_info['username'].'</td>
    </tr>
	';
	if ($user_info['status'] != 0) {
		echo '<tr>
      <td>Status</td>
      <td><strong>'.userstatus_to_text($user_info['status']).'</strong></td>
    </tr>
	';
	}
    echo '<tr>
      <td>User ID</td>
      <td>'.$user_info['userid'].'</td>

    </tr>
    <tr>
      <td>Tokens</td>
      <td>'.($user_info['good_tokens'] + $user_info['contrib_tokens'] - $user_info['bad_tokens']).'</td>
    </tr>
   <tr>
      <td>Good Tokens</td>
      <td>'.($user_info['good_tokens']).'</td>
    </tr>
    <tr>
      <td>Bad Tokens</td>
      <td>'.($user_info['bad_tokens']).'</td>
    </tr>
    <tr>

      <td><a href="/links.php?mode=user&amp;userid='.$user_info['userid'].'&amp;type=3">Contribution Tokens</a></td>
      <td>'.($user_info['contrib_tokens']).'</td>
    </tr>
    <tr>
      <td>Account Created</td>
      <td>'.date('m/d/y H:i', $user_info['created']).'</td>
    </tr>

    <tr>
      <td>Last Active</td>
      <td>'.date('m/d/y H:i', $user_info['lastactive']).'</td>
    </tr>
    <tr>
      <td>Signature</td>
      <td>'.($user_info['signature']).'</td>
    </tr>
    <tr>
      <td>Quote</td>
      <td>'.($user_info['quote']).'</td>
    </tr>
    <tr>
      <td>Email Address</td>
      <td>'.($user_info['email']).'</td>
    </tr>
    <tr>
      <td>Instant Messaging</td>
      <td>'.($user_info['im']).'</td>
    </tr>
    <tr>
      <td>Picture</td>
      <td>'.parse_description($user_info['picture']).'</td>
    </tr>

    <tr>
      <th colspan="2">More Options</th>
    </tr>
    <tr>
      <td colspan="2"><a href="/token.php?me='.$_SESSION['userid'].'&amp;type=1&amp;user='.$user_info['userid'].'">Give '.$user_info['username'].' A Bad Token</a></td>
    </tr>
    <tr>
      <td colspan="2"><a href="/loser.php?userid='.$user_info['userid'].'">View '.$user_info['username'].'\'s Stats</a></td>

    </tr>
    <tr>
      <td colspan="2"><a href="/links.php?mode=user&amp;userid='.$user_info['userid'].'">View All Links Added By '.$user_info['username'].'</a></td>
    </tr>
    <tr>
      <td colspan="2">View '.$user_info['username'].'\'s Wiki Pages: <a href="//wiki.endoftheinter.net/index.php/'.$user_info['username'].'">Community Page</a> | 
      <a href="//wiki.endoftheinter.net/index.php/User:'.$user_info['username'].'">User Page</a></td>

    </tr>
    <tr>
      <td colspan="2"><a href="/priv.php?userid='.$user_info['userid'].'">Send '.$user_info['username'].' a Private Message</a></td>
    </tr>
  </table>
';	
	}
}

function display_links($dbConn, $link_query, $order, $limit, $mode, $curr_page) {
    //displays the links meeting the condition in link query

	switch ($mode) {
		case "all" :
			echo "<h1>All Links</h1>
";
			break;
		case "new" :
			echo "<h1>New Links</h1>
";
			break;
		case "top" :
			echo "<h1>Top Voted</h1>
";
			break;
		case "topvoted" :
			echo "<h1>Top Voted</h1>
";
			break;
		case "topweek" :
			echo "<h1>Top Voted this Week</h1>
";
			break;
		case "user" :
			echo "<h1>Links Added by User</h1>";
		default :
			break;
	}
	
	display_userbar();

    $link_list = std_query($dbConn, "SELECT COUNT(*) FROM `links`
                            WHERE ".$link_query."
                            ORDER BY ".$order."
                            LIMIT ".$limit);
    $link_list = mysqli_fetch_assoc($link_list);

    $num_pages = ceil($link_list['COUNT(*)'] / 50);
    if ($num_pages > 1) {
        //multiple pages of links.
//        $page_list = paginate($num_pages, '<a href="links.php?s_aw='.$_GET['s_aw'].'&mode='.$mode.'&amp;page=');
        $page_list = paginate($num_pages, '<a href="links.php?'.$_SERVER['QUERY_STRING'].'&amp;page=', $curr_page);
        echo display_page_nav($curr_page, $num_pages, '<a href="links.php?'.$_SERVER['QUERY_STRING'].'&amp;page=');
    }

	//get the row number of the first link on this page.
	$first_link_row = ($curr_page-1)*50;	
	
    //now list 50 links at most on the currently selected page.
    echo '<table class="grid">
    <tr>

      <th><a href="/links.php?'.$_SERVER['QUERY_STRING'].'&amp;sort=2&amp;sortd=1">Title</a></th>
      <th><a href="/links.php?'.$_SERVER['QUERY_STRING'].'&amp;sort=1&amp;sortd=1">Date</a></th>
      <th><a href="/links.php?'.$_SERVER['QUERY_STRING'].'&amp;sort=3&amp;sortd=1">Added by</a></th>
      <th><a href="/links.php?'.$_SERVER['QUERY_STRING'].'&amp;sort=4&amp;sortd=2">Rating</a></th>
    </tr>
    ';
    $row_no = 0;
	
	$link_list = std_query($dbConn, "SELECT * FROM `links`
							WHERE ".$link_query."
							ORDER BY ".$order."
							LIMIT ".($first_link_row).", 50;");
    while ($link = mysqli_fetch_assoc($link_list)) {
        //get username attached with this userid.
        $username = std_query($dbConn, "SELECT `username` FROM `ll_users`
                                WHERE `userid` = ".quote_smart($dbConn, $link['userid'])."
                                LIMIT 1");
        $username = mysqli_fetch_assoc($username);
        echo '<tr class="r'.$row_no.'">
      <td>';
		if ($link['deleted'] == 1) {
			echo '<strong><font color="red">(DELETED)</font></strong> ';
		}
		echo '<a href="/linkme.php?l='.$link['linkid'].'">'.$link['title'].'</a></td>
      <td>';
      if ($link['date'] != 0) {
        echo date('m/d/y H:i', $link['date']);
      }
	  $rating_denominator = $link['vote_num'];
      if ($link['vote_num'] == 0) {
        $rating_denominator = 1;
      }
      echo '</td>
      <td><a href="/profile.php?user='.$link['userid'].'">'.$username['username'].'</a></td>
      <td>'.round($link['vote_sum']/$rating_denominator, 2).'/10 (based on '.$link['vote_num'].' votes)</td>
    </tr>
    ';
        $row_no++;
        if ($row_no > 1) {
            $row_no = 0;
        }
    }
    echo '</table>
'.$page_list;
}

function display_link($dbConn, $link_array) {
    //displays info for a single link.
    //get username for this link.
    $username = std_query($dbConn, "SELECT `username` FROM `ll_users`
                            WHERE `userid` = ".quote_smart($dbConn, $link_array['userid'])."
                            LIMIT 1");
    $username = mysqli_fetch_assoc($username);

    if ($link_array['vote_num'] == 0)
        $vote_number = 1;
    else
        $vote_number = $link_array['vote_num'];

    echo "<h1>".$link_array['title']."</h1>
  <br /><br />
";
	if ($link_array['deleted'] == 1) {
		echo "  <strong><font color='red'>(Deleted link)</font></strong><br />
";
	}

    if ($link_array['link'] == "See below") {
    	echo "  See below";
    }
    else {
	echo "  <a href = '".htmlentities($link_array['link'])."' target = '_blank' >".htmlentities($link_array['link'])."</a>";
    }
    echo "
  <br /><br />
  <b>Added by:</b> <a href='/profile.php?user=".$link_array['userid']."'>".$username['username']."</a><br />

<b>Date:</b> ".date('r', $link_array['date'])."<br />
  <b>Rating:</b> ".round($link_array['vote_sum'] / $vote_number, 2)."/10 (based on ".intval($link_array['vote_num'])." votes)<br />

  <b>Categories:</b> ".htmlentities($link_array['categories'])."<br />
  <b>Description:</b>

".parse_description($link_array['description'])."<br /><br />
";
	display_userbar();
}

function parse_description($description) {
	//parses a link description, replacing image links with proxy image links.
	//deprecated since images no longer require a session.
/*
	for ($position = strpos($description, '"), "\\/\\/'); !($position === FALSE); $position = strpos($description, '"), "\\/\\/', $position+1)) {
		$description = substr($description, 0, $position).'"), "\\/\\/llbackup.dyndns.org\\/image_grab.php?url='.substr($description, $position+strlen('"), "\\/\\/'), strlen($description)-$position);
	}
*/	
	return $description;
}

function display_searchform() {
    echo '<form name="f" action="links.php" method="get">
    Note: Everything is included in the search, so feel free to go nuts with 1 or 2 letter words.<br />
    <input type="text" name="s_aw"> <small><a href="lsearch.php?a">Advanced search</a></small><br />

    <input type="hidden" name="mode" value="s">
    <input type="submit" name="go" value="Search">
  </form>
';
}
function display_page_nav($current_page, $number_pages, $append_link) {
	//append_link should be a link ending with, say, &page=
    $page_nav = '<div class="infobar" id="infobar">';
    if ($current_page != 1) {
        $page_nav .= $append_link.'1">First Page</a> | ';
    }
    if ($current_page > 2) {
        $page_nav .= $append_link.($current_page-1).'">Previous Page</a> | ';
    }
    $page_nav .= 'Page '.$current_page.' of '.$number_pages;
    if ($current_page < $number_pages - 1) {
        $page_nav .= ' | '.$append_link.($current_page+1).'">Next Page</a>';
    }
    if ($current_page != $number_pages) {
        $page_nav .= ' | '.$append_link.($number_pages).'">Last Page</a>';
    }
    $page_nav .= '</div>';
    return $page_nav;
}

function paginate($num_pages, $append_link, $current_page=1) {
	//append_link should be everything up to, say, &page=
    $page_list = '<div class="infobar">Page: ';
    $i = 1;
    while ($i <= $num_pages) {
		if ($i == $current_page) {
			$page_list .= $i.' | ';			
		} else {
			$page_list .= $append_link.$i.'">'.$i.'</a> | ';
		}
        if ($i < 15 || abs($current_page - $i) <= 5 ) {
            $i++;
        } elseif ($i >= 15 && $num_pages <= $i + 5) {
            $i++;
        } elseif ($i >= 15 && $num_pages > $i + 5) {
            $i += 5;
        }
    }
    $page_list .= '</div>';
    return $page_list;
}

function display_welcome() {
	echo "<h1>Welcome to the LL backup!</h1>
		<h2>Things are a bit rough at the moment; please bear with me as I add new features.</h2>
		01-27-12: Links on LL are actually disabled at the moment, and LL is actually an LLC now. Nobody is really sure what's going to happen, but I'll keep you updated on developments.<br />
		01-02-12: Got around to writing a daemon to pull new links from LL every fifteen minutes. No more manual updating ever again \o/<br />
		12-07-11: Fixed a bug where searching certain multi-word categories would return links from other categories.<br />
		09-25-11: Search is (almost) completely fixed, should be much faster. I'd ideally like to allow the use of 'complete phrase' in fields, but for now you'll have to just deal with single-word phrases.<br />
		03-06-11: Search should be fixed now, though it's still pretty slow. Not sure what I can do about that, but I'll think about it in the next few weeks.<br />
		02-08-11: If your session times out, you should be redirected properly to the page you were viewing last now. Link updates are much easier for me to run now and should be happening at least once a day. Search kind of broken at the moment and will take forever to run, but I'll try to fix that in the next few weeks.<br />
		01-08-10: Password migration to SHA256. Also, if you have an active session already the site won't ask you to log in again. Also, images in link descriptions should show up now (though they're slow, be patient).<br />
		03-10-09: Everything in the search should be fully functional (and readable) now.
		";
}

function display_help() {
	echo "<h1>Help!</h1>
		<h2>gl hf dd</h2>
		";
}

function display_admin_panel($dbConn) {
	//displays administrator panel.
	echo "<h1>Administrator Panel</h1>
	<div id = 'admin_panel'>
		";
	if ($_REQUEST['section'] != 'users') {
		echo "<h2><a href = '/admin.php?section=users'>Users</a></h2>
";
	} else {
		if ($_REQUEST['action'] == '') {
			echo "<h2>Users</h2>
		";
		} else {
			echo "		<h2><a href = '/admin.php?section=users'>Users</a></h2>
		";
		}
		display_user_listing($dbConn);
		echo "
";
		if ($_REQUEST['action'] != 'add' && $_REQUEST['action'] != 'edit') {
			echo "<div class = 'admin_subheading_1'><a href = '/admin.php?section=users&action=add'>Add User</a></div>
";
		}
		else {
			echo "		<div class = 'admin_subheading_1'>Add User<br />
			<div class='admin_subheading_2'>";
			display_user_add_form($dbConn, $_REQUEST['userid']);
			echo "		</div>
		</div>
";
		}
	}
	if ($_REQUEST['section'] != 'update') {
		echo "		<h2><a href = '/admin.php?section=update'>Update Stats</a></h2>
";
	} else {
		echo "<h2>Update Stats</h2>
";
		display_update_form($dbConn);
	}
	echo "	</div>
	";
}

function display_user_listing($dbConn) {
	//displays a table of all users.
	$user_listing = std_query($dbConn, "SELECT * FROM `users`
								ORDER BY `userid` ASC
								LIMIT 30");
	if (mysqli_num_rows($user_listing) < 1) {
		//no users in db.
		echo "No users found in database.";
		return;
		exit;
	}
	
	//otherwise, start user table output.
	echo "<table id = 'user_listing'>
	<tr><th>UserID</th><th>Username</th><th>Userlevel</th><th>Verified?</th><th>Email</th><th>Last Login</th><th></th><th></th></tr>
";
	
	$i = 1;
	
	while ($user = mysqli_fetch_assoc($user_listing)) {
		if ($i == 1) {
			echo "<tr class = 'A'>";
		} else {
			echo "<tr class = 'B'>";
		}
    $last_login = get_user_last_login($dbConn, $user['userid']);
		echo "	<td>".intval($user['userid'])."</td><td>".htmlentities($user['username'])."</td><td>".userlevel_to_text(intval($user['userlevel']))."</td><td>".(intval($user['verified']) == 1 ? 'yes' : 'no')."</td><td>".htmlentities($user['email'])."</td><td><a href = 'usermap.php?userid=".intval($user['userid'])."' >".($last_login == 0 ? 'Never' : date('r', get_user_last_login($dbConn, $user['userid'])))."</a></td><td>".($_SESSION['userlevel'] > $user['userlevel'] ? "<a href = '".current_filename()."?section=users&action=edit&userid=".intval($user['userid'])."'><img src='/images/edit.png' title='Edit' alt='Edit' /></a></td><td><a href = '".current_filename()."?section=users&action=delete&userid=".intval($user['userid'])."'><img src='/images/delete.png' title = 'Delete' alt='Delete' /></a></td>" : "</td><td></td>")."</tr>
";
	}
	echo "</table>
	";
}

function display_user_add_form($dbConn, $userid) {
	//form to add a user to the system.
	if (intval($userid) != 0) {
		//get this user's information to display in the form.
		$user = std_query($dbConn, "SELECT `username`, `email`, `userlevel` FROM `users`
							WHERE `userid` = ".intval($userid)."
							LIMIT 1");
		if (mysqli_num_rows($user) < 1) {
			$user = "";
		} else {
			$user = mysqli_fetch_assoc($user);
			if ($user['userlevel'] >= $_SESSION['userlevel']) {
				echo "You do not have permissions to edit this user.";
				$user = "";
			}
		}
	}
	$userlevel_select_text = "";
	for ($i = 0; $i <= 3; $i++) {
		if ($i >= $_SESSION['userlevel']) {
			break;
		}
		$userlevel_select_text .= "<option value = '".$i."' >".htmlentities(userlevel_to_text($i))."</option>";
	}
	
	echo "<form action='".current_filename()."?action=edit' method='post'>
	UserID: <input name = 'userid' size = 3 value = '".(is_array($user) ? htmlentities($userid) : '')."' /><br />
	".(is_array($user) ? "Username: ".htmlentities($user['username'])."<input type = 'hidden' name = 'username' value = '".htmlentities($user['username'])."' /><br />" : "New Username: <input name = 'username' length = 20 /><br />")."
	New Password: <input name = 'password1' size = 20 type = 'password' /><br />
	Confirm Password: <input name = 'password2' size = 20 type = 'password' /><br />
	Email: <input name = 'email' size = 20 value = '".htmlentities($user['email'])."' /><br />
	Userlevel: <select name = 'userlevel'>".$userlevel_select_text."</select><br />
	<input type = 'submit' value = '".(is_array($user) ? "Modify" : "Register")."' />
	</form>
	";
}

function display_update_form($dbConn) {
	echo "	<input name='timecode' id='timecode' type='hidden' value='".(md5($_SERVER['REMOTE_ADDR'].microtime(true)))."' /><br />
	Update: Full <input type = 'radio' name = 'type' value = 'full' id = 'type-full' checked /> | Links <input type = 'radio' name = 'type' value = 'link' id = 'type-link' /> | Users <input type = 'radio' name = 'type' value = 'user' id = 'type-user' /><br />
	Mode: Fast <input type = 'radio' name = 'mode' value = 'fast' id = 'mode-fast' checked /> | Full <input type = 'radio' name = 'mode' value = 'full' id = 'mode-full' /> | Resume <input type = 'radio' name = 'mode' value = 'resume' id = 'mode-resume' /> | Benchmark <input type = 'radio' name = 'mode' value = 'bench' id = 'mode-bench' /><br />
	Start from ID: <input name = 'start_id' value = 0 id = 'start_id' /><br />
	";
	//if an update is already going, 
	$checkProgress = std_query($dbConn, "SELECT `name`, `value` FROM `indices`
								WHERE (`name` = 'link_progress' || `name` = 'user_progress')
								AND `value` != 0
								LIMIT 1");
	if (mysqli_num_rows($checkProgress) > 0) {
		//there is an update already in-progress.
		$updateRow = mysqli_fetch_assoc($checkProgress);
		$updateType = ($updateRow['name'] == 'link_progress') ? 'Links' : 'Users';
		$updateValueArray = explode("/", $updateRow['value']);
		$updateValue = round(100*$updateValueArray[0] / $updateValueArray[1], 2);
		echo "	<input id = 'updateButton' type = 'button' value = 'Update' onclick = 'this.disabled=true; startUpdate(0);' /><br /><br />
		Update type: <div id = 'type'>".$updateType."</div><br />
		Progress: <div id = 'results'>".$updateRow['value']." (".$updateValue."%)</div><br />
		<script>
			$(document).ready(function() {
				clearIntervals();
				intervals.push(window.setInterval(updateProgress,3000,'".$updateRow['name']."'));
			});
		</script>
";
	} else {
		//no update in progress.
		echo "	<input id = 'updateButton' type = 'button' value = 'Update' onclick = 'this.disabled=true; startUpdate(0);' /><br /><br />
		Update type: <div id = 'type'>None</div><br />
		Progress: <div id = 'results'>0%</div><br />
";
	}
}

function display_usermap($dbConn, $userid, $ip) {
	//display a list of recent login attempts for the given userid or IP.
	if ($userid != '') {
		$usermap_criteria = "`userid` = ".intval($userid);
	} elseif ($ip != '') {
		$usermap_criteria = "`ip` = ".quote_smart($dbConn, $ip);
	} else {
		
	}
	$usermap = std_query($dbConn, "SELECT * FROM `usermap`
							WHERE ".$usermap_criteria."
							ORDER BY `time` DESC");
	if (mysqli_num_rows($usermap) < 1) {
		$output_string = "No entries for this userid or IP found.<br />
";
	} else {
		$output_string = "<table>
<tr><th>Time</th><th>Username</th><th>IP</th><th>Type</th></tr>
";
		$userid_username_array[$_SESSION['userid']] = $_SESSION['username'];
		while ($usermap_entry = mysqli_fetch_assoc($usermap)) {
			if (!array_key_exists($usermap_entry['userid'], $userid_username_array)) {
				$get_username = std_query($dbConn, "SELECT `username` FROM `users`
											WHERE `userid` = ".intval($usermap_entry['userid'])."
											LIMIT 1");
				if (mysqli_num_rows($get_username) < 1) {
					$userid_username_array[$usermap_entry['userid']] = "Unknown";
				} else {
					$get_username = mysqli_fetch_assoc($get_username);
					$userid_username_array[$usermap_entry['userid']] = $get_username['username'];
				}
			}
			$output_string .= "<tr><td>".($usermap_entry['time'] <= 0 ? 'None' : date('r', $usermap_entry['time']))."</td><td><a href='usermap.php?userid=".intval($usermap_entry['userid'])."' >".htmlentities($userid_username_array[$usermap_entry['userid']])."</a></td><td><a href='usermap.php?ip=".htmlentities($usermap_entry['ip'])."' >".htmlentities(gethostbyaddr($usermap_entry['ip']))."</a></td><td>".usermap_type_to_text($usermap_entry['type'])."</td></tr>
";
		}
		$output_string .= "</table>
";
	}
	echo $output_string;
}

function display_footer() {
    echo '

<br /><br /><small><b>Time Taken:</b> '.round(microtime(true)-START_TIME, 4).'s <b>sqlly stuff: </b> ugh% <b>Server load:</b> way too high :<</small></td></tr></table></div>
</body>

</html>';
}

function current_filename() {
	//displays the current script's filename.
    $filename = str_replace("/ll_backup/", "", $_SERVER['PHP_SELF']);
    return $filename;
}

function display_defined_vars() {
	//displays all defined variables. debug only!
	$defined_vars = get_defined_vars();
	foreach ($defined_vars as $key=>$value) {
		echo '$'.$key."=>";
		if (is_array($value)) {
			foreach ($value as $key2=>$value2) {
				echo "[".htmlentities($key2)."]=>".htmlentities($value2)."<br />";
			}
		}
		else
		echo "".htmlentities($value)."<br />";
	}
}
?>
