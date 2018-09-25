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
<h1 class="txt-style-1 bn"> Account User: <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>

	<div class="c-acc-status mg5 mgt0">
        
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Zone For Panic</h2>
           <form method="post" action="">
          <div class="row bts">
          <div class="col-sm-4 col-sm-offset-2">
          	<div class="form-group">
            	<label> From</label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date" name="from_date" value="<?php echo $_POST['from_date']?>" />
            </div>
            </div>
            <div class="col-sm-4">
          	<div class="form-group">
            	<label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date" name="to_date" value="<?php echo $_POST['to_date']?>" />
            </div>
            </div>
            </div>
             
			<div class="row mga bts" align="center">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100 wap" id="chartId" type="submit" name="submit">Search</button>
              </div>
			</div>  
          </form>
         
			  <?php 
			  if (isset($_POST['submit'])) { 
				if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
          $date = "AND `trip`.tripdatetime between '".date('Y-m-d',strtotime($_POST['from_date']))." "."00:00:00". "' AND  '".date('Y-m-d',strtotime($_POST['to_date']))." "."23:59:59". "'";
				}
				else{
					$date ='';
				}
			}
			  ?>
          <h3>User Information</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tbody>
              <tr>
                <th width="25%" class="tab-txt1">User Name</th>
                <th width="25%" class="tab-txt1">Driver Name</th>
                <th width="25%" class="tab-txt1">Panic</th>
                <th width="25%" class="tab-txt1">Trip Date</th>
                <th width="25%" class="tab-txt1">Status</th>
                <th width="25%" class="tab-txt1">Mor Information</th>
              </tr> 
              <?php 
			  
			 //$user_login_status = "SELECT login.id, login.added_by, users.* FROM login LEFT JOIN users ON login.id = users.added_by WHERE login.added_by = '".$_SESSION['uid']."' AND login.account_type='5' AND users.account_type='99' $dateUser $nameUser	";
              $getDriver = mysql_query("select * from driver where company_id='".$_SESSION['uid']."'");
              // $numRows = mysql_num_rows($getDriver);
              // if($numRows >0)
              // {
              while($rowDriver = mysql_fetch_array($getDriver))
              {
                $driverTotal[] = $rowDriver['id'];
              }
              $saveDriver = implode("','", $driverTotal);
             // print_r($driverTotal);
        //echo $user_panic = "select * from trip where driver_id IN ('$saveDriver') and panictaxirequest !='' ";
       $user_panic = "SELECT `trip`.tripdatetime,`driver`.id,`driver`.login_status,`driver`.name as driverName,`trip`.endTrip_sourceaddress,`trip`.endTrip_destinationaddress,`trip`.id as tripId,`trip`.customer_id,`trip`.panictaxirequest,`users`.name as userName,`users`.id,`trip`.driver_id FROM `trip` LEFT JOIN `users` ON `trip`.customer_id = `users`.id LEFT JOIN `driver` ON `trip`.driver_id = `driver`.id WHERE `trip`.driver_id IN ('$saveDriver') and `trip`.panictaxirequest !='' $date";
				$result_user_login_status = mysql_query($user_panic);
				$num_rows_user_login = mysql_num_rows($result_user_login_status);
				if($num_rows_user_login>0){
					while($row_user_login = mysql_fetch_array($result_user_login_status)){
			?>
			  <tr>
                <td class="tab-txt2"><?php echo $row_user_login['userName'];?></td>
                <td class="tab-txt2"><?php echo $row_user_login['driverName'];?></td>
                <td class="tab-txt2"><?php echo $row_user_login['panictaxirequest'];?></td>
                <td class="tab-txt2"><?php echo $row_user_login['tripdatetime'];?></td>
                <td class="tab-txt2"><?php if($row_user_login['login_status']=='1'){echo 'LogIn';}else{echo 'LogOff';}?></td>
                <td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($row_user_login["tripId"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
             </tr>
			 <?php //} 
       }}else{?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
			 <?php }?>
            </tbody>
          </table>
            
          </div>
        </div>
        
      </div>

</div>
</div>
</div>
</div>

<?php include '../include/footer.php'; ?>
</body>
</html>