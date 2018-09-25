<!-- Google Map -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script type="text/javascript">
function initialize() {
    new google.maps.places.Autocomplete(
    (document.getElementById('address')), {
    	//componentRestrictions: {country: "mx"},
        types: ['geocode']
});
}
initialize();
</script>
<script>
    var map_default_lat = 24.126701958681682;
    var map_default_lng = -102.85400390625;
    var map_default_zoom = 5;
    var map_default_typeid = "roadmap";
</script>

<script type="text/javascript" src="<?php echo MAIN_URL;?>js/gmaps.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>js/prettify.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>js/drawonmaps_markers.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>js/drawonmaps.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>js/drawonmaps_map_display.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>bootstrap/js/validator.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_URL;?>js/ie-emulation-modes-warning.js"></script>
<!-- Google Map -->
