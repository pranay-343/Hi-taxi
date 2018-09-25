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
<h1 class="txt-style-1 bn">Account User: <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mg5 mgt0">
              <h2 class="txt-style-3">Account Status: Hi Taxi</h2>
              <form method="post" action="">
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> From </label>
                      <input type="text" class="datepicker-here input-style" placeholder="Select From DATE" name="from_date" value="<?php echo $_POST['from_date']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> To </label>
                      <input type="text" class="datepicker-here input-style" placeholder="Select To date" name="to_date" value="<?php echo $_POST['to_date']?>"   />
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>Type</label>
                  <ul>
                    <li> <input type="checkbox" name="activation" value="activation" <?php if (!empty($_POST['activation'])): ?> checked="checked"<?php endif; ?>/> <span>Activation</span> </li>
                    <li> <input type="checkbox" name="payment" value="paid"<?php if (!empty($_POST['payment'])): ?> checked="checked"<?php endif; ?>/> <span>Payment</span> </li>
                  </ul>
                    </div>
                  </div>
                  
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label>State</label>
                  <ul>
                    <li> <input type="checkbox" name="paid" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?> /> <span>Paid</span> </li>
                    <li> <input type="checkbox"  name="pending" <?php if (!empty($_POST['pending'])): ?> checked="checked"<?php endif; ?>/> <span>Non Paid</span> </li>
                  </ul>
                    </div>
                  </div>
                  
                </div>
                
                
                
                <div class="row bts">
                  <div class="col-lg-12" style="text-align:center;">
                    <button class="dash-button hvr-wobble-horizontal wap" name="submit" id="chartId" type="submit">Search</button>
                  </div>
                </div>
              </form>
              <?php 
			  $cur_date = date('m/d/Y');
			  $query_net_bal = "SELECT SUM(driverPayment.payment) as totalNetBal FROM driverPayment WHERE driverPayment.added_by = '".$_SESSION['uid']."' AND paymentDateTo >= '$cur_date'";
			  $data_amount =mysql_fetch_array(mysql_query($query_net_bal));
			  $net_bal = $data_amount['totalNetBal'];
			  ?>
              <h2 class="txt-style-4"> NET BALANCE HI TAXI - <?php if($net_bal){echo $net_bal.'.00 MX';} else{echo '0.00MX';}?></h2>
              <div class="bst">
              <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1">Income</th>
                <th class="tab-txt1">Result</th>
                <th class="tab-txt1">Date and Time</th>
                <th class="tab-txt1">Type</th>
                <!--<th class="tab-txt1">Zone</th>-->
                <th class="tab-txt1">Observation</th>
                <th class="tab-txt1">State</th>
                <th class="tab-txt1">More Information</th>
              </tr>
              <?php 
			    
			  
			  if (isset($_POST['submit'])) {
					if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
						$date = "AND driverPayment.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'+ INTERVAL 1 DAY";
					}
					if($_POST['payment']!=''){
						$payment = " AND `driverPayment`.amount_type LIKE '%" . ($_POST['payment']) . "%'";
					}						
					if($_POST['activation']!=''){
						$activation = " AND `driverPayment`.amount_type LIKE '%" . ($_POST['activation']) . "%'";
					}
				}
				else{
					$payment = '';
					$activation = '';
					$date = '';
				}
				
                /*$str="SELECT `taxicompany`.web_user_id,`taxicompany`.per_week_cost,`manage_master_amount`.company_id,`manage_master_amount`.amount,`manage_master_amount`.added_on,`manage_master_amount`.type,`manage_master_amount`.start_date,`manage_master_amount`.end_date_time,`manage_master_amount`.amount_type,`manage_master_amount`.added_by,`login`.id,`login`.name FROM `taxicompany`                   
                    LEFT JOIN `manage_master_amount` ON `taxicompany`.web_user_id=`manage_master_amount`.company_id
                    LEFT JOIN `login` ON `manage_master_amount`.added_by=`login`.id where `taxicompany`.web_user_id='".$_SESSION['uid']."' and `manage_master_amount`.zone_id!='0' $date $payment $activation";
               $res=mysql_query($str);
               $num=mysql_num_rows($res);
			   if($num>0){
               while($row=mysql_fetch_array($res))
               {
					$query_income = "SELECT sum(trip.trip_ammount) as totalamount, driver.id, driver.name,trip.id as trId, trip.driver_id as tRID, trip.trip_mode, trip.tripdatetime FROM driver 
					LEFT JOIN trip ON driver.id = trip.driver_id 
					WHERE driver.added_by='6' AND trip.trip_type='corporate' AND trip.trip_mode ='complete' AND trip.tripdatetime BETWEEN '".date('Y-m-d', strtotime($row['start_date']))."' AND '".date('Y-m-d', strtotime($row['end_date_time']))."'"; 
					$result_income = mysql_query($query_income);
					$rows_income = mysql_num_rows($result_income);
					while($row_income=mysql_fetch_array($result_income)){
						$amount_income = $row_income['totalamount'];
					}
					
					$fromDate = date('Y-m-d', strtotime($row['start_date']));
					$toDate = date('Y-m-d', strtotime($row['end_date_time']));
					
					
					$query_dri_acti =mysql_fetch_assoc(mysql_query("SELECT SUM(payment) as amount FROM driverPayment WHERE added_by ='".$_SESSION['uid']."' AND (paymentDateFrom <='$fromDate' AND paymentDateTo <= '$toDate')"));
					$total_activation_amount = $query_dri_acti['amount'];
					
					
					$query_corporation_acti =mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as totalamount FROM manage_master_amount WHERE zone_id ='0' AND company_id ='".$_SESSION['uid']."' AND (start_date >='$fromDate' AND end_date_time <= '$toDate')"));
					$total_corporation_amount = $query_corporation_acti['totalamount'];
					*/
					$query_driver = "SELECT * FROM driverPayment WHERE driverPayment.added_by = '".$_SESSION['uid']."' $date $activation $payment";
					$result_driver =  mysql_query($query_driver);	
					$num_rows = mysql_num_rows($result_driver);
					if($num_rows>0){
						while($data_driver =  mysql_fetch_array($result_driver)){
							$start_date = date ('Y-m-d',strtotime($data_driver['paymentDateFrom']));
							$end_date = date ('Y-m-d',strtotime($data_driver['paymentDateTo']));
							
							$query_trip_detail = "SELECT SUM(trip.trip_ammount) as totalAmt FROM trip  where 1 AND trip.driver_id='".$data_driver['driver_name']."' AND trip.trip_type='corporate' AND trip.tripdatetime >='$start_date' AND trip.tripdatetime<='$end_date'";
							$result_trip_amount = mysql_fetch_array(mysql_query($query_trip_detail));
					
					
              ?>
              <tr>
			  <?php //echo $_SESSION['uid'];?>
                <td class="tab-txt2"><?php if($data_driver['payment']){echo $data_driver['payment'].'.00 MX';}else{echo '0.00 MX';}?></td>
                <td class="tab-txt2"><?php if($result_trip_amount['totalAmt']){echo $result_trip_amount['totalAmt'].'.00 MX';}else{echo '0.00 MX';} ?></td>
                <td class="tab-txt2"><?php echo $data_driver['added_on'];?></td>
                <td class="tab-txt2"><?php if($data_driver['amount_type'] == 'activation'){echo 'Taxi Activacion';}?></td>
                <td class="tab-txt2">REF1</td>
				<td class="tab-txt2">Paid</td>
                <!-- <td class="tab-txt2">REF1</td> -->
                <td class="tab-txt2">
				<?php if($data_driver['payment']){?>
                    <a href="<?php echo TAXI_URL.'view_taxi_acti_detail.php?id='.base64_encode($data_driver['id']);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a>
				<?php }else{?>	
					<a href="javascript:void(0)"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a
				<?php }?>
				</td>
              </tr>
            <?php } }else{?>
				<tr>
                    <td style="color: red; padding:10px" colspan="5"> No Records Found </td>
                </tr>
			<?php }?>	
            </table>
            
            <!--<div style="margin:20px auto; background:#fff; text-align:center;">
        	<img src="../images/c1.jpg" >
        	</div>-->
			<div style="margin:20px auto; background:#fff; text-align:center;">
				<div id="chart-container">La comparación de los ingresos corrientes Meses</div>
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
/*
FusionCharts.ready(function () {
	$.post('getData.php',{mode:'<?php echo base64_encode('getTaxiPaymentDetails');?>'},function(data){
	var obj = jQuery.parseJSON(data);
	//console.log(obj);
		
    var revenueChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-container',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Current Month revenue of current year",
                "subCaption": "Taxi Central",
                "xAxisName": "Driver List",
                "yAxisName": "Ingresos (en U$S)",
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
    }).render();
	
	});
    
});	*/

