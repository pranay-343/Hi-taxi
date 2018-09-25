<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 

$start = $_POST['selDay'];
$dateArray = '';
for($i = 0;$i <= 6;$i++)
{
	//echo date("Y-m-d", strtotime("$start + " . ($i*5) . " day")) . "<br>";
	$nj = "'".date('m/d/Y', strtotime($start.' +'.$i.' days'))."',";
	$dateArray .= $nj;
	//'02/02/2016','02/01/2016','01/02/2016','01/01/2016'
}
$getalldates = rtrim($dateArray,',');
$dates = explode(',',$getalldates);
$start_date = $dates[0];
$end_date = $dates[6];
//print_r($start_date);
//print_r($end_date);
?>
<style>
   td.dp-highlight {
    pointer-events: none !important;
}
    td.dp-highlight .ui-state-default {
      background: #484;
      color: #FFF;
          pointer-events: none !important;
    }
    select.ui-datepicker-month {
    color: #000;
}
</style>
<link rel="stylesheet" type="text/css" href="filess/mdp.css">
<body class="popup_designm1">
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row btss">
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
              <h2 class="txt-style-3">Add Payment</h2>
                <div id="errorMessage"></div>
              <form action="" method="POST" onSubmit="return addPayemnt();">
<?php
if(isset($_POST['submit1']) and $_POST['submit1']!=""){   
 addPayemnt(); 
HTMLRedirectURL(TAXI_URL."payement_print.php?id=".base64_encode($_POST['driverName']));
}            
?>
                <div class="row">                  
                 <?php
                    if(isset($_POST['submit']))
                    {
                     $driverName=$_REQUEST['txtDname'];
                     $fromDate=$_REQUEST['fromDate'];
                     $toDate=$_REQUEST['toDate'];
                     $week=$_REQUEST['week'];
                     $week=$_REQUEST['selDay'];
                     // $driverPayment=$_REQUEST['driverPayment'];


                     $date1 = "and account.add_on >='".$fromDate."' AND account.add_on <='".$toDate."'";
                     $str61="SELECT `driver`.name,`driver`.id,`account`.id,`driver_id`,SUM(`account`.payment_amount) as totalamount FROM `driver`
                      LEFT JOIN `account` ON `driver`.id=`account`.driver_id where `driver`.name='$driverName' $date1";
                      $res61=mysql_query($str61);
                      //print_r($res61);
                      $row61=mysql_fetch_assoc($res61);
                      


                    $str55="select * from driver where id='$driverName'";
                    $res55=mysql_query($str55);
                    $row55=mysql_fetch_array($res55);
                    ?>
                    <div class="c-acc-status bst" style="margin-top:0;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                            <th width="5%" class="tab-txt1">Driver Name</th>
                            <th width="20%" class="tab-txt1">Driver Contact Number</th>
                            <th width="20%" class="tab-txt1">Car Plate Number</th>                            
                        </tr>
                  <tr>
                    <td width="5%" class="tab-txt1"><?php echo $row55['name']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row55['contact_number']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row55['vehicle_number']; ?></td>                    
                  </tr>
                    </thead>
                  </table>
                </div>
                <?php } ?>
                <input type="hidden" name="week" value="<?php echo $week;?>">
                <input type="hidden" name="driverName" value="<?php echo $driverName;?>">
                 <div class="row">  
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label>SELECT THE DAY OF THE Payment</label>
                   <div id="demos">
                                    <ul>
					<li class="demo" onClick="myFunction()">
						<div id="pre-select-dates" class="box"></div>
						<div class="code-box">
                       
						<pre class="code" style="display:none">
						var date = new Date();
						console.log(date);
						var njj = "[<?php echo rtrim($dateArray,',');?>]";
						console.log(njj);
						$('#pre-select-dates').multiDatesPicker({
                                                        disabled: true,
							addDates: [<?php echo $getalldates;?>],
							numberOfMonths: 2
						});</pre>
						</div>
						</li>
						</ul>
					</div>
                      <p id="demo11"></p>
                      <input type="text" name="fromDate" class="input-style" id="input1" size="10" value="<?php echo $start_date;?>" style="display:none">
                      <input type="text" name="toDate" class="input-style" id="input2" size="10" value="<?php echo $end_date;?>" style="display:none">
                    </div>
                  </div>                                    
                 
                 
                <div class="col-sm-4">
                    <div class="form-group">
                      <label> Payment </label>
                      <input type="text" name="driverPayment" id="driverPayment" class="input-style" value="<?php echo $row61['totalamount'];?>" required/>
                    </div>
                  </div> 
                  
                </div> 
				<input type="hidden" name="selDate" id="selDate" value="<?php echo $_POST['selDay'];?>"/>
                <div class="row">
                  <div class="col-lg-12" style="text-align:center;">
                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addPayemnt')?>" />
                    <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
                     <input type="button" class="dash-button hvr-wobble-horizontal"  data-toggle="modal" data-target="#myModal" value="Confirm" />
                        
                        
                     
                      <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Payment Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to payment this driver</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <!--<button type="submit" class="btn btn-primary" data-dismiss="modal" name="submit1" id="submit1">SI</button>-->
                                    <input type="submit" class="btn btn-primary" name="submit1" id="submit1" value="Yes" />
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                </div>  
              </form>         
           <?php
           // if (isset($_POST['submit1'])) 
           // { 
           //   $week=$_REQUEST['week'];
           //   $name=$_REQUEST['driverName'];
           //   $driverPayment=$_REQUEST['driverPayment'];
           //   // if(!empty($_REQUEST['fromDate']) && !empty($_REQUEST['toDate']))
           //   // {
           //  // $driverType1=$_REQUEST['driverType'];
           //   $fromDate1=$_REQUEST['fromDate'];
           //   $toDate1=$_REQUEST['toDate'];
                               
           //   $str="insert into driverPayment (`name`,`payment`,`week`,`paymentDateFrom`,`paymentDateTo`) values ('$name','$driverPayment','$week','$fromDate1','$toDate1')";
           //   $res=mysql_query($str) or die(mysql_error());
           //   if($res)
           //   {
           //    echo "<script>alert('Data Inserted successfully');
           //          window.location.href='add-payment.php'</script>";
           //   }
           //   else
           //   {
           //    echo "Error";
           //   }            
           // }
           ?>          
          </div>          
        </div>
      </div>
    </div>
    <?php 
