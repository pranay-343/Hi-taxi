<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body class="popup_designm1">
<?php include '../include/taxi-navbar.php'; ?>
<div class="main_content">
  <div class="container pal0">
    <div class="row">
      <div class="col-sm-3 pa10">
        <?php include '../include/taxi-sidebar.php'; ?>
      </div>
        <?php
          // Sum of all travel
            $get_driver_id  = mysql_query("SELECT id FROM driver WHERE added_by = '".$_SESSION['uid']."'");
            if(mysql_num_rows($get_driver_id)>0){
                while ($rowData = mysql_fetch_array($get_driver_id)) {
                $dIds .= $rowData['id'].',';
            }
            $driIds .= rtrim($dIds,',');
        
            $sql_travel = "SELECT trip.id,trip.trip_ammount,trip.customer_id as tCusId FROM trip  WHERE driver_id IN ($driIds)  AND trip.trip_type ='corporate'";
            $res_travel = mysql_query($sql_travel);
            $rows_data = mysql_num_rows($res_travel);
            $travel_amount = 0;
            while($row=mysql_fetch_array($res_travel)){
                $travel_amount += $row['trip_ammount'];
            }  
            // Sum of all payment
            $sql_travel = "SELECT * FROM driverPayment WHERE added_by = '".$_SESSION['uid']."'";
            $res_travel = mysql_query($sql_travel);
            $rows_data = mysql_num_rows($res_travel);
            $payment_amount = 0;
            while($row=mysql_fetch_array($res_travel)){
                $payment_amount += $row['payment'];
            } 
            }
            ?>
        
      <div class="col-sm-9">
        <div class="row br1">
          <div class="col-sm-12">
            <h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
          </div>
        </div>
        <div class="c-acc-status mg5 mgt0">
          <h2 class="txt-style-3">Taxi Drivers</h2>
          <form method="post" action="">
            <div class="row bts">
              <div class="col-sm-6">
                <div class="form-group">
                  <label> Name</label>
                  <!--<input type="text" name="name" class="input-style" placeholder="Enter Name Here" value="<?php echo $_POST['name'];?>"/>-->
                  <select class="input-style" id="name" name="name">
                    <option value="" selected="selected">Select Driver</option>
                    <?php 
                            $query_dri = mysql_query("select * from `driver` where 1 and company_id='".$_SESSION['uid']."'");
                            $num_row = mysql_num_rows($query_dri);
                            if($num_row>0){
                            while($info_dri = mysql_fetch_array($query_dri)){
                    ?>
                    <?php if(isset($_POST['submit'])){ (isset($_POST["name"])) ? $name = $_POST["name"] : $name = ($data['name']);}?>
                    <option <?php if ($name == $info_dri['name']){ echo 'selected' ;} ?> value="<?php echo $info_dri['name'];?>"><?php echo $info_dri['name'];?></option>
                    <?php } } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Type</label>
                  <ul class="lft oop">
                    <li>
                      <input type="checkbox" name= "active" value="200" <?php if (!empty($_POST['active'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Active</span> </li>
                    <li>
                      <input type="checkbox" name= "inactive" value="99" <?php if (!empty($_POST['inactive'])): ?> checked="checked"<?php endif; ?>/>
                      <span>In-Active</span> </li>
                    
                  </ul>
                  <ul class="lft oop">
                  <li>
                      <input type="checkbox" name= "suspended" value="400"<?php if (!empty($_POST['suspended'])): ?> checked="checked"<?php endif; ?> />
                      <span>Suspend</span> </li>
                    <li>
                      <input type="checkbox" name="insuranceExpired" value="<?php echo date('Y-m-d')?>" <?php if (!empty($_POST['insuranceExpired'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Insurance Expired</span> </li>
                    <li>
                    <input type="checkbox" name="licenceExpired" value="<?php echo date('Y-m-d')?>" <?php if (!empty($_POST['licenceExpired'])): ?> checked="checked"<?php endif; ?>/>
                    <span>License Expired</span> </li>
                    <!--<li> <input type="checkbox" name="insuranceOverDue" value="" /> <span>Insurance Overdue</span> </li>
                    <li> <input type="checkbox" name="nopayment" value="" /> <span>Non-Payment</span> </li>-->
                  </ul>
                </div>
              </div>
            <div class="clearfix"></div>
              <div class="col-lg-12" style="text-align:center;">
                <input type="submit" id="submit" value="Search" name="submit" class="dash-button hvr-wobble-horizontal wap wera" />
                <a href="<?php echo TAXI_URL; ?>add-driver.php" class="dash-button hvr-wobble-horizontal wap wera">New Taxi Driver</a> </div>
            </div>
          </form>
          <div class="bst" style="margin-top:40px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
            <tr> 
              <!-- <th><?php echo $_SESSION['uid']; ?></th> -->
              <th class="tab-txt1">Name</th>
              <th class="tab-txt1">State</th>
              <th class="tab-txt1">Contact Number</th>
              <th class="tab-txt1">Insurance Expired</th>
              <th class="tab-txt1">Action</th>
              <!--<th class="tab-txt1">RETIRAR</th>-->
            </tr>
            <?php
            $curr_date = date('Y-m-d');
    $query = "select * from `driver` where 1 and company_id='".$_SESSION['uid']."' AND status!='404'";
	if($_POST['submit']) {
	if($_POST['name'] != ''){
		 $query .= " and driver.name like '%".$_POST['name']."%'";
	}
	
	if($_POST['active'] != '')
  {
    $active = $_POST['active'];
  }
  else
    {
      $active = '0';
    }
	if($_POST['inactive'] != '')
    { 
      $inactive = $_POST['inactive'];
    }
    else
      {
        $inactive = '0';
      }
	if($_POST['suspended'] != '')
    {
      $suspend = $_POST['suspended'];
    }
    else
      {
        $suspend = '0';
      }
    if($_POST['licenceExpired'] != '')
    {
      $licence = $_POST['licenceExpired'];
    }
    else
      {
        $licence = '';
      }

    if($_POST['insuranceExpired'] != '')
    {
      $insurance = $_POST['insuranceExpired'];
    }
    else
      {
        $insurance = '';
      }
	 if($active == "0" and $inactive == "0" and $suspend == "0")
   {

   }
   else
   {
	 $query .= " and driver.status in ($active,$inactive,$suspend)";
   }

   $query.=" OR (driver.licence_expiration_date < '$licence'";

   $query.=" OR driver.insurance_expiration_date < '$insurance')";
	 
   $query .= " AND company_id='".$_SESSION['uid']."' order by name ASC";}	
	//echo $query;
	$res = mysql_query($query);
	if(mysql_num_rows($res) > 0){
	while($data = mysql_fetch_array($res)){ 
		if($data['status'] == 200){$status = 'Active';}else if($data['status'] == 99){$status = 'Block';}else if($data['status'] == 400){$status = 'Suspended';}
                
                $startTimeStamp = date('Y-m-d',strtotime($data['insurance_expiration_date']));
                
                $now = time(); // or your date as well
                $your_date = strtotime($startTimeStamp);
                $datediff =   $your_date - $now;
                $numberDays =  floor($datediff/(60*60*24));
                
                
  ?>
            <tr>
              <td class="tab-txt2"><?php echo $data['name'];?></td>
              <td class="tab-txt2"><?php echo $status;?></td>
              <td class="tab-txt2"><?php echo $data['contact_number'];?></td>
              <td class="tab-txt2"><?php if($curr_date <=$startTimeStamp){echo $numberDays.' Days Left';}else{echo 'Expire';} ?></td>
              <td class="tab-txt2">
                  <a href="view-taxi-driver.php?a=<?php echo $data["id"];?>"> <span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span> </a>&nbsp;&nbsp;
                  <a href="javascript:void();" title="Delete" data-toggle="modal" data-target="#myModal<?php echo $data["id"];?>" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a>
              
              </td>
              <!-- <td class="tab-txt2"><a href="javascript:void(0)" onclick='return deleteDriver(<?php// echo $data["id"];?>);'> <img src="../images/remove.png"> </a></td> -->
              <!--<td class="tab-txt2"><a href="javascript:;" title="Delete" onClick="return deleteDriver1(<?php echo $data["id"];?>);" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a></td>-->
               
                    <div class="modal fade" id="myModal<?php echo $data["id"];?>" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Delete Driver</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you want to sure delete this driver</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="deleteDrivers" onClick="return deleteDriverYes(<?php echo $data["id"] ?>);">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </tr>
            <?php } } else{?>
            <tr>
              <td style="color: red; padding:10px" colspan="4"> No records found</td>
            </tr>
            <?php }?>
            
          </table>
          </div><?php //echo $driIds.'--------'.$travel_amount.'@@@@@'. $payment_amount;?>
          <div class="row spacetop">
                <h4 class="col-sm-6">Sum of all trips : <?php echo $travel_amount.CURRENCY ;?>  </h4>
                <h4 class="col-sm-6">Sum of all payments :   <?php echo $payment_amount.CURRENCY ;?></h4>
            </div><br/>
            
            
          <!-- dinesh -->
          <h3>Deleted Driver Details</h3>
          <div class="bst" style="margin-top:40px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
            <tr> 
              <!-- <th><?php echo $_SESSION['uid']; ?></th> -->
              <th class="tab-txt1">Name</th>
              <th class="tab-txt1">Calification Average</th>
              <th class="tab-txt1">More Information</th>
              <!-- <th class="tab-txt1">RETIRAR</th> -->
            </tr>
            <?php
  $query = "select * from `driver` where 1 and company_id='".$_SESSION['uid']."' AND status ='404'";
  
  $res = mysql_query($query);
  if(mysql_num_rows($res) > 0){
  while($data = mysql_fetch_array($res)){ 
    // if($data['status'] == 200){$status = 'Active';}else if($data['status'] == 99){$status = 'Block';}else if($data['status'] == 400){$status = 'Suspended';}
  ?>
            <tr>
              <td class="tab-txt2"><?php echo $data['name'];?></td>
              <td class="tab-txt2"><?php echo $data['driver_delete_date'];?></td>
              <td class="tab-txt2"><a href="view-delete-driver.php?a=<?php echo $data["id"];?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td> 
             
            </tr>
            <?php } } else{?>
            <tr>
              <td style="color: red; padding:10px" colspan="4"> No Records Found</td>
            </tr>
            <?php }?>
          </table>
          </div>
          <!-- dinesh -->
          
          <!-- dinesh -->
          <h3>Average Driver Rating</h3>
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
            <tr> 
              <th class="tab-txt1">Name</th>
              <th class="tab-txt1">Average Calification</th>
              <th class="tab-txt1">More Information</th>
            </tr>
            <?php
                $query = "select * from `driver` where 1 and company_id='".$_SESSION['uid']."'";
                $res = mysql_query($query);
                if(mysql_num_rows($res) > 0){
                while($data = mysql_fetch_array($res)){ 
                  
                ?>
            <tr>
              <td class="tab-txt2"><?php echo $data['name'];?></td>.
              <?php 
                // error_reporting(E_ALL);
                $get_trip_detail = "SELECT  SUM(customer_rating) as rating, COUNT(customer_rating) as countRate FROM trip where driver_id = '".$data['id']."' and `trip`.account_type='99' AND `trip`.trip_mode = 'complete'";
                $res_trip_detail = mysql_query($get_trip_detail);
                $rowData = mysql_fetch_array($res_trip_detail);
                    if($rowData['countRate']!='0'){
                        $total_rating = $rowData['rating']/$rowData['countRate'];
                        $rating = (int)($total_rating);
                    }
                
              ?>
              <td class="tab-txt2"><?php echo $rating ;?></td>
              <td class="tab-txt2"><a href="view-rating-info.php?a=<?php echo base64_encode($data['id']);?>"><i class="fa fa-eye  fa_iconm1" aria-hidden="true"></i></a></td>
             
            </tr>
            <?php } } else{?>
            <tr>
              <td style="color: red; padding:10px" colspan="4"> No Records Found</td>
            </tr>
            <?php }?>
          </table>
          <!-- dinesh -->
          
        </div>
      </div>
    </div>
  </div>
</div>
    
   
  

<?php include '../include/footer.php'; ?>
<script type="text/javascript">
function deleteDriver(a)
{
	
   swal({
        title: "Delete Driver",
        text: "Are you sure to delete this driver",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        $.post('getData.php',{mode:'<?php echo base64_encode("deleteDriver");?>',a:a},function(response){
          $('#errorMessage').html(response);
          location.reload();
        }); 
        swal("Eliminado", "El conductor fue eliminado", "Éxito");
      });
    return false;
}   

function deleteDriver1(a)
    {
     alert('fdsfs');               
      swal({
        //title: "¿Estas seguro?",
         title: "Nj",
        text: "No podras recuperar los detalles de la zona una vez eliminada",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
        },
      function(){ 
          $.post('getData.php',{mode:'<?php echo base64_encode("deleteDriver");?>',a:a},function(response){    
          $('#errorMessage').html(response);
          location.reload();
         });
        });
      return false;
    }
    
    $(document).ready(function(){
	 $('#deleteDriverYes').click(function(i) {		
            $.post('getData.php',{mode:'<?php echo base64_encode('deleteDriver');?>'},function(response){
                $('#errorMessage').html(response);
                alert(response);
                 location.reload();
            }); 
        }); 
    }); 
    
    function deleteDriverYes(a){
     $.post('getData.php',{mode:'<?php echo base64_encode('deleteDriver');?>',a:a},function(response){
                $('#errorMessage').html(response);                
                 location.reload();
            }); 
        }
</script>
</body>
</html><!-- JQUERY SUPPORT -->