<?php
include '../include/config.php';
include '../include/define.php';
define("SUPER_ADMIN_URL","http://www.hvantagetechnologies.com/central-taxi/super-admin/");
define("CORPORATE_URL","http://www.hvantagetechnologies.com/central-taxi/corp-user/");
//define("ACCOUNT_URL","http://www.hvantagetechnologies.com/central-taxi/account/");
define("TAXI_URL","http://www.hvantagetechnologies.com/central-taxi/taxi-company/");
define("ZONE_URL","http://www.hvantagetechnologies.com/central-taxi/zone-admin/");
define("MAIN_URL","http://www.hvantagetechnologies.com/central-taxi/");
define("image_PATH","http://www.hvantagetechnologies.com/central-taxi/images/");
define("MAIN_URL_WWW","http://www.hvantagetechnologies.com/central-taxi/");
OnLoad();

function OnLoad()
{
	$method = $_GET['method'];
	if($method == 'SignIn')
	{
		SignIn();
	}
 	elseif($method == 'startTrip')
    {
        startTrip();
    }
    elseif($method == 'previousTrip')
    {
        previousTrip();
    }    
    elseif($method == 'logout')
    {
        logout();
    }
    elseif($method == 'sendMessage')
    {
        sendMessage();
    }
    elseif($method == 'cancel')
    {
        cancel();
    }
    elseif($method == 'rateing')
    {
        rateing();
    }
    elseif($method == 'feedback')
    {
        feedback();
    }
    elseif($method == 'panic')
    {
        panic();
    }
    elseif($method == 'tripHistory')
    {
        tripHistory();
    }
    elseif($method == 'favorateAddress')
    {
        favorateAddress();
    }
    elseif($method == 'getDriver')
    {
        getDriver();
    }
    elseif($method == 'PayPayment')
    {
        PayPayment();
    }
     elseif($method == 'boardedTrip')
    {
        boardedTrip();
    }
    elseif($method == 'startTrip1')
    {
        startTrip1();
    }
    elseif($method == 'getColonies')
    {
        getColonies();
    }
     elseif($method == 'getAdminNotification')
    {
        getAdminNotification();
    }
	 elseif($method == 'getCurrentDriverInfo')
	{
		getCurrentDriverInfo();
	} 
	elseif($method == 'paymentMode')
    {
        paymentMode();
    }	
}

// function for send message through gcm
/*function send_notification($registatoin_ids, $message)
		{ 

         $url = 'https://android.googleapis.com/gcm/send';
		 $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $message,
        );
 
        $headers = array(
            'Authorization: key = AIzaSyAQ5Se4Tu1LmgZDAwQ-mguA73x__s8HsTY',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
         // Close connection
        curl_close($ch);
        $result;
    }
    */

