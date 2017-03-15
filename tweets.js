//define lati and long as global variable
//to be accessed by maps.js
var lati;
var long;

$(document).ready(function() {

	//display user tweets
	$.getJSON("call_twitter_API.php",
		function(tweetdata) {
  			var tl = $("#tweet-list");
			$.each(tweetdata, function(i,tweet) {
				tl.append("<li>" + tweet.text + " created " + relTime(tweet.created_at) + "</li>");
			});
		});

	//display tweets related to #CM0677
	$.getJSON("search_API.php",
		function(searchdata) {
  			var p = $("#search-list");
			$.each(searchdata.statuses, function(i, search) {
				var text = "<ul class='search-tweet-list'><li>";

				//splitting retrieved time string to Day Month Year
				var created_time = search.created_at;
				var created_date_array = created_time.split(" ");
				var created_date = created_date_array[2] + " " + created_date_array[1] + " " + created_date_array[5];

				text += "<strong>";
				text += search.user.screen_name;
				text += "</strong> on ";
				text += created_date;
				text += "<br /><em>";
				text += search.text;
				text += "</em></li>";

				//if geolocation is not null, show the information in a hidden div
  				if (search.geo != null) {
  					text += "<div class='secretlocationGeo'><p>tweeted from "
  					text += search.place.name;
  					text += ", ";
  					text += search.place.country;
  					text += ", by ";
  					text += search.user.name;
  					text += ".</p>";
  					//show geolocation coordinates in a hidden input field to be retrieved later to lati and long
  					text += "<input class='locationcood' type='hidden' name='";
  					text += search.user.name;
  					text += "' value='";
  					text += search.geo.coordinates;
  					text += "' />";
  					text += "</div>";
  				//else if user has a default location, show the information in a hidden div
  				} else if (search.user.location != null && search.user.location != "") {
  					text += "<div class='secretlocationLoc'><p>Tweeted by "
  					text += search.user.name;
  					text += " based at ";
  					text += search.user.location;
  					text += ".</p></div>";
  				}
  				text += "</ul>";
  				p.append(text);
    		});

    		//hide both divs
    		$('.secretlocationGeo').hide();
    		$('.secretlocationLoc').hide();

    		//for each mouseover on the search tweet list,
    		//show the hidden location div
			$('.search-tweet-list').each(function() {
				$(this).mouseover(function() {
					var hiddenLocation = $(this).find('div');
					if (hiddenLocation.attr("class") == 'secretlocationGeo') {
						//retrieve the coordinate of the tweet from hidden input
						var input = hiddenLocation.find('input');
						var coordinates = input.attr("value");
						var username = input.attr("name");

						//split the coordinates to latitude and longitude
						var splitstring = coordinates.split(",");
						lati = parseFloat(splitstring[0]);
						long = parseFloat(splitstring[1]);
						var myLatLng2 = {lat: lati, lng: long};

						//call the maps.js to add a google marker
						addMarker(myLatLng2, username);
						//set the map so it shows all markers from the marker array
						//including CSCC and the tweet user location
						setBounds(markerArray);
					}
					//show the hidden div
					hiddenLocation.show(10);
				})

				//on mouseout, hide the div
				$(this).mouseout(function() {
					var hiddenLocation = $(this).find('div');

					if (hiddenLocation.attr("class") == 'secretlocationGeo') {
						//remove all markers from map, delete from marker array
						//set up marker again from new array list and reset map bound
						setMarker(null);
						deleteMarker();
						setMarker(map);
						setBounds(markerArray);
					}
					//hide the div
					hiddenLocation.hide();
				})
			})
		});

	//change the date time to how long ago
	function relTime(time_value) {
        time_value = time_value.replace(/(\+[0-9]{4}\s)/ig,"");

        var parsed_date = Date.parse(time_value);
        var relative_to =(arguments.length > 1) ? arguments[1] : new Date();
        var timeago = parseInt((relative_to.getTime() - parsed_date) / 1000);

        if (timeago < 60) return 'less than a minute ago';
        else if(timeago < 120) return 'about a minute ago';
        else if(timeago < (45*60)) return (parseInt(timeago / 60)).toString() + 'minutes ago';
        else if(timeago < (90*60)) return 'about an hour ago';
        else if(timeago < (24*60*60)) return 'about ' + (parseInt(timeago / 3600)).toString() + ' hours ago';
        else if(timeago < (48*60*60)) return '1 day ago';
        else return (parseInt(timeago / 86400)).toString() + ' days ago';
    }
})

//refresh function to refresh the tweet, similar as above
function refresh() {
	$.getJSON("search_API.php",
		function(searchdata) {
  			var p = $("#search-list");
  			p.empty();
			$.each(searchdata.statuses, function(i, search) {
				var text = "<ul class='search-tweet-list'><li>";
				var created_time = search.created_at;
				var created_date_array = created_time.split(" ");
				var created_date = created_date_array[2] + " " + created_date_array[1] + " " + created_date_array[5];

				text += "<strong>";
				text += search.user.screen_name;
				text += "</strong> on ";
				text += created_date;
				text += "<br /><em>";
				text += search.text;
				text += "</em></li>";

  				if (search.geo != null) {
  					text += "<div class='secretlocationGeo'><p>tweeted from "
  					text += search.place.name;
  					text += ", ";
  					text += search.place.country;
  					text += ", by ";
  					text += search.user.name;
  					text += ".</p>";
  					text += "<input class='locationcood' type='hidden' name='";
  					text += search.user.name;
  					text += "' value='";
  					text += search.geo.coordinates;
  					text += "' />";
  					text += "</div>";
  				} else if (search.user.location != null && search.user.location != "") {
  					text += "<div class='secretlocationLoc'><p>Tweeted by "
  					text += search.user.name;
  					text += " based at ";
  					text += search.user.location;
  					text += ".</p></div>";
  				}
  				text += "</ul>";
  				p.append(text);
    		});
    		$('.secretlocationGeo').hide();
    		$('.secretlocationLoc').hide();

			$('.search-tweet-list').each(function() {
				$(this).mouseover(function() {
					var hiddenLocation = $(this).find('div');
					if (hiddenLocation.attr("class") == 'secretlocationGeo') {
						var input = hiddenLocation.find('input');
						var coordinates = input.attr("value");
						var username = input.attr("name");

						var splitstring = coordinates.split(",");
						lati = parseFloat(splitstring[0]);
						long = parseFloat(splitstring[1]);
						var myLatLng2 = {lat: lati, lng: long};

						addMarker(myLatLng2, username);
						setBounds(markerArray);
					}
					hiddenLocation.show(10);
				})

				$(this).mouseout(function() {
					var hiddenLocation = $(this).find('div');

					if (hiddenLocation.attr("class") == 'secretlocationGeo') {
						setMarker(null);
						deleteMarker();
						setMarker(map);
						setBounds(markerArray);
					}
					hiddenLocation.hide();
				})
			})
		});
}



