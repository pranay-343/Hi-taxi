<?php 
include '../include/define.php';
verifyLogin();
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
			  <div id="errorMessage"></div>
          <h2 class="txt-style-3">Message History</h2>
          <form  method="post" action="">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> FROM </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date" name="fromDate"  value="<?php echo $_POST['fromDate'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date" name="toDate" value="<?php echo $_POST['toDate'];?>" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Status </label>
                  <ul>
                    <li>
                      <input type="checkbox" name="chkStatusPending" value="pending" <?php if (!empty($_POST['chkStatusPending'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Pending</span></li>
                      <li>
                      <input type="checkbox" name="chkStatusSolved" value="solved" <?php if (!empty($_POST['chkStatusSolved'])): ?> checked="checked"<?php endif; ?> />
                      <span>Resolved</span></li>
                      <li>
                      <input type="checkbox" name="chkStatusDiscard" value="discard" <?php if (!empty($_POST['chkStatusDiscard'])): ?> checked="checked"<?php endif; ?>/>
                      <span>Discarded</span></li>
                     
                  </ul>
                </div>
                
                <div class="form-group">
                  <label> TAXI DRIVER </label>
                  <input type='text' class='input-style' placeholder="TAXI DRIVER" name="txtDName" value="<?php echo $_POST['txtDName'];?>"/>
                </div>
              </div>
           <div class="clearfix"></div>
              <div class="col-sm-4 col-sm-offset-4">
                <button class="dash-button hvr-wobble-horizontal w100 wap" type="submit" name="submit" id="submit">informes de búsqueda</button>
              </div>
              
            </div>
          </form>
          
          <br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="10%" class="tab-txt1">Name</th>
                <th width="25%" class="tab-txt1">Date and Time</th>
                <th width="25%" class="tab-txt1">COMMENT</th>
                <th width="20%" class="tab-txt1">MORE INFORMATION</th>
                <th width="10%" class="tab-txt1">RESOLVE</th>
                <th width="10%" class="tab-txt1">DISCARD</th>
              </tr>
			  <?php 
				 $query ="SELECT driver.id, driver.name, driver.added_by as driAddedBy,trip.id as tId,trip.driver_id as tRId, trip.driver_rateing, trip.customer_rating, trip.customer_id, trip.complain_status, trip.tripdatetime,trip.description, taxicompany.web_user_id, taxicompany.id as taxiId, taxicompany.added_by as taxiAddedBy  FROM trip LEFT JOIN driver ON trip.driver_id = driver.id LEFT JOIN taxicompany ON driver.added_by = taxicompany.web_user_id WHERE taxicompany.added_by ='".$_SESSION['uid']."' AND trip.customer_rating <=  '2' ";
				
				if (isset($_POST['submit'])) {
					
					echo '<p># Buscar: <strong>"'.$_POST['txtDName'].'"  "'.$_POST['fromDate'].'"  "'.$_POST['toDate'].'"</strong><p>';
					
					/*$chkStatus = $_POST['chkStatus'];
					$chekData = implode(",",$chkStatus);
					if ($chekData != '') {
						$complain_status = " AND complain_status IN ($chekData)";
					}*/
					if($_POST['txtDName'] != ''){
						$query .= "AND driver.name like '%".$_POST['txtDName']."%'";
					}
					if($_POST['chkStatusPending'] != ''){$pending = $_POST['chkStatusPending'];}else{$pending = '';}
					if($_POST['chkStatusSolved'] != ''){$solved = $_POST['chkStatusSolved'];}else{$solved = '';}
					if($_POST['chkStatusDiscard'] != ''){$discard = $_POST['chkStatusDiscard'];}else{$discard = '';}
					if($pending == "" || $pending == null and $solved == "" || $solved == null and $discard == "" || $discard == null)
					{
                        
					}
					else
					{
						$query .= "and trip.complain_status in ('$pending','$solved','$discard')";
					}
					
					if($_POST['fromDate'] != '' && $_POST['toDate'] != ''){
					$query .= "AND trip.tripdatetime between '".date('Y-m-d',strtotime($_POST['fromDate']))."' AND  '".date('Y-m-d',strtotime($_POST['toDate']))."'+ INTERVAL 1 DAY";
					}
					//print_r($query);
				}  
					//$i = '0';
					$result = mysql_query($query);
					$num_rows = mysql_num_rows($result);
					if($num_rows>0){
					while($data =  mysql_fetch_array($result)){
					//$i++ 	
			  ?>
              <tr>
                <td class="tab-txt2"><?php echo $data['name']?></td>
                <td class="tab-txt2"><?php echo date('Y-m-d', strtotime($data['tripdatetime']));?></td>
                <td class="tab-txt2"><?php echo $data['description'];?></td>
                <td class="tab-txt2"><a href="view_reports.php?a=<?php echo base64_encode($data['tId']); ?>&b=<?php echo base64_encode($data['tRId']); ?>&c=<?php echo base64_encode($data['customer_id']); ?>&d=<?php echo base64_encode($data['driver_rateing']); ?>&e=<?php echo base64_encode($data['customer_rating']); ?>" id="moreinfo" ><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
				
				<?php if($data['complain_status'] == 'solved'){?>
				<td class="tab-txt2"><?php echo 'Solved'?></td>
				<?php }else{?>
                <td class="tab-txt2"><a href="javascript:void(0)" id="solved"  data-toggle="modal" data-target="#solved-modal-<?php echo $data['tId'];?>" ><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
				<?php }?>
				<?php if($data['complain_status'] == 'discard'){?>
				<td class="tab-txt2"><?php echo 'Discard'?></td>
				<?php }else{?>
                <td class="tab-txt2"><a href="javascript:void(0)" id="discarded" data-toggle="modal" data-target="#discarded-modal-<?php echo $data['tId'];?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
				<?php }?>
              </tr>
			  <div class="modal fade solved-modal" id="solved-modal-<?php echo $data['tId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="padding-bottom:0;">
							<p><strong>Informe resuelto</strong></p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						
						<!-- Begin # DIV Form -->
						<?php
						if(isset($_POST['solve_pay']) and $_POST['solve_pay']!=""){
						solvedReportPayment();
						unset($_POST);
						HTMLRedirectURL(ZONE_URL."reports.php");
						}
						?>
						<div id="div-forms">
						
							<!-- Begin # Login Form -->
							<form id="solve-form" method="post" action="" onSubmit="return solvedReportPayment();">
								<div class="modal-body">
									<p> Se le quiere resolver este informe / quejas</p>
								</div>
								<input type="hidden" name="trip_id" value="<?php echo $data['tId'];?>"/>
								<input type="hidden" name="txtSolved" value="solved"/>
								<div class="modal-footer">                            
									 <div class="btnCon">
										<button type="button" class="dash-button w100" style="margin-top:0;" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">No</button>
										<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('solvedReportPayment')?>" />
										<input class="dash-button w100" type="submit" name="solve_pay" id="solve_pay" value="Sí" />
									</div>	
								</div>
							</form>
						  
							
						</div>
						<!-- End # DIV Form -->
						
					</div>
				</div>
			</div>
			
			<div class="modal fade discarded-modal" id="discarded-modal-<?php echo $data['tId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="padding-bottom:0;">
							<p><strong>Informe descartados</strong></p>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
						
						<!-- Begin # DIV Form -->
						<?php
						if(isset($_POST['discarded_pay']) and $_POST['discarded_pay']!=""){
						discardedReportPayment();
						unset($_POST);
						HTMLRedirectURL(ZONE_URL."reports.php");
						}
						?>
						<div id="div-forms">
						
							<!-- Begin # Login Form -->
							<form id="discarded-form" method="post" action="" onSubmit="return discardedReportPayment();">
								<div class="modal-body">
									<p> ¿Está desea descartar este informe / quejas</p>
								</div>
								<input type="hidden" name="trip_id" value="<?php echo $data['tId'];?>"/>
								<input type="hidden" name="txtDiscard" value="discard"/>
								<div class="modal-footer">                            
									 <div class="btnCon">
										<button type="button" class="dash-button w100" style="margin-top:0;" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">No</button>
										<input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('discardedReportPayment')?>" />
										<input class="dash-button w100" type="submit" name="discarded_pay" id="discarded_pay" value="Sí" />
									</div>	
								</div>
							</form>
						  
							
						</div>
						<!-- End # DIV Form -->
						
					</div>
				</div>
			</div>
			<?php } }else{?>
			<tr>
				<td style="color: red; padding:10px" colspan="6"> No se encontrarón archivos</td>
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
</script>