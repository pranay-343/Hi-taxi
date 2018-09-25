<?php 
	$query_zone_id = "SELECT id,web_user_id,zone_area_id_sess FROM taxicompany where web_user_id = '".$_SESSION['uid']."'";
	$result_zone_id = mysql_query($query_zone_id);
	$data_zone_id = mysql_fetch_assoc($result_zone_id);	
?>
<div class="nav-side-menu">
    <div class="brand">Brand Logo</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out sas2">
           <li><a href="<?php echo TAXI_URL; ?>">Dashboard</a></li>
           <li><a href="<?php echo TAXI_URL; ?>taxi_drivers.php">Taxi Driver</a></li>
           <li><a href="<?php echo TAXI_URL; ?>corp-companies.php">Corporate Companies</a></li>
           <!--<li><a href="<?php echo TAXI_URL;?>create_zone.php">límites de trabajo</a></li>-->
		   <li><a href="<?php echo TAXI_URL;?>wrok_zone_create.php?p=map_edit&map_id=<?php echo $data_zone_id['zone_area_id_sess']?>">Work Zone</a></li>
    	  <li><a href="<?php echo TAXI_URL;?>add-payment.php">Add Payment</a></li>
        	<li><a href="<?php echo TAXI_URL;?>account-status.php">Account Status</a></li>
        <li><a href="<?php echo TAXI_URL;?>agreements.php">Agreements</a></li>
        <li><a href="<?php echo TAXI_URL;?>price_of_colony_list.php">Price of Colonies</a></li>
        <!--<li><a href="<?php //echo TAXI_URL;?>profile.php">Profile</a></li>-->
        <li><a href="<?php echo TAXI_URL;?>notification.php">Notification</a></li>
        <li><a href="<?php echo TAXI_URL;?>panic.php">Panic</a></li>
        <li><a href="<?php echo TAXI_URL;?>logs.php">Logs</a></li>
        <li><a href="<?php echo MAIN_URL;?>logout.php">Sign Out</a></li>
        </ul>
    </div>
</div>

