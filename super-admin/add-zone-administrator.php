<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style type="text/css">
    .hide_poly{
        display: none !important;
    }
    .show_poly{
        display: block !important;
    }
</style>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Superadministrador Hi Taxi</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Creating zone Area</h2>
<?php
if(isset($_POST['addmap_btn']) and $_POST['addmap_btn']!=""){
createzoneCordinatedWithAdministrator();
unset($_POST);
}

?>
<div class="clearfix"></div>
              <div class="row">
        
            <div id="basic_options">
                <div class="radio">
        <!--<label for="drawwhat_line"><input type="radio" name="drawwhat" id="drawwhat_line" value="line" checked>LÃ?NEA</label>-->
         <label for="drawwhat_polygon" class=" " id="njGetNew"><input type="radio" name="drawwhat" id="drawwhat_polygon" value="polygon">Polygon</label> 
        <!--<label for="drawwhat_rectangle"><input type="radio" name="drawwhat" id="drawwhat_rectangle" value="rectangle">RECTÃ?NGULO</label>-->    
        <!--<label for="drawwhat_circle"><input type="radio" name="drawwhat" id="drawwhat_circle" value="circle">Circle</label> -->   
                <div id="helpbox" class="text-info"></div>    
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8 col-md-8 col-xs-12">
                   <div class="">
                        <div id="basic_buttons">
                            <button type="button" id="drawwhat_clearall" class="btn btn-danger">Clear All</button>
                            <button type="button" disabled="disabled" id="add_btn" class="btn btn-primary">Add</button> 
                            <button type="button" disabled="disabled" id="save_btn" class="btn btn-success">Save</button> 
                            <button type="button" disabled="disabled" id="cancel_editing" class="btn btn-warning">Cancel</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="searchbox" >
                        <form method="post" id="geocoding_form" class="form-inline" role="form">
                            <div class="form-group input">
                                <input type="text" class="form-control w40" id="address" name="address" placeholder="Search Location">
                                <input type="submit" class="btn btn-primary" value="Search" />
                            </div>                  
                        </form>
                    </div>
                </div>
                <div class="clearfix"></div>

            </div>






                    
        
    </div>
        <div class="row">
                <div class="popin">
                    <div id="map"></div>
                </div>
            </div>
            <div class="row" id="map_form">

<?php
if(isset($_POST['addmap_btn']) and $_POST['addmap_btn']!=""){
createzoneCordinatedWithAdministrator();
unset($_POST);
}

?>
                <form  method="post" action="" role="form" data-toggle="validator">
                    <div class="row" id="allmarks"></div>  
                    <div class="row" id="map_info">

                        <div class="form-group">
                            <label for="map_title" class="control-label">Title</label>
                            <input type="text" class="form-control" id="map_title" name="map_title" placeholder="Enter Title" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="map_description">Description</label>
                            <textarea class="form-control" rows="3" id="map_description" name="map_description" placeholder="Enter Description"></textarea>
                        </div>
                        
                         <div class="form-group">
                            <label for="map_description">ADMINISTRADOR</label>
                            <select name="administratorId" id="administratorId" class="form-control">
                            <option value="">--Select Administrator--</option>
                            <?php
                            $query = mysql_query("SELECT * FROM `login` WHERE 1 and  `account_type` = '2' ");
                            while($data = mysql_fetch_array($query))
                            {
                                echo '<option value="'.$data["id"].'">'.$data["name"].'</option>';
                            }
                            ?>
                            </select>
                        </div>
                        
                        <input type="hidden" id="map_center_lat" name="map_center_lat">
                        <input type="hidden" id="map_center_lng" name="map_center_lng">
                        <input type="hidden" id="map_zoom" name="map_zoom">
                        <input type="hidden" id="map_typeid" name="map_typeid">

                        <input type="hidden" id="map_Lineid" name="map_Lineid">
                        <input type="hidden" id="map_Polygonid" name="map_Polygonid">
                        <input type="hidden" id="map_Rectangleid" name="map_Rectangleid">
                        <input type="hidden" id="map_Circleid" name="map_Circleid">
                        <input class="dash-button hvr-wobble-horizontal w100" type="submit" name="addmap_btn" id="addmap_btn" value="CREAR ZONA" />
                    </div>  
                </form>
            </div> 
        </div> 

      </div>
    </div>
<?php 
include '../include/footer.php'; 
include '../include/map-script.php'; 
?>
<script type="text/javascript">
function initialize() {
    new google.maps.places.Autocomplete(
    (document.getElementById('address')), {
    	componentRestrictions: {country: "mx"},
        types: ['geocode']
});
}
initialize();


</script>
</body>
</html>