include '../include/footer.php'; 
?>
<!-- JQUERY SUPPORT -->

<script src="<?php echo MAIN_URL;?>js/jquery.js"></script>
<script src="<?php echo MAIN_URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo MAIN_URL;?>js/modernizr-custom.js"></script>
<!-- datepicker -->

<!-- sidebar menu -->

<script type="text/javascript" src="filess/jquery-1.11.1.js"></script>
<script type="text/javascript" src="filess/jquery-ui-1.11.1.js"></script>
<script type="text/javascript" src="filess/jquery-ui.multidatespicker.js"></script>
<script type="text/javascript">
		<!--
			var latestMDPver = $.ui.multiDatesPicker.version;
			var lastMDPupdate = '2014-09-19';
			
			$(function() {
				// Version //
				//$('title').append(' v' + latestMDPver);
				$('.mdp-version').text('v' + latestMDPver);
				$('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);
				
				// Documentation //
				$('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
				$('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
				$('#how-to h4').each(function () {
					var a = $(this).closest('li').attr('id');
					$(this).wrap('<'+'a href="#'+a+'"></'+'a>');
				});
				$('#demos .demo').each(function () {
					var id = $(this).find('.box').attr('id') + '-demo';
					$(this).attr('id', id)
						.find('h3').wrapInner('<'+'a href="#'+id+'"></'+'a>');
				});
				
				// Run Demos
				$('.demo .code').each(function() {
					eval($(this).attr('title','NEW: edit this code and test it!').text());
					this.contentEditable = false;
                                        
				}).focus(function() {
                                    if(!$(this).next().hasClass('test'))
                                        $(this)
                                        .after('<button class="test">test</button>')
                                        .next('.test').click(function() {
                                                $(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy')
                                                eval($(this).prev().text());
                                                $(this).remove();
                                    });
				});
			});
		
		</script>


</body>
</html>