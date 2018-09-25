<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 

$driver_id = base64_decode($_GET['a']);


$get_driver_detail = mysql_fetch_array(mysql_query("SELECT id,  name FROM driver WHERE id = '$driver_id'"));
$sql = "SELECT trip.*,users.id, users.name FROM trip LEFT JOIN users ON trip.customer_id = users.id where driver_id = '$driver_id'and `trip`.account_type='99' AND `trip`.trip_mode = 'complete'";
$result = mysql_query($sql);
$num_row = mysql_num_rows($result);
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
          <h2 class="txt-style-3">Taxi Driver : <?php echo $get_driver_detail['name'];?></h2>
          
          <div class="bst" style="margin-top:40px;">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" style="background:#fff;">
            <tr> 
                <?php //echo $driver_id.'-----';?>
              <th class="tab-txt1">Driver Name</th>
              <th class="tab-txt1">Corporate User</th>
              <th class="tab-txt1">Ratings</th>
              <th class="tab-txt1">Trips</th>
              <th class="tab-txt1">More Information</th>
            </tr>
            <?php if($num_row > 0){
             while ($row = mysql_fetch_array($result)) {
            ?>            
            <tr>
              <td class="tab-txt2"><?php echo $get_driver_detail['name'];?></td>
              <td class="tab-txt2"><?php echo $row['name'];?></td>
              <td class="tab-txt2"><?php echo $row['customer_rating'];?></td>
              <td class="tab-txt2"><?php echo $row['endTrip_sourceaddress'].' <strong>--</strong> '.$row['endTrip_destinationaddress']; ?></td>
              <td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($row["id"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td> 
                    
            </tr>
            <?php } }else{?>
            <tr>
              <td style="color: red; padding:10px" colspan="4"> No records found</td>
            </tr>
            <?php }?>
            
          </table>
        
          </div>
          <!-- dinesh -->
          
        </div>
      </div>
    </div>
  </div>
</div>
    
   
  

<?php include '../include/footer.php'; ?>
<script type="text/javascript">
function deleteDriver(a)
{
	
   swal({
        title: "¿Estas seguro?",
        text: "No podras recuperar los detalles del conductor, y todos los viajes y otros detalles también serán eliminados",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
      },
      function(){
        $.post('getData.php',{mode:'<?php echo base64_encode("deleteDriver");?>',a:a},function(response){
          $('#errorMessage').html(response);
          location.reload();
        }); 
        swal("Eliminado", "El conductor fue eliminado", "Éxito");
      });
    return false;
}   

function deleteDriver1(a)
    {
     alert('fdsfs');               
      swal({
        //title: "¿Estas seguro?",
         title: "Nj",
        text: "No podras recuperar los detalles de la zona una vez eliminada",
        type: "Advertencia",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si, eliminar',
        closeOnConfirm: false
        },
      function(){ 
          $.post('getData.php',{mode:'<?php echo base64_encode("deleteDriver");?>',a:a},function(response){    
          $('#errorMessage').html(response);
          location.reload();
         });
        });
      return false;
    }
    
    $(document).ready(function(){
	 $('#deleteDriverYes').click(function(i) {		
            $.post('getData.php',{mode:'<?php echo base64_encode('deleteDriver');?>'},function(response){
                $('#errorMessage').html(response);
                alert(response);
                 location.reload();
            }); 
        }); 
    }); 
    
    function deleteDriverYes(a){
     $.post('getData.php',{mode:'<?php echo base64_encode('deleteDriver');?>',a:a},function(response){
                $('#errorMessage').html(response);                
                 location.reload();
            }); 
        }
</script>
</body>
</html><!-- JQUERY SUPPORT -->