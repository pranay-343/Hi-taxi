<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body class="popup_designm1">
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">SuperAdmin Hi Taxi</h1>
            <div class="c-acc-status mgr">
              <h2 class="txt-style-3">Working Area</h2>
              <form method="post" action="">
                <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                    <label> Zone Name </label>
                    <input type="text" name="txtname" id="searchid_1" class="input-style" placeholder="Enter Text Here" />
                    <!--<input type='hidden' name="driverEmail" class='input-style' id="searchid"/> -->
                    <span id="zone_areaa"></span>
                     
						<!--<select name="txtname" id="txtname" class="input-style">
							<option value="" selected="selected">Seleccionar Zona</option>
							<?php $query = mysql_query("SELECT zone_title, id FROM zone_area ");
									$num_rows = mysql_num_rows($query);
									if($num_rows>0){
										while($data = mysql_fetch_array($query)){
									
							?>
							<?php if(isset($_POST['submit'])){ (isset($_POST["txtname"])) ? $zone_title = $_POST["txtname"] : $zone_title=base64_decode($data['zone_title']);}?>
							<option <?php if ($zone_title == base64_decode($data['zone_title'] )){ echo 'selected' ;} ?>  value="<?php echo base64_decode($data['zone_title']);?>"><?php echo base64_decode($data['zone_title']);?></option>
							<?php } }?>
						 </select>-->	
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     
                      <label>Administrador </label> 
                      <input type="text" name="txtAdminName" id="searchid" class="input-style" id="se" placeholder="Enter Text Here" />
                      <span id="party_id"></span>
					  <!--<select name="txtAdminName" id="txtAdminName" class="input-style">
							<option value="" selected="selected">Seleccionar Administrador</option>
							<?php $query_zone_name = mysql_query("SELECT zone_title, zone_area.id, login.id as zoneId, login.name as zone_name FROM zone_area LEFT JOIN login ON zone_area.allot_to = login.id GROUP BY login.name");
									$num_rows_zone_name = mysql_num_rows($query_zone_name);
									if($num_rows_zone_name>0){
										while($data = mysql_fetch_array($query_zone_name)){
									
							?>
							<?php  if(isset($_POST['submit'])){(isset($_POST["txtAdminName"])) ? $zone_name = $_POST["txtAdminName"] : $zone_name=$data['zone_name']; }?>
							<option <?php if ($zone_name == $data['zone_name'] ){ echo 'selected' ;} ?> value="<?php echo ($data['zone_name']);?>"><?php echo ($data['zone_name']);?></option>
							<?php } }?>
						 </select>-->	
                    </div>
                  </div>
                </div>
                <div class="row bts">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="dash-button hvr-wobble-horizontal w100 f74 wer" type="submit" name="submit">Apply Filters</button>
                    </div>
                    <div class="col-sm-4">
                    	<a href="<?php echo SUPER_ADMIN_URL?>add-zone-administrator.php" class="dash-button hvr-wobble-horizontal w100 f74 wer">Create Work Zone</a>
                    </div>
                </div>
              </form>
            </div>
            <div class="c-acc-status mg5 bst">
            	<table width="100%" id="viewAdministrator" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                            <th width="5%" class="tab-txt1">#</th>
                            <th width="20%" class="tab-txt1">Name</th>
                            <th width="20%" class="tab-txt1">Administrador</th>
                            <th width="10%" class="tab-txt1">Centrals</th>
                            <th width="10%" class="tab-txt1">Taxis</th>
                            <th width="10%" class="tab-txt1">Trips</th>
                            <th width="15%" class="tab-txt1">Earnings</th>
                            <th width="30%" class="tab-txt1">Action</th>
                        </tr>
                    </thead>
					
                    <?php 
                        if (isset($_POST['submit'])) {
                          
                            echo '<p>#Search For: <strong>"'.$_POST['txtname'].'"  "'.$_POST['txtAdminName'].'"</strong><p>';
                            //(base64_encode($_POST['txtname']));
                            if ($_POST['txtname'] != '') {
                                $zoneTitle = " AND zone_title LIKE '%" . base64_encode($_POST['txtname']) . "%'";
                            }
                            else{
                                $zoneTitle = " AND z.zone_title != ''";
                            }
                            if ($_POST['txtAdminName'] != '') {
                                $adminName = " AND name LIKE '%" . $_POST['txtAdminName'] . "%'";
                            }	
                            else {
                                $adminName = '';
                            }
                        }
                        $query="select l.id,zone_title,z.id as zone_id,name from `login` as l Left Join `zone_area` as z On l.id=z.allot_to where 1 and account_type = '2' $zoneTitle $adminName and zone_title != '' ORDER BY z.id DESC";
                        $result=mysql_query($query) or die();
                        $num_rows=mysql_num_rows($result);
                        if($num_rows>0){
                        $i=0;
                        //$location=array();
                        while($row=mysql_fetch_assoc($result))
                        { 
                        $i++;
                        if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
                        $linkss = '<a href="save_create_zone.php?a='.$row["zone_id"].'" title="View" class="hov_none" data-original-title="View"><span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span>&nbsp;&nbsp;
                        <a href="javascript:;" title="Delete" data-toggle="modal" data-target="#myModal'.$row['zone_id'].'" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a>
                ';
                $zone_title = base64_decode($row['zone_title']);
                        //$location[]=array($i,$zone_title,$row['name'],'10','30','250','500',$linkss);
                        
                        //$data = array("data"=>$location);
                        //print_r(json_encode($data));
                    ?>
                    <tr>
                        <td class="tab-txt2"><?php echo $i;?></td>
                        <td class="tab-txt2"><?php echo $zone_title;?></td>
                        <td class="tab-txt2"><?php echo $row['name'];?></td>
					<?php 
					// For Total Centrals detail
					$query_central ="SELECT zone_area.id,  zone_area.added_by, taxicompany.id, taxicompany.zone_area_id_sess FROM zone_area LEFT JOIN taxicompany ON zone_area.id = taxicompany.zone_area_id_sess WHERE zone_area.added_by =  '1' AND zone_area_id_sess !=  '' AND zone_area.id = '".$row['zone_id']."'";
					$result_central = mysql_query($query_central);
					$num_central = mysql_num_rows($result_central);						
					?>
                        <td class="tab-txt2"><?php echo $num_central;?></td>
						
					<?php 
					// For total taxies
					$query_taxies = "SELECT zone_area.id,  zone_area.added_by, taxicompany.id, taxicompany.zone_area_id_sess, driver.* FROM zone_area LEFT JOIN taxicompany ON zone_area.id = taxicompany.zone_area_id_sess LEFT JOIN driver ON taxicompany.id = driver.added_by WHERE zone_area.added_by =  '1' AND zone_area_id_sess !=  '' AND zone_area.id = '".$row['zone_id']."'";
					$result_taxies = mysql_query($query_taxies);
					$num_taxies  = mysql_num_rows($result_taxies);
					?>		
                        <td class="tab-txt2"><?php echo $num_taxies?></td>
						
					<?php 
					// For total Trips
					$query_trips = "SELECT zone_area.id,  zone_area.added_by, taxicompany.id, taxicompany.zone_area_id_sess, driver.id as driverId, trip.id as tripId, trip.driver_id as tripDid FROM zone_area LEFT JOIN taxicompany ON zone_area.id = taxicompany.zone_area_id_sess LEFT JOIN driver ON taxicompany.id = driver.added_by LEFT JOIN trip ON driver.id = trip.driver_id  WHERE zone_area.added_by =  '1' AND zone_area_id_sess !=  '' AND zone_area.id = '".$row['zone_id']."' AND trip.driver_id!='' AND trip.status='500'";
					$result_trips = mysql_query($query_trips);
					$num_trips  = mysql_num_rows($result_trips);
					?>
                        <td class="tab-txt2"><?php echo $num_trips;?></td>
					<?php 
					// For total Earnings
					$query_trips = "SELECT SUM(trip.trip_ammount) as tripAmt FROM zone_area LEFT JOIN taxicompany ON zone_area.id = taxicompany.zone_area_id_sess LEFT JOIN driver ON taxicompany.id = driver.added_by LEFT JOIN trip ON driver.id = trip.driver_id  WHERE zone_area.added_by =  '1' AND zone_area_id_sess !=  '' AND zone_area.id = '".$row['zone_id']."' AND trip.driver_id!='' AND trip.status='500'";
					$result_trips = mysql_query($query_trips);
					$num_trips  = mysql_num_rows($result_trips);
					$amount = mysql_fetch_assoc($result_trips);
					$amount['tripAmt'];
					?>	
                        <td class="tab-txt2"><?php if($amount['tripAmt']){ echo '$'.$amount['tripAmt'];} else{echo '$0';}?></td>
                        <td class="tab-txt2"><?php echo $linkss;?></td>
                    </tr>
                     <div class="modal fade" id="myModal<?php echo $row["zone_id"];?>" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <!--<h4 class="modal-title">¿Estas seguro?</h4>-->
                                </div>
                                <div class="modal-body">
<!--                                    <p>Usted no va a poder recuperar los detalles del Administrador de Zona. Y toda la información relacionada va a ser eliminada.</p>-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="deleteDrivers" onClick="return deleteZoneAdministrator(<?php echo $row['zone_id'] ?>);">SI</button>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }else{ ?>
                    <tr>
                        <td style="color: red; padding:10px"  colspan="8"> No Data Available</td>
                    </tr>
                    <?php }?>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
<script>
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
<script type="text/javascript">
/*$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewAdministrator').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getworkZoneAdministratorDetails'); ?>" 
      },
      'columnDefs': [{
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '';
         }
      }],
      'order': [[1, 'asc']]
   });

  

});*/

function deleteZoneAdministrator(a)
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
</script>
</body>
</html>

<!--<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>-->
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.min.js"></script>
<link href="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.css" rel="stylesheet">
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
            $(document).ready(function(){ //alert('fdsf');
            $("#searchid").autocomplete({
                 source:'getData.php?mode=<?php echo base64_encode('getZoneAdminName');?>',
                
            select: function (event, ui) {
            $('#party_id').html(ui.item.id);
             },
                        minLength:1
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
            $(document).ready(function(){ //alert('fdsf');
            $("#searchid_1").autocomplete({
                 source:'getData.php?mode=<?php echo base64_encode('getZoneAreaName');?>',
                
            select: function (event, ui) {
            $('#zone_areaa').html(ui.item.id);
             },
                        minLength:1
                    });
                });     
</script>