<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
 <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet" type="text/css" />
<style>
        .container
        {
           
            top: 10%; left: 10%; right: 0; bottom: 0;
        }
        .action
        {
            width: 400px;
            height: 30px;
            margin: 10px 0;
        }
        .cropped>img
        {
            margin-right: 10px;
        }
        .imageBox
{
    position: relative;
    height: 400px;
    width: 400px;
    border:1px solid #aaa;
    background: #fff;
    overflow: hidden;
    background-repeat: no-repeat;
    cursor:move;
}

.imageBox .thumbBox
{
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    margin-top: -100px;
    margin-left: -100px;
    box-sizing: border-box;
    border: 1px solid rgb(102, 102, 102);
    box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
    background: none repeat scroll 0% 0% transparent;
}

.imageBox .spinner
{
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
    line-height: 400px;
    background: rgba(0,0,0,0.7);
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
<h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Taxi Driver Ad details</h2>
              <?php
                if(isset($_POST['addDriver']) and $_POST['addDriver']!=""){
                add_driver();
               // unset($_POST);
               // HTMLRedirectURL(TAXI_URL."add-driver.php");
                }
                ?>
              <form method="post" enctype="multipart/form-data">
                <div id="errorMessage"></div>
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>NAME </label>
                      <input type="text" name="name" id="name" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['name'];} ?>" class="input-style" placeholder="Enter Driver Name" required/>
                    </div>
                  </div>
                  <!-- div class="col-sm-6">
                  <div class="form-group">
                     <label> Con controladores </label>
                      <input type="file" name="image" id="image" class="input-style" placeholder="Introduzca controlador de imagen aquí" required/>
                    </div>
                  </div -->
                </div>
                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> LICENSE PLATE NUMBER </label>
                      <input type="text" id="liecence_number" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['liecence_number'];} ?>" name="liecence_number" class="input-style" placeholder="LICENSE PLATE NUMBER" required/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> CONTACT NUMBER </label>
                      <input type="text" name="contactno" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['contactno'];} ?>" id="contactno" class="input-style" placeholder="CONTACT NUMBER" required onKeyPress="return IsNumeric(event);"/>
                      <span id="error" style="color: Red; display: none">tipo &uacute;nico n&uacute;mero (0 - 9)</span>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> INSURANCE EXPIRATION DATE </label>
                      <input type="text" id="insurance_expiration_date" name="insurance_expiration_date" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['insurance_expiration_date'];} ?>" class="datepicker-here input-style after_current_date" placeholder="INSURANCE EXPIRATION DATE" required/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> LICENSE EXPIRATION DATE </label>
                      <input type="text" name="licence_expiration_date" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['licence_expiration_date'];} ?>" id="licence_expiration_date" class="datepicker-here input-style after_current_date" placeholder="LICENSE EXPIRATION DATE" required/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> VEHICLE OWNER'S NAME </label>
                      <input type="text" id="vehicle_owner_name" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['vehicle_owner_name'];} ?>" name="vehicle_owner_name" class="input-style" placeholder="VEHICLE OWNER'S NAME " required/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>VEHICLE CONTACT NUMBER</label>
                      <input type="text" name="vehicle_contact" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['vehicle_contact'];} ?>" id="vehicle_contact" class="input-style" placeholder="VEHICLE CONTACT NUMBER" onKeyPress="return IsNumeric(event);" required/>
                       <span id="error1" style="color: Red; display: none">tipo &uacute;nico n&uacute;mero (0 - 9)</span>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> VEHICLE NAME </label>
                      <input type="text" id="vehicle_name" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['vehicle_name'];} ?>" name="vehicle_name" class="input-style" placeholder="VEHICLE NAME" required/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> NUMBER OF VEHICLES </label>
                      <input type="text" name="vehicle_number" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['vehicle_number'];} ?>" id="vehicle_number" class="input-style" placeholder="NUMBER OF VEHICLES" required/>
                    </div>
                  </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                  <div class="form-group">
                     <label> USER Email</label>
                      <input type="text" name="username" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['username'];} ?>" id="username" class="input-style" placeholder="Email " required/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> PASSWORD </label>
                      <input type="password" name="password" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['password'];} ?>" id="password" class="input-style" placeholder="PASSWORD" required/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
					<div class="form-group">
						<label> Trip FARE PER KM </label>
						<input type="text" name="trip_fare" value="<?php if(isset($_REQUEST['addDriver'])){ echo $_REQUEST['trip_fare'];} ?>" id="trip_fare" class="input-style" placeholder="Trip FARE PER KM" required/>
                    </div>
                  </div>
				  
				  <div class="col-sm-6">
                  <div class="form-group">				  
                     <label> PRIMARY ZONE </label>
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
				  
                  <div class="col-sm-6">
                  <div class="form-group" style="display:none;">
                     <label> Trip of driver </label>
                     <select name="driver_type" class="input-style" id="driver_type">
                      <option value="none">---Select---</option>
                      <option value="monthly">Monthly</option>
                      <option value="trip">Trip</option>
                     </select>
                      <!-- <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Enter Trip Fare per KM  Here" required/> -->
                    </div>
                  </div>
                </div>
				<div class="row">
					<div class="col-sm-6">
					  <div class="form-group">				  
						 <label> Sub Zone </label>
						<select name="driver_zone" class="input-style" id="driver_zone">
						<option value="">---Select Sub Zone---</option>
						<?php 
							// Main zone area
							$query_zone = "SELECT taxicompany.name, taxicompany.web_user_id, zone_cordinater.cordinate_title as zcTitle,zone_cordinater.zone_area_id as zcId FROM zone_cordinater 
							LEFT JOIN taxicompany ON zone_cordinater.zone_area_id = taxicompany.zone_area_id_sess
							WHERE 1 and taxicompany.web_user_id ='".$_SESSION['uid']."'";
							$result_zone =mysql_fetch_array(mysql_query($query_zone));
							//Sub zone area						
							$query_zone_driver = "SELECT * FROM zone_cordinater_driver WHERE zone_cordinater_driver.added_by ='".$_SESSION['uid']."'";
							$result_zone_driver = mysql_query($query_zone_driver);
							$result_rows_driver =mysql_num_rows($result_zone_driver);
						?>
						<!--<option value="<?php// echo $result_zone['zcId'];?>"><?php //echo $result_zone['zcTitle'];?></option>-->
						<?php if($result_rows_driver>0){ while($data_zone_driver = mysql_fetch_array($result_zone_driver)){?>
							<option value="<?php echo $data_zone_driver['id'];?>"><?php echo $data_zone_driver['cordinate_title']?></option>
						<?php } }?>
						 </select>						 
						</div>
					  </div>
				</div>
				<div class="row">
          <div class="col-sm-6">
                 <div class="field_wrapper">
                    <div>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
                        <input type="file" name="file_name[]" value="" class="s4a"/>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
