$(document).ready(function(){

	//display weather from OpenWeather API using the coordinate
 	$.getJSON("http://api.openweathermap.org/data/2.5/weather?lat=53.36652&lon=-2.29855&APPID=cf105b5c444c4117907c6b3fa1acf602&units=metric",
	function(weathers) {
		var w = $("#weather");

		//display unix time in a human readable format
		//using date.format.js from jacwright
		var n_sunrise = new Date(weathers.sys.sunrise * 1000);
		var sunrise = n_sunrise.format('H:i');
		var n_sunset = new Date(weathers.sys.sunset * 1000);
		var sunset = n_sunset.format('H:i');

		w.append("<h2>" + weathers.name + ", " + weathers.sys.country + "</h2>");
		w.append("<div class='weather-mini'><img src='http://openweathermap.org/img/w/" + weathers.weather[0].icon + ".png' alt='weather icon' id='weather-icon' ><div id='temperature'>" + weathers.main.temp + " °C</div><p>" + weathers.weather[0].main + " :: " + weathers.weather[0].description + "</p></div>");
		w.append("<div class='weather-mini'><p>Humidity :: " + weathers.main.humidity + "%</p></div>");
		w.append("<div class='weather-mini'><p>Wind :: " + weathers.wind.speed + " m/s</p></div>");
		w.append("<div class='weather-mini'><p>Sunrise :: " + sunrise + "</p></div>");
		w.append("<div class='weather-mini'><p>Sunset :: " + sunset + "</p></div>");
	});

});