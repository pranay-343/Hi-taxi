<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style>
.btnHide{
	display: none !important;
}
.btnShow{
	display: block !important;
}
.btnCon {
	display: none;
}
</style>
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
            <div class="row wht bstsss">
            	<div class="col-sm-8">
              <h2 class="txt-style-3">Account Status: Corporate</h2>
              </div>
			  <div id="errorMessage"></div>
              <div class="col-sm-4">
              	<button class="dash-button hvr-wobble-horizontal w100 tcs ret f74" data-toggle="modal" data-target="#login-modal">Add Corporate Payment</button>
                <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom:0;">
					<p><strong>Add Corporate Payment</strong></p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</div>
                
                <!-- Begin # DIV Form -->
				<?php
                if(isset($_POST['amount_comfirm']) and $_POST['amount_comfirm']!=""){echo 'aaa';
                addCorporateAmount();
                unset($_POST);
                HTMLRedirectURL(TAXI_URL."account-status.php");
                }
                ?>
                <div id="div-forms">
                
                    <!-- Begin # Login Form -->
                    <form id="login-form" method="post" action="" onSubmit="return addCorporateAmount();">
                        <div class="modal-body">

                            <!--<input id="login_username" class="form-control" type="text" placeholder="Corporate" required>-->
							<select name="selCorName" id="selCorName" class="form-control" required>
								<option value="">Select Corporate</option>
								<?php
                  $query_to_driver = "SELECT * FROM corporate WHERE 1 AND added_by = '".$_SESSION['uid']."'";
									$result_to_driver = mysql_query($query_to_driver);
									$num_rows = mysql_num_rows($result_to_driver);					
									if(isset($num_rows) && $num_rows>0){
									while($row = mysql_fetch_array($result_to_driver)){?>
										<option value="<?php echo $row['web_user_id'];?>"><?php echo $row['name'];?></option>
								<?php } }?>
							</select>
                            <input id="txtamount" class="form-control" type="text" placeholder="Amount" name ="txtamount"  onkeypress="return IsNumeric(event);" required>
							<span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
                            <textarea class="form-control" type="text" placeholder="Message" name ="txtMessage" id= "txtMessage" style="margin-top:10px;" required></textarea>

                        </div>
                        <div class="modal-footer">
                            <div id="btnNext" class="btnNe ">
                                <button class="dash-button w100" style="margin-top:0;" id="nexPopup">Following</button>
                            </div>
							 <div class="btnCon">
                                <button type="button" class="dash-button w100" style="margin-top:0;" id="closeModal" >Cancel</button>
								<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addCorporateAmount')?>" />
								<input class="dash-button w100" type="submit" name="amount_comfirm" id="amount_comfirm" value="Confirm" />
                            </div>	
                        </div>
                    </form>
                  
                    
                </div>
                <!-- End # DIV Form -->
                
			</div>
		</div>
	</div>
              </div>
              </div>
              <br/>
                <form method="post" name="search" action="">
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> From </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Satrt Date"  name="start_date" value="<?php echo $_POST['start_date']?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> To </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date"  name="end_date" value="<?php echo $_POST['end_date']?>" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Type</label>
                  <ul>
                    <li> <input type="checkbox" name="travel" value="travel" <?php if (!empty($_POST['travel'])): ?> checked="checked"<?php endif; ?> /> <span>Travel</span> </li>
                    <li> <input type="checkbox" name="activation" value="activation"  <?php if (!empty($_POST['activation'])): ?> checked="checked"<?php endif; ?> /> <span>Payment</span> </li>
                  </ul>
                    </div>
                  </div>
                <div class="clearfix"></div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Corporation</label>
                      <input type="text" name="txtCorName" class="input-style" placeholder=" Corporate Name" value="<?php echo $_POST['txtCorName']?>" />
                    </div>
                  </div>
                  
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>State</label>
                  <ul>
                    <li> <input type="checkbox" name="paid" value="" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?> /> <span>Paid</span> </li>
                    <li> <input type="checkbox" name="non_paid" value=""  <?php if (!empty($_POST['non_paid'])): ?> checked="checked"<?php endif; ?> /> <span>Non Paid</span> </li>
                  </ul>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-12" style="text-align:center;">
                      <button class="dash-button hvr-wobble-horizontal" type="submit" name="submit" id="chartId">Search</button>
                  </div>
                </div>
              </form>
                <?php                 
                    if(isset($_POST['submit'])){                       
                        $name = "AND login.name LIKE '%" . $_POST['txtCorName'] . "%'";
                        if($_POST['start_date'] != '' && $_POST['end_date'] != ''){
                            $date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($_POST['start_date']))."' AND  '".date('Y-m-d',strtotime($_POST['end_date']))."'+ INTERVAL 1 DAY";
                        }
						if($_POST['activation'] != ''){
							$payment_acti = "AND manage_master_amount.amount_type LIKE '%" . $_POST['activation'] . "%'";
						}
						if($_POST['paid'] != ''){
							$paid = "AND manage_master_amount.amount LIKE '%" . $_POST['paid'] . "%'";
						}
						if($_POST['travel'] != ''){
							$travel = "AND manage_master_amount.amount_type LIKE '%" . $_POST['travel'] . "%'";
						}
                    }
                    else{
                        $name = '';
                        $date = '';
						$paid = '';
						$payment_acti = '';
                    }
                    //Total all user credit limit query for corporation                        
						$query_total_cre ="SELECT SUM(manage_master_amount.amount) as totalCre FROM manage_master_amount WHERE added_by='".$_SESSION['uid']."' $date";   
						$result_total_cre = mysql_fetch_array(mysql_query($query_total_cre));	
						$total_cre_amt = $result_total_cre['totalCre'];
					
					// Total user amount use by croporate users  for corporation
						$current_date = date('Y-m-d');					
						$query_used_amt = "SELECT SUM(manage_master_amount.amount) as usedAmt FROM manage_master_amount WHERE added_by='".$_SESSION['uid']."' AND end_date_time<='$current_date' $date";
						$result_used_amt = mysql_fetch_array(mysql_query($query_used_amt));	
						$total_used_amt = $result_used_amt['usedAmt'];						
						$total_rema_cre_amt = $total_cre_amt - $total_used_amt;				
							
                ?>
                <div class="bst">
              <h2 class="txt-style-4"> CORPORATE NET BALANCE : <?php if($total_rema_cre_amt){echo CURRENCY.$total_rema_cre_amt;}else{echo CURRENCY.'0.00';}?></h2>
              <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1">Income</th>
                <th class="tab-txt1">Outcome</th>
                <th class="tab-txt1">Date and time</th>
                <th class="tab-txt1">Type</th>
                <th class="tab-txt1">Status</th>
                <th class="tab-txt1">Observations</th>
                <th class="tab-txt1">Corporate Name</th>
                <th class="tab-txt1">Mor Information</th>
              </tr>
                <?php 
                    
                
                    /*//List all corporation users
                        $query =" SELECT  * FROM corporate "
                              . " WHERE company_id='".$_SESSION['uid']."' $name $date";
                          $result = mysql_query($query);
                          $num_rows = mysql_num_rows($result);
                          if($num_rows>0){
                          while($row=mysql_fetch_array($result)){
                              
                     // List corporation user amount used         
                        $query_total = " SELECT users.id,users.corporate_id,account.payment_amount, account.id,account.customer_id, SUM(account.payment_amount) as total_amount  FROM users"
                             . " JOIN account ON users.id = account.customer_id"
                             . " WHERE corporate_id ='".$row['web_user_id']."' AND payment_mode !='cash'";
                             $result_user_total =mysql_query($query_total);
                             while ($row1 = mysql_fetch_array($result_user_total)) {
                               $amount_used =$row1['total_amount'];
                             }
							 
							 $query_credit = "SELECT SUM(manage_master_amount.amount) as manageAmt, added_on FROM manage_master_amount WHERE zone_id='0' AND company_id ='".$_SESSION['uid']."' AND corporate_id ='".$row['web_user_id']."' AND type='credit_amount'";
							 $result_manage_total =mysql_query($query_credit);
                             while ($row_manage_total = mysql_fetch_array($result_manage_total)) {
                                $amount_manage_total =$row_manage_total['manageAmt'];
                             }
                             $outcome_amt = ($amount_manage_total+$row['begning_credit'])- $amount_used;
							 */
						$query_corporation = "SELECT manage_master_amount.*,login.name as corpName, login.id as corpId FROM manage_master_amount LEFT JOIN login ON manage_master_amount.corporate_id = login.id
						where manage_master_amount.added_by ='".$_SESSION['uid']."' AND zone_id='0' AND manage_master_amount.crop_mb_u_id ='0' $name $date $travel $payment_acti";
						$result_corporation = mysql_query($query_corporation);
						$num_rows = mysql_num_rows($result_corporation);
						if($num_rows>0){
						while($data_coporation = mysql_fetch_array($result_corporation)){
							//echo $data_coporation['start_date'];
							$start_date = $data_coporation['start_date'];
							$end_date = $data_coporation['end_date_time'];
              
                                                         $query_user_outcome = "SELECT users.id, users.added_by, SUM(manage_master_amount.amount) as userLimit FROM users LEFT JOIN manage_master_amount ON users.id = manage_master_amount.crop_mb_u_id WHERE users.added_by = '".$data_coporation['corporate_id']."' AND users.added_on >='$start_date' AND users.added_on<='$end_date' + INTERVAL 1 DAY";
							$result_user_data = mysql_fetch_array(mysql_query($query_user_outcome));
							
							$outcome_amount = $result_user_data['userLimit'];
                ?>
                    <tr>
                      <td class="tab-txt2"><?php echo CURRENCY.$data_coporation['amount']?></td>
                      <td class="tab-txt2"><?php echo CURRENCY.$outcome_amount; ?></td>
                      <td class="tab-txt2"><?php echo date('Y-m-d', strtotime($data_coporation['added_on']));?></td>
                      <td class="tab-txt2">Activate Taxi</td>
                      <td class="tab-txt2">Payment</td>
                      <td class="tab-txt2">REF1</td>
                      <td class="tab-txt2"><?php echo $data_coporation['corpName']?></td>
                      <td class="tab-txt2"><a href="javascript:void(0)"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
                    </tr>
                    <?php } }else{?>
                    <tr>
                        <td style="color: red; padding: 10px;" colspan="8"> No Records founds</td>
                    </tr>
                    <?php }?>
            </table>
            <div style="margin:20px auto; background:#fff; text-align:center;">
        		<div id="chart-container">The comparison of current revenues Months</div>
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

