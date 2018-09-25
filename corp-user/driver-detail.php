<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 

$triptID = base64_decode($_GET['a']);
if($triptID == '' || $triptID == null)
{
	RedirectURL(CORPORATE_URL."account-status.php");
}
// source_landmark   destination_landmark
//$qry = "SELECT d.image as driverImage,a.start_time,a.end_time,d.name AS driverName,t.status,t.customer_id,t.id as tripId,u.name,u.email_id,t.driver_id,a.payment_mode,a.payment_amount,a.add_on,t.source_address,t.source_latitude,t.source_longitude,t.source_landmark,t.destination_address,t.destination_latitude,t.destination_longitude,t.destination_landmark
$qry = "SELECT t.*, d.image as driverImage,d.name AS driverName
FROM `trip` t 
Left Join `users` u On t.customer_id=u.id 
LEFT JOIN  `driver` d ON t.driver_id = d.id 
WHERE 1 and u.`corporate_id`= '".$_SESSION['uid']."' and t.id='".$triptID."' 
order by t.id desc";
$res = mysql_query($qry);
$data = mysql_fetch_assoc($res);
//print_r($data);

if($data['driverImage'] != '' || $data['driverImage'] != null)
{
$imgDriver = TAXI_URL.$data['driverImage'];
}
else
{
$imgDriver = '../images/profile.png';
}
$start_time_trip = date("H:i:s", strtotime($data['tripdatetime']));
$end_time_trip = date("H:i:s", strtotime($data['trip_acceptTime']));
$duration = date_create($start_time_trip)->diff(date_create($end_time_trip))->format('%h Hrs %i Min %s Sec').'<br/>';


?>
<style>
.driver-image img {
    width: 50%;
}

</style>
<body>
    <?php include '../include/corp-navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pal0">
            <?php include '../include/corp-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <?php include '../include/corp-rsidebar.php'; ?>
            <div class="c-acc-status">
              <h2 class="txt-style-3">Detalle controlador</h2>
              <div class="row btsd">
              	<div class="col-sm-3">
                	<span class="txt-style-4">Taxista : <b><?php echo $data['driverName'];?></b></span>
                    <div class="driver-image"><img src="<?php echo $imgDriver;?>" alt="" title="" /></div>
                </div>
                <div class="col-sm-2">
                <span class="txt-style-4">Cantidad : <b><?php echo $data['trip_ammount'];?></b></span>
                </div>
                <div class="col-sm-4">
                <span class="txt-style-4"><b><?php echo $_SESSION['uname'];?></b> De Corporación</span>
                </div>
                <div class="col-sm-3">
                <span class="txt-style-4">Duración : <b><?php echo $duration;?></b></span>
                </div>
              </div>
              <br/>
              <?php //echo 'IDDDDDD'.$data['id'].'--------'.'Source--'.$data['source_landmark'].'--- Destination'.$data['destination_landmark'];?>
              <div class="row mfg">
              	<div class="col-sm-12 mg5">
                    <div id="map_canvas" style="width: 100%;height: 400px;"></div>
                </div>
                  
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!-- Animate map js -->
<script src="<?php echo MAIN_URL;?>js/v3_epoly.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	initialize();
	calcRoute();
});
  </script> 
<script type="text/javascript">
  
var map;
var directionDisplay;
var directionsService;
var stepDisplay;
var markerArray = [];
var position;
var marker = null;
var polyline = null;
var poly2 = null;
var speed = 0.000005, wait = 1;
var infowindow = null;
var myPano;   
var panoClient;
var nextPanoId;
var timerHandle = null;
var iconBase = '<?php echo MAIN_URL;?>images/';

function createMarker(latlng, label, html) {
// alert("createMarker("+latlng+","+label+","+html+","+color+")");
    var contentString = '<b>'+label+'</b><br>'+html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
		//  icon: iconBase + 'dotMarker.png',
        title: label,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
        marker.myname = label;
        // gmarkers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
        });
    return marker;
}


