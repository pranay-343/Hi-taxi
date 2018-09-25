<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
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
<div class="row btse">
	<div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/work-area.png" alt="" title="" />
            </div>
            <a href="<?php echo SUPER_ADMIN_URL?>work-zone.php"><span class="txt-style-2">Working Areas</span></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/administrator.png" alt="" title="" />
            </div>
            <a href="<?php echo SUPER_ADMIN_URL?>administrators.php"><span class="txt-style-2">Administrators</span></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-xs-12">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/manager-profile.png" alt="" title="" />
            </div>
            <a href="<?php echo SUPER_ADMIN_URL?>profile.php"><span class="txt-style-2">Edit Profile</span></a>
        </div>
    </div>
	<div class="col-lg-4 col-md-6 col-xs-12 col-sm-offset-4 spacetop">
    	<div class="c-dash-1">
        	<div class="cicon1 hvr-float-shadow">
            	<img src="../images/log.png" alt="" title="" />
            </div>
            <a href="<?php echo SUPER_ADMIN_URL?>log.php"><span class="txt-style-2">Log</span></a>
         </div>
    </div>
</div>
            
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
</body>
</html>
