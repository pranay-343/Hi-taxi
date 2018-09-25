<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$data = mysql_fetch_assoc(mysql_query("select * from `login` where 1 and id= '".$_SESSION['uid']."'"));
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
<h1 class="txt-style-1">Super Administrator Hi Taxi</h1>
<div class="row">
<div class="c-acc-status mgr">
              <h2 class="txt-style-3">Manage the profile details</h2>
              <form method="post" onSubmit="return updateLoginDetails();">
                <div id="errorMessage"></div>
                <div class="row ert">

                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> Name</label>
                      <input type="text" class="input-style" data-language="en" name="name" id="name" required value="<?php echo $data['name'];?>" placeholder="Name">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> Email </label>
                      <input type="text" class="input-style" data-language="en" name="email" id="email"  readonly placeholder="Email" value="<?php echo $data['email'];?>">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> PHONE </label>
                      <input type="text" class="input-style" data-language="en" name="contact_number" required id="contact_number" value="<?php echo $data['contact_number'];?>" placeholder="Contact Number" onKeyPress="return IsNumericNumber(event);">
                      <span id="error" style="color: Red; display: none"> Enter number only (0 - 9)</span>
                    </div>
                  </div>
                  <div class="col-sm-12">
                  <div class="form-group">
                      <label> ADDRESS </label>
                      <input type="text" class="input-style" data-language="en" name="address" id="address" required value="<?php echo $data['address'];?>" placeholder="
Introduzca la contraseña de">
                    </div>
                  </div>

                  <!-- -->
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> CURRENT PASSWORD </label>
                      <input type="password" class="input-style" data-language="en" name="currentPassword" id="currentPassword" placeholder="CURRENT PASSWORD">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> NEW PASSWORD </label>
                      <input type="password" class="input-style" data-language="en" name="newPassword" id="newPassword" placeholder="NEW PASSWORD">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label> CONFIRM PASSWORD</label>
                      <input type="password" name="confirmPassword" id="confirmPassword" class="input-style" placeholder="CONFIRM PASSWORD">
                      
                    </div>
                  </div>
                </div>
                <div class="row ert">
                	<div class="col-sm-4 col-sm-offset-4">
                		<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('updateLoginDetails')?>" />
                    	<button class="dash-button hvr-wobble-horizontal w100 f74">Actualizar Perfil</button>
                    </div>
                </div>
              </form>
            </div>	
</div>
           
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script>
function updateLoginDetails()
{
	var currentPassword= $('#currentPassword').val();
	var newPassword= $('#newPassword').val();
	var confirmPassword= $('#confirmPassword').val();
	var mode= $('#mode').val();
  var address= $('#address').val();
  var name= $('#name').val();
  var contact_number= $('#contact_number').val();

	if(newPassword !== confirmPassword)
	{
		alert('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>La contraseña ingresada no es correcta</div>');
		return false;
	}
	$.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',{contact_number:contact_number,name:name,address:address,mode:mode,currentPassword:currentPassword,newPassword:newPassword,confirmPassword:confirmPassword},function(response){
		if(response == '1')
		{
			$('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Tu información subida</div>');
			$('#currentPassword').val('');
			$('#newPassword').val('');
			$('#confirmPassword').val('');
		}
		else
		{
		$('#errorMessage').html(response);	
		}
		
		return false;
	});
	return false;
}
 // Validation for number or credit limit         
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumericNumber(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
</script>
</body>
</html>
