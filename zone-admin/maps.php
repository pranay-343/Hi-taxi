<?php 
include '../include/define.php';
include '../include/head.php'; 

if($_POST['centralss'] == '' || $_POST['centralss'] == null)
{
	$_POST['centralss'] = '0';
}
?>
    <body>
    <?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Maps area</h2>
          <form method="post">
          <div class="row bts">
          <div class="col-sm-4">
          	<div class="form-group">
            	<label> Central </label>
                 <select class="input-style" name="centralss" id="centralss">
                 	<option>--Select Central--</option>
                    <?php 
					$qruy = mysql_query("SELECT `login`.id,`login`.name,`login`.contact_number From `login` LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by ='".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'");
	while($dat = mysql_fetch_assoc($qruy))
	{
		if($dat['id'] == $_POST['centralss']){$nj = 'selected';}else{$nj = '';}
		echo '<option value="'.$dat['id'].'" '.$nj.'>'.$dat['name'].'</option>';
	}
					?>
                 </select>
                  <input class="dash-button hvr-wobble-horizontal w100 wap" value="Filtrar" name="submit" type="submit" />
            </div>
           
            </div>
            
            
            </div>
            
            <div class="row">
            	<div class="col-sm-12">
                 <div class="index_table" id="checkboxArea" style="display:none">
			</div>
                	<div>
  	<div id="map" style="width:100%; height: 400px;"></div>
		
	</div>
                </div>
            </div>
          </form>
          <div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
<?php include '../include/map-script.php'; ?>
</body>
</html>

<script>
 $(document).ready(function () {
 var geocoder = new google.maps.Geocoder();
// Code for zone area bound
 var polygon='';
 var linee = '';
 var circles = '';
    var path = [];
    var objectsBounds = new google.maps.LatLngBounds();
    var tmp_coords = [];
    $.post('getData.php', {mode: '<?php echo base64_encode('getcordeinatesDetails'); ?>', a: '<?php echo $_SESSION['zoneArea']; ?>'}, function (response) {
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
		}
		
		
		// Get all driver Details for circle boumdry
		$.post('getDriverDetails.php',{mode:'<?php echo base64_encode('getallDriversDetails')?>',a:<?php echo $_POST['centralss'];?>},function(response){
			var obj = jQuery.parseJSON(response);
                        //console.log(response);
			var njData = obj['getallDriversDetails'];
			for (i = 0; i < njData.length; i++) 
			{  
				if(njData[i].driver_id != '0' || njData[i].driver_id != 0)
				{
					map.addMarker({
						lat: njData[i].latitude,
						lng: njData[i].longitude,
						draggable: false,
						icon: '<?php echo ZONE_URL;?>location-24-32.png',
						outside: function(m, f){
						  alert('Este mercado se ha movido fuera de su valla');
						},
						infoWindow: { 
						content: '<p>Nombre central : <b>'+njData[i].central+'</b></p><p>Sin Contacto : <b>'+njData[i].mobile+'</b></p><p>Nombre del conductor : <b>'+njData[i].username+'</b></p>'
					  }					  
				  });
				  
				}
			}
	  });
          
          
          // Get all driver trip Details for headt map starting point
		/*$.post('getDriverDetails.php',{mode:'<?php echo base64_encode('getAllTripsDataBy_Nj')?>',a:<?php echo $_POST['centralss'];?>},function(response){
                //console.log(response);
			var obj = jQuery.parseJSON(response);
                        //console.log(response);
			var njData1 = obj['getallDriversDetails_zone'];
			for (j = 0; j < njData1.length; J++) 
			{  
				if(njData[i].driver_id != '0' || njData[i].driver_id != 0)
				{
					map.addMarker({
						lat: njData[i].latitude,
						lng: njData[i].longitude,
						draggable: false,
						icon: '<?php echo ZONE_URL;?>Location-32.png',
						outside: function(m, f){
						  alert('Este mercado se ha movido fuera de su valla');
						},
						infoWindow: { 
						content: '<p>Heat Map Pickup Zone</p></p><p>Sin Contacto : <b>'+njData[i].mobile+'</b></p><p>Nombre del conductor : <b>'+njData[i].username+'</b></p>'
					  }					  
				  });
				  
				}
			}
	  });*/
    
    	var objs=[];
      	$.post('getDriverDetails.php',{mode:'<?php echo base64_encode("getAllTripsDataBy_Nj")?>'},function(response){
            
                 // Heatmap data: 500 Points
            var obj = jQuery.parseJSON(response);
           // console.log(obj['result']);
            var arr = obj['result'].length;
            var i=0;
            var z = '';
            for(i=0;i < arr;i++)
            {

               objs += obj['result'][i];
            //   objs.push(objj);
            }

            console.log(getPoints());
            initMap();

             var map, heatmap;
		      function initMap() {
		        
		        heatmap = new google.maps.visualization.HeatmapLayer({
		          data: getPoints(),
		          map: map
		        });
		      }

		      function toggleHeatmap() {
		        heatmap.setMap(heatmap.getMap() ? null : map);
		      }

		      function changeGradient() {
		        var gradient = [
		          'rgba(0, 255, 255, 0)',
		          'rgba(0, 255, 255, 1)',
		          'rgba(0, 191, 255, 1)',
		          'rgba(0, 127, 255, 1)',
		          'rgba(0, 63, 255, 1)',
		          'rgba(0, 0, 255, 1)',
		          'rgba(0, 0, 223, 1)',
		          'rgba(0, 0, 191, 1)',
		          'rgba(0, 0, 159, 1)',
		          'rgba(0, 0, 127, 1)',
		          'rgba(63, 0, 91, 1)',
		          'rgba(127, 0, 63, 1)',
		          'rgba(191, 0, 31, 1)',
		          'rgba(255, 0, 0, 1)'
		        ]
		        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
		      }

		      function changeRadius() {
		        heatmap.set('radius', heatmap.get('radius') ? null : 20);
		      }

		      function changeOpacity() {
		        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
		      }
		      
		      function getPoints() {
		      	return '['+objs+']';
		      	//return [new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227),new google.maps.LatLng(22.7269521,75.8799227)];
		      }

            
      	});
          
         
          
	  // Gert all driver Details
		map.fitBounds(objectsBounds);
	});
// // Code end for zone area bound

var locations = '';

   
   /*
    var infowindow = new google.maps.InfoWindow();
	var njData = obj;
    var marker, i;
    for (i = 0; i < njData.length; i++) {  
	if(njData[i].driver_id != '0' || njData[i].driver_id != 0)
	{
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(njData[i].latitude, njData[i].longitude),
        map: map,
		icon: '<?php echo ZONE_URL;?>taxi-32.png'
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent('<b>'+njData[i].username+'</b> ('+njData[i].mobile+') ');
          infowindow.open(map, marker);
        }
      })(marker, i));
	}
    }
	*/
//});

});
</script>