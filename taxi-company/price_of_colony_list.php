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
            <h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
          </div>
        </div>
		
        <div class="c-acc-status mg5 mgt0" style="border:none;">
          <h2 class="txt-style-3">Price colonies</h2>
		  <a class="dash-button hvr-wobble-horizontal wap" href="<?php echo TAXI_URL.'create_zone.php'?>" style="float : right; margin: 0 0 10px 0">Add Colony</a>
          <div class="bst" style="margin-top:40px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
            <tr>
              <th width="20%" class="tab-txt1">Colonies A</th>
              <th width="20%" class="tab-txt1">Colonies B</th>
              <th width="5%" class="tab-txt1">Rate</th>
            </tr>
            <?php //error_reporting(0);
               $colony_detail ="SELECT * FROM colony"
                            . " WHERE addded_by='".$_SESSION['uid']."'";
                        $result_colony = mysql_query($colony_detail);
                        $num_rows = mysql_num_rows($result_colony);
						
                        if(isset($num_rows) && $num_rows>0){
                        while($row = mysql_fetch_array($result_colony)){
			  ?>
            <tr>
              <td class="tab-txt2"><?php echo $row['name_A'];?></td>
              <td class="tab-txt2"><?php echo $row['name_B'];?></td>
              <td class="tab-txt2"><?php echo $row['fare'].' MX';?></td>
            </tr>
            <?php } } else{?>
            <tr>
              <td style="color: red; padding: 10px;" colspan="3">No Records Found</td>
            </tr>
            <?php }?>
          </table>
          </div>
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
function removeAgreement(a,b)
{
    swal({
        title: "¿Estas seguro?",
        text: "Usted no va a poder recuperar los detalles del Acuerdo",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
		  $.post('getData.php',{mode:a,b:b},function(response){
			  swal("Eliminado", "Los detalles del Acuerdo han sido eliminados", "Éxito");
			location.reload();
			  });
        
      });
    
    return false;
}
</script>
</body>
</html>