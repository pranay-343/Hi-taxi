<?php
include '../include/define.php';
verifyLogin();
include '../include/head.php';
$zoneId = $_SESSION['uid'];
?>
<style>
.pw_prompt {
	position: fixed;
	left: 50%;
	top: 50%;
	margin-left: -100px;
	padding: 15px;
	width: 20%;
	border: 1px solid black;
	background: #FFD200;
}
.pw_prompt label {
	display: block;
	margin-bottom: 5px;
}
.pw_prompt input {
	margin-bottom: 10px;
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
 
  
          <h2 class="txt-style-3">Create Colony</h2>
          
    <div class="mgh">
      <div id="errorMessage"></div>
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Search</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" role="form" id="multiple-destination" onSubmit="return saveColonies('<?php echo base64_encode('saveColoniess');?>')">
          <div id="errorMessage"></div>
            <div class="form-group row pad0 sr bsts">
              <div class="col-sm-4 pad0">
                <input type="text" id="colonyNameA" name="colonyNameA" placeholder="Colony Name A" required/>
              </div>
              <div class="col-sm-4 pad0">
                <input type="text" id="colonyNameB" name="colonyNameB" placeholder="Colony Name B" required/>
              </div>
              
            </div>
            <br/>
            <div class="form-group dso">
              <label class="sr-only" for="start">Starting Location :</label>
              <input type="text" class="form-control" id="start" placeholder="Starting Location" required>
            </div>
            <div class="form-group dso">
              <label class="sr-only" for="end">Destination Location :</label>
              <input type="text" class="form-control" id="end" placeholder="Starting Location" required>
            </div>
            <div class="form-group dso" style="display:none">
              <select class="form-control" id="mode" name="mode">
                <option value="DRIVING">DRIVING</option>
                <option value="WALKING">WALKING</option>
                <option value="BICYCLING">BICYCLING</option>
                <option value="TRANSIT">TRANSIT</option>
              </select>
            </div>
             <div class="form-group dso">
                <input type="text" id="fare" name="fare" class="form-control" placeholder="Fare Amount" required/>
              </div>
            <input type="hidden" class="field" id="end_street_number" placeholder="Street address"/>
            <input type="hidden" class="field" id="end_locality" placeholder="City"/>
            <input type="hidden" class="field" id="end_administrative_area_level_1" placeholder="State"/>
            <input type="hidden" class="field" id="end_postal_code" placeholder="Zip code"/>
            <input type="hidden" class="field" id="end_country" placeholder="Country"/>
            <input type="hidden" class="field" id="end_latitude"/>
            <input type="hidden" class="field" id="end_longitude"/>
            <input type="hidden" class="field" id="start_street_number" placeholder="Street address"/>
            <input type="hidden" class="field" id="start_locality" placeholder="Street address"/>
            <input type="hidden" class="field" id="start_administrative_area_level_1"placeholder="State"/>
            <input type="hidden" class="field" id="start_postal_code" placeholder="Zip code"/>
            <input type="hidden" class="field" id="start_country" placeholder="Country"/>
            <input type="hidden" class="field" id="start_latitude"/>
            <input type="hidden" class="field" id="start_longitude" />
            <input type="hidden" class="field" id="totalDistanceInKM" />
            <!-- button type="button" class="btn btn-success btng" onClick="_ZNRPL_Add_Element();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button -->
          <br/>
          <button type="button" class="btn btn-success mg10" onClick="calcRoute();" style='margin-top:5px;'>Get Shortest Path</button>
          <button type="button" class="btn btn-primary mg10" id="TrafficToggle" style='margin-top:5px;'>Show / Hide Traffic</button>
          <input type="submit" class="btn btn-primary mg10 dso" id="saveColony" style='margin-top:5px;' value="Save" />
          </form>
        </div>
      </div>
      <div class="row roz">
        <div class="col-sm-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="text-left" style="float:left;padding-top:10px;">
                <h3 class="panel-title">GOOGLE MAP</h3>
              </div>
              <div class="text-right"> 
      <a href="#" class="btn btn-success text-right" onClick="window.print()"><i class="glyphicon glyphicon-print"></i></a><span id="share"></span> 
              </div>
            </div>
            <div class="panel-body">
              <input id="pac-input" class="controls" type="text" placeholder="Buscar Lugares cercanos" style="display:none">
              <div id="map-canvas" class="col-lg-12" style="height:350px;"></div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Total Distance: <span id="total"></span></h3>
            </div>
            <div class="panel-body">
              <div id="directionsPanel"></div>
            </div>
          </div>
        </div>
      </div>
	  <p>If you do not get your current location correctly please drag the point of location.</p>
      <div class="panel panel-primary mg5">
        <div class="panel-heading">
          <h3 class="panel-title">TOTAL COST OF THE TRIP:: </h3>
        </div>
        <div class="panel-body">
          <div id="trip_cost"></div>
        </div>
      </div>
      <br/><br/>
    </div>

  <!-- /container --> 
  <!--END --> 
</div>
<?php
include '../include/footer.php';
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places"></script> 
<script src="<?php echo MAIN_URL; ?>js/routeplannerapi.min.js"></script> 
<script>
$(document).ready(function () {
var placeSearch, autocomplete,autocompletee;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};
function initializeStart(a) {
    autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('start')), {
        //types: ['(regions)']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress(a,autocomplete);
    });
}
function initializeEnd(b) {
    autocompletee = new google.maps.places.Autocomplete(
    (document.getElementById('end')), {
       // types: ['(regions)']
    });
    google.maps.event.addListener(autocompletee, 'place_changed', function () {
        fillInAddress(b,autocompletee);
    });
}
function fillInAddress(a,b) {
    var place = b.getPlace();
    document.getElementById(a+'_'+"latitude").value = place.geometry.location.lat();
    document.getElementById(a+'_'+"longitude").value = place.geometry.location.lng();
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(a+'_'+addressType).value = val;
        }
    }
}
initializeEnd('end');
initializeStart('start');
});
</script>
<script>
function saveColonies(a)
{
	//alert($('#totalDistanceInKM').val());
	var colonyNameA = $('#colonyNameA').val();
	var colonyNameB = $('#colonyNameB').val();
	var start = $('#start').val();
	var end = $('#end').val();
	var end_street_number = $('#end_street_number').val();
	var end_city = $('#end_locality').val();
	var end_state = $('#end_administrative_area_level_1').val();
	var end_postal_code = $('#end_postal_code').val();
	var end_latitude = $('#end_latitude').val();
	var end_longitude = $('#end_longitude').val();
	var start_street_number = $('#start_street_number').val();
	var start_city = $('#start_locality').val();
	var start_state = $('#start_administrative_area_level_1').val();
	var start_postal_code = $('#start_postal_code').val();
	var start_latitude = $('#start_latitude').val();
	var start_longitude = $('#start_longitude').val();
	var totalDistanceInKM = $('#totalDistanceInKM').val();
	var fare = $('#fare').val();
	if(totalDistanceInKM == '')
	{
		$('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Primero busque alguna colonia y luego presione… <b>"Obtener el camino mas corto"</b> button.</div>');
		return false;
	}
	$.post('<?php echo MAIN_URL;?>pageFragment/ajaxDataSaver.php',{mode:a,colonyNameA:colonyNameA,colonyNameB:colonyNameB,start:start,end:end,end_street_number:end_street_number,end_city:end_city,end_state:end_state,end_postal_code:end_postal_code,end_latitude:end_latitude,end_longitude:end_longitude,start_street_number:start_street_number,start_city:start_city,start_state:start_state,start_postal_code:start_postal_code,start_latitude:start_latitude,start_longitude:start_longitude,totalDistanceInKM:totalDistanceInKM,fare:fare},function(response){
		if(response == '1')
		{
			$('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Nueva colonia añadido correctamente.</div>');
			location.reload();
		}
		
		});
	return false;
}
</script>
</body>
</html>