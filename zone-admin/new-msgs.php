<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style type="text/css">
#result {
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
.show {
	padding:5px;
	border-bottom:1px #999 dashed;
	font-size:15px;
}
.show:hover {
	background:#4c66a4;
	color:#FFF;
	cursor:pointer;
}

</style>
<body>
<?php include '../include/zone-navbar.php'; ?>
<?php 
		// Query for driver detail
		$query_driver_detail="SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name,`driver`.id as driID,`driver`.email FROM `driver`
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
        where `driver`.name like '%$q%' and `login`.id='".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'";
        $result_driver_detail = mysql_query($query_driver_detail);
        $num_rows_driver_detail = mysql_num_rows($result_driver_detail);
		
		// Query for corporaion detail 
		$nj = '';$njj = '';
		$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by =  '".$_SESSION['uid']."'");
		while($data = mysql_fetch_array($query))
		{
			  $nj .= $data[id].',';
		}
		$nj = rtrim($nj,',');
		$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
		while($data = mysql_fetch_array($query)){
			  $njj .= $data[id].',';
		}
		$njj = rtrim($njj,',');
		if(isset($njj) && $njj){
			$query_corporation_detail="SELECT name,web_user_id  FROM `corporate` where 1 and web_user_id in ($njj) and name like '%".$q."%' ";
			$result_corporation_detail = mysql_query($query_corporation_detail);
			$num_rows_corporation_detail = mysql_num_rows($result_corporation_detail);
		}
		
		// Query for centrals
		$query_central_detail = "SELECT name, id FROM login WHERE name like '%$q%' and account_type ='4' and added_by='".$_SESSION['uid']."'";
		$result_central_detail = mysql_query($query_central_detail);
		$num_rows_central_detail = mysql_num_rows($result_central_detail);
		
		//Query for app users detail
		$nj = '';
		$njj = '';
        $query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by =  '".$_SESSION['uid']."'");
        while($data = mysql_fetch_array($query))
        {
              $nj .= $data[id].',';
        }
        $nj = rtrim($nj,',');
		if(isset($nj) && $nj){
			$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
			while($data = mysql_fetch_array($query))
			{
				  $njj .= $data[id].',';
			}
		}
        $njj = rtrim($njj,',');
		if(isset($njj) && $njj){
			echo $query_users_detail="SELECT name, id FROM `users` where 1 and corporate_id in ($njj) and name like '%".$q."%' ";
			$result_users_detail = mysql_query($query_users_detail);
			$num_rows_users_detail = mysql_num_rows($result_users_detail);
		}
	?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <!--<h2 class="txt-style-3">Nuevos mensajes</h2>-->
          <form method="post" name="search" action="" onSubmit="return message();">
            <?php
              if(isset($_POST['submit1']) and $_POST['submit1']!="")
              { 
                message_new(); 
                HTMLRedirectURL(ZONE_URL."message-history.php");
              }            
            ?>
            <!--<div class="row">
              <div class="col-sm-3">
                <input type="radio" name="sendMessage" value="particular" class="chooseType" checked="checked">
                Especial
                </div>
                <div class="col-sm-3">
                <input type="radio" name="sendMessage" value="all" class="chooseType">
                Todas 
              </div>
            </div>
            <br/>-->
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> TAXI DRIVERS </label>
                  <select name="selDriverName" id="selDriverName" class="form-control ">
                    <option value=" ">Select Taxi Driver</option>
                    <?php  				
						if(isset($num_rows_driver_detail) && $num_rows_driver_detail>0){
						while($row = mysql_fetch_array($result_driver_detail)){?>
                    <option value="<?php echo $row['driID'];?>"><?php echo $row['name'];?></option>
                    <?php } }?>
                    <option value="0">All TAXI DRIVERS</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> CORPORATIONS </label>
                  <!--<input type='text' name="corpName" class='input-style' id="searchid1" placeholder="Introduzca el texto aquí"  />
                  <span id="party_id13"></span>-->
                  <select name="selCorName" id="selCorName" class="form-control ">
                    <option value=" ">Select CORPORATIONS</option>
                    <?php   
						if ($num_rows_corporation_detail >0) {            
						while ($row = mysql_fetch_array($result_corporation_detail))
						{?>
                    <option value="<?php echo $row['web_user_id'];?>"><?php echo $row['name'];?></option>
                    <?php } }?>
                    <option value="0">All CORPORATIONS</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> CENTRALES </label>
                  <!--<input type='text' name="taxiName" id="searchid2" class='input-style' placeholder="Introduzca el texto aquí"  />
                  <span id="party_id14"></span>-->
                  
                  <select name="selCentralName" id="selCentralName" class="form-control ">
                    <option value=" ">Select Centrals</option>
                    <?php  
						if ($num_rows_central_detail > 0) {
						while($row_central_detail = mysql_fetch_array($result_central_detail)){?>
                    <option value="<?php echo $row_central_detail['id'];?>"><?php echo $row_central_detail['name'];?></option>
                    <?php } }?>
                    <option value="0">All Centrals</option>
                  </select>
                </div>
              </div>
            
              <div class="col-sm-4">
                <div class="form-group">
                  <label>USERS</label>
                  <!--<input type='text' name="corpUser" id="searchid3" class='input-style' placeholder="Introduzca el texto aquí"  />
                  <span id="party_id15"></span>-->
                  <select name="selUsersName" id="selUsersName" class="form-control ">
                    <option value=" ">Select USER</option>
                    <?php  
						$num_rows_users_detail = mysql_num_rows($result_users_detail);
						if ($num_rows_users_detail > 0) {
						while($row_users_detail = mysql_fetch_array($result_users_detail)){?>
                    <option value="<?php echo $row_users_detail['id'];?>"><?php echo $row_users_detail['name'];?></option>
                    <?php } }?>
                    <option value="0">All Users</option>
                  </select>
                </div>
              </div>
           
              <div class="col-sm-8">
                <div class="form-group">
                  <label>TITLE</label>
                  <input type="text" name="txtHeading" placeholder="TITLE" class="input-style" required />
                </div>
              </div>
           <div class="clearfix"></div>
              <div class="col-sm-6 wap">
                <div class="form-group">
                  <label>MESSAGE</label>
                  <textarea class="input-style" name="sentMessage"  placeholder="MESSAGE" style="min-height:330px;" required maxlength="300"></textarea>
                </div>
              </div>
              <div class="col-sm-6 wap">
                <div class="form-group">
                  <label>&nbsp;</label>
                 
      </div>
