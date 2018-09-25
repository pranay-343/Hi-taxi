<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
    <?php include '../include/corp-navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pal0">
            <?php include '../include/corp-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <?php include '../include/corp-rsidebar.php'; ?>
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Add trip </h2>
              <div id="errorMessage"></div>
               <?php
            if(isset($_POST['add_trip']) and $_POST['add_trip']!=""){
            addTripManualCorporate();
            //unset($_POST);
            }
            ?>
            <?php $getDatAddBY = mysql_fetch_array(mysql_query("SELECT id, added_by,name FROM login WHERE id = '".$_SESSION['uid']."'"));?>
              <form method="post" action="" name="addTrip" id="addTrip">
                <div class="row bts">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1" width="30%">Name</th>
                <th class="tab-txt1" width="30%">From</th>
                <th class="tab-txt1" width="30%">To</th>
                <th class="tab-txt1" width="10%">Cost</th>
              </tr>
              <tr>
                <input type="hidden" name="companyname" id="companyname" value="<?php echo $getDatAddBY['name']?>">
                <td class="tab-txt2">
                <select name="name" id="name" required class="form-control" style="width: 90%;margin: 10px;">
                <option value="">Select user</option>
                <?php $query = mysql_query("SELECT name, id, added_by FROM users WHERE added_by ='".$_SESSION['uid']."'");
                    $num_rows = mysql_num_rows($query);
                    if($num_rows>0){
                      while($data = mysql_fetch_array($query)){
                    
                ?>
                <?php if(isset($_POST['submit'])){ (isset($_POST["name"])) ? $name = $_POST["name"] : $name=($data['name']);}?>
                      <option <?php if ($name == ($data['name'] )){ echo 'selected' ;} ?> value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
                <?php } }?>
               </select>
                </td>

                <td class="tab-txt2">
                <select name="colonyA" id="colonyA_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                <?php 
                    $qry = mysql_query("select * from `colony` where 1 AND colony.addded_by = '".$getDatAddBY['added_by']."'  order by name_A asc");
                    while($data = mysql_fetch_assoc($qry))
                    {
                      echo '<option value="'.$data['id'].'">'.$data['a_address'].'</option>';
                    }       
                ?>
                </select>
                </td>
                <td class="tab-txt2">
                <select name="colonyB" id="colonyB_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                </select>
                </td>
                <td class="tab-txt2">
                <input type="text" id="fare_1" name="fare" value="0.00" class="form-control" style="width: 90%;margin: 10px;"/>
                </td>
                <td class="tab-txt2"><a href="#"></a><input type="hidden" name="currentRowStatus" id="currentRowStatus_<?php echo $i;?>" value="9" /></td>
              </tr>
              
              </table>
                  </div>
               
                
                <div class="clearfix"></div>
                  <div class="col-lg-12">
                    <!--<button class="dash-button hvr-wobble-horizontal w100 wap" type="submit">A&ntilde;adir un viaje </button>-->

                    <input type="submit" name="add_trip" id="add_trip" value="Add Trip" class="dash-button hvr-wobble-horizontal w100 wap" />
                  </div>
                </div><br/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
    
    
</body>
</html>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
$("#autocomplete").on('focus', function () {
    geolocate();
    geolocate_end();

});

var placeSearch, autocomplete , autocomplete1;
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
    autocomplete1 = new google.maps.places.Autocomplete(
   (document.getElementById('address_end')), {
        types:  ['geocode']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress();
    });
    google.maps.event.addListener(autocomplete1, 'place_changed', function () {
        fillInAddress_end();
    });
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
        console.log(place.address_components);
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
            var locality = position.coords.long_name;
            var state = position.coords.administrative_area_level_1;
            var country = position.coords.long_name;
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }
}



function initialize_end() {
    autocomplete = new google.maps.places.Autocomplete(
   (document.getElementById('address_end')), {
        types:  ['geocode']
    });
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        fillInAddress_end();
    });
}





// [START region_fillform]
function fillInAddress_end() {
    var place = autocomplete.getPlace();
    document.getElementById("latitude_end").value = place.geometry.location.lat();
    document.getElementById("longitude_end").value = place.geometry.location.lng();
    for (var component in componentForm) {
    }
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType1= place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}
function geolocate_end() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = new google.maps.LatLng(
            position.coords.latitude, position.coords.longitude);
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            document.getElementById("latitude_end").value = latitude;
            document.getElementById("longitude_end").value = longitude;
            autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
        });
    }
}

initialize();
instialize_end();


function getstatecbo(a,b)
{
  $.post('getData.php',{a:a,mode:'<?php echo base64_encode('getColonyB');?>'},function(data){
    if(data == '0')
    {}
    else
    {
      var obj = $.parseJSON(data);
      $('#colonyB_'+b).html(obj.option);
      $('#fare_'+b).val(obj.fare);
    }
    });
  return true;    
}
</script>