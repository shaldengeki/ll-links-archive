var xmlHttp = new XMLHttpRequest();
var progress = new XMLHttpRequest();
var intervals = new Array();

function roundNumber(num, digits) {
	return num.toFixed(digits);
}

function clearIntervals() {
	for (var i = 0; i < intervals.length; i++) {
		window.clearInterval(intervals[i]);
	}
	intervals = new Array();
}

function startUpdate(startID) {
	// get the form's optional properties.
	var type = document.getElementById("type-full").checked;
	if (type == false) {
		type = document.getElementById("type-link").checked;
		if (type == false) {
			type = document.getElementById("type-user").checked;
			if (type == false) {
				type = "full";
				progress_type = "link";
			} else {
				type = "user";
				progress_type = "user";
			}
		} else {
			type = "link";
			progress_type = "link";
		}
	} else {
		type = "full";
		progress_type = "link";
	}
	var mode = document.getElementById("mode-fast").checked;
	if (mode == false) {
		var mode = document.getElementById("mode-full").checked;
		if (mode == false) {
			mode = document.getElementById("mode-resume").checked;
			if (mode == false) {
				mode = document.getElementById("mode-bench").checked;
				if (mode == false) {
					mode = "full";
				} else {
					mode = "bench";
				}
			} else {
				mode = "resume";
			}
		} else {
			mode = "full";
		}
	} else {
		mode = "fast";
	}
		
	var formStartID = document.getElementById("start_id").value;
	var timecode = document.getElementById("timecode").value;
	
	if ((formStartID != 0) && (formStartID != '') && (formStartID != null)) {
		startID = formStartID;
	}
	
	// Only go on if there are values for the link field.
	if ((startID != 0) && ((startID == null) || (startID == ""))) return;

	document.getElementById("results").innerHTML = '0/0 (0%)';
//	setPercentage(0);
	
	//clear previous intervals.
	clearIntervals();
	intervals.push(window.setInterval(updateProgress,3000,progress_type + "_progress"));
	
	// Build the URL to connect to and
	// setup a function for the server to run when it's done
	if (type == "link") {
		xmlHttp.onreadystatechange = function(interval) {
			updatePage(interval);
		};
		document.getElementById("type").innerHTML = 'Links';
		var url = "/cURL/ll_link_distribution_parallel.php?mode=" + escape(mode) + "&type=" + escape(type) + "&last_id=" + escape(startID) + "&timecode=" + escape(timecode);
	} else if (type == "user") {
		xmlHttp.onreadystatechange = function(interval) {
			updatePage(interval);
		};
		document.getElementById("type").innerHTML = 'Users';
		var url = "/cURL/ll_rating_distribution_parallel.php?mode=" + escape(mode) + "&type=" + escape(type) + "&last_id=" + escape(startID) + "&timecode=" + escape(timecode);
	} else {
		xmlHttp.onreadystatechange = updateUsers;
		document.getElementById("type").innerHTML = 'Links';
		var url = "/cURL/ll_link_distribution_parallel.php?mode=" + escape(mode) + "&type=" + escape(type) + "&last_id=" + escape(startID) + "&timecode=" + escape(timecode);
	}
	
	// Open a connection to the server
	xmlHttp.open("GET", url, true);

	// Send the request
	xmlHttp.send(null);
}

function updateUsers(startID) {
	// get the form's optional properties.
	var type = document.getElementById("type-full").checked;
	if (type == false) {
		type = document.getElementById("type-link").checked;
		if (type == false) {
			type = document.getElementById("type-user").checked;
			if (type == false) {
				type = "full";
			} else {
				type = "user";
			}
		} else {
			type = "link";
		}
	} else {
		type = "full";
	}
	var mode = document.getElementById("mode-fast").checked;
	if (mode == false) {
		var mode = document.getElementById("mode-full").checked;
		if (mode == false) {
			mode = document.getElementById("mode-resume").checked;
			if (mode == false) {
				mode = document.getElementById("mode-bench").checked;
				if (mode == false) {
					mode = "full";
				} else {
					mode = "bench";
				}
			} else {
				mode = "resume";
			}
		} else {
			mode = "full";
		}
	} else {
		mode = "fast";
	}
	var formStartID = document.getElementById("start_id").value;
	var timecode = document.getElementById("timecode").value;

	if ((formStartID != 0) && (formStartID != '') && (formStartID != null)) {
		startID = formStartID;
	}
	
	// Only go on if there are values for the link field.
	if ((startID != 0) && ((startID == null) || (startID == ""))) return;

	document.getElementById("results").innerHTML = '0/0 (0%)';
	document.getElementById("type").innerHTML = 'Users';
//	setPercentage(0);

	//clear previous intervals.
	clearIntervals();
	intervals.push(window.setInterval(updateProgress,3000,"user_progress"));

	// Build the URL to connect to and
	// setup a function for the server to run when it's done
	xmlHttp.onreadystatechange = function(interval) {
		updatePage(interval);
	};
	var url = "/cURL/ll_rating_distribution_parallel.php?mode=" + escape(mode) + "&type=" + escape(type) + "&last_id=" + escape(startID) + "&timecode=" + escape(timecode);

	// Open a connection to the server
	xmlHttp.open("GET", url, true);

	// Send the request
	xmlHttp.send(null);
}

/*	Set the overlay graphic to blank out the background
	so it looks like the status indicator is set to the
	right percentage.	*/
function setPercentage(percentage) {
	/*	We're subtracting (percentage * 3) from 300 because the div
		width is 300 pixels.  If it was 400 wide we'd do 
		400 - (percentage*4).  	*/
	/*	newWidth = 300 - (percentage * 3) + 'px';
	document.getElementById('whiteOverlay').style.width = newWidth;*/
	document.getElementById('results').innerHTML = percentage;
}

function updateProgress(type) {
	// updates a page's progress.
	if (xmlHttp.readyState != 4) {
		var url = "/get_progress.php?type=" + escape(type);
		progress.open("GET", url, false);
		progress.send(null);
		var response = progress.responseText + " (" + (100*roundNumber(eval(progress.responseText), 4)) + "%)";

		if (response != "No such type!") {
			setPercentage(response);
		}
	}
}

function updatePage(interval) {
	if (xmlHttp.readyState == 4) {
		var response = xmlHttp.responseText;
		document.getElementById("results").innerHTML = response;
		window.clearInterval(interval);
		document.getElementById("updateButton").disabled = false;
	}
}