//
function startTrip()
{			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
    {
    	date_default_timezone_set('asia/kolkata');
        $dateTime=date('Y-m-d H:i:s');
	    $desti_city=$data[0]['desti_city'];
		$desti_zip=$data[0]['desti_zip'];
		$source_country=$data[0]['source_country'];
		$currentlongitude=$data[0]['currentlongitude'];	
		$currentlatitute=$data[0]['currentlatitute'];
		$desti_country=$data[0]['desti_country'];
		$tripType=$data[0]['tripType'];
		$destinationlandmark=$data[0]['destinationlandmark'];
		$source_state=$data[0]['source_state'];
		$destination_lat=$data[0]['destination_lat'];
		$companyname=$data[0]['companyname'];
		$sourcelongitude=$data[0]['sourcelongitude'];
		$source_city=$data[0]['source_city'];
		$sourcelatitute=$data[0]['sourcelatitute'];
		$account_types=$data[0]['account_type'];
		$destination_address=$data[0]['destination_address'];
		$sourcelandmark=$data[0]['sourcelandmark'];
		$description=$data[0]['description'];
		$desti_state=$data[0]['desti_state'];
		$sourceaddress=$data[0]['sourceaddress'];
		$destination_lon=$data[0]['destination_lon'];
		$customer_id=$data[0]['customer_id'];
		$amount=$data[0]['amount'];
		$device_type=$data[0]['device_type'];
		$status='0';
		// $q1="select * from users where id='".$customer_id."' and account_type='".$account_types."'";
		// $res1=mysql_query($q1);
		// $row=mysql_fetch_array($res1);
                
		$device_id  = $data[0]['device_id'];
		$server_gmt=$data[0]['server_gmt'];
                
                // For current GMT 
                $server_gmt_ori =str_replace('GMT', '', $server_gmt);
                
                getCurrentTimezone($server_gmt_ori);
                $arr = getCurrentTimezone($server_gmt_ori);
                
                $date_server_login= $arr['date'];
                $time_server_login= $arr['time'];
                $time_zone_server= $arr['tz'];
                
                $date_time = $arr['date_time'];
                //echo $date_server_login.'---'.$time_server_login.'@@@@@'.$time_zone_server.'-------'.$date_time;die;
                
                $query_set_time = "UPDATE users SET `date_server_login`='$date_server_login',`time_server_login`='$time_server_login',`time_zone_server`='$time_zone_server',`utc_server`='$server_gmt_ori' where id='$customer_id'";
                mysql_query($query_set_time);
                // For current GMT End
                
		$point1_lat = $sourcelatitute;
        $point1_lng = $sourcelongitude;
        $point2_lat = $destination_lat;
        $point2_lng = $destination_lon;
        function distance($point1_lat, $point1_lng, $point2_lat, $point2_lng, $unit) { 
        $theta = $point1_lng - $point2_lng; 
        $dist = sin(deg2rad($point1_lat)) * sin(deg2rad($point2_lat)) +  cos(deg2rad($point1_lat)) * cos(deg2rad($point2_lat)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit); 
        if($unit == "K")
        {
            return ($miles * 1.609344); 
        }
        }
        $distance=ceil(distance($point1_lat, $point1_lng, $point2_lat, $point2_lng, "k"));
        if($device_id=="" || $account_types=="")
		{
            $contents['msg']='Plz enter device id and account_types';
	    	$msg['message']='Error in Submition';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
		}
		else
	   {
	   	    $map = " ( 3959 * acos( cos( radians('$sourcelatitute') ) * cos( radians( a_latitude ) ) * cos( radians( a_longitude ) - radians('$sourcelongitude') ) + sin( radians('$sourcelatitute') ) * sin( radians( a_latitude ) ) ) ) AS distance ";
			$condition = " and a_latitude IS NOT NULL AND a_longitude IS NOT NULL ";
			$having = " HAVING distance BETWEEN 0 AND 300  ";

		$str77="select a.taxi_company_id,$map from `colony` as a where 1 $condition group by a.taxi_company_id $having";
		$res77=mysql_query($str77);
		while($row77=mysql_fetch_array($res77))
		{
			$str78="select * from driver where company_id='".$row77['taxi_company_id']."' and login_status='1'";
			$res78=mysql_query($str78);
			$row78=mysql_fetch_assoc($res78);
			$getDriverDetails[]=$row78['device_id'];			           
		}
		$getDriverDevice=$getDriverDetails;
		
		if($getDriverDevice>=0)
		{
	   	$str55="update users set device_id='".$device_id."' where id='".$customer_id."'";
            $res55=mysql_query($str55);
	    $q="INSERT INTO `trip`(`current_latitude`,`current_longitude`,`source_latitude`,`source_longitude`,`source_city`,`source_state`,`source_landmark`,`source_country`,`destination_latitude`,`source_address`,`destination_address`,`destination_longitude`,`destination_city`,`destination_state`,`destination_zip`,`destination_landmark`,`destination_country`,`account_type`,`description`,`customer_id`,`trip_distance`,`tripdatetime`,`device_id`,`trip_type`,`addedby`,`addedon`,`status`,`trip_ammount`,`device_type`)
		    VALUES ('$currentlatitute','$currentlongitude','$sourcelatitute','$sourcelongitude','$source_city','$source_state','$sourcelandmark','$source_country','$destination_lat','$sourceaddress','$destination_address','$destination_lon','$desti_city','$desti_state','$desti_zip','$destinationlandmark','$desti_country','$account_types','$description','$customer_id','$distance','$date_time','$device_id','$tripType','$customer_id','$date_time','$status','$amount','$device_type')";
   	    $res=mysql_query($q) or die(mysql_error());

   	   
   	   // $driverInfo="select * from driver where login_status='1'";
   	    $registatoin_ids = $getDriverDevice;
	    $message = array("newTrip" => "You have get a new trip");	 
        send_notification($registatoin_ids, $message);
   	    $contents=array();

   	     if(mysql_affected_rows() > 0)
		  {
	    	$id=mysql_insert_id();
	    	$contents['id']="$id";
	    	$msg['message']='Data Insert';
	    	$msg['result']=$contents;
	    	$msg['status']='200';  
	    	echo json_encode($msg);  	
		 }
	    else
	    	{
	    	$contents['msg']='Error';
	    	$msg['message']='Error in Coding';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    	}
	    }
	    else
	    {
	    	$contents['msg']='Error';
	    	$msg['message']='No driver available in your area';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    }
	}	
}
}

// previousTrip

function previousTrip()
{
    	$neer2=array();
	    $q = "SELECT * From trip";
   	    $res=mysql_query($q) or die(mysql_error());
   	    if($res)
   	    {
   	    while($row2 = mysql_fetch_array($res))
				{
		           $neer1['sourcelandmark'] = $row2['source_landmark'];
		           $neer1['sourcelatitute'] = $row2['source_latitude'];
				   $neer1['sourcelongitude'] = $row2['source_longitude'];	
				   $neer2[] = $neer1;					
				}
				$msg['message'] = 'Driver Get Successfully';	    	
		    	$msg['result'] = $neer2;
		    	$msg['status'] = '200'; 
		    	echo json_encode($msg);
        }
	    else
	    	{
	    	$contents['msg']='Error';
	    	$msg['message']='Error in Coding';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    	}	
}

//send message

function sendMessage()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];
		$message=$data[0]['message'];
		$tripId=$data[0]['tripId'];
		$q="INSERT INTO `customer_sendMessage`(`customer_id`,`message`,`trip_id`)VALUES ('$uid','$message','$tripId')";
    	$res=mysql_query($q) or die(mysql_error());
		        $q3= "SELECT `trip`.id,`trip`.driver_id,`driver`.device_id,`driver`.id
		        From `trip` 
		        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id
		        WHERE `trip`.id ='".$tripId."' "; 
				$res3=mysql_query($q3) or die(mysql_error());
				$row1=mysql_fetch_assoc($res3);
                $gcm_regid=$row1['device_id'];
				$contents = array(); 	    
				$contents['trip_id'] = $row1['id']; 
				$contents['customer_id'] = $row1['customer_id']; 
				$contents['message'] = $message;
				$registatoin_ids = array($gcm_regid);
			    $message = array("sendmessage" => $contents);	 
	            send_notification($registatoin_ids, $message);
                $contents=array();
			    if(mysql_affected_rows() > 0)
			    {
			    	$id=mysql_insert_id();
			    	$contents['id']="$id";			    	
			    	$msg['message']='Send Message Successfully';
			    	$msg['result']=$contents;
			    	$msg['status']='200'; 
			    	echo json_encode($msg);  	
			    }
			    else
			    {
			    	$contents['msg']='Error';
			    	$msg['message']='Error in Coding';
			    	$msg['result']=$contents;
			    	$msg['status']='400';
			    	echo json_encode($msg);
			    }
  }
}

