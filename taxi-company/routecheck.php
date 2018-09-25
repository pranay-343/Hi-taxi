<?php
include '../include/define.php';
verifyLogin();
include '../include/head.php';
$zoneId = $_SESSION['uid'];
$query = mysql_query("select z.* from `zone_area` z Left Join `login` l ON z.allot_to=l.added_by where 1 and l.id='" . $zoneId . "'");
$response = mysql_fetch_assoc($query);
$zone_title = base64_decode($response['zone_title']);
$zone_description = base64_decode($response['zone_description']);
$qryLog = mysql_query("select * from `login` where 1 and id='" . $zoneId . "'");
$result = mysql_fetch_assoc($qryLog);
?>
<style>
    .pw_prompt {
        position:fixed;
        left: 50%;
        top:50%;
        margin-left:-100px;
        padding:15px;
        width:20%;
        border:1px solid black;
        background: #FFD200;
    }
    .pw_prompt label {
        display:block; 
        margin-bottom:5px;
    }
    .pw_prompt input {
        margin-bottom:10px;
    }
</style>
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
        <div class="container pal0">
            <div class="row">
                <div class="col-sm-3 pa10">
                    <?php include '../include/taxi-sidebar.php'; ?>

                </div>
                <div class="col-sm-9">
                    <div class="container">
                        <h1 class="txt-style-1">Administrador de la zona</h1>
                        <div class="c-acc-status mgr">
                            <h2 class="txt-style-3">Administrador de Zona Ver</h2>
                        </div>
                        <div id="errorMessage"></div>
                        <!-- Main component for a primary marketing message or call to action -->
                        <div class="jumbotron">
                            <div class="col-sm-4" style="float:right">
                                <p>Administrador de la zona : <b><?php echo $result['name']; ?></b></p>
                            </div>

                            <p>Título de la Zona : <strong><?php echo $zone_title; ?></p>
                            <div class="row">
                                <p>Descripción : <strong><?php echo $zone_description; ?></strong></p>
                                <div class="index_table" id="checkboxArea">
                                </div>
                                <input type="text" id="routeFrom" name="routeFrom" value="700 n tryon st, charlotte nc" />
                                <label for="routeFrom">de</label><br />
                                <input type="text" id="routeTo" name="routeTo" value="Huntersville, NC" />
                                <label for="routeTo">entonces</label><br />
                                <select id="routeMode" name="routeMode">
                                    <option value="DRIVING">Driving</option>
                                    <option value="WALKING">Walking</option>
                                    <option value="BICYCLING">Bicycling</option>
                                    <option value="TRANSIT">Transit</option>
                                </select>
                                <label for="routeMode">Mode</label><br />
                                <div class="textcenter">
                                    <button id="routeGo">Route</button>
                                    <button id="routeClear">Clear Route</button>
                                </div>
                                <div id="directions"></div>



                            </div>
                            <br/><br/>
                            <div class="row">
                                <div class="popin">
                                    <div id="map"></div>
                                </div>
                            </div>          
                        </div>
                    </div> <!-- /container -->
                    <!--END -->
                </div>
                <?php
                include '../include/footer.php';
                include '../include/map-script.php';
                ?>
