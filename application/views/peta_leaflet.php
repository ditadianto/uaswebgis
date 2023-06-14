<div class="content"> 
 <div id="map" style="width: 100%; height: 530px; color:black;"></div> 
</div> 
<script> 

var provin = new L.LayerGroup();
var hutan = new L.LayerGroup();

var map = L.map('map', { 
 center: [-1.7912604466772375, 116.42311966554416], 
 zoom: 5, 
 zoomControl: false,
 layers:[] 
}); 

var GoogleSatelliteHybrid= L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { 
maxZoom: 22, 
attribution: 'Latihan Web GIS' 
}).addTo(map);

var OpenStreetMap_DE = L.tileLayer('https://{s}.tile.openstreetmap.de/{z}/{x}/{y}.png', {
	maxZoom: 18,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

var Stamen_Terrain = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.{ext}', {
	attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	subdomains: 'abcd',
	minZoom: 0,
	maxZoom: 18,
	ext: 'png'
});

var baseLayers = {
    'Google Satellite Hybrid': GoogleSatelliteHybrid,
    'Open Street Map' : OpenStreetMap_DE,
    'Terrain' : Stamen_Terrain
}; 

var groupedOverlays = {
    "Peta Dasar" : {
        'Provinsi Jawa Barat' : provin,
        'Klasifikasi Hutan' : hutan
    }
};

var overlayLayers = {} 

L.control.groupedLayers(baseLayers, groupedOverlays).addTo(map);

var 
osmUrl='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'; 
var osmAttrib='Map data &copy; OpenStreetMap contributors'; 
var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib }); 
var rect1 = {color: "#ff1100", weight: 3}; 
var rect2 = {color: "#0000AA", weight: 1, opacity:0, fillOpacity:0}; 
var miniMap = new L.Control.MiniMap(osm2, {toggleDisplay: true, position : "bottomright", 
aimingRectOptions : rect1, shadowRectOptions: rect2}).addTo(map);

L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);

/* GPS enabled geolocation control set to follow the user's location */
var locateControl = L.control.locate({ 
position: "topleft", 
drawCircle: true, 
follow: true, 
setView: true, 
keepCurrentZoomLevel: true, 
markerStyle: { 
weight: 1, 
opacity: 0.8, 
fillOpacity: 0.8
}, 
circleStyle: { 
weight: 1, 
clickable: false
}, 
icon: "fa fa-location-arrow", 
metric: false, 
strings: { 
title: "My location", 
popup: "You are within {distance} {unit} from this point", 
outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
}, 
locateOptions: { 
maxZoom: 18, 
watch: true, 
enableHighAccuracy: true, 
maximumAge: 10000, 
timeout: 10000
} 
}).addTo(map);

var zoom_bar = new L.Control.ZoomBar({position: 'topleft'}).addTo(map);

L.control.coordinates({ 
position:"bottomleft", 
decimals:2, 
decimalSeperator:",", 
labelTemplateLat:"Latitude: {y}", 
labelTemplateLng:"Longitude: {x}" 
}).addTo(map);
/* scala */
L.control.scale({metric: true, position: "bottomleft"}).addTo(map);

var north = L.control({position: "bottomleft"}); 
north.onAdd = function(map) { 
var div = L.DomUtil.create("div", "info legend"); 
div.innerHTML = '<img src="<?=base_url()?>assets/arah-mata-angin.png"style=width:200px;>'; 
return div; } 
north.addTo(map);

$.getJSON("<?=base_url()?>/assets/jabar.geojson",function(Kode){
 L.geoJson( Kode, {
 style: function(feature){
 var fillColor,
 Kode = feature.properties.Kode;
 if ( Kode < 2 ) fillColor = "#ffffff"; 
 else if ( Kode > 0 ) fillColor = "#ffffff";
 else fillColor = "#f7f7f7"; // no data
 return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
 },
 onEachFeature: function( feature, layer ){
 layer.bindPopup(feature.properties.WADMKK)
 }
 }).addTo(provin);
 });

 $.getJSON("<?=base_url()?>/assets/hutan.geojson",function(kode){
 L.geoJson( kode, {
 style: function(feature){
 var fillColor,
 kode = feature.properties.kode;
 if ( kode > 5 ) fillColor = "#006837"; 
 else if ( kode > 4 ) fillColor ="#01665e"
 else if ( kode > 3 ) fillColor = "#00ffff";
 else if ( kode > 2 ) fillColor = "#ff7f00";
 else if ( kode > 1 ) fillColor = "#ffff00";
 else if ( kode > 0 ) fillColor = "#00ff00";
 else fillColor = "#f7f7f7"; // no data
 return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
 },
 onEachFeature: function( feature, layer ){
 layer.bindPopup(feature.properties.Name)
 }
 }).addTo(hutan);
 });

</script>
