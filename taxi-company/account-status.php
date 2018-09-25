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
<h1 class="txt-style-1 bn">Account User: <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mgt0">
              <h2 class="txt-style-3">Account Status</h2>
              <div class="w50">
              <table width="100%" border="0" align="center" class="account_dashboard">
                  <?php 
                        $query = mysql_query("SELECT per_week_cost FROM taxicompany WHERE web_user_id = '".$_SESSION['uid']."'");
                        while($row=mysql_fetch_array($query)){                            
                            $total_begning_limit = $row['per_week_cost'];
                           // "SELECT SUM(amount) as totalamount FROM manage_master_amount WHERE company_id = '".$_SESSION['uid']."' and zone_id !=''";
                        $query_credit = mysql_query("SELECT SUM(amount) as totalamount FROM manage_master_amount WHERE  company_id = '".$_SESSION['uid']."' and zone_id !='0' and type ='credit_amount'");  
                            while($row1=mysql_fetch_array($query_credit)){   
                                $total_credit_limit = $row1['totalamount'];
                            }
                        } 
                        $amt_total = $total_begning_limit + $total_credit_limit;
                  ?>
                  
                <tr>
                  <td width="30%" height="37">Taxi Central net balance</td>
                  <td width="10%" height="37" align="center"> - </td>
                  <td width="30%" height="37"> <?php if($amt_total){echo CURRENCY.$amt_total;}else{echo CURRENCY.'0';}?></td>
                </tr>
                <?php 
                    //Total all user credit limit query for corporation
                        $query_total =" SELECT  SUM(corporate.begning_credit) as user_credit_limit FROM corporate "
                            . " WHERE company_id='".$_SESSION['uid']."'";
                        $result_total = mysql_query($query_total);
                        while($row=mysql_fetch_array($result_total)){
                             $total_credit_limit = $row['user_credit_limit'];
                        }  
                        
                    // Total user amount use by croporate users  for corporation
                        $query =" SELECT corporate.company_id, corporate.web_user_id as cop_user_id, users.id, users.corporate_id, users.credit_limit, account.customer_id, account.id, SUM(account.payment_amount) as amount_total FROM corporate "
                                . " JOIN users ON corporate.web_user_id = users.corporate_id"
                                . " JOIN account ON users.id = account.customer_id"
                                . " WHERE company_id='".$_SESSION['uid']."' AND payment_mode !='cash'";
                        $result = mysql_query($query);
                        while($row=mysql_fetch_array($result)){
                           $total_used_amount = $row['amount_total']; 
                        }                         
                        $net_corporation_amount =  $total_credit_limit-$total_used_amount;                   
                ?>
                <tr>
                  <td width="30%" height="37"> Corporation </td>
                  <td width="10%" height="37" align="center"> - </td>
                  <td width="30%" height="37"><?php if($net_corporation_amount){echo CURRENCY.$net_corporation_amount;}else{echo CURRENCY.'0';}?> </td>
                </tr>
                <?php 
                    //Total all user credit limit query for corporation
                        /*$query_total ="SELECT account.id, account.driver_id, account.payment_amount,account.payment_mode, driver.* FROM driver JOIN account ON driver.id = account.driver_id"
                           . " WHERE company_id='".$_SESSION['uid']."' AND account.payment_mode !='cash' AND account.payment_mode !=''";*/                
                        $query_driver_total ="SELECT SUM(account.payment_amount) as driver_amt FROM driver JOIN account ON driver.id = account.driver_id"
                            . " WHERE company_id='".$_SESSION['uid']."' AND account.payment_mode !='cash' AND account.payment_mode !=''";
                        $result_driver_total = mysql_query($query_driver_total);
                        while($row=mysql_fetch_array($result_driver_total)){
                             $total_driver_limit = $row['driver_amt'];
                        }  
                        
                                     
                ?>
                <tr>
                  <td width="30%" height="37">Driver Net Balance</td>
                  <td width="10%" height="37" align="center">  -</td>
                  <td width="30%" height="37"> <?php if($total_driver_limit){echo CURRENCY.$total_driver_limit;}else{echo CURRENCY.'0';}?> </td>
                </tr>
              </table>
              </div>
            <div class="row bts">
              <div class="col-md-4">
              <a href="<?php echo TAXI_URL; ?>tc-acc-status.php" class="dash-button hvr-wobble-horizontal w100 wap"> central Taxi </a>
              </div>
              
              <div class="col-md-4">
              <a href="<?php echo TAXI_URL; ?>corporate.php" class="dash-button hvr-wobble-horizontal w100 wap"> Corporation </a>
              </div>
              
              <div class="col-md-4 mghji">
              <a href="<?php echo TAXI_URL; ?>td-acc-status.php" class="dash-button hvr-wobble-horizontal w100 wap"> Taxi Driver </a>
              </div>
			</div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>
<script type="text/javascript">
$(document).ready(function (){
   // Array holding selected row IDs
   var rows_selected = [];
   var table = $('#viewAdministrator').DataTable({
      'ajax': {
         'url': "getData.php?mode=<?php echo base64_encode('getAccountAdministratorDetails'); ?>" 
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
        swal("Deleted!", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}
</script>
</body>
</html>