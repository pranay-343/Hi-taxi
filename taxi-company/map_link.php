<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
<?php include '../include/taxi-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/taxi-sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
    
        <div class="c-acc-status">
          <h2 class="txt-style-3">Map Location</h2>
        </div>  
          <?php $id = base64_decode($_REQUEST['id']);
          $sql = "SELECT * FROM send_message_new WHERE id = '$id'";
          $res = mysql_query($sql);
          $dataArray = mysql_fetch_array($res);
          
          ?>
          <div id="map" width="500px" height="350px"></div>
          <div id="map-canvas" width="500px" height="350px"></div>
      </div>        
    </div>      
   </div>    
 </div> 
    
<?php include '../include/footer.php'; ?>
</body>
</html>

<script src="https://maps.googleapis.com/maps/api/js?&sensor=true&extension=.js"></script>
<script>
    
(function () {

    var pos = new google.maps.LatLng(<?php echo $dataArray['latitude']?>, <?php echo $dataArray['longitude']?>);

    var map = new google.maps.Map($('#map')[0], {
        center: pos,
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROAD
    });

    var marker = new google.maps.Marker({
        position: pos,
        map: map
    });
    marker.tooltipContent = 'this content should go inside the tooltip';
    var infoWindow = new google.maps.InfoWindow({
        content: '<?php echo $dataArray['location_address']?>'
    });

    google.maps.event.addListener(marker, 'click', function () {
        infoWindow.open(map, marker);
    });
    
})();

function fromLatLngToPoint(latLng, map) {
    var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
    var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
    var scale = Math.pow(2, map.getZoom());
    var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
}
</script>
          