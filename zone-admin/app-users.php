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
          <h2 class="txt-style-3">App Users�n</h2>
          <form>
            <div class="row bts">
              <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                  <label> From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date"  />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End State"  />
                </div>
              </div>
              <div class="col-sm-4 col-sm-offset-4">
                <button class="dash-button hvr-wobble-horizontal w100 wap">Search</button>
              </div>
              
            </div>
          </form>
          <br/>
         <?php /*?>
          <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        
          <!--<div align="center" class="i100"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
		  <div  align="center" class="i100" id="chart-container1" >FusionCharts rendirán aquí</div>
           <br/>
            <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        
          <!--<div align="center" class="i100"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
      <div  align="center" class="i100" id="chart-container2" >FusionCharts rendirán aquí</div>
           <br/>
            <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        
          <!--<div align="center" class="i100"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
      <div  align="center" class="i100" id="chart-container3" >FusionCharts rendirán aquí</div>
           <br/>
            <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        
          <!--<div align="center" class="i100"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
      <div  align="center" class="i100" id="chart-container4" >FusionCharts rendirán aquí</div>
           <br/>
            <h2 class="txt-style-3 txt-style-31">Datos y estadísticas</h2>
         <p class="txt-style-6">
         Nº de Taxi Centrale, Taxi (activo / inactivo), Servicios de Quejas, cancelado, informó, alertas, media: $ Viajes, Taxi Tiempo de retardo, la marca que le dan los taxistas, pedidos de acuerdo a la tecnología
         </p>
        
          <!--<div align="center" class="i100"> <img src="../images/c1.jpg" alt="" title="" /> </div>-->
      <div  align="center" class="i100" id="chart-container5" >FusionCharts rendirán aquí</div>
           <br/>--><?php */?>
         <h2 class="txt-style-3 txt-style-31">User List</h2>
         <form action="" method="post">
             <div class="row bts1">
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label> Name </label>
                         <input type='text' class='input-style' name="txtDriverName" placeholder="Driver Name"  value="<?php echo $POST['txtDriverName'] ?>"/>
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label> Contact number. </label>
                         <input type='text' class='input-style' name="txtContact" placeholder="Contact Number" value="<?php echo $POST['txtContact'] ?>"/>
                     </div>
                 </div>
                 <div class="col-sm-4">
                     <div class="form-group">
                         <label> Email </label>
                         <input type='text' class='input-style' name="txtEmail" placeholder="Email" value="<?php echo $POST['txtEmail'] ?>"/>
                     </div>
                 </div>
                <!-- <div class="col-sm-3">
                     <div class="form-group">
                         <label> Id controlador </label>
                         <input type='text' class='input-style' name="txtDriverId" placeholder="Introduzca texto aquí" value="<?php echo $POST['txtDriverId'] ?>"/>
                     </div>
                 </div>
                 <div class="col-sm-3">
                     <div class="form-group">
                         <label> Número de coches Taxi </label>
                         <input type='text' class='input-style' name="txtCarPlate" placeholder="Introduzca texto aquí" value="<?php echo $POST['txtCarPlate'] ?>"/>
                     </div>
                 </div>-->
                 <div class="clearfix"></div>
                 <div class="col-sm-4 col-sm-offset-4 f74">
                     <button class="dash-button hvr-wobble-horizontal w100 wap" type ="submit" name="submit"><i class="fa fa-search"></i>Search</button>
                 </div>
             </div>
         </form>
           <br/><br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="15%" class="tab-txt1">USER</th>
                <th width="15%" class="tab-txt1">LAST CONNECTION </th>
                <th width="15%" class="tab-txt1">FINISHED</th>
                <th width="15%" class="tab-txt1">CANCELED</th>
                <th width="15%" class="tab-txt1">REPORTED</th>
                <th width="15%" class="tab-txt1">AVERAGE RATING</th>
                <th width="10%" class="tab-txt1">MORE DATA</th>
              </tr>
              <?php
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
						$email = " AND `driver`.email LIKE '%" . ($_POST['txtEmail']) . "%'";
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
			  
			   
              /*$str="SELECT `trip`.trip_type,`trip`.customer_id,`trip`.driver_id,`users`.account_type,`users`.id as userid,`users`.name as username,`driver`.company_id,`taxicompany`.web_user_id,`login`.id,`login`.name FROM `trip`
              LEFT JOIN `users` ON `trip`.customer_id=`users`.id
              LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id
              LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
              LEFT JOIN `login` ON `driver`.company_id=`login`.id where `trip`.trip_type='userapp' and `users`.account_type='7' and `taxicompany`.added_by='".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."' $name $contact $email $liecence_number $vehicle_number group by userid";
              $res=mysql_query($str);
              if(mysql_affected_rows()>0)
              {
              while($row=mysql_fetch_array($res))
              {*/
			// ALL driver detail show
                
                        // For get central company
                        $str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '" . $_SESSION['uid'] . "' and account_type='4' AND zone_area_id_sess = '" . $_SESSION['zoneArea'] . "'";
                        $res = mysql_query($str);
                        if (mysql_affected_rows() > 0) {
                        $getcentral = '';
                        while ($row = mysql_fetch_array($res)) {
                            $getcentral .= $row['web_user_id'] . ',';
                        }
                        $getcentral = rtrim($getcentral, ',');
                        }
                        
                        // For get corporation company
                        $get_corp_company = "SELECT id,name FROM login WHERE added_by ='$getcentral'";
                        $res_corp_company = mysql_query($get_corp_company);
                        if (mysql_affected_rows() > 0) {
                        $getcropIds = '';
                        while ($row = mysql_fetch_array($res_corp_company)) {
                            $getcropIds .= $row['id'] . ',';
                        }
                        $getcropIds = rtrim($getcropIds, ',');
                        }
                        
                        if(isset($getcropIds)){
                        $sql_crop_user = "SELECT users.id,users.name,trip.customer_id,trip.driver_id,trip.id as trId,trip.tripdatetime FROM users LEFT JOIN trip ON users.id = trip.customer_id WHERE users.added_by in ($getcropIds) GROUP BY trip.customer_id ORDER BY trip.id DESC";
                        $res_result = mysql_query($sql_crop_user);
                         $rows_users = mysql_num_rows($res_result);
                         if($rows_users >0 ){
                             
                        /* }
     $query_driver = "SELECT `trip`.trip_type,`trip`.customer_id,`trip`.driver_id, driver.*, `users`.id as userid,`users`.name as userName, zone_cordinater.id as zoneId, zone_cordinater.zone_area_id,zone_cordinater_driver.id as zoneDId, zone_cordinater_driver.cordinate_title as zoneDname  FROM trip 
			LEFT JOIN driver ON trip.driver_id = driver_id
			LEFT JOIN users ON trip.customer_id = users.id
			LEFT JOIN zone_cordinater ON driver.zone_primary_id = zone_cordinater.zone_area_id			
			LEFT JOIN zone_cordinater_driver ON driver.zone_id = zone_cordinater_driver.id 
			WHERE zone_cordinater.zone_area_id =  '".$_SESSION['zoneArea']."' GROUP BY driver.id $name $contact $email $liecence_number $vehicle_number";
			$result_driver = mysql_query($query_driver);
			$rows_driver = mysql_num_rows($result_driver);
			if($rows_driver >0 ){*/
			while($data = mysql_fetch_array($res_result)){		
				  
				//Last Trip dtail 
                 $str_trip="SELECT `trip`.customer_id,`trip`.driver_id,`trip`.tripdatetime,trip.id FROM `trip` where `trip`.customer_id='".$data['id']."' ORDER by `trip`.id DESC LIMIT 1";
                $res_trip=mysql_query($str_trip);
                $row_trip=mysql_fetch_array($res_trip);
               // $num0=mysql_num_rows($res0);

                
		//  Total complete trip by driver
                $str_complete_trip="SELECT `trip`.customer_id,`trip`.driver_id,`trip`.tripdatetime,trip.id FROM `trip`  where `trip`.customer_id='".$data['id']."' and `trip`.status='500'";
                $res_complete_trip=mysql_query($str_complete_trip);
                $num_complete_trip=mysql_num_rows($res_complete_trip);

                // Total cancle trip status
                $str_cancle_trip="SELECT `trip`.customer_id,`trip`.driver_id,`trip`.tripdatetime FROM `trip` where `trip`.customer_id='".$data['id']."' and `trip`.status='600'";
                $res_cancle_trip=mysql_query($str_cancle_trip);
                $num_cancle_trip=mysql_num_rows($res_cancle_trip);

                // Reported trip by 
                $str_reported_trip="SELECT `trip`.customer_id,`trip`.driver_id,`trip`.tripdatetime,trip.id FROM `trip` where `trip`.customer_id='".$data['id']."'  AND `trip`.customer_rating <= 2";
                $res_reported_trip=mysql_query($str_reported_trip);
                $num_reported_trip=mysql_num_rows($res_reported_trip);

                // Total ratings by trip
                $str_rating="select trip.id, trip.customer_rating,trip.driver_id from trip where customer_id='".$data['id']."'";
                $res_rating=mysql_query($str_rating);
                $num_rating=mysql_num_rows($res_rating);
                $row_rating=mysql_fetch_array($res_rating);				
                $ab[]=$row_rating['customer_rating'];
                $total_rating = 'No rating';
                if($num_rating>0){
                $sum=array_sum($ab);
                $total_rating =$sum/$num_rating;
                }
              ?>
              <tr>
                <td class="tab-txt2"><?php echo $data ['name'];?></td>
                <td class="tab-txt2"><?php echo $row_trip['tripdatetime'];?></td>
                <td class="tab-txt2"><?php echo $num_complete_trip;?></td>
                <td class="tab-txt2"><?php echo $num_cancle_trip;?></td>
                <td class="tab-txt2"><?php echo $num_reported_trip;?></td>
                <td class="tab-txt2"><?php echo $total_rating; ?></td><??>
                <td class="tab-txt2"><a href="<?php echo ZONE_URL?>view-app-user.php?id=<?php echo base64_encode($data['id']); ?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
              </tr>
              <?php 
               }
               }}
              else
              {
                  echo "<tr>";
                  echo "<td style='color:red;padding:10px;' colspan='8'>No Record Found</td>";
                  echo "</tr>";
              } 
              ?>
              <!-- <tr>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2">test</td>
                <td class="tab-txt2"><a href="<?php echo ZONE_URL?>view-app-user.php">( + )</a></td>
              </tr> -->
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
                "caption": "Activar taxi",
                // "subCaption": "Bakersfield Central vs Los Angeles Topanga",
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
                }
                // {
                //     "seriesname": "Desactivar Taxi",
                //     "data":  obj.INActive.INActive
                // }, 
                // {
                //     "seriesname": "Viajes completados de todos los taxis",
                //     "data": obj.completed.completed
                    
                // }, 
                // {
                //     "seriesname": "Viajes no completados de todo los taxis",
                //     "data": obj.cancle_trip.cancle_trip
					
                // }, 
                // {
                //     "seriesname": "Total Quejas",
                //     "data":obj.reported.reported
                // }
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart2 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container2',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Desactivar taxi",
                // "subCaption": "Bakersfield Central vs Los Angeles Topanga",
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
      
                // {
                //     "seriesname": "Activar Taxi",
                //     "data": obj.Active.Active
                // },
                {
                    "seriesname": "Desactivar Taxi",
                    "data":  obj.INActive.INActive
                } 
                // {
                //     "seriesname": "Viajes completados de todos los taxis",
                //     "data": obj.completed.completed
                    
                // }, 
                // {
                //     "seriesname": "Viajes no completados de todo los taxis",
                //     "data": obj.cancle_trip.cancle_trip
          
                // }, 
                // {
                //     "seriesname": "Total Quejas",
                //     "data":obj.reported.reported
                // }
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart3 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container3',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Viajes completados de todos taxis",
                // "subCaption": "Bakersfield Central vs Los Angeles Topanga",
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
      
                // {
                //     "seriesname": "Activar Taxi",
                //     "data": obj.Active.Active
                // },
                // {
                //     "seriesname": "Desactivar Taxi",
                //     "data":  obj.INActive.INActive
                // }, 
                {
                    "seriesname": "Viajes completados de todos los taxis",
                    "data": obj.completed.completed
                    
                }
                // {
                //     "seriesname": "Viajes no completados de todo los taxis",
                //     "data": obj.cancle_trip.cancle_trip
          
                // }, 
                // {
                //     "seriesname": "Total Quejas",
                //     "data":obj.reported.reported
                // }
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart4 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container4',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Viajes no completados de todo los taxis",
                // "subCaption": "Bakersfield Central vs Los Angeles Topanga",
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
      
                // {
                //     "seriesname": "Activar Taxi",
                //     "data": obj.Active.Active
                // },
                // {
                //     "seriesname": "Desactivar Taxi",
                //     "data":  obj.INActive.INActive
                // }, 
                // {
                //     "seriesname": "Viajes completados de todos los taxis",
                //     "data": obj.completed.completed
                    
                // }, 
                {
                    "seriesname": "Viajes no completados de todo los taxis",
                    "data": obj.cancle_trip.cancle_trip
          
                }
                // {
                //     "seriesname": "Total Quejas",
                //     "data":obj.reported.reported
                // }
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart5 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container5',
        width: '550',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Total Quejas",
                // "subCaption": "Bakersfield Central vs Los Angeles Topanga",
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
      
                // {
                //     "seriesname": "Activar Taxi",
                //     "data": obj.Active.Active
                // },
                // {
                //     "seriesname": "Desactivar Taxi",
                //     "data":  obj.INActive.INActive
                // }, 
                // {
                //     "seriesname": "Viajes completados de todos los taxis",
                //     "data": obj.completed.completed
                    
                // }, 
                // {
                //     "seriesname": "Viajes no completados de todo los taxis",
                //     "data": obj.cancle_trip.cancle_trip
          
                // }, 
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