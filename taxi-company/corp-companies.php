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
          <div class="row br1">
<div class="col-sm-12">
<h1 class="txt-style-1 bn">Account User: <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
        <div class="c-acc-status mg5 mgt0">
          <h2 class="txt-style-3">Corporate Companies</h2>
          <form method="post">
            <div class="row">
              <div class="col-md-3"> </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="input-style" placeholder="Name" value="<?php echo $_POST['name'];?>"/>
                </div>
              </div>
              <div class="col-md-3"> </div>
            </div>
            <div class="row bts try">
              <div class="col-sm-4 col-sm-offset-2 step1" style="text-align:center;">
                <input type="submit" name="search" id="search" class="dash-button hvr-wobble-horizontal w100 wap" value="Search" style="margin-top:0px"/>
              </div>
              <div class="col-sm-4 step2" style="text-align:center;">
                <a href="<?php echo TAXI_URL; ?>add-corporate-company.php" class="dash-button hvr-wobble-horizontal w100 wap fsm" style="margin-top:0px;">Add Corporate Company</a>
              </div>
            </div>
          </form>
          <br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1 table table-border" style="margin-bottom:0;">
              <thead>
              <tr>
                <th width="20%" class="tab-txt1">Name</th>
                <th width="10%" class="tab-txt1">Credit Limit </th>
                <th width="20%" class="tab-txt1">Aggregate </th>
                <th width="7%" class="tab-txt1">Action</th>
                <!--<th width="7%" class="tab-txt1">RETIRAR</th>-->
              </tr>
<?php 
if($_POST['name'] != '')
{
    $name = " and c.name like '%".$_POST['name']."%'";
}
else
{$name = '';}
$query="select c.id,c.name,c.begning_credit,a.name as agrName, c.web_user_id from `corporate` c Left Join `agreements` a ON a.id = c.agreement_id where 1 and company_id = '".$_SESSION['uid']."' $name order by c.id ASC";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	$amt_total_credit = '0';
	if($num_rows>0){
	while($row=mysql_fetch_assoc($result))
		//echo $row['web_user_id']; echo'<br>';
	{
		$query_amt = "SELECT manage_master_amount.amount as totalAmt FROM manage_master_amount WHERE added_by ='".$_SESSION['uid']."' AND zone_id='0' AND  type='credit_amount' AND corporate_id = '".$row['web_user_id']."'";
		$result_amt = mysql_query($query_amt);
		
	while($row_amt=mysql_fetch_array($result_amt))
	{ 
		$amt_total_credit = $amt_total_credit+$row_amt['totalAmt'];
	}
	?>
<tr>
    <td class="tab-txt2"><?php echo $row['name'];?></td>
	<?php  
	
	?>
    <td class="tab-txt2"> <?php echo $amt_total_credit+$row['begning_credit'];?> </td>
    <td class="tab-txt2"> <?php echo $row['agrName'];?> </td>
    <td class="tab-txt2">
        <a href="edit-corporate-company.php?a=<?php echo $row['web_user_id'];?>"><span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span></a> &nbsp;&nbsp;
<!--        <a href="javascript:;" title="Delete" data-toggle="modal" data-target="#myModal<?php echo $row["web_user_id"];?>" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a>-->
    </td>
    <!-- <td class="tab-txt2"><a href="javascript:;" onClick="return deleteCorporateCompany(<?php //echo $row["web_user_id"];?>);"><img src="../images/remove.png"  alt="" title="" /></a></td> -->
     <!--<td class="tab-txt2"><a href="javascript:;" title="Delete" onClick="return deleteCorporateCompany(<?php echo $row["web_user_id"];?>);" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a></td> -->
    
   
                    <div class="modal fade" id="myModal<?php echo $row["web_user_id"];?>" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">¿Estas seguro?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>No podras recuperar los detalles del administrador corporativo una vez eliminado.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="deleteDrivers" onClick="return deleteCorporateCompany(<?php echo $row["web_user_id"]; ?>);">SI</button>
                                </div>
                            </div>
                        </div>
                    </div>
  </tr>
<?php
	} }else{
	?>
	<tr>
        <td style="color: red; padding: 10px;" colspan="5"> No Records Found</td>
    </tr>
	<?php }?>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
function deleteCorporateCompany1(a)
    {
      swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles del administrador corporativo una vez eliminado.",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
        },
      function(){ 
          $.post('getData.php',{mode:'<?php echo base64_encode('deleteCorporateAccount');?>',a:a},function(data){
          swal("Eliminado", "Los detalles del Acuerdo han sido eliminados", "Éxito");
          location.reload();
         });
        });
      return false;
    }
    
     function deleteCorporateCompany(a){alert(a);
     $.post('getData.php',{mode:'<?php echo base64_encode('deleteCorporateAccount');?>',a:a},function(response){
                $('#errorMessage').html(response);                
                 location.reload();
            }); 
        }
</script>
</body>
</html>