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
<h1 class="txt-style-1 bn">CUENTA DE USUARIO : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Ad del taxista detalles</h2>
              <?php
               $infoDriver=$_REQUEST['a'];
               $driverDetail = mysql_fetch_array(mysql_query("select * from driver where id = '$infoDriver'"));
              ?>
              <form method="post" enctype="multipart/form-data">
                <div id="errorMessage"></div>
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label>Nombre </label>
                      <input type="text" name="name" id="name" class="input-style" placeholder="Introduzca piloto Nombre Aquí" value="<?php echo $driverDetail['name'] ?>" readonly/>
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
                     <label> Número de licencia </label>
                      <input type="text" id="liecence_number" name="liecence_number" class="input-style" placeholder="Ingrese número de licencia del conductor Aquí" value="<?php echo $driverDetail['liecence_number'] ?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Número de contactos </label>
                      <input type="text" name="contactno" id="contactno" class="input-style" placeholder="Introduzca usuario Información del contacto Número" value="<?php echo $driverDetail['contact_number'] ?>" readonly/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Seguros Fecha de vencimiento </label>
                      <input type="text" id="insurance_expiration_date" name="insurance_expiration_date" class="datepicker-here input-style after_current_date" placeholder="Introduzca Seguros Fecha de vencimiento " value="<?php echo $driverDetail['insurance_expiration_date'] ?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Fecha de caducidad de licencia </label>
                      <input type="text" name="licence_expiration_date" id="licence_expiration_date" class="datepicker-here input-style after_current_date" placeholder="Introducir licencia Fecha de vencimiento" value="<?php echo $driverDetail['licence_expiration_date'] ?>" readonly/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre del propietario del vehículo </label>
                      <input type="text" id="vehicle_owner_name" name="vehicle_owner_name" class="input-style" placeholder="Introducir nombre del propietario del vehículo" value="<?php echo $driverDetail['vehicle_owner_name'] ?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Vehículo Número de contacto </label>
                      <input type="text" name="vehicle_contact" id="vehicle_contact" class="input-style" placeholder="Introduzca Vehículo Número de contacto del propietario" value="<?php echo $driverDetail['vehicle_contact'] ?>" readonly/>
                    </div>
                  </div>
                </div>

                <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre de vehículos </label>
                      <input type="text" id="vehicle_name" name="vehicle_name" class="input-style" placeholder="Introducir el nombre de Vehículo Aquí" value="<?php echo $driverDetail['vehicle_name'] ?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Número de vehículos </label>
                      <input type="text" name="vehicle_number" id="vehicle_number" class="input-style" placeholder="Introducir número de vehículos" value="<?php echo $driverDetail['vehicle_number'] ?>" readonly/>
                    </div>
                  </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                  <div class="form-group">
                     <label> Nombre de usuario </label>
                      <input type="text" name="username" id="username" class="input-style" placeholder="Introducir e-mail-Id Aquí" value="<?php echo $driverDetail['username'] ?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Contraseña </label>
                      <input type="password" name="password" id="password" class="input-style" placeholder="Introduzca su contraseña" value="<?php echo $driverDetail['password'] ?>" readonly/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
					<div class="form-group">
						<label> Tarifa de ida y por km </label>
						<input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Introduzca tarifa de ida y por KM Aquí" value="<?php echo $driverDetail['trip_fare'] ?>" readonly/>
                    </div>
                  </div>
				  
				  <div class="col-sm-6">
                  <div class="form-group">				  
                     <label> zona primaria </label>
                    <!-- <select name="driver_zoneaera" class="input-style" id="driver_zoneaera" readonnly> -->
                    
					<?php 
						// Main zone area
						$query_zone = "SELECT taxicompany.name, taxicompany.web_user_id, zone_cordinater.cordinate_title as zcTitle,zone_cordinater.zone_area_id as zcId, zone_area.id as ZAid,zone_area.zone_title as ZATitle FROM zone_cordinater 
						LEFT JOIN taxicompany ON zone_cordinater.zone_area_id = taxicompany.zone_area_id_sess
						LEFT JOIN zone_area ON zone_cordinater.zone_area_id = zone_area.id
						WHERE 1 and taxicompany.web_user_id ='".$_SESSION['uid']."'";
						$result_zone =mysql_fetch_array(mysql_query($query_zone));
					?>        
          <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Introduzca tarifa de ida y por KM Aquí" value="<?php echo base64_decode($result_zone['ZATitle']);?>" readonly/>            
					<!-- <option value="<?php echo $result_zone['zcId'];?>" selected="selected"><?php echo base64_decode($result_zone['ZATitle']);?></option> -->
                    <!-- </select> -->
                    </div>
                  </div>
			    <!-- <div class="col-sm-6">
            <div class="form-group">
              <label> con controladores </label>
              <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Introduzca tarifa de ida y por KM Aquí" value="<?php echo TAXI_URL.$driverDetail['image'] ?>" readonly/>
            </div>
          </div> -->
                  <div class="col-sm-6">
                  <div class="form-group" style="display:none;">
                     <label> Tipo de controlador </label>
                     <select name="driver_type" class="input-style" id="driver_type">
                      <option value="none">---Seleccionar---</option>
                      <option value="monthly">Mensual</option>
                      <option value="trip">Viaje</option>
                     </select>
                      <!-- <input type="text" name="trip_fare" id="trip_fare" class="input-style" placeholder="Enter Trip Fare per KM  Here" required/> -->
                    </div>
                  </div>
                </div>
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
</script>