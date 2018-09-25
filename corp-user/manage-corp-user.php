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
              <h2 class="txt-style-3">Corporate User</h2>
              <form method="post" name="search" action="">
                <div class="row bts">
                   <div class="col-sm-4">
                  <div class="form-group">
                      <label> Name </label>
                      <!--<input type='text' class='input-style' placeholder="Enter Text Here" name="name" value="<?php //echo $_POST['name'];?>"/>-->
					  <select name="name" id="name" required class="input-style">
						<option value="">Select User</option>
						<?php $query = mysql_query("SELECT name, id, added_by FROM users WHERE added_by ='".$_SESSION['uid']."'");
								$num_rows = mysql_num_rows($query);
								if($num_rows>0){
									while($data = mysql_fetch_array($query)){
								
						?>
						<?php if(isset($_POST['submit'])){ (isset($_POST["name"])) ? $name = $_POST["name"] : $name=($data['name']);}?>
									<option <?php if ($name == ($data['name'] )){ echo 'selected' ;} ?> value="<?php echo $data['name'];?>"><?php echo $data['name'];?></option>
						<?php } }?>
					 </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label>From </label>
                      <input type='text' class='datepicker-here input-style' required data-language='en' placeholder="Start Date"  name="start_date" value="<?php echo $_POST['start_date'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> To </label>
                      <input type='text' class='datepicker-here input-style' required data-language='en' placeholder="End Date"  name="end_date" value="<?php echo $_POST['end_date'];?>"/>
                    </div>
                  </div>
                  <div class="clr"></div>
                
               	<div class="col-sm-4 col-sm-offset-2">
                  <div class="form-group">
                      <button class="dash-button hvr-wobble-horizontal w100 wap wer ytu" type="submit" name="submit">Search</button>
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                    <a href="<?php echo CORPORATE_URL;?>add-user.php" class="dash-button hvr-wobble-horizontal w100 wap wer ytu">Add Corporate User</a>
                    </div>
                  </div>
               </div>
              </form>
            
            </div>
            <div class="c-acc-status mg5 bst pad0">
               <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <tbody>
                        <tr>
                            <th width="5%" class="tab-txt1">#</th>
                            <th width="10%" class="tab-txt1">Name</th>
                            <th width="15%" class="tab-txt1">Email</th>
                            <th width="10%" class="tab-txt1">User Name</th>
                            <th width="10%" class="tab-txt1">DATE OF LAST TRIP</th>                            
                            <th width="5%" class="tab-txt1">TOTAL BALANCE</th>
                            <th width="5%" class="tab-txt1">SPENT BALANCE</th>
                            <th width="5%" class="tab-txt1">BALANCE AVAILABLE</th>
                            <th width="5%" class="tab-txt1">Login</th>
                            <th width="5%" class="tab-txt1">Edit</th>
                        </tr>
                    
                    <?php
if(isset($_POST['submit'])){
	$name = "AND u.name LIKE '%" . $_POST['name'] . "%'";
	if($_POST['start_date'] != '' && $_POST['end_date'] != '')
	{
  //$date = "AND u.added_on between '".date('Y-m-d',strtotime($_POST['start_date']))."' AND  '".date('Y-m-d',strtotime($_POST['end_date']))."'";
	$date = "AND u.added_on >= '".$_POST['start_date']."' AND  u.added_on <='".$_POST['end_date']."'";
	}
}
else
{
	$name = '';
	$date = '';
}
 $query = "select  u.* from `users` u left join `login` l ON u.added_by=l.id   where 1 and u.added_by = '".$_SESSION['uid']."' $name  $date order by u.id ASC";
$result = mysql_query($query) or die();
$num_rows = mysql_num_rows($result);
$i = 0;
$location = array();
$logg = '';
if($num_rows>0){
while ($row = mysql_fetch_assoc($result)) {
$i++;
//echo $row['login_status'];
if ($row['login_status'] == 0) {
	$logg = 'NO';
} else {
	$logg = 'SI';
}
$linkss = '<a href="' . CORPORATE_URL . 'edit-user.php?a=' . base64_encode($row['id']) . '"><span class="fa fa-pencil fa_iconm1" style="position:relative;top:2px;"></span></a>';

$query_last_trip = mysql_query("SELECT id, tripdatetime FROM trip WHERE customer_id = '".$row[id]."'  GROUP BY customer_id ORDER BY id");
$rows_last_trip =  mysql_num_rows($query_last_trip);
$trip_date = mysql_fetch_assoc($query_last_trip);

$query_amt = "SELECT * FROM account WHERE customer_id = '".$row['id']."' AND trip_id!='' AND driver_id!=''";
$result_amt = mysql_query($query_amt);        
$rows_amt = mysql_num_rows($result_amt);
$noitems= 0;
while($info = mysql_fetch_array($result_amt))
{                    
	$numberitems = explode(',',$info['payment_amount']);
        for ($j = 0; $j < count($rows_amt); $j++){ 
		$noitems += $numberitems[$j];
		}
	}
	$remainAccount = $row['credit_limit'] - $noitems;
	echo '<tr>';
	echo "<td class='tab-txt2'> ". $i . "</td>";
	echo "<td class='tab-txt2'> ". $row['name'] . "</td>";
	echo "<td class='tab-txt2'> ". $row['email_id'] . "</td>";
	echo "<td class='tab-txt2'> ". $row['username'] . "</td>";
	if($trip_date){echo "<td class='tab-txt2'> ". date("d M Y", strtotime($row['added_on'])). "</td>";}
	else{
		echo "<td class='tab-txt2'> No Trips Available</td>";
	}
	echo "<td class='tab-txt2'> ".CURRENCY. $row['credit_limit'] . "</td>";
	echo "<td class='tab-txt2'> ".CURRENCY. $noitems . "</td>";
	echo "<td class='tab-txt2'>".CURRENCY.$remainAccount."</td>";
	echo "<td class='tab-txt2'> ". $logg . "</td>";
	echo "<td class='tab-txt2'> ". $linkss . "</td>";
    echo '</tr>';
}}
else{
?>
<tr>
    <td style="color: red; padding:10px;" colspan="10">No Records Found</td>
</tr>      
<?php }?>                        
</tbody>
           </table><br/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
<script>
    /*
$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewUsers').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getviewUsers'); ?>" 
      },
      'columnDefs': [{
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '';
         }
      }],
      'order': [[1, 'asc']]
   });
});
*/
function deleteTaxiCompany(a,b)
{
    alert('Estamos trabajando…');
    swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles de la central y todos los conductores, viajes y otros detalles también serán eliminados",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        swal("Eliminado", "La central de taxi fue eliminada", "Éxito");
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