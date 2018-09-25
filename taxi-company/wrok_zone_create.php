<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$zoneId = $_GET['map_id']; 
$query = mysql_query("select * from `zone_area`  where 1 and id='".$zoneId."'");
$response = mysql_fetch_assoc($query);
$zone_title= base64_decode($response['zone_title']);
$zone_description=base64_decode($response['zone_description']); 

$qryLog = mysql_query("select * from `login` where 1 and id='".$zoneId."'");
$result = mysql_fetch_assoc($qryLog); 

$qry = mysql_query("select * from `zone_cordinater`  where 1 and zone_area_id='".$response['id']."'");
$res = mysql_fetch_assoc($qry);
?>
<style type="text/css">button#drawwhat_clearall {
    display: none;
}
/*
.posit_absol {
    position: fixed !important;
    top: 90px !important;
    left: 27%;
}*/
</style>

<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
		  
          <div class="col-sm-9">
            <h1 class="txt-style-1">Account User : <strong> <?php echo $_SESSION['uname']; echo $_SESSION['uid'];?> </h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Zone Area</h2>
			  
			  <p class="guide_msg">You can add only one area of ??the zone at a time</p>

              <div class="row">
        <div class="span65">
            <div id="basic_options">
                <div class="radio">
       <!--<label for="drawwhat_line"><input type="radio" name="drawwhat" id="drawwhat_line" value="line" checked>Line</label>-->
        <label for="drawwhat_polygon"><input type="radio" name="drawwhat" id="drawwhat_polygon" value="polygon">Polygon</label>  
        <label for="drawwhat_polygon"><input type="checkbox" name="chkFarbiddenShow" id="chkFarbiddenShow" value="1">RESTRICTED AREA</label>
        <!--<label for="drawwhat_rectangle"><input type="radio" name="drawwhat" id="drawwhat_rectangle" value="rectangle">Rectangle</label>-->        
        <!--<label for="drawwhat_circle"><input type="radio" name="drawwhat" id="drawwhat_circle" value="circle">Circle</label>-->    
                <div id="helpbox" class="text-info"></div>    
                </div>
            </div>
            
            
            <div id="basic_buttons">
                <button type="button" id="drawwhat_clearall" class="btn btn-danger">Borrar todo</button>
                <button type="button" disabled="disabled" id="add_btn" class="btn btn-primary">Add</button> 
                <button type="button" disabled="disabled" id="save_btn" class="btn btn-success">Save</button> 
                <button type="button" disabled="disabled" id="cancel_editing" class="btn btn-warning">Cancel</button>
            </div>
        </div>          
        <div class="span70 searchbox" >
            <form method="post" id="geocoding_form" class="form-inline" role="form"> 
                <div class="form-group input">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Search Address">
                    <input type="submit" class="btn btn-primary" value="Search" />
                </div>                  
            </form>
        </div>
    </div>
        <div class="row">
                <div class="popin">
                    <div id="map"></div>
                </div>
            </div>
            <div class="row" id="map_form">	
            <div id="erorrMsg"></div>		
<?php
if(isset($_POST['editmap_btn']) and $_POST['editmap_btn']!=""){
createzoneCordinatedForDriver();
unset($_POST);
HTMLRedirectURL(TAXI_URL."wrok_zone_create.php");
}
?>
               <form  method="post" action="" role="form" data-toggle="validator">
                   
                   <label class="posit_absol" for=""><input type="hidden" name="chkFarbidden" id="chkFarbidden" value=""></label> 
                    <div class="row" id="allmarks"></div>  
                    <div class="row" id="map_info">
                        

                <input type="hidden" id="zoneId" name="zoneId" value="<?php echo $zoneId;?>">
                <input type="hidden" id="cordinateId" name="cordinateId" value="<?php echo $response['id'];?>">
                
                       <input type="hidden" id="map_center_lat" name="map_center_lat" value="<?php echo $res['map_center_latitude'];?>">
                        <input type="hidden" id="map_center_lng" name="map_center_lng" value="<?php echo $res['map_center_longitude'];?>">
                        <input type="hidden" id="map_zoom" name="map_zoom" value="<?php echo $res['map_zoom'];?>">
                        <input type="hidden" id="map_typeid" name="map_typeid" value="<?php echo $res['map_type'];?>">

                        <input type="hidden" id="map_Lineid" name="map_Lineid" value="<?php echo $res['email'];?>">
                        <input type="hidden" id="map_Polygonid" name="map_Polygonid" value="<?php echo $res['email'];?>">
                        <input type="hidden" id="map_Rectangleid" name="map_Rectangleid" value="<?php echo $res['email'];?>">
                        <input type="hidden" id="map_Circleid" name="map_Circleid" value="<?php echo $res['email'];?>">
                        <input class="dash-button hvr-wobble-horizontal w100" type="submit" name="editmap_btn" id="editmap_btn" value="Actualizar controlador &Atilde;rea" />
                    </div>  
                </form>
            </div> 
        </div> 

      </div>
    </div>
