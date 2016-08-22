<?php

//links.php
//handler for link listings.

include_once('includes.php');

if (!logged_in()) {
    //eject this user.
    header("Location: index.php?r=".urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$page = intval($_GET['page']);
if ($page == 0) {
	$page = 1;
}

if ($_GET['s_aw'] != '' || $_GET['s_ep'] != '' || $_GET['s_ao'] != '' || $_GET['s_wo'] != '' || $_GET['c_is'] != '') {
    //user has searched something.
    display_header("Search for links");
    echo "<h1>Search for Links</h1>";
	
	//find out if they're doing an advanced search or not.
	if ($_GET['mode'] == 'as') {
		//oh shit.
		$match_against_criteria = "";
	
		//sort the ALL OF THESE WORDS field.
		$all_terms = stripslashes($_GET['s_aw']);
		if ($all_terms != 'NULL' && $all_terms != '') {
			$all_terms = preg_split("[\W]", urldecode($all_terms));
			$match_against_criteria .= " "."+".implode(" +", $all_terms);
		}
		
		//sort the EXACT PHRASE field.
		$exact_term = stripslashes($_GET['s_ep']);
		if ($exact_term != 'NULL' && $exact_term != '') {
			$exact_term = str_replace(array("'", '"'), '', urldecode($exact_term));
			$match_against_criteria .= " +#*#*#*#*#*#*#".$exact_term."#*#*#*#*#*#*#";
		}

		//sort the AT LEAST ONE WORD field.
		$one_term_array = preg_split("[\W]", urldecode(stripslashes($_GET['s_ao'])));
		if (!empty($one_term_array)) {
			$one_term = "";
			foreach($one_term_array as $value) {
				if ($value != 'NULL' && $value != '') {
					if ($one_term == "") {
						$one_term = $value;
					} else {
						$one_term .= " ".($value);
					}
				}
			}
			if ($one_term != '') {
				$match_against_criteria .= " +(".$one_term.")";
			}
		}

		//sort the WITHOUT THE WORDS field.
		if ($_GET['s_wo'] != '') {
			$no_term_array = preg_split("[\W]", urldecode(stripslashes($_GET['s_wo'])));
			if (!empty($no_term_array)) {
				foreach($no_term_array as $value) {
					$match_against_criteria .= " -".$value;
				}
			}
		}
		
		if ($match_against_criteria == '') {
			$field_search = "1=1";
		} else {
			//find out if we're searching in JUST title.
			if ($_GET['s_to'] == 0) {
				$field_search = " MATCH(`title`,`description`, `link`) AGAINST(".quote_smart($dbConn, $match_against_criteria)." IN BOOLEAN MODE)";
			} elseif ($_GET['s_to'] == 1) {
				$field_search = " MATCH(`title`) AGAINST(".quote_smart($dbConn, $match_against_criteria)." IN BOOLEAN MODE)";
			}
		}

		//sort the categories.
		//form currently passes categories as c_is=CATEGORY1&c_is=CATEGORY2&... etc so we parse this.
		$categories = "";
		$arguments = $_SERVER['QUERY_STRING'];
		$category_position = strpos($arguments, "&c_is=");
		
		for ($category_position = strpos($arguments, "&c_is="); !($category_position === FALSE); $category_position = strpos($arguments, "&c_is=", $category_position+1)) {
			$category = html_entity_decode(str_replace("+", " ", get_enclosed_string($arguments, "&c_is=", "&", $category_position)));
			$categories .= " +#*#*#*#*#*#*#".$category."#*#*#*#*#*#*#";
		}
		
		if ($categories != '') {
			$category_search = "MATCH(`categories`) AGAINST(".quote_smart($dbConn, $categories)." IN BOOLEAN MODE)";
		} else {
			$category_search = "1=1";
		}
		//assemble this query.
		$field_search = str_replace("#*#*#*#*#*#*#", '"', $field_search);
		$category_search = str_replace("#*#*#*#*#*#*#", '"', $category_search);
		
		display_links($dbConn, $field_search." AND ".$category_search, "`linkid` DESC", 9999999999, "as", $page);
		
	}
	else {
		//basic search.
		/*$search_term = preg_split("[\W]", $_GET['s_aw']);
		$search_term_fixed = implode("%", $search_term);*/
		display_links($dbConn, "MATCH(`title`, `description`, `link`) AGAINST(".quote_smart($_GET['s_aw'])." IN BOOLEAN MODE)", "`linkid` DESC", 9999999999, "as", $page);
		exit;

	}	
} else {
	//display page.
	switch ($_GET['mode']) {
		case "topweek" :
			display_header("Top Voted this Week");
			display_links($dbConn, "`date` > ".(time() - 604800), "ROUND(((`vote_sum` / `vote_num` - 5) * `vote_num`)/5)*5 DESC, `vote_num` DESC", 2000, "topweek", $page);
			break;
		case "top" :
			display_header("Top Voted");
			display_links($dbConn, "`date` > ".(time() - 63072000), "ROUND(((`vote_sum` / `vote_num` - 5) * `vote_num`)/5)*5 DESC, `vote_num` DESC", 5000, "top", $page);
			break;
		case "new" :
			display_header("New Links");
			
			//get last update time.
			$last_link_date = std_query($dbConn, "SELECT `date` FROM `links`
										ORDER BY `date` DESC
										LIMIT 1");
			$last_link_date = mysqli_fetch_assoc($last_link_date);
			
			display_links($dbConn, "`date` >= ".($last_link_date['date'] - 86400), "`linkid` DESC", 250, "new", $page);
			break;
		case "all" :
			display_header("All Links");
			display_links($dbConn, "1=1", "`linkid` ASC", 99999999999, "all", $page);
			break;
		case "user" :
			display_header("Links Added By User");
			display_links($dbConn, "`userid` = ".intval($_GET['userid']), "`linkid` ASC", 99999999999, "user", $page);		
			break;
		default:
		case "search" :
				header("Location: lsearch.php");
				exit;
			display_header("Search for links");
			display_searchform();
			break;
	}
}
display_footer();
?>
