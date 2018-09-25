<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';

$id = base64_decode($_GET['a']);
$data = mysql_fetch_assoc(mysql_query("select * from `users` where 1 and id = '$id'"));

?>
<body>
<?php include '../include/corp-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/corp-sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
        <?php include '../include/corp-rsidebar.php'; ?>
        <div class="c-acc-status">
          <h2 class="txt-style-3">Editar Usuario</h2>
          <div id="errorMessage"></div>
          <form method="post" onSubmit="return updateCorporateUser();">
            <input type="text" name="userId" id="userId" value="<?php echo $id;?>" style="visibility:hidden;" />
            <input type="text" name="Idd" id="Idd" value="<?php echo $id;?>" style="visibility:hidden;" />
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Nombre </label>
                  <input type="text" name="name" id="name" class="input-style" required placeholder="Introduzca nombre aquí" value="<?php echo $data['name'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Correo Electronico </label>
                  <input type="text" name="emailId" id="emailID" class="input-style" required placeholder="Introducir e-mail-Id Aquí" value="<?php echo $data['email_id'];?>"/>
                  <input type="hidden" name="oldEmail" id="oldEmail" class="input-style" required placeholder="Introducir e-mail-Id Aquí" value="<?php echo $data['email_id'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> No móviles. </label>
                  <input type="text" name="contact" id="contact" class="input-style" required required placeholder="Introduzca Móvil No. Aquí" value="<?php echo $data['contact_no'];?>" onkeypress="return IsNumeric(event);"/>
                   <span id="error" style="color: Red; display: none">* Input digits (0 - 9)</span>
                </div>
              </div>
            
