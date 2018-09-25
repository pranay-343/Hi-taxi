<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
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
			<?php $_SESSION['zone_area_session'] = $data['id']; //print_r($zone_area_session);?>
            
<div class="row btse spacetop">
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/txcom.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>taxi-companies.php" id="zone_centrals"><span class="txt-style-2">central</span></a>
         </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/accountstatus.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>account-status.php"><span class="txt-style-2" id="zone_account">Account Status</span></a>
         </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/messages.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>my-msgs.php" id="zone_new_maps"><span class="txt-style-2">Message</span></a>
         </div>
    </div>
    <div class="clearfix"></div>

<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/alert.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>alerts.php" id="zone_alerts"><span class="txt-style-2">Alerts</span></a>
         </div>
    </div>
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/mghis.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>message-history.php" id="zone_meg_history"><span class="txt-style-2">Message History</span></a>
         </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/nw.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>blog-news.php" id="zone_news"><span class="txt-style-2">News</span></a>
         </div>
    </div>
    
    <div class="clearfix"></div>
<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/reports.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>reports.php" id="zone_reports"><span class="txt-style-2">Reports</span></a>
         </div>
    </div>
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/app-user.png" alt="" title="" />
            </div>
           <a href="<?php echo ZONE_URL?>app-users.php" id="zone_app_users"> <span class="txt-style-2">App Users</span></a>
         </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/tfrv.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>taxi-drivers.php" id="zone_taxi_drivers"><span class="txt-style-2">Taxi Drivers</span></a>
         </div>
    </div>
    

<div class="col-lg-4 col-md-6 col-xs-12 col-sm-offset-2">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/maps.png" alt="" title="" />
            </div>
        	<a href="<?php echo ZONE_URL?>maps.php" id="zone_map"><span class="txt-style-2">Maps</span></a></div>
    </div>
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/log.png" alt="" title="" />
            </div>
            <a href="<?php echo ZONE_URL?>log.php"><span class="txt-style-2">Logs</span></a>
         </div>
    </div>
    
</div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
    </html>
<!-- JQUERY SUPPORT -->
<!--<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>-->
<!-- sidebar menu -->
