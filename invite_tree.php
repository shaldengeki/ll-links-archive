<?php
include_once("./global/include_globals.php");

function username_to_userid($dbConn, $username) {
	$this_user = std_query($dbConn, "SELECT `userid` FROM `ll_users`
								WHERE `username` = ".quote_smart($dbConn, $username));
	@$this_user = mysqli_fetch_assoc($this_user);
	return intval($this_user['userid']);
}

function userid_to_username($dbConn, $userid) {
	$this_user = std_query($dbConn, "SELECT `username` FROM `ll_users`
								WHERE `userid` = ".intval($userid));
	if (mysqli_num_rows($this_user) != 1) {
		return "Unknown";
	} else {
		$this_user = mysqli_fetch_assoc($this_user);
		return $this_user['username'];
	}
}

function find_children($dbConn, $userid) {
	$children_array = array();
	$children_list = std_query($dbConn, "SELECT `username` FROM `ll_users`
								WHERE `invitedby` = ".intval($userid)."
								ORDER BY `userid` DESC");
	while (@$child = mysqli_fetch_assoc($children_list)) {
		$children_array[] = $child['username'];
	}
	return $children_array;
}

function find_parent($dbConn, $userid) {
	$this_user = std_query($dbConn, "SELECT `invitedby` FROM `ll_users`
								WHERE `userid` = ".intval($userid));
	$this_user = mysqli_fetch_assoc($this_user);
	return intval($this_user['invitedby']);
}

function find_first_ancestor($dbConn, $userid) {
	while (find_parent($dbConn, $userid) != 0) {
		$userid = find_parent($dbConn, $userid);
	}
	return $userid;
}

function find_generation($dbConn, $userid) {
	$generation = 0;
	while (find_parent($dbConn, $userid) != 0) {
		$userid = find_parent($dbConn, $userid);
		$generation++;
	}
	return $generation;
}

echo "<html>
	<head>
		<title>Invite Tree Lookup</title>
	</head>
	<body>
<pre><h1>Invite Tree Lookup</h1>
<form action='invite_tree.php' method='post'>
UserID: <input name='userid' />
<input type='submit' value='Search' />
</form>
";

if ($_POST['userid'] != '') {
	$userid = $_POST['userid'];
} elseif ($_REQUEST['userid'] != '') {
	$userid = $_REQUEST['userid'];
}

if ($userid != '') {
$dbConn = connectSQL("seinma_llusers");
	//user is submitting a userid to view.

	//go up the invite tree until we're at the top.
	$top_parent = find_first_ancestor($dbConn, $userid);
	
	$children_array = array();
	$children_to_process = array(userid_to_username($dbConn, $top_parent));
	while ($children_to_process != array()) {
		$parent = array_pop($children_to_process);
		$children_array[$parent] = find_children($dbConn, username_to_userid($dbConn, $parent));
		foreach ($children_array[$parent] as $child) {
			array_push($children_to_process, $child);
		}
		$i++;
	}
	
	//echo the invite tree.
	foreach ($children_array as $parent=>$children) {
		$generation = find_generation($dbConn, username_to_userid($dbConn, $parent));
		$initial_space = "";
		for ($i=0; $i<$generation; $i++) {
			$initial_space .= "\t";
		}
		echo $initial_space."<em>(Gen".$generation.")</em> ";
		if ($parent == userid_to_username($dbConn, $userid)) {
			echo "<strong><a href='https://endoftheinter.net/profile.php?user=".username_to_userid($dbConn, $parent)."'>".$parent."</a></strong><em> invited: <br />
";
		} else {
			echo "<a href='https://endoftheinter.net/profile.php?user=".username_to_userid($dbConn, $parent)."'>".$parent."</a><em> invited: <br />
";
		}
		if ($children == array()) {
			echo $initial_space."Nobody";
		} else {
			echo $initial_space;
			foreach ($children as $child) {
				if ($child == userid_to_username($dbConn, $userid)) {
					echo "</em><strong>".$child."</strong><em>, ";				
				} else {
					echo $child.", ";
				}
			}
		}
		
		echo "</em><br /><br />
";
	}
}
echo "		</pre>
	</body>
</html>";
?>
