<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
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
          <div class="row br1">
<div class="col-sm-12">
</div>
</div>
            <div class="c-acc-status mg5 mgt0">
			<?php
            if(isset($_POST['add_company_payment']) and $_POST['add_company_payment']!=""){
            addTaxiCompanyPayment();
            unset($_POST);
            }
			?>
              <h2 class="txt-style-3">AÃ±adir Pago</h2>
              <form action="" method="POST" name="submit">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                       
                      <label> Nombre de la empresa de taxis </label>                      
					  <select class="input-style" style="color:#999;" name="companyId" id="companyId">
						<option value="">Seleccionar Nombre de la empresa</option>
						<?php 
							$query ="SELECT name,id,web_user_id FROM taxicompany WHERE added_by = '".$_SESSION['uid']."'";
								$result = mysql_query($query);
								$num_rows = mysql_num_rows($result);
								if($num_rows>0){
								while($row = mysql_fetch_array($result)){
						?>
						<option value="<?php echo $row['web_user_id']?>"><?php echo $row['name'];?></option>
						<?php } }?>
					  </select>
                    </div>
                  </div>                     
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Seleccionar las Semanas tendrá que pagar </label>
                      <input type="text" name="fromDate" id="fromDate" class="datepicker-here input-style" placeholder="Seleccione fecha" />
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Seleccionar las Semanas tendrá que pagar </label>
                      <input type="text" name="toDate" id="toDate" class="datepicker-here input-style" placeholder="Seleccione fecha" />
                    </div>
                  </div>
                  <div class="col-sm-4" id="month">
                    <div class="form-group">
                      <label> AÃ±adir Pago </label>
                      <input type="text" name="companyPayment" id="companyPayment" class="input-style" placeholder="Introduzca controlador de Pago" />
                    </div>
                  </div>
                </div> 
                  
                <div class="row">
                  <div class="col-lg-12" style="text-align:center;">
                    <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
					
					<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('addTaxiCompanyPayment')?>" />
					<input type="submit" name="add_company_payment" id="add_company_payment" value="AÃ±adir Pago" class="dash-button hvr-wobble-horizontal" />
                    <!--<button class="dash-button hvr-wobble-horizontal" name="submit"   type="submit">Add Payment</button>-->
                  </div>
                </div>
              </form>
            </div>           
                   
          </div>          
        </div>
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>

<script type="text/javascript">
var $start = $('#start'),
  $end = $('#end');
  $start.datepicker({
    language: 'en',
    minDate: 0,
    onSelect: function (fd, date) {
      $end.data('datepicker')
        .update('minDate', date)
    }
  })
  $end.datepicker({
    language: 'en',
    minDate: 0,
    onSelect: function (fd, date) {
      $start.data('datepicker')
        .update('maxDate', date)
    }
  })
</script>
</body>
</html>