<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 

$id = base64_decode($_GET['a']);
//$data1 = mysql_fetch_assoc(mysql_query("select * from `login` where 1 and id = '$id'"));
$taxicomDetail = mysql_fetch_assoc(mysql_query("select * from `news` where 1 and id = '$id'"));
$fId=$taxicomDetail['id'];
// $fileUpload = mysql_fetch_assoc(mysql_query("select * from `files_upload` where 1 and login_id = '$fId'"));

?>
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
          <h2 class="txt-style-3">Ver Noticias</h2>
          
          <form method="post" name="" action="" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $id;?>" />
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Imagen</label>
                  <img style="width:100px;height:100px;" src="<?php echo $taxicomDetail['newsImage'];?>">
                </div>
              </div>
			  <div class="col-sm-4">
                <div class="form-group">
                  <label>Título</label>
                  <input type="text" name="title" id="title" class="input-style input-style1" placeholder="Introduzca texto aquí" value="<?php echo $taxicomDetail['title']?>" readonly/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Descripción</label>
                  <input type="text" name="discription" id="discription" class="input-style input-style1" placeholder="Introduzca texto aquí" value="<?php echo $taxicomDetail['discription']?>" readonly/>
                </div>
              </div>              
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Fecha y hora</label>
                  <input type="text" name="added_on" id="added_on" class="input-style input-style1" placeholder="Introduzca País Aquí" required value="<?php echo $taxicomDetail['added_on'];?>" readonly/>
                </div>
              </div>  
            
          </form>
          </div>
          <div>
            
          </div>
          <div class="clearfix"></div>
        </div>
		
         
		
		
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
            types:  ['geocode'],
            componentRestrictions: {country: "mx"}
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