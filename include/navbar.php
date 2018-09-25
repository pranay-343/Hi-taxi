<!-- corp user starts -->
<div class="header">
  <div class="container">
      <div class="row">
          <div class="col-sm-4">
              <div class="logo">
                  <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" width="60px" height="60px"/>
                </div>
            </div>
            <div class="col-sm-8">
            <div class="top_right_toggle">
            <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                        <a href="<?php echo SUPER_ADMIN_URL;?>profile.php" ><i class="fa fa-user"></i> <?php echo $_SESSION['uname'];?></a>
                        <!--<ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo SUPER_ADMIN_URL;?>profile.php">Profile</a>
                            </li>
                            <li>
                                <a href="<?php echo MAIN_URL;?>logout.php">Logout</a>
                            </li>
                            
                        </ul>-->
                    </li>
                    </ul>
                    </div>
            </div>
        </div>
    </div>
</div>