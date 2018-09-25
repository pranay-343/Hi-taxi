<?php  ?>
<?php 
include '../include/define.php';
include '../include/head.php'; 
?>
<style type="text/css">
   
    
    #result
    {
        position:absolute;
        width:100%;
        padding:10px;
        display:none;
        margin-top:-1px;
        border-top:0px;
        overflow:hidden;
        border:1px #CCC solid;
        background-color: white;
    }
    .show
    {
        padding:5px; 
        border-bottom:1px #999 dashed;
        font-size:15px; 
    }
    .show:hover
    {
        background:#4c66a4;
        color:#FFF;
        cursor:pointer;
    }
	#map, #panorama {
    height: 350px;
    background: #69c;
    width: 60%;
}
</style>
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
          <h2 class="txt-style-3">View Message </h2>
		  
		  
		  
            <?php 
                $id=$_REQUEST['id'];
                $str="select * from send_message_new where 1 and id='$id'";
                $res=mysql_query($str);
                $row=mysql_fetch_array($res);

                if($row['user_type'] == 'driver'){
                    $data_dri = mysql_fetch_array(mysql_query("SELECT * FROM driver WHERE id = '".$row['user_id']."'"));
                    $name = $data_dri['name'];
                }
                elseif ($row['user_type'] == 'crop') {
                    $data_crop = mysql_fetch_array(mysql_query("SELECT * FROM login WHERE id = '".$row['user_id']."'"));
                    $name = $data_crop['name'];
                }
                elseif ($row['user_type'] == 'compnay') {
                    $data_com = mysql_fetch_array(mysql_query("SELECT * FROM login WHERE id = '".$row['user_id']."'"));
                    $name = $data_com['name'];
                }
                elseif ($row['user_type'] == 'cropuser') {
                    $data_user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = '".$row['user_id']."'"));
                    $name = $data_user['name'];
                }
            ?>
          <div class="row bts">


              <div class="clearfix"></div>
              <!-- BY Dinesh -->
              <div class="c-acc-status bst mgmin">
                  <h2 class="txt-style-3">Message Information</h2>

                  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                      <tr> 
                          <th class="tab-txt1">Name </th>
                          <th class="tab-txt1">TITLE</th>
                          <th class="tab-txt1">MESSAGE</th>
                          <th class="tab-txt1">LOCATION MAP</th>
                          <th class="tab-txt1">ADDED ON</th>
                      </tr>
                      
                      

                      <tr> 
                          <td class="tab-txt1"><?php echo $name;?></td>
                          <td class="tab-txt1"><?php echo $row['heading'];?></td>
                          <td class="tab-txt1 message_display"><?php echo base64_decode($row['message']);?></td>
                          <td class="tab-txt1"><?php echo $row['location_address'];?></td>
                          <td class="tab-txt1"><?php echo $row['added_on'];?></td>
                      </tr>
                  </table>
                  <div id="map" width="350px" height="350px" style="margin-top: 30px"></div> 
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




<script src="https://maps.googleapis.com/maps/api/js?&sensor=true&extension=.js"></script>
<script>
    
(function () {

    var pos = new google.maps.LatLng(<?php echo $row['latitude']?>, <?php echo $row['longitude']?>);

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
        content: '<?php echo $row['location_address']?>'
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

<script>

$(function(){

    var minimized_elements = $('td.message_display');
    
    minimized_elements.each(function(){    
        var t = $(this).text();        
        if(t.length < 50) return;
        
        $(this).html(
            t.slice(0,50)+'<span>... </span><a href="#" class="more">More</a>'+
            '<span style="display:none;">'+ t.slice(100,t.length)+' <a href="#" class="less">Less</a></span>'
        );
        
    }); 
    
    $('a.more', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).hide().prev().hide();
        $(this).next().show();        
    });
    
    $('a.less', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).parent().hide().prev().show().prev().show();    
    });

});
</script>