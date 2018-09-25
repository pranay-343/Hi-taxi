<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$data = mysql_fetch_array(mysql_query("select * from `driver` where 1 and id = '".$_GET['a']."'"));
if($data['insurance_expired'] == '1')
{
  $insurance_expired = 'checked';
}
else
{
  $insurance_expired = ''; 
}
if($data['insurance_overdue'] == '1')
{
  $insurance_overdue = 'checked';
}
else
{
  $insurance_overdue = ''; 
}
if($data['non_payment'] == '1')
{
  $non_payment = 'checked';
}
else
{
  $non_payment = ''; 
}
if($data['status'] == 200)
  {$active = 'checked';}
if($data['status'] == 99)
  {$block = 'checked';}
if($data['status'] == 400)
  {$suspend = 'checked';}

if($data['image'] != '' || $data['image'] != null)
{$img = $data['image'];}
else
{$img = '../images/profile.png';}
?>
<link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
<body class="test4">
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
              <h2 class="txt-style-3">Taxi Driver</h2>
<?php
if(isset($_POST['editDriver']) and $_POST['editDriver']!=""){
editDriver();
unset($_POST);
}
?>
              <form method="post" enctype="multipart/form-data">
              <div class="row viewtaxi_driver">
                	<div class="col-md-8">
                    	<h2> <?php echo $data['name'];?> </h2>
                        <div class="row">
                        	<div class="col-md-4">
                            	<img id="driverImage" src="<?php echo $img;?>">
                            </div>

                        	<div class="col-md-4">
                            	<ul>
                   				 <li> <input type="radio" name="status" id="status" value="200" <?php echo $active;?>/> <span>Active</span> </li>
                   				 <li> <input type="radio" name="status" id="status" value="99" <?php echo $block;?>/> <span>In-Active</span> </li>
                   				 <li> <input type="radio" name="status" id="status" value="400" <?php echo $suspend;?>/> <span>Suspend</span> </li>
                  				</ul>
                            </div>
                            
                        	<div class="col-md-4">
                            <ul class="koi">
                              <li> <input type="checkbox" name="insurance_expired" id="insurance_expired" <?php echo $insurance_expired;?> value="0"/> <span> Insurance expired</span> </li>
                              <li> <input type="checkbox" name="insurance_overdue" id="insurance_overdue" <?php echo $insurance_overdue;?> value="0"/> <span>License expired</span> </li>
                              <li> <input type="checkbox" name="non_payment" id="non_payment" <?php echo $non_payment;?> value="0"/> <span>Non-Payment</span> </li>
                  			</ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4" style="border-left:1px solid #CCC;">
                      <table width="95%" border="0" class="list_quality">
                        <tr>
                          <td style="font-size:16px; font-weight:bold; padding-bottom:10px; border-top:none;">Ratings</td>
                        </tr>
            <tr>
							<td style="font-size:22px; text-align:center; padding:10px 0px; ">
							  <?php
							   $query_rating="SELECT SUM(customer_rating) as rating, COUNT(customer_rating) as countRate FROM `trip` 
							  where `trip`.driver_id='".$_REQUEST['a']."' and `trip`.account_type='99' AND `trip`.trip_mode = 'complete'";
								$result_rating= mysql_query($query_rating);
								$data_rating = mysql_fetch_array($result_rating);
								if($data_rating['countRate']!='0'){
									$total_rating = $data_rating['rating']/$data_rating['countRate'];
									$rating = (int)($total_rating);
								?>
								<?php for($i= 1; $i<=$rating; $i++){ ?>
								<i class="fa fa-star"></i>
								<?php }?>
									
							</td>
						</tr>
						<tr>
						  <td>Very Correct 
						   <?php for($i= 1; $i<=$rating; $i++){ ?>
						  <strong>
						  <i class="fa fa-star"></i>
						  </strong>
						   <?php }?>
						  </td>
						</tr>
						<?php
						}else{
							echo'<p>No Rating<p>';
						}?>
						
                      </table>
                    </div>
            	</div>
                
                <div class="row bts" style="border-top:1px solid #CCC; margin:0px; padding-top:30px;">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Name </label>
                      <input type="text" name="name" class="input-style" placeholder="Enter Name Here" value="<?php echo $data['name'];?>" required/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Email </label>
                      <input type="text" name="username" class="input-style" placeholder="Enter User Name Here" value="<?php echo $data['username'];?>" required/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Contact Number </label>
                      <input type="text" name="contactno" class="input-style" placeholder="Enter Telephone no. Here" value="<?php echo $data['contact_number'];?>" required/>
                    </div>
                  </div>
				  <!-- Start-->
					<div class="col-sm-4">
						<div class="form-group">
						  <label> LICENSE PLATE NUMBER </label>
						  <input type="text" name="liecence_number" class="input-style" placeholder=" LICENSE PLATE NUMBER" value="<?php echo $data['liecence_number'];?>" required/>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
						  <label> INSURANCE EXPIRATION DATE </label>
						  <input type="text" name="insurance_expiration_date" id="insurance_expiration_date" class="datepicker-here input-style after_current_date" placeholder="INSURANCE EXPIRATION DAT " value="<?php echo $data['insurance_expiration_date'];?>" required/>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
						  <label> LICENSE EXPIRATION DATE</label>
						  <input type="text" name="licence_expiration_date" id="licence_expiration_date" class="datepicker-here input-style after_current_date" placeholder="LICENSE EXPIRATION DATE " value="<?php echo $data['licence_expiration_date'];?>" required/>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
						  <label> VEHICLE CONTACT NUMBER</label>
						  <input type="text" name="vehicle_contact" id="vehicle_contact" class="input-style" placeholder="VEHICLE CONTACT NUMBER" value="<?php echo $data['vehicle_contact'];?>" required/>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
						  <label> WAY FARE PER KM</label>
						  <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="WAY FARE PER KM" value="<?php echo $data['trip_fare'];?>" required/>
						</div>
					</div>
				  
                 <!-- End-->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> VEHICLE </label>
                      <input type="text" name="vehicle_name" class="input-style" placeholder="Enter VEHICLE" value="<?php echo $data['vehicle_name'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>VEHICLE OWNER</label>
                      <input type="text" name="vehicle_owner_name" class="input-style" placeholder="Enter Vehicle Owner Name Here" value="<?php echo $data['vehicle_owner_name'];?>"/>
                    </div>
                  </div>
				  
				   <div class="col-sm-4">
                  <div class="form-group">				  
                     <label>Zone Name </label>
                    <select name="driver_zone" class="input-style" id="driver_zone">
                    <option value="">---Select Zone---</option>
					<?php
					  $qry_main_zone = mysql_query("SELECT * FROM zone_cordinater_driver WHERE zone_cordinater_driver.added_by ='".$_SESSION['uid']."'");
                      while($dataa = mysql_fetch_array($qry_main_zone))
					  {
						  if($dataa['id'] == $data['zone_id'])
						  {
						  $selected = "selected";
						  }
						  else
						  {
							  $selected = '';
						  }
					  ?>
					 <option value="<?php echo $dataa['id'];?>" <?php echo $selected;?>><?php echo $dataa['cordinate_title'];?></option>
					<?php }?>
					
                     </select>
                    <input type="hidden" name="driver_zoneaera" value="<?php if( $data['zone_primary_id']){echo $data['zone_primary_id'];}else{echo'0';}?>"/> 
                    </div>
                  </div>
				  
				  
                </div>
          <div class="col-sm-4">
                  <div class="form-group">          
                     <label>Primary Zone </label>
                    <select name="driver_zoneaera" class="input-style" id="driver_zoneaera">
                    
          <?php 
            // Main zone area
            $query_zone = "SELECT taxicompany.name, taxicompany.web_user_id, zone_cordinater.cordinate_title as zcTitle,zone_cordinater.zone_area_id as zcId, zone_area.id as ZAid,zone_area.zone_title as ZATitle FROM zone_cordinater 
            LEFT JOIN taxicompany ON zone_cordinater.zone_area_id = taxicompany.zone_area_id_sess
            LEFT JOIN zone_area ON zone_cordinater.zone_area_id = zone_area.id
            WHERE 1 and taxicompany.web_user_id ='".$_SESSION['uid']."'";
            $result_zone =mysql_fetch_array(mysql_query($query_zone));
          ?>                    
          <option value="<?php echo $result_zone['zcId'];?>" selected="selected"><?php echo base64_decode($result_zone['ZATitle']);?></option>
                    </select>
                    </div>
                  </div>
                <div class="files archive_files">
                <label> Files</label>
                <ul>
                <?php
					$qryFIles = mysql_query("select * from `files_upload` where added_by = '".$_GET['a']."'");
					while($dataFiles = mysql_fetch_array($qryFIles))
					{
					?>
					<div>
                    <li><a href="upload_file/<?php echo $dataFiles['file_name'];?>" download title="Download Here"><?php echo $dataFiles['name'];?></a></li>
					</div>
					<?php
					}
				?>
                </ul>
                <div class="clr"> </div>
                <div class="field_wrapper">
                    <div>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
                        <input type="file" name="file_name[]" value="" class="s4a"/>
                        <div class="clearfix"></div>
                    </div>
                </div>
				<div class="clr"> </div>
               
                <div class="col-md-4"> </div>
                	<div class="col-md-4">
                    <input type="hidden" name="driverId" id="driverId" value="<?php echo $_GET['a'];?>" />
                    <input class="dash-button hvr-wobble-horizontal w100 wap" type="submit" name="editDriver" id="editDriver" value="Update Driver" />
                    </div>
                <div class="col-md-4"> </div>
                </div>
                </form>
                <br/><br/>
                <div id="ErrorMsg"></div>
                <div class="row bst" style="margin-top:40px;">
                	<div class="col-md-7 pad0">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#FFF;">
              <tr>
                <th class="tab-txt1">Name</th>
                <th class="tab-txt1">Date And Time</th>
                <th class="tab-txt1">TRAVEL PAYMENT</th>
                <th class="tab-txt1">More Information</th>				
              </tr>
	<?php 
        //  $query = "SELECT * FROM trip WHERE driver_id = '".$_GET['a']."'";
      $query="SELECT `trip`.driver_id,`driver`.id,`driver`.name,`trip`.tripdatetime,`trip`.account_type,`trip`.id as tripid, `trip`.trip_ammount FROM `trip`
              LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id where `trip`.driver_id='".$_REQUEST['a']."' and `trip`.account_type='99'";
					$result= mysql_query($query);
					$num_rows = mysql_num_rows($result);
					if(isset($num_rows) && $num_rows>0){
						while($rows = mysql_fetch_array($result)){
							$total_trip_amt += $rows['trip_ammount'];
       //echo base64_encode($rows['id']);

			?>
              <tr>
                <td class="tab-txt2"><?php echo $rows['name'];?></td>
                <td class="tab-txt2"><?php echo $rows['tripdatetime'];?></td>
				        <td class="tab-txt2"><?php echo $rows['trip_ammount'];if($rows['trip_ammount']){echo'.00';}else{echo '0.00';} echo 'MX'?></td>
                <td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($rows['tripid']);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
              </tr>
			<?php }}else{ ?>
            
			 <tr>
          <td style="color: red; padding: 10px;" colspan="3">No records found</td>
			</tr>		
			<?php }?>
            <tr>
              <td class="tab-txt2 table_totl" colspan="3">Payment to taxi central </td>
              <td class="tab-txt2 table_totl"><?php echo $total_trip_amt.'.00 MX';?></td>
            </tr>
           <tr>
              <td class="tab-txt2 table_totl" colspan="3">Total Amount </td>
              <td class="tab-txt2 table_totl">200 MX</td>
            </tr>

            
            </table>
                    </div>
                 <form method="post" class="mg45">
                    <div class="col-md-5 pad0">
                    <h2 class="txt-style-3" style="margin-bottom:0;">Description</h2>
				   <textarea name="suspend_description" id="suspend_description" rows="3" class="input-style tar" style="background-color: #cacaca;" required="required"><?php echo $data['suspend_description'];?></textarea>
				   <a class="dash-button" style="margin: 15px 5px 0 125px; width: 200px;" data-toggle="modal" data-target="#login-modal" >Suspend</a>
                    
					<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
						<div class="modal-dialog">							
							<div class="modal-content">
								<div class="modal-header" style="padding-bottom:0;">
									<p><strong>Suspender conductor</strong></p>
									<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
										<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
									</button>-->
									<div class="modal-body">
									  <p>Are you want to sure suspend the taxi driver</p>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal" style="background: #BDBDBD;">No</button>
									  <button type="button" style="background: #E6C010;" class="btn btn-default" data-dismiss="modal" onClick="return accountSuspend('<?php echo base64_encode('accountSuspendDriver')?>','<?php echo $_GET['a'];?>');">Yes</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					
					
					</div>
               
                <!--<div class="row" style="margin-top:20px;">					
					<div class="col-lg-12">
						<button class="dash-button hvr-wobble-horizontal" style="margin-top:0px;" onClick="return accountSuspend('<?php //echo base64_encode('accountSuspendDriver')?>','<?php //echo $_GET['a'];?>');">SUSPEND</button>
                    </div>
                </div>-->
                </form>
              <br/>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
