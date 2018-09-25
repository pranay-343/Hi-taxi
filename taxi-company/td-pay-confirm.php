<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body  class="popup_designm1">
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">Taxi Driver</h2>
               <?php
                    if(isset($_POST['driverData'])){print_r($driverData);
                    $driverName=$_REQUEST['txtDriName'];
                    $str55="select * from driver where name='$driverName'";
                    $res55=mysql_query($str55);
                    $row55=mysql_fetch_array($res55);
                    ?>
                    <div class="c-acc-status mg5">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                            <th width="5%" class="tab-txt1">Driver Name</th>
                            <th width="20%" class="tab-txt1">Driver Contact Number</th>
                            <th width="20%" class="tab-txt1">Car Plate Number</th>                            
                        </tr>
                  <tr>
                    <td width="5%" class="tab-txt1"><?php echo $row55['name']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row55['contact_number']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row55['vehicle_number']; ?></td>                    
                  </tr>
                    </thead>
                  </table>
                </div>
                <?php }?>
              </div>


<link href="http://ngiriraj.com/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="http://ngiriraj.com/css/AdminLTE.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>


			  <?php
                if(isset($_POST['amount_comfirm']) and $_POST['amount_comfirm']!=""){echo 'aaa';
                amountComfirmToTaxtidriver();
                //unset($_POST);
                HTMLRedirectURL(TAXI_URL."payement_print_all_trips.php?id=".base64_encode($_POST['driver_id'][0]));
                }
                ?>
              <?php
                $str="SELECT `trip`.id as tripId,`trip`.tripdatetime,`trip`.driver_id,`driver`.company_id,`users`.id as corporateId,`users`.name,`trip`.source_address,`trip`.trip_ammount,`trip`.payment_to_driver,`driver`.name as driverName From `trip`
            LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id
            LEFT JOIN `users` ON `trip`.customer_id=`users`.id
             where `driver`.name='$driverName' AND trip.account_type='99' AND trip.payment_to_driver='0'";
            $res=mysql_query($str); 
            //$row=mysql_fetch_array($res); 
			$rows = mysql_num_rows($res);
            if($rows>0)
            {            
          ?>
		  
		  <form method ="post" name="trip_payment" action="" onSubmit="return amountComfirmToTaxtidriver();">
		  
          <div class="c-acc-status mg5">
		  <div class="box-body table-responsive" id="ptable">
			<div class="btn-group">
<!--				<button class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i> Exportación de datos de la tabla</button>-->
				<ul class="dropdown-menu " role="menu" style="left: 0px;">									
					<li><a href="#" onClick="$('#customers').tableExport({type:'excel',escape:'false'});"> <img src="http://ngiriraj.com/pages/htmltable_export/icons/xls.png" width="24px"> XLS</a></li>
					<li><a href="#" onClick="myFunctionPrint()" class="fa fa-print">Impresión</a></li>
				</ul>
			</div>		
			<div id="customers">
              <table width="100%" cellpadding="0" cellspacing="0" border="0" id="customers1" class="table table-bordered table-striped sortable">
                    <thead>
                        <tr>
                            <th width="5%" class="tab-txt1">#</th>
                            <th width="20%" class="tab-txt1">QUANTITY</th>
                            <th width="20%" class="tab-txt1">DATE AND TIME</th>
                            <th width="10%" class="tab-txt1">CORPORATION</th>
                            <th width="10%" class="tab-txt1">STATUS</th>
                            <th width="10%" class="tab-txt1">DRIVER NAME</th>
                            <th width="30%" class="tab-txt1">MORE INFORMATION</th>
                        </tr>
                    </thead>
                  <?php
                 while($row=mysql_fetch_array($res))
                  {
                    // $linkss = '<a href="'.ZONE_URL.'Edit-taxi-company.php?a=' . base64_encode($row['id']) . '"><img src="../images/edit.png" alt="" title="" /></a>';
                    ?>
                    <input type="hidden" name="trip_id[]" value="<?php echo $row['tripId']; ?>"/>
                    <input type="hidden" name="amount[]" value="<?php echo $row['trip_ammount']; ?>"/>
                    <input type="hidden" name="driver_id[]" value="<?php echo $row['driver_id']; ?>"/>
                    <input type="hidden" name="corporateId[]" value="<?php echo $row['corporateId']; ?>"/>
                  <tr>
                    <td width="5%" class="tab-txt1"><?php echo $row['tripId']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row['trip_ammount']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row['tripdatetime']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row['name']; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo 'Pending'; ?></td>
                    <td width="5%" class="tab-txt1"><?php echo $row['driverName']; ?></td>
                    <td class="tab-txt2"><a href="view-taxi-driver-info.php?id=<?php echo base64_encode($row["tripId"]);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                  </tr>
                    <?php
                  } 
                  }                
                  else
                {                 
                  echo "<tr>";
                  echo "<td style='color:red;padding:10px;' colspan='8'>No Records Found</td>";
                  echo "</tr>";
                }
                  ?>  
                </table>
				</div>
				<div class="c-acc-status mg5">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                          <?php 
                          //  $driverName=$_REQUEST['txtDriName'];
                            $str61="SELECT `driver`.name,`driver`.id,`trip`.id,SUM(`trip`.trip_ammount) as totalamount, trip.driver_id,trip.account_type FROM `driver`
                            LEFT JOIN trip On driver.id = trip.driver_id where `driver`.name='$driverName' AND trip.account_type='99' AND trip.payment_to_driver='0'";
                            $res61=mysql_query($str61);
                            //print_r($res61);
                            $row61=mysql_fetch_assoc($res61);
                            ?>
                            <!-- <td><input type="text" name="totalAmount" value="<?php echo $Amount= $row61['totalamount'];?>"> </td> -->
                            <th width="5%" class="tab-txt1"> TOTAL AMOUNT:
                            <?php echo $Amount= $row61['totalamount'];
                            ?></th>
                            <input type="hidden" name="tripAllPrice" value="<?php echo $row61['totalamount'];?>" />
                        </tr> 
                    </thead>
                  </table>
                </div>
				<div class="row">
                  <div class="col-lg-12" style="text-align:center;">
					<!--<button class="dash-button hvr-wobble-horizontal" type="submit">CONFIRM</button>-->
					
                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('amountComfirmToTaxtidriver')?>" />
                    <input class="dash-button hvr-wobble-horizontal" type="button"  data-toggle="modal" data-target="#myModal"  value="CONFIRMAR" />
                  </div>
                </div>
                      
                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Confirmacion de pago</h4>
                          </div>
                          <div class="modal-body">
                              <p>payments for all trips</p>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                              <!--<button type="submit" class="btn btn-primary" data-dismiss="modal" name="submit1" id="submit1">SI</button>-->
                              <input type="submit" class="btn btn-primary" name="amount_comfirm" id="amount_comfirm" value="SI" />

                          </div>
                      </div>
                  </div>
              </div>
        
            </div>
			</form>
          </div>
        </div>
        
        
            
      </div>
    </div>
