<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style type="text/css">
	input[type="file"]{height:26px; vertical-align:top;}
	.field_wrapper div{ margin-bottom:10px;}
	.add_button{ margin-top:10px; margin-left:10px;vertical-align: text-bottom;}
	.remove_button{ margin-top:8px; margin-left:10px;vertical-align: text-bottom;}
</style>
<body>
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
          <h2 class="txt-style-3">Add Central</h2>
          <div id="errorMessage">
          <?php
            if(isset($_POST['add_central']) and $_POST['add_central']!=""){
            addTaxiCentralByZone();
            unset($_POST);
            }
		  ?>
          </div>
          <form method="post" enctype="multipart/form-data">
            <?php 
                $companyAdmin = mysql_fetch_array(mysql_query("select `email`,`name` from `login` where `id` ='".$_SESSION['uid']."' "));
               ?>
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Name</label>
                   <input type="text" name="Company_name" id="Company_name" class="input-style" placeholder="Name" required/>
                </div>
              </div>
                <div class="col-sm-4">
                    <div class="form-group">
                    <label>Email</label>
                        <input type="email" name="emailID" id="emailID" class="input-style" placeholder=" e-mail-Id " required/>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                    <label>Password</label>
                        <input type="password" id="password" name="password" class="input-style" placeholder="Password" required/>
                    </div>
                </div>                
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="address" id="address" class="input-style" placeholder="Address" required/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" id="country" class="input-style" placeholder="Country" required/>
                </div>
              </div>
            
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Contact Number</label>
                  <input type="text" name="contactno" id="contactno" class="input-style" placeholder="Contact Number" required onKeyPress="return IsNumeric(event);"/>
                  <span id="error" style="color: Red; display: none">type only number (0 - 9)</span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Per week cost</label>
                  <input type="text" name="per_week_cost" id="per_week_cost" class="input-style" style="color:#999;" placeholder="Per week cost" onKeyPress="return IsNumeric(event);">
                  <span id="error1" style="color: Red; display: none">Type Numeric Value (0 - 9)</span>
                  </select>
                </div>
              </div>
              <div class="col-sm-4" style="display:none;">
                <div class="form-group">
                  <label>Límites de trabajo</label>
                  <!--<input type="text" name="worklimit" id="worklimit" class="input-style" placeholder="Enter Text Here" onkeypress="return IsNumeric(event);"/>-->
                  <!--<span id="error2" style="color: Red; display: none">tipo &uacute;nico n&uacute;mero (0 - 9)</span>-->
                  
                  <select name="worklimit" id="worklimit" class="input-style">
                      <option value="">Seleccione Límite de Trabajo</option>
                        <?php

                                $x = 1;
                         while ($x <= 100) {?>
                             <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                         <?php   $x++;}?>                           
                  </select>
                </div>
              </div>
           
              <div class="col-sm-12">
                <div class="form-group">
                  <ul>
                    <li>
                      <input type="checkbox" name="systemAllow" id="systemAllow" value="1">
                      <span>Full system company</span></li>
                  </ul>
                </div>
              </div>
          
              <div class="col-sm-12">
                <div class="form-group">
                  <label> <strong>Add Files :-</strong> </label>
                </div>
              </div>
          
              <div class="col-sm-4 wap">
                <div class="files field_wrapper">
                  <ul>
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add_morenew.png"/></a>
                    <input type="file" name="file_name[]" class="s4a" value="" style="margin-left: -27px;margin-top: 53px;"/>
                   <div class="clearfix"></div>
                  </ul>
                </div>
              </div>
           <div class="clearfix"></div>
            <br/>
            <!--<h2 class="txt-style-3">Información del usuario de la empresa</h2>-->
          
<!--              <div class="col-sm-6">
                <div class="form-group">
                  <input type="email" name="emailID" id="emailID" class="input-style" placeholder="Introducir e-mail-Id Aquí" required/>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input type="password" id="password" name="password" class="input-style" placeholder="Introduzca su contraseña aquí" required/>
                </div>
              </div>-->
           
              <div class="col-sm-4 col-sm-offset-4">
              <input type="hidden" name="city" id="locality" value="" />
              <input type="hidden" name="state" id="administrative_area_level_1" value="" />
              <input type="hidden" name="latitude" id="latitude" value="" />
                    <input type="hidden" name="longitude" id="longitude" value="" />
                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addTaxiCompany')?>" />
                    <input type="hidden" id="company_email" name="company_email" value="<?php echo $companyAdmin['email'] ?>">
                    <input type="hidden" name="company_name" id="company_name" value="<?php echo $superAdmin['name'];?>" />
                    <input type="submit" name="add_central" id="add_central" value="Add Central" class="dash-button hvr-wobble-horizontal w100 wap" />
              </div>
            </div>
          </form>
          <div> 
        </div>
        <!--<div class="c-acc-status i100" align="center"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
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
</body>
</html><!-- JQUERY SUPPORT -->

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

//NUmber Validation

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