function initialize() {
  infowindow = new google.maps.InfoWindow(
    { 
      size: new google.maps.Size(150,50)
    });
    // Instantiate a directions service.
    directionsService = new google.maps.DirectionsService();
    
    // Create a map and center it on Manhattan.
    var myOptions = {
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    address = 'mexico'
    geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': address}, function(results, status) {
       map.setCenter(results[0].geometry.location);
	});
    // Create a renderer for directions and bind it to the map.
    var rendererOptions = {
      map: map
    }
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
    // Instantiate an info window to hold step text.
    stepDisplay = new google.maps.InfoWindow();
    polyline = new google.maps.Polyline({
	path: [],
	strokeColor: '#FF0000',
	strokeWeight: 3
    });
    poly2 = new google.maps.Polyline({
	path: [],
	strokeColor: '#FF0000',
	strokeWeight: 3
    });
  }
	var steps = []
	function calcRoute()
	{
		if (timerHandle) { clearTimeout(timerHandle); }
		if (marker) { marker.setMap(null);}
		polyline.setMap(null);
		poly2.setMap(null);
		directionsDisplay.setMap(null);
		polyline = new google.maps.Polyline({
		path: [],
		strokeColor: '#FF0000',
		strokeWeight: 3
		});
		poly2 = new google.maps.Polyline({
		path: [],
		strokeColor: '#FF0000',
		strokeWeight: 3
		});
		// Create a renderer for directions and bind it to the map.
		var rendererOptions = {
		  map: map
		}
		directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
		var start = '<?php echo $data['source_landmark'];?>'; //source_landmark   destination_landmark
		var end = '<?php echo $data['destination_landmark'];?>';
		var travelMode = google.maps.DirectionsTravelMode.DRIVING
		var request = {
				origin: start,
				destination: end,
				travelMode: travelMode
			};
			// Route the directions and pass the response to a
			// function to create markers for each step.
		directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK){
		directionsDisplay.setDirections(response);

		var bounds = new google.maps.LatLngBounds();
		var route = response.routes[0];
		startLocation = new Object();
		endLocation = new Object();

		// For each route, display summary information.
		var path = response.routes[0].overview_path;
		var legs = response.routes[0].legs;
			for (i=0;i<legs.length;i++) {
			  if (i == 0) { 
				startLocation.latlng = legs[i].start_location;
				startLocation.address = legs[i].start_address;
				// marker = google.maps.Marker({map:map,position: startLocation.latlng});
				marker = createMarker(legs[i].start_location,"start",legs[i].start_address,"green");
			  }
			  endLocation.latlng = legs[i].end_location;
			  endLocation.address = legs[i].end_address;
			  var steps = legs[i].steps;
			  for (j=0;j<steps.length;j++) {
				var nextSegment = steps[j].path;
				for (k=0;k<nextSegment.length;k++) {
				  polyline.getPath().push(nextSegment[k]);
				  bounds.extend(nextSegment[k]);
			   }
			  }
			}
			polyline.setMap(map);
			map.fitBounds(bounds);
	// createMarker(endLocation.latlng,"end",endLocation.address,"red");
		map.setZoom(18);
	//	startAnimation();
		}                                                    
	 });
}
    var step = 50; // 5; // metres
	var tick = 500; // milliseconds
	var eol;
	var k=0;
	var stepnum=0;
	var speed = "";
	var lastVertex = 1;
//=============== animation functions ======================
      function updatePoly(d) {
        // Spawn a new polyline every 20 vertices, because updating a 100-vertex poly is too slow
        if (poly2.getPath().getLength() > 20) {
          poly2=new google.maps.Polyline([polyline.getPath().getAt(lastVertex-1)]);
          // map.addOverlay(poly2)
        }
        if (polyline.GetIndexAtDistance(d) < lastVertex+2) {
           if (poly2.getPath().getLength()>1) {
             poly2.getPath().removeAt(poly2.getPath().getLength()-1)
           }
           poly2.getPath().insertAt(poly2.getPath().getLength(),polyline.GetPointAtDistance(d));
        } else {
          poly2.getPath().insertAt(poly2.getPath().getLength(),endLocation.latlng);
        }
      }
    function animate(d) {
// alert("animate("+d+")");
        if (d>eol) {
          map.panTo(endLocation.latlng);
          marker.setPosition(endLocation.latlng);
		  startAnimation();
          return;
        }
        var p = polyline.GetPointAtDistance(d);
        map.panTo(p);
        marker.setPosition(p);
        updatePoly(d);
        timerHandle = setTimeout("animate("+(d+step)+")", tick);
    }
function startAnimation() {
        eol=polyline.Distance();
        map.setCenter(polyline.getPath().getAt(0));
        // map.addOverlay(new google.maps.Marker(polyline.getAt(0),G_START_ICON));
        // map.addOverlay(new GMarker(polyline.getVertex(polyline.getVertexCount()-1),G_END_ICON));
        // marker = new google.maps.Marker({location:polyline.getPath().getAt(0)} /* ,{icon:car} */);
        // map.addOverlay(marker);
        poly2 = new google.maps.Polyline({path: [polyline.getPath().getAt(0)], strokeColor:"#0000FF", strokeWeight:10});
        // map.addOverlay(poly2);
        setTimeout("animate(50)",2000);  // Allow time for the initial map display
}
//=============== ~animation funcitons =====================


</script>