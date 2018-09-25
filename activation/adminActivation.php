<?php 
include '../include/define.php'; 
include '../include/head.php'; 
?>
<style type="text/css">
.login-form a {
    font-family: 'Open Sans';
    font-weight: 400;
    display: inline-block !important;
    text-align: right;
    color: #09F;
}
</style>
<body style="background:url(<?php echo MAIN_URL;?>images/background.jpg) no-repeat fixed; background-size:cover !important;">
<div class="login-header"> <img src="<?php echo MAIN_URL;?>images/logo.png" alt="" title="" /></div>
<div class="main-login">
  <div class="login-head"> Verificaci√≥n de Email </div>
  <div class="login-form">
    <form method="post" id="login_form" > <!-- onsubmit="return clcikLogin();"-->
      <?php 
//include '../include/define.php';

 $id=$_REQUEST['id'];
 $str1="select email_verification from login where id='$id'";
 $res1=mysql_query($str1);
 $row=mysql_fetch_array($res1);
 if($row['email_verification'] == '1')
 {?>
 	 <h1> Su cuenta ya est· activa, no hay necesidad de verificarla nuevamente</h1>
 <?php 
}
 else
 {
 $str="update login set email_verification='1' where id='$id' ";
 $res=mysql_query($str); 
?>
<h1>Gracias por activar su cuenta.</h1>
<a href="http://www.hvantagetechnologies.com/central-taxi/login.php">Please click to go back to website</a>
<?php
}
?>

      
    </form>
  </div>
</div>

<?php
include '../include/footer.php'; 
?>
</body>
</html>
<script  type="text/javascript">
  $.backstretch("images/background.jpg");
</script>


