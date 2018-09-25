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
          <div class="row br1">
<div class="col-sm-12">
<h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mg5 mgt0">
              <h2 class="txt-style-3">Account Status: Taxista</h2>
              <form method="post" name="search" action="">
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> From</label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date"  name="start_date" id= "start_date" value="<?php echo $_POST['start_date'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> To </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date"  name="end_date" id="end_date" value="<?php echo $_POST['end_date'];?>"/>
                    </div>
                  </div>
                 
                <?php 
                    $str="select * from driver where company_id='".$_SESSION['uid']."'";
                    $res=mysql_query($str);                    
                ?>    
                
                  <div class="col-sm-4"1>
                    <div class="form-group">
                      <label> Taxi Driver </label>
                      <!--<input type="text" name="txtDriName" class="input-style" placeholder="Enter text here" value="<?php echo $_POST['txtDriName'];?>" />-->
                        <select name="txtDriName" id= "txtDriName" class="input-style">
                              <option value="">Select Taxi Driver</option>
                              <?php while($row=mysql_fetch_array($res)) {?>
                                      <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                              <?php } ?>
                        </select>
                    </div>
                  </div>
             
              <!-- <div class="col-sm-2">
                    <div class="form-group">
                      <label>Tipo</label>
                  <ul>
                    <li> <input type="checkbox" name="activation" value="activation" <?php //if (!empty($_POST['activation'])): ?> checked="checked"<?php //endif; ?>/> <span>Activación</span> </li>
                    <li> <input type="checkbox" name="payment" value="paid"<?php// if (!empty($_POST['payment'])): ?> checked="checked"<?php //endif; ?>/> <span>Pago</span> </li>
                  </ul>
                    </div>
                  </div> -->
                  
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>State</label>
                  <ul>
                    <li> <input type="checkbox" name="paid" value="200" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?>/> <span>Paid</span> </li>
                    <li> <input type="checkbox"  name="unpaid" value="900" <?php if (!empty($_POST['unpaid'])): ?> checked="checked"<?php endif; ?>/> <span>Non Paid</span> </li>
                  </ul>
                    </div>
                  </div>

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>Type</label>
                  <ul>
                      <li> 
                          <input type="checkbox" name="travel" value="travel" <?php if (!empty($_POST['travel'])): ?> checked="checked"<?php endif; ?> /> <span>Travel</span> </li>
                      <li> 
                          <input type="checkbox" name="activation" value="activation"  <?php if (!empty($_POST['activation'])): ?> checked="checked"<?php endif; ?> /> <span>Payment</span> 
                      </li>
                  </ul>
                    </div>
                  </div>
                </div>
                
                <div class="row bts">
                  <div class="col-lg-12" style="text-align:center;">
                      <button class="dash-button hvr-wobble-horizontal wap" type="submit" name="submit" id="chartId">filtros</button>
                  </div>
                </div>
              </form>
              </div>
             
             <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Taxi Driver payments</h2>
            
              <div class="row">
                 <?php  
						if(isset($_POST['submit']))
             {
              if($_POST['txtDriName'] != "" || $_POST['txtDriName'] != null)
              {
							$name = "AND driver.name LIKE '%" . $_POST['txtDriName'] . "%'";
              }
							if ($_POST['start_date'] != '' && $_POST['end_date'] != '') 
              {
								$date = "AND driver.added_on between '" . date('Y-m-d', strtotime($_POST['start_date']))." "."00:00:00" . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date']))." "."23:59:59" . "'";
							}
              if($_POST['paid'] != "" || $_POST['unpaid'] != "")
              {
                $paymentPaid = " AND `driver`.status IN ('".($_POST['paid'])."','".($_POST['unpaid'])."')";
              }
							// if($_POST['unpaid'] != "")
       //              {
       //                $paymentUnPaid = " AND `driver`.status = '".($_POST['unpaid'])."'";
       //              }   
						} else {
							$name = '';
							$date = '';
              $paymentPaid = '';
              $paymentUnPaid = '';
						} 
						/*                 
						$driver_detail1 ="SELECT * FROM driver"
                            . " WHERE company_id='".$_SESSION['uid']."' $name $date AND driverType='monthly'";
                        $result_driver1 = mysql_query($driver_detail1);
                        $num_rows1 = mysql_num_rows($result_driver1);
						$totalSum = '0';
                        if(isset($num_rows1) && $num_rows1>0){
                        while($row1 = mysql_fetch_array($result_driver1)){
                            $query_amt1 = "SELECT account. ; as driver_amt FROM account WHERE driver_id='".$row1['id']."' AND (payment_mode!='cash' OR payment_mode!='')";
                            $result_amt1 = mysql_query($query_amt1); 
                            
                            $amt_driver1 = array();
                            
                            while($row_amt1 = mysql_fetch_array($result_amt1)){
                                 $totalSum = $totalSum + $row_amt1['driver_amt'];
                            
                                
                            }}}*/
							
						//Total Balance Taxi driver to taxi company
            $query_form_taxi_driver = "SELECT * FROM driver WHERE driver.added_by = '".$_SESSION['uid']."' $name $date $paymentPaid";
						$result_form_taxi_driver = mysql_query($query_form_taxi_driver);
						$num_rows = mysql_num_rows($result_form_taxi_driver);
						if($num_rows>0){
							while($data = mysql_fetch_array($result_form_taxi_driver)){
								$query_amt = "SELECT driverPayment.driver_name,SUM(driverPayment.payment) as driver_amt FROM driverPayment WHERE added_by='".$_SESSION['uid']."' ";
									$result_amt = mysql_query($query_amt);
									while($row_amt = mysql_fetch_array($result_amt)){
										$totalSum = $row_amt['driver_amt'];
									}
							}	
						}                  
                  ?>
              	<div class="col-md-7">
                	<p class="status_p">Payments revenues  : <?php echo CURRENCY.$totalSum?> <br>
                    Pending Income: <?php echo CURRENCY?>0.00  </p>
                </div>
                <div class="col-md-5">
                	<a href="<?php echo TAXI_URL; ?>add-payment.php" class="dash-button hvr-wobble-horizontal f74 ret" style="width:100%; margin:0px;">Add Payment Taxi Driver</a>
                </div>
              </div>
              <div class="bst">
              <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1">Income</th>
                <th class="tab-txt1">Date</th>
                <!--<th class="tab-txt1">Status</th>-->
                <th class="tab-txt1">Driver Name</th>
                <th class="tab-txt1">Estate</th> <!-- status -->
                <th class="tab-txt1">More Information</th>
              </tr>
              
                <?php   
				
               if(isset($_POST['submit'])) {
                    $name = "AND driver.name LIKE '%" . $_POST['txtDriName'] . "%'";
                    if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {
                        $date = "AND driver.added_on between '" . date('Y-m-d', strtotime($_POST['start_date']))." "."00:00:00" . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date']))." "."23:59:59" . "'";
                    }		
                    if($_POST['paid'] != "")
                    {
                      $paymentPaid = " AND `driver`.status IN ('".($_POST['paid'])."','".($_POST['unpaid'])."')";
                    }
                    // if($_POST['unpaid'] != "")
                    // {
                    //   $paymentUnPaid = " AND `driver`.status = '".($_POST['unpaid'])."'";
                    // }			
                } else {
                    $name = '';
                    $date = '';
                    $paymentPaid = '';
                    $paymentUnPaid = '';
                } 

             // $driStatus = "SELECT `driver`.status FROM `driver`"

				/*
                 $driver_detail ="SELECT * FROM driver"
                            . " WHERE company_id='".$_SESSION['uid']."' $name $date AND driverType='monthly'";
                        $result_driver = mysql_query($driver_detail);
                        $num_rows = mysql_num_rows($result_driver);
						
                        if(isset($num_rows) && $num_rows>0){
                        while($row = mysql_fetch_array($result_driver)){
                            $query_amt = "SELECT SUM(account.payment_amount) as driver_amt FROM account WHERE driver_id='".$row['id']."' AND (payment_mode!='cash' OR payment_mode!='')";
                            $result_amt = mysql_query($query_amt);
                            while($row_amt = mysql_fetch_array($result_amt)){
                                $amt_driver = $row_amt['driver_amt'];
								
                            }*/
							
					$query_form_taxi_driver = "SELECT * FROM driver WHERE driver.added_by = '".$_SESSION['uid']."' $name $date $paymentPaid";
					$result_form_taxi_driver = mysql_query($query_form_taxi_driver);
					$num_rows = mysql_num_rows($result_form_taxi_driver);
					if($num_rows>0){
						while($data = mysql_fetch_array($result_form_taxi_driver)){
							$query_amt = "SELECT driverPayment.driver_name,SUM(driverPayment.payment) as driver_amt FROM driverPayment WHERE driver_name='".$data['id']."' ";
								$result_amt = mysql_query($query_amt);
								while($row_amt = mysql_fetch_array($result_amt)){
									$amt_driver = $row_amt['driver_amt'];
									//echo $amt_driver11;
									
								}
				 ?>
                <tr>
                  <td class="tab-txt2"><?php if($amt_driver) {echo $amt_driver;}else{echo '0';}?></td>
                  <td class="tab-txt2"><?php  echo date('Y-m-d', strtotime($data['added_on']));?></td>
<!--                  <td class="tab-txt2">Paid</td>-->
                  <td class="tab-txt2"><?php echo $data['name'];?></td>
                  <?php if($data['status'] == '404'){ $driStatus = "Delete";}elseif($data['status'] == '200'){ $driStatus = "Paid" ;}elseif($data['status'] == '900'){ $driStatus = "Unpaid"; }elseif($data['status'] == '400'){ $driStatus = "Suspend";} ?>
                  <td class="tab-txt2"><?php echo $driStatus;?></td>
                  <td class="tab-txt2"><a href="driver_trip_detail.php?a=<?php echo base64_encode($data["id"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
                </tr>
                <?php } }else{?>
                <tr>
                    <td style="color: red; padding: 10px;" colspan="8"> No Records Found</td>
                </tr>
                <?php }?>
                       
            </table>
            
            <!--<div style="margin:20px auto; background:#fff; text-align:center;">
        	<img src="../images/c1.jpg" >
        	</div>-->
			
			<div style="margin:20px auto; background:#fff; text-align:center;">
        		<div id="chart-container">The comparison of current revenues Months</div>
        	</div>
            </div>
            </div>
            
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Payments to Taxi Driver</h2>
           
              <div class="row">
              	<div class="col-md-7">
				<?php $driver_Amt = mysql_fetch_array(mysql_query("SELECT SUM(trip.trip_ammount) as  tripAmt FROM trip LEFT JOIN driver ON trip.driver_id = driver.id LEFT JOIN users On trip.customer_id = users.id WHERE trip.trip_type='corporate' AND trip.account_type='99'  AND driver.added_by = '".$_SESSION['uid']."' AND payment_to_driver = '0' $date $name ORDER BY trip.tripdatetime DESC"));?>
                	<p class="status_p">Pending payments:: <?php echo $driver_Amt['tripAmt'].'.00';?> MX  </p>
                </div>
                <div class="col-md-5">
                	<a href="<?php echo TAXI_URL; ?>taxi_driver_payment.php" class="dash-button hvr-wobble-horizontal f74 ret" style="width:100%; margin:0px;">Add Payment To Taxi Driver</a>
                </div>
              </div>
              <div class="bst">
              <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1">Quantity</th>
                <th class="tab-txt1">Date</th>
                <th class="tab-txt1">Corporation</th>
                <th class="tab-txt1">State</th>
                <th class="tab-txt1">Taxi Driver</th>
                <th class="tab-txt1">More Information</th>
              </tr>
			  <?php       
			  
			 if(isset($_POST['submit'])) {
                             //print_r($_POST);
                            
                    $name = "AND driver.name LIKE '%" . $_POST['txtDriName'] . "%'";
                    if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {
                        $date = "AND driver.added_on between '" . date('Y-m-d', strtotime($_POST['start_date']))." "."00:00:00" . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date']))." "."23:59:59" . "'";
                    }		
                    
                    if($_POST['paid'] != "" && $_POST['unpaid'] != "")
                    {
                        $paid1 = '500';
                        $Unpaid1 = '0';
                        // $paymentPaidBoth = " AND `trip`.payment_to_driver IN $paid'";
                        $paymentPaidBoth = " AND `trip`.payment_to_driver IN ('".($paid1)."','".($Unpaid1)."')";
                    }
                    elseif($_POST['paid'] != "")
                    {
                        if($_POST['paid'] == '200'){
                            $paid = '500';
                            $paymentPaid = " AND `trip`.payment_to_driver ='$paid'";
                        }
                    }
                    
                    else{
                            $Unpaid = '0';
                            $paymentPaid = " AND `trip`.payment_to_driver ='$Unpaid'";
                    }
                    } else {
                            $name = '';
                            $date = '';
                            $paymentPaid = '';
                            $paymentPaidBoth = '';
                    } 	
				     $query_to_driver = "SELECT trip.id as tripId,trip.driver_id,trip.trip_type,trip.payment_to_driver,trip.customer_id as corporateUserId,trip.trip_ammount,trip.tripdatetime,driver.name as driverName,driver.added_by as driverAddedBy, driver.added_on as driAddOn, users.name as corporateName FROM trip LEFT JOIN driver ON trip.driver_id = driver.id LEFT JOIN users On trip.customer_id = users.id WHERE trip.trip_type='corporate' AND trip.account_type='99'  AND driver.added_by = '".$_SESSION['uid']."' $date $name $paymentPaid $paymentPaidBoth ORDER BY trip.tripdatetime DESC";
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
					<td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($row["tripId"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
				</tr>
			<?php }} else{?>
				<tr>
					<td style="color: red; padding: 10px;" colspan="8"> No Records Found</td>
				</tr>
			<?php }?>
             
              
              
            </table>
            
			<!--<div style="margin:20px auto; background:#fff; text-align:center;">
				<img src="../images/c1.jpg" >
        	</div>-->
			<div style="margin:20px auto; background:#fff; text-align:center;">
        		<div id="chart-container-chart">The comparison of current income Month</div>
        	</div>
             </div>
              </div>
              
          </div>
        </div>
        
        
            
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
// chart query from driver (Monthly basis)

FusionCharts.ready(function () {
	
	$.post('getData.php',{mode:'<?php echo base64_encode('getFromTaxiDriverMonthlyDetails');?>',idC:'chartId',from_date:'<?php echo $_POST['start_date'];?>',to_date:'<?php echo $_POST['end_date'];?>',txtDriName:'<?php echo $_POST['txtDriName']?>'},function(data){
	var obj = jQuery.parseJSON(data);	
    var revenueChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-container',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {			
            "chart": {
                "caption": "Current Month revenues",
                "subCaption": "Hi Taxi",
                "xAxisName": "Driver List",
                "yAxisName": "Income (In USD)",
                "numberPrefix": "$",
                "paletteColors": "#0075c2",
                "bgColor": "#ffffff",
                "borderAlpha": "20",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#ffffff",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },
            "data": obj,
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "1000",
                            "color": "#1aaf5d",
                            "valueOnRight": "1",
                            "displayvalue": "Monthly Target"
                        }
                    ]
                }
            ]
        }
    });
    
    revenueChart.render();
	
	});
	
	$.post('getData.php',{mode:'<?php echo base64_encode('getToTaxiDriverMonthlyDetails');?>',idC:'chartId',from_date:'<?php echo $_POST['start_date'];?>',to_date:'<?php echo $_POST['end_date'];?>',txtDriName:'<?php echo $_POST['txtDriName']?>'},function(data){
	var obj = jQuery.parseJSON(data);
	//console.log(obj);
	var revenueChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-container-chart',
        width: '500',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Current Month revenues",
                "subCaption": "Hi Taxi",
                "xAxisName": "Driver List",
                "yAxisName": "Income (In USD)",
                "numberPrefix": "$",
                "paletteColors": "#0075c2",
                "bgColor": "#ffffff",
                "borderAlpha": "20",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#ffffff",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },
            "data": obj,
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "1000",
                            "color": "#1aaf5d",
                            "valueOnRight": "1",
                            "displayvalue": "Monthly Target"
                        }
                    ]
                }
            ]
        }
    });
    
    revenueChart.render();
	
	});
    
});	

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
        title: "Delete User",
        text: "No lo harás ser capaz de recuperar esta Taxi Datos Empresa. Y todos los detalles quitados como conductor, vehículo, viajes, etc ..!",
        type: "advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Sí, estoy seguro!',
        closeOnConfirm: false
      },
      function(){
        swal("Eliminado", "Sus datos Taxi Company ha sido suprimido!", "éxito");
      });
    
    return false;
}

</script>
</body>
</html>
