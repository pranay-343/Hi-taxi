<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
//echo "select * from `login` where id='".$_SESSION['uid']."'";
$query = mysql_fetch_assoc(mysql_query("select * from `login` where id='".$_SESSION['uid']."'"));
?>
<body class="corp_prof">
    <?php include '../include/corp-navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pal0">
            <?php include '../include/corp-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <?php include '../include/corp-rsidebar.php'; ?>
            <div class="c-acc-status">
              <h2 class="txt-style-3">Corporation Profile</h2>
              <form>
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Name </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Name" value="<?php echo $query['name'];?>" readonly/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <input type="text" name="txtname" class="input-style" placeholder="Contact Number" value="<?php echo $query['contact_number'];?>" readonly/>
                    </div>
                  </div>
                
               	<div class="col-sm-12">
                	<h2 class="txt-style-4">TO MODIFY THIS INFORMATION, YOU SHOULD CONTACT THE AGENCY TAXI</h2>
                </div>
               </div>
              </form>
            </div>
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Change your password</h2>
              <form method="post" onSubmit="return updatePasswordCorporate('<?php echo base64_encode('updatePasswordCorporate');?>','<?php echo $_SESSION['uid'];?>')">
                <div id="errorMessage"></div>
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <!--<label> Información </label>-->
                       <label>&nbsp;</label>
                      <input type="password" name="oldPassword" id="oldPassword" class="input-style" placeholder="Old Passowrd" required/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                       <label>&nbsp;</label>
                      <input type="password" name="newPassword" id="newPassword" class="input-style" placeholder="New Password" required/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <input type="password" name="confirmPassword" id="confirmPassword" class="input-style" placeholder="Confirm Password" required/>
                    </div>
                  </div>
               <div class="clearfix"></div>
               	<div class="col-sm-4 col-sm-offset-4">
                	<button class="dash-button hvr-wobble-horizontal wap" style="width:100%;" type="submit">Confirm</button>
                </div>
               </div><br/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
    <script type="text/javascript">
function updatePasswordCorporate(a,b)
{
  var oldPassword = $('#oldPassword').val();
  var newPassword = $('#newPassword').val();
  var confirmPassword = $('#confirmPassword').val();

if(newPassword != confirmPassword)
{
  $('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>La contraseña no corresponde</div>');
  return false;  
}

  $.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',{mode:a,b:b,oldPassword:oldPassword,newPassword:newPassword},function(data){
    
    if(data == 1)
    {
      $('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Tu contraseña fue actualizada</div>');
    }
    else
    {
     $('#errorMessage').html(data); 
    }

  });
  return false;
}
    </script>
</body>
</html>
