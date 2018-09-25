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
            <div class="row">
	<div class="col-sm-12">
    	<div class="cbtns">
    	<a href="<?php echo CORPORATE_URL?>manage-corp-user.php" class="yl-bt">Corporate User</a>
        <a href="<?php echo CORPORATE_URL?>account-status.php" class="yl-bt">Account Status</a>
        <a href="<?php echo CORPORATE_URL?>corp-profile.php" class="yl-bt">Corporation Profile</a>
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
