<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
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
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Add Administrator</h2>
              <div id="errorMessage">
              <?php 
			  
if(isset($_POST['addmap_btn']) and $_POST['addmap_btn']!=""){
addAdministrator();
unset($_POST);
}
			  ?>
              </div>
              <form method="post" onSubmit="return addAdministrator();" enctype="multipart/form-data">
				       <?php 
                $superAdmin = mysql_fetch_array(mysql_query("select `email`,`name` from `login` where `id` ='".$_SESSION['uid']."' "));
               ?>
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Name </label>
                      <input type="text" name="name" id="name" class="input-style" placeholder="Name" required>
                     <div class="help-block with-errors"></div>
                    </div>
                  </div>
                 <div class="col-sm-6">
                  <div class="form-group">
                     <label>Phone  Number </label>
                     <input type="text" name="contactno" id="contactno" class="input-style" placeholder="Contact Number" required value="" onKeyPress="return IsNumericNumber(event);" maxlength="12">
                      <span id="error" style="color: Red; display: none"> Only Number Type (0 - 9)</span>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Email </label>
                      <input type="email" name="emailID" id="emailID" class="input-style" placeholder="Email" required>
                     <div class="help-block with-errors"></div>
                    </div>
                  </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Password </label>
                      <input type="password" id="password" name="password" class="input-style" placeholder="Password" required>
                     <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
             
        <style type="text/css">
            
        </style>
          <div class="field_wrapper">
                <div>
                <a href="javascript:void(0);" class="add_button" title="Add field"><img src="add-icon.png"/></a>
                    <input type="file" name="file_name[]" value="" class="s4a"/>
                    <div class="clearfix"></div>
                </div>
            </div>
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addAdministrator');?>" />
                <input type="hidden" name="super_email" id="super_email" value="<?php echo $superAdmin['email'];?>" />
                <input type="hidden" name="super_name" id="super_name" value="<?php echo $superAdmin['name'];?>" />
                <input class="dash-button hvr-wobble-horizontal w100 disabled" type="submit" name="addmap_btn" id="addmap_btn" value="Add  Administrator" style="pointer-events: all; cursor: pointer;">
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
</body>
</html>
<!-- add doc support -->
<script type="text/javascript">
    // Validation for number or credit limit         
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumericNumber(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
    
$(document).ready(function () {
	var maxField = 20; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><a href="javascript:void(0);" class="remove_button" title="Eliminar campo"><img src="remove-icon.png"/></a><input type="file" class="s4a" name="file_name[]" value=""/><div class="clearfix"></div></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function () { //Once add button is clicked
		if (x < maxField) { //Check maximum number of input fields
		x++; //Increment field counter
		$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function (e) { //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>