<?php 
include '../include/footer.php'; 
?>

 <script type="text/javascript" src="export/tableExport.js"></script>
<script type="text/javascript" src="export/jquery.base64.js"></script>
<script type="text/javascript" src="export/html2canvas.js"></script>
<script type="text/javascript" src="export/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="export/jspdf/jspdf.debug.js"></script>
<script type="text/javascript" src="export/jspdf/libs/base64.js"></script> 
<script>
function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'a2');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#customers')[0];

    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 40,
        bottom: 40,
        left: 40,
		width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF 
        //          this allow the insertion of new lines after html
        pdf.save('Test.pdf');
    }, margins);
}
</script>
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
        swal("Eliminado", "La central de taxi fue eliminada", "Éxito");
      });
    
    return false;
}
</script>
<script type="text/javaScript">
	
		$(document).ready(function(){
		
			//var curl = $(location).attr('href');
			var curl = location.href.split("/").slice(-1);
		
			var aurl = "";
			$('li > a').each(function() {
				aurl = $(this).attr('href').split("/").slice(-1);
				if ("'"+curl+"'" == "'"+aurl+"'"){
				$(this).parent().parent().parent().addClass('active');
				$(this).parent().parent().parent().parent().addClass('active');
				$(this).parent().parent().parent().parent().parent().addClass('active');
				$(this).parent().parent().parent().parent().parent().parent().addClass('active');
				$(this).parent().parent().parent().parent().parent().parent().parent().addClass('active');
				}			
			});
			
			
		});
		
// Print function	
function myFunctionPrint() {
    window.print();
}
</script>
</body>
</html>