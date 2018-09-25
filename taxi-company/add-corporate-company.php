<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$length = 10;
$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{:?><|}"), 0, $length);
$randomUserName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 2);
?>
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <div class="row br1">
<div class="col-sm-12">
<h1 class="txt-style-1 bn">Account User: <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Add New Corporate Business</h2>
              <div id="errorMessage"></div>
              <form method="post" enctype="multipart/form-data" onSubmit="return addCorporateCompany();">
                <?php 
                $corporateAdmin = mysql_fetch_array(mysql_query("select `email`,`name` from `login` where `id` ='".$_SESSION['uid']."' "));
               ?>
                <div id="errorMessage">
<?php
if(isset($_POST['submitCorporateCompany']) and $_POST['submitCorporateCompany']!=""){
addCorporateCompany();
HTMLRedirectURL(TAXI_URL."add-corporate-company.php");
}		         
?>
                </div>
                <div class="row bts">
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label><strong>Corporate Detail</strong> </label></div></div>
                     <div class="clearfix"></div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label>Name </label>
                      <input type="text" name="name" id="name" class="input-style" placeholder="Name" required onChange="return createUSername();"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label> Credit Limit </label>
                      <input type="text" name="creditLimit" id="creditLimit" class="input-style" placeholder="Credit Limit" required onClick="return createUSername();" onKeyPress="return IsNumeric(event);" value =<?php echo corporation_act_amt;?> >
					  <span id="error" style="color: Red; display: none">Input digits (0 - 9)</span>
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label> Agreement </label>
                      <select name="agreement" id="agreement" class="input-style">
                      <option value="0">---Select Agreement--</option>
                      <?php
					  $qry = mysql_query("select * from `agreements` where 1 AND added_by = '".$_SESSION['uid']."'");
                      while($data = mysql_fetch_array($qry))
					  {
					  ?>
                      <option value="<?php echo $data['percentage'];?>"><?php echo $data['name'];?></option>
                      <?php
					  }
					  ?>
                      </select>
                    </div>
                  </div>
               <div class="clearfix"></div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label><strong>INFORMATION COMPANY MANAGEMENT</strong> </label></div></div>  <div class="clearfix"></div>
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Email Id</label>
                      <input type="email" name="emailID" id="emailID" class="input-style" placeholder="Email Id" required/>
                    </div>
                  </div> 
                  <div class="col-sm-6">
                  <div class="form-group">
                     <label> Password </label>
                      <input type="text" name="password" id="password" class="input-style" placeholder="Password" readonly required value="<?php echo $randomString;?>"/>
                    </div>
                  </div>
                
                
            </div>
            <div class="c-acc-status mgr bst">
            <h2 class="txt-style-3 mgb">Price Of Colonies</h2>
            
            	<a class="dash-button hvr-wobble-horizontal col-sm-1 pull-right" onClick="return showNextRow();">+</a>
                <div class="clearfix"></div> 
         <div class="spacetop">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1" width="30%">From</th>
                <th class="tab-txt1" width="30%">To</th>
                <th class="tab-txt1" width="10%">Cost</th>
                <th class="tab-txt1" width="10%">Delete</th>
              </tr>
              <tr>
                <td class="tab-txt2">
                <select name="colonyA[]" id="colonyA_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                <?php 
            				$qry = mysql_query("select * from `colony` where 1 AND colony.addded_by = '".$_SESSION['uid']."'  order by name_A asc");
            				while($data = mysql_fetch_assoc($qry))
            				{
            					echo '<option value="'.$data['id'].'">'.$data['name_A'].'</option>';
            				}				
        				?>
                </select>
                </td>
                <td class="tab-txt2">
                <select name="colonyB[]" id="colonyB_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                </select>
                </td>
                <td class="tab-txt2">
                <input type="text" id="fare_1" name="fare[]" value="0.00" class="form-control" style="width: 90%;margin: 10px;"/>
                </td>
                <td class="tab-txt2"><a href="#"></a><input type="hidden" name="currentRowStatus[]" id="currentRowStatus_<?php echo $i;?>" value="9" /></td>
              </tr>
              <?php 
			  $i = '2';
			  for($i;$i <= 15;$i++)
			  { ?>
				<tr id="rowID_<?php echo $i;?>" style="display:none">
                <td class="tab-txt2">
                <select name="colonyA[]" id="colonyA_<?php echo $i;?>" class="form-control" onchange='return getstatecbo(this.value,"<?php echo $i;?>")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                <?php 
				$qry = mysql_query("select * from `colony` where 1 AND colony.addded_by = '".$_SESSION['uid']."' order by name_A asc");
				while($data = mysql_fetch_assoc($qry))
				{
					echo '<option value="'.$data['id'].'">'.$data['name_A'].'</option>';
				}				
				?>
                </select>
                </td>
                <td class="tab-txt2">
                <select name="colonyB[]" id="colonyB_<?php echo $i;?>" class="form-control" onchange='return getstatecbo(this.value,"<?php echo $i;?>")'; style="width: 90%;margin: 10px;">
                <option value="">--Select--</option>
                </select>
                </td>
                <td class="tab-txt2">
                <input type="text" id="fare_<?php echo $i;?>" name="fare[]" value="0.00" class="form-control" style="width: 90%;margin: 10px;"/>
                </td>
                <td class="tab-txt2"><a href="#" onClick="return showRemoveRow(<?php echo $i;?>);"><img src="../images/remove.png"></a>
                <input type="hidden" name="currentRowStatus[]" id="currentRowStatus_<?php echo $i;?>" value="0" /></td>
              </tr>
			  <?php }
			  ?>
              </table></div>
            </div>
            <div class="c-acc-status mgr mg5">
            <div class="row bts">
               	<div class="col-sm-4 col-sm-offset-4 btsa">
                <input type="hidden" name="rowNumber" id="rowNumber" value="1" />
                <input type="hidden" name="randnum" id="randnum" value="<?php echo $randomUserName;?>" />
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addCorporateCompany')?>" />
                <input type="hidden" id="corporate_email" name="corporate_email" value="<?php echo $corporateAdmin['email'] ?>">
                <input type="hidden" name="corporate_name" id="corporate_name" value="<?php echo $corporateAdmin['name'];?>" />
                <input type="submit" class="dash-button hvr-wobble-horizontal w100 wap fs" name="submitCorporateCompany" id="submitCorporateCompany" value="Add Corporate Detail" />    
                </div>
                </div></div>
              </form>
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">

