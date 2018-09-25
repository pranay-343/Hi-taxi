<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
<?php include '../include/taxi-navbar.php'; ?>
<div class="main_content">
<div class="container pal0">
<div class="row">
  <div class="col-sm-3 pa10">
    <?php include '../include/taxi-sidebar.php'; ?>
  </div>
  <div class="col-sm-9 mg5">
    <div class="row br1">
      <div class="col-sm-12">
        <h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?></strong></h1>
      </div>
    </div>
  
    <div class="row spacetop bot20">
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/tfrv.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>taxi_drivers.php"><span class="txt-style-2">Taxi Driver</span></a> </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/addpymnts.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>add-payment.php"><span class="txt-style-2">Add Payment</span></a> </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/work-area.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>wrok_zone_create.php?p=map_edit&map_id=<?php echo $data_zone_id['zone_area_id_sess']?>"><span class="txt-style-2">Work Zone</span></a> </div>
      </div>
   <br/>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/accountstatus.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>account-status.php"><span class="txt-style-2">Account Status</span></a> </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/txcom.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>corp-companies.php"><span class="txt-style-2">Corporate Companies</span></a> </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/agreemnts.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>agreements.php"><span class="txt-style-2">Agreements</span></a> </div>
      </div>
     <br/>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/prices.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>price_of_colony_list.php"> <span class="txt-style-2">Price of Colonies</span></a> </div>
      </div>
        <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/logs-acc.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>logs.php"> <span class="txt-style-2">Logs</span></a> </div>
      </div>
      <div class="col-lg-4 col-md-6 col-xs-12">
        <div class="c-dash-1">
          <div class="cicon1 hvr-float-shadow"> <img src="../images/notification-acc.png" alt="" title=""> </div>
          <a href="<?php echo TAXI_URL; ?>notification.php"> <span class="txt-style-2">Notification</span></a> </div>
      </div>
    </div>
  </div>
</div>
<?php 
include '../include/footer.php'; 
?>
</body>
</html>