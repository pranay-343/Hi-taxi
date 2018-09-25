<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
    <body>
    <?php include '../include/navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/super-sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
        <h1 class="txt-style-1">Super Administrator Hi Taxi</h1>
        <div class="c-acc-status mg0 mgyu">
          <h2 class="txt-style-3">Administrator Logs</h2>
          <form method="post" action="">
          <div class="row bts">
          <div class="col-sm-4 col-sm-offset-2">
          	<div class="form-group">
            	<label> Start Date</label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Data" name="from_date" value="<?php echo $_POST['from_date']?>" />
            </div>
            </div>
            <div class="col-sm-4">
          	<div class="form-group">
            	<label> End date </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date" name="to_date" value="<?php echo $_POST['to_date']?>" />
            </div>
            </div>
            </div>
			<div class="row bts mag" style="">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100" id="chartId" type="submit" name="submit">Search</button>
              </div>
			</div>  
          </form>
          <br/> <br/>
		  <h3>  Users Log</h3>
          <div class="bst">
            <table id="datatable" class="ctabel1" cellspacing="0" width="100%">
              <thead><tr>
                <th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type Of User</th>
                <th width="25%" class="tab-txt1">Last Access</th>
                <th width="25%" class="tab-txt1">Current Status</th>
              </tr></thead>
			  <tfoot>
            <tr>
            	<th width="25%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Type Of User</th>
                <th width="25%" class="tab-txt1">Last Access</th>
                <th width="25%" class="tab-txt1">Current Status</th>
               <!--  <th width="25%" class="tab-txt1">nombre</th>
                <th width="25%" class="tab-txt1">TIPO DE álbum</th>
                <th width="25%" class="tab-txt1">Fecha de última</th>
                <th width="25%" class="tab-txt1">Estado actual</th> -->
            </tr>
        </tfoot>
			 <tbody>
			<?php 
			if (isset($_POST['submit'])) { 
				if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
					$date = "AND login.last_login between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
				}
				else{
					$date ='';
				}
			}			
				$query_logs = "SELECT * FROM login WHERE 1 $date";
				$result_logs = mysql_query($query_logs);
				$num_logs = mysql_num_rows($result_logs);
				if($num_logs>0){
					while($row_logs = mysql_fetch_array($result_logs)){
			?>
              <tr>
                <td class="tab-txt2"><?php echo $row_logs['name'];?></td>
                <td class="tab-txt2"><?php if($row_logs['account_type']=='1'){echo 'Sunper Admin';}
									elseif($row_logs['account_type']=='2'){echo 'Zone Admin';}
									elseif($row_logs['account_type']=='4'){echo 'Account User';}
									elseif($row_logs['account_type']=='5'){echo 'Corporation Company';}
									?>
				</td>
                <td class="tab-txt2"><?php if($row_logs['last_login'] == '0000-00-00 00:00:00'){echo 'No Login Time Available';}
						else{echo date('Y-m-d - h:i A', strtotime($row_logs['last_login']));}?></td>
                <td class="tab-txt2"><?php if($row_logs['login_status']=='1'){echo 'LogIn';}else{echo 'LogOff';}?></td>
              </tr>
			<?php }} else{?>
              <tr>
               <td style="color: red; padding:10px" colspan="4">N0o records found</td>
              </tr>
			<?php }?> 

			   </tbody>
            </table>
          </div>
		  
		  <br/><br/><br/>
		  <h3> Work Areas</h3>
			<div class="bst">
            <table id="datatable_zone" class="ctabel1" cellspacing="0" width="100%">
            <thead>
				  <tr>
					<th width="30%" class="tab-txt1">Work Zone</th>
					<th width="30%" class="tab-txt1">Zone Admin</th>
					<th width="30%" class="tab-txt1">Last Modified Date</th>
				  </tr>
			</thead>
			<tfoot>
				<tr>
					<th width="30%" class="tab-txt1">Work Zone</th>
					<th width="30%" class="tab-txt1">Zone Admin</th>
					<th width="30%" class="tab-txt1">Last Modified Date</th>
				</tr>
			</tfoot>
				 <tbody>
					<?php 
                                        if (isset($_POST['submit'])) { 
                                                if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                                                        $date = "AND zone_area.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
                                                }
                                                else{
                                                        $date ='';
                                                }
                                        }
                                        
                                        
                                        $sql_zone = "SELECT zone_area.zone_title,zone_area.id,zone_area.added_on,login.name as zoneAName FROM zone_area LEFT JOIN login ON zone_area.allot_to = login.id WHERE 1  $date";
					$result_zone = mysql_query($sql_zone);
					$num_rows_zone = mysql_num_rows($result_zone);
					if($num_rows_zone>0){
						while($data_zone =  mysql_fetch_array($result_zone)){
					?>
						<tr>
							<td class="tab-txt2"><?php echo base64_decode($data_zone['zone_title']);?></td>
							<td class="tab-txt2"><?php echo $data_zone['zoneAName'];?></td>
							<td class="tab-txt2"><?php echo $data_zone['added_on'];?></td>
					<?php } } else{?>
					<tr>
					   <td style="color: red; padding:10px" colspan="4"> No hay resultados</td>
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
<?php include '../include/footer.php'; ?>
</body>
</html>


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
		$('#datatable_zone').DataTable();
	} );
</script>