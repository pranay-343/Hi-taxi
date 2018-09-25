<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">PAYMENT TAXI DRIVER</h2>
              <form action="td-pay-confirm.php" method="POST">
				<div class="row">
					<!--<div class="col-md-4"> </div>-->
                    <div class="col-md-7">
                    <div class="form-group">
                    	<label>TAXI DRIVER </label>
						<select name="txtDriName" id="txtDriName" class="lkj">
						<option value="">Select Driver Name</option>
						<?php $query_to_driver = "SELECT trip.id as tripId,trip.driver_id,trip.trip_type,trip.payment_to_driver,trip.customer_id as corporateUserId,driver.name as driverName,driver.added_by as driverAddedBy,account.payment_amount, account.payment_mode,account.add_on as addedDate, users.name as corporateName FROM trip LEFT JOIN driver ON trip.driver_id = driver.id LEFT JOIN account ON trip.id = account.trip_id LEFT JOIN users On trip.customer_id = users.id WHERE trip.trip_type='corporate' AND trip.account_type='99'  AND driver.added_by = '".$_SESSION['uid']."' AND account.payment_mode!='cash' GROUP BY trip.driver_id";
				$result_to_driver = mysql_query($query_to_driver);
				$num_rows = mysql_num_rows($result_to_driver);					
				if(isset($num_rows) && $num_rows>0){
				while($row = mysql_fetch_array($result_to_driver)){?>
						<option value = "<?php echo $row['driverName'];?>"> <?php echo $row['driverName']?></option>
				<?php }}?>
						</select>
                    	<!--<input type='text' class='input-style' placeholder="Enter Text Here"  name="txtDriName"/>-->
                    </div>
                    </div>
                    <div class="col-md-5" style="text-align:center;">
                            <!-- <a href="<?php echo TAXI_URL; ?>td-pay-confirm.php" class="dash-button hvr-wobble-horizontal">Continue</a> -->
                        <button class="dash-button hvr-wobble-horizontal" onclick="return confirm('Are you sure?');" name="driverData">Continue</button>
                    </div>
               
                </div>
                          
              <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="margin-top:40px;">
              <tr>
                <th width="7%" class="tab-txt1">QUANTITY</th>
                <th width="20%" class="tab-txt1">Date and time</th>
                <th width="10%" class="tab-txt1">CORPORATION</th>
                <th width="11%" class="tab-txt1">STATUS</th>
                <th width="10%" class="tab-txt1">Taxi Driver</th>
                <th width="10%" class="tab-txt1">More Information</th>
              </tr>
               <?php        
                /*if(isset($_POST['submit'])) {
					if($_POST['travel']!=''){
						$name = "AND driver.name LIKE '%" . $_POST['txtDriName'] . "%'";
					}
                } else {
                    $name = '';
                }
                    $driver_detail ="SELECT driver.id as driverId, driver.name as driverName,driver.added_on as driverDate, trip.*, account.* FROM driver LEFT JOIN trip ON driver.id = trip.driver_id LEFT JOIN account ON trip.id = account.trip_id"
                            . " WHERE company_id='".$_SESSION['uid']."' $name $date AND driverType='trip'";
                        $result_driver = mysql_query($driver_detail);
                        $num_rows = mysql_num_rows($result_driver);
						
                        if(isset($num_rows) && $num_rows>0){
                       while($row = mysql_fetch_array($result_driver)){*/
				$query_to_driver = "SELECT trip.id as tripId,trip.driver_id,trip.trip_type,trip.payment_to_driver,trip.customer_id as corporateUserId,trip.trip_ammount,trip.tripdatetime,driver.name as driverName,driver.added_by as driverAddedBy, users.name as corporateName FROM trip LEFT JOIN driver ON trip.driver_id = driver.id  LEFT JOIN users On trip.customer_id = users.id WHERE trip.trip_type='corporate' AND trip.account_type='99'  AND driver.added_by = '".$_SESSION['uid']."'  ORDER BY trip.tripdatetime DESC";
				$result_to_driver = mysql_query($query_to_driver);
				$num_rows = mysql_num_rows($result_to_driver);					
				if(isset($num_rows) && $num_rows>0){
				while($row = mysql_fetch_array($result_to_driver)){
                             
            ?>
              <tr>
				<td class="tab-txt2"><?php echo $row['trip_ammount']?></td>
				<td class="tab-txt2"><?php  echo date('Y-m-d', strtotime($row['tripdatetime']));?></td>
				<td class="tab-txt2"><?php echo $row['corporateName'];?></td>
				<td class="tab-txt2"><?php if($row['payment_to_driver']=='0'){echo 'Pending';}else{echo 'Paid';}?></td>
				<td class="tab-txt2"><?php echo $row['driverName'];?></td>
				<td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($row["tripId"]);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
              </tr>
				<?php } }else{?>     
				<tr>
					<td style="color: red; padding: 10px;" colspan="5"> No Records Found</td>
				</tr>
			<?php }?>
            </table>
          </div>
          
          
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewAdministrator').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getAccountAdministratorDetails'); ?>" 
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

  

});

function deleteTaxiCompany(a,b)
{
    alert('Estamos trabajando…');
    swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles de la central y todos los conductores, viajes y otros detalles también serán eliminados",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        swal("Eliminado", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}
</script>
</body>
</html>
