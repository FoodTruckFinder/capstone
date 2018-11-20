//This div will display Google map
const mapArea = document.getElementById('map');

//This button will set everything into motion when clicked
const actionBtn = document.getElementById('showMe');

//This will display all the available addresses returned by Google's Geocode Api
const locationsAvailable = document.getElementById('locationList');

//Let's bring in our API_KEY
const __KEY = 'YOUR_API_KEY';

//Let's declare our Gmap and Gmarker variables that will hold the Map and Marker Objects later on
let Gmap;
let Gmarker;

//Now we listen for a click event on our button
actionBtn.addEventListener('click', e => {
	// hide the button
	actionBtn.style.display = "none";
	// call Materialize toast to update user
	M.toast({ html: 'fetching your current location', classes: 'rounded' });
	// get the user's position
	getLocation();
});

getLocation = () => {
	// check if user's browser supports Navigator.geolocation
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(displayLocation, showError, options);
	} else {
		M.toast({ html: "Sorry, your browser does not support this feature... Please Update your Browser to enjoy it", classes: "rounded" });
	}
}
// Displays the different error messages
showError = (error) => {
	mapArea.style.display = "block"
	switch (error.code) {
		case error.PERMISSION_DENIED:
			mapArea.innerHTML = "You denied the request for your location."
			break;
		case error.POSITION_UNAVAILABLE:
			mapArea.innerHTML = "Your Location information is unavailable."
			break;
		case error.TIMEOUT:
			mapArea.innerHTML = "Your request timed out. Please try again"
			break;
		case error.UNKNOWN_ERROR:
			mapArea.innerHTML = "An unknown error occurred please try again after some time."
			break;
	}
}
//Makes sure location accuracy is high
const options = {
	enableHighAccuracy: true
}
displayLocation = (position) => {
	const lat = position.coords.latitude;
	const lng = position.coords.longitude;
	const latlng = {lat, lng}
	showMap(latlng);
	createMarker(latlng);
	mapArea.style.display = "block";
}
showMap = (latlng) => {
	let mapOptions = {
		center: latlng,
		zoom: 17
	};
	Gmap = new google.maps.Map(mapArea, mapOptions);
}

createMarker = (latlng) => {
	let markerOptions = {
		position: latlng,
		map: Gmap,
		animation: google.maps.Animation.BOUNCE,
		clickable: true
	};
	Gmarker = new google.maps.Marker(markerOptions);
};

const breweryMarkers = [

	//Marble Brewery Downtown
	{
		coords: {lat: 35.0928, lng: -106.6467},
		content: '<h1>Marble Brewery Downtown</h1><br/><a href="http://www.marblebrewery.com/loc/abq-downtown/">Website</a>'
		/*iconImage: 'https://www.google.com/url?sa=i&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjin5OZ8L3eAhVKVK0KHX7BCqMQjRx6BAgBEAU&url=http%3A%2F%2Fwww.marblebrewery.com%2Fon-tap-abq-westside%2F&psig=AOvVaw1uqieu-r7qHGHRt7uZcbfE&ust=1541528734340961' */
	},

	{ //Marble NE Heights
		coords: {lat: 35.130449, lng: -106.530022},
		content: '<h1>Marble NE Heights</h1><br/><a href="http://www.marblebrewery.com/loc/ne-heights/">Website</a>'
	},

	{ //Marble West Side
		coords: {lat: 35.216457, lng: -106.698214},
		content: '<h1>Marble West Side</h1><br/><a href="http://www.marblebrewery.com/loc/abq-westside/">Website</a>'
	},
	{ //La Cumbre West Side
		coords: {lat: 35.146298, lng: -106.688148},
		content: '<h1>La Cumbre West Side</h1><br/><a href="http://www.lacumbrebrewing.com">Website</a>'
	},
	{ //La Cumbre Main Industrial District
		coords: {lat: 35.118007, lng: -106.614151},
		content: '<h1>La Cumbre Main Industrial District</h1><br/><a href="http://www.lacumbrebrewing.com/">Website</a>'
	},
	{ //Bow and Arrow Brewing
		coords: {lat: 35.106097, lng: -106.650892},
		content: '<h1>Bow and Arrow Brewing</h1><br/><a href="http://www.bowandarrowbrewing.com/">Website</a>'
	},
	{ //Tractor Wells Park
		coords: {lat: 35.102533, lng: -106.647781},
		content: '<h1>Tractor Wells Park</h1><br/><a href="https://getplowed.com/wells-park/">Website</a>'
	},
	{ //Tractor Nob Hill
		coords: {lat: 35.079654, lng: -106.606705},
		content: '<h1>Tractor Nob Hill</h1><br/><a href="https://getplowed.com/nob-hill/">Website</a>'
	},
	{ //High and Dry Brewing
		coords: {lat: 35.086723, lng: -106.594554},
		content: '<h1>High and Dry Brewing</h1><br/><a href="http://highanddrybrewing.com/">Website</a>'
	},
	{ //Side Track Brewing
		coords: {lat: 35.080986, lng: -106.650044},
		content: '<h1>Side Track Brewing</h1><br/><a href="http://sidetrackbrewing.net/">Website</a>'
	}
];

for(let i = 0; i < breweryMarkers.length; i++) {
	addMarker(breweryMarkers[i]);
}


function addMarker(props) {
	let marker = new google.maps.Marker({
		position: props.coords,
		map: mapArea,

	});

	// Check for customicon
	if(props.iconImage) {
		// Set icon image
		marker.setIcon(props.iconImage);
	}

	if(props.content) {
		var infoWindow = new google.maps.InfoWindow({
			content: props.content
		});

		marker.addListener('click', function() {
			infoWindow.open(map, marker);
		});
		marker.addListener('mouseout', function() {
			infoWindow.close(map, marker);

		});

	}
}

