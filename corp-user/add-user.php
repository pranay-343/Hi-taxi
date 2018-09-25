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
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Add User</h2>
              <div id="errorMessage"></div>
              <form method="post" onSubmit="return addCorporateUser();">
                <div class="row bts">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Name </label>
                      <input type="text" name="name" id="name" class="input-style" required placeholder="Name" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Email Id </label>
                      <input type="email" name="emailId" id="emailID" class="input-style" required placeholder="Email Id" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Contact Number </label>
                      <input type="text" name="contact" id="contact" class="input-style" required required placeholder="Contact Number" onkeypress="return IsNumeric(event);" />
                       <span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
                    </div>
                  </div>
                
<!--                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> City </label>
                      <input type="text" name="city" id="city" class="input-style" required placeholder="Introduzca texto aquí" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Zip Code </label>
                      <input type="text" name="zipCode" id="zipCode"  class="input-style" required placeholder="Introduzca texto aquí" />
                    </div>
                  </div>-->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> CREDIT LIMIT </label>
                      <input type="text" name="creditLimit" id="creditLimit" class="input-style" required placeholder="CREDIT LIMIT" onKeyPress="return IsNumeric(event);"/>
                      <span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> CREDIT LIMIT / DAY </label>
                      <input type="text" name="creditLimitPerDay" id="creditLimitPerDay" class="input-style" required placeholder="CREDIT LIMIT / DAY"  onkeypress="return IsNumeric(event);"/>
                       <span id="error2" style="color: Red; display: none">* Input digits (0 - 9)</span>
                    </div>
                  </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label> USERNAME </label>
                        <input type="text" name="username" id="username" class="input-style" required placeholder="USERNAME" />
                    </div>
                </div>
                
                  
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> PASSWORD </label>
                      <input type="password" name="password" id="password" class="input-style" required placeholder="PASSWORD" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> CONFIRM PASSWORD </label>
                      <input type="password" name="cpassword" id="cpassword" class="input-style" required placeholder="CONFIRM PASSWORD" />
                    </div>
                  </div>
                
                  <div class="col-sm-4">
                    <div class="form-group">
                      <ul>
                        <li>
                            <input type="checkbox" name="blockUser" id="blockUser"/>
                          <span>Will block if the user exceeds the limit</span></li>
                      </ul>
                    </div>
                  </div>
                <div class="clearfix"></div>
                  <div class="col-lg-12">
                      <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addCorporateUser')?>" />
                    <button class="dash-button hvr-wobble-horizontal w100 wap" type="submit">Add User</button>
                  </div>
                </div><br/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
    <script>  
        // Validation for number or credit limit 
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1 || keyCode == 9);
                var inputId =  $(e.target).attr("id");
                if(inputId == 'contact'){
                    document.getElementById("error").style.display = ret ? "none" : "inline";
                }
                if(inputId == 'creditLimit'){
                    document.getElementById("error1").style.display = ret ? "none" : "inline";                   
                }
                if(inputId == 'creditLimitPerDay'){
                    document.getElementById("error2").style.display = ret ? "none" : "inline";
                }
            return ret;
        }
        
        
        
    
    function addCorporateUser()
{
  var name= $('#name').val();
  var emailID= $('#emailID').val();
  var contact= $('#contact').val();
  var city= $('#city').val();
  var zipCode= $('#zipCode').val();
  var creditLimit= $('#creditLimit').val();
  var creditLimitPerDay= $('#creditLimitPerDay').val();
  var username= $('#username').val();
  var password= $('#password').val();
  var cpassword= $('#cpassword').val();
  var blockUser= $('#blockUser').val();
  var mode= $('#mode').val();
  
  if ($('#blockUser').is(":checked"))
    {
      blockUser = '1';
    }
    else
    {
       blockUser = '0'; 
    }
  
  if(password != cpassword)
  {
  $('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>La contraseña no corresponde.</div>');
  return false;
  }

  $.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',
  {name:name,emailID:emailID,contact:contact,city:city,zipCode:zipCode,creditLimit:creditLimit,creditLimitPerDay:creditLimitPerDay,username:username,password:password,blockUser:blockUser,mode:mode},function(response){
    if(response == 1)
    {
      $('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Nuevo usuario agregado con éxito.</div>');
        $('#name').val('');
        $('#emailID').val('');
        $('#contact').val('');
        $('#city').val('');
        $('#zipCode').val('');
        $('#creditLimit').val('');
        $('#creditLimitPerDay').val('');
        $('#username').val('');
        $('#password').val('');
        $('#cpassword').val('');
        $('#blockUser').val('');
    }
    else
    {
      $('#errorMessage').html(response);
    }
    return false;
  });
  return false;
}
    </script>
    
</body>
</html>