<?php 
include '../include/footer.php'; 
include '../include/map-script.php'; 
?>
 <script>
        $(document).ready(function(){
            var objectsBounds = new google.maps.LatLngBounds();
            var tmp_coords = [];
            $.post('../super-admin/getData.php',{mode:'<?php echo base64_encode('getcordeinatesDetails_driver');?>',a:'<?php echo $_GET["map_id"];?>'},function(response){
                var obj = jQuery.parseJSON(response);
        
                for (var i = 0; i < obj['dataa']['zone_name'].length; i++)
                    {

                            if($.trim(obj['dataa']['zone_name'][i].zone_name)== 0 || obj['dataa']['zone_name'][i].zone_name == '0')
                            {}
                            else
                            {
                                var contentt = '<div class="checkbox"><label><input type="checkbox" name="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" id="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" checked="checked">'+obj['dataa']['zone_name'][i].zone_name+'</label></div>';
                                $('#checkboxArea').append(contentt);
                            }
                    }
                
                // <div class="checkbox"><label><input type="checkbox" name="chbx_rectangles" id="chbx_rectangles" checked="checked">Rectangles</label></div>
                //$('#checkboxArea').push();
        
            // ----------polygon------  
            if(obj['dataa']['polygon'] === 'undefined' || obj['dataa']['polygon'] === undefined)
                {}
                else
                {

                    var polygon = obj['dataa']['polygon'];
                    for (var i = 0; i < polygon.length; i++)
                    {
                        var cordinateId = 'Main_Zone';
                        
                            var cordinated = polygon[i].cordinatess;
                            var coords = cordinated;
                            tmp_coords = getPathFromCoordsArray(coords);

                            var getbounds = loadPolygonMainZoneByNjj(tmp_coords,polygon[i].cordinate_title,cordinateId);
                            objectsBounds.union(getbounds);  
                    }
                }
            // ----------polygon Driver------       
            
                map.fitBounds(objectsBounds); 
            });
        });
        
        
    </script>
	<script>
        $(document).ready(function(){
			var objectsBounds = new google.maps.LatLngBounds();
            var tmp_coords = [];
            $.post('../super-admin/getData.php',{mode:'<?php echo base64_encode('getcordeinatesDetails_driver_2');?>',a:'<?php echo $_GET["map_id"];?>'},function(response){
                var obj = jQuery.parseJSON(response);
		
				for (var i = 0; i < obj['dataa']['zone_name'].length; i++)
					{

                    //    retrun false;
							if($.trim(obj['dataa']['zone_name'][i].zone_name)== 0 || obj['dataa']['zone_name'][i].zone_name == '0')
							{}
							else
							{
								var contentt = '<div class="checkbox"><label><input type="checkbox" name="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" id="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" checked="checked">'+obj['dataa']['zone_name'][i].zone_name+'</label></div>';
								$('#checkboxArea').append(contentt);
							}
					}
				
				// <div class="checkbox"><label><input type="checkbox" name="chbx_rectangles" id="chbx_rectangles" checked="checked">Rectangles</label></div>
				//$('#checkboxArea').push();		
			// ----------polygon------	
			if(obj['dataa']['dr_polygon'] === 'undefined' || obj['dataa']['dr_polygon'] === undefined)
				{}
				else
				{

					var polygon = obj['dataa']['dr_polygon'];
					for (var i = 0; i < polygon.length; i++)
					{
                        var cordinateId = obj['dataa']['dr_polygon'][i]['driver_cordinated_ID'];
							var cordinated = polygon[i].dr_cordinatess;
							var coords = cordinated;
							tmp_coords = getPathFromCoordsArray(coords);
							var getbounds = loadPolygonByNjj(tmp_coords,polygon[i].dr_cordinate_title,cordinateId);
							objectsBounds.union(getbounds);  
					}
				}
			
				map.fitBounds(objectsBounds); 
            });
        });
		
		
    </script>
    
    <script>
        $(document).ready(function(){
			var objectsBounds = new google.maps.LatLngBounds();
            var tmp_coords = [];
            $.post('../super-admin/getData.php',{mode:'<?php echo base64_encode('getcordeinatesDetails_driver_3');?>',a:'<?php echo $_GET["map_id"];?>'},function(response){
                var obj = jQuery.parseJSON(response);
		
				for (var i = 0; i < obj['dataa']['zone_name'].length; i++)
					{

                    //    retrun false;
							if($.trim(obj['dataa']['zone_name'][i].zone_name)== 0 || obj['dataa']['zone_name'][i].zone_name == '0')
							{}
							else
							{
								var contentt = '<div class="checkbox"><label><input type="checkbox" name="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" id="chbx_'+obj['dataa']['zone_name'][i].zone_name+'" checked="checked">'+obj['dataa']['zone_name'][i].zone_name+'</label></div>';
								$('#checkboxArea').append(contentt);
							}
					}
				
				// <div class="checkbox"><label><input type="checkbox" name="chbx_rectangles" id="chbx_rectangles" checked="checked">Rectangles</label></div>
				//$('#checkboxArea').push();		
			// ----------polygon------	
			if(obj['dataa']['dr_polygon'] === 'undefined' || obj['dataa']['dr_polygon'] === undefined)
				{}
				else
				{

					var polygon = obj['dataa']['dr_polygon'];
					for (var i = 0; i < polygon.length; i++)
					{
                        var cordinateId = obj['dataa']['dr_polygon'][i]['driver_cordinated_ID'];
							var cordinated = polygon[i].dr_cordinatess;
							var coords = cordinated;
							tmp_coords = getPathFromCoordsArray(coords);
							var getbounds = loadPolygonForbiddenByNjj(tmp_coords,polygon[i].dr_cordinate_title,cordinateId);
							objectsBounds.union(getbounds);  
					}
				}
			
				map.fitBounds(objectsBounds); 
            });
        });
		
$('#chkFarbiddenShow').click(function(){
    var text = "";
    $('#chkFarbiddenShow:checked').each(function(){
        text += $(this).val();
    });
    //text = text.substring(0,text.length-1);
    
    $('#chkFarbidden').val(text);
});
    </script>
</body>
</html>

