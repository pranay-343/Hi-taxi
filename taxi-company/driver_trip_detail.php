<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';

$id = base64_decode($_GET['a']);
//print_r($id);
?>
<style type="text/css">
#result {
	position:absolute;
	width:100%;
	padding:10px;
	display:none;
	margin-top:-1px;
	border-top:0px;
	overflow:hidden;
	border:1px #CCC solid;
	background-color: white;
}
.show {
	padding:5px;
	border-bottom:1px #999 dashed;
	font-size:15px;
}
.show:hover {
	background:#4c66a4;
	color:#FFF;
	cursor:pointer;
}
</style>
<body class="pop">
<?php include '../include/taxi-navbar.php'; ?>
<div class="main_content">
  <div class="container pal0">
    <div class="row">
      <div class="col-sm-3 pa10">
        <?php include '../include/taxi-sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
        <div class="c-acc-status mg5">
          <h2 class="txt-style-3">Estado de Cuenta : Detalle Taxi Conductor de viaje</h2>
          <form method="post" name="search" action="" autocomplete="off">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> De </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Seleccionar fecha desde"  name="start_date" value="<?php echo $_POST['start_date'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Entonces </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Seleccionar fecha hasta"  name="end_date"  value="<?php echo $_POST['end_date'];?>"/>
                </div>
              </div>
           
              <div class="col-lg-12" style="text-align:center;">
                <button class="dash-button hvr-wobble-horizontal wap" type="submit" name="submit">Filtros</button>
              </div>
            </div>
          </form>
        </div>
     
          <div class="c-acc-status mg5 bst">
            <h2 class="txt-style-3">Historia de viajes</h2>
            <br/>
            <br/>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr> 
                <!--<th class="tab-txt1">Trip id</th>-->
                <th class="tab-txt1">Conductor de taxi</th>
                <th class="tab-txt1">Ingresos</th>
                <th class="tab-txt1">Fecha</th>
              </tr>
              <?php
                if (isset($_POST['submit'])) {  
                    $fromDate = date('m/d/Y', strtotime($_POST['start_date']));
                    $toDate = date('m/d/Y', strtotime($_POST['end_date']));                
                if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {                    
					$date = "AND driverPayment.paymentDateFrom >= '$fromDate' AND driverPayment.paymentDateTo <= '$toDate' ";
                }                
                
            } else {
                $date = '';
            }
            /* $str="SELECT `trip`.id as tripId,`trip`.tripdatetime,`trip`.status,`trip`.driver_id,`driver`.company_id,`login`.id,`login`.name,`trip`.source_address,`account`.payment_amount,`account`.payment_mode,`driver`.name as driverName From `trip`"
                   . "LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id "
                   . "LEFT JOIN `login` ON `driver`.company_id=`login`.id "
                   . "LEFT JOIN `account` ON `trip`.id=`account`.trip_id "
                   . "WHERE 1 and `trip`.driver_id = $id AND (`trip`.status ='202' OR `trip`.status ='500') $driverName $date $travel $complete $paid $unpaid ORDER BY trip.id DESC";*/
			$str=" SELECT driver.name, driverPayment.* FROM driverPayment LEFT JOIN driver On driverPayment.driver_name = driver.id where driverPayment.driver_name = '$id' $date";	   
            $res=mysql_query($str); 
            if(mysql_affected_rows()>0){ 
                while($info=mysql_fetch_array($res))
                  {
                
            ?>
              <tr>
                <td class="tab-txt2"><?php echo $info['name'];?></td>
                <td class="tab-txt2"><?php if($info['payment']){echo $info['payment'];echo' MX';}else{echo '0.0 MX';}?></td>
                <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['paymentDateFrom'])); echo' - '; echo date('Y-m-d', strtotime($info['paymentDateTo']));?></td>
                <?php } } else{?>
              <tr>
                <td style="color: red; padding:10px" colspan='3'> Ningún record fue encontrado</td>
              </tr>
              <?php }?>
            </table>
          </div>
      
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html><script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.min.js"></script>
<!-- live search script -->
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
		          $(document).ready(function(){
				     $("#searchid").autocomplete({
                        source:'corporation_live_search.php',
						select: function (event, ui) {
						$('#party_id12').html(ui.item.id);
					   },
                        minLength:1
                    });
                });
</script>
<!-- live search script -->
<script>
// Validation for number or credit limit 
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementByClass("error").style.display = ret ? "none" : "inline";
            return ret;
        }    
function updateCorporateUser()
{
  var name= $('#name').val();
  var emailID= $('#emailID').val();
  var contact= $('#contact').val();
  var city= $('#city').val();
  var zipCode= $('#zipCode').val();
  var creditLimit= $('#creditLimit').val();
  var creditLimitPerDay= $('#creditLimitPerDay').val();
  var username= $('#username').val();
  //var password= $('#password').val();
  var newpassword= $('#newpassword').val();
  var blockUser= $('#blockUser').val();
  var mode= $('#mode').val();
  var userId = $('#userId').val();
  var Idd = $('#Idd').val();
  
//newpassword:newpassword,Idd:Idd,userId:userId,name:name,emailID:emailID,contact:contact,city:city,zipCode:zipCode,creditLimit:creditLimit,username:username,password:password,blockUser:blockUser,
   if(newpassword == '')
     {
      $('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Por favor ingrese una nueva contraseña</div>');
   }
  if ($('#blockUser').is(":checked"))
    {
      blockUser = '1';
    }
    else
    {
       blockUser = '0'; 
    }
  $.post('<?php echo MAIN_URL?>pageFragment/ajaxDataSaver.php',{mode:mode,newpassword:newpassword,Idd:Idd,userId:userId,name:name,emailID:emailID,contact:contact,city:city,zipCode:zipCode,creditLimit:creditLimit,creditLimitPerDay:creditLimitPerDay,username:username,blockUser:blockUser},function(response){
    console.log(response);
	if(response == 1)
    {
      $('#errorMessage').html('<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Actualizar usuario con éxito..!</div>');
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