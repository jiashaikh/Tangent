import axios from 'axios';

var population = document.getElementById("population");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(geocodeLatLng);
    } else {
        population.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function geocodeLatLng(position) {
    var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
		var code = '';

                loopFormattedAddress:
                for(var i = 0; i < results[0].formatted_address.length; i++) {
                    loopTypes:
                    for (var j = 0; j < results[0].formatted_address[i].types; j++) {
                        if (results[0].formatted_address[i].types[j] === 'country') {
			    code = results[0].formatted_address[i].short_name;

                            break loopFormattedAddress;
                        }
                    }
                }

                getPopulation(code);		
            } else {
                population.innerHTML = "No results found";
            }
        } else {
            // TO DO - log the error instead
            population.innerHTML = "Geocoder failed due to: " + status;
        }
    });
}

function getPopulation(code) {
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.get('/ajax/countrypopulation/getcountry?code=' + code)
                .then(response => {
                    const responseData = response.data;
                   
                    if (responseData.hasOwnProperty('population')) {
                   	if (responseData['population']) {
			    population.innerHTML = "The population of " + county + " is " + responseData['population'];	
			} else {
			    population.innerHtml = "Population details are un-available";
                        }
		    } else if (responseData.hasOwnProperty('error')) {
			// TO DO - log the error instead
            		population.innerHTML = "Error";	
		    }
                })	
}
