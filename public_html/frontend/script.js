var map;
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		//DO NOT CHANGE ZOOM OR LAT LONG WITHOUT CONSULTING WITH TEAM
		center: {lat: 35.083, lng: -106.638},

		zoom: 15
	});
}