//cancel trip
function cancel()
{
	
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{

		
		$uid=$data[0]['uid'];
		$tripId=$data[0]['trip_id'];
		//$account_type=$data[0]['account_type'];
		$status1='cancel';
		$status='600';
		$driverId1='0';
		$canceltaxirequest=$data[0]['canceltaxirequest'];
	    $q = "SELECT * FROM trip WHERE id ='".$tripId."' AND customer_id='".$uid."'";
		$res=mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{
			    
 				$q3= "SELECT `trip`.id,`trip`.driver_id,`trip`.customer_rejectResson,`trip`.customer_id,`driver`.device_id From `trip`
 				LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
 				WHERE `trip`.id ='".$tripId."' ";
				$res3=mysql_query($q3) or die(mysql_error());				
				$row1=mysql_fetch_assoc($res3);	
	            $gcm_regid = $row1['device_id'];
				$contents = array(); 
				$contents['trip_id'] = $row1['id']; 
				$contents['uid'] = $row1['customer_id']; 
				$contents['canceltaxirequest'] = $row1['customer_rejectResson']; 
				
				$registatoin_ids = array("$gcm_regid");
			    $message = array("tripcancel" => $contents);	 
	            send_notification($registatoin_ids, $message);
 	            $q2=" UPDATE trip SET status='".$status."',driver_id='".$driverId1."',customer_rejectResson='".$canceltaxirequest."' WHERE id='".$tripId."' ";
				$res4=mysql_query($q2) or die(mysql_error());
			
				$msg['message']='successfull';
				$msg['result']=$contents;
				$msg['status']='200';
				echo json_encode($msg);
		}
	else
		{
			$contents['msg'] = 'error';
			$msg['message']='Cancel Taxi';
			$msg['result']=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
}	
}


//Rating
function rateing()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];		
		$tripId=$data[0]['tripId'];		
		$rateing=$data[0]['rateing'];
       // $q="INSERT INTO `driver_rateing`(`customer_id`,`rateing`)VALUES ('$customer_id','$rateing')";
		$q="update trip set driver_id='".$driverId."',driver_rateing='".$rateing."' where id='".$tripId."'";		
        $res=mysql_query($q) or die(mysql_error());
	    $contents=array();
	    if(mysql_affected_rows() > 0)
	    {
	    	//$id=mysql_insert_id();
	    	$contents['id']="$id";    	
	    	$msg['message']='Rating Inserted';
	    	//$msg['result']=$contents;
	    	$msg['status']='200'; 
	    	echo json_encode($msg);  	
	    }
	    else
	    {
	    	$contents['msg']='Error';
	    	$msg['message']='Error in Coding';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    }
     }
}

//feed back by customer
function feedback()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$feedback_latitude=$data[0]['feedback_latitude'];
		$feedback_longitude=$data[0]['feedback_longitude'];	
		$customerComment=$data[0]['customerComment'];	
		$custmer_id=$data[0]['custmer_id'];
		$customerRating=$data[0]['customerRating'];
		$trip_id=$data[0]['trip_id'];
		$account_type=$data[0]['account_type'];
	    $q="UPDATE `trip` SET feedback_latitude = '".$feedback_latitude."',feedback_longitude = '".$feedback_longitude."',user_comment = '".$customerComment."',customer_rating='".$customerRating."' where id = '".$trip_id."' ";
        $res = mysql_query($q) or die(mysql_error());
	    $contents=array();
	    if(mysql_affected_rows() > 0)
	    {
	    	$contents['feedback_latitude'] = $feedback_latitude;
	    	$contents['feedback_longitude'] = $feedback_longitude;
	    	$contents['customerComment'] = $customerComment;
	    	$contents['customerRating'] = $customerRating;
	    	$contents['account_type'] = $account_type;
	    	$msg['message']='FeedBack Done';
	    	$msg['result']=$contents;
	    	$msg['status']='200';  
	    	echo json_encode($msg);  	
	    }
	    else
	    {
	    	$contents['msg']='Error';
	    	$msg['message']='Error in Codeing';
	    	$msg['result']=$contents;
         	$msg['status']='400';
	    	echo json_encode($msg);
	    }
	  }
	}

// for panic customer
function panic()
{
	 $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$trip_id=$data[0]['trip_id'];
		$uid=$data[0]['uid'];
		$account_type=$data[0]['account_type'];
		$panictaxirequest=$data[0]['panictaxirequest'];
	    $q="update `trip` set panictaxirequest ='".$panictaxirequest."' where id='".$trip_id."' and account_type='".$account_type."'";
	    $res=mysql_query($q) or die(mysql_error());
	    $contents=array();
	    if($res)
	    { 	
	    	$contents['trip_id'] = $trip_id;
	    	$contents['uid'] = $uid;
	    	$contents['account_type'] = $account_type;
	    	$contents['panictaxirequest'] = $panictaxirequest;
	    	$msg['message']='Panic taxi request inserted Successfully';
	    	$msg['result']=$contents;
	    	$msg['status']='200';  
	    	echo json_encode($msg);  	
	    }
	    else
	    {
	    	$contents['msg']='Error';
	    	$msg['message']='Error in Coding';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    }
  }
}

