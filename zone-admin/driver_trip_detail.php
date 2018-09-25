<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';

$id = base64_decode($_GET['a']);
//print_r($id);
?>
<style type="text/css">
#result {
	position:absolute;
	width:100%;
	padding:10px;
	display:none;
	margin-top:-1px;
	border-top:0px;
	overflow:hidden;
	border:1px #CCC solid;
	background-color: white;
}
.show {
	padding:5px;
	border-bottom:1px #999 dashed;
	font-size:15px;
}
.show:hover {
	background:#4c66a4;
	color:#FFF;
	cursor:pointer;
}
</style>
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
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Estado de la cuenta: Detalle Taxi Conductor de viaje</h2>
          <form method="post" name="search" action="" autocomplete="off">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> A partir de </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select From Date"  name="start_date" value="<?php echo $_POST['start_date'];?>"/>
                </div>
              </div>
              <?php// echo $a = $_REQUEST['a'];?> 
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Hasta </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select To Date"  name="end_date"  value="<?php echo $_POST['end_date'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Tipo</label>
                  <ul>
                    <li>
                      <input type="checkbox" name="travel" value="202" <?php if (!empty($_POST['travel'])): ?> checked="checked"<?php endif; ?> />
                      <span>Viajar</span> </li>
                    <li>
                      <input type="checkbox" name="complete" value="500"  <?php if (!empty($_POST['complete'])): ?> checked="checked"<?php endif; ?> />
                      <span>Completar</span> </li>
                  </ul>
                </div>
              </div>
           
              <!--<div class="col-sm-4">
                    <div class="form-group">
                      <label> Corporation </label>
                      <input type="text" name="txtCorName" class="input-style search1" id="searchid" placeholder="Enter text here"  value="<?php echo $_POST['txtCorName'];?>"/>
                      <span id="party_id12" style="display:none"></span>   
                    </div>
                  </div>-->
                  <div class="clearfix"></div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Conductor de taxi </label>
                  <input type="text" name="txtDriName" class="input-style" placeholder="Enter text here"  value="<?php echo $_POST['txtDriName'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Tipo</label>
                  <ul>
                    <li>
                      <input type="checkbox" name="paid" value="paid" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Pagado</span> </li>
                    <li>
                      <input type="checkbox" name="unpaid" value="unpaid" <?php if (!empty($_POST['unpaid'])): ?> checked="checked"<?php endif; ?>/>
                      <span>No pagado</span> </li>
                  </ul>
                </div>
              </div>
            <div class="clearfix"></div>
              <div class="col-lg-12" style="text-align:center;">
                <button class="dash-button hvr-wobble-horizontal" type="submit" name="submit">filtros</button>
              </div>
            </div>
          </form>
        </div>
        
        <!-- BY Dinesh -->
        <div class="c-acc-status bst mgmin">
            <h2 class="txt-style-3">información para el conductor</h2>
         
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr> 
                <!--<th class="tab-txt1">Trip id</th>-->
                <th class="tab-txt1">Nombre del conductor</th>
                <!-- <th class="tab-txt1">Email Id</th> -->
                <th class="tab-txt1">NÚMERO DE CONTACTO</th>
                <th class="tab-txt1">Insurence Expiry Date</th>
                <th class="tab-txt1">Seguros Fecha de caducidad</th>
                <th class="tab-txt1">Última hora de conexión</th>
                <th class="tab-txt1">Estado actual</th>
              </tr>
              <?php 
                $driverDetail = mysql_fetch_array(mysql_query("select * from `driver` where id ='".$id."'"));
                if($driverDetail['status'] == '200')
                {
                   $CurrentStatus ='working';
                }
                elseif($driverDetail['status'] == '99')
                {
                   $CurrentStatus ='block';
                }
                elseif($driverDetail['status'] == '404')
                {
                   $CurrentStatus ='suspend';
                }
               ?>
              <tr>
                <td class="tab-txt2"><?php echo $driverDetail['name']; ?></td>
                <!-- <td class="tab-txt2"><?php //echo $driverDetail['email']; ?></td> -->
                <td class="tab-txt2"><?php echo $driverDetail['contact_number']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['insurance_expiration_date']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['licence_expiration_date']; ?></td>
                <td class="tab-txt2"><?php echo $driverDetail['last_login_time']; ?></td>
                <td class="tab-txt2"><?php echo $CurrentStatus; ?></td>
              </tr>
            </table>
        </div>
        <!-- BY Dinesh -->
      
          <div class="c-acc-status bst mgmin">
            <h2 class="txt-style-3">Historia de viajes</h2>
         
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr> 
                <!--<th class="tab-txt1">Trip id</th>-->
                <th class="tab-txt1">Conductor de taxi</th>
                <th class="tab-txt1">Ingresos</th>
                <th class="tab-txt1">Fecha</th>
                <th class="tab-txt1">Estado</th>
                <th class="tab-txt1">Efectivo / por aplicación</th>
              </tr>
              <?php
                if (isset($_POST['submit'])) {  
                    $fromDate = date('Y-m-d', strtotime($_POST['start_date']));
                    $toDate = date('Y-m-d', strtotime($_POST['end_date']));
                //(base64_encode($_POST['txtname']));
                if ($_POST['txtDriName'] != '') {
                    $driverName = " AND driver.name LIKE '%" . ($_POST['txtDriName']) . "%'";
                }
                if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {
                    $date1 = "and account.add_on >='" . $fromDate . "' AND account.add_on <='" . $toDate . "'";
                    //$date = "and trip.tripdatetime >='" . $fromDate . "' AND trip.tripdatetime <='" . $toDate . "'";
                    $date = "AND trip.tripdatetime between '" . date('Y-m-d', strtotime($_POST['start_date'])) . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date'])) . "'";
                }
                if($_POST['travel']!=''){
                    $travel = " AND (`trip`.status LIKE '%" . ($_POST['travel']) . "%'";
                }
                
                if($_POST['complete']!=''){
                    $complete = " OR `trip`.status LIKE '%" . ($_POST['complete']) . "%')";
                }
                
                if($_POST['paid']!=''){
                    $paid = " AND (`account`.payment_mode LIKE '%" . ($_POST['paid']) . "%'";
                }
                
                if($_POST['unpaid']!=''){
                    $unpaid = " OR `account`.payment_mode LIKE '%" . ($_POST['unpaid']) . "%')";
                }
                
            } else {
                $driverName = '';
                $date = '';
                $travel ='';
                $complete = '';
                $paid = '';
                $unpaid = '';
            }
               $str="SELECT `trip`.id as tripId,`trip`.tripdatetime,`trip`.status,`trip`.driver_id,sum(`trip`.trip_ammount) as paymentDriver,`trip`.payment_mode,`driver`.company_id,`login`.id,`login`.name,`trip`.source_address,`driver`.name as driverName From `trip`"
                   . "LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id "
                   . "LEFT JOIN `login` ON `driver`.company_id=`login`.id "
                   //. "LEFT JOIN `account` ON `trip`.id=`account`.trip_id "
                   . "WHERE 1 and `trip`.trip_type != 'userapp' and `trip`.driver_id = $id AND (`trip`.status ='202' OR `trip`.status ='500') $driverName $date $travel $complete $paid $unpaid ORDER BY trip.id DESC";
            $res=mysql_query($str); 
            if(mysql_affected_rows()>0){ 
                while($info=mysql_fetch_array($res))
                  {
                
            ?>
              <tr> 
                <!--<td class="tab-txt2"><?php //echo $info['tripId'];?></td>-->
                <td class="tab-txt2"><?php echo $info['driverName'];?></td>
                <td class="tab-txt2"><?php if($info['paymentDriver']){echo $info['paymentDriver'];echo' MX';}else{echo '0.0 MX';}?></td>
                <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['tripdatetime'])); echo' - '; echo date('h:i:s A', strtotime($info['tripdatetime']));?></td>
                <td class="tab-txt2"><?php if($info['status'] == '202'){echo 'Travel';}elseif($info['status'] == '500'){echo 'Complete';}?></td>
                <td class="tab-txt2"><?php if($info['payment_mode']=='cash'){echo 'Cash';}else{echo'BY App';} ?></td>
                <?php } } else{?>
              <tr>
                <td style="color: red; padding:10px" colspan='5'>No hay resultados</td>
              </tr>
              <?php }?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html><script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>
