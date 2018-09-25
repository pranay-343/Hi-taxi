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
<style type="text/css">
    .hide_poly{
        display: none !important;
    }
    .show_poly{
        display: block !important;
    }
</style>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Administrator Area</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Administrator Edit Area</h2>
              <div class="row">
        <div class="span65">
            <div id="basic_options">
                <div class="radio">
                    <label for="drawwhat_polygon" class="hide_poly" id="njGetNew"><input type="radio" name="drawwhat" id="drawwhat_polygon" value="polygon">Polígono</label> 
                    
        <!--<label for="drawwhat_rectangle"><input type="radio" name="drawwhat" id="drawwhat_rectangle" value="rectangle">Rectangle</label> -->       
        <!--<label for="drawwhat_circle"><input type="radio" name="drawwhat" id="drawwhat_circle" value="circle">Circle</label>-->    
                <div id="helpbox" class="text-info"></div>    
                </div>
            </div>
            <div id="basic_buttons">
                <!--<button type="button" id="drawwhat_clearall" class="btn btn-danger">Clear All</button> -->
                <button type="button" disabled="disabled" id="add_btn" class="btn btn-primary" >Add</button>
                <button type="button" disabled="disabled" id="save_btn" class="btn btn-success">Save</button> 
                <button type="button" disabled="disabled" id="cancel_editing" class="btn btn-warning">Cancel</button>
            </div>
        </div>          
        <div class="span70 searchbox" >
            <form method="post" id="geocoding_form" class="form-inline" role="form">
                <div class="form-group input">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter Search location">
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
<?php
if(isset($_POST['editmap_btn']) and $_POST['editmap_btn']!=""){
updatezoneCordinatedWithAdministrator();
unset($_POST);
}
?>
               <form  method="post" action="" role="form" data-toggle="validator">
                    <div class="row" id="allmarks"></div>  
                    <div class="row" id="map_info">

                        <div class="form-group">
                            <label for="map_title" class="control-label">Title</label>
                            <input type="text" class="form-control" id="map_title" name="map_title" placeholder="Enter Title" value="<?php echo $zone_title ;?>" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="map_description">Description</label>
                            <textarea class="form-control" rows="3" id="map_description" name="map_description" placeholder="Enter Description"><?php echo $zone_description ;?></textarea>
                        </div>
	<div class="form-group">
	<label for="map_description">Administrator</label>
	<!--<input type="text" name="administratorId" id="administratorId"  class="input-style" required value="<?php echo $result['name'];?>" readonly="readonly"/>-->
		<select name="administratorId" id="administratorId" class="input-style">
		<option value="">Select Zone Administrator</option>
				
	
	<?php $query_zone_admin = "SELECT * FROM login WHERE account_type='2'";
			$result_zone_admin =mysql_query($query_zone_admin);
			$num_zone_admin = mysql_num_rows($result_zone_admin);
			if($num_zone_admin > 0){
				while ($data_zone_admin = mysql_fetch_array($result_zone_admin)){
	?>
			<option <?php if ($data_zone_admin['id']) {
                    echo (($data_zone_admin['id'] == $response['allot_to'] ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $data_zone_admin['id'];?>"><?php echo $data_zone_admin['name'];?></option>
	<?php } }?>
	</select>
	</div>
                        
                        

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
                        <input class="dash-button hvr-wobble-horizontal w100" type="submit" name="editmap_btn" id="editmap_btn" value="zona de actualización" />
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
            $.post('getData.php',{mode:'<?php echo base64_encode('getcordeinatesDetails');?>',a:'<?php echo $_GET["map_id"];?>'},function(response){
                var obj = jQuery.parseJSON(response);
		if(obj['dataa'] == '' || obj['dataa'] == null){juctChkmap();}
                else
                {
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
		// ---- circle------			
				if(obj['dataa']['circle'] === 'undefined' || obj['dataa']['circle'] === undefined)
				{}
				else
				{
					var circle = obj['dataa']['circle'];
					for (var i = 0; i < circle.length; i++)
					{
							var cordinated = circle[i].cordinatess;
							var coords = cordinated;
							var coords = cordinated;
							tmp_coords = getDataFromArray(coords);
							var getbounds = loadCircle(tmp_coords[0], tmp_coords[1], parseInt(tmp_coords[2]),circle[i].cordinate_title);
							objectsBounds.union(getbounds);
					}
				}
			//--  - --line  ----------
			if(obj['dataa']['line'] === 'undefined' || obj['dataa']['line'] === undefined)
				{}
				else
				{
					var line = obj['dataa']['line'];
					for (var i = 0; i < line.length; i++)
					{
							var cordinated = line[i].cordinatess;
							var coords = cordinated;
							tmp_coords = getPathFromCoordsArray(coords);
							var getbounds = loadPolyline(tmp_coords, line[i].cordinate_title);
							objectsBounds.union(getbounds);
					}
				}
			// ----------polygon------	
			if(obj['dataa']['polygon'] === 'undefined' || obj['dataa']['polygon'] === undefined)
				{}
				else
				{
                                    
					var polygon = obj['dataa']['polygon'];
					for (var i = 0; i < polygon.length; i++)
					{
							var cordinated = polygon[i].cordinatess;
							var coords = cordinated;
							tmp_coords = getPathFromCoordsArray(coords);
							var getbounds = loadPolygon(tmp_coords,polygon[i].cordinate_title);
							objectsBounds.union(getbounds);  
					}
				}
				
				map.fitBounds(objectsBounds); juctChkmap();
                            }
            });
        });
		
	function juctChkmap()
        {
            var polyy = $('#poly_0').val();	
        //alert(polyy+'--nj')
        if(polyy == '' || polyy == null)
        {
            $("#njGetNew").removeClass("hide_poly");
            $("#njGetNew").addClass("show_poly");
        }
        }
    </script>
    <script type="text/javascript">
    $("#poly_0_delete").click(function(){
        alert("Se hace clic en el párrafo.");
    });
    </script>
</body>
</html>
