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
            <h1 class="txt-style-1">Super Administrator Hi Taxi</h1>
            <div class="c-acc-status mgr">
              <h2 class="txt-style-3">Administrators</h2>
              <form method="post" name="search" action="">
                <div class="row">
                  
               
                  <div class="col-sm-4 col-sm-offset-4 rr1">
                  <div class="form-group">
                     <label> Name </label>
                     <input type="text" name="txtname" class="input-style" placeholder="Name" value="<?php echo $_POST['txtname']?>"/>
                      
                    </div>
                  </div>
                </div>
                <div class="row bts">
                	<div class="col-sm-4 col-sm-offset-2">
                            <button class="dash-button hvr-wobble-horizontal w100 f74" type="submit" name="submit">Search</button>
                    </div>
                    <div class="col-sm-4">
                    	<a href="<?php echo SUPER_ADMIN_URL?>add-account-administrator.php" class="dash-button hvr-wobble-horizontal w100 f74">Add New Administrator</a>
                    </div>
                </div>
              </form>
            </div>
            <div class="c-acc-status mg5 bst">
	<table id="viewAdministrator" class="display select" cellspacing="0" width="100%">
   <thead>
      <tr>
         <th width="5%" class="tab-txt1">#</th>
         <th width="10%" class="tab-txt1">Name</th>
         <th width="10%" class="tab-txt1">Email</th>
         <th width="20%" class="tab-txt1">Contact No</th>
         <th width="15%" class="tab-txt1">CREATED</th>
         <!-- <th width="15%" class="tab-txt1">Estado de ingreso</th> -->
         <th width="10%" class="tab-txt1">#Zone Allot</th>
         <th width="10%" class="tab-txt1">#Centrals Allot</th>
         <th width="10%" class="tab-txt1">#Taxis Allot</th>
         <th width="10%" class="tab-txt1">#Total Trips</th>
         <th width="10%" class="tab-txt1">#Payments</th>
         <th width="10%" class="tab-txt1">Action</th>
      </tr>
   </thead>
   <?php 
    if (isset($_POST['submit'])) {
	echo $result_search = '<p># Buscar: <strong>"'.$_POST['txtname'].'" </strong><p>';	
       if ($_POST['txtname'] != '') {
           $fname = " AND name LIKE '%" . $_POST['txtname'] . "%'";
       } else {
           $fname = '';
       }
   }
   $query = "select * from `login` where 1 and account_type = '2' $fname ORDER BY id DESC";
   $result = mysql_query($query) or die();
   $num_rows = mysql_num_rows($result);
   if($num_rows>0){
   $i = 0;
   //$location = array();
    $tripAmmount = "";

   while ($row = mysql_fetch_assoc($result))
   {
      
      $payment = "select * from manage_master_amount where zone_id = '".$row['id']."' ";
      $resPayment = mysql_query($payment);
      $countPayment="";

      $nj = '0';
        $njData = mysql_query("SELECT 
IF(zone_id=0 || zone_id='".$row['id']."', sum(amount), '0') as nj, company_id,sum(amount)
 FROM `manage_master_amount` where 1 and `company_id` in (select company_id FROM `manage_master_amount` where 1 and `zone_id` = '".$row['id']."') group by zone_id");
        while($getSum = mysql_fetch_array($njData))
        {
          $nj = $nj + $getSum['nj'];
        }
        // echo $nj.'----nj total---'.$row['id'].'<br/>';
     

      $njDriv = '0';
        $njData = mysql_query("SELECT sum(trip_ammount) as nj,driver_id FROM `trip` where 1 and driver_id in (SELECT id FROM  `driver` where 1 and `company_id` in (select company_id FROM  `manage_master_amount` where 1 and `zone_id`='".$row['id']."'))   group by driver_id");
        while($getSum = mysql_fetch_array($njData))
        {
          $njDriv = $njDriv + $getSum['nj'];
        }
        // echo $njDriv.'----nj total---'.$row['id'].'<br/>';

         




      $zoneTotal=mysql_query("select id from zone_area where allot_to='".$row['id']."'");
      $zoneTotal1=mysql_num_rows($zoneTotal);

      $central = mysql_query("Select id,account_type,added_by from login where account_type = '4' and added_by ='".$row['id']."'");
      $central1=mysql_num_rows($central);
        while($driverTotal=mysql_fetch_array($central))
        {
       //   $driverCount = "";
          // echo "select id,company_id from driver where company_id = '".$driverTotal['id']."' ";
          // echo "<br>";
        $driver = mysql_query("select id,company_id from driver where company_id = '".$driverTotal['id']."' ");
        $driver1 = mysql_num_rows($driver);
        // while($nyDriver=mysql_fetch_array($driver))
        // {
        //    //echo $nyDriver['id'];
        //    $travel = mysql_query("select trip_ammount,driver_id from trip where driver_id = '".$nyDriver['id']."' ");
        //       while($travel_ammount=mysql_fetch_array($travel))
        //       {
        //        $tripAmmount += $travel_ammount['trip_ammount'];
        //       }
        //       //echo $tripAmmount."<br>";
          
        // }
       
          // while($nyDriver=mysql_fetch_array($driver))
          // {
          //  $driverCount[] = $nyDriver['id'];
          //    // $travel = mysql_query("select trip_ammount,driver_id from trip where driver_id = '".$driverCount."' ");
          //    // $tripAmmount = "";
          //    //  while($travel_ammount=mysql_fetch_array($travel))
          //    //  {
          //    //    $tripAmmount += $travel_ammount['trip_ammount'];
          //    //  }
          // }
        
       
          // for($i=0;$i<count($driverCount);$i++)
          //   {
          //     //echo $driverCount[$i]."driver";
              
          //     $travel = mysql_query("select trip_ammount,driver_id from trip where driver_id = '".$driverCount[$i]."' ");
          //     $tripAmmount = "";
          //     while($travel_ammount=mysql_fetch_array($travel))
          //     {
          //       $tripAmmount += $travel_ammount['trip_ammount'];
          //     }
          //      //$tripAmmount1 = $tripAmmount;
          //   }

         }
      $i++;
       if ($row['login_status'] == 0) {
           $logg = 'LogOff';
       } else {
           $logg = 'LogIn';
       }
       $linkss = '<a href="view-account-administrator.php?a=' . $row["id"] . '" title="View" class="" data-original-title="View"> <span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span></a>
	<a href="javascript:;" title="Delete" data-toggle="modal" data-target="#myModal'.$row['id'].'"  class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Edit"><i class="fa fa-times fa-1x"></i></a>
';
      // $location[] = array($i, $row['name'], $row['email'], $row['contact_number'], date("d M Y h:i a", strtotime($row['added_on'])), $logg, $linkss);


   
   ?>
    <tr>
        <td class="tab-txt2"><?php echo $i;?></td>
        <td class="tab-txt2"><?php echo $row['name'];?></td>
        <td class="tab-txt2"><?php echo $row['email'];?></td>
        <td class="tab-txt2"><?php echo $row['contact_number'];?></td>
        <td class="tab-txt2"><?php echo date("d M Y h:i a", strtotime($row['added_on']));?></td>
        <!-- <td class="tab-txt2"><?php //echo $logg;?></td> -->
        <td class="tab-txt2"><?php echo $zoneTotal1;?></td>
        <td class="tab-txt2"><?php echo $central1;?></td>
        <td class="tab-txt2"><?php echo $driver1;?></td>
        <td class="tab-txt2"><?php echo $njDriv;?></td>
        <td class="tab-txt2"><?php echo $nj;?></td>
        <td class="tab-txt2"><?php echo $linkss;?></td>
    </tr>
    <div class="modal fade" id="myModal<?php echo $row["id"]; ?>" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Deleted User</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete this user details</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="deleteDrivers" onClick="return deleteWorkZoneAdministartor(<?php echo $row['id'] ?>);">SI</button>  
                </div>
            </div>
        </div>
    </div>
    <?php } }else{ ?>
    <tr>
        <td style="color: red; padding:10px" colspan="7">No Records found</td>
    </tr>
    <?php }?>
   
  
</table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
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
         'url': "getData.php?mode=<?php echo base64_encode('getZoneAdministratorDetails'); ?>" 
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

function deleteWorkZoneAdministartor(a)
{
	swal({
		title: "Delete",
		text: "Los detalles de administrador fueron eliminados",
		type: "Advertencia",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Si, eliminar',
		closeOnConfirm: false
		},
		function(){
			$.post('getData.php',{mode:'<?php echo base64_encode('deleteZonesAdministrator');?>',a:a},function(response){	
			swal("Eliminado", "Los detalles de administrador fueron eliminados", "Éxito");
			window.location.href = '<?php echo SUPER_ADMIN_URL;?>administrators.php';
		});
	});
	return false;
}
</script>