<div class="col-sm-6">
                  <div class="form-group">
                     <label> Driver Image </label>
                      <input type="file" class="input-style" placeholder="" id="file" style="float:left; width: 250px">
                    </div>
<div class="container">
    <div class="imageBox">
        <div class="thumbBox"></div>
        <div class="spinner" style="display: none">Cargando…</div>
    </div>
    <div class="action">
        
        <!-- input type="file" name="image" id="image" class="input-style" placeholder="Introduzca controlador de imagen aquí" required/ -->
        <input type="button" id="btnCrop" value="haga clic para recortar" style="float: right">
        <input type="button" id="btnZoomIn" value="+" style="float: right;width: 20px;" >
        <input type="button" id="btnZoomOut" value="-" style="float: right;width: 20px;">
    </div>
    <div class="cropped">
    </div>
</div>
</div>
</div>
                
                <div class="row bts">
               	<div class="col-sm-4 col-sm-offset-4">
                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addTaxiCompany')?>" />
                    <input class="dash-button hvr-wobble-horizontal w100 wap" type="submit" name="addDriver" id="addDriver" value="Add Taxi Driver" />
                    </div>
                   
                </div>
                <div class="spacetop">&nbsp;</div>
              </form>
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

</body>
</html>

<script src="<?php echo TAXI_URL;?>cropbox.js"></script>
<script>
    $(function() {
        $( ".after_current_date" ).datepicker({ minDate: 0});
    });
$(window).load(function() {
        var options =
        {
            thumbBox: '.thumbBox',
            spinner: '.spinner',
            imgSrc: 'avatar.png'
        }
        var cropper = $('.imageBox').cropbox(options);
        $('#file').on('change', function(){
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = $('.imageBox').cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            this.files = [];
        })
        $('#btnCrop').on('click', function(){
            var img = cropper.getDataURL();
            $('.cropped').html('<img src="'+img+'"><input type="hidden" value="'+img+'" name="cropImage">');
        })
        $('#btnZoomIn').on('click', function(){
            cropper.zoomIn();
        })
        $('#btnZoomOut').on('click', function(){
            cropper.zoomOut();
        })
    });
    $('#minMaxExample').datepicker({
	language: 'en',
	minDate: new Date() // Now can select only dates, which goes after today
    })



/*
var $start = $('#insurance_expiration_date'),
  $end = $('#licence_expiration_date');
  $start.datepicker({
    language: 'en',
    onSelect: function (date) {
      $end.data('datepicker')
        .update('minDate', date)
    }
  })
  $end.datepicker({
    language: 'en',
    onSelect: function (date) {
      $start.data('datepicker')
        .update('maxDate', date)
    }
  })
  */
</script>
<script type="text/javascript">
$(document).ready(function () {
	var maxField = 20; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><a href="javascript:void(0);" class="remove_button" title="Retire campo"><img src="remove-icon.png"/></a><input type="file" class="s4a" name="file_name[]" value=""/><div class="clearfix"></div></div>'; //New input field html 
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


var specialKeys = new Array();
specialKeys.push(8); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        var inputId =  $(e.target).attr("id");
        if(inputId == 'contactno'){
            document.getElementById("error").style.display = ret ? "none" : "inline";
        }
        if(inputId == 'vehicle_contact'){
            document.getElementById("error1").style.display = ret ? "none" : "inline";                   
        }
    return ret;
}
</script>