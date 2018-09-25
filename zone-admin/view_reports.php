<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';

 $tripId = base64_decode($_GET['a']);
 $driver_id = base64_decode($_GET['b']);
 $customer_id = base64_decode($_GET['c']);
 $driver_rate = base64_decode($_GET['d']);
 $customer_rate = base64_decode($_GET['e']);
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
<body>
<?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container pal0">
    <div class="row">
      <div class="col-sm-3 pa10">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Account Status: Taxi Driver Travel Detail</h2>
          <form method="post" name="search" action="" autocomplete="off">
            <div class="row bts">
              
              
            <div class="clearfix"></div>
        <!-- BY Dinesh -->
        <div class="c-acc-status bst mgmin">
            <h2 class="txt-style-3">information for the driver</h2>
         
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr> 
                <th class="tab-txt1">Driver Name</th>
                <th class="tab-txt1">CONTACT Number</th>
                <th class="tab-txt1">licence Expiry Date</th>
                <th class="tab-txt1">Insurance Expiry date</th>
                <th class="tab-txt1">connection time</th>
                <th class="tab-txt1">Current Status</th>
                <th class="tab-txt1">Customer Verification</th>
              </tr>
              <?php 
                $driverDetail = mysql_fetch_array(mysql_query("select * from `driver` where id ='".$driver_id."'"));
                if($driverDetail['status'] == '200')
                {
                   $CurrentStatus ='working';
                }
                elseif($driverDetail['status'] == '99')
                {
                   $CurrentStatus ='block';
                }
                elseif($driverDetail['status'] == '404')
                {
                   $CurrentStatus ='suspend';
                }
                if($customer_rate == '' || $customer_rate == null)
                {
                   $customer_rate ='No data available';
                }
                 if($driverDetail['contact_number'] == '' || $driverDetail['contact_number'] == null)
                {
                   $abc = 'No data available';
                }
               ?>
              <tr>
                <td class="tab-txt2"><?php echo $driverDetail['name']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['contact_number']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['insurance_expiration_date']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['licence_expiration_date']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['last_login_time']; ?></td>
                <td class="tab-txt2"><?php echo $CurrentStatus; ?></td>
                <td class="tab-txt2"><?php echo $customer_rate; ?></td>
              </tr>
            </table>
        </div>
        <!-- BY Dinesh -->
      <div class="c-acc-status bst mgmin">
            <h2 class="txt-style-3">Customer Information</h2>
         
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr> 
                <th class="tab-txt1">Driver Name</th>
                <th class="tab-txt1">Contact Number</th>
                <th class="tab-txt1">E-mail</th>
                <th class="tab-txt1">leader board pilot</th>
              </tr>
              <?php 
                $customerDetail = mysql_fetch_array(mysql_query("select * from `users` where id ='".$customer_id."'"));
                if($customerDetail['contact_no'] == '' || $customerDetail['contact_no'] == null)
                {
                   $customerDetail['contact_no'] = 'No data available';
                }
                if($customerDetail['name'] == '' || $customerDetail['name'] == null)
                {
                   $customerDetail['name'] ='No data available';
                }
                if($driver_rate == '' || $driver_rate == null)
                {
                   $driver_rate ='No data available';
                }
               ?>
              <tr>
                <td class="tab-txt2"><?php echo $customerDetail['name']; ?></td>
                <td class="tab-txt2"><?php echo $customerDetail['contact_no']; ?></td>
                <td class="tab-txt2"><?php echo $customerDetail['email_id']; ?></td>
                <td class="tab-txt2"><?php echo $driver_rate; ?></td>
              </tr>
            </table>
        </div>

        <!-- for user información -->
          
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
      $('#errorMessage').html('<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Por favor ingrese una nueva contraseña..!</div>');
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