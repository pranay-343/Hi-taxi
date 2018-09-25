<?php 
include '../include/define.php';
//verifyLogin();
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
          <h2 class="txt-style-3">Taxi Driver</h2>
          <form method="post" name="search" action="">
            <div class="row bts">
             
              <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                  <label> From  </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date" name="fromDate" value="<?php echo $_POST['fromDate'];?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To  </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date" name="toDate" value="<?php echo $_POST['toDate'];?>"/>
                </div>
              </div>
            
              <div class="col-sm-4 col-sm-offset-4">
                <button class="dash-button hvr-wobble-horizontal w100 wap" type="submit" name="submit">Search</button>
              </div>
              
            </div>
          </form>
          <br/>
<!--         <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        <div class="row bts2 bst">
        	<div class="col-sm-6 i00" style=" width: 40% !important">
            	<img src="../images/chart.png" alt="" title="" />
            </div>
            <div class="col-sm-6 i100">
            	<img src="../images/car.png" alt="" title="" />
            </div>
            <div class="col-sm-12">
			<div id="chart-container1" style="width:  95% !important;display: inline-block;">FusionCharts rendirán aquí</div></div>
        </div>-->
           <br/>
           </div>
           <div class="c-acc-status mg5">
         <h2 class="txt-style-3">Taxi drivers list</h2>
         
         <form method="post" name="search" action="">
         <div class="row bts1">
             <div class="col-sm-4">
                 <div class="form-group">
                     <label> Name </label>
                     <input type='text' class='input-style' placeholder="Name" name="txtDriverName" value="<?php echo $_POST['txtDriverName']; ?>"/>
                 </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                <label> Contact Number </label>
               <input type='text' class='input-style' placeholder="Contact Number" name="txtContact" value="<?php echo $_POST['txtContact']; ?>"  />
                 </div>
             </div>
             <div class="col-sm-4">
                <div class="form-group">
                <label> Email </label>
                <input type='text' class='input-style' placeholder="Email" name="txtEmail" value="<?php echo $_POST['txtEmail']; ?>"  />
                </div>
             </div>
            <!-- <div class="col-sm-3">
         	<div class="form-group">
            <label> Id controlador</label>
            <input type='text' class='input-style' placeholder="Introduzca texto aquí" name="txtDriverId" value="<?php echo $_POST['txtDriverId'];?>" />
            </div>
            </div>
            <div class="col-sm-3">
         	<div class="form-group">
            <label> Número de matrícula del coche </label>
            <input type='text' class='input-style' placeholder="Introduzca texto aquí" name="txtCarPlate" value="<?php echo $_POST['txtCarPlate'];?>" />
            </div>
            </div>-->
            
            	<div class="col-sm-4 col-sm-offset-4 f74">
                	<button class="dash-button hvr-wobble-horizontal w100 wap" type ="submit" name="submit"><i class="fa fa-search"></i>Search</button>
                </div>
            </div>
         </form>
          <br/><br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th  class="tab-txt1">CORPORATE USER</th>
                <th  class="tab-txt1">DRIVER NAME</th>
                <th  class="tab-txt1">LAST VISIT</th>
                <th class="tab-txt1">FINISHED</th>
                <th  class="tab-txt1">CANCELED</th>
                <!--<th class="tab-txt1">Reported</th>-->
                <th  class="tab-txt1">PUNCTUATION</th>
                <th class="tab-txt1">MORE INFORMATION</th>
              </tr>
			  
			  <?php //print_r($_SESSION);
			  
			  if(isset($_POST['submit'])) {
					if($_POST['txtDriverName']!=''){
						$name = "AND driver.name LIKE '%" . $_POST['txtDriverName'] . "%'";
					}
					else
						{
							$name = "";	
						}
                    if ($_POST['fromDate'] != '' && $_POST['toDate'] != '') {
                      //  $date = "AND trip.tripdatetime between '" . date('Y-m-d', strtotime($_POST['fromDate'])) . "' AND  '" . date('Y-m-d', strtotime($_POST['toDate'])) . "'";
                    }
					if($_POST['txtContact']!=''){
						$contact = " AND driver.contact_number LIKE '%" . ($_POST['txtContact']) . "%'";
					}
					else
						{
							$contact = "";	
						}
					
					if($_POST['txtEmail']!=''){
						$email = " AND `driver`.username LIKE '%" . ($_POST['txtEmail']) . "%'";
					}
					else
						{
							$email = "";	
						}
					
					if($_POST['txtDriverId']!=''){
						$liecence_number = " AND driver.liecence_number LIKE '%" . ($_POST['txtDriverId']) . "%'";
					}
					else
						{
							$liecence_number = "";	
						}
					if($_POST['txtCarPlate']!=''){
						$vehicle_number = " AND `driver`.vehicle_number LIKE '%" . ($_POST['txtCarPlate']) . "%'";
					}
					else
						{
							$vehicle_number = "";	
						}
					
                } else {
                    $name = '';
                    //$date = '';
					$contact ='';
					$email = '';
					$liecence_number = '';
					$vehicle_number = '';
                }
					$query ="SELECT login.id as corporateId, login.name as corporateName FROM login where 1 and added_by ='".$_SESSION['uid']."'";
					$result = mysql_query($query);
					$num_rows = mysql_num_rows($result);
					if($num_rows > 0){
					while($row = mysql_fetch_array($result)){
						//$query1 = "SELECT driver.*,trip.id as tripId, trip.driver_id as tripDId, trip.tripdatetime FROM driver LEFT JOIN trip On driver.id = trip.driver_id where added_by = '".$row['corporateId']."' $date $name $contact $email GROUP BY (trip.driver_id) ORDER BY trip.id DESC"	;
						$query1 = "SELECT driver.*,trip.id as tripId, trip.driver_id as tripDId, trip.tripdatetime, taxicompany.id as taxyId, taxicompany.zone_area_id_sess FROM driver LEFT JOIN trip On driver.id = trip.driver_id LEFT JOIN taxicompany ON driver.company_id = taxicompany.web_user_id where driver.added_by = '".$row['corporateId']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'  $name $contact $email $liecence_number $vehicle_number GROUP BY (trip.driver_id) ORDER BY trip.id DESC"	;
						$result1 = mysql_query($query1); 
						while($row1 = mysql_fetch_array($result1)){
							//print_r($row1["id"]);
			  ?>
              <tr>
                <td class="tab-txt2"><?php echo $row['corporateName'];?></td>
                <td class="tab-txt2"><?php echo $row1['name'];?></td>
                <td class="tab-txt2"><?php if($row1['tripdatetime']){echo date('Y-m-d', strtotime($row1['tripdatetime']));}else{echo 'No Trips';}?></td>
				<?php 
				//error_reporting(0);	
				
					$query_com  = mysql_query(" SELECT * FROM trip LEFT JOIN driver ON trip.driver_id = driver.id where trip.driver_id = '".$row1["id"]."' AND trip_mode = 'complete'  $name $contact $email $liecence_number $vehicle_number");
					$num_rows_com = mysql_num_rows($query_com);
				?>
                <td class="tab-txt2"><?php if($num_rows_com>0) {echo $num_rows_com;} else{echo '0';}?></td>
				<?php 
				
					$query_can  = mysql_query(" SELECT * FROM trip LEFT JOIN driver ON trip.driver_id = driver.id where trip.driver_id = '".$row1["id"]."' AND status = '600'  $name $contact $email $liecence_number $vehicle_number");
					if($query_can){
					$num_rows_can = mysql_num_rows($query_can);}
					else{
						$num_rows_can ='0';
					}
				?>
                <td class="tab-txt2"><?php if($num_rows_can>0) {echo $num_rows_can;} else{echo '0';}?></td>
                  <!--<td class="tab-txt2">Repoted Case</td>-->
				<?php
				  // Total rating
					$query_rating="SELECT SUM(driver_rateing) as rating, COUNT(driver_rateing) as countRate FROM `trip` 
					where `trip`.driver_id='".$row1["id"]."' and `trip`.account_type='99' AND `trip`.trip_mode = 'complete'";
					$result_rating= mysql_query($query_rating);
					$data_rating = mysql_fetch_array($result_rating);
					if($data_rating['countRate']>0){
					$total_rating = $data_rating['rating']/$data_rating['countRate'];
					$rating = (int)($total_rating);
					}
					else{
					$rating = '0';	
					}
				?>
                <td class="tab-txt2"><?php echo $rating."<br>";?></td>
                <td class="tab-txt2"><a href="view_driver_user.php?a=<?php echo base64_encode($row1["id"]);?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
              </tr>
			<?php } } }else{?>
				<tr>
                    <td style="color: red; padding: 10px;" colspan="7"> ningún record fue encontrado</td>
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

<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>'},function(data){
	var obj = jQuery.parseJSON(data);
	console.log(obj.Active);
var visitChart = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container1',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Número de visitantes de la semana pasada",
                "subCaption": "Bakersfield Central vs Los Angeles Topanga",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "paletteColors": "#0075c2,#1aaf5d,#FD5403,#8c7bb6",
                "bgcolor": "#ffffff",
                "showBorder": "0",
                "showShadow": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "legendBorderAlpha": "0",
                "legendShadow": "0",
                "showAxisLines": "0",
                "showAlternateHGridColor": "0",
                "divlineThickness": "1",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "xAxisName": "Day",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "Jan" }, 
                        { "label": "Feb" }, 
                        { "label": "Mar" },
                        { "label": "Apr" }, 
                        { "label": "May" }, 
                        { "label": "Jun" }, 
                        { "label": "Jul" }, 
                        { "label": "Aug" }, 
                        { "label": "Sep" }, 
                        { "label": "Oct" }, 
                        { "label": "Nov" }, 
                        { "label": "Dec" }
                    ]
                }
            ],
            "dataset": [
			
                {
                    "seriesname": "Activar Taxi",
                    "data": obj.Active.Active
                },
                {
                    "seriesname": "Desactivar Taxi",
                    "data":  obj.INActive.INActive
                }, 
                {
                    "seriesname": "Viajes completados de todos los taxis",
                    "data": obj.completed.completed
                    
                }, 
                {
                    "seriesname": "Viajes no completados de todo los taxis",
                    "data": obj.cancle_trip.cancle_trip
					
                }, 
                {
                    "seriesname": "Total Quejas",
                    "data":obj.reported.reported
                }
            ], 
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "17022",
                            "color": "#6baa01",
                            "valueOnRight": "1",
                            "displayvalue": "Average"
                        }
                    ]
                }
            ]
        }
    
    }).render();

	});
	
});
</script>