<?php
$strCenterPoint="SELECT `login`.id,`zone_area`.id as zid,`zone_area`.allot_to,`zone_cordinater`.zone_area_id,`zone_cordinater`.map_center_latitude,`zone_cordinater`.map_center_longitude from `login` LEFT JOIN `zone_area` ON `login`.id = `zone_area`.allot_to LEFT JOIN `zone_cordinater` ON `zone_cordinater`.zone_area_id = `zone_area`.id where `login`.id ='".$_SESSION['uid']."' ";
$resCentralPoint=mysql_query($strCenterPoint);
$rowCentralPoint=mysql_fetch_array($resCentralPoint);
$latCenterPoint =  $rowCentralPoint['map_center_latitude'];
$lonCenterPoint = $rowCentralPoint['map_center_longitude'];
?>
                  <input type="checkbox" id="getOptional" name ="getOptional" value="1">Attach Location
                <?php// echo $_SESSION['zoneArea']; ?>
                  <div id="map" style="width:100%; height:350; display: none" class="map_section"></div>
                  <div id="map_canvas" style="height: 350px;width: 100%;"></div>
              </div>
           
           <input id="searchTextField" name="searchAddress" value="" type="hidden" size="50" style="text-align: left;width:357px;direction: ltr;">
            <input name="latitude" class="MapLat" value="" type="hidden" placeholder="Latitude" style="width: 161px;">
            <input  name="longitude" class="MapLon" value="" type="hidden" placeholder="Longitude" style="width: 161px;">
              <!--<div class="col-sm-6 wap">
                <div class="form-group">
			      	<div id="map" style="width: 500px; height: 400px;"></div></div></div-->
              <div class="col-sm-4 col-sm-offset-4"> 
                <!-- <button class="dash-button hvr-wobble-horizontal w100" name="submit">Send message</button> -->
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('message_new')?>" />
                <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
                <input type="submit" class="dash-button hvr-wobble-horizontal w100 wap" name="submit1" id="submit1" value="Send Message" />
              </div>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
    
    


    
    
<?php include '../include/footer.php'; ?>
</body>
</html>
<!-- live search script -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
<script>
   /* $(".map_section").hide();
    $("#getOptional").click(function() {
        if($(this).is(":checked")) {
            $(".map_section").show();
        } else {
            $(".map_section").hide();
        }
    });*/
    
var $start = $('#start'),
	$end = $('#end');
	$start.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$end.data('datepicker')
				.update('minDate', date)
		}
	})
	$end.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$start.data('datepicker')
				.update('maxDate', date)
		}
	})
