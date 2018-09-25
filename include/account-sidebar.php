<div class="nav-side-menu">
  <div class="brand">Brand Logo</div>
  <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
  <div class="menu-list">
    <ul id="menu-content" class="menu-content collapse out sas2">
      <li><a href="<?php echo ACCOUNT_URL;?>index.php">Dashboard</a></li>
      <li data-toggle="collapse" data-target="#products" class="active collapsed" aria-expanded="false"> 
          <a href="#">Manage Taxi Companies <span class="arrow"></span></a> </li>
      <ul class="sub-menu collapse" id="products" aria-expanded="false" style="height: 0px;">
        <li class="active"><a href="<?php echo ACCOUNT_URL;?>taxi-company.php">Add Taxi Company</a></li>
          <li><a href="<?php echo ACCOUNT_URL;?>view-taxi-companies.php">View Taxi Companies</a></li>
      </ul>
      <li><a href="<?php echo ACCOUNT_URL;?>taxi_drivers.php">Taxi Drivers</a></li>
      <li><a href="<?php echo ACCOUNT_URL;?>add-payment.php">Add Payments</a></li>
      <li><a href="<?php echo ACCOUNT_URL;?>work-zones.php">Work Zones</a></li>
      <li><a href="<?php echo ACCOUNT_URL;?>account-status.php">Account Status</a></li>
      <li><a href="<?php echo ACCOUNT_URL;?>agreements.php">Agreements</a></li>
      <li><a href="<?php echo ACCOUNT_URL;?>#">Prices of Colonies</a></li>
    </ul>
  </div>
</div>