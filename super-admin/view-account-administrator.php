<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';
$zoneId = $_GET['a']; 
$query = mysql_query("select * from `login` where 1 and id='".$zoneId."'");
$response = mysql_fetch_assoc($query);

?>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Administrador</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Editar Administrador</h2>
              <div id="errorMessage">
<?php 
if(isset($_POST['addmap_btn']) and $_POST['addmap_btn']!=""){
updateAdministrator();
unset($_POST);
}
?>
              </div>
              <form method="post" onSubmit="return addAdministrator();" enctype="multipart/form-data">
				
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>NOMBRE </label>
                   <input type="text" name="name" id="name" class="input-style" placeholder="Introduce el nombre aquí" required value="<?php echo $response['name'];?>">
                     <div class="help-block with-errors"></div>
                    </div>
                  </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                     <label> NÚMERO DE CONTACTO </label>
                      <input type="text" name="contactno" id="contactno" class="input-style" placeholder="Introduzca Número de contacto" required value="<?php echo $response['contact_number'];?>" onKeyPress="return IsNumericNumber(event);">
					  <span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label> Email </label>
							<input type="email" name="emailID" required id="emailID" class="input-style" placeholder="Introducir e-mail-id aquí" required value="<?php echo $response['email'];?>">
							<div class="help-block with-errors"></div>
						</div>
				    </div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>CONTRASEÑA</label>
							<input type="text" name="password" required id="password" class="input-style input-style1" placeholder="Introduzca la contraseña aquí" required value="<?php echo $response['password_de']?>">
							<input type="hidden" name="password_hi" id="password_hi" class="input-style input-style1" placeholder="Introduzca el texto aquí" value="<?php echo $response['password_de']?>">
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-sm-6">
						<div class="form-group">
							<label>NUEVA CONTRASEÑA </label>
							<input type="password" name="newpassword"  id="newpassword" class="input-style" placeholder="Introduzca la contraseña aquí" value="">
							<div class="help-block with-errors"></div>
						</div>
					</div>
				</div>
             
        <style type="text/css">
            input[type="file"]{height:20px; vertical-align:top;}
            .field_wrapper div{ margin-bottom:10px;}
            .add_button{ margin-top:10px; margin-left:10px;vertical-align: text-bottom;}
            .remove_button{ margin-top:10px; margin-left:10px;vertical-align: text-bottom;}
        </style>
          <div class="field_wrapper">
          <?php
		  $qryFIles = mysql_query("select * from `files_upload` where login_id = '".$_GET['a']."'");
          while($dataFiles = mysql_fetch_array($qryFIles))
		  {
		  ?>
          <div>
            <?php echo $dataFiles['name'];?> &nbsp;<a href="upload_file/<?php echo $dataFiles['file_name'];?>" download><i class="fa fa-download"></i></a>
          </div>
          <?php
		  }
          ?>
          <div>
          <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
          <input type="file" name="file_name[]" class="input03" multiple="multiple">
          
             <div style="clear:both;"></div>
          </div>
            </div>
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addAdministrator');?>" />
                <input type="hidden" name="administratorId" id="administratorId" value="<?php echo $_GET['a'];?>" />
                <input class="dash-button hvr-wobble-horizontal w100 disabled" type="submit" name="addmap_btn" id="addmap_btn" value="Editar administrador" style="pointer-events: all; cursor: pointer;">
              </form>
            </div>
            
          
            
          <h3>Zonas Asignadas</h3>
          <div class="bst">
              <table id="datatable" class="ctabel1" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th width="25%" class="tab-txt1">Nombre</th>
                          <th width="25%" class="tab-txt1">Descripcion</th>
                          <th width="25%" class="tab-txt1">Fecha creacion</th>
                      </tr>
                    </thead>
                  
                  <tbody>
                      <?php
                        $query_zone_allot  = "SELECT * FROM zone_area WHERE allot_to = $zoneId";
                             $result_zone_allot = mysql_query($query_zone_allot);
                             $num_rows = mysql_num_rows($result_zone_allot);
                             if($num_rows>0){
                                 while ($row_zone_allot = mysql_fetch_array($result_zone_allot)) {
                      ?>
                      <tr>
                          <td class="tab-txt2"><?php echo base64_decode($row_zone_allot['zone_title']);?></td>
                          <td class="tab-txt2"><?php echo base64_decode($row_zone_allot['zone_description']);?></td>
                          <td class="tab-txt2"><?php echo ($row_zone_allot['added_on']);?></td>
                      </tr>
                       <?php } }else{?>

                      <tr>
                          <td style="color: red; padding:10px" colspan="4"> ning�n record fue encontrado</td>
                      </tr>
                      <?php }?>

                  </tbody>
              </table>
          </div>
          
          
          <br/> <br/> <br/><h3>Taxi Centrales</h3>
          <div class="bst">
              <table id="datatable_central" class="ctabel1" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th width="25%" class="tab-txt1">Nombre Central</th>
                          <th width="25%" class="tab-txt1">Nombre Zona</th>
                          <th width="25%" class="tab-txt1">Fecha Creacion</th>
                      </tr>
                    </thead>
                  
                  <tbody>
                      <?php
                        $query_central  = "SELECT * FROM login WHERE added_by = $zoneId";
                             $result_central = mysql_query($query_central);
                             $num_rows_central = mysql_num_rows($result_central);
                             if($num_rows_central>0){
                                 while ($row_central = mysql_fetch_array($result_central)) {
                      ?>
                      <tr>
                          <td class="tab-txt2"><?php echo $row_central['name'];?></td>
                          <td class="tab-txt2"><?php echo $response['name'];?></td>
                          <td class="tab-txt2"><?php echo $row_central['added_on'];?></td>
                      </tr>
                       <?php } }else{?>

                      <tr>
                          <td style="color: red; padding:10px" colspan="4"> ning�n record fue encontrado</td>
                      </tr>
                      <?php }?>

                  </tbody>
              </table>
          </div>
          
          <br/> <br/> <br/><h3>Taxies </h3>
          <div class="bst">
              <table id="datatable_driver_trip" class="ctabel1" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th width="25%" class="tab-txt1">Nombre del conductor</th>
                          <th width="25%" class="tab-txt1">Nombre Central</th>
                          <th width="25%" class="tab-txt1">Fecha creacion</th>
                          <th width="25%" class="tab-txt1">Estado Conductor</th>
                      </tr>
                    </thead>
                  
                  <tbody>
                      <?php
                      $centralIds = '';
                        $query_central_id  = (mysql_query("SELECT id FROM login WHERE added_by = $zoneId"));
                        while ($row_ids = mysql_fetch_array($query_central_id)) {
                            $centralIds[] = $row_ids['id'];                            
                        } 
                        if($centralIds!=''){
                        $centralIds = implode(',', $centralIds);
                        
                            $driver_detail = "SELECT * FROM driver where company_id IN($centralIds)";
                            $result_driver = mysql_query($driver_detail);
                            $num_rows_driver = mysql_num_rows($result_driver);
                             
                            if($num_rows_driver>0){
                                while ($row_driver = mysql_fetch_array($result_driver)) {
                      ?>
                      <tr>
                          <td class="tab-txt2"><?php echo $row_driver['name'];?></td>
                          <td class="tab-txt2"><?php echo $response['name'];?></td>
                          <td class="tab-txt2"><?php echo $row_driver['added_on'];?></td>
                          <td class="tab-txt2"><?php if($row_driver['login_status'] == 0){echo 'Log Off';}else{echo 'Log In';}?></td>
                      </tr>
                       <?php } } }else{?>

                      <tr>
                          <td style="color: red; padding:10px" colspan="4"> No hay resultados</td>
                      </tr>
                      <?php }?>

                  </tbody>
              </table>
          </div>
          
          
          <br/> <br/> <br/><h3>Viajes de Taxis de hoy</h3>
          <div class="bst">
              <table id="datatable_driver" class="ctabel1" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                          <th width="25%" class="tab-txt1">Nombre del conductor</th>
                          <th width="25%" class="tab-txt1">Fecha de Viaje</th>
                          <th width="25%" class="tab-txt1">Origen - Destino </th>
                          <th width="25%" class="tab-txt1">Precio</th>
                      </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th width="25%" class="tab-txt1">Nombre del conductor</th>
                            <th width="25%" class="tab-txt1">Trip Fecha creacion</th>
                            <th width="25%" class="tab-txt1">Origen - Destino</th>
                            <th width="25%" class="tab-txt1">Precio</th>
                        </tr>
                    </tfoot>
                  
                  <tbody>
                      <?php
                        $curr_date = date('Y-m-d');
                     //   echo "SELECT driver_id, id FROM trip_log WHERE date LIKE '%$curr_date%' AND `zone_type` LIKE '%In%' GROUP BY driver_id";
                        $query_driver_id  = (mysql_query("SELECT driver_id, id FROM trip_log WHERE date LIKE '%$curr_date%' AND `zone_type` LIKE '%In%' GROUP BY driver_id"));
                        if(mysql_num_rows($query_driver_id) > 0){
                        while ($row_ids = mysql_fetch_array($query_driver_id)) {
                            $driverIds[] = $row_ids['driver_id'];                            
                        }                        
                        $driverIds = implode(',', $driverIds);
                        
                        $trip_driver_detail = "SELECT trip.*, driver.name FROM trip LEFT JOIN driver ON trip.driver_id = driver.id where trip.driver_id IN($driverIds) AND trip.tripdatetime LIKE '%$curr_date%' and trip_type =  'corporate'";
                             $result_driver_trip = mysql_query($trip_driver_detail);
                             $num_rows_driver = mysql_num_rows($result_driver_trip);
                             if($num_rows_driver>0){
                                 while ($row_driver_trip = mysql_fetch_array($result_driver_trip)) { 
                                     $totalamt[]  = $row_driver_trip['trip_ammount'];
                                     
                                     //echo $totalamt.'------';
                      ?>
                      <tr>
                          <td class="tab-txt2"><?php echo $row_driver_trip['name'];?></td>
                          <td class="tab-txt2"><?php echo $row_driver_trip['tripdatetime'];?></td>
                          <td class="tab-txt2"><?php  if($row_driver_trip['endTrip_sourceaddress']){echo $row_driver_trip['endTrip_sourceaddress'];}else{
                           $row_driver_trip['source_address'];   
                          }
                          echo ' - ';
                          if($row_driver_trip['endTrip_destinationaddress']){echo $row_driver_trip['endTrip_destinationaddress'];}else{echo $row_driver_trip['destination_address']; }
                            
                          
                          ?></td>
                          <td class="tab-txt2"><?php echo $row_driver_trip['trip_ammount'].CURRENCY ; //if($row_driver_trip['login_status'] == 0){echo 'Log Off';}else{echo 'Log In';}?></td>
                      </tr>
                      <?php //print_r($totalamt);echo 'AAAAAAAAA';?>
                        <?php } } }else{?>

                      <tr>
                          <td style="color: red; padding:10px" colspan="4">No hay resultados</td>
                      </tr>
                      <?php }?>

                  </tbody>
              </table>
          </div>
           <br/> <h3>Ganancias de hoy</h3>
           
           <p class="bottom_total">Cantidad total : 
               <?php
               if($totalamt == "" || $totalamt == null)
               {
                     echo CURRENCY.'0';
               }
               else
               {
                $amt = array_sum($totalamt); 
                     echo CURRENCY.$amt;
                }
                ?>
           </p>
          </div>  
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
</body>
</html>
<!-- add doc support -->
<script type="text/javascript">

 // Validation for number or credit limit         
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumericNumber(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
$(document).ready(function () {
	var maxField = 20; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><input type="file" name="file_name[]" class="input03" multiple="multiple"><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function () { //Once add button is clicked
		if (x < maxField) { //Check maximum number of input fields
		x++; //Increment field counter
		$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});

$(document).ready(function() {
        $('#datatable').DataTable();
        $('#datatable_central').DataTable();
        $('#datatable_driver').DataTable();
        $('#datatable_driver_trip').DataTable();
        // $('#datatable_driver_trip').DataTable({
        //    "bRetrieve":true,
        //    "bJQueryUI":true,
        //    "sPaginationType": "full_numbers"
            
        // });

});
</script>
<style type="text/css">
span.icon-span-filestyle{ display:none !important;}
.btn-primary{ background:#e0e0e0 !important; border:1px #CCC solid !important;}
</style>