</script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.min.js"></script>
<!-- live search script -->
<script src="http://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true"></script>
<script type="text/javascript">
    
 
 $(function() {
    $('.chooseType').change(function() {
        if ($(this).val() == 'all') {
            //alert("all");
			$("#selDriverName").addClass("input-style1");
			$("#selCorName").addClass("input-style1");
			$("#selCentralName").addClass("input-style1");
			$("#selUsersName").addClass("input-style1");
        } else {
			$("#selDriverName").removeClass("input-style1");
			$("#selCorName").removeClass("input-style1");
			$("#selCentralName").removeClass("input-style1");
			$("#selUsersName").removeClass("input-style1");
            //alert("particular");
        }
    });
});
 
 
 
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid").autocomplete({
                        source:'gethint1.php',
            select: function (event, ui) {
            $('#party_id12').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid1").autocomplete({
                        source:'gethint2.php',
            select: function (event, ui) {
            $('#party_id13').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid2").autocomplete({
                        source:'gethint3.php',
            select: function (event, ui) {
            $('#party_id14').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid3").autocomplete({
                        source:'gethint4.php',
            select: function (event, ui) {
            $('#party_id15').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
var map = new google.maps.Map(document.getElementById('map'), {
      zoom:7,
      // center: new google.maps.LatLng(-33.92, 151.25),
      center: new google.maps.LatLng('<?php echo $latCenterPoint; ?>', '<?php echo $lonCenterPoint; ?>'),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

$.post('getData.php',{mode:'<?php echo base64_encode('njGetData');?>'},function(response){
  //console.log(response);
    var arr = jQuery.parseJSON(response);
    locations = arr['driver_details'];
    // login users list based on zone based corp / driver / 
    console.log(locations);
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
        for (i = 0; i < locations.length; i++) { 
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i]['latitude'], locations[i]['longitude']),
            map: map
          });
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent('Driver name:  '+locations[i]['driverName']+' <br> '+'Company name:  '+ locations[i]['companyName']);
              infowindow.open(map, marker);
            }
          })(marker, i));
      }

    var locations_users = arr['user_details'];  
    var infowindow = new google.maps.InfoWindow();
    var marker, i;
    for (i = 0; i < locations_users.length; i++) { 
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations_users[i]['userLatitude'], locations_users[i]['userLongitude']),
        map: map,
        icon: 'rU427.png'
      });
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent('User name:  '+locations_users[i]['userName']+' <br> '+'Corporate name:  '+ locations_users[i]['corporateName']);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
});



  $(function () {
         var lat = 22.7195687,
             lng =  75.8577258,
             latlng = new google.maps.LatLng(lat, lng),
             image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

         //zoomControl: true,
         //zoomControlOptions: google.maps.ZoomControlStyle.LARGE,

         var mapOptions = {
             center: new google.maps.LatLng(lat, lng),
             zoom: 5,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
             panControl: true,
             panControlOptions: {
                 position: google.maps.ControlPosition.TOP_RIGHT
             },
             zoomControl: true,
             zoomControlOptions: {
                 style: google.maps.ZoomControlStyle.LARGE,
                 position: google.maps.ControlPosition.TOP_left
             }
         },
         map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
             marker = new google.maps.Marker({
                 position: latlng,
                 map: map,
                 icon: image
             });

         var input = document.getElementById('searchTextField');
         var autocomplete = new google.maps.places.Autocomplete(input, {
             types: ["geocode"]
         });

         autocomplete.bindTo('bounds', map);
         var infowindow = new google.maps.InfoWindow();

         google.maps.event.addListener(autocomplete, 'place_changed', function (event) {
             infowindow.close();
             var place = autocomplete.getPlace();
             if (place.geometry.viewport) {
                 map.fitBounds(place.geometry.viewport);
             } else {
                 map.setCenter(place.geometry.location);
                 map.setZoom(17);
             }

             moveMarker(place.name, place.geometry.location);
             $('.MapLat').val(place.geometry.location.lat());
             $('.MapLon').val(place.geometry.location.lng());
         });
         google.maps.event.addListener(map, 'click', function (event) {
             $('.MapLat').val(event.latLng.lat());
             $('.MapLon').val(event.latLng.lng());
             infowindow.close();
                     var geocoder = new google.maps.Geocoder();
                     geocoder.geocode({
                         "latLng":event.latLng
                     }, function (results, status) {
                         console.log(results, status);
                         if (status == google.maps.GeocoderStatus.OK) {
                             console.log(results);
                             var lat = results[0].geometry.location.lat(),
                                 lng = results[0].geometry.location.lng(),
                                 placeName = results[0].address_components[0].long_name,
                                 latlng = new google.maps.LatLng(lat, lng);

                             moveMarker(placeName, latlng);
                             $("#searchTextField").val(results[0].formatted_address);
                         }
                     });
         });
        
         function moveMarker(placeName, latlng) {
             marker.setIcon(image);
             marker.setPosition(latlng);
             infowindow.setContent(placeName);
             //infowindow.open(map, marker);
         }
     });
</script>