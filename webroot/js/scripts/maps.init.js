jQuery(function() {
	"use strict";

	function initGoogleMaps() {
		
		// gmap - 1

		google.maps.event.addDomListener(window, 'load', function() {
			new google.maps.Map(document.getElementById("gmap01"), {
				zoom: 3,
				center: new google.maps.LatLng(40.74, -74.18)
			});
		});
		

		// gmap - 2 (with marker)
		function mapMarker() {
			var gmap02 = new google.maps.Map(document.getElementById("gmap02"), {
				zoom: 4,
				center: new google.maps.LatLng(-33, 151)
			});
			var marker = new google.maps.Marker({
				map: gmap02,
				icon: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
				animation: google.maps.Animation.DROP,
				title: "You are here",
				position: new google.maps.LatLng(-33.890542, 151.274856)
			})
		}
		google.maps.event.addDomListener(window, 'load', mapMarker);


		// gmap - 3 (streetview)
		function mapStreetView() {
			var streetView = new google.maps.StreetViewPanorama(document.querySelector('#street-view'), {
				position: new google.maps.LatLng(40.688738,-74.043871)
			});
		}
		google.maps.event.addDomListener(window, 'load', mapStreetView);

		// gmap - 4 (shapes)
		function mapShapesDraw() {
			var gmap04 = new google.maps.Map(document.getElementById("gmap04"), {
				zoom: 11,
				center: new google.maps.LatLng(40.74, -74.18)
			});
			// draw polyline
			var polyline = new google.maps.Polyline({
				path: [
					new google.maps.LatLng(40.74,-74.18),
					new google.maps.LatLng(40.64,-74.10),
					new google.maps.LatLng(40.54,-74.05),
					new google.maps.LatLng(40.44,-74)
				],
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});
			polyline.setMap(gmap04);

			// draw polygon
			var polygon = new google.maps.Polygon({
				path: [
					new google.maps.LatLng(40.74,-74.18),
					new google.maps.LatLng(40.64,-74.18),
					new google.maps.LatLng(40.84,-74.08),
					new google.maps.LatLng(40.74,-74.18)
				],
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2
			});
			polygon.setMap(gmap04);

			// draw circle
			var circle = new google.maps.Circle({
				strokeColor: '#FF0000',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				center: new google.maps.LatLng(40.70,-74.14),
				radius: 4000,
				editable: true
			});
			circle.setMap(gmap04);
		}
		google.maps.event.addDomListener(window, 'load', mapShapesDraw);
		
		

		
	}


	function _init() {
		initGoogleMaps();
	}
	_init();

})