// customer trip history
function tripHistory()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];
		$account_type=$data[0]['account_type'];
		if(!empty($data[0]['fromDate']) && !empty($data[0]['toDate']))
		 {
		 $fromDate=$data[0]['fromDate'].' '.'00:00:00';
		 $toDate=$data[0]['toDate'].' '.'23:59:59';
		 $fdate = " and tripdatetime >='".$fromDate."' AND tripdatetime <='".$toDate."'";
		 }
		 else{

		 	$fdate = '';
		 }
	    $contents = array(); 
   	    $thang = array();
   	    $month=array();
	    $query="select DISTINCT MONTH(tripdatetime) as month, YEAR(tripdatetime) as year  from `trip` where customer_id = '".$uid."' $fdate";
		$result=mysql_query($query) or die(mysql_error());
		$num=mysql_num_rows($result);
		if(mysql_num_rows($result))
		 {
			while($row=mysql_fetch_array($result))
			{
	 		    $str1 = "SELECT `trip`.endTrip_sourceaddress,`trip`.endTrip_sourcelatitude,`trip`.endTrip_sourcelongitude,`trip`.endTrip_destinationaddress,`trip`.endTrip_destinationlatitude,`trip`.endTrip_destinationlongitude,`trip`.id,`trip`.driver_id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.user_comment,`trip`.source_country,`trip`.streetnumber,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.tripdatetime,`trip`.trip_type,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_zip,`trip`.destination_landmark,`trip`.destination_country,`driver`.name,`driver`.image,`driver`.contact_number,`driver`.vehicle_number,`trip`.status,`trip`.trip_ammount,`trip`.trip_distance,`trip`.travelTime,`trip`.customer_rating,`trip`.driver_rateing,`login`.name as companyname FROM `trip` 
			 		LEFT JOIN `driver` ON `trip`.driver_id =`driver`.id
			 		LEFT JOIN `login` ON `driver`.company_id=`login`.id
			 		where MONTH(`tripdatetime`) = '".$row['month']."' AND YEAR(`tripdatetime`) = '".$row['year']."' and customer_id = '".$uid."' and `trip`.status !='0' $fdate ORDER BY id desc";			 		
				$res1=mysql_query($str1) or die(mysql_error());
				while($row1=mysql_fetch_array($res1))
				{
					$contents['id']=$row1['id'];
				    // $contents['source_address']=$row1['source_address'].','.$row1['source_city'].','.$row1['streetnumber'].','.$row1['source_country'].','.$row1['source_zip'];
				    if($row1['status'] == '600')
				    {
				    	//echo "hello";
				    	$contents['source_address']=$row1['source_address'];
					    $contents['source_latitude']=$row1['source_latitude'];
					    $contents['source_longitude']=$row1['source_longitude'];

					    $contents['destination_address']=$row1['destination_address'];
					    $contents['destination_latitude']=$row1['destination_latitude'];
					    $contents['destination_longitude']=$row1['destination_longitude'];
				    }
				    else
				    {
				    	//echo "dinesh";
					    $contents['source_address']=$row1['endTrip_sourceaddress'];
					    $contents['source_latitude']=$row1['endTrip_sourcelatitude'];
					    $contents['source_longitude']=$row1['endTrip_sourcelongitude'];

					    $contents['destination_address']=$row1['endTrip_destinationaddress'];
					    $contents['destination_latitude']=$row1['endTrip_destinationlatitude'];
					    $contents['destination_longitude']=$row1['endTrip_destinationlongitude'];
					 }

				    // $contents['source_address']=$row1['source_landmark'];
				    // $contents['source_latitude']=$row1['source_latitude'];
				    // $contents['source_longitude']=$row1['source_longitude'];

				    // $contents['destination_address']=$row1['destination_landmark'];
				    // $contents['destination_latitude']=$row1['destination_latitude'];
				    // $contents['destination_longitude']=$row1['destination_longitude'];

				    $contents['tripdatetime']=$row1['tripdatetime'];
				    $contents['trip_distance']=$row1['trip_distance'];
				    $contents['trip_ammount']=$row1['trip_ammount'];
				    $contents['trip_type']=$row1['trip_type'];
				    // $contents['destination_address']=$row1['destination_address'].','.$row1['destination_city'].','.$row1['destination_state'].','.$row1['destination_country'].','.$row1['destination_zip'];
				    $contents['customer_rating']=$row1['driver_rateing'];
				    
				    if($row1['contact_number'] == '')
				    {
				    	$contents['contact_number'] ="";
				    }
				    else
				    {
				        $contents['contact_number']=$row1['contact_number'];
				    }
                    if($row1['name'] == '')
				    {
				    	$contents['driverName']="";
				    }
				    else
				    {
				       $contents['driverName']=$row1['name'];
				    }
				    if($row1['companyname'] == '')
				    {
				    	$contents['companyname']="";
				    }
				    else
				    {
				    $contents['companyname']=$row1['companyname'];
				    }
				    if($row1['vehicle_number'] == '')
				    {
				    	$contents['taxiNumber']="";
				    }
				    else
				    {
				    $contents['taxiNumber']= $row1['vehicle_number'];
				    }
				    if($row1['image'] == "")
				    {
				    	$contents['driverImage']="";
				    }
				    else
				    {
				    $contents['driverImage'] = TAXI_URL.$row1['image'];
				    }
				   
				 //    if($row1['status']=='0')
				 //    {
				 //    	$contents['status']="Request Taxi";
				 //    }
				 //    if($row1['status']=='200')
				 //    {
				 //    	$contents['status']="Driver Accept Trip";
				 //    }
				 //    if($row1['status']=='201')
				 //    {
				 //    	$contents['status']="Drvier arrived";
				 //    }
				 //    if($row1['status']=='202')
				 //    {
				 //    	$contents['status']="Start Trip";
				 //    }
					// if($row1['status']=='500')
				 //    {
				 //    	$contents['status']="End Trip";
				 //    }
					// if($row1['status']=='600')
				 //    {
				 //    	$contents['status']="Trip Cancelled By Customer";
				 //    }
				    if($row1['status']=='0')
				    {
				    	$contents['status']="solicitud de taxi";
				    }
				    if($row1['status']=='200')
				    {
				    	$contents['status']="Acepta el controlador de viaje";
				    }
				    if($row1['status']=='201')
				    {
				    	$contents['status']="conductor llegó";
				    }
				    if($row1['status']=='202')
				    {
				    	$contents['status']="Comenzar Viaje";
				    }
					if($row1['status']=='500')
				    {
				    	$contents['status']="Terminar Viaje";
				    }
					if($row1['status']=='600')
				    {
				    	$contents['status']="Viaje cancelado por el Usuario";
				    }

				    //$contents['driverImage']= $row1['image'];
				    $contents['travelTime']= $row1['travelTime'];
				    $contents['user_comment']= $row1['user_comment'];
				   // $contents['driverImage']= $row1['image'];
					$thang[] = $contents;
				    }					
					if($row['month']=="1") {   $mm='Enero'.' '.$row['year']; }
					elseif($row['month'] =="2") {   $mm ='Febrero'.' '.$row['year']; }	
					elseif($row['month']=="3")  {   $mm ='Marzo'.' '.$row['year']; }	
					elseif($row['month']=="4")  {   $mm ='Abril'.' '.$row['year']; }	
					elseif($row['month']=="5")  {   $mm ='Mayo'.' '.$row['year']; }	
					elseif($row['month']=="6")  {   $mm  ='Junio'.' '.$row['year']; }	
					elseif($row['month']=="7")  {   $mm ='Julio'.' '.$row['year']; }	
					elseif($row['month']=="8")  {   $mm ='Agosto'.' '.$row['year']; }	
					elseif($row['month']=="9")  {   $mm ='Setiembre'.' '.$row['year']; }	
					elseif($row['month']=="10") {   $mm ='Octubre'.' '.$row['year']; }	
					elseif($row['month']=="11") {   $mm ='Noviembre'.' '.$row['year']; }	
					elseif($row['month']=="12") {   $mm ='Diciembre'.' '.$row['year']; }
					$pp[$mm] =$thang;
					$thang = '';
					$contents = '';
					$month['name']=$mm;
					$aa[] = $month;
					}
					$msg['message']='Successfully';
					$msg['month']=$aa;
					$msg['result'][]=$pp;
					$msg['status']='200';
					echo json_encode($msg);
					 }
				 	 else
				 	{
			  		$msg['message']='Error';
			 		$msg['result'][]='No Data Found';
			 		$msg['status']='400';
			 		echo json_encode($msg);
				 	}
				 }
			 	else
			      {
					$msg['message'] = 'Error';
					$msg['result'][] = 'please send request';
					$msg['status'] = '600';
					echo json_encode($msg);
			      }
			}

