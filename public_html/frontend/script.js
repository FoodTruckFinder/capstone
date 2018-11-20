
function initMap() {
	//VARIABLE DELCARATION ONLY BELOW
	var map = new google.maps.Map(document.getElementById('map'), {

		//DO NOT CHANGE ZOOM OR LAT LONG WITHOUT CONSULTING WITH TEAM
		center: {lat: 35.083, lng: -106.638},
		zoom: 15
		mapTypeControl: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,

			//zoomControl: boolean,
			//mapTypeControl: boolean,
			//scaleControl: boolean,
			//streetViewControl: boolean,
			//rotateControl: boolean,
			//fullscreenControl: boolean

		}
	});
}