FusionCharts.ready(function () {
	$.post('getData.php',{mode:'<?php echo base64_encode('getTaxiPaymentDetailsIO_2');?>',id1:'chartId',from_date:'<?php echo $_POST['from_date'];?>',to_date:'<?php echo $_POST['to_date'];?>',payment:'<?php echo $_POST['payment'];?>',activation:'<?php echo $_POST['activation'];?>'},function(data){
	var obj = jQuery.parseJSON(data);
	//console.log(obj.category);
	var revenueChart = new FusionCharts({
        type: 'mscolumn2d',
        renderAt: 'chart-container',
        width: '500',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Comparison earnings of the current month (<?php echo date('Y')?>)",
                "xAxisname": "Current Month (<?php echo date('Y')?>)",
                "yAxisName": "Income (U $ S)",
                "numberPrefix": "$",
                "plotFillAlpha" : "80",

                //Cosmetics
                "paletteColors" : "#0075c2,#1aaf5d",
                "baseFontColor" : "#333333",
                "baseFont" : "Helvetica Neue,Arial",
                "captionFontSize" : "14",
                "subcaptionFontSize" : "14",
                "subcaptionFontBold" : "0",
                "showBorder" : "0",
                "bgColor" : "#ffffff",
                "showShadow" : "0",
                "canvasBgColor" : "#ffffff",
                "canvasBorderAlpha" : "0",
                "divlineAlpha" : "100",
                "divlineColor" : "#999999",
                "divlineThickness" : "1",
                "divLineIsDashed" : "1",
                "divLineDashLen" : "1",
                "divLineGapLen" : "1",
                "usePlotGradientColor" : "0",
                "showplotborder" : "0",
                "valueFontColor" : "#ffffff",
                "placeValuesInside" : "1",
                "showHoverEffect" : "1",
                "rotateValues" : "1",
                "showXAxisLine" : "1",
                "xAxisLineThickness" : "1",
                "xAxisLineColor" : "#999999",
                "showAlternateHGridColor" : "0",
                "legendBgAlpha" : "0",
                "legendBorderAlpha" : "0",
                "legendShadow" : "0",
                "legendItemFontSize" : "10",
                "legendItemFontColor" : "#666666"                
            },
            "categories": [
                {
                    "category": obj.category
                }
            ],
            "dataset": [
                {
                    "seriesname": "Income Current Month",
                    "data": obj.income
                }, 
                {
                    "seriesname": "Outputs Current Month",
                    "data": obj.outcome
                }
            ],
            "trendlines": [
                {
                    
                }
            ]
        }
    });
    
    revenueChart.render();
	
	});
    
});	
</script>
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
        swal("Deleted!", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}

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
</body>
</html>