// last Trip Address info 
function favorateAddress()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];		
	    $q = "SELECT * FROM trip WHERE customer_id='".$uid."'";
		$res=mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{
			    $contents = array();
 				$q3= "SELECT `trip`.id,`trip`.source_landmark,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_landmark,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.customer_id,`users`.credit_limit From `trip` 
 				LEFT JOIN `users` ON `trip`.customer_id=`users`.id
 				";
				$res3=mysql_query($q3) or die(mysql_error());
				$row2=mysql_fetch_assoc($res3)				;
				while($row1=mysql_fetch_array($res3))
				{	
				$contents = array(); 				
				$contents['uid'] = $row1['id']; 				 				
				$contents['source_landmark'] = $row1['source_landmark']; 				 				
				$contents['source_latitude'] = $row1['source_latitude']; 				 				
				$contents['source_longitude'] = $row1['source_longitude']; 				 				
				$contents['destination_landmark'] = $row1['destination_landmark']; 				 				
				$contents['destination_latitude'] = $row1['destination_latitude']; 				 				
				$contents['destination_longitude'] = $row1['destination_longitude']; 
				//$contents['refreshamount'] = $row1['credit_limit']; 
				$aa[]=$contents;				 				
			    }
			    //$content['refreshamount'] = $row2['credit_limit'];			    
				$msg['message']='successfull';
				$msg['result']=$aa;
				//$msg['result1']=$content;
				$msg['status']='200';
				echo json_encode($msg);
		}
	else
		{
			$contents['msg'] = 'error';
			$msg['message']='Cancel Taxi';
			$msg['result']=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
}	
}