//include '../include/footer.php'; 
?>
         <script src="<?php echo MAIN_URL; ?>js/jquery.js"></script>
    <script src="<?php echo MAIN_URL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo MAIN_URL; ?>js/modernizr-custom.js"></script>

    <!-- datepicker -->
    <!--<script src="<?php echo MAIN_URL; ?>js/datepicker.js"></script>
    <script src="<?php echo MAIN_URL; ?>js/datepicker.en.js"></script>-->
    <script src="<?php echo MAIN_URL; ?>js/jquery.backstretch.min.js"></script>
    <!-- sidebar menu -->
    <!-- menu jQuery -->
    <script src="<?php echo MAIN_URL; ?>js/jquery.menu-aim.js"></script>
    <script src="<?php echo MAIN_URL; ?>js/main.js"></script>

    <!-- datatable jQuery -->
    <!--<script src="<?php echo MAIN_URL; ?>js/1.11.0-jquery.min.js"></script>-->

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
<script type="text/javascript">
    $(function() {
        $( ".after_current_date" ).datepicker({ minDate: 0});
    });
$(document).ready(function () {
	var maxField = 20; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a><input type="file" class="s4a" name="file_name[]" value=""/><div class="clearfix"></div></div>'; //New input field html 
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

function accountSuspend(a,b)
{
	var suspend_description = $('#suspend_description').val();
	if(suspend_description == '')
	{
		$('#ErrorMsg').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please enter some data in description box ..!</div>');
		return false;
	}
	$.post('getData.php',{mode:a,b:b,suspend_description:suspend_description},function(data){
		$('#ErrorMsg').html(data);
		});
	return false;
}
</script>
</body>
</html>

