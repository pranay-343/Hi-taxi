<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';
$zoneId = $_GET['a']; 
$query = mysql_query("select * from `zone_area` where 1 and id='".$zoneId."'");
$response = mysql_fetch_assoc($query);
$num_row = mysql_num_rows($query);
if($num_row == 0){
    echo '<script> alert("Esta zona no está disponible en la lista");</script>';
    HTMLRedirectURL(SUPER_ADMIN_URL.'work-zone.php');    
}
$zone_admin_id = $response['allot_to'];
$zone_title= base64_decode($response['zone_title']);
$zone_description=base64_decode($response['zone_description']);

$qryLog = mysql_query("select * from `login` where 1 and id='".$zone_admin_id."'");
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
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>

    </div>
          <div class="col-sm-9 sebs scd">
    <div class="container">
         <h1 class="txt-style-1">Administrador Hi Taxi</h1>
            <div class="c-acc-status mgr">
              <h2 class="txt-style-3">Administrador Hi Taxi</h2>
              </div>
              <div id="errorMessage"></div>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="jumbotron">
        <div class="col-sm-4" style="float:right">
        <p>Administrator Name : <b><?php echo $result['name'];?></b></p>
        </div>
        
            <p>Zone Name : <strong><?php echo $zone_title;?></p>
            <div class="row">
                <p>Description : <strong><?php echo $zone_description;?></strong></p>
           <div class="index_table" id="checkboxArea">
           </div>
                <div class="tyt">
                    <button type="button" class="btn btn-primary btn-xs" id="edit_map_158" href="#" onClick="return checkAdminLoginPassword();">Edit Zone</button>
                    <a type="button" class="btn btn-danger btn-xs" id="del_map_158" href="#" onClick="return deleteZoneAdministrator(<?php echo $zoneId;?>,'delete');">Edit Zone Administrator</a>
                    </div>
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
        <script>
        $(document).ready(function(){
			var objectsBounds = new google.maps.LatLngBounds();
            var tmp_coords = [];
            $.post('getData.php',{mode:'<?php echo base64_encode('getcordeinatesDetails');?>',a:'<?php echo $_GET["a"];?>'},function(response){
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
				
				map.fitBounds(objectsBounds); 
            });
        });
		
		function deleteZoneAdministrator(a,b)
		{
			swal({
				title: "¿Estas seguro?",
				text: "Usted no va a poder recuperar los detalles del Administrador de Zona. Y toda la información relacionada va a ser eliminada.",
				type: "Advertencia",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Si, eliminar',
				closeOnConfirm: false
			  },
			  function(){
				  $.post('getData.php',{mode:'<?php echo base64_encode('deleteZonesAdministrator');?>',a:a},function(response){	
			 		swal("Eliminado", "Los detalles de su administrador de la zona ha sido suprimido!", "Éxito");
					window.location.href = '<?php echo SUPER_ADMIN_URL;?>work-zone.php';
				 });
			  });
			return false;
		}
		
		
		function checkAdminLoginPassword()
		{
			var promptCount = 0;
			window.pw_prompt = function(options) {
				var lm = options.lm || "Password:",
					bm = options.bm || "Submit";
				if(!options.callback) { 
					alert("Sin función de devolución de llamada proporcionado! Por favor proporcionar una.") 
				};
							   
				var prompt = document.createElement("div");
				prompt.className = "pw_prompt";
				
				var submit = function() {
					options.callback(input.value);
					document.body.removeChild(prompt);
				};
			
				var label = document.createElement("label");
				label.textContent = lm;
				label.for = "pw_prompt_input" + (++promptCount);
				prompt.appendChild(label);
			
				var input = document.createElement("input");
				input.id = "pw_prompt_input" + (promptCount);
				input.type = "password";
				input.addEventListener("keyup", function(e) {
					if (e.keyCode == 13) submit();
				}, false);
				prompt.appendChild(input);
			
				var button = document.createElement("button");
				button.textContent = bm;
				button.addEventListener("click", submit, false);
				prompt.appendChild(button);
				document.body.appendChild(prompt);
			};
			
			var nj = '0';
			pw_prompt({
				lm:"Please enter the passowrd:", 
				callback: function(password) {
					$.post('getData.php',{mode:'<?php echo base64_encode('checkAdminPassword');?>',a:password},function(response){
						nj = response;
						if(nj == '1')
						{
							alert('correct password. Changes may take 24 hours to take effect');
							doMap(<?php echo $zoneId;?>,'edit');
							return true;
						}
						else
						{
							alert('Your username password does not match ...!');
							return false;
						}
					});
				}
			});
			return false;
		}		
		
		
    </script>
  </body>
</html>
