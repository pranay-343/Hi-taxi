<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
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
          <h2 class="txt-style-3">Account Status</h2>
          <?php
          // Sum of all travel
            $sql_travel = "SELECT trip.id,trip.trip_ammount,trip.customer_id as tCusId,users.id as cId FROM trip LEFT JOIN users ON trip.customer_id =  users.id WHERE users.added_by = '".$_SESSION['uid']."'  AND trip.trip_type ='corporate' AND trip.status='500'";
            $res_travel = mysql_query($sql_travel);
            $rows_data = mysql_num_rows($res_travel);
            $travel_amount = 0;
            while($row=mysql_fetch_array($res_travel)){
                $travel_amount += $row['trip_ammount'];
            }  
            
            // Sum of all payment
            $sql_travel = "SELECT * FROM manage_master_amount WHERE corporate_id = '".$_SESSION['uid']."' AND crop_mb_u_id!='0'";
            $res_travel = mysql_query($sql_travel);
            $rows_data = mysql_num_rows($res_travel);
            $payment_amount = 0;
            while($row=mysql_fetch_array($res_travel)){
                $payment_amount += $row['amount'];
            } 
            //echo '@@'.$payment_amount;
          
          
           function corporateCancelAmount()
           {

                // $query = " SELECT login.id, login.email, users.corporate_id, users.id, users.email_id, account.trip_id, account.customer_id, account.payment_amount, corporate.begning_credit, corporate.web_user_id"
                //     . " FROM login LEFT JOIN users ON login.id = users.corporate_id "
                //     . " LEFT JOIN account ON users.id = account.customer_id LEFT JOIN corporate ON login.id = corporate.web_user_id"
                //     . " WHERE login.id =9 and login.id ='".$_SESSION['uid']."'  GROUP BY account.trip_id  LIMIT 0 , 30";
                $query="SELECT `users`.added_by,`users`.id,`trip`.customer_id,`trip`.trip_ammount FROM `users`
                       LEFT JOIN `trip` ON `users`.id = `trip`.customer_id where `users`.added_by='".$_SESSION['uid']."' and `trip`.status='600'";
                $result=mysql_query($query);
                while($rows=mysql_fetch_array($result))
                {
                    $noitems += $rows['trip_ammount'];
                }
                echo $noitems;                

            }
          ?>
          <form method="post" name="search" action="">
            <div class="row bts">
              <div class="col-sm-4">
                
                <div class="form-group">
                  <label> WAY TO PAY </label>
                  <ul>
                    <li>
                      <input type="checkbox" name="trip_mode" value="travel" <?php if (!empty($_POST['trip_mode'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Travel</span>
					</li>					
                    <li>
                      <input type="checkbox" name="trip_mode1" value="travel" <?php if (!empty($_POST['trip_mode1'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Payment</span>
					</li>
					
                    <li><span>Status</span></li>
                    <li>
                      <input type="checkbox" name="trip_payment_status_paid" value="paid" <?php if (!empty($_POST['trip_payment_status_paid'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Paid</span></li>
                    <li>
                      <input type="checkbox" name="trip_payment_status_nonpaid" value="nonpaid" <?php if (!empty($_POST['trip_payment_status_nonpaid'])): ?> checked="checked"<?php endif; ?> />
                      <span>Non paid</span></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date"  name="start_date" value="<?php echo $_POST['start_date']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en'  placeholder="End Date"  name="end_date" value="<?php echo $_POST['end_date']?>"/>
                </div>
              </div>
            
              <div class="col-lg-12">
                  <button class="dash-button hvr-wobble-horizontal wap" type="submit" name="submit">Search</button>
              </div>
            </div>
          </form>
        </div>
        <h3> Travel Information</h3>
        <div class="c-acc-status mg5 bst pad0">
          <table  id="datatable" width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
            <tr>
              <!-- <?php//  echo $_SESSION['uid'];?> -->
              <th width="20%" class="tab-txt1">Name</th>
              <th width="20%" class="tab-txt1">DATE</th>
              <th width="20%" class="tab-txt1">CASH / PER APPLICATION	</th>
              <!-- <th width="20%" class="tab-txt1">Cantidad adjudicadas</th> -->
              <th width="20%" class="tab-txt1">QUANTITY</th>
              <th width="20%" class="tab-txt1">MORE INFORMATION</th>
            </tr>
            <?php 
            if(isset($_POST['submit'])){

              if($_POST['trip_payment_status_paid'] != '' && $_POST['trip_payment_status_nonpaid'] != '')
                {
                  $trip_payment_status_paidNOn = " AND (a.payment_mode LIKE '%" . $_POST['trip_payment_status_paid'] . "%' or a.payment_mode LIKE '%" . $_POST['trip_payment_status_nonpaid'] . "%')";
                }
                
                elseif(isset($_POST['trip_payment_status_paid']) && $_POST['trip_payment_status_paid'] != ''){ 
                    $trip_payment_status_paid = " AND a.payment_mode LIKE '%" . $_POST['trip_payment_status_paid'] . "%'";
                    
                }elseif(isset($_POST['trip_payment_status_nonpaid']) && $_POST['trip_payment_status_nonpaid'] != ''){
                    $trip_payment_status_nonpaid = " and a.payment_mode LIKE '%" . $_POST['trip_payment_status_nonpaid'] . "%'";                    
                }

                if(isset($_POST['trip_payment_status_paid']) !='' && $_POST['trip_mode'] != ''){
                    $trip_mode = " or t.trip_mode LIKE '%" . $_POST['trip_mode'] . "%'";
                }
                if ($_POST['start_date'] != '' && $_POST['end_date'] != '') 
                {
                    $date = "AND `trip`.tripdatetime between '" . date('Y-m-d', strtotime($_POST['start_date'])) . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date'])) . "' + INTERVAL 1 DAY";
				        }
			           }
                else {
                    $trip_mode = '';
                    $trip_payment_status_paid='';
                    $trip_payment_status_nonpaid='';
                    $date = '';
                    $trip_payment_status_paidNOn='';
                }
        // $query = "SELECT t.customer_id,t.id as tripId,name,email_id,t.driver_id,t.trip_mode,t.trip_ammount,a.payment_mode,a.payment_amount,a.add_on FROM `trip` t 
        //           Left Join `users` u On t.customer_id=u.id
        //           Left Join `account` a On a.trip_id=t.id
        //           WHERE 1 ";
        // $query .= "and u.`corporate_id`= '".$_SESSION['uid']."' and a.payment_amount != '' and a.user_type_id = '99' $date $trip_mode $trip_payment_status_paid $trip_payment_status_nonpaid $trip_payment_status_paidNOn order by a.add_on desc";
        $query = "SELECT `users`.id,`users`.name,`trip`.customer_id,`trip`.trip_ammount,`trip`.tripdatetime,`trip`.id as tripId, trip.payment_mode from `users` LEFT JOIN `trip` on `users`.id = `trip`.customer_id where `users`.corporate_id = '".$_SESSION['uid']."' AND trip.trip_type ='corporate' and trip.endTrip_destinationaddress!='' $date $trip_mode $trip_payment_status_paid $trip_payment_status_nonpaid $trip_payment_status_paidNOn ";
		    $result = mysql_query($query);
                $rows = mysql_num_rows($result);               
                if($rows>0){
                 while($info = mysql_fetch_array($result)){
				        if($info['trip_mode']=='cancle'){
					       $info['trip_ammount'];
				      }
            ?>
            <tr>
                <?php //print_r($info['tripId']);?>
              <td class="tab-txt2"><?php echo $info['name'];?></td>
              <td class="tab-txt2"><?php if($info['tripdatetime'] != "") { echo $info['tripdatetime'];} else { echo "No trip available";} ?></td>
              <td class="tab-txt2"><?php if($info['payment_mode'] == 'credit'){echo 'Por App';}else{echo 'Efectivo';}?></td>
              <!-- <td class="tab-txt2"><?php //echo $info['payment_amount'];?> MX</td> -->
              <td class="tab-txt2"><?php if($info['trip_ammount'] == "") { echo "0" ;} else { echo CURRENCY.$info['trip_ammount']; }?> </td>
              <td class="tab-txt2"><a href="<?php echo CORPORATE_URL;?>driver-detail.php?a=<?php echo base64_encode($info['tripId']);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
            </tr>
            <?php } }else{ ?>
            <tr>
                <td style="color: red; padding:10px" colspan="6">No Records Found</td>
                </tr>
            <?php }?>
          
          </table>
          <div class="row spacetop">
              <h4 class="col-sm-6">Sum of all trips : <?php echo CURRENCY.$travel_amount;?>  </h4>
              <h4 class="col-sm-6">Sum of all payments :  <?php echo CURRENCY.$payment_amount;?></h4>
            <!--<div class="col-sm-4 col-sm-offset-2">
                <p class="dash-button hvr-wobble-horizontal w100">Amount Adjudicated : </p>
            </div>
            <div class="col-sm-4">
                <p class="dash-button hvr-wobble-horizontal w100">Amount Cancelled : 0</p>
            </div>-->
          </div><br/>
        </div>
        <h3>Payment Information</h3>
         <div class="c-acc-status mg5 bst pad0">
              <table  id="datatable_zone" width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                <tr>
                  <!-- <?php // echo $_SESSION['uid'];?> -->
                  <th width="20%" class="tab-txt1">Name</th>
                  <th width="20%" class="tab-txt1">DATE</th>
                  <th width="20%" class="tab-txt1">TYPE</th>
                  <th width="20%" class="tab-txt1">AMOUNT ALLOTTED</th>
                  <!--<th width="20%" class="tab-txt1">Importe Anulado</th>
                  <th width="20%" class="tab-txt1">más información</th>-->
                </tr>
                <?php
                $companyData = "SELECT `login`.id,`login`.name,`login`.added_by,`manage_master_amount`.added_on,`manage_master_amount`.company_id,`manage_master_amount`.corporate_id,`manage_master_amount`.amount_type,`manage_master_amount`.amount FROM `login` LEFT JOIN `manage_master_amount` ON `login`.id = `manage_master_amount`.corporate_id where `manage_master_amount`.corporate_id = '".$_SESSION['uid']."' AND `manage_master_amount`.crop_mb_u_id !='0' AND `manage_master_amount`.amount !='0' ORDER BY manage_master_amount.id DESC";
                $resultCompany = mysql_query($companyData);
                if(mysql_num_rows($resultCompany) > 0){
                while($rowCompany = mysql_fetch_array($resultCompany))
                {
                 //$manage_master_amount = "select * from `manage_master_amount` where company_id = '".$_SESSION['uid']."'" ;
                ?>
            <tr>
              <td class="tab-txt2"><?php echo $rowCompany['name'];?></td>
              <!-- <td class="tab-txt2"><?php // echo date("Y-m-d", strtotime($rowCompany['add_on'])); ?></td> -->
              <td class="tab-txt2"><?php echo $rowCompany['added_on']; ?></td> 
              <td class="tab-txt2"><?php echo "Payment"; //echo $rowCompany['amount_type'];?></td>
              <td class="tab-txt2"><?php echo CURRENCY.$rowCompany['amount'];?> </td>
              <!--<td class="tab-txt2"><?php if($rowCompany['trip_mode']=='cancle'){echo $info['trip_ammount'];}?>0.00 MX</td>
              <td class="tab-txt2"><a href="#">( + )</a></td>-->
            </tr>
                <?php  } } else{ ?>
            <tr>
              <td style="color: red; padding:10px" colspan="6">No Records Found</td>
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
</html>

<script>
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
	});

  $(document).ready(function() {
    $('#datatable').DataTable();
    $('#datatable_zone').DataTable();
  } );
</script>