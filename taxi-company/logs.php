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
        
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Zone For Logs</h2>
           <form method="post" action="">
          <div class="row bts">
          <div class="col-sm-4 col-sm-offset-2">
          	<div class="form-group">
            	<label> From </label>
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
            <div class="row bts">
          <div class="col-sm-4">
            <div class="form-group">
              <label> CORPORATE </label>
                  <input type='text' class='input-style' data-language='en' placeholder="CORPORATE" name="corporate" value="<?php echo $_POST['corporate']?>" />
            </div>
            </div>
            <div class="col-sm-4">
            <div class="form-group">
              <label> Taxi Driver </label>
                  <input type='text' class='input-style' data-language='en' placeholder="Taxi Driver" name="driver" value="<?php echo $_POST['driver']?>" />
            </div>
            </div>
            <div class="col-sm-4">
            <div class="form-group">
              <label> User </label>
                  <input type='text' class='input-style' data-language='en' placeholder="User" name="user" value="<?php echo $_POST['user']?>" />
            </div>
            </div>
            </div>
			<div class="row mga bts" align="center">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100 wap" id="chartId" type="submit" name="submit">Search</button>
              </div>
			</div>  
          </form>
          <br/><br/>
          <h3>Corporate Business</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1"  id="datatable">
              <tbody>
              <tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">User Type</th>
                <th width="25%" class="tab-txt1">LAST ACCESS Time</th>
                <th width="25%" class="tab-txt1">Status</th>
              </tr>
			  <?php 
			  if (isset($_POST['submit'])) { 
				if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
          $date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))." "."00:00:00". "' AND  '".date('Y-m-d',strtotime($_POST['to_date']))." "."23:59:59". "'";
          $dateDriver = "AND driver.last_login_time between '".date('Y-m-d',strtotime($_POST['from_date']))." "."00:00:00". "' AND  '".date('Y-m-d',strtotime($_POST['to_date']))." "."23:59:59". "'";
					$dateUser = "AND users.last_login_time between '".date('Y-m-d',strtotime($_POST['from_date']))." "."00:00:00". "' AND  '".date('Y-m-d',strtotime($_POST['to_date']))." "."23:59:59". "'";
				}
				else{
					$date ='';
				}
        if($_POST['corporate'] !='')
        {
          $nameCorporate = "and login.name LIKE '%".$_POST['corporate']."%'";
        }
        else
        {
          $nameCorporate = '';
        }
        if($_POST['driver'] !='')
        {
          $nameDriver = "and driver.name LIKE '%".$_POST['driver']."%'";
        }
        else
        {
          $nameDriver = '';
        }
        if($_POST['user'] !='')
        {
          $nameUser = "and users.name LIKE '%".$_POST['user']."%'";
        }
        else
        {
          $nameUser = '';
        }
			}
			  $query_logs = "SELECT * FROM login where account_type = '5' AND added_by = '".$_SESSION['uid']."' $date $nameCorporate ";
			  $result_logs = mysql_query($query_logs);
				$num_logs = mysql_num_rows($result_logs);
				if(($num_logs>0)){
					while($row_logs = mysql_fetch_array($result_logs)){
			  ?>
              <tr>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2">Compa&ntilde;&iacute;a Corporaci&oacute;n</td>
                <td class="tab-txt2"><?php if($row_logs['last_login'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
						else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'LogIn';}else{echo 'LogOff';}?></td>
              </tr>
			  
			  
			<?php } } else{ ?>
      <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
       <?php } ?>  
      </tbody>
          </table>
          </div>
          <br/><br/>
          <h3>Driver Information</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1"  id="datatable1">
              <tbody>
              <tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">User type</th>
                <th width="25%" class="tab-txt1">LAST ACCESS Time</th>
                <th width="25%" class="tab-txt1">Status</th>
              </tr>
			  <?php $sql_driver_status = "SELECT * FROM driver WHERE company_id = '".$_SESSION['uid']."' $dateDriver $nameDriver";
			   $result_logs_driver_status = mysql_query($sql_driver_status);
				$num_logs_driver_status = mysql_num_rows($result_logs_driver_status);
				if($num_logs_driver_status>0){
					while($row_logs_driver_status = mysql_fetch_array($result_logs_driver_status)){
			  ?>
			<tr>
                <td class="tab-txt2"><?php echo $row_logs_driver_status['name'];?></td>
                <td class="tab-txt2">Conductor</td>
                <td class="tab-txt2"><?php if($row_logs_driver_status['last_login_time'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
						else{echo date('Y-m-d - h:i A', strtotime($row_logs_driver_status['last_login_time']));}?></td>
                <td class="tab-txt2"><?php if($row_logs_driver_status['login_status']=='1'){echo 'LogIn';}else{echo 'LogOff';}?></td>
             </tr>
			 <?php } }else{?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
			<?php }?>
       </tbody>
          </table>
          </div>  
          <br/><br/>
          <h3> User Information</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable2">
              <tbody>
              <tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">User Type</th>
                <th width="25%" class="tab-txt1">LAST ACCESS Time</th>
                <th width="25%" class="tab-txt1">Status</th>
              </tr> 
              <?php 
			  
			 $user_login_status = "SELECT login.id, login.added_by, users.* FROM login LEFT JOIN users ON login.id = users.added_by WHERE login.added_by = '".$_SESSION['uid']."' AND login.account_type='5' AND users.account_type='99' $dateUser $nameUser	";
				$result_user_login_status = mysql_query($user_login_status);
				$num_rows_user_login = mysql_num_rows($result_user_login_status);
				if($num_rows_user_login>0){
					while($row_user_login = mysql_fetch_array($result_user_login_status)){
			?>
			  <tr>
                <td class="tab-txt2"><?php echo $row_user_login['name'];?></td>
                <td class="tab-txt2">Usuario Corporativo</td>
                <td class="tab-txt2"><?php if($row_user_login['last_login_time'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
						else{echo date('Y-m-d - h:i A', strtotime($row_user_login['last_login_time']));}?></td>
                <td class="tab-txt2"><?php if($row_user_login['login_status']=='1'){echo 'LogIn';}else{echo 'LogOff';}?></td>
             </tr>
			 <?php } }else{?>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('#datatable').DataTable();
    $('#datatable1').DataTable();
    $('#datatable2').DataTable();
  } );
</script>