// function getDriver()
// {
// 			$query1 = "SELECT * From `driver` where login_status='1'";
// 	    	$result1=mysql_query($query1);	    	
// 	    	$neer2 = array();
// 			while($row1 = mysql_fetch_assoc($result1))
// 			{
// 					$query2 = "SELECT * From `trip_log`  where driver_id='".$row1['id']."'  ORDER BY id desc LIMIT 1";
// 	    			$result2=mysql_query($query2);
// 	    			while($row2 = mysql_fetch_assoc($result2))
// 					{
// 			            $neer1['latitude'] = $row2['latitude'];
// 			            $neer1['longitude'] = $row2['longitude'];
// 						$neer1['driver_id'] = $row1['id'];
// 						$neer1['username'] = $row1['username'];
// 						$neer1['mobile'] = $row1['contact_number'];	
// 					}	
// 					$neer2[] = $neer1;
// 			}
// 	    	//$contents['user_type']=$user_type;
// 	    	$msg['message']='Driver Get Successfully';
// 	    	$msg['result']=$neer2;
// 	    	$msg['status']='200';  
// 	    	echo json_encode($msg); 
// }

function getDriver()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$latitute=$data[0]['latitute'];
 	    $longitude=$data[0]['longitude'];
		$query1 = "SELECT * From `driver` where login_status='1'";
		//$query1 = "SELECT * From `trip_log` where status='0'";
    	$result1=mysql_query($query1);	    	
    	$neer2 = array();
		while($row1 = mysql_fetch_array($result1))
		{
				$distane_lat_long = ",( 6371 * acos( cos( radians({$latitute}) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians({$longitude}) ) + sin( radians({$latitute}) ) * sin( radians( `latitude` ) ) ) ) AS distance";
    		    $query3="SELECT * $distane_lat_long
				FROM `trip_log` where driver_id='".$row1['id']."' and status='0' HAVING distance <= 100 ORDER BY `trip_log`.id DESC LIMIT 1 ";
				$result3=mysql_query($query3);
    			while($row3 = mysql_fetch_array($result3))
				{
					//echo $row3['driver_id'];
		            $neer1['latitude'] = $row3['latitude'];
		            $neer1['longitude'] = $row3['longitude'];
					$neer1['driver_id'] = $row1['id'];
					$neer1['username'] = $row1['username'];
					$neer1['mobile'] = $row1['contact_number'];	
				}	
				$neer2[] = $neer1;
				
		}
		//print_r($neer2[0]);
		if($neer2[0] == "")
		{
			//echo "sss";
			$msg['message']='Error';
	    	$msg['result']='No Data Available';
	    	$msg['status']='400';  
	    	echo json_encode($msg);
		}
		else
		{
	    	//$contents['user_type']=$user_type;
	    	$msg['message']='Driver Get Successfully';
	    	$msg['result']=$neer2;
	    	$msg['status']='200';  
	    	echo json_encode($msg); 
    	}
      }
}

function PayPayment() {
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if (!empty($data['0'])) {
        $uid = $data[0]['uid'];
        //ptint_r($data);
        // $str1="select * from `users` where id='$uid'";
        $queryTotal = mysql_fetch_array(mysql_query("SELECT SUM( amount ) AS totalamt FROM manage_master_amount WHERE crop_mb_u_id = '$uid'"));
        /*$str1 = "SELECT `trip`.customer_id,`trip`.trip_ammount,`manage_master_amount`.amount FROM `trip`
		       LEFT JOIN `manage_master_amount` ON `trip`.customer_id = `manage_master_amount`.crop_mb_u_id where `trip`.customer_id='$uid' and `trip`.payment_mode = 'credit' ";*/
        $str1 = "SELECT `trip`.customer_id,`trip`.trip_ammount FROM `trip` where `trip`.customer_id='$uid' and `trip`.payment_mode = 'credit' ";
        $res1 = mysql_query($str1);
        $num1 = mysql_num_rows($res1);
        if ($num1 == '0') {
            $string = "select amount from `manage_master_amount` where crop_mb_u_id='".$uid."'";
            $result = mysql_query($string);
            $rowString = mysql_fetch_assoc($result);
            $final['refreshamount'] = $rowString['amount'];
        } else {
            while ($row1 = mysql_fetch_assoc($res1)) {
                $value +=$row1['trip_ammount'];
                //$value1 += $row1['amount'];
            }
            $value1 = $queryTotal['totalamt'];
           
            $final['refreshamount'] = $value1 - $value;
        }

        $msg['message'] = 'successfull';
        $msg['result'][] = $final;
        $msg['status'] = '200';
        //$msg['result']=$final;
        echo json_encode($msg);
    } else {
        $contents['msg'] = 'error';
        $msg['message'] = 'Error';
        $msg['result'][] = $contents;
        $msg['status'] = '400';
        echo json_encode($msg);
    }
}

