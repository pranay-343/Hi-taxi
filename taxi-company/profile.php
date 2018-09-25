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
          <div class="col-sm-9">
<h1 class="txt-style-1">Perfil</h1>
<div class="row">
<div class="c-acc-status mgr">
              <h2 class="txt-style-3">Actualizar datos de login</h2>
              <form method="post" onSubmit="return updateLoginDetails();">
                <div id="errorMessage"></div>
                <div class="row bts">
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> Contraseña actual </label>
                      <input type="password" class="input-style" data-language="en" name="currentPassword" id="currentPassword" placeholder="Ingresar la contraseña actual">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> Nueva contraseña </label>
                      <input type="password" class="input-style" data-language="en" name="newPassword" id="newPassword" placeholder="Ingresar la nueva contraseña">
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label>Confirmar contraseña</label>
                      <input type="password" name="confirmPassword" id="confirmPassword" class="input-style" placeholder="Ingresar la contraseña nuevamente">
                      
                    </div>
                  </div>
                <div class="clearfix"></div>
                	<div class="col-sm-4 col-sm-offset-4 btsa">
                		<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('updateTaxiCompanyLoginDetails')?>" />
                    	<button class="dash-button hvr-wobble-horizontal w100 f74">Actualizar datos de login</button>
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
	if(newPassword !== confirmPassword)
	{
		$('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>La contraseña no corresponde</div>');
		return false;
	}
	$.post('<?php echo MAIN_URL?>pageFragment/ajaxAccountData.php',{mode:mode,currentPassword:currentPassword,newPassword:newPassword,confirmPassword:confirmPassword},function(response){
		if(response == '1')
		{
			$('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Tu contraseña fue actualizada</div>');
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
</script>
</body>
</html>
