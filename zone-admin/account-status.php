<?php
error_reporting('E_All'); 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style type="text/css">
div#datepickers-container {
z-index: 99999999 !important;
}
</style>
    <body class="frog popup_designm1">
    <?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Account Status</h2>
          <form method="post" name="search" action="">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date" name="from_date"  value="<?php echo $_POST['from_date']?>" id="from_date"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date" name="to_date"  value="<?php echo $_POST['to_date']?>"  id="to_date"/>
                </div>
              </div>
              
            </div>
            <div class="row bts">              
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Type </label>
                  <ul>
                    <li>
					<input type="checkbox" name="activation" value="activation" <?php if(!empty($_POST['activation'])): ?> checked="checked"<?php endif; ?>/>
					<span>Activation</span></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Status </label>
                  <ul>
                    <li>
                      <input type="checkbox" name="paid" value="paid" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?>/>
                      
                      <span>Paid</span></li>
                      <li>
                        <input type="checkbox" name="non_paid" value="nonpaid" <?php if (!empty($_POST['non_paid'])): ?> checked="checked"<?php endif; ?>/>
                        <span>Non Paid</span></li>
                   
                  </ul>
                </div>
              </div>
            </div>
            
            <div class="row bts">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100 wap" id="chartId" type="submit" name="submit">Search</button>
              </div>
              <div class="col-sm-4">
                <!--<button class="dash-button hvr-wobble-horizontal w100">Add payment</button> add-company-payment.php-->
				<a style="cursor:pointer;"class="dash-button hvr-wobble-horizontal w100 wap" data-toggle="modal" data-target="#payment-modal">Add Payment</a>
              </div>
            </div>
          </form>
          <div class="row">
            <?php
			$cdate = date("Y-m-d");
				if (isset($_POST['submit'])) {
					
					if($_POST['from_date'] != '')
						{
							$from_date = $_POST['from_date'];	
						}
					else
						{
							$from_date = "";	
						}
						
					if($_POST['to_date'] != '')
						{
							$to_date = $_POST['to_date'];	
						}
					else
						{
							$to_date = "";	
						}	
					
					if($_POST['paid'] != '')
						{
							$paid = $_POST['paid'];	
						}
					else
						{
							$paid = "";	
						}	
						
						if($_POST['non_paid'] != '')
						{
							$non_paid = $_POST['non_paid'];	
						}
					else
						{
							$non_paid = "";	
						}
						
						if($_POST['activation'] != '')
						{
							$activation = $_POST['activation'];	
						}
					else
						{
							$activation = "";	
						}
					if($from_date != '' && $to_date != ''){
						echo '<p># Buscar: <strong>"'.$from_date.'"  "'.$to_date.'"</strong><p>';
						}
					else if($from_date != '' && $to_date != '' && $paid != ''){
						echo '<p># Buscar: <strong>"'.$from_date.'"  "'.$to_date.'"  "'.$paid.'"</strong><p>';
						}
					else if($from_date != '' && $to_date != '' && $non_paid != ''){
						echo '<p># Buscar: <strong>"'.$from_date.'"  "'.$to_date.'"  "'.$non_paid.'"</strong><p>';
						}
                    else if($from_date != '' && $to_date != '' && $activation != ''){
						echo '<p># Buscar: <strong>"'.$from_date.'"  "'.$to_date.'"  "'.$activation.'"</strong><p>';
						}
						else if($paid != '' && $non_paid != ''){
						echo '<p># Buscar: <strong>"'.$paid.'" "'.$non_paid.'"</strong><p>';
						}
						else if($paid != '' && $activation != ''){
						echo '<p># Buscar: <strong>"'.$paid.'" "'.$activation.'"</strong><p>';
						}
						else if($non_paid != '' && $activation != ''){
						echo '<p># Buscar: <strong>"'.$non_paid.'" "'.$activation.'"</strong><p>';
						}
						else if($paid != '' && $non_paid != '' && $activation != ''){
						echo '<p># Buscar: <strong>"'.$paid.'" "'.$non_paid.'" "'.$activation.'"</strong><p>';
						}
						else if($activation != ''){
						echo '<p># Buscar: <strong>"'.$activation.'"</strong><p>';
						}
						else if($paid != ''){
						echo '<p># Buscar: <strong>"'.$paid.'"</strong><p>';
						}
						else if($non_paid != ''){
						echo '<p># Buscar: <strong>"'.$non_paid.'"</strong><p>';
						}					
					/*if($_POST['from_date'] && $_POST['to_date']){
						echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['to_date'].'"</strong><p>';
						}
					 else if($_POST['from_date'] && $_POST['to_date'] && $_POST['paid']){
						echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['to_date'].'"  "'.$_POST['paid'].'"</strong><p>';
						}
					else if($_POST['non_paid'] && $_POST['from_date'] && $_POST['to_date']){
						echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['to_date'].'"  "'.$_POST['non_paid'].'"</strong><p>';
						}
						else if($_POST['activation'] && $_POST['from_date'] && $_POST['to_date']){
						   echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['activation'].'"</strong><p>';  	
							}
							else{
					echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['to_date'].'"  "'.$_POST['paid'].'"  "'.$_POST['non_paid'].'"  "'.$_POST['activation'].'"</strong><p>';
					
							}*/
							//echo '<p># Buscar: <strong>"'.$_POST['from_date'].'"  "'.$_POST['to_date'].'"  "'.$_POST['paid'].'"  "'.$_POST['non_paid'].'"  "'.$_POST['activation'].'"</strong><p>';
					
					if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
						$date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
					}
					if($_POST['paid']!=''){
						$paid = " AND  '$cdate' < `manage_master_amount`.end_date_time";
					}
					else if($_POST['non_paid']!=''){
						$non_paid = " AND  '$cdate' > `manage_master_amount`.end_date_time";
					}
					else if($_POST['activation']!=''){
						$activation = " And `manage_master_amount`.amount_type = '". ($_POST['activation']) . "'";
					}
					else if($_POST['paid']!='' && $_POST['activation']!='' && $_POST['non_paid']!='')
					{
						$paid = " AND `manage_master_amount`.amount_type = '".($_POST['paid']) . "'";
						$activation = " AND `manage_master_amount`.amount_type = '". ($_POST['activation']) . "'";
						$non_paid = " AND `manage_master_amount`.amount_type = '". ($_POST['non_paid']) . "')";
					}
				}
				else{
					$paid = '';
					$activation = '';
					$non_paid = '';
					$date = '';
				}
				
				$str="SELECT `taxicompany`.per_week_cost,`taxicompany`.web_user_id,`manage_master_amount`.zone_id,`manage_master_amount`.company_id,`manage_master_amount`.amount FROM `manage_master_amount`
                  LEFT JOIN `taxicompany` on `manage_master_amount`.company_id=`taxicompany`.web_user_id where `manage_master_amount`.company_id = `taxicompany`.web_user_id and `manage_master_amount`.zone_id='".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."' $date ";
                  $res=mysql_query($str);
                  while($row=mysql_fetch_array($res))
                  {
                    $per_week_cost[]=$row['per_week_cost'];

                    $amount[]=$row['amount'];
                  }
                  // print_r($result);
                  // print_r($result1);
				if($per_week_cost){
                 $a = array_sum($per_week_cost);					
				}
				if($amount){
                 $b = array_sum($amount);
				}

                 $c=$a+$b;

            ?>
            <div class="col-sm-12"> <span class="txt-style-5">balance neto - <?php echo '$ '.$b; ?></span> </div>
          </div>
          <br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable">
                <thead>
                <tr>
                <th width="10%" class="tab-txt1">Company Name</th>
                <th width="10%" class="tab-txt1">Income</th>
                <th width="10%" class="tab-txt1">Outcome</th>
                <th width="18%" class="tab-txt1">Date</th>
                <th width="10%" class="tab-txt1">Type</th>
                <th width="10%" class="tab-txt1">Status</th>
                <th width="30%" class="tab-txt1">Message</th>
                <th width="3%" class="tab-txt1">More Information</th>
              </tr>
              </thead>
			  <?php //error_reporting(0);
					/*$query ="SELECT * FROM taxicompany LEFT JOIN manage_master_amount ON taxicompany.web_user_id = manage_master_amount.company_id where taxicompany.added_by = '".$_SESSION['uid']."' AND manage_master_amount.zone_id!='' AND manage_master_amount.added_by = '".$_SESSION['uid']."'";*/
					
					if (isset($_POST['submit'])) { 
						if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
							$date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'+ INTERVAL 1 DAY";
						}
						else{
                                                    $date = "";	
						}
						if($_POST['paid']!=''){
                                                    $paid = " AND  '$cdate' < `manage_master_amount`.end_date_time";
						}
						else{
                                                    $paid = "";	
						}
						if($_POST['non_paid']!=''){
                                                    $non_paid = " AND '$cdate' > `manage_master_amount`.end_date_time";
						}
						else{
                                                    $non_paid = "";	
						}						
						if($_POST['activation']!=''){
							$activation = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['activation']) . "%'";
						}
						
						else{
                                                    $activation = "";
						}
					}
					else{
						$paid = '';
						$activation = '';
						$date = '';
						$non_paid ='';
					}
					
                       $query_amount_detail ="SELECT *,`manage_master_amount`.added_on as manage_addedod FROM manage_master_amount LEFT JOIN taxicompany ON manage_master_amount.company_id = taxicompany.web_user_id WHERE taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."' AND manage_master_amount.added_by ='".$_SESSION['uid']."' AND manage_master_amount.corporate_id='0' $date $activation $paid $non_paid ORDER BY manage_master_amount.added_on DESC ";
						$result_amount_detail = mysql_query($query_amount_detail);
						$rows = mysql_num_rows($result_amount_detail);
						if($rows>0){
							while($company_data = mysql_fetch_array($result_amount_detail)){
								
			  ?>
            <tbody>
              <tr>
                <td class="tab-txt2"><?php  echo $company_data['name'];?></td>
                <td class="tab-txt2"><?php if($company_data['amount_type'] == 'activation'){ echo $company_data['amount'];}else{echo '0';} ?></td>
                <?php 
                        // For corporate outcome                        
                        $sql_cor_out = "SELECT  sum(amount) as total_amt_cor_com FROM manage_master_amount WHERE added_by = '".$company_data['company_id']."' AND zone_id = '0' AND added_on >=  '".date('Y-m-d',strtotime($company_data['start_date']))."' AND added_on<='".date('Y-m-d',strtotime($company_data['end_date_time']))."'";
                        $result_cor_out = mysql_fetch_array(mysql_query($sql_cor_out));
                        $amt_cor_com = $result_cor_out['total_amt_cor_com'];                        
                        
                        //For per taxi activataion
                         $sql_taxi_actva_out = "SELECT sum(payment) as total_amt_per_taxi FROM driverPayment WHERE added_by = '".$company_data['company_id']."'  AND added_on >=  '".date('Y-m-d',strtotime($company_data['start_date']))."' AND added_on<='".date('Y-m-d',strtotime($company_data['end_date_time']))."'";
                        $result_taxi_out = mysql_fetch_array(mysql_query($sql_taxi_actva_out));
                        $amt_taxi_com = $result_taxi_out['total_amt_per_taxi'];
                        
                        // For corporate trip 
                        
                        $sql_get_driver = (mysql_query("SELECT id,name FROM driver WHERE company_id = '".$company_data['company_id']."' "));   
                        while ($row_driver = mysql_fetch_array($sql_get_driver)){
                        $drib_ids = $row_driver['id']; 
                            
                        //get trip data
                            
                        $sql_trip_detail = "SELECT SUM(trip_ammount)as tripamt FROM trip WHERE driver_id = $drib_ids AND tripdatetime >=  '".date('Y-m-d',strtotime($company_data['start_date']))."' AND tripdatetime<='".date('Y-m-d',strtotime($company_data['end_date_time']))."'";
                        $result_trip_detail = mysql_fetch_array(mysql_query($sql_trip_detail));
                        $tripamt = $result_trip_detail['tripamt'];
                        
                        }
                        
                        
                        $total_outcom = $amt_cor_com+$amt_taxi_com+$tripamt;
                      
                        
                
                ?>
		<td class="tab-txt2"><?php echo $total_outcom. CURRENCY; //if($company_data['amount_type'] == 'paid'){echo $company_data['amount'];}else{echo '0';} ?></td>
		<td class="tab-txt2"><?php echo $company_data['manage_addedod'];?></td>
                <td class="tab-txt2"><?php echo $company_data['amount_type'];?></td>				
                <td class="tab-txt2"><?php if($cdate>$company_data['end_date_time'])
                    {echo "Unpaid";}
                    else{echo "Paid";}?>	
		</td>
                <td class="tab-txt2"><?php echo $company_data['message'];?></td>
                <td class="tab-txt2"><a href="company_detail.php?a=<?php echo base64_encode($company_data["web_user_id"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
				
              </tr>
              
              <?php } } else{?>
		<tr>
                    <td style="color: red; padding:10px" colspan="8">No Records Found</td>
                </tr>
             <?php }?>
            </tbody>
            </table>
          </div>
        </div>
        <!--<div class="c-acc-status" align="center"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
        <div style="margin:20px auto; background:#fff; text-align:center;" class="bst">
            <div id="chart-container">A comparison of current revenues Months</div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom:0;">
					<p><strong>Add Central Payment</strong></p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</div>
                
                <!-- Begin # DIV Form -->
				<?php
                if(isset($_POST['add_company_payment']) and $_POST['add_company_payment']!=""){
                addTaxiCompanyPayment();
                //unset($_POST);
                HTMLRedirectURL(ZONE_URL."payement_print.php?id=".base64_encode($_POST['selComName']));
                }
                ?>
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="payment-form" method="post" action="" onSubmit="return addTaxiCompanyPayment();">
                        <div class="modal-body">

                            <!--<input id="login_username" class="form-control" type="text" placeholder="Corporate" required>-->
							<select name="selComName" id="selComName" class="form-control" required>
								<option value="">Select Central Name</option>
								<?php $query_sess_taxi = "SELECT name,id,web_user_id FROM taxicompany WHERE added_by = '".$_SESSION['uid']."' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
									$result_sess_taxi = mysql_query($query_sess_taxi);
									$num_rows = mysql_num_rows($result_sess_taxi);					
									if(isset($num_rows) && $num_rows>0){
									while($row = mysql_fetch_array($result_sess_taxi)){?>
										<option value="<?php echo $row['web_user_id'];?>"><?php echo $row['name'];?></option>
								<?php } }?>
							</select>
							<select name="selAmtType" id="selAmtType" class="form-control" style="margin-top: 10px;" required>
								<option value="">Select Type Quantity</option>
								<option value="activation">Activation</option>
								<!--<option value="paid">I paid</option>
                                <option value="non paid">non paid</option>-->
							</select>
							<!---<input type="text" name="fromDate" id="fromDate" class="datepicker-here form-control" placeholder="Start Date" />
							<input type="text" name="toDate" id="toDate" class="datepicker-here form-control" placeholder="End Date" />--->
							
                            <input id="txtamount" class="form-control" type="text" placeholder="Amount" name ="txtamount"  onkeypress="return IsNumeric(event);" required/>
							<span id="error" style="color: Red; display: none">* Type Number Value(0 - 9)</span>
                            <textarea class="form-control" type="text" placeholder="Comment" name ="txtMessage" id= "txtMessage" style="margin-top:10px;" required></textarea>

                        </div>
                        <div class="modal-footer">
                            <div id="btnNext" class="btnNe ">
                                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addTaxiCompanyPayment')?>" />
                                <input class="dash-button w100" type="button" data-toggle="modal" data-target="#myModal"  value="Confirmar" />
                            </div>							
                        </div>
                        
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Payment confirmation</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>you sure you want to pay this center</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        <!--<button type="submit" class="btn btn-primary" data-dismiss="modal" name="submit1" id="submit1">SI</button>-->
                                        <input type="submit" class="btn btn-primary" name="add_company_payment" id="add_company_payment" value="Yes" />

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                  
                    
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<!-- JQUERY SUPPORT -->
<!--<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>-->

<!-- datepicker -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
<script type="text/javascript">

// chart query from driver (Monthly basis)

FusionCharts.ready(function () { //$_POST['from_date'] 
	$.post('getData.php',{mode:'<?php echo base64_encode('getCentralMonthlyDetails');?>',id1:'chartId',from_date:'<?php echo $_POST['from_date'];?>',to_date:'<?php echo $_POST['to_date'];?>',po_non_paid:'<?php echo $_POST['non_paid'];?>',po_paid:'<?php echo $_POST['paid'];?>',po_activation:'<?php echo $_POST['activation'];?>'},function(data){
	var obj = jQuery.parseJSON(data);
	//console.log(obj.category);
		
    var revenueChart = new FusionCharts({
        type: 'column2d',
        renderAt: 'chart-container',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "The current Month and Year income or ongoing ",
                "subCaption": "Hi Taxi",
                "xAxisName": "Central List",
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
    }).render();
	
	});
    
});	

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
	
	// Amount payment for taxi company
	var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
                var inputId =  $(e.target).attr("id");
                if(inputId == 'txtamount'){
                    document.getElementById("error").style.display = ret ? "none" : "inline";
                }
            return ret;
        }
        
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
</script>