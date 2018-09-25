<?php
include("../include/define.php"); 
$mode = base64_decode($_REQUEST['mode']);
if($mode == 'getTaxiCompanyCentralDetails')
{
	$query="select * from `login` where 1 and account_type = '4'";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
	$linkss = '<a href="'.ZONE_URL.'Edit-taxi-company.php?a=' . base64_encode($row['id']) . '"><img src="../images/edit.png" alt="" title="" /></a>';
	$seeMore = '<a href="'.ZONE_URL.'taxi-company-file.php">( + )</a>';
	$location[]=array($row['name'],'100/30','100','20','120','2.4 Mins','300.000 MX',$seeMore,$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));
}

if($mode == 'deleteZonesAdministrator')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select id from `zone_area`  where 1 and allot_to='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	
	$qryDelete = mysql_query("delete from `zone_cordinater`  where 1 and zone_area_id='".$response['id']."'");
	$qryDelete = mysql_query("delete from `zone_area`  where 1 and id='".$response['id']."'");
	$qryDelete = mysql_query("delete from `login`  where 1 and id='".$zoneId."'");
	echo '0';
}

if($mode == 'checkAdminPassword')
{
	$password = md5($_POST['a']);
	$query = mysql_query("select password from `login`  where 1 and id='".$_SESSION['uid']."'");
	$response = mysql_fetch_assoc($query);
	if($response['password'] == $password)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}

if($mode == 'getallDriversDetails')
{
	//$query1 = "SELECT * From `driver` where login_status='1'";
	$query1 = "SELECT * From `driver` LEFT JOIN taxicompany ON driver.company_id = taxicompany.web_user_id `driver` where login_status='1' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'";
	$result1=mysql_query($query1);	    	
	$nj = array();
	$i = '0';
	while($row1 = mysql_fetch_assoc($result1))
	{
		$i++;
		$query2 = "SELECT * From `trip_log` where driver_id='".$row1['id']."'  ORDER BY id desc LIMIT 0,1";
		$result2=mysql_query($query2);
		if(mysql_num_rows($result2) > 0 )
		{
				$row2 = mysql_fetch_assoc($result2);
				$data['latitude'] = $row2['latitude'];
				$data['longitude'] = $row2['longitude'];
				$data['driver_id'] = $row1['id'];
				$data['username'] = $row1['username'];
				$data['mobile'] = $row1['contact_number'];	
		}
		else
		{
			
		}
		$nj[] = $data;
		unset($row2['latitude'],$row2['longitude'],$row2['id'],$row2['username'],$row2['contact_number']);
	}
	echo json_encode($nj);
}


if($mode =='getCentralMonthlyDetails'){
	$id=$_POST['id1'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$po_paid=$_POST['paid'];
	$po_non_paid=$_POST['non_paid'];
	$po_activation=$_POST['activation'];
	$cdate = date("Y-m-d");
	if (isset($id)) { 
		/*if($to_date != '' && $from_date != ''){
			$date = "AND  manage_master_amount.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
		}
		if($_POST['paid']!=''){
			$paid = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['paid']) . "%'";
		}						
		if($_POST['activation']!=''){
			$activation = " OR `manage_master_amount`.amount_type LIKE '%" . ($_POST['activation']) . "%'";
		}*/
		if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
			$date = "AND  manage_master_amount.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
		}
		if($_POST['paid']!=''){
			$paid = " AND  '$cdate' < `manage_master_amount`.end_date_time";
		}
		else if($_POST['non_paid']!=''){
			$non_paid = " AND  '$cdate' > `manage_master_amount`.end_date_time";
		}
		else if($_POST['activation']!=''){
			$activation = " And `manage_master_amount`.amount_type = '". ($po_activation) . "'";
		}
		else if($po_paid!='' && $po_activation!='' && $po_non_paid!=''){
			$paid = " AND `manage_master_amount`.amount_type = '".($po_paid) . "'";
			$activation = " AND `manage_master_amount`.amount_type = '". ($po_activation) . "'";
			$non_paid = " AND `manage_master_amount`.amount_type = '". ($po_non_paid) . "')";
		}
	}
	else{
		$paid = '';
		$non_paid = '';
		$activation = '';
		$date = '';
	}
	$query = "SELECT * FROM taxicompany where 1 and added_by = '".$_SESSION['uid']."' AND zone_area_id_sess = '".$_SESSION['zoneArea']."' ORDER BY added_on DESC ";
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
		$current_date = date('Y-m-d'); 
		if($num_rows>0){
		$total_amt = array();
		while($row = mysql_fetch_array($result)){
			$total_amt = '';
			$amount = $row['per_week_cost']; 
		    $query1 = "SELECT end_date_time, SUM(amount) as totalamount, added_on, zone_id, company_id, corporate_id FROM manage_master_amount where 1 and company_id = '".$row['web_user_id']."' AND zone_id!='' $date $activation $paid $non_paid ORDER BY end_date_time DESC";
			$result1 = mysql_query($query1);
			while($row1 = mysql_fetch_array($result1)){
				if( $row1['end_date_time'] != null || $row1['end_date_time'] != '')
				{
					//$total_amt1 = $row1['totalamount']; 
					$total_amt=$row1['totalamount'];
					$end_activation_date= $row1['end_date_time']; 
					//$total_amt=$total_amt1+$row1['totalamount'];
				}
				else
				{
					$total_amt='0';
				}
					
				}
				if($total_amt != '' || $total_amt != null)
				{
					$centarlName['label'] = $row['name'];
					$centarlName['value'] = $total_amt;	
				}
				
				$njj[] = $centarlName;
			}	
		}
		echo json_encode($njj);
}

if($mode == 'setZoneSession')
{
	$_SESSION['zoneArea'] = $_POST['a'];
	HTMLRedirectURL(ZONE_URL.'index.php');  
}



if($mode == 'getcordeinatesDetails')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select * from `zone_area` where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$title['zone_title']= base64_decode($response['zone_title']);
	$title['zone_description']=base64_decode($response['zone_description']);
	
	$query = "select cordinate_title,cordinated as cordinatess,map_zoom,map_type,zone_type,id as cordinate_id from `zone_cordinater` where 1 and zone_area_id='".$response['id']."'";
	$res = mysql_query($query);
	$reactangle = array();
	$circle = array();
	$line = array();
	$polygon = array();
	while($data = mysql_fetch_assoc($res))
	{
		$dataa['zone_name'][] =array('zone_name'=>$data['zone_type']);
		if($data['zone_type'] == 'circle')
		{
			$dataa['circle'][] =$data;
		}
		
		if($data['zone_type'] == 'line')
		{
			$dataa['line'][] =$data;
		}
		
		if($data['zone_type'] == 'polygon')
		{
			$dataa['polygon'][] =$data;
		}

	}
	$msg['title']=$title;
	$msg['dataa']=$dataa;
	echo json_encode($msg);
}