//Customer boarded
function boardedTrip()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$driverId=$data[0]['driverId'];		
		$tripId=$data[0]['tripId'];
		$dateTime=$data[0]['dateTime'];
		$latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
		$q1 = "SELECT * FROM trip WHERE id='".$tripId."'";
		$res=mysql_query($q1) or die(mysql_error());
		$q2="UPDATE trip SET status='202',driver_id='".$driverId."' where id='".$tripId."'";
		mysql_query($q2) or die(mysql_error());
		if($res)
		{
        $q3= "SELECT `trip`.id,`trip`.customer_id,`driver`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`driver`.vehicle_name,`driver`.vehicle_number,`taxicompany`.name
        From `trip` 
        LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        WHERE `trip`.id ='".$tripId."' ";
		$res3=mysql_query($q3) or die(mysql_error());
		$row1=mysql_fetch_assoc($res3);
	    $gcm_regid=$row1['device_id'];
        $contents = array(); 	
		$contents['message'] = "yes";
		/*$contents['mobile'] = $row1['contact_number'];
		$contents['taxicompany'] = $row1['name']; 
		$contents['vehicalname'] = $row1['vehicle_name']; 
		$contents['vehicle_number'] = $row1['vehicle_number'];*/
	    $registatoin_ids = array($gcm_regid);
		$message = array("borded" => $contents);
	    send_notification($registatoin_ids, $message);
		$msg['message']='successfull';
		$msg['result']=$contents;
		$msg['status']='200';
		echo json_encode($msg);
	}	
	else
	{
		$contents['msg'] = 'error';
		$msg['message']='Error';
		$msg['result']=$contents;
		$msg['status']='100';
		echo json_encode($msg);
	}
	}
	else
	{
		$contents['msg'] = 'error';
		$msg['message']='Error';
		$msg['result'][]=$contents;
		$msg['status']='400';
		echo json_encode($msg);
	}

}

function startTrip1()
{			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
    {
    	
    //	date_default_timezone_set('asia/kolkata');
     //   $dateTime=date('Y-m-d H:i:s');
	    $uid=$data[0]['uid'];
	    $latitute=$data[0]['latitute'];
		$longitude=$data[0]['longitude'];
		$sourcefulladdress=$data[0]['sourcefulladdress'];
		$sourcelatitude=$data[0]['sourcelatitude'];	
		$sourcelongitude=$data[0]['sourcelongitude'];
		$account_type=$data[0]['account_type'];

		$str20="select * from `users` where id='$uid'";
		$str20 = "SELECT c.company_id,u.added_by FROM `users` u left join `corporate` c on u.added_by=c.web_user_id where 1 and u.id = '$uid'";
		$res20=mysql_query($str20);
		$row20=mysql_fetch_array($res20);
        //$row20['added_by'];
		$value='';$msg='';
		$map = " ( 3959 * acos( cos( radians('$sourcelatitude') ) * cos( radians( a_latitude ) ) * cos( radians( a_longitude ) - radians('$sourcelongitude') ) + sin( radians('$sourcelatitude') ) * sin( radians( a_latitude ) ) ) ) AS distance ";
		$condition = " and a_latitude IS NOT NULL AND a_longitude IS NOT NULL ";
		$having = " HAVING distance BETWEEN 0 AND 500 ";
	   // $str="select a.*,$map from colony as a where 1 $condition $having and taxi_company_id='$uid'";
	    $str="select a.*,$map from `colony` as a where 1 $condition $having and taxi_company_id='".$row20['company_id']."'";
		$res=mysql_query($str);
		if(mysql_affected_rows()>0)
		{
			while($row1=mysql_fetch_array($res))
			{
			$contents1['destination_landmark'] = rtrim($row1['b_address']); 				 				
			$contents1['destination_latitude'] = rtrim($row1['b_latitude']); 				 				
			$contents1['destination_longitude'] = rtrim($row1['b_longitude']);
			$contents1['destination_amount'] = rtrim($row1['fare']);
			$value[]=$contents1;
			}
		    $msg['message']='successfull';
			$msg['result']=$value;
			$msg['status']='200';
			echo json_encode($msg);
		}
		else
		{
		    $contents['msg'] = 'error';
			$msg['message']='Data Not Found';
			//$msg['result'][]=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
    }
}

function getColonies()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$uid=$data[0]['uid'];	

		$q11 = "SELECT * From users where id='$uid'";
		$res1=mysql_query($q11) or die(mysql_error());
		$corporateId = '';
		if(mysql_affected_rows()>0)
		{
			$row1=mysql_fetch_array($res1);
			$corporateId = $row1['corporate_id'];
		}

		$q1 = "SELECT * From corporate_colony where corporate_id='$corporateId'";
		$res=mysql_query($q1) or die(mysql_error());
		if(mysql_affected_rows()>0)
		{		
		while($row=mysql_fetch_array($res))
		{
			$row['colonyA'];
			$str1="select * from colony where id='".$row['colonyA']."'";
			$res1=mysql_query($str1);
			while($row1=mysql_fetch_array($res1))
			{
				$contents['id']=$row1['id'];
				$contents['source_name']=$row1['name_A'];
				$contents['destination_name']=$row1['name_B'];
				$contents['source_address']=$row1['a_address'];
				$contents['destination_address']=$row1['b_address'];
				$contents['fare']=$row1['fare'];
				$contents['km_distance']=$row1['km_distance'];
				$contents['taxi_company_id']=$row1['taxi_company_id'];
				$contents['description']=$row1['description'];
			
				$contents['source_city']=$row1['a_city'];
				$contents['source_state']=$row1['a_state'];
				$contents['source_postal_code']=$row1['a_postal_code'];
				$contents['destination_city']=$row1['b_city'];
				$contents['destination_state']=$row1['b_state'];
				$contents['destination_postal_code']=$row1['b_postal_code'];
				$value[]=$contents;
			}
		}
		    $msg['message']='successfull';
			$msg['result']=$value;
			$msg['status']='200';
			echo json_encode($msg);
	}	
	else
	{
		$contents['msg'] = 'error';
		$msg['message']='Error';
		$msg['result'][]=$contents;
		$msg['status']='400';
		echo json_encode($msg);
	}
}
}

