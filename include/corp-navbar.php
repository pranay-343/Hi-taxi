<!-- corp user starts -->
<div class="header">
  <div class="container">
      <div class="row">
          <div class="col-sm-4">
              <div class="logo">
                  <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" width="55px" height="55px"/>
                </div>
            </div>
            <div class="col-sm-8">
            <div class="top_right_toggle">
            <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                        <a href="<?php echo CORPORATE_URL;?>corp-profile.php" ><?php echo $_SESSION['uname'];?></a>
                        <!--<ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo CORPORATE_URL;?>corp-profile.php">Profile</a>
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