//NUmber Validation

var specialKeys = new Array();
specialKeys.push(8); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        var inputId =  $(e.target).attr("id");
        if(inputId == 'creditLimit'){
            document.getElementById("error").style.display = ret ? "none" : "inline";
        }
       
    return ret;
}

function showNextRow()
{
	var rowNumber = $('#rowNumber').val();
	var a = parseInt(rowNumber)+1;
	$('#rowID_'+a).show();
	$('#rowNumber').val(a);
	$('#currentRowStatus_'+a).val('9');
	return false;
}
function showRemoveRow(a)
{
	$('#rowID_'+a).hide();
	$('#currentRowStatus_'+a).val('1');
	return false;
}
/*
function addCorporateCompany()
{
  var name= $('#name').val();
  var emailID= $('#email').val();
  var creditLimit= $('#creditLimit').val();
  var agreement= $('#agreement').val();
  var password= $('#password').val();
  var mode= $('#mode').val();

  $.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',{mode:mode,name:name,emailID:emailID,password:password,creditLimit:creditLimit,agreement:agreement},function(response){
    if(response == 1)
    {
      $('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Corporate Administrator Added Successfully..!</div>');
    window.location.href = '<?php echo TAXI_URL;?>corp-companies.php';
    }
    else
    {
      $('#errorMessage').html(response);
    }
    return false;
  });
  return false;
}

function createUSername()
{
	console.log('nj');
	var randnum = $('#randnum').val();
	var name= $('#name').val();
	if(name == '' || name == null)
	{
		
	}
	else
	{
		$('#email').html(name+'_'+randnum+'@gmail.com');
	}
	return false;
}
*/
<!-- get description of tax-->
function getstatecbo(a,b)
{
	$.post('getData.php',{a:a,mode:'<?php echo base64_encode('getColonyB');?>'},function(data){
		if(data == '0')
		{}
		else
		{
			var obj = $.parseJSON(data);
			$('#colonyB_'+b).html(obj.option);
			$('#fare_'+b).val(obj.fare);
		}
		});
	return true;		
}
</script>
</body>
</html>
