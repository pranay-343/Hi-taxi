<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style>.tab-txt1{padding: 10px 7px !important;}</style>



    <body class="test3">
    <?php include '../include/zone-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
        
          <h2 class="txt-style-3">Taxi Companies</h2>
          <?php 
		  /*$query1="SELECT SUM(trip_ammount) AS totalAmount FROM `trip`";
		  $querysql1=mysql_query($query1);
		  $row=mysql_fetch_array($querysql1);
		  ?>
          <strong class="txt-style-3">SALDO DE LA CUENTA:</strong><?php echo $row['totalAmount'];*/?>
          <?php 
					//echo $ee=$row['web_user_id'];
					// Avg total complete trip payment
					$str2="SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
                          LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' $zoneTitle $date and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
                          $res2=mysql_query($str2);
                          /*if(mysql_affected_rows($res2)>0)
                          {*/
							   while($row2=mysql_fetch_array($res2))
                  {
				  
					$query_complete_t_payment2 = "SELECT driver.id ,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, SUM(trip.trip_ammount) as total_amt FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row2['web_user_id']."' AND trip.status ='500'";
					$result_c_t_payment2 =  mysql_query($query_complete_t_payment2);
					$row_c_t_payment2 = mysql_fetch_assoc($result_c_t_payment2);
				    $total_amt2+=$row_c_t_payment2['total_amt'];
				  }
						  /*}*/
					?>
          <h2 class="txt-style-3" style="font-size: 14px;">Account Balance:<span style="font-weight: normal;"><?php echo CURRENCY.$total_amt2?></span></h2>
          <form action="" method="POST">
            <div class="row bts">
             <div class="col-sm-4">
                <div class="form-group">
                  <label> Taxi Central </label>
                  <input type='text' id="text" class='input-style' placeholder="Taxi Central" name="text"  value="<?php echo $_POST['text'];?>"/>
                  </div>
                  </div>
               <?php
                /*$date = new DateTime('2016-04-14', new DateTimeZone('Pacific/Nauru'));
                echo $date->format('Y-m-d H:i:sP') . "\n";                echo '</br>';

                $date->setTimezone(new DateTimeZone('Asia/Kolkata'));
                echo $date->format('Y-m-d H:i:sP') . "\n"; echo '</br>';*/
                //echo date('Y-m-d H:i:s').'--------';
                
                /*$date1 = date('Y-m-d H:i:s');
                $date = date_create($date1, timezone_open('Asia/Kolkata'));
                //$date2 = date_create($date1, timezone_open('America/Mexico_City'));
                $date2 = date_timezone_set($date1, timezone_open('Pacific/Chatham'));
                echo date_format($date, 'Y-m-d H:i:sP') . "\n";
                echo '</br>'.'---- ';
                echo date_format($date2, 'Y-m-d H:i:sP') . "\n";
                
                echo '---------------------'.date_default_timezone_set("America/Los_Angeles");*/
            /*$curr_datee= date('Y-m-d');   
            $date=date_create($curr_datee,timezone_open("Asia/Kolkata"));
            echo date_format($date,"Y-m-d H:i:sP") . "<br>";

            $date111=  date_timezone_set($date,timezone_open("America/Mexico_City"));
            echo date_format($date,"Y-m-d H:i:s");
            print_r($date111);*/
               
                $ip = $_SERVER;
                //echo '<pre>';print_r($ip);
                ?> 
                
              <div class="col-sm-4">
                <div class="form-group">
                  <label> From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="From Date" name="fromDate" id="fromDate" value="<?php echo $_POST['fromDate'];?>" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="To Date" name="toDate" id="toDate" value="<?php echo $_POST['toDate'];?>" />
                </div>
              </div>
            </div>
            <div class="row bts zone_btn_setting">
              <div class="col-sm-6">
                <button class="dash-button hvr-wobble-horizontal w100 wap" name="submit" type="submit" id="chartId">Search</button>
              </div>
                <div class="col-sm-6">
                    <a href="<?php echo ZONE_URL?>add-taxi-company.php" style="color:#333;" class="dash-button hvr-wobble-horizontal w100 wap">Create Central</a>
                </div>
            </div>
              
          </form>
          <br/>
          <div class="c-acc-status mg5 bst" style="border:none;">
          <?php //echo'<pre>';print_r($_SESSION);


                           if (isset($_POST['submit'])) {
							  
							  if($_POST['text']!='' && $_POST['fromDate']!='' && $_POST['toDate']!='')
							  	{ 
                            echo '<p># Buscar: <strong>"'.$_POST['text'].'"  "'.$_POST['fromDate'].'"  "'.$_POST['toDate'].'" </strong><p>';
								}
							else
								{
									$s = '"';
									if($_POST['text']!='')
										{
											$text = $s.$_POST['text'].$s;
											}
									else
										{
											$text = "";
											}
									
									if($_POST['fromDate']!='')
										{
											$fromDate = $s.$_POST['fromDate'].$s;
											}
									else
										{
											$fromDate = "";
											}
											
									if($_POST['toDate']!='')
										{
											
											$toDate = $s.$_POST['toDate'].$s;
											}
									else
										{
											$toDate = "";
											}				
											
									 echo "<p># Buscar: <strong>$text $fromDate $toDate </strong><p>";				
								}	
								
                              //(base64_encode($_POST['txtname']));
                              if ($_POST['text'] != '') {
                                  $zoneTitle = " AND taxicompany.name LIKE '%" .($_POST['text']) . "%'";
                              }

                            if($_POST['fromDate'] != '' && $_POST['toDate'] != '')
                            {
                           $date = "AND taxicompany.added_on between '".date('Y-m-d',strtotime($_POST['fromDate']))."' AND  '".date('Y-m-d',strtotime($_POST['toDate']))."'+ INTERVAL 1 DAY";
                            }
                        }
                        else
                            {
                                    $zoneTitle = '';
                                    $date = '';
                            }
                          $str="SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login` LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' $zoneTitle $date and (account_type='4' OR account_type='6') AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
                          $res=mysql_query($str);
                          if(mysql_affected_rows()>0)
                          {
                        
          ?>
          
              <table width="100%" id="viewAdministrator" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                            <th width="20%" class="tab-txt1">Name</th>
                            <th width="20%" class="tab-txt1">CORPORATE / NORMAL TRAVEL TRIP</th>
                            <th width="20%" class="tab-txt1">AVERAGE PAYMENTS</th>
                            <th width="20%" class="tab-txt1">TAXI SERV ACTIVE / INACTIVE</th>
                            <th width="20%" class="tab-txt1">COMPLETED SERVICES</th>
                            <th width="20%" class="tab-txt1">CANCELED</th>
                            <th width="20%" class="tab-txt1">Reported Taxi</th>
                            <th width="20%" class="tab-txt1">Average</th>
                            <!--<th width="20%" class="tab-txt1">Promedio de Pago</th>-->
                            <th width="30%" class="tab-txt1">Action</th>
<!--                            <th width="20%" class="tab-txt1">Ver</th>                            
                            <th width="30%" class="tab-txt1">Editar</th>-->
                        </tr>
                   
                  <?php
                  while($row=mysql_fetch_array($res))
                  {
                      $getDriver = "SELECT id as driverId FROM driver WHERE added_by = '".$row['web_user_id']."'";
                      $res_Driver = mysql_query($getDriver);
                      if(mysql_num_rows($res_Driver) > 0){
                      while ($res_Data = mysql_fetch_array($res_Driver)) {
                          $driver_id[] = $res_Data['driverId'];
                      }
                  $idDri = implode(",",$driver_id);}
                     // print_r($idDri);
                      
                      
					$linkss = '<a href="'.ZONE_URL.'Edit-taxi-company.php?a=' . base64_encode($row['id']) . '"><span class="fa fa-pencil fa_iconm1"></span>&nbsp;&nbsp;</a> &nbsp;&nbsp;&nbsp;&nbsp;';
					$link_view = '<a href="'.ZONE_URL.'view-taxi-company.php?a=' . base64_encode($row['id']) . '"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a>';
                    ?>
                        <tr>
                    
                    <td  class="tab-txt2"><?php echo $row['name']; ?></td>
					<?php 
          // for corporate trip 
         // echo "select id from `trip` where `trip`.driver_id IN ($idDri) and `account_type` ='99'";
          if($driver_id != "")
          {
          $user99=mysql_query("select id from `trip` where `trip`.driver_id IN ($idDri) and `account_type` ='99'");
          $user99_rows = mysql_num_rows($user99);
          }
          else
          {
             $user99_rows = "0" ;
          }
          // for corporate trip 
         // echo "select id from `trip` where `trip`.driver_id = '".$row['driverId']."' and `account_type` ='99'";
         
          if($idDri != "")
          {
          $user7=mysql_query("select id from `trip` where `trip`.driver_id IN ($idDri) and `account_type` ='7'");
          $user7_rows = mysql_num_rows($user7);
          }
          else
          {
             $user7_rows = "0" ;
          }

           if($idDri != "")
            {
            //  echo "select id,trip_ammount from `trip` where `trip`.driver_id = '".$row['driverId']."' ";
            $count_trip=mysql_query("select id,trip_ammount from `trip` where `trip`.driver_id IN ($idDri)");
            $count_trip1 = mysql_num_rows($count_trip);
            if($count_trip1 == "0")
            {
              $count_trip1 ="1";
            }
            while($count_trip2=mysql_fetch_array($count_trip))
            {
              $trip_ammount123 += $count_trip2['trip_ammount'];
            }
              $count_trip3 = CURRENCY.round($trip_ammount123 / $count_trip1);
            }
            else
            {
               $count_trip3 = "0" ;
            }

          ?>
          <td  class="tab-txt2"><?php echo $user99_rows; ?> / <?php echo $user7_rows; ?></td>
          <td  class="tab-txt2"><?php echo $count_trip3; ?></td>
          <?php
          

					// active taxi total sum query
					$query_active_taxi =mysql_num_rows(mysql_query("SELECT driver.id,driver.status,driver.name FROM driver WHERE added_by ='".$row['web_user_id']."' AND status ='200'"));								
					// Inactive taxi total sum query
					$query_inactive_taxi =mysql_num_rows(mysql_query("SELECT driver.id,driver.status,driver.name FROM driver WHERE added_by ='".$row['web_user_id']."' AND (status ='400' || status ='404')"));								
					?>
					<td class="tab-txt2"><?php echo $query_active_taxi.' / '.$query_inactive_taxi;?></td>
					
					<?php // Complete Trips services
					 $query_complete_trips = mysql_num_rows(mysql_query("SELECT driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row['web_user_id']."' AND trip.status ='500'"));
					?>
					<td class="tab-txt2"><?php echo $query_complete_trips;?></td>
					
					<?php // Canceled Trips services
					$query_cancle_trips = mysql_num_rows(mysql_query("SELECT driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row['web_user_id']."' AND trip.status ='600'"))
					?>
					<td class="tab-txt2"><?php echo $query_cancle_trips;?></td>
					
					<?php // Reported Trips services
					$query_reported_trips = mysql_num_rows(mysql_query("SELECT driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row['web_user_id']."' AND trip.status ='600'"));
					
					?>
					<td class="tab-txt2"><?php echo $query_reported_trips;?></td>
					
					<?php 
					// Average wait time
					$query_average_time = "SELECT driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, trip.trip_acceptTime FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row['web_user_id']."' AND trip.status ='500' AND trip.trip_acceptTime!='0000-00-00 00:00:00'";
					$result_average_time = mysql_query($query_average_time);
					$num_rows = mysql_num_rows($result_average_time);
					
					if($num_rows>0){
						while($data_rows = mysql_fetch_array($result_average_time)){
							$start_time = date('H:i', strtotime($data_rows['tripdatetime']));
							$end_time = date('H:i', strtotime($data_rows['trip_acceptTime']));
							
							//echo $start_time.'!!!';
							//echo $end_time.'@@';
							$trip_request_time = strtotime($start_time);
							$accept_time = strtotime($end_time);							
							$diff = $accept_time - $trip_request_time;
							$total_time_sum += $diff;													
						}
						
						 $average_time = $total_time_sum/$num_rows;
						$y = intval($average_time);
            		
					}
					?>
					<td class="tab-txt2"><?php echo gmdate("H:i",$y);?></td>
					<?php 
					//echo $ee=$row['web_user_id'];
					// Avg total complete trip payment					
					$query_complete_t_payment = "SELECT driver.id ,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, SUM(trip.trip_ammount) as total_amt FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row['web_user_id']."' AND trip.status ='500'";
					$result_c_t_payment =  mysql_query($query_complete_t_payment);
					$row_c_t_payment = mysql_fetch_assoc($result_c_t_payment);
				    $total_amt =$row_c_t_payment['total_amt'];
					?>
					<!--<td class="tab-txt2"><?php if($total_amt){echo CURRENCY.$total_amt;}else{echo CURRENCY.'0';}?></td>-->
					<td class="tab-txt2"><?php echo $link_view.'  '.$linkss;;?></td>
<!--                    <td class="tab-txt2"><?php echo $linkss;?></td>-->
                 
                  </tr>
                 
                  
                    <?php
                  } 
				  ?>
				   </thead>
                  </table>                                
                <?php
                } 
                else
                {
                  ?>
                   <table width="100%" id="viewAdministrator" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                    <thead>
                        <tr>
                            <th width="5%" class="tab-txt1">#</th>
                            <th width="20%" class="tab-txt1">Name</th>
                            <th width="20%" class="tab-txt1">Address</th>
                            <th width="10%" class="tab-txt1">Country</th>
                            <th width="10%" class="tab-txt1">Contact Number</th>
                            <th width="10%" class="tab-txt1">Cost per week</th>
                            <th width="15%" class="tab-txt1">Work limit</th>
                            <th width="30%" class="tab-txt1">Action</th>
                        </tr>
                    </thead>
                  
                  <?php
                  echo "<tr>";
                  echo "<td style='color:red;padding:10px;' colspan='8'>No Record Found</td>";
                  echo "</tr>";
                }
                  ?>  
                </table> 
            </div>
          
        <h2 class="txt-style-3 txt-style-31">Services</h2>        
        <div class="row bst tre">        	
            <div class="col-sm-12">
                <div id="chart-container-can-com-reported">Fusion Charts Here­</div>            
            </div>
        </div>
        <br/>
        

        <h2 class="txt-style-3 txt-style-31">Triggered alarms</h2>        
        <div class="row bst tre">         
            <div class="col-sm-12">
                <div id="chart-container-alarams">Fusion Charts Here­</div>                    
            </div>
        </div>
        <br/>
           
        <h2 class="txt-style-3 txt-style-31">Travel time</h2>
        
        <div class="row bst tre">
          
        <div class="col-sm-12">
        <div id="average_time_taxi">Fusion Charts Here</div></div>
        </div>
        <br/>
        
        
        
        <h2 class="txt-style-3 txt-style-31">Average rating drivers </h2>        
        <div class="row bst tre">          
        <div class="col-sm-12">
            <div id="chart-container-dr-rating">Fusion Charts Here</div>                
        </div>
        </div>
        <br/>
        
        <h2 class="txt-style-3 txt-style-31">Average payment</h2>
       
        <div class="row bst tre">
         <div class="col-sm-12">
        <div id="chart-container-avg-payment">Fusion Charts Here</div></div>
        </div>
        <br/>
        
        <h2 class="txt-style-3 txt-style-31">Corporate Travel vs normal travel</h2>
        
        <div class="row bst tre">
         
        <div class="col-sm-12">
            <div id="chart-container-crop-user">Fusion Charts Here</div></div>
        </div>
        <br/>
        
 <!-- dinesh -->         
           <div class="c-acc-status mg5">
         <h2 class="txt-style-3">Business information</h2>
         <form>
         <div class="row">
         <div class="col-sm-9">
         	<div class="form-group">
            <label> <strong>THE TOTALS FOR THE SELECTED FILTERS</strong> </label>
            </div>
            </div>
            <div class="col-sm-3">
         	<div class="form-group">
             <?php 
					//echo $ee=$row['web_user_id'];
					// Avg total complete trip payment
					 $str3="SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
                          LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' $zoneTitle $date and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
                          $res3=mysql_query($str3);
                          /*if(mysql_affected_rows($res2)>0)
                          {*/
							   while($row3=mysql_fetch_array($res3))
                  {
				  
					$query_complete_t_payment3 = "SELECT driver.id ,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, SUM(trip.trip_ammount) as total_amt FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by ='".$row3['web_user_id']."' AND trip.status ='500'";
					$result_c_t_payment3 =  mysql_query($query_complete_t_payment3);
					$row_c_t_payment3 = mysql_fetch_assoc($result_c_t_payment3);
				    $total_amt3+=$row_c_t_payment3['total_amt'];
				  }
						  /*}*/
					?>
          
            <label> <strong>Complete:</strong><?php echo CURRENCY.$total_amt3?></label>
            </div>
            </div>
            </div>
            
         </form>
          <br/><br/>
         
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<script type="text/javascript">
// $(document).ready(function (){
//    // Array holding selected row IDs
//    var rows_selected = [];
//    var table = $('#viewAdministrator').DataTable({
//       'ajax': {
//          'url': "getData.php?mode=<?php echo base64_encode('getTaxiCompanyCentralDetails'); ?>" 
//       },
//       'columnDefs': [{
//          'searchable': false,
//          'orderable': false,
//          'className': 'dt-body-center',
//          'render': function (data, type, full, meta){
//              return '';
//          }
//       }],
//       'order': [[0, 'asc']]
//    });
// });

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
    //average_time_taxi
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart4 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-can-com-reported',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Number of completed services",
                    "data": obj.completed.completed
                }, 
                {
                    "seriesname": "Number of canceled services",
                    "data": obj.cancle_trip.cancle_trip          
                }, 
                {
                    "seriesname": "Number of reported services",
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart2 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-alarams',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Number of active alarms",
                    "data":  obj.averageAlerted.averageAlerted
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
	var obj = jQuery.parseJSON(data);
	console.log(obj.Active);
var visitChart = new FusionCharts({
        type: 'msline',
        renderAt: 'average_time_taxi',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
			
                {
                    "seriesname": "Average waiting time",
                    "data": obj.averageTimeed.averageTimeed
                },
                {
                    "seriesname": "Average travel time",
                    "data":  obj.averageTripTimeed.averageTripTimeed
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart5 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-dr-rating',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "star rating",
                    "data": obj.averageRatinged.averageRatinged
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart6 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-avg-payment',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Average Payment",
                    "data":obj.averagePaymented.averagePaymented
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
<script>
FusionCharts.ready(function () {
var obj ='';
$.post('getData.php',{mode:'<?php echo base64_encode('getAllDetails');?>',id1:'chartId',fromDate:'<?php echo $_POST['fromDate'];?>',toDate:'<?php echo $_POST['toDate'];?>',text:'<?php echo $_POST['text'];?>'},function(data){
  var obj = jQuery.parseJSON(data);
  console.log(obj.Active);
var visitChart7 = new FusionCharts({
        type: 'msline',
        renderAt: 'chart-container-crop-user',
        width: '966',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "",
                "subCaption": "",
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
                "xAxisName": "Months",
                "showValues": "0"               
            },
            "categories": [
                {
                    "category": [
                        { "label": "January" }, 
                        { "label": "February" }, 
                        { "label": "March" },
                        { "label": "April" }, 
                        { "label": "May" }, 
                        { "label": "June" }, 
                        { "label": "July" }, 
                        { "label": "August" }, 
                        { "label": "September" }, 
                        { "label": "October" }, 
                        { "label": "November" }, 
                        { "label": "December" }
                    ]
                }
            ],
            "dataset": [
                {
                    "seriesname": "Corporate travel",
                    "data":obj.corporated.corporated
                },
                {
                    "seriesname": "Normal travel",
                    "data":obj.userapped.userapped
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