$(document).ready(function (){
	$("#btnNext").click(function(){
		if(($('#selCorName').val()!='') ||($('#txtamount').val()='') || ($('#txtMessage').val()!='')){
			$(".btnNe").addClass("btnHide");
			$(".btnCon").addClass("btnShow");
			$("btnShow").removeClass("btnCon");
			$('#selCorName').prop('readonly', true);
			$('#txtamount').prop('readonly', true);
			$('#txtMessage').prop('readonly', true);
			return false;
		}
	});	
});

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
/*
$(function() {
      $("#companyNotifi").validate({
        rules: {
            selCompanyName:'required',           
        },
        submitHandler: function(form) {
            var formData =$("#companyNotifi").serialize();
                  $.ajax({
                        url: "<?php MAIN_URL?>",
                        type: "POST",                
                        data: formData,
                        beforeSend: function() {
                        },
                        }).done(function(data) {                            
                            document.getElementById('seclet_notify_advisor').innerHTML=data;
                             $('.modal-header .close').trigger('click');  
                        });
            },  
        });
    });*/
// chart query

FusionCharts.ready(function () {
	$.post('getData.php',{mode:'<?php echo base64_encode('getCorporateMonthlyDetails_new');?>',idC:'chartId',from_date:'<?php echo $_POST['start_date'];?>',to_date:'<?php echo $_POST['end_date'];?>',txtCorName:'<?php echo $_POST['txtCorName']?>',to_date:'<?php echo $_POST['end_date'];?>',txtCorName:'<?php echo $_POST['txtCorName']?>',activation:'<?php echo $_POST['activation'];?>',travel:'<?php echo $_POST['travel']?>'},function(data){
	var obj = jQuery.parseJSON(data);
	console.log(obj.income);
	var revenueChart = new FusionCharts({
        type: 'mscolumn2d',
        renderAt: 'chart-container',
        width: '500',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "The comparison of current revenues Months (<?php echo date('Y')?>)",
                "xAxisname": "Current month (<?php echo date('Y')?>)",
                "yAxisName": "Income (In USD)",
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
                    "seriesname": "Current Months income",
                    "data": obj.income
                }, 
                {
                    "seriesname": "Current month Outcome",
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
</script>
<script type="text/javascript">
/* #####################################################################
   #
   #   Project       : Modal Login with jQuery Effects
   #   Author        : Rodrigo Amarante (rodrigockamarante)
   #   Version       : 1.0
   #   Created       : 07/29/2015
   #   Last Change   : 08/04/2015
   #
   ##################################################################### */
   
$(function() {
    
    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

   //$("form").submit(function () {
   
    
    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
    
    function msgFade ($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function() {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }
    
    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function() {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
  		}, $msgShowTime);
    }
});

        var $start = $('#start'),
        $end = $('#end');
        $start.datepicker({
                language: 'en',
                onSelect: function (fd, date) {
                        $end.data('datepicker')
                                .update('minDate', date)
                }
        });
        $end.datepicker({
                language: 'en',
                onSelect: function (fd, date) {
                        $start.data('datepicker')
                                .update('maxDate', date)
                }
        });
</script>
</body>
</html>