function getNotification()
{
	$contents=array();
	//echo "hello";
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{ 
		//$str="select * from send_message GROUP BY driver_name ORDER BY ID DESC";
		//$str1="select DISTINCT corporate_user, from send_message ";
		// $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
		//      LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id GROUP BY corporate_user ORDER BY messageId DESC";
	    $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
		     LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id "; 
		$res=mysql_query($str);
		if($res)
		{
			while($row=mysql_fetch_array($res))
			{
				$contents['adminmessage']=base64_decode($row['message']);
				//$contents['device_id']=$row['device_id'];
				$contents['image']='http://www.hvantagetechnologies.com/central-taxi/images/logo.png';
				//$value=$contents;
				$getDriverDevice[]=$row['device_id'];
				// $registatoin_ids = $row['device_id'];
		  //   	$message = array("admin" => $value );	 
	   //      	send_notification($registatoin_ids, $message);
			}

			$registatoin_ids = $getDriverDevice;
		    $message = array("admin" => $contents );	 
	        send_notification($registatoin_ids, $message);
		    
		    $msg['message']='successfull';
			$msg['result']=$contents;
			$msg['status']='200';
			echo json_encode($msg);
		}	
		else
		{
			$contents['msg'] = 'error';
			$msg['message']='Error';
			$msg['result'][]=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
	}
}

function getAdminNotification()
{
	$contents=array();
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{ 
		$user_id=$data[0]['user_id'];
		//$str="select * from send_message GROUP BY driver_name ORDER BY ID DESC";
		//$str1="select DISTINCT corporate_user, from send_message ";
		// $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
		//      LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id GROUP BY corporate_user ORDER BY messageId DESC";
	    // $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
		   //   LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id "; 
		$str="SELECT `send_message`.location_address,`send_message`.latitude,`send_message`.longitude,`send_message`.corporate_user,`send_message`.message,`users`.id,`send_message`.heading,`users`.name FROM `send_message`
		      LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id where `users`.id='".$user_id."' or `send_message`.corporate_user='0'";
		$res=mysql_query($str);
		if(mysql_affected_rows()>0)
		{
			while($row=mysql_fetch_array($res))
			{				
				$contents['title']=$row['heading'];				
				$contents['adminmessage']=base64_decode($row['message']);
				$contents['latitude']=$row['latitude'];				
				$contents['longitude']=$row['longitude'];				
				$contents['location_address']=$row['location_address'];				
				$thang[]=$contents;			
			}
		    $msg['message']='successfull';
			$msg['result']=$thang;
			$msg['status']='200';
			echo json_encode($msg);
		}	
		else
		{
			$contents['msg'] = 'Sorry no data found';
			$msg['message']='Error';
			$msg['result'][]=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
	}
}

function getCurrentDriverInfo()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$customer_id=$data[0]['customer_id'];		
		$driverId=$data[0]['driverId'];
		$sql = mysql_query("select * from `trip_log` where `driver_id` = '$driverId' order by `id` DESC");
		$row = mysql_fetch_object($sql);
		$list['driver_id'] = $row->driver_id;
		$list['latitude'] = $row->latitude;
		$list['longitude'] = $row->longitude;
		$nee[] = $list;
		$msg['message']='Success';
	    $msg['result']=$nee;
	    $msg['status']='200';  
	    echo json_encode($msg);			
	}
	else
	{
		$contents['msg'] = 'error';
		$msg['message']='Error';
		$msg['result'][]=$contents;
		$msg['status']='400';
		echo json_encode($msg);
	}
}

// Function for payment mode by customer
function paymentMode()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
         $customer_id = $data[0]['uid'];
         $trip_id = $data[0]['tripId'];
         $mode = $data[0]['paymentMode'];

         $str="SELECT `trip`.id,`trip`.driver_id,`driver`.id,`driver`.device_id from `trip` LEFT JOIN `driver` ON `trip`.driver_id = `driver`.id where `trip`.id='".$trip_id."'";
         $res=mysql_query($str);
         $row=mysql_fetch_array($res);
         $gcm_regid=$row['device_id'];

         if($mode == 'credit')
         {
           $getData = "update `trip` set payment_mode='".$mode."' where `trip`.id = '".$trip_id."' ";
           $result=mysql_query($getData);
           //echo $numrows=mysql_num_rows($result);
	           if($result)
	           {
	           	 $msg['message']='Success';
	             $msg['result']="credit";
	             $msg['status']='200';  
	             echo json_encode($msg);   
	           }

           $registatoin_ids = array($gcm_regid);
     	   $message = array("paymentmode" => "credit");
	       send_notification($registatoin_ids, $message);
         }
         else
         {
           $getData1 ="update `trip` set payment_mode='".$mode."' where `trip`.id='".$trip_id."'";
           $result1=mysql_query($getData1);
           //$numData1=mysql_num_rows($result1);
	           if($result1)
	           {
	           	 $msg['message']='Success';
	             $msg['result']="cash";
	             $msg['status']='200';  
	             echo json_encode($msg);   
	           }

           $registatoin_ids = array($gcm_regid);
     	   $message = array("paymentmode" => "cash");
	       send_notification($registatoin_ids, $message);
         }
	}
}