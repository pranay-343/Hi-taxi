<!-- corp user starts -->
<div class="header">
  <div class="container">
      <div class="row">
          <div class="col-sm-4">
              <div class="logo">
                  <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" />
                </div>
            </div>
            <div class="col-sm-8">
            <div class="top_right_toggle">
            <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['uname'];?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo CORPORATE_URL;?>corp-profile.php">Perfil</a>
                            </li>
                            <li>
                                <a href="<?php echo MAIN_URL;?>logout.php">Cerrar sesiÃ³n</a>
                            </li>
                            
                        </ul>
                    </li>
                    </ul>
                    </div>
            </div>
        </div>
    </div>
</div>