if($mode == 'getAllDetails'){	
	$id=$_POST['id1'];
	$fromDate=$_POST['fromDate'];
	$toDate=$_POST['toDate'];
	$text=$_POST['text'];
	if (isset($id)) {
		
		$taxicompany = 	"AND taxicompany.name LIKE '%" . $text . "%'";		
		if($fromDate != '' && $toDate != ''){
			$date = "AND  trip.tripdatetime between '".date('Y-m-d',strtotime($fromDate))."' AND  '".date('Y-m-d',strtotime($toDate))."'";
		}
	}
	else{
		$taxicompany = '';
		$date = '';
	}
	$str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."' $taxicompany";
	$res=mysql_query($str);
	if(mysql_affected_rows()>0){
		$getcentral = '';
		while($row=mysql_fetch_array($res)){
		$getcentral .= $row['web_user_id'].',';
		}
		 $getcentral = rtrim($getcentral, ',');
		
			
			// active taxi total record 
			$months=array("January","February","March","April","May","June","July","August","September","October","November","December");
			$currentMonth = date("m");
                        //echo $currentMonth.'-------';
			if( $currentMonth == "01")
			 {
			 	 $currentMonth = "January";
			 }
			 elseif( $currentMonth == "02")
			 {
			      $currentMonth = "February";
			 }
			  elseif( $currentMonth == "03")
			 {
			      $currentMonth = "March";
			 }
			  elseif( $currentMonth == "04")
			 {
			      $currentMonth = "April";
			 } 
			 elseif( $currentMonth == "05")
			 {
			      $currentMonth = "May";
			 }
			  elseif( $currentMonth == "06")
			 {
			      $currentMonth = "June";
			 }
			  elseif( $currentMonth == "07")
			 {
			      $currentMonth = "July";
			 }
			  elseif( $currentMonth == "08")
			 {
			      $currentMonth = "August";
			 } 
			 elseif( $currentMonth == "09")
			 {
			      $currentMonth = "September";
			 }
			  elseif( $currentMonth == "10")
			 {
			      $currentMonth = "October";
			 }
			 elseif( $currentMonth == "11")
			 {
			      $currentMonth = "November";
			 }
			 elseif( $currentMonth == "12")
			 {
			      $currentMonth = "December";
			 }
                         
                         for ($i = 0; $i < count($months); $i++) {
                            if ($months[$i] != $currentMonth) {
                                $query_active_taxi = (mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('" . $getcentral . "') AND status ='200' AND YEAR(CURDATE()) = YEAR(updated_on) GROUP BY datee "));
                                while ($data_active_taxi = mysql_fetch_assoc($query_active_taxi)) {
                                    if ($months[$i] == $data_active_taxi['datee']) {

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_active['month'] = $data_active_taxi['datee'];
                                        $nj_active['value'] = $data_active_taxi['total'];
                                    } else {
                                        $nj_active['month'] = "0";
                                        $nj_active['value'] = "0";
                                    }
                                    $getActive[] = $nj_active;
                                }
                            } else {
                                break;
                            }
                        }       
			$Active['Active'] = $getActive;	
                        
                        
			//Inactive Taxi total record 

			//$months1=array("January","February","March","April","May","June","July","August","September","October","November","December");
			for ($j = 0; $j < count($months); $j++) {
                            if ($months[$j] != $currentMonth) {
                                $query_inactive_taxi = (mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('" . $getcentral . "') AND (status ='400' || status ='404') AND YEAR(CURDATE()) = YEAR(updated_on)  group by datee "));
                                while ($data_inactive_taxi = mysql_fetch_array($query_inactive_taxi)) {
                                    if ($months[$j] == $data_inactive_taxi['datee']) {
                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_inactive['month'] = $data_inactive_taxi['datee'];
                                        $nj_inactive['value'] = $data_inactive_taxi['total'];
                                    } else {
                                        $nj_inactive['month'] = "0";
                                        $nj_inactive['value'] = "0";
                                    }
                                    $inactive[] = $nj_inactive;
                                }
                            } else {
                                break;
                            }
                        }
                        
                        //$nj_inactive['month'] = $data_inactive_taxi['datee'];
			// 	$nj_inactive['value'] = $data_inactive_taxi['total'];
			// 	$inactive[] = $nj_inactive;
			// }
                        
			$Inactivee['INActive'] = $inactive;
                         
			
			// Complete trips // ---- added_by ='".$row['web_user_id']."'
			for ($k = 0; $k <= count($months); $k++) {
                            $data_complete['datee'] = '';
                            $data_complete['total'] = '';
                            if ($months[$k] != $currentMonth || $months[$k] == $currentMonth) {
                                 //echo $months[$k].'-------'.$currentMonth.'<br/>';

                               $njjj = "SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND trip.status ='500' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$k]."' $date group by datee  ORDER BY trip.tripdatetime ASC";
                                $query_complete_trips = mysql_query($njjj);
                                $data_complete = mysql_fetch_array($query_complete_trips);
                                    if (mysql_num_rows($query_complete_trips) > 0)
                                    {
                                        $nj_complete['month'] = $months[$k];
                                        $nj_complete['value'] = $data_complete['total'];
                                        $complete[] = $nj_complete;
                                    } else {  // echo'gfdg';                                     
                                        $nj_complete['month'] = $months[$k];
                                        $nj_complete['value'] = "0";
                                        $complete[] = $nj_complete;
                                    }
                                  
                                
                            } else {
                                break;
                            }
                           
                            $data_complete['datee'] = '';
                            $data_complete['total'] = '';
                        }
                       // print_r($complete);

			$completee['completed'] = $complete;
			
			
			// Canceled Trips services	---- added_by ='".$row['web_user_id']."'
			
			
			
			$cancle_tripee = '';
                        for ($l = 0; $l < count($months); $l++) {
                            
                            $data_cancle['datee'] = '';
                            $data_cancle['total'] = '';
                            if ($months[$l] != $currentMonth || $months[$l] == $currentMonth) {
                                $query_cancle_trips = (mysql_query("SELECT count(trip.id) as total, driver.id,driver.status,driver.name, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('" . $getcentral . "') AND trip.status ='600' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$l]."' $date group by datee  ORDER BY trip.tripdatetime ASC"));
                                $data_cancle = mysql_fetch_array($query_cancle_trips);
                                   // if ($months[$l] == $data_cancle['datee']) {
                                if(mysql_num_rows($query_cancle_trips) > 0){

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_cancle['month'] = $months[$l];
                                        $nj_cancle['value'] = $data_cancle['total'];
                                        $cancle_trip[] = $nj_cancle;
                                    } else {
                                        $nj_cancle['month'] = $months[$l];
                                        $nj_cancle['value'] = "0";
                                        $cancle_trip[] = $nj_cancle;
                                    }
                                //}
                            } else {
                                break;
                            }
                            $data_cancle['datee'] = '';
                            $data_cancle['total'] = '';
                        }
                        // 	$nj_cancle['month'] = $data_cancle['datee'];
			// 	$nj_cancle['value'] = $data_cancle['total'];
			// 	$cancle_trip[] = $nj_cancle;
			// }			
			$cancle_tripee['cancle_trip'] = $cancle_trip;
			
			// Reported Trips services
			for ($u = 0; $u < count($months); $u++) {
                            if ($months[$u] != $currentMonth || $months[$u] == $currentMonth) {
                                $query_reported_trips = (mysql_query("SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, trip.driver_rateing, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$u]."' AND (trip.driver_rateing <='2' AND trip.driver_rateing !='') AND trip.status = '500' $date group by datee  ORDER BY trip.tripdatetime ASC"));
                                while ($data_reported = mysql_fetch_array($query_reported_trips)) {
                                    if ($months[$u] == $data_reported['datee']) {
                                    // if ($data_reported['datee'] != '' || $data_reported['datee'] != null){
                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_reported['month'] = $data_reported['datee'];
                                        $nj_reported['value'] = $data_reported['total'];
                                    } else {                                        
                                    }
                                    $reported[] = $nj_reported;
                                }
                            } else {
                                break;
                            }
                        }
                        // 	$nj_reported['month'] = $data_reported['datee'];
			// 	$nj_reported['value'] = ($data_reported['total']);
			// 	$reported[] = $nj_reported;				
			// }
			$reportedee['reported'] = $reported;
			
			// Total corporate trips
			for ($c = 0; $c <= count($months); $c++) {                            
                            $data_corporate['datee'] = '';
                            $data_corporate['total'] = '';
                            if ($months[$c] != $currentMonth || $months[$c] == $currentMonth) {
                                $query_corporate = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid,trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='corporate' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$c]."' $date group by datee  ORDER BY trip.tripdatetime ASC";
                                    $result_corporate = mysql_query($query_corporate);
                                    $data_corporate = mysql_fetch_array($result_corporate);
                                    if (mysql_num_rows($result_corporate) > 0){       
                                        $nj_corporate['month'] = $months[$c];
                                        $nj_corporate['value'] = $data_corporate['total'];
                                        $corporated[] = $nj_corporate;
                                    } else {
                                        $nj_corporate['month'] = $months[$c];
                                        $nj_corporate['value'] = "0";
                                        $corporated[] = $nj_corporate;
                                    }
                            } else {
                                break;
                            }
                            $data_corporate['datee'] = '';
                            $data_corporate['total'] = '';
                        }
                        $corporatee['corporated'] = $corporated;
			
			// Total userapp trips
                        for ($a = 0; $a <= count($months); $a++) {                           
                            $data_userapp['datee'] = '';
                            $data_userapp['total'] = '';
                            if ($months[$a] != $currentMonth || $months[$a] == $currentMonth) {
                                $query_userapp = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid, trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('" . $getcentral . "') AND trip.trip_type='userapp' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$a]."'  $date group by datee ORDER BY trip.tripdatetime ASC";
                                $result_userapp = mysql_query($query_userapp);
                               $data_userapp = mysql_fetch_array($result_userapp);
                                    if (mysql_num_rows($result_userapp) > 0) {

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_userapp['month'] = $months[$a];
                                        $nj_userapp['value'] = $data_userapp['total'];
                                        $userapped[] = $nj_userapp;
                                    } else {
                                        $nj_userapp['month'] = $months[$a];
                                        $nj_userapp['value'] = "0";
                                        $userapped[] = $nj_userapp;
                                    }
                               
                            } else {
                                break;
                            }
                            
                            $data_userapp['datee'] = '';
                            $data_userapp['total'] = '';
                        }
                        // 	$nj_userapp['month'] = $data_userapp['datee'];
			// 	$nj_userapp['value'] = ($data_userapp['totalTripUserapp']);
			// 	$userapped[] = $nj_userapp;				
			// }
			$userappee['userapped'] = $userapped;
                        
                        
                        // Total Avarage Alerts
                        for ($q = 0; $q <= count($months); $q++) {
                            $data_averageAlertapp['datee'] = '';
                            $data_averageAlertapp['total'] = '';
                            if ($months[$q] != $currentMonth || $months[$q] == $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageAlertapp = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid, trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='corporate'AND trip.customer_rating<=2 and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$q]."' $date group by datee ORDER BY trip.tripdatetime ASC";
                            $result_averageAlertapp = mysql_query($query_averageAlertapp);
                            $data_averageAlertapp = mysql_fetch_array($result_averageAlertapp);{
                                if (mysql_num_rows($result_averageAlertapp) > 0){
                                    
                                    $nj_averageAlertapp['month'] = $months[$q];
                                    $nj_averageAlertapp['value'] = $data_averageAlertapp['total'];
                                    $averageAlerted[] = $nj_averageAlertapp;
                                } else {                                      
                                    $nj_averageAlertapp['month'] = $months[$q];
                                    $nj_averageAlertapp['value'] = "0";
                                    $averageAlerted[] = $nj_averageAlertapp;
                                }
                                }} else {
                                    break;
                                }
                                $data_averageAlertapp['datee'] = '';
                                $data_averageAlertapp['total'] = '';
                        }
                        $averageAlertee['averageAlerted'] = $averageAlerted;
                        
                        
                         // avarage time for taxi
                        for ($w = 0; $w <= count($months); $w++) {
                            $data_averageTimeapp['datee'] = '';
                            $data_averageTimeapp['total'] = '';
                            if ($months[$w] != $currentMonth || $months[$w] == $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageTimeapp = "SELECT  trip.id as nj,trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_acceptTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND trip.trip_acceptTime!='0000-00-00 00:00:00' AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$w]."' $date  ORDER BY trip.tripdatetime ASC";
                            $result_averageTimeapp = mysql_query($query_averageTimeapp);
                            $num_rows = mysql_num_rows($result_averageTimeapp);

                            if($num_rows>0){
                                    while($data_rows = mysql_fetch_array($result_averageTimeapp)){
                                        
                                            $start_time = date('H:i:s', strtotime($data_rows['tripdatetime']));
                                            $end_time = date('H:i:s', strtotime($data_rows['trip_acceptTime']));

                                            //echo $start_time.'!!!';
                                            //echo $end_time.'@@';
                                           $trip_request_time = ($start_time);
                                           $accept_time = ($end_time);		
                                           
                                           $diff = $accept_time - $trip_request_time;		
                                           $total_time_sum += abs($diff);
                                    }
                                    
                                    $average_time = $total_time_sum/$num_rows;
                                    $totalAvgTime = round($average_time);
                                    $nj_averageTimeapp['month'] = $months[$w];
                                    $nj_averageTimeapp['value'] = $totalAvgTime;
                                    $averageTimeed[] = $nj_averageTimeapp;                                    

                            }else {                                      
                                    $nj_averageTimeapp['month'] = $months[$w];
                                    $nj_averageTimeapp['value'] = "0";
                                    $averageTimeed[] = $nj_averageTimeapp;
                            }
                            
                            }else{
                                break;
                                }
                                $data_averageTimeapp['datee'] = '';
                                $data_averageTimeapp['total'] = '';
                        }
                        $averageTimeee['averageTimeed'] = $averageTimeed;
                       // print_r($averageTimeed);
                        
                          // avarage trip timing for taxi
                        for ($t = 0; $t <= count($months); $t++) {
                            $data_averageTripTimeapp['datee'] = '';
                            $timeData = '';
                            if ($months[$t] != $currentMonth || $months[$t] == $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageTripTimeapp = "SELECT  trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND trip.trip_endTime!='0000-00-00 00:00:00' AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$t]."'  $date  ORDER BY trip.tripdatetime ASC";
                            $result_averageTripTimeapp = mysql_query($query_averageTripTimeapp);
                            $num_rows = mysql_num_rows($result_averageTripTimeapp);

                            if($num_rows>0){
                                    while($data_rows = mysql_fetch_array($result_averageTripTimeapp)){
                                            $start_time = date('H:i:s', strtotime($data_rows['tripdatetime']));
                                            $end_time = date('H:i:s', strtotime($data_rows['trip_endTime']));

                                            //echo $start_time.'!!!';
                                            //echo $end_time.'@@';
                                            $trip_request_time = ($start_time);
                                            $accept_time = ($end_time);							
                                            $diff = $accept_time - $trip_request_time;
                                            $total_time_sum += abs($diff);													
                                    }

                                    $average_time = $total_time_sum/$num_rows;
                                    $timeData = intval($average_time);
                                    
                                    $nj_averageTripTimeapp['month'] = $months[$t];
                                    $nj_averageTripTimeapp['value'] = $timeData;
                                    $averageTripTimeed[] = $nj_averageTripTimeapp;                                    

                            }else {                                      
                                    $nj_averageTripTimeapp['month'] = $months[$t];
                                    $nj_averageTripTimeapp['value'] = "0";
                                    $averageTripTimeed[] = $nj_averageTripTimeapp;
                            }}else{
                                break;
                                }
                                $data_averageTripTimeapp['datee'] = '';
                                $timeData = '';
                        }
                        $averageTripTimeee['averageTripTimeed'] = $averageTripTimeed;

                        // avarage driver ratings
                        for ($y = 0; $y <= count($months); $y++) {
                            $data_averageRating['datee'] = '';
                            $data_averageRating['total'] = '0';
                            if ($months[$y] != $currentMonth) {
                                //echo $months[$y].'-----------'.$currentMonth;
                                  $query_averageRating = "SELECT  SUM(customer_rating) as rating, COUNT(customer_rating) as countRate, trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500'  AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$y]."' $date ORDER BY trip.tripdatetime ASC";
                            $result_averageRating = mysql_query($query_averageRating);
                            $num_rows = mysql_num_rows($result_averageRating);
                            //echo $num_rows.'---';
                            //$data_count = mysql_fetch_array($result_averageRating);
                            if($num_rows > 0){
                                //echo 'fgfdgfdg';
                                while($data_rating = mysql_fetch_array($result_averageRating)){ 
                                    //print_r ($data_rating);
                                    if ($data_rating['countRate'] != '0') {
                                        $total_rating = $data_rating['rating'] / $data_rating['countRate'];
                                        $rating =  $total_rating;
                                    }
                                }
                                 $totalRat = $rating;

                                $nj_averageRating['month'] = $months[$y];
                                $nj_averageRating['value'] = $totalRat;
                                $averageRatinged[] = $nj_averageRating;                                    

                            }else {                                      
                                    $nj_averageRating['month'] = $months[$y];
                                    $nj_averageRating['value'] = "0";
                                    $averageRatinged[] = $nj_averageRating;
                            }}
                            else{
                                    break;
                                }
                                $data_averageRating['datee'] = '';
                                $data_averageRating['total'] = '0';
                        }
                        $averageRatingee['averageRatinged'] = $averageRatinged;
                        
                        // Average Pay for driver trips
                        
                        for ($d = 0; $d <= count($months); $d++) {
                            $data_Payment['datee'] = '';
                            $data_Payment['value'] = '';
                            if ($months[$d] != $currentMonth) {
                                //echo $months[$y].'-----------'.$currentMonth;
                                  $query_averagePayment = "SELECT  SUM(trip.trip_ammount) as totalAmt, COUNT(trip.id) as countRate, trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500'  AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$d]."'  $date  ORDER BY trip.tripdatetime ASC";
                            $result_averagePayment = mysql_query($query_averagePayment);
                            $num_rows = mysql_num_rows($result_averagePayment);

                            if($num_rows>0){
                                while($data_Payment = mysql_fetch_array($result_averagePayment)){
                                    //print_r($data_Payment);
                                    if ($data_Payment['countRate'] != '0') {
                                        $total_amount = $data_Payment['totalAmt'] / $data_Payment['countRate'];
                                        $toalAmount =  $total_amount;
                                    }
                                }
                                $amount = $toalAmount;

                                $nj_averagePayment['month'] = $months[$d];
                                $nj_averagePayment['value'] = $amount;
                                $averagePaymented[] = $nj_averagePayment;                                    

                            }else {                                      
                                    $nj_averagePayment['month'] = $months[$d];
                                    $nj_averagePayment['value'] = "0";
                                    $averagePaymented[] = $nj_averagePayment;
                            }}else{
                                break;
                                }
                                $data_Payment['datee'] = '';
                                $data_Payment['value'] = '';
                        }
                        $averagePaymentee['averagePaymented'] = $averagePaymented;
                        
                        //print_r($averagePaymented);
                        
                        
                        $njj['Active'] = $Active;
                        $njj['INActive'] = $Inactivee;
                        $njj['completed'] = $completee;
                        $njj['cancle_trip'] = $cancle_tripee;
                        $njj['reported'] = $reportedee;
                        $njj['corporated'] = $corporatee;
                        $njj['userapped'] = $userappee;
                        $njj['averageAlerted'] = $averageAlertee;
                        $njj['averageTimeed'] = $averageTimeee;
                        $njj['averageTripTimeed'] = $averageTripTimeee;
                        $njj['averageRatinged'] = $averageRatingee;
                        $njj['averagePaymented'] = $averagePaymentee;

                }

                echo json_encode($njj);
	 //echo json_encode($ak_act_vlau);
}

if($mode == 'getSingleDetails'){	
	$centrald = $_POST['a'];
	$str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.web_user_id = '$centrald' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
	$res=mysql_query($str);
	if(mysql_affected_rows()>0){
		$getcentral = '';
		while($row=mysql_fetch_array($res)){
		$getcentral .= $row['web_user_id'];
		}
		$getcentral = $getcentral;
		
			
			// active taxi total record 
			
			$query_active_taxi =(mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('".$getcentral."') AND status ='200' AND YEAR(CURDATE()) = YEAR(updated_on) group by datee "));
			while($data_active_taxi = mysql_fetch_assoc($query_active_taxi))
			{
				//$nj_active['month'] = $data_active_taxi['datee'];
				$nj_active['value'] = $data_active_taxi['total'];
				$getActive[] = $nj_active;			
			}
			$Active['Active'] = $getActive;			
			//Inactive Taxi total record 
			$query_inactive_taxi =(mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('".$getcentral."') AND (status ='400' || status ='404') AND YEAR(CURDATE()) = YEAR(updated_on)  group by datee "));
			while($data_inactive_taxi = mysql_fetch_array($query_inactive_taxi))
			{
				//$nj_inactive['month'] = $data_inactive_taxi['datee'];
				$nj_inactive['value'] = $data_inactive_taxi['total'];
				$inactive[] = $nj_inactive;
			}
			$Inactivee['INActive'] = $inactive;			
			
			
			// Complete trips // ---- added_by ='".$row['web_user_id']."'
			$query_complete_trips = mysql_query("SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND trip.status ='500' group by datee ");
			while ($data_complete = mysql_fetch_array($query_complete_trips)){
				$nj_complete['month'] = $data_complete['datee'];
				$nj_complete['value'] = $data_complete['total'];
				
				$complete[] = $nj_complete;
				//$njj['complete'] = $nj_complete;
			}
			$completee['completed'] = $complete;
			
			
			// Canceled Trips services	---- added_by ='".$row['web_user_id']."'
			$cancle_tripee ='';
			$query_cancle_trips = (mysql_query("SELECT count(trip.id) as total, driver.id,driver.status,driver.name, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND trip.status ='600' group by datee "));
			while ($data_cancle = mysql_fetch_array($query_cancle_trips)){
				$nj_cancle['month'] = $data_cancle['datee'];
				$nj_cancle['value'] = $data_cancle['total'];
				$cancle_trip[] = $nj_cancle;
			}			
			$cancle_tripee['cancle_trip'] = $cancle_trip;
			
			// Reported Trips services
			$query_reported_trips = (mysql_query("SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, trip.driver_rateing, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND (trip.driver_rateing <='2' AND trip.driver_rateing !='') AND trip.status = '500' group by datee "));
			while($data_reported = mysql_fetch_array($query_reported_trips)){
				$nj_reported['month'] = $data_reported['datee'];
				$nj_reported['value'] = ($data_reported['total']);
				$reported[] = $nj_reported;				
			}
			$reportedee['reported'] = $reported;
			
			// Total corporate trips
			$query_corporate = "SELECT COUNT(trip.id) as totalTripCorp, trip.status, trip.driver_id as tDid, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='corporate' group by datee ";
			$result_corporate = mysql_query($query_corporate);
			while($data_corporate = mysql_fetch_array($result_corporate)){
				$nj_reported['month'] = $data_reported['datee'];
				$nj_corporate['value'] = ($data_corporate['totalTripCorp']);
				$corporated[] = $nj_corporate;				
			}
			$corporatee['corporated'] = $corporated;
			
			// Total userapp trips
			$query_userapp = "SELECT COUNT(trip.id) as totalTripUserapp, trip.status, trip.driver_id as tDid, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='userapp' group by datee ";
			$result_userapp = mysql_query($query_userapp);
			while($data_userapp = mysql_fetch_array($result_userapp)){
				$nj_reported['month'] = $data_reported['datee'];
				$nj_userapp['value'] = ($data_userapp['totalTripUserapp']);
				$userapped[] = $nj_userapp;				
			}
			$userappee['userapped'] = $userapped;
		
		$njj['Active'] = $Active;
		$njj['INActive'] = $Inactivee;
		$njj['completed'] = $completee;
		$njj['cancle_trip'] = $cancle_tripee;
		$njj['reported'] = $reportedee;
		$njj['corporated'] = $corporatee;
		$njj['userapped'] = $userappee;
		
	}
		
	echo json_encode($njj);
	 //echo json_encode($ak_act_vlau);
}

if($mode == 'njGetData')
{
// zone id = 48 
// compnay id = 49
// driver id = 27,30,31
 $qry = "select id,name,company_id as compnayIDD,login_status from `driver` as d where 1 and d.company_id in (SELECT web_user_id FROM `taxicompany` as tc where 1 and tc.`zone_area_id_sess` in (select zone_area_id from `zone_cordinater` as zc where 1 and zc.zone_area_id = (SELECT id FROM `zone_area` where 1 and allot_to = '".$_SESSION['uid']."')))";

  $qry1 = "select id,name,company_id as compnayIDD,login_status from `driver` as d where 1 and d.company_id in (SELECT web_user_id FROM `taxicompany` as tc where 1 and tc.`zone_area_id_sess` in (select zone_area_id from `zone_cordinater` as zc where 1 and zc.zone_area_id = (SELECT id FROM `zone_area` where 1 and allot_to = '".$_SESSION['uid']."'))) group by compnayIDD";

$resultDriverMap=mysql_query($qry);
$resultCorpMap=mysql_query($qry1);
//$qry = mysql_query("SELECT web_user_id FROM `taxicompany` where 1 and `zone_area_id_sess` in (select zone_area_id from `zone_cordinater` zc where 1 and zc.zone_area_id = (SELECT id FROM `zone_area` where 1 and allot_to = '48'))");
if(mysql_num_rows($resultDriverMap) > 0)
{
	
	while($data = mysql_fetch_array($resultDriverMap))
	{
		$getLatData = mysql_fetch_array(mysql_query("SELECT longitude,latitude FROM `trip_log` where 1 and driver_id = '".$data['id']."' group by id order by id DESC limit 0,1"));
		$getCompData = mysql_fetch_array(mysql_query("SELECT id,name,web_user_id FROM `taxicompany` where 1 and `web_user_id` = '".$data['compnayIDD']."'"));
		//$getUserData = mysql_fetch_array(mysql_query("SELECT id,name FROM `taxicompany` where 1 and `web_user_id` = '".$data['compnayIDD']."'"));

		// $getUserData="SELECT `taxicompany`.web_user_id,`login`.added_by,`login`.id,`users`.corporate_id,`users`.name from `taxicompany` LEFT JOIN `login` ON `taxicompany`.web_user_id = `login`.id LEFT JOIN `users` ON `login`.id = `users`.corporate_id where `taxicompany`.web_user_id = '".$getCompData['web_user_id']."'";
		if($getLatData['latitude'] !== '' || $getLatData['latitude'] !== null)
		{
		$datas['id'] = $data['id'];
		$datas['companyName'] = $getCompData['name'];
		$datas['latitude'] = $getLatData['latitude'];
		$datas['longitude'] = $getLatData['longitude'];
		$datas['driverName'] = $data['name'];
		}
		$nj_driver[] = $datas; 
	}
}
if(mysql_num_rows($resultCorpMap) > 0)
{

	while($coprData = mysql_fetch_assoc($resultCorpMap))
	{
		
		$getCompData1 = mysql_fetch_array(mysql_query("SELECT id,name,web_user_id FROM `taxicompany` where 1 and `web_user_id` = '".$coprData['compnayIDD']."'"));

		$getUserData1="SELECT `taxicompany`.web_user_id,`corporate`.company_id,`corporate`.web_user_id,`users`.corporate_id,`users`.name,`users`.latitude as ulatitude,`users`.longitude as ulongitude,`corporate`.name as cname from `taxicompany` LEFT JOIN `corporate` ON `taxicompany`.web_user_id = `corporate`.company_id LEFT JOIN `users` ON `corporate`.web_user_id =`users`.corporate_id where 1 and `users`.latitude != '' and `taxicompany`.web_user_id='".$getCompData1['web_user_id']."'";
		$resUserData1=mysql_query($getUserData1);
		while($rowUserData1=mysql_fetch_array($resUserData1))
		{
			$datas1['userName'] = $rowUserData1['name'];
			$datas1['corporateName'] = $rowUserData1['cname'];
			$datas1['userLatitude'] = $rowUserData1['ulatitude'];
			$datas1['userLongitude'] = $rowUserData1['ulongitude'];
			$nj_corp[] = $datas1;
		}
	
}
$nj['driver_details'] = $nj_driver; 
$nj['user_details'] = $nj_corp; 
		
	echo json_encode($nj);
	
}
}

if($mode == 'getRealTimeData')
{
    $get_central_id =" SELECT * FROM login WHERE added_by = '".$_SESSION['uid']."'";
    $res_central = mysql_query($get_central_id);
    while ($rowData = mysql_fetch_array($res_central)) {
        $central_id .=  $rowData['id'].',';
        
    }
    $getCenId = rtrim(',', $central_id);
    
    $getDriver = "select `id` from `driver` where `company_id` = '$getCenId' ";
    $resDriver = mysql_query($getDriver);
    while ($row = mysql_fetch_array($resDriver)) {
        //$insert = mysql_query("insert into `chk_data_nj` (`name`,`date`) values ('dk2','2016-04-08')");
        $todayDate = date('Y-m-d') . ' ' . '00:00:00';
        $todayDate1 = date('Y-m-d') . ' ' . '23:59:59';
        echo $getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '$todayDate' and '$todayDate1' and `driver_id` = '" . $row['id'] . "'";
        $res = mysql_query($getTrip);
    }
}


if($mode == 'getSingleComDetails'){	
	$id=$_POST['id1'];        
	$centrald = $_POST['a'];
	$fromDate=$_POST['fromDate'];
	$toDate=$_POST['toDate'];
	$text=$_POST['text'];
	if (isset($centrald)) {
		
		$taxicompany = 	"AND taxicompany.name LIKE '%" . $text . "%'";		
		if($fromDate != '' && $toDate != ''){
			$date = "AND  trip.tripdatetime between '".date('Y-m-d',strtotime($fromDate))."' AND  '".date('Y-m-d',strtotime($toDate))."'";
		}
	}
	else{
		$taxicompany = '';
		$date = '';
	}
	$str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."' AND `taxicompany`.web_user_id = '$centrald' $taxicompany";
	$res=mysql_query($str);
	if(mysql_affected_rows()>0){
                $row=mysql_fetch_array($res);
		$getcentral = $row['web_user_id'];
		/*while($row=mysql_fetch_array($res)){
		$getcentral .= $row['web_user_id'].',';
		}
		 $getcentral = rtrim($getcentral, ',');
		*/
			
			// active taxi total record 
			$months=array("January","February","March","April","May","June","July","August","September","October","November","December");
			$currentMonth = date("m");
                        //echo $currentMonth.'-------';
			if( $currentMonth == "01")
			 {
			 	 $currentMonth = "January";
			 }
			 elseif( $currentMonth == "02")
			 {
			      $currentMonth = "February";
			 }
			  elseif( $currentMonth == "03")
			 {
			      $currentMonth = "March";
			 }
			  elseif( $currentMonth == "04")
			 {
			      $currentMonth = "April";
			 } 
			 elseif( $currentMonth == "05")
			 {
			      $currentMonth = "May";
			 }
			  elseif( $currentMonth == "06")
			 {
			      $currentMonth = "June";
			 }
			  elseif( $currentMonth == "07")
			 {
			      $currentMonth = "July";
			 }
			  elseif( $currentMonth == "08")
			 {
			      $currentMonth = "August";
			 } 
			 elseif( $currentMonth == "09")
			 {
			      $currentMonth = "September";
			 }
			  elseif( $currentMonth == "10")
			 {
			      $currentMonth = "October";
			 }
			 elseif( $currentMonth == "11")
			 {
			      $currentMonth = "November";
			 }
			 elseif( $currentMonth == "12")
			 {
			      $currentMonth = "December";
			 }
                         
                         for ($i = 0; $i < count($months); $i++) {
                            if ($months[$i] != $currentMonth) {
                                $query_active_taxi = (mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('".$getcentral."') AND status ='200' AND YEAR(CURDATE()) = YEAR(updated_on) GROUP BY datee "));
                                while ($data_active_taxi = mysql_fetch_assoc($query_active_taxi)) {
                                    if ($months[$i] == $data_active_taxi['datee']) {

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_active['month'] = $data_active_taxi['datee'];
                                        $nj_active['value'] = $data_active_taxi['total'];
                                    } else {
                                        $nj_active['month'] = "0";
                                        $nj_active['value'] = "0";
                                    }
                                    $getActive[] = $nj_active;
                                }
                            } else {
                                break;
                            }
                        }       
			$Active['Active'] = $getActive;	
                        
                        
			//Inactive Taxi total record 

			//$months1=array("January","February","March","April","May","June","July","August","September","October","November","December");
			for ($j = 0; $j < count($months); $j++) {
                            if ($months[$j] != $currentMonth) {
                                $query_inactive_taxi = (mysql_query("SELECT count(driver.id) as total, CONCAT(DATE_FORMAT(added_on, '%M')) as datee FROM driver WHERE added_by in ('".$getcentral."') AND (status ='400' || status ='404') AND YEAR(CURDATE()) = YEAR(updated_on)  group by datee "));
                                while ($data_inactive_taxi = mysql_fetch_array($query_inactive_taxi)) {
                                    if ($months[$j] == $data_inactive_taxi['datee']) {
                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_inactive['month'] = $data_inactive_taxi['datee'];
                                        $nj_inactive['value'] = $data_inactive_taxi['total'];
                                    } else {
                                        $nj_inactive['month'] = "0";
                                        $nj_inactive['value'] = "0";
                                    }
                                    $inactive[] = $nj_inactive;
                                }
                            } else {
                                break;
                            }
                        }
                        
                        //$nj_inactive['month'] = $data_inactive_taxi['datee'];
			// 	$nj_inactive['value'] = $data_inactive_taxi['total'];
			// 	$inactive[] = $nj_inactive;
			// }
                        
			$Inactivee['INActive'] = $inactive;
                         
			
			// Complete trips // ---- added_by ='".$row['web_user_id']."'
			for ($k = 0; $k <= count($months); $k++) {
                            $data_complete['datee'] = '';
                            $data_complete['total'] = '';
                            if ($months[$k] != $currentMonth) {
                                 //echo $months[$k].'-------'.$currentMonth.'<br/>';

                               $njjj = "SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND trip.status ='500' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$k]."' $date group by datee  ORDER BY trip.tripdatetime ASC";
                                $query_complete_trips = mysql_query($njjj);
                                $data_complete = mysql_fetch_array($query_complete_trips);
                                    if (mysql_num_rows($query_complete_trips) > 0)
                                    {
                                        $nj_complete['month'] = $months[$k];
                                        $nj_complete['value'] = $data_complete['total'];
                                        $complete[] = $nj_complete;
                                    } else {  // echo'gfdg';                                     
                                        $nj_complete['month'] = $months[$k];
                                        $nj_complete['value'] = "0";
                                        $complete[] = $nj_complete;
                                    }
                                  
                                
                            } else {
                                break;
                            }
                           
                            $data_complete['datee'] = '';
                            $data_complete['total'] = '';
                        }
                       // print_r($complete);

			$completee['completed'] = $complete;
			
			
			// Canceled Trips services	---- added_by ='".$row['web_user_id']."'
			
			
			
			$cancle_tripee = '';
                        for ($l = 0; $l < count($months); $l++) {
                            
                            $data_cancle['datee'] = '';
                            $data_cancle['total'] = '';
                            if ($months[$l] != $currentMonth) {
                                $query_cancle_trips = (mysql_query("SELECT count(trip.id) as total, driver.id,driver.status,driver.name, trip.status as tStatus, trip.tripdatetime, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') AND trip.status ='600' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$l]."' $date group by datee  ORDER BY trip.tripdatetime ASC"));
                                $data_cancle = mysql_fetch_array($query_cancle_trips);
                                   // if ($months[$l] == $data_cancle['datee']) {
                                if(mysql_num_rows($query_cancle_trips) > 0){

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_cancle['month'] = $months[$l];
                                        $nj_cancle['value'] = $data_cancle['total'];
                                        $cancle_trip[] = $nj_cancle;
                                    } else {
                                        $nj_cancle['month'] = $months[$l];
                                        $nj_cancle['value'] = "0";
                                        $cancle_trip[] = $nj_cancle;
                                    }
                                //}
                            } else {
                                break;
                            }
                            $data_cancle['datee'] = '';
                            $data_cancle['total'] = '';
                        }
                        // 	$nj_cancle['month'] = $data_cancle['datee'];
			// 	$nj_cancle['value'] = $data_cancle['total'];
			// 	$cancle_trip[] = $nj_cancle;
			// }			
			$cancle_tripee['cancle_trip'] = $cancle_trip;
			
			// Reported Trips services
			for ($u = 0; $u < count($months); $u++) {
                            if ($months[$u] != $currentMonth) {
                                $query_reported_trips = (mysql_query("SELECT count(trip.id) as total,driver.id,driver.status,driver.name, trip.id as tripId, trip.status as tStatus, trip.tripdatetime, trip.driver_rateing, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$u]."' AND (trip.driver_rateing <='2' AND trip.driver_rateing !='') AND trip.status = '500' $date group by datee  ORDER BY trip.tripdatetime ASC"));
                                while ($data_reported = mysql_fetch_array($query_reported_trips)) {
                                    if ($months[$u] == $data_reported['datee']) {
                                    // if ($data_reported['datee'] != '' || $data_reported['datee'] != null){
                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_reported['month'] = $data_reported['datee'];
                                        $nj_reported['value'] = $data_reported['total'];
                                    } else {                                        
                                    }
                                    $reported[] = $nj_reported;
                                }
                            } else {
                                break;
                            }
                        }
                        // 	$nj_reported['month'] = $data_reported['datee'];
			// 	$nj_reported['value'] = ($data_reported['total']);
			// 	$reported[] = $nj_reported;				
			// }
			$reportedee['reported'] = $reported;
			
			// Total corporate trips
			for ($c = 0; $c <= count($months); $c++) {                            
                            $data_corporate['datee'] = '';
                            $data_corporate['total'] = '';
                            if ($months[$c] != $currentMonth) {
                                $query_corporate = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid,trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='corporate' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$c]."' $date group by datee  ORDER BY trip.tripdatetime ASC";
                                    $result_corporate = mysql_query($query_corporate);
                                    $data_corporate = mysql_fetch_array($result_corporate);
                                    if (mysql_num_rows($result_corporate) > 0){       
                                        $nj_corporate['month'] = $months[$c];
                                        $nj_corporate['value'] = $data_corporate['total'];
                                        $corporated[] = $nj_corporate;
                                    } else {
                                        $nj_corporate['month'] = $months[$c];
                                        $nj_corporate['value'] = "0";
                                        $corporated[] = $nj_corporate;
                                    }
                            } else {
                                break;
                            }
                            $data_corporate['datee'] = '';
                            $data_corporate['total'] = '';
                        }
                        $corporatee['corporated'] = $corporated;
			
			// Total userapp trips
                        for ($a = 0; $a <= count($months); $a++) {                           
                            $data_userapp['datee'] = '';
                            $data_userapp['total'] = '';
                            if ($months[$a] != $currentMonth) {
                                $query_userapp = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid, trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='userapp' and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$a]."'  $date group by datee ORDER BY trip.tripdatetime ASC";
                                $result_userapp = mysql_query($query_userapp);
                               $data_userapp = mysql_fetch_array($result_userapp);
                                    if (mysql_num_rows($result_userapp) > 0) {

                                        // echo $data_active_taxi['datee']."dk";
                                        $nj_userapp['month'] = $months[$a];
                                        $nj_userapp['value'] = $data_userapp['total'];
                                        $userapped[] = $nj_userapp;
                                    } else {
                                        $nj_userapp['month'] = $months[$a];
                                        $nj_userapp['value'] = "0";
                                        $userapped[] = $nj_userapp;
                                    }
                               
                            } else {
                                break;
                            }
                            
                            $data_userapp['datee'] = '';
                            $data_userapp['total'] = '';
                        }
                        // 	$nj_userapp['month'] = $data_userapp['datee'];
			// 	$nj_userapp['value'] = ($data_userapp['totalTripUserapp']);
			// 	$userapped[] = $nj_userapp;				
			// }
			$userappee['userapped'] = $userapped;
                        
                        
                        // Total Avarage Alerts
                        for ($q = 0; $q <= count($months); $q++) {
                            $data_averageAlertapp['datee'] = '';
                            $data_averageAlertapp['total'] = '';
                            if ($months[$q] != $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageAlertapp = "SELECT COUNT(trip.id) as total, trip.status, trip.driver_id as tDid, trip.tripdatetime, driver.id as dId, CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) as datee FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND driver.added_by in ('".$getcentral."') AND trip.trip_type='corporate'AND trip.customer_rating<=2 and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$q]."' $date group by datee ORDER BY trip.tripdatetime ASC";
                            $result_averageAlertapp = mysql_query($query_averageAlertapp);
                            $data_averageAlertapp = mysql_fetch_array($result_averageAlertapp);{
                                if (mysql_num_rows($result_averageAlertapp) > 0){
                                    
                                    $nj_averageAlertapp['month'] = $months[$q];
                                    $nj_averageAlertapp['value'] = $data_averageAlertapp['total'];
                                    $averageAlerted[] = $nj_averageAlertapp;
                                } else {                                      
                                    $nj_averageAlertapp['month'] = $months[$q];
                                    $nj_averageAlertapp['value'] = "0";
                                    $averageAlerted[] = $nj_averageAlertapp;
                                }
                                }} else {
                                    break;
                                }
                                $data_averageAlertapp['datee'] = '';
                                $data_averageAlertapp['total'] = '';
                        }
                        $averageAlertee['averageAlerted'] = $averageAlerted;
                        
                        
                         // avarage time for taxi
                        for ($w = 0; $w <= count($months); $w++) {
                            $data_averageTimeapp['datee'] = '';
                            $data_averageTimeapp['total'] = '';
                            if ($months[$w] != $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageTimeapp = "SELECT  trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_acceptTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND trip.trip_acceptTime!='0000-00-00 00:00:00' AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$w]."' $date  ORDER BY trip.tripdatetime ASC";
                            $result_averageTimeapp = mysql_query($query_averageTimeapp);
                            $num_rows = mysql_num_rows($result_averageTimeapp);

                            if($num_rows>0){
                                    while($data_rows = mysql_fetch_array($result_averageTimeapp)){
                                            $start_time = date('H:i:s', strtotime($data_rows['tripdatetime']));
                                            $end_time = date('H:i:s', strtotime($data_rows['trip_acceptTime']));

                                            //echo $start_time.'!!!';
                                            //echo $end_time.'@@';
                                           $trip_request_time = ($start_time);
                                           $accept_time = ($end_time);							
                                           $diff = $accept_time - $trip_request_time;
                                           $total_time_sum += abs($diff);													
                                    }

                                    $average_time = $total_time_sum/$num_rows;
                                    $totalAvgTime = intval($average_time);
                                    
                                    $nj_averageTimeapp['month'] = $months[$w];
                                    $nj_averageTimeapp['value'] = $totalAvgTime;
                                    $averageTimeed[] = $nj_averageTimeapp;                                    

                            }else {                                      
                                    $nj_averageTimeapp['month'] = $months[$w];
                                    $nj_averageTimeapp['value'] = "0";
                                    $averageTimeed[] = $nj_averageTimeapp;
                            }}else{
                                break;
                                }
                                $data_averageTimeapp['datee'] = '';
                                $data_averageTimeapp['total'] = '';
                        }
                        $averageTimeee['averageTimeed'] = $averageTimeed;
                        
                        
                          // avarage trip timing for taxi
                        for ($t = 0; $t <= count($months); $t++) {
                            $data_averageTripTimeapp['datee'] = '';
                            $data_averageTripTimeapp['total'] = '';
                            if ($months[$t] != $currentMonth) {
                                //echo $months[$u].'-----------'.$currentMonth;
                                $query_averageTripTimeapp = "SELECT  trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500' AND trip.trip_endTime!='0000-00-00 00:00:00' AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$t]."'  $date  ORDER BY trip.tripdatetime ASC";
                            $result_averageTripTimeapp = mysql_query($query_averageTripTimeapp);
                            $num_rows = mysql_num_rows($result_averageTripTimeapp);

                            if($num_rows>0){
                                    while($data_rows = mysql_fetch_array($result_averageTripTimeapp)){
                                            $start_time = date('H:i:s', strtotime($data_rows['tripdatetime']));
                                            $end_time = date('H:i:s', strtotime($data_rows['trip_endTime']));

                                            //echo $start_time.'!!!';
                                            //echo $end_time.'@@';
                                            $trip_request_time = ($start_time);
                                            $accept_time = ($end_time);							
                                            $diff = $accept_time - $trip_request_time;
                                            $total_time_sum += $diff;													
                                    }

                                    $average_time = $total_time_sum/$num_rows;
                                    $timeData = intval($average_time);
                                    
                                    $nj_averageTripTimeapp['month'] = $months[$t];
                                    $nj_averageTripTimeapp['value'] = $timeData;
                                    $averageTripTimeed[] = $nj_averageTripTimeapp;                                    

                            }else {                                      
                                    $nj_averageTripTimeapp['month'] = $months[$t];
                                    $nj_averageTripTimeapp['value'] = "0";
                                    $averageTripTimeed[] = $nj_averageTripTimeapp;
                            }}else{
                                break;
                                }
                                $data_averageTripTimeapp['datee'] = '';
                                $data_averageTripTimeapp['total'] = '';
                        }
                        $averageTripTimeee['averageTripTimeed'] = $averageTripTimeed;

                        // avarage driver ratings
                        for ($y = 0; $y <= count($months); $y++) {
                            $data_averageRating['datee'] = '';
                            $data_averageRating['total'] = '';
                            if ($months[$y] != $currentMonth) {
                                //echo $months[$y].'-----------'.$currentMonth;
                                  $query_averageRating = "SELECT  SUM(customer_rating) as rating, COUNT(customer_rating) as countRate, trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500'  AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$y]."' $date ORDER BY trip.tripdatetime ASC";
                            $result_averageRating = mysql_query($query_averageRating);
                            $num_rows = mysql_num_rows($result_averageRating);

                            if($num_rows>0){
                                while($data_rating = mysql_fetch_array($result_averageRating)){
                                    if ($data_rating['countRate'] != '0') {
                                        $total_rating = $data_rating['rating'] / $data_rating['countRate'];
                                        $rating =  $total_rating;
                                    }
                                }
                                $totalRat = $rating;

                                $nj_averageRating['month'] = $months[$y];
                                $nj_averageRating['value'] = $totalRat;
                                $averageRatinged[] = $nj_averageRating;                                    

                            }else {                                      
                                    $nj_averageRating['month'] = $months[$y];
                                    $nj_averageRating['value'] = "0";
                                    $averageRatinged[] = $nj_averageRating;
                            }}else{
                                break;
                                }
                                $data_averageRating['datee'] = '';
                                $data_averageRating['total'] = '';
                        }
                        $averageRatingee['averageRatinged'] = $averageRatinged;
                        
                        // Average Pay for driver trips
                        
                        for ($d = 0; $d <= count($months); $d++) {
                            $data_Payment['datee'] = '';
                            $data_Payment['value'] = '';
                            if ($months[$d] != $currentMonth) {
                                //echo $months[$y].'-----------'.$currentMonth;
                                  $query_averagePayment = "SELECT  SUM(trip.trip_ammount) as totalAmt, COUNT(trip.id) as countRate, trip.status, trip.driver_id as tDid, trip.tripdatetime, trip.trip_endTime, driver.id as dId FROM trip LEFT JOIN driver ON trip.driver_id = driver.id WHERE trip.status='500'  AND driver.added_by in ('".$getcentral."') and CONCAT(DATE_FORMAT(trip.tripdatetime, '%M')) = '".$months[$d]."'  $date  ORDER BY trip.tripdatetime ASC";
                            $result_averagePayment = mysql_query($query_averagePayment);
                            $num_rows = mysql_num_rows($result_averagePayment);

                            if($num_rows>0){
                                while($data_Payment = mysql_fetch_array($result_averagePayment)){
                                    //print_r($data_Payment);
                                    if ($data_Payment['countRate'] != '0') {
                                        $total_amount = $data_Payment['totalAmt'] / $data_Payment['countRate'];
                                        $toalAmount =  $total_amount;
                                    }
                                }
                                $amount = $toalAmount;

                                $nj_averagePayment['month'] = $months[$d];
                                $nj_averagePayment['value'] = $amount;
                                $averagePaymented[] = $nj_averagePayment;                                    

                            }else {                                      
                                    $nj_averagePayment['month'] = $months[$d];
                                    $nj_averagePayment['value'] = "0";
                                    $averagePaymented[] = $nj_averagePayment;
                            }}else{
                                break;
                                }
                                $data_Payment['datee'] = '';
                                $data_Payment['value'] = '';
                        }
                        $averagePaymentee['averagePaymented'] = $averagePaymented;
                        
                        //print_r($averagePaymented);
                        
                        
                        $njj['Active'] = $Active;
                        $njj['INActive'] = $Inactivee;
                        $njj['completed'] = $completee;
                        $njj['cancle_trip'] = $cancle_tripee;
                        $njj['reported'] = $reportedee;
                        $njj['corporated'] = $corporatee;
                        $njj['userapped'] = $userappee;
                        $njj['averageAlerted'] = $averageAlertee;
                        $njj['averageTimeed'] = $averageTimeee;
                        $njj['averageTripTimeed'] = $averageTripTimeee;
                        $njj['averageRatinged'] = $averageRatingee;
                        $njj['averagePaymented'] = $averagePaymentee;

                }

                echo json_encode($njj);
	 //echo json_encode($ak_act_vlau);
}


?>

