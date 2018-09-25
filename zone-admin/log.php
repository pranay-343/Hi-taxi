<?php 
include '../include/define.php';
include '../include/head.php'; 
?>
    <body>
    <?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Zone Log</h2>
           <form method="post" action="">
          <div class="row bts">
          <div class="col-sm-4">
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
            <div class="col-sm-4">
            <div class="form-group">
              <label>Taxi Central </label>
                  <input type='text' class='input-style' data-language='en' placeholder="Taxi Central" name="taxtcompany" value="<?php echo $_POST['taxtcompany']?>" />
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
              <label> Driver </label>
                  <input type='text' class='input-style' data-language='en' placeholder="Driver" name="driver" value="<?php echo $_POST['driver']?>" />
            </div>
            </div>

            <div class="col-sm-4">
            <div class="form-group">
              <label> USER </label>
                  <input type='text' class='input-style' data-language='en' placeholder="USER" name="user" value="<?php echo $_POST['user']?>" />
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

         	 <?php 
			  	if (isset($_POST['submit'])) { 
				if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
					$date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."' + INTERVAL 1 DAY";
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

		        if($_POST['taxtcompany'] !='')
		        {
		          $nameTaxiCom = "and login.name LIKE '%".$_POST['taxtcompany']."%'";
		        }
		        else
		        {
		          $nameTaxiCom = '';
		        }



			}
		      if (isset($_POST['submit'])) { 
		        if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
		          $date1 = "AND driver.last_login_time between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."' + INTERVAL 1 DAY";
		        }
		        else{
		          $date1 ='';
		        }
		      }
		    ?>

          <h3> Taxi Company</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable">
              <tbody><tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type of User</th>
                <th width="25%" class="tab-txt1">LAST ACCESS DATE</th>
                <th width="25%" class="tab-txt1">CURRENT STATUS</th>
              </tr>

			  <?php 
			  $query_logs = "SELECT * FROM login where account_type = '4' and added_by='".$_SESSION['uid']."' $date $nameTaxiCom";
			  $result_logs = mysql_query($query_logs);
				$num_logs = mysql_num_rows($result_logs);
				if($num_logs>0){
					while($row_logs = mysql_fetch_array($result_logs)){
			  ?>
              <tr>
                <?php $driverId[] = $row_logs['id']; ?>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2">User</td>
                <td class="tab-txt2"><?php if($row_logs['last_login'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
						else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'Active';}else{echo 'Inactive';}?></td>
              </tr>
			  
			  <?php }} else{?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
			<?php }?>   
              
            </tbody></table>
            
          </div>

           <br/><br/>
          <h3> Taxi driver Company</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable1">
              <tbody><tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type Of user</th>
                <th width="25%" class="tab-txt1">Last Access Date</th>
                <th width="25%" class="tab-txt1">Current Status</th>
              </tr>
        <?php 
      //   if (isset($_POST['submit'])) { 
      //   if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
      //     $date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
      //   }
      //   else{
      //     $date ='';
      //   }
      // }
       // echo count($driverId);
        if(count($driverId)>0)
        {
       for($i=0;$i<count($driverId);$i++)
       {
        $query_logs = "SELECT * FROM driver where added_by='".$driverId[$i]."' $date1 $nameDriver";
        $result_logs = mysql_query($query_logs);
       // $num_logs = mysql_num_rows($result_logs);
      // if($num_logs>0){

          while($row_logs = mysql_fetch_array($result_logs)){
            //echo "select name from login where id='".$row_logs['added_by']."'";
            $companyName=mysql_fetch_array(mysql_query("select name from login where id='".$row_logs['added_by']."'"));
        ?>
              <tr>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2"><?php echo $companyName['name'];?></td>
                <td class="tab-txt2"><?php if($row_logs['last_login_time'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
            else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login_time']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'Active';}else{echo 'Inactive';}?></td>
              </tr>
        
        <?php } //}else{?>
             <!--  <tr>
               <td style="color: red; padding:10px" colspan="4">ningún record fue encontrado</td> 
              </tr> -->
      <?php }}//}
      else
        { ?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
        <?php } ?>   
              
            </tbody></table>
            
          </div>

<br/><br/>
          <h3> Corporate Company</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable2">
              <tbody><tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type Of User</th>
                <th width="25%" class="tab-txt1">Last Access Time</th>
                <th width="25%" class="tab-txt1">Current Status</th>
              </tr>
        <?php 
      //   if (isset($_POST['submit'])) { 
      //   if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
      //     $date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
      //   }
      //   else{
      //     $date ='';
      //   }
      // }
        if(count($driverId)>0)
        {
       for($i=0;$i<count($driverId);$i++)
       {
        $query_logs = "SELECT * FROM login where account_type = '5' and added_by='".$driverId[$i]."' $date $nameCorporate";
        $result_logs = mysql_query($query_logs);
       // $num_logs = mysql_num_rows($result_logs);
       // if($num_logs>0){

          while($row_logs = mysql_fetch_array($result_logs)){
            //echo "select name from login where id='".$row_logs['added_by']."'";
            $companyName=mysql_fetch_array(mysql_query("select name from login where id='".$row_logs['added_by']."'"));
        ?>
              <tr>
                <?php $corporateUser[] = $row_logs['id']; ?>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2">Empresa corporativa</td>
                <td class="tab-txt2"><?php if($row_logs['last_login'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
            else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'Active';}else{echo 'Inactive';}?></td>
              </tr>
        
        <?php }//}else{?>
              <tr>
               <!-- <td style="color: red; padding:10px" colspan="4">ningún record fue encontrado</td> -->
              </tr>
      <?php }}
      else
        { ?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
        <?php } ?>    
              
            </tbody></table>
            
          </div>

<br/><br/>
          <h3> corporate user</h3>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable3">
              <tbody><tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type Of User</th>
                <th width="25%" class="tab-txt1">Last Access Time</th>
                <th width="25%" class="tab-txt1">Current Status</th>
              </tr>
        <?php 
      //   if (isset($_POST['submit'])) { 
      //   if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
      //     $date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
      //   }
      //   else{
      //     $date ='';
      //   }
      // }
        if(count($corporateUser)>0)
        {
       for($i=0;$i<count($corporateUser);$i++)
       {
        $query_logs = "SELECT * FROM users where corporate_id='".$corporateUser[$i]."' $date  $nameUser";
        $result_logs = mysql_query($query_logs);
       // $num_logs = mysql_num_rows($result_logs);
       // if($num_logs>0){

          while($row_logs = mysql_fetch_array($result_logs)){
            //echo "select name from login where id='".$row_logs['added_by']."'";
            $companyName=mysql_fetch_array(mysql_query("select name from login where id='".$row_logs['corporate_id']."'"));
        ?>
              <tr>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2"><?php echo $companyName['name'];?></td>
                <td class="tab-txt2"><?php if($row_logs['last_login_time'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
            else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login_time']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'Active';}else{echo 'Inactive';}?></td>
              </tr>
        
        <?php }//}else{?>
              <tr>
               <!-- <td style="color: red; padding:10px" colspan="4">ningún record fue encontrado</td> -->
              </tr>
      <?php } }
      else
        { ?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">No Records Found</td>
              </tr>
        <?php } ?>
       
              
            </tbody></table>
            
          </div>



        </div>
        
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<!-- JQUERY SUPPORT -->
<!--<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>-->

<!-- datepicker -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
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
	})

	$(document).ready(function() {
		$('#datatable').DataTable();
		$('#datatable1').DataTable();
		$('#datatable2').DataTable();
		$('#datatable3').DataTable();
	} );
</script>