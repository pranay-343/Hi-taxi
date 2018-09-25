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
 body {
        top: 0px !important;
}
</style>

<body style="background:url(<?php echo MAIN_URL;?>images/background.jpg) no-repeat fixed; background-size:cover !important;">

<div class="login-header"> <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" /></div>

<div class="main-login">

  <div class="login-head"> Login </div>

  <div class="login-form">

    <form method="post" id="login_form" > <!-- onsubmit="return clcikLogin();"-->

      <div id="errorMessage">

<?php

if(isset($_POST['submitForm']))

{

  

    // code for check server side validation

    if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  

        $msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.     

    }else{// Captcha verification is Correct. Final Code Execute here!      

        $msg="<span style='color:green'>The Validation code has been matched.</span>";      

    }



  login('login');

} 

?>

      </div>

      <div class="form-group">

        <input type="email" name="email" id="email" placeholder="Enter Email" class="form-control" required/>

      </div>

      <div class="form-group">

        <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control" required/>

      </div>

      <div class="form-group"> <a href="<?php echo MAIN_URL.'forgot_password.php';?>">Forgot Password?</a> </div>

      <div class="form-group captcha">

        <div class="captcha-image"> 

          <img src="<?php echo MAIN_URL;?>captcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>

          <label for='message'>Enter security code here</label>

        </div>

        <input id="captcha_code" name="captcha_code" type="text" class="form-control" required>

<!--        You can not read the image? <a href='javascript: refreshCaptcha();'>click here to update­</a> para actualizar. -->

      </div>

      <div class="form-group">

        <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('Login');?>" />

        <button class="form-control" type="submit" name="submitForm" ><i class="fa fa-lock"></i> Login</button>

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

