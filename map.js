//set up global variables to be accessed by tweet.js
var map;
var markerArray = [];
var myLatLng;

$(document).ready(
	function initialize() {

		//set up default coordinates and title
	 	myLatLng = {lat: 53.36652, lng: -2.29855};
		var placetitle = "Coast City Sports Centre";

	 	var mapProp = {
		 	center:new google.maps.LatLng(53.36652,-2.29855),
		 	zoom:15,
		 	mapTypeId:google.maps.MapTypeId.SATELLITE,
		 	zoomControl: true,
			mapTypeControl: true,
			scaleControl: true,
			streetViewControl: true,
			rotateControl: true,
			fullscreenControl: true
	 	};

	 	/*
		var polygoncood = [
	 		{lat: 53.36630, lng: -2.29840},
	 		{lat: 53.36631, lng: -2.29842},
	 		{lat: 53.36632, lng: -2.29857},
	 		{lat: 53.36640, lng: -2.29855},
	 		{lat: 53.36660, lng: -2.29830}
	 	];

	 	var polygon = new google.maps.Polygon({
	 		paths: polygoncood,
	 		strokeColor: '#009955',
	 		strokeOpacity: 0.8,
	 		strokeWeight: 1,
	 		fillColor: '#009955',
	 		fillOpacity: 0.4
	 	});
		*/

		//infowindow
	 	var info = 	'<p><b>Coast City Sports Centre</b> offers various types of facilities like ' +
      				'swimming pool, gym, racket court for tennis, squash and etc. '+
      				'Join us today!';

      	var infoWindow = new google.maps.InfoWindow({
      		content: info
      	});

      	//add a new map
	 	map = new google.maps.Map(document.getElementById("googleMap") ,mapProp);

	 	//add a new marker using default location and title
	 	addMarker(myLatLng, placetitle);

  		//polygon.setMap(map);
		//marker.setMap(map);
		//add info window to default marker
		markerArray[0].addListener('click', function() {
			infoWindow.open(map, markerArray[0]);
		});

	//add an eventlistener to the dom to call the initialize function when the window is loaded
	//google.maps.event.addDomListener(window, 'load', initialize);
	}
);

//adds a new marker to the map
function addMarker(location, locationTitle) {
	var marker = new google.maps.Marker({
		position: location,
		map: map,
		draggable: true,
		animation: google.maps.Animation.DROP,
		title: locationTitle
	});
	//adds marker to marker array
	markerArray.push(marker);
}

//delete 2nd item in the marker array
//as requested in the assignment, only 2 markers are shown in the map
//as the first marker is the default marker of CSCC location, while the second is the added marker via tweet location
//hence the 2nd item of the array will always be deleted
function deleteMarker() {
	markerArray.splice(1, 1);
}

//set the marker on the map
function setMarker(map) {
	for (var i = 0; i < markerArray.length; i++) {
		markerArray[i].setMap(map);
	}
}

//set the map bound according to the marker array
//so all markers are shown on the map
//if there's only 1 marker, the map will be zoomed and focused on the marker
function setBounds(markerArray) {
	if (markerArray.length > 1) {
		var bounds = new google.maps.LatLngBounds();
		for (var i=0; i < markerArray.length; i++) {
			bounds.extend(markerArray[i].getPosition());
		}
		map.fitBounds(bounds);
	} else {
		map.setZoom(15);
		map.panTo(myLatLng);
	}
}