<!--              <div class="col-sm-4">
                <div class="form-group">
                  <label> City </label>
                  <input type="text" name="city" id="city" class="input-style" required placeholder="Introduzca texto aquí" value="<?php echo $data['city'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Zip Code </label>
                  <input type="text" name="zipCode" id="zipCode"  class="input-style" required placeholder="Introduzca texto aquí" value="<?php echo $data['zip_code'];?>"/>
                </div>
              </div>-->
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Límite de crédito </label>
                  <input type="text" name="creditLimit" id="creditLimit" class="input-style" required placeholder="Introduzca texto aquí" value="<?php echo $data['credit_limit'];?>" onKeyPress="return IsNumeric(event);"/>
                   <span id="error1" style="color: Red; display: none">* Input digits (0 - 9)</span>
                </div>
              </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label> Límite de Crédito / día </label>
                <input type="text" name="creditLimitPerDay" id="creditLimitPerDay" class="input-style" required placeholder="Introduzca texto aquí" value="<?php echo $data['credit_limit_per_day'];?>" onKeyPress="return IsNumeric(event);"/>
                 <span id="error2" style="color: Red; display: none">Input digits (0 - 9)</span>
              </div>
            </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Nombre de usuario </label>
                  <input type="text" name="username" id="username" class="input-style" required placeholder="Introduzca texto aquí" value="<?php echo $data['username'];?>"/>
                </div>
              </div>
           
              <!-- div class="col-sm-4">
                <div class="form-group">
                  <label>Old Password </label>
                  <input type="password" name="password" id="password" class="input-style" placeholder="Introduzca texto aquí" />
                </div>
              </div -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Contraseña </label>
                  <input type="text" name="password" id="password" class="input-style input-style1" placeholder="Introduzca texto aquí" value="<?php echo $data['password_de']?>" readonly="readonly">
				          <input type="hidden" name="password_hi" id="password_hi" class="input-style input-style1" placeholder="Introduzca texto aquí" value="<?php echo $data['password_de']?>">
                </div>
              </div>
			  <div class="col-sm-4">
                <div class="form-group">
                  <label>Nueva Contraseña </label>
                  <input type="password" name="newpassword" id="newpassword" class="input-style" placeholder="Introduzca texto aquí" value="" >
                </div>
              </div>
           
              <div class="col-sm-4">
                <div class="form-group">
                  <ul>
                    <li>
                      <input type="checkbox" name="blockUser" id="blockUser" <?php if($data['blockUser'] == '1'){echo 'checked';} ?>/>
                      <span>Bloquear si la voluntad del usuario excede el límite</span></li>
                  </ul>
                </div>
              </div>
           
              <div class="col-lg-12">
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('updateCorporateUser')?>" />
                <button class="dash-button hvr-wobble-horizontal wap" type="submit">ACTUALIZAR INFORMACIÓN</button>
              </div>
            </div>
          </form>
        </div>
        <div class="c-acc-status mg5">
          <h2 class="txt-style-3">Historia de viajes</h2>
          <form method="post" name="trip_histoey" action="">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> A partir de </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Seleccionar Fecha Desde"  name="start_date" value="<?php echo $_POST['start_date'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Hasta </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Seleccionar Fecha Hasta"  name="end_date" value="<?php echo $_POST['end_date'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> FORMA DE PAGO </label>
                  <ul>
					<li>
                        <input type="checkbox" name="trip_cash" value="cash" <?php if (!empty($_POST['trip_cash'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Efectivo</span>
					</li>
                    <li>
                        <input type="checkbox" name="trip_mode" value="travel" <?php if (!empty($_POST['trip_mode'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Por App</span></li>
                    <li>
                      <span>PAGADO</span></li>
                    <li>
                        <input type="checkbox" name="trip_payment_status_paid" value="paid" <?php if (!empty($_POST['trip_payment_status_paid'])): ?> checked="checked"<?php endif; ?>/>
                      <span>SI</span></li>
                    <li>
                        <input type="checkbox" name="trip_payment_status_nonpaid" value="nonpaid" <?php if (!empty($_POST['trip_payment_status_nonpaid'])): ?> checked="checked"<?php endif; ?>/>
                      <span>No</span></li>
                  </ul>
                </div>
              </div>
           
               	<div class="col-sm-4 col-sm-offset-2">
                  <div class="form-group">
                      <button class="dash-button hvr-wobble-horizontal w100 wap" type="submit" name="submit">Buscar Historia</button>
                    </div>
                  </div>
               </div>
          </form>
          <br/>
          <br/>
          <div class="bst">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
            <tr>
              <th width="20%" class="tab-txt1">Fecha</th>
              <th width="20%" class="tab-txt1">Dirección de la fuente</th>
              <th width="20%" class="tab-txt1">dirección de destino</th>
              <th width="20%" class="tab-txt1">Resultado importe</th>
              <th width="20%" class="tab-txt1">Efectivo / por aplicación</th>
              <th width="20%" class="tab-txt1">Pagado</th>
              <th width="20%" class="tab-txt1">más información</th>
            </tr>
            <?php //echo base64_encode($row['id']); echo '11'; print_r($row['id']);
                if(isset($_POST['submit'])){
                    //$trip_mode = "AND trip.trip_mode LIKE '%" . $_POST['trip_mode'] . "%'";
                if(isset($_POST['trip_mode']) && $_POST['trip_mode'] != ''){
                    $trip_mode = " AND trip.trip_mode LIKE '%" . $_POST['trip_mode'] . "%'";
                }
                if(isset($_POST['trip_payment_status_paid']) && $_POST['trip_payment_status_paid'] != ''){ 
                    $trip_payment_status_paid = " AND account.payment_mode LIKE '%" . $_POST['trip_payment_status_paid'] . "%'";
                    
                }if(isset($_POST['trip_payment_status_nonpaid']) && $_POST['trip_payment_status_nonpaid'] != ''){
                    $trip_payment_status_nonpaid = " and account.payment_mode LIKE '%" . $_POST['trip_payment_status_nonpaid'] . "%'";
                    
                }   
                if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {
                    $date = "AND account.add_on between '" . date('Y-m-d', strtotime($_POST['start_date'])) . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date'])) . "' + INTERVAL 1 DAY";
                }
                } else {
                    //$trip_mode = '';
                    $trip_mode = '';
                    $trip_payment_status_paid='';
                    $trip_payment_status_nonpaid='';
                    $date = '';
                }

            $userId = $id;
            //$query = "SELECT users.id, users.city, account.* FROM account LEFT JOIN users ON account.customer_id = users.id where customer_id= '$userId'";
               $query = "SELECT users.id, users.city, account.*, trip.id,trip.trip_mode,trip.endTrip_sourceaddress,trip.endTrip_destinationaddress,trip.payment_mode FROM account LEFT JOIN users ON account.customer_id = users.id LEFT JOIN trip ON account.trip_id = trip.id where 1 and account.customer_id = '$userId' and trip.endTrip_destinationaddress!=''  $date $trip_mode $trip_payment_status_paid $trip_payment_status_nonpaid";
                $result = mysql_query($query);
                $rows = mysql_num_rows($result);
                if($rows >0){
                while($info = mysql_fetch_array($result)){
            ?>
            <tr>
              <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['add_on']));?></td>
              <td class="tab-txt2"><?php echo $info['endTrip_sourceaddress'];?></td>
              <td class="tab-txt2"><?php echo $info['endTrip_destinationaddress'];?></td>
              <td class="tab-txt2"><?php echo $info['payment_amount'];?>mx</td>
              <td class="tab-txt2"><?php if($info['payment_mode'] == 'credit'){echo 'Por App';}else{echo 'Efectivo';}?></td>
              <td class="tab-txt2"><?php if($info['payment_mode'] =='paid' || $info['payment_mode']=='cash'){echo 'SI';}else{echo'No';} //PAGADO-paid?></td>
              <!--<td class="tab-txt2"><?php //echo $info['city'];?></td>-->              
              <td class="tab-txt2"><a href="<?php echo CORPORATE_URL;?>driver-detail.php?a=<?php echo base64_encode($info['trip_id']);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
            </tr>
            <?php } } else{?>
                <tr>
                    <td style="color: red; padding:10px" colspan="5">No hay resultados</td>
                </tr>
            <?php }?>
          </table></div><br/>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<script>
// Validation for number or credit limit 
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1 || keyCode == 9);
                var inputId =  $(e.target).attr("id");
                if(inputId == 'contact'){
                    document.getElementById("error").style.display = ret ? "none" : "inline";
                }
                if(inputId == 'creditLimit'){
                    document.getElementById("error1").style.display = ret ? "none" : "inline";                   
                }
                if(inputId == 'creditLimitPerDay'){
                    document.getElementById("error2").style.display = ret ? "none" : "inline";
                }
            return ret;
        }   
function updateCorporateUser()
{
  var name= $('#name').val();
  var emailID= $('#emailID').val();
  var oldEmail= $('#oldEmail').val();
  var contact= $('#contact').val();
  var city= $('#city').val();
  var zipCode= $('#zipCode').val();
  var creditLimit= $('#creditLimit').val();
  var creditLimitPerDay= $('#creditLimitPerDay').val();
  var username= $('#username').val();
  //var password= $('#password').val();
  var password= $('#password').val();
  var blockUser= $('#blockUser').val();
  var mode= $('#mode').val();
  var userId = $('#userId').val();
  var Idd = $('#Idd').val();
  var newpassword = $('#newpassword').val();
  
//newpassword:newpassword,Idd:Idd,userId:userId,name:name,emailID:emailID,contact:contact,city:city,zipCode:zipCode,creditLimit:creditLimit,username:username,password:password,blockUser:blockUser,
   
  if ($('#blockUser').is(":checked"))
    {
      blockUser = '1';
    }
    else
    {
       blockUser = '0'; 
    }
  $.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',{mode:mode,password:password,Idd:Idd,userId:userId,name:name,emailID:emailID,contact:contact,city:city,zipCode:zipCode,creditLimit:creditLimit,creditLimitPerDay:creditLimitPerDay,username:username,blockUser:blockUser,newpassword:newpassword,oldEmail:oldEmail},function(response){
   // console.log(response);
	if(response == 1)
    {
      $('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Usuario actualizado correctamente..!</div>');
        /*$('#name').val('');
        $('#emailID').val('');
        $('#contact').val('');
        $('#city').val('');
        $('#zipCode').val('');
        $('#creditLimit').val('');
        $('#creditLimitPerDay').val('');
        $('#username').val('');
        $('#password').val('');
        $('#cpassword').val('');
        $('#blockUser').val('');*/
    }
    else
    {
      $('#errorMessage').html(response);
    }
    
    return false;
  });
  return false;
}
 
var $start = $('#start'),
	$end = $('#end');
	$start.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$end.data('datepicker')
				.update('minDate', date)
		}
	})
	$end.datepicker({
		language: 'en',
		onSelect: function (fd, date) {
			$start.data('datepicker')
				.update('maxDate', date)
		}
	})
</script>