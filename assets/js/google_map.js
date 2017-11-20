var map = null;
var marker = null;
var posset = 0;
var iw;
var drag=false;

function xz()
{
	var lat = $.('#lat').val() || 1.274309;
	var lng = $.('#lat').val() || 32.747070;
	ll = new google.maps.LatLng(lat, lng);
	computepos(ll);
	zoom=7;
	var mO = {
		scaleControl:true,
		zoom:zoom,
		zoomControl:true,
		zoomControlOptions: {style:google.maps.ZoomControlStyle.LARGE},
		center: ll,
		disableDoubleClickZoom:true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("gmap"), mO);
	map.setTilt(0);
	map.panTo(ll);
	marker = new google.maps.Marker({position:ll,map:map,draggable:true,title:'Marker is Draggable'});   

	google.maps.event.addListener(marker, 'click', function(mll) {
		var html= "<div style='color:#000;background-color:#fff;padding:5px;width:150px;'><p>Latitude - Longitude:<br />" + String(mll.latLng.toUrlValue()) + "<br /><br />Lat: " + mll.latLng.lat() +  "&#176; <br />Long: " + mll.latLng.lng() +  "&#176; </p></div>";
		iw = new google.maps.InfoWindow({content:html});
		iw.open(map,marker);
	});
	google.maps.event.addListener(marker, 'dragstart', function() {if (iw){iw.close();}});

	google.maps.event.addListener(marker, 'dragend', function(event) {
		posset = 1;
		if (map.getZoom() < 10){map.setZoom(10);}
		map.setCenter(event.latLng);
		computepos(event.latLng);
		drag=true;
		setTimeout(function(){drag=false;},250);
	});
}

function computepos (point)
{
	$("#lat").val(point.lat().toFixed(6));
	$("#lng").val(point.lng().toFixed(6));
}

function showAddress(address)
{
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': address}, function(results, status) {
	 if (status == google.maps.GeocoderStatus.OK) {
	  map.setCenter(results[0].geometry.location);
	  map.setMapTypeId(google.maps.MapTypeId.HYBRID);
	  if (map.getZoom() < 16){map.setZoom(16);}else{}
	  marker.setPosition(results[0].geometry.location);
	  posset = 1;
	  computepos(results[0].geometry.location);
	 } else {
	  alert("Geocode was not successful for the following reason: " + status);
	 }
	});
}
jQuery(document).ready(function($)
{
	   xz();
});