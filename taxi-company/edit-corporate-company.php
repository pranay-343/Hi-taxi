<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';
$amt_total_credit = '0';
$data = mysql_fetch_assoc(mysql_query("select c.name,c.begning_credit,c.agreement_id,l.email,c.password,l.password_de,l.id as corColony,c.id as corIDD from `corporate` c left join `login` l ON c.web_user_id=l.id where 1 and c.web_user_id = '".$_GET['a']."'"));

	$query_amt = "SELECT manage_master_amount.amount as totalAmt FROM manage_master_amount WHERE added_by ='".$_SESSION['uid']."' AND zone_id='0' AND  type='credit_amount' AND corporate_id = '".$_GET['a']."'";
	$result_amt = mysql_query($query_amt);		
	while($row_amt=mysql_fetch_array($result_amt)){ 
		$amt_total_credit = $amt_total_credit+$row_amt['totalAmt'];
	}
	
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
          <h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
        </div>
      </div>
      <div class="c-acc-status mgr mg5">
        <h2 class="txt-style-3">Edit Corporate Company</h2>
        <div id="errorMessage">
          <?php
if(isset($_POST['submitCorporateCompany']) and $_POST['submitCorporateCompany']!=""){
updateeCorporateCompany();
HTMLRedirectURL(TAXI_URL."corp-companies.php");
}		         
?>
        </div>
        <form method="post" enctype="multipart/form-data" onSubmit="return addCorporateCompany();">
          <input type="hidden" name="logIDD" id="logIDD" value="<?php echo $data['corColony']; ?>" />
          <input type="hidden" name="corIDD" id="corIDD" value="<?php echo $data['corIDD']; ?>" />
          <div id="errorMessage"></div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label><strong>COMPANY Details</strong> </label>
              </div>
            </div>
          </div>
          <div class="row bts">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Name </label>
                <input type="text" name="name" id="name" class="input-style" placeholder="Enter Name" value="<?php echo $data['name'];?>" required />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Credit Limit </label>
                <input type="text" name="creditLimit" id="creditLimit" class="input-style" placeholder="Introduzca límite de crédito Aquí" value="<?php echo $data['begning_credit']+$amt_total_credit;?>" required />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label> Agreement </label>
                <select name="agreement" id="agreement" class="input-style">
                  <option value="">---Select Agreement--</option>
                  <?php
					  $qry = mysql_query("select * from `agreements` where 1 AND added_by = '".$_SESSION['uid']."'");
                      while($dataa = mysql_fetch_array($qry))
					  {
						  if($dataa['id'] == $data['agreement_id'])
						  {
						  $nj = "selected";
						  }
						  else
						  {
							  $nj = '';
						  }
					  ?>
                  <option value="<?php echo $dataa['id'];?>" <?php echo $nj;?>><?php echo $dataa['name'];?></option>
                  <?php
					  }
					  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label><strong>INFORMATION COMPANY MANAGEMENT</strong> </label>
                <div id="errorM"></div>
              </div>
            </div>
          </div>
          <div class="row bts">
            <div class="col-sm-4">
              <div class="form-group">
                <label>Email Id</label>
                <input type="text" name="emailID" id="emailID" class="input-style" placeholder="Email Id" value="<?php echo $data['email'];?>" required/>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label> Password </label>
                <input type="text" name="password" id="password" class="input-style" placeholder="Password" value="**********" readonly required />
                <input type="hidden" name="password_old" id="password" class="input-style" placeholder="Introduzca la contraseña aquí" value="<?php echo $data['password_de']; ?>" readonly />
              </div>
            </div>
            <div class="col-sm-4">
              <label> &nbsp; </label>
              <button onClick="return resetPassword();" style="margin: 10px;" class="dash-button hvr-wobble-horizontal w100" type="button">Reset Password</button>
            </div>
          </div>
          <div class="c-acc-status mgr bst" style="border:none; margin-bottom:0;">
            <h2 class="txt-style-3">Price Of Colonies</h2>
            <a class="dash-button hvr-wobble-horizontal col-sm-1 pull-right test5" onClick="return showNextRow();">+</a> <br/>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
              <tr>
                <th class="tab-txt1" width="30%">From</th>
                <th class="tab-txt1" width="30%">To</th>
                <th class="tab-txt1" width="10%">Cost</th>
                <th class="tab-txt1" width="10%">Delete</th>
              </tr>
              <?php
              $qryColony = mysql_query("select * from `corporate_colony` where 1 and corporate_id = '".$data['corColony']."'");
			  $j = '887';
			  while($resp = mysql_fetch_assoc($qryColony))
			  { $j++;
			  ?>
              <tr id="alredyExists_<?php echo $j;?>">
                <td class="tab-txt2"><select name="colonyA[]" id="colonyA_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                    <option value="">--Select--</option>
                    <?php 
				$qry = mysql_query("select * from `colony` where 1 and addded_by = '".$_SESSION['uid']."' order by name_A asc");
				while($dataaa = mysql_fetch_assoc($qry))
				{
					if($resp['colonyA'] == $dataaa['id']){$njSelect = 'selected';}else{$njSelect = '';}
					echo '<option value="'.$dataaa['id'].'" '.$njSelect.'>'.$dataaa['name_A'].'</option>';
				}				
				?>
                  </select></td>
                <td class="tab-txt2"><select name="colonyB[]" id="colonyB_1" class="form-control" onchange='return getstatecbo(this.value,"1")'; style="width: 90%;margin: 10px;">
                    <option value="">--Select--</option>
                    <?php 
				$qryGt = mysql_query("select * from `colony` where 1 and addded_by = '".$_SESSION['uid']."' and id = '".$resp['colonyB']."' order by name_A asc");
				$dataGt = mysql_fetch_assoc($qryGt);
				echo '<option value="'.$dataGt['id'].'" selected>'.$dataGt['name_A'].'</option>';
				?>
                  </select></td>
                <td class="tab-txt2"><input type="text" id="fare_1" name="fare[]" value="<?php echo $resp['fare'];?>" class="form-control" style="width: 70%;margin: 10px;"/></td>
                <td class="tab-txt2"><a href="#" onClick="return RemoveRowEditCorporation('<?php echo $resp['id'];?>','<?php echo $j;?>');"><img src="../images/remove.png"></a>
                  <input type="hidden" name="currentRowStatus[]" id="currentRowStatus_<?php echo $j;?>" value="9" /></td>
              </tr>
              <?php }
			  ?>
              <?php 
			  $i = '2';
			  for($i;$i <= 15;$i++)
			  { ?>
              <tr id="rowID_<?php echo $i;?>" style="display:none">
                <td class="tab-txt2"><select name="colonyA[]" id="colonyA_<?php echo $i;?>" class="form-control" onchange='return getstatecbo(this.value,"<?php echo $i;?>")'; style="width: 90%;margin: 10px;">
                    <option value="">--Select--</option>
                    <?php 
				$qry = mysql_query("select * from `colony` where 1 and addded_by = '".$_SESSION['uid']."' order by name_A asc");
				while($data = mysql_fetch_assoc($qry))
				{
					echo '<option value="'.$data['id'].'">'.$data['name_A'].'</option>';
				}				
				?>
                  </select></td>
                <td class="tab-txt2"><select name="colonyB[]" id="colonyB_<?php echo $i;?>" class="form-control" onchange='return getstatecbo(this.value,"<?php echo $i;?>")'; style="width: 90%;margin: 10px;">
                    <option value="">--Select--</option>
                  </select></td>
                <td class="tab-txt2"><input type="text" id="fare_<?php echo $i;?>" name="fare[]" value="0.00" class="form-control" style="width: 90%;margin: 10px;"/></td>
                <td class="tab-txt2"><a href="#" onClick="return showRemoveRow(<?php echo $i;?>);"><img src="../images/remove.png"></a>
                  <input type="hidden" name="currentRowStatus[]" id="currentRowStatus_<?php echo $i;?>" value="0" /></td>
              </tr>
              <?php }
			  ?>
            </table>
          </div>
          <div class="c-acc-status mgr mg5">
            <div class="row bts btsb">
              <div class="col-sm-6 col-sm-offset-3 btsa">
                <input type="hidden" name="rowNumber" id="rowNumber" value="1" />
                <input type="hidden" name="randnum" id="randnum" value="<?php echo $randomUserName;?>" />
                <input type="hidden" name="randPassword" id="randPassword" value="<?php echo $randomString;?>" />
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('updateCorporateCompany')?>" />
                <input type="submit" class="dash-button hvr-wobble-horizontal w100 wap" name="submitCorporateCompany" id="submitCorporateCompany" value="Update Detail" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
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


function RemoveRowEditCorporation(a,b)
{
	$('#alredyExists_'+b).hide();
	$('#currentRowStatus_'+b).val('1');
  $.post('getData.php',{mode:'<?php echo base64_encode('RemoveRowEditCorporation');?>',a:a},function(response){
    if(response == 1)
    {
    }
    return false;
  });
  return false;
}

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
/*
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
function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function resetPassword()
{
	var newPassword = randomPassword(10);
	$('#password').val(newPassword);
	$.post('getData.php',{mode:'<?php echo base64_encode('changePAssword');?>',a:'<?php echo $_GET['a'];?>',c:newPassword},function(response){
		//$('#errorM').html(response);
		});
	return false;
}

</script>
</body>
</html>