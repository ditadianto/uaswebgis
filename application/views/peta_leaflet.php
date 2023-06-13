<div class="content"> 
 <div id="map" style="width: 100%; height: 530px; color:black;"></div> 
</div> 
<script> 

var provin = new L.LayerGroup();

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
        'Provinsi Jawa Barat' : provin
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
 if ( Kode > 21 ) fillColor = "#006837"; 
 else if (Kode>20) fillColor="#fec44f"
 else if (Kode>19) fillColor="#c2e699"
 else if (Kode>18) fillColor="#fee0d2"
 else if (Kode>17) fillColor="#756bb1"
 else if (Kode>16) fillColor="#8c510a"
 else if (Kode>15) fillColor="#01665e"
 else if (Kode>14) fillColor="#e41a1c"
 else if (Kode>13) fillColor="#636363"
 else if (Kode>12) fillColor= "#762a83"
 else if (Kode>11) fillColor="#1b7837"
 else if (Kode>10) fillColor="#d53e4f"
 else if (Kode>9) fillColor="#67001f"
 else if (Kode>8) fillColor="#c994c7"
 else if (Kode>7) fillColor="#fdbb84"
 else if (Kode>6) fillColor="#dd1c77"
 else if (Kode>5) fillColor="#3182bd"
 else if ( Kode > 4 ) fillColor ="#f03b20"
 else if ( Kode > 3 ) fillColor = "#31a354";
 else if ( Kode > 2 ) fillColor = "#78c679";
 else if ( Kode > 1 ) fillColor = "#c2e699";
 else if ( Kode > 0 ) fillColor = "#ffffcc";
 else fillColor = "#f7f7f7"; // no data
 return { color: "#999", weight: 1, fillColor: fillColor, fillOpacity: .6 };
 },
 onEachFeature: function( feature, layer ){
 layer.bindPopup(feature.properties.WADMKK)
 }
 }).addTo(provin);
 });


</script>
