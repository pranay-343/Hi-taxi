<?php 

include 'include/define.php'; 

include 'include/head.php'; 

?>

<style type="text/css">

.login-form a {

    font-family: 'Open Sans';

    font-weight: 400;

    display: inline-block !important;

    text-align: right;

    color: #09F;

}
.dash-button {
    border: none;
    line-height: 32px;
    width: 100%;
    height: 43px;
}

</style>

<body style="background:url(<?php echo MAIN_URL;?>images/background.jpg) no-repeat fixed; background-size:cover !important;">

<div class="login-header"> <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" /></div>

<div class="main-login">

  <div class="login-head"> Se te olvidó tu contraseña</div>

  <div class="login-form">
 <?php 
			  
if(isset($_POST['submitForm']) and $_POST['submitForm']!=""){    
forgot_password();
//unset($_POST);
}
			  ?>
    <form method="post" id="forgot_form" > <!-- onsubmit="return clcikLogin();"-->

      <div id="errorMessage">

      </div>

      <div class="form-group">

        <input type="email" name="txtemail" id="txtemail" placeholder="IdentificaciÃ³n de correo" class="form-control" required/>

      </div>

      

      

     

      <div class="form-group">

        <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('forgot_password');?>" />
        <input type="submit" name="submitForm" id="submitForm" class="dash-button hvr-wobble-horizontal w10 form-control" value="Enviar" />
        <!--<button class="form-control" type="submit" name="submitForm" >Enviar</button>-->

      </div>

    </form>

  </div>

</div>



<?php

include 'include/footer.php'; 

?>

</body>

</html>

<script  type="text/javascript">

  $.backstretch("images/background.jpg");

</script>

<script>

  function refreshCaptcha(){

    var img = document.images['captchaimg'];

    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;

  }

/*

  function clcikLogin()

  {

    var emnailID = $('#emailID').val();

    var pwd = $('#pwd').val();

    var mode = $('#mode').val();

    //var captcha = '<?php echo $_SESSION['captcha_code'];?>';

    $.post('<?php echo MAIN_URL;?>pageFragment/ajaxDataSaver.php',{mode:mode,email:emnailID,pwd:pwd},function(response){

      $('#errorMessage').html(response);

      return false;

    });

    return false;

  }

  */

</script>