<script type="text/javascript" src="https://hpneo.github.io/gmaps/prettify/prettify.js"></script>
<script>
    $(document).ready(function () {
// auto serach query fro all source and destination
        function autoSearch_routeTo() {
        new google.maps.places.Autocomplete(
            (document.getElementById('routeTo')), {
                componentRestrictions: {country: "mx"},
        types: ['geocode']
        });
        new google.maps.places.Autocomplete(
       (document.getElementById('routeFrom')), {
           componentRestrictions: {country: "mx"},
        types: ['geocode']
        });
    }
    autoSearch_routeTo();
// end auto serach query fro all source and destination                
    var geocoder = new google.maps.Geocoder();
// Code for zone area bound
 var polygon='';
 var linee = '';
 var circles = '';
    var path = [];
    var objectsBounds = new google.maps.LatLngBounds();
    var tmp_coords = [];
    $.post('getData.php', {mode: '<?php echo base64_encode('getcordeinatesDetails'); ?>', a: '<?php echo $_SESSION['uid']; ?>'}, function (response) {
    var obj = jQuery.parseJSON(response);
    for (var i = 0; i < obj['dataa']['zone_name'].length; i++)
        {
            if ($.trim(obj['dataa']['zone_name'][i].zone_name) == 0 || obj['dataa']['zone_name'][i].zone_name == '0')
            {
            }
            else
            {
                var contentt = '<div class="checkbox"><label><input type="checkbox" name="chbx_' + obj['dataa']['zone_name'][i].zone_name + '" id="chbx_' + obj['dataa']['zone_name'][i].zone_name + '" checked="checked">' + obj['dataa']['zone_name'][i].zone_name + '</label></div>';
                $('#checkboxArea').append(contentt);
            }
        }
        // ---- circle------			
				if (obj['dataa']['circle'] === 'undefined' || obj['dataa']['circle'] === undefined)
				{
				}
				else
				{
				var circle = obj['dataa']['circle'];
				for (var i = 0; i < circle.length; i++)
				{
					var nj = circle[i].cordinatess;
					var p = '';
					nj = nj.replace(/[(]/g, "");
					nj = nj.replace(/[)]/g, "");
					nj = nj.substring(0, nj.length - 1);
					var p = nj.split(',');
                                        circles = map.drawCircle({
					lat: p[0].trim(),
					lng: p[1].trim(),
					radius: parseInt(p[2].trim() * 10),
					fillOpacity: 0.2
				});
					var cordinated = circle[i].cordinatess;
					var coords = cordinated;
					var coords = cordinated;
					tmp_coords = getDataFromArray(coords);
					var getbounds = loadCircle(tmp_coords[0], tmp_coords[1], parseInt(tmp_coords[2]), circle[i].cordinate_title);
					objectsBounds.union(getbounds);
				}
				map.addMarker({
                                    lat: p[0].trim(),
                                    lng: p[1].trim(),
                                    draggable: true,
                                    fences: [circles],
                                    outside: function (m, f) {
                                    	alert('This marker has been moved outside of its cicle fence');
                                    }
                                    });
				}
				//--  - --line  ----------
				if (obj['dataa']['line'] === 'undefined' || obj['dataa']['line'] === undefined)
				{
				}
				else
				{
				var line = obj['dataa']['line'];
				for (var i = 0; i < line.length; i++)
				{
					var nj = line[i].cordinatess;
					nj = nj.replace(/[(]/g, "");
					nj = nj.replace(/[)]/g, ",");
					nj = nj.substring(0, nj.length - 1);
					var p = nj.split(',,');
				for (var n = 0; n < p.length; n++)
					{
						var arra = p[n].split(',');
						latlng = new google.maps.LatLng(arra[0], arra[1]);
						path.push(latlng);
					}
					var cordinated = line[i].cordinatess;
					var coords = cordinated;
					tmp_coords = getPathFromCoordsArray(coords);
					var getbounds = loadPolyline(tmp_coords, line[i].cordinate_title);
					objectsBounds.union(getbounds);
				}
                               
			 linee = map.drawPolygon({
				paths: path,
				strokeColor: '#BBD8E9',
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: '#BBD8E9',
				fillOpacity: 0.6
				});
				map.addMarker({
					lat: 24.126701958681682,
					lng: -102.85400390625,
					draggable: true,
					fences: [linee],
					outside: function (m, f) {
					alert('This marker has been moved outside of its fence');
					}
				});
			}
			// ----------polygon------	
			if (obj['dataa']['polygon'] === 'undefined' || obj['dataa']['polygon'] === undefined)
			{
			}
			else
			{ 
			polygon = obj['dataa']['polygon'];
			for (var i = 0; i < polygon.length; i++)
			{
				var nj = polygon[i].cordinatess;
				nj = nj.replace(/[(]/g, "");
				nj = nj.replace(/[)]/g, ",");
				nj = nj.substring(0, nj.length - 1);
				var p = nj.split(',,');
				for (var n = 0; n < p.length; n++)
				{
					var arra = p[n].split(',');
					latlng = new google.maps.LatLng(arra[0], arra[1]);
					path.push(latlng);
				}
				var cordinated = polygon[i].cordinatess;
				var coords = cordinated;
				tmp_coords = getPathFromCoordsArray(coords);
				var getbounds = loadPolygon(tmp_coords, polygon[i].cordinate_title);
				objectsBounds.union(getbounds);
			}
			polygon = map.drawPolygon({
				paths: path,
				strokeColor: '#BBD8E9',
				strokeOpacity: 1,
				strokeWeight: 3,
				fillColor: '#BBD8E9',
				fillOpacity: 0.6
			});
			map.addMarker({
				lat: arra[0],
				lng: arra[1],
				draggable: true,
				fences: [polygon],
				outside: function (m, f) {
				alert('This marker has been moved outside of its fence');
				}
			});
		}
		map.fitBounds(objectsBounds);
	});
// // Code end for zone area bound

// code start here for route direction
$("#routeGo").on("click", function () {
    calcRoute();
});
var destination_lati = '';
var destination_longi = '';
var origin_longi = '';
var origin_lati = '';
function calcRoute() {
    geocoder.geocode({'address': $("#routeTo").val()}, function (results, status) {
	if (status == google.maps.GeocoderStatus.OK) {
	origin_lati = results[0].geometry.location.lat();
	origin_longi = results[0].geometry.location.lng();
	}
    });
    geocoder.geocode({'address': $("#routeFrom").val()}, function (results, status) {
    	if (status == google.maps.GeocoderStatus.OK) {
	destination_lati = results[0].geometry.location.lat();
	destination_longi = results[0].geometry.location.lng();
        }
    });
//  console.log(destination_lati + '---' + destination_longi + '---' + origin_longi + '---' + origin_lati);
    map.renderRoute({
    origin: [origin_lati, origin_longi],
    destination: [destination_lati, destination_longi],
    travelMode: 'driving',
    strokeColor: '#131540',
    strokeOpacity: 0.6,
    strokeWeight: 6
    }, {
    panel: '#directions',
    draggable: true
    });
    }
    
    map.addMarker({
        lat: destination_lati,
        lng: destination_longi,
        draggable: true,
        fences: [polygon],
        outside: function (m, f) {
            alert('This marker has been moved outside of its cicle fence');
        }
    });
    map.addMarker({
        lat: destination_lati,
        lng: destination_longi,
        draggable: true,
        fences: [linee],
        outside: function (m, f) {
            alert('This marker has been moved outside of its cicle fence');
        }
    });
    map.addMarker({
        lat: destination_lati,
        lng: destination_longi,
        draggable: true,
        fences: [polygon],
        outside: function (m, f) {
            alert('This marker has been moved outside of its cicle fence');
        }
    });
	                                
});
</script>
</body>
</html>