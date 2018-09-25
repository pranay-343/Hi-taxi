<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 

$id = base64_decode($_GET['a']);
$data1 = mysql_fetch_assoc(mysql_query("select * from `login` where 1 and id = '$id'"));
$taxicomDetail = mysql_fetch_assoc(mysql_query("select * from `taxicompany` where 1 and web_user_id = '$id'"));
$fId=$taxicomDetail['web_user_id'];
// $fileUpload = mysql_fetch_assoc(mysql_query("select * from `files_upload` where 1 and login_id = '$fId'"));

?>
    <body class="k10">
    <?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php';?>
        <div class="c-acc-status mg0">
        
        <?php
        
                  // For total balance 
                $total_com_balance = "SELECT SUM(manage_master_amount.amount) as total_amt FROM manage_master_amount WHERE company_id = '$id' AND corporate_id ='0'";
                $res_com_balance = mysql_query($total_com_balance);
                $data_total_bal = mysql_fetch_array($res_com_balance);  
        
		$sql2 = "select driver.*, trip.*, (select SUM(trip.trip_ammount) from trip where 1 and driver.id = trip.driver_id) as TOTAL_AMT from driver LEFT JOIN trip ON driver.id = trip.driver_id where 1 and driver.company_id = '$id'";
		$res2 = mysql_query($sql2);
		while($row2 = mysql_fetch_object($res2))
		{
			$total_amt+=$row2->TOTAL_AMT;
		}
		?>
		
		<?php
		
      /* $query1 ="SELECT SUM(amount) as amount FROM `manage_master_amount` WHERE `zone_id` ='".$_SESSION['uid']."' AND `company_id`='".$id."'";
        $query1sql=mysql_query($query1);
		$row1=mysql_fetch_array($query1sql);*/
		?>
        <div>
        	<h4 class="bal_setting">The total balance of the company:<?php echo CURRENCY.$data_total_bal['total_amt'];?>
            <?php //echo $row1['amount']; 
		if($total_amt!='')
		{
			//echo $total_amt;
			}
		else
			{
				//echo "0";	
			}	
		?>  </h4>
        <h4 class="bal_setting">The actual balance:<?php echo CURRENCY.$data_total_bal['total_amt'];?>
            <?php //echo $row1['amount']; 
		if($total_amt!='')
		{
			//echo $total_amt;
			}
		else
			{
				//echo "0";	
			}	
		?>  </h4>
         <a href="http://www.hvantagetechnologies.com/central-taxi/zone-admin/account-status.php"><input type="submit" name="account" id="update_central" value="Cuenta" class="dash-button hvr-wobble-horizontal w10 wap wer" style="margin-bottom:17px;"/></a>
          <h2 class="txt-style-3">Edit Central</h2>
          <?php
if(isset($_POST['update_central']) and $_POST['update_central']!=""){
editUpdateTaxiCentralByZone();
unset($_POST);
}

		  ?>
          <form method="post" name="" action="" enctype="multipart/form-data">
              <input type="hidden" name="web_user_id" value="<?php echo $id;?>" />
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>NAME</label>
                  <input type="text" name="Company_name" id="Company_name" class="input-style" placeholder="Name" value="<?php echo $taxicomDetail['name']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>ADDRESS</label>
                  <input type="text" name="address" id="address" class="input-style" placeholder="ADDRESS" value="<?php echo $taxicomDetail['address']?>"/>
                </div>
              </div>              
              <div class="col-sm-4">
                <div class="form-group">
                  <label>COUNTRY</label>
                  <input type="text" name="country" id="country" class="input-style" placeholder="COUNTRY" required value="<?php echo $taxicomDetail['country'];?>"/>
                </div>
              </div>  
            
              <div class="col-sm-4">
                <div class="form-group">
                  <label>PHONE NO.</label>
                  <input type="text" name="contactno" id="contactno"  class="input-style" placeholder="Contact Number�" value="<?php echo $taxicomDetail['contact_number']?>" onKeyPress="return IsNumeric(event);"/>
                  <span id="error" style="color: Red; display: none">Type Numeric Value(0 - 9)</span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>PER WEEK ACTIVATION COST</label>
                  <input type="txt" name="per_week_cost" id="per_week_cost" class="input-style" style="color:#999;" placeholder="Introduzca texto aquí"  onkeypress="return IsNumeric(event);" value="<?php echo $taxicomDetail['per_week_cost']?>">
                  <span id="error1" style="color: Red; display: none">Type Numeric Value (0 - 9)</span>
                  </select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>WORKING LIMITS</label>
<!--                  <input type="text" name="worklimit" id="worklimit" class="input-style" placeholder="Introduzca texto aquí"  onkeypress="return IsNumeric(event);" value="<?php echo $taxicomDetail['work_limit']?>"/>
                  <span id="error2" style="color: Red; display: none">Input digits (0 - 9)</span>-->
                  <select name="worklimit" id="worklimit" class="input-style">
                      <option value="">Select</option>
                        <?php

                                $x = 1;
                         while ($x <= 100) {?>
                      <option <?php if ($taxicomDetail['work_limit']) {
                    echo (($taxicomDetail['work_limit'] == $x ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
                         <?php   $x++;}?>                           
                  </select>
                </div>
              </div>
           
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Email id</label>
                  <input type="text" name="emailID" class="input-style" placeholder="Email Id" value="<?php echo $data1['email']?>" required/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Password</label>
                  <input type="text" name="password" class="input-style input-style1" placeholder="Enter Password" required value="<?php echo $data1['password_de']?>"/>
                  
                </div>
              </div>  
				<div class="col-sm-4">
					<div class="form-group">
					  <label>New Password</label>
					  <input type="password" name="newpassword" class="input-style" placeholder="New Password"/>
					</div>
				</div> 
        <!-- by dinesh -->
         <div class="col-sm-12">
                <div class="form-group">
                  <ul>
                    <li>
                      <input type="checkbox" name="systemAllow" id="systemAllow" value="1" checked>
                      <span>Full system company</span></li>
                  </ul>
                </div>
              </div>			  
            <!-- by dinesh -->
              <div class="col-sm-12">
              <div class="form-group">
                     <label> <strong>FILES  :-</strong> </label>
                     </div>
              </div>
              
              <?php 
              $str ="select * from `files_upload` where 1 and login_id = '$fId' ";
              $res=mysql_query($str);
              while($row=mysql_fetch_array($res))
              {                
              ?>
              <div class="col-sm-4 btsa">
                <div class="files">
                     	<ul>
                        	<li>
                                    <a href="<?php echo  TAXI_URL?>/upload_file/<?php echo $row['file_name'];?>" download title="Download Here"><?php echo $row['name'];?></a>
                            <!--<a href="<?php //echo  TAXI_URL?>/upload_file/<?php echo $row['file_name'];?>" download><img height="100" width="100" src="<?php //echo  TAXI_URL?>/upload_file/<?php //echo $row['file_name'];?>" /></a>-->
                          </li>
                        </ul>
                     </div>
              </div>
              <?php
              }
              ?>
           
              <div class="clearfix"></div>
             
              <div class="col-sm-12 wap">
                <div class="files field_wrapper">
                  <ul>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add_morenew.png"/></a>
                    <input type="file" name="file_name[]" class="s4a" value=""/>
                   <div class="clearfix"></div>
                  </ul>
                </div>
              </div>
           <div class="clearfix"></div>
              <!--div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100 wap wer">agregar archivos</button>
              </div-->
              <div class="col-sm-4" >                  
                    <input type="hidden" name="city" id="locality" value="" />
                    <input type="hidden" name="state" id="administrative_area_level_1" value="" />
                    <input type="hidden" name="latitude" id="latitude" value="" />
                    <input type="hidden" name="longitude" id="longitude" value="" />
                  <!--<button class="dash-button hvr-wobble-horizontal w100" type="submit">save</button>-->
                  <input type="submit" name="update_central" id="update_central" value="Save" class="dash-button hvr-wobble-horizontal w100 wap wer" />
              </div>
            </div>
          </form>
          
         
          <div class="clearfix"></div>
        </div>
		<div class="clearfix"></div>
         
		<div class="c-acc-status mg5 bst">
		 <h2 class="txt-style-3">Taxistas</h2>
			<table width="100%" id="viewAdministrator" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
				<thead>
					<tr>
						<th width="20%" class="tab-txt1">Name</th>
						<th width="20%" class="tab-txt1">Status</th>
						<th width="20%" class="tab-txt1">More Information</th>
					</tr>
					<?php 
						$current_date= date('m/d/Y');						
						$query_driver_list ="SELECT * FROM driver WHERE  added_by = '$id'";
						$result_driver = mysql_query($query_driver_list);
						if(mysql_num_rows($result_driver)>0){
							while($row_driver = mysql_fetch_array($result_driver)){
								
						 $linkss = '<a href="'.ZONE_URL.'driver_trip_detail.php?a=' . base64_encode($row_driver['id']) . '"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a>';
						
					?>
					<tr>
						<td width="20%" class="tab-txt2"><?php echo $row_driver['name'];?></td>
						<?php $query_driver_act ="SELECT * FROM driverPayment WHERE driver_name = '".$row_driver['id']."' AND (driverPayment.paymentDateFrom>='$current_date' OR driverPayment.paymentDateTo<='$current_date')";
						$rows = mysql_num_rows(mysql_query($query_driver_act));
						?>
						<td width="20%" class="tab-txt2"><?php if($row_driver['status']=='200'){echo 'Active';}else{echo 'Inactive';}?></td>
						<td width="20%" class="tab-txt2"><?php echo $linkss;?></td>
					</tr>
					<?php }} else{?>
					<tr>
						<td style='color:red;padding:10px;' colspan='3'>No Records Founds</td>
					</tr>
					<?php }?>
				</thead>
			</table>
		</div>	
		 <h2 class="txt-style-3 txt-style-31">Status</h2>        
          <div class="row bst tre">        	
              <div class="col-sm-12">
                  <div id="chart-container-can-com-reported">Fusion Charts Here</div>            
              </div>
          </div>
          <br/>


          <h2 class="txt-style-3 txt-style-31">Triggered alarms</h2>        
          <div class="row bst tre">         
              <div class="col-sm-12">
                  <div id="chart-container-alarams">Fusion Charts Here</div>                    
              </div>
          </div>
          <br/>

          <h2 class="txt-style-3 txt-style-31">Travel time</h2>

          <div class="row bst tre">

              <div class="col-sm-12">
                  <div id="average_time_taxi">Fusion Charts Here</div></div>
          </div>
          <br/>



          <h2 class="txt-style-3 txt-style-31">Average rating drivers</h2>        
          <div class="row bst tre">          
              <div class="col-sm-12">
                  <div id="chart-container-dr-rating">Fusion Charts Here</div>                
              </div>
          </div>
          <br/>

          <h2 class="txt-style-3 txt-style-31">Average payment</h2>

          <div class="row bst tre">
              <div class="col-sm-12">
                  <div id="chart-container-avg-payment">Fusion Charts Here</div></div>
          </div>
          <br/>

          <h2 class="txt-style-3 txt-style-31">Corporate Travel vs normal travel</h2>

          <div class="row bst tre">

              <div class="col-sm-12">
                  <div id="chart-container-crop-user">Fusion Charts Here</div></div>
          </div>
          <br/>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<!-- JQUERY SUPPORT -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>

<!-- datepicker -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
    $("#autocomplete").on('focus', function () {
    geolocate();
    });

    var placeSearch, autocomplete;
    var componentForm = {
      //  street_number: 'short_name',
      //  route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name'
       // postal_code: 'short_name'
    };

    function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
       (document.getElementById('address')), {
            types:  ['geocode']
        });
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress();
        });
    }
    
    
    
     var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
                var inputId =  $(e.target).attr("id");
                if(inputId == 'contactno'){
                    document.getElementById("error").style.display = ret ? "none" : "inline";
                }
                if(inputId == 'per_week_cost'){
                    document.getElementById("error1").style.display = ret ? "none" : "inline";                   
                }
                if(inputId == 'worklimit'){
                    document.getElementById("error2").style.display = ret ? "none" : "inline";
                }
            return ret;
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
        
        


// [START region_fillform]
function fillInAddress() {
    var place = autocomplete.getPlace();
    document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();
    for (var component in componentForm) {
    }
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }
}

initialize();
</script>
<script type="text/javascript">
$(document).ready(function () {
  var maxField = 20; //Input fields increment limitation
  var addButton = $('.add_button'); //Add button selector
  var wrapper = $('.field_wrapper'); //Input field wrapper
  var fieldHTML = '<ul><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a><input type="file" name="file_name[]" value="" class="s4a" /><div class="clearfix"></div></ul>'; //New input field html 
  var x = 1; //Initial field counter is 1
  $(addButton).click(function () { //Once add button is clicked
    if (x < maxField) { //Check maximum number of input fields
      x++; //Increment field counter
      $(wrapper).append(fieldHTML); // Add field html
    }
  });
  $(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
    e.preventDefault();
    $(this).parent('ul').remove(); //Remove field html
    x--; //Decrement field counter
  });
});

</script>

<script>
    //average_time_taxi
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart4 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-can-com-reported',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Number of completed services",
                    "data": obj.completed.completed
                }, 
                {
                    "seriesname": "Number of canceled services",
                    "data": obj.cancle_trip.cancle_trip          
                }, 
                {
                    "seriesname": "Number of reported services",
                    "data":obj.reported.reported
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

  });
  
});
</script>
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart2 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-alarams',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Number of active alarms",
                    "data":  obj.averageAlerted.averageAlerted
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();
  });  
});
</script>
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
	var obj = jQuery.parseJSON(data);
	console.log(obj.Active);
var visitChart = new FusionCharts({
        type: 'msline',
        renderAt: 'average_time_taxi',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                   "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
			
                {
                    "seriesname": "Average waiting time",
                    "data": obj.averageTimeed.averageTimeed
                },
                {
                    "seriesname": "Average travel time",
                    "data":  obj.averageTripTimeed.averageTripTimeed
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

	});
	
});
</script>
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart5 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-dr-rating',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                   "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "star rating",
                    "data": obj.averageRatinged.averageRatinged
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

  });
  
});
</script>
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart6 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-avg-payment',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Average Payment",
                    "data":obj.averagePaymented.averagePaymented
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

  });
  
});
</script>
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getSingleComDetails');?>',a:'<?php echo base64_decode($_GET['a'])?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart7 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-crop-user',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                   "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Corporate travel",
                    "data":obj.corporated.corporated
                },
                {
                    "seriesname": "Normal travel",
                    "data":obj.userapped.userapped
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

  });
  
});
</script>