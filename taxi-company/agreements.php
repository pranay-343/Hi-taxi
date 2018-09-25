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
            <div class="c-acc-status mg5 mgt0">
              <h2 class="txt-style-3">Agreement</h2>
<?php
if(isset($_POST['addaggrement']) and $_POST['addaggrement']!=""){
addaggrementCreate();
unset($_POST);
}
?>
              <form method="post" enctype="multipart/form-data">
				<div class="row bts">
					<div class="col-md-4">
                    <div class="form-group">
                    	<label>AGREEMENT NAME </label>
                    	<input type="text" name="name" class="input-style" placeholder="AGREEMENT NAME" required/>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                    	<label>AGREEMENT PERCENT</label>
                    	<input type="text" name="percentage" id="percentage" class="input-style" placeholder="AGREEMENT PERCENT" onkeypress='validate(event)' required/>
					  <span id="error" style="color: Red; display: none">Input digits (0 - 9)</span>
					  <span id="error1" style="color: Red; display: none">Por favor, introduzca el porcentaje de  0 to 100</span>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                    	<label>Document File </label>
                        <input type="file" name="file_name" class="input-style" placeholder="Documentos extras del convenio"/>
                    </div>
                    </div>
                    
                    <div class="col-md-12">
                    <div class="form-group">
                    	<label>DESCRIPTION OF AGREEMENT </label>
                    	<textarea name="descripition" class="input-style" placeholder="DESCRIPTION OF AGREEMENT....." required></textarea>
                    </div>
                    </div>
                <div class="clearfix"></div>
				<div class="col-lg-12" style="text-align:center;">
                <input type="hidden" name="aggrement_by" id="aggrement_by" value="<?php echo $_SESSION['uid'];?>"/><br/>
                 <input class="dash-button hvr-wobble-horizontal wap" style="margin-top:0px;" type="submit" name="addaggrement" id="addaggrement" value="Save AGREEMENT" />
                    </div>
                </div>
              </form>
              <div class="bst" style="margin-top:40px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="20%" class="tab-txt1">AGREEMENT NAME</th>
                <th width="20%" class="tab-txt1">DESCRIPTION</th>
                <th width="5%" class="tab-txt1">PERCENTAGE  (%)</th>
                <th width="7%" class="tab-txt1">ACTION</th>
<!--                <th width="7%" class="tab-txt1">Editar</th>
                <th width="7%" class="tab-txt1">retirar</th>-->
              </tr>
              <?php
              $qry = "select * from `agreements` where 1 and `aggrement_by`='".$_SESSION['uid']."'";
			  $res = mysql_query($qry);
                          if(mysql_num_rows($res) > 0){
			  while($data = mysql_fetch_array($res))
			  {
			  ?>
              <tr>
                <td width="25%" class="tab-txt2"><?php echo $data['name'];?></td>
                <td width="25%" class="tab-txt2"><?php echo $data['descripition'];?></td>
                <td width="25%" class="tab-txt2"><?php echo $data['percentage'];?></td>
                <td width="25%" class="tab-txt2">
                    <a href="edit_agreements.php?a=<?php echo $data['id'];?>"><span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span></a>&nbsp;&nbsp;
                    <a class="btn btn-xs btn-outline btn-danger add-tooltip" href="javascrit:void()" onClick="return removeAgreement('<?php echo base64_encode('deleteAgreement');?>','<?php echo $data['id'];?>')">
                        <i class="fa fa-times fa-1x"></i>
                        <!--<img src="../images/remove.png" alt="" title="" />-->
                    </a>
                </td>
                <td class="tab-txt2"></td>
              </tr>
              <?php
                          } }else{
			  ?>
                    <tr>
                      <td style="color: red; padding: 10px;" colspan="8"> No se hallaron registros</td>
                    </tr>
                          <?php }?>
              
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

(function(doc) {
        var oIn = doc.getElementById('percentage');
        var nIn = oIn.value;
        oIn.addEventListener('keyup', function() {
            if(this.value > 100) {
                alert('Cannot exceed 100');
                this.focus();
            }
        });
    })(document);

function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}


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
			  swal("Deleted!", "Los detalles del Acuerdo han sido eliminados", "Éxito");
			location.reload();
			  });
        
      });
    
    return false;
}
</script>
</body>
</html>