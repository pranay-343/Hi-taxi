<?php
include '../include/define.php';
include '../include/config.php';
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
    elseif($method == 'changePassword')
    {
        changePassword();
	}
    elseif($method == 'logout')
    {
        logout();
    }
    elseif($method == 'updateProfile')
    {
        updateProfile();
    }
     elseif($method == 'cancel')
    {
        cancel();
    }
     elseif($method == 'getDriver')
    {
        getDriver();
    }
    elseif($method == 'sendMessage')
    {
        sendMessage();
    }
    elseif($method == 'tripHistory')
    {
        tripHistory();
    }
    elseif($method == 'feedback')
    {
        feedback();
    }
     elseif($method == 'emailVerification')
     {
         emailVerification();
     }
     elseif($method == 'emailVerification_1')
     {
         emailVerification_1();
     }
     elseif($method == 'panic')
    {
        panic();
    }
    elseif($method == 'boardedTrip')
    {
        boardedTrip();
    }
	elseif($method == 'getCurrentDriverInfo')
    {
        getCurrentDriverInfo();
    }
    elseif($method == 'companyDriver')
    {
        companyDriver();
    }
  }

  function emailVerification_1()
  {
  	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
    {
        $customer_id=$data[0]['customer_id'];
	    $editemail=$data[0]['email'];
	    $str="select * from `users` where `id` = '".$customer_id."' and `account_type` = '7' and `email_id` = '".$editemail."'";
	    $res=mysql_query($str);
	    $row=mysql_fetch_assoc($res);
	    if($row['email_verify'] == '1')
	    {
	    	$contents['verifyEmail']='Yes';
	    	//$msg['message']='Your email is already verified';
	    	$msg['message']='Yes';
	    	$msg['result']=$contents;
	    	$msg['status']='200';
	    	echo json_encode($msg);
	    }
	    else
	    {
	    	$contents['verifyEmail']='No';
	    	$msg['message']='No';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
	    }
	}
  }

//
function startTrip()
{			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
    {
        date_default_timezone_set('asia/kolkata');
        $dateTime=date('Y-m-d H:i:s');
	    $streetnumber=$data[0]['streetnumber'];
	    $tripType=$data[0]['tripType'];
		$currentlongitude=$data[0]['currentlongitude'];	
		$currentlatitute=$data[0]['currentlatitute'];
		$destination_lat=$data[0]['destination_lat'];
		$companyname=$data[0]['companyname'];

		$sourcelatitute=$data[0]['sourcelatitute'];
		$sourcelongitude=$data[0]['sourcelongitude'];
		
		$account_types=$data[0]['account_type'];
		$destinationaddress=$data[0]['destinationaddress'];
		$description=$data[0]['description'];
		$sourceaddress=$data[0]['sourceaddress'];
		$destination_lon=$data[0]['destination_lon'];
		$customer_id=$data[0]['customer_id'];
		$device_id=$data[0]['regId'];
		$device_type = $data[0]["device_type"];
		$server_gmt=$data[0]['server_gmt'];
		$status='0';
                
                // For current GMT Start
                
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
        function distance1($point1_lat, $point1_lng, $point2_lat, $point2_lng, $unit) 
        { 
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
        if($destinationaddress == '' || $sourceaddress == '')
        {
            $distance ='0';
        }
        else
        {
        $distance=ceil(distance1($point1_lat, $point1_lng, $point2_lat, $point2_lng, "k"));
        }
		if($device_id=="" || $account_types=="")
		{
            $contents['msg']='Plz enter divce_id and account_types';
	    	$msg['message']='Error in Submition';
	    	$msg['result']=$contents;
	    	$msg['status']='400';
	    	echo json_encode($msg);
		}
	   else
	   {
	     	$str55="update users set device_id='".$device_id."' where id='".$customer_id."'";
            $res55=mysql_query($str55);
	   $q = "INSERT INTO `trip`(`current_latitude`,`current_longitude`,`source_latitude`,`source_longitude`,`source_address`,`destination_latitude`,`destination_longitude`,`destination_address`,`description`,`customer_id`,`device_id`,`account_type`,`streetnumber`,`company_name`,`trip_type`,`trip_distance`,`tripdatetime`,`status`,`device_type`)
		 VALUES ('$currentlatitute','$currentlongitude','$sourcelatitute','$sourcelongitude','$sourceaddress','$destination_lat','$destination_lon','$destinationaddress','$description','$customer_id','$device_id','$account_types','$streetnumber','$companyname','$tripType','$distance','$dateTime','$status','$device_type')";
   	    $res=mysql_query($q) or die(mysql_error());
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

//cancel trip

function cancel()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];
		$tripId=$data[0]['trip_id'];
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
				$contents['canceltaxirequest'] = $canceltaxirequest; 
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

//companyDriver
function companyDriver()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
 	    $companyId=$data[0]['selectcompanyid'];
    if($companyId !="0")
    {
 	    $str="SELECT `taxicompany`.id,`taxicompany`.web_user_id,`driver`.company_id,`driver`.id as driverID,`driver`.name FROM `taxicompany`
 	          LEFT JOIN `driver` ON `taxicompany`.web_user_id = `driver`.company_id where `taxicompany`.id='".$companyId."'";
 	    $res=mysql_query($str);
 	    while($row=mysql_fetch_array($res))
 	    {
          $driverId[]=$row['driverID'];
 	    } // end while looop
 	    for($i=0;$i<count($driverId);$i++)
        {
        $str2="select login_status,name,contact_number from `driver` where id='".$driverId[$i]."'";
        $res2=mysql_query($str2);
        $row2=mysql_fetch_assoc($res2);
        if($row2['login_status'] == '1' )
        {
 	    $str1="select `latitude`,`longitude` from `trip_log` where driver_id='".$driverId[$i]."' order by id desc limit 1";
 	    $res1=mysql_query($str1);
 	    $row1=mysql_fetch_array($res1);
 	    
        $contents['driverId'] = $driverId[$i];
        $contents['username'] = $row2['name'];
        $contents['mobile'] = $row2['contact_number'];
 	    $contents['latitude'] = $row1['latitude'];
 	    $contents['longitude'] = $row1['longitude'];
        $thmsg[] = $contents;
        }
        } // end for loop
        if($contents != '')
        {
            $msg['message']='Successfull';
            $msg['result']=$thmsg;
            $msg['status']='200';  
            echo json_encode($msg);
        }
        else
        {
            $msg['message']='Error';
            $msg['result']='No Driver login in your area';
            $msg['status']='400';  
            echo json_encode($msg);
        }
     }
     else
     {
     	//$str2="select login_status,name,contact_number from `driver` where id='".$driverId[$i]."'";
     	$str2="select * from `driver` where login_status='1' ";
        $res2=mysql_query($str2);
       // $row2=mysql_fetch_assoc($res2);
        while($row2=mysql_fetch_array($res2))
 	    {
         // $driverId=$row2['driver_id'];
 	    $str1="select `latitude`,`longitude`,`driver_id` from `trip_log` where `driver_id` ='".$row2['id']."' order by id desc limit 1";
 	    $res1=mysql_query($str1);
 	    $row1=mysql_fetch_array($res1);
 	    
        $contents['driverId'] = $row1['driver_id'];
        $contents['username'] = $row2['name'];
        $contents['mobile'] = $row2['contact_number'];
 	    $contents['latitude'] = $row1['latitude'];
 	    $contents['longitude'] = $row1['longitude'];
        $thmsg[] = $contents;
        }
        if($contents != '')
        {
            $msg['message']='Successfull';
            $msg['result']=$thmsg;
            $msg['status']='200';  
            echo json_encode($msg);
        }
        else
        {
            $msg['message']='Error';
            $msg['result']='No Driver login in your area';
            $msg['status']='400';  
            echo json_encode($msg);
        }
     }   
 	}
}

// Get All Online Driver Info
function getDriver()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$latitute=$data[0]['latitute'];
 	    $longitude=$data[0]['longitude'];
 	    $customer_id=$data[0]['customer_id'];
 	    $strEmail="select email_verify from users where id='".$customer_id."'";
 	    $resEmail=mysql_query($strEmail);
 	    $rowEmail=mysql_fetch_assoc($resEmail);
 	    if($rowEmail['email_verify'] == '0')
 	    {
 	    	$rowEmail="No";
 	    }
 	    else
 	    {
 	    	$rowEmail="Yes";
 	    }
			$query1 = "SELECT * From `driver` where login_status='1'";
	    	$result1=mysql_query($query1);	    	
	    	$neer2 = array();
			while($row1 = mysql_fetch_array($result1))
			{
			$distane_lat_long = ",( 6371 * acos( cos( radians({$latitute}) ) * cos( radians( `latitude` ) ) * cos( radians( `longitude` ) - radians({$longitude}) ) + sin( radians({$latitute}) ) * sin( radians( `latitude` ) ) ) ) AS distance";
			$query3="SELECT * $distane_lat_long
			FROM `trip_log` where driver_id='".$row1['id']."' and status='0' HAVING distance <= 10 ORDER BY `trip_log`.id DESC LIMIT 1 ";
			$result3=mysql_query($query3);
			while($row3 = mysql_fetch_array($result3))
			{
				//echo $row3['driver_id'];
	            $neer1['latitude'] = $row3['latitude'];
	            $neer1['longitude'] = $row3['longitude'];
				$neer1['driver_id'] = $row1['id'];
				$neer1['username'] = $row1['username'];
				$neer1['mobile'] = $row1['contact_number'];	
				$neer1['verifyEmail'] = $rowEmail;	
			}	
			$neer2[] = $neer1;
			}
	    	if($neer2[0] == "")
		{
			$msg['message']='Error';
	    	$msg['result']='No Data Available';
	    	$msg['status']='400';  
	    	echo json_encode($msg);
		}
		else
		{
	    	$msg['message']='Driver Get Successfully';
	    	$msg['result']=$neer2;
	    	$msg['status']='200';  
	    	echo json_encode($msg); 
    	}
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
		$account_type=$data[0]['account_type'];
		$q="INSERT INTO `customer_sendMessage`(`customer_id`,`message`,`trip_id`,`account_type`)VALUES ('$uid','$message','$tripId','$account_type')";
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
	   	 
	   	 

		$str="select DISTINCT MONTH(tripdatetime) as month, YEAR(tripdatetime) as year  from `trip` where customer_id = '".$uid."' $fdate";
		 $res=mysql_query($str) or die(mysql_error());
		 if(mysql_num_rows($res) > 0)
		  {
			while($row=mysql_fetch_array($res))
			{
	 			$str1 = "SELECT `trip`.endTrip_sourceaddress,`trip`.endTrip_sourcelatitude,`trip`.endTrip_sourcelongitude,`trip`.endTrip_destinationaddress,`trip`.endTrip_destinationlatitude,`trip`.endTrip_destinationlongitude,`trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.user_comment,`trip`.source_country,`trip`.account_type,`trip`.streetnumber,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.tripdatetime,`trip`.trip_type,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_zip,`trip`.destination_landmark,`trip`.destination_country,`driver`.name,`driver`.image,`driver`.contact_number,`driver`.vehicle_number,`trip`.status,`trip`.trip_ammount,`trip`.trip_distance,`trip`.travelTime,`trip`.customer_rating,`trip`.driver_rateing,`taxicompany`.name as companyname FROM `trip` 
			 		LEFT JOIN `driver` ON `trip`.driver_id =`driver`.id
			 		LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
			 		where MONTH(`tripdatetime`) = '".$row['month']."' AND YEAR(`tripdatetime`) = '".$row['year']."' AND customer_id = '".$uid."' and `trip`.status !='0' $fdate ORDER BY id desc";
				$res1=mysql_query($str1) or die(mysql_error());
				while($row1=mysql_fetch_array($res1))
				{
					$contents['id']=$row1['id'];
				    // $contents['source_address']=$row1['source_address'].','.$row1['source_city'].','.$row1['streetnumber'].','.$row1['source_country'].','.$row1['source_zip'];
				    // if($row1['endTrip_sourceaddress']=='' && $row1['endTrip_sourcelatitude']=='' && $row1['endTrip_sourcelongitude']=='' && $row1['endTrip_destinationaddress']=='' && $row1['endTrip_destinationlatitude']='' && $row1['endTrip_destinationlongitude'])
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
				    $contents['tripdatetime']=$row1['tripdatetime'];
				    $contents['trip_distance']=$row1['trip_distance'];
				    $contents['trip_ammount']=$row1['trip_ammount'];
				    $contents['trip_type']=$row1['trip_type'];
				    // $contents['destination_address']=$row1['destination_address'].','.$row1['destination_city'].','.$row1['destination_state'].','.$row1['destination_country'].','.$row1['destination_zip'];
				    $contents['customer_rating']=$row1['driver_rateing'];
				    if($row1['image'] == "")
				    {
				    	$contents['driverImage']="";
				    }
				    else
				    {
				        $contents['driverImage'] = TAXI_URL.$row1['image'];
				    }
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

				   // $contents['driverImage']= $row1['image'];
				    $contents['travelTime']= $row1['travelTime'];
				    $contents['user_comment']= $row1['user_comment'];
				   // $contents['driverImage']= $row1['image'];
					$thang[] = $contents;
				    }					
					if($row['month']=="1") {   $mm='January'.' '.$row['year']; }
					elseif($row['month'] =="2") {   $mm ='February'.' '.$row['year']; }	
					elseif($row['month']=="3")  {   $mm ='March'.' '.$row['year']; }	
					elseif($row['month']=="4")  {   $mm ='April'.' '.$row['year']; }	
					elseif($row['month']=="5")  {   $mm ='May'.' '.$row['year']; }	
					elseif($row['month']=="6")  {   $mm  ='June'.' '.$row['year']; }	
					elseif($row['month']=="7")  {   $mm ='July'.' '.$row['year']; }	
					elseif($row['month']=="8")  {   $mm ='August'.' '.$row['year']; }	
					elseif($row['month']=="9")  {   $mm ='September'.' '.$row['year']; }	
					elseif($row['month']=="10") {   $mm ='October'.' '.$row['year']; }	
					elseif($row['month']=="11") {   $mm ='November'.' '.$row['year']; }	
					elseif($row['month']=="12") {   $mm ='December'.' '.$row['year']; }
					$pp[$mm] =$thang;
					//print_r($pp);
					$thang = '';
					$contents = '';
					$month['name']=$mm;
					//print_r($month);
					$aa[] = $month;
					//print_r($aa);
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
			 		$msg['status']='200';
			 		echo json_encode($msg);
				 	}
				 }
			 	else
			      {			

					$msg['message'] = 'Error';
					$msg['result'][] = 'please send request';
					$msg['status'] = '400';
					echo json_encode($msg);
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

	   $q="UPDATE `trip` SET feedback_latitude = '".$feedback_latitude."',feedback_longitude = '".$feedback_longitude."',user_comment = '".$customerComment."',customer_rating='".$customerRating."',account_type='".$account_type."' where id = '".$trip_id."' ";
        $res = mysql_query($q) or die(mysql_error());
	    $contents=array();
	    if(mysql_affected_rows() > 0)
	    {
	    	$contents['feedback_latitude'] = $feedback_latitude;
	    	$contents['feedback_longitude'] = $feedback_longitude;
	    	$contents['customerComment'] = $customerComment;
	    	$contents['customerRating'] = $customerRating;
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
		$panictaxirequest=$data[0]['panictaxirequest'];
	    $q="update `trip` set panictaxirequest ='".$panictaxirequest."' where id='".$trip_id."'";
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

// Email Verification For User
function emailVerification()
{
	 $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));

	if(!empty($data['0']))
	{
		$ID=$data[0]['ID'];
		$latitute=$data[0]['latitute'];
		$email=$data[0]['email'];
		$longitude=$data[0]['longitude'];		
		
		$str="select * from users where id='$ID'";
		$res=mysql_query($str);
		$row=mysql_fetch_assoc($res);		
		if($row['email_verify']=='1')
		{
	    $msg['message']='You have already verified';
		$msg['result']=$email;
		$msg['status']='100';
		echo json_encode($msg);
		}else
		{

			$to = $email;
			$base_url="http://www.hvantagetechnologies.com/central-taxi/";
			//$base_url2="http://www.hvantagetechnologies.com/central-taxi/activation/activation.php";
			$body='Hi, We need to make sure you are human. Please verify your email and get started using your Website account. <a href="http://www.hvantagetechnologies.com/central-taxi/activation/activation.php?id='.$ID.'">'.$base_url.'activation/'.$to.'</a>';
            $message = "your Email Verification link are show below:";
			$message = $message."Click Here - ".$body;	
			$message = $message."Thanks,";
			$message = $message."The taxi central Team";
			$subject = "Email Verification";
			
 		    $from = "Central Taxi : mmfinfotech253@gmail.com";
			//$headers = "From:" . $from;
			$headers .= "MIME-Version: Social App\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
			if(mail($to,$subject,$message,$headers))
			{
				$msg['message']='successfull';
				$msg['result']=$body;
				$msg['status']='200';
				echo json_encode($msg);
			}
			else
			{
			    $msg['message']='Error';
				$msg['result']=$contents;
				$msg['status']='400';
				echo json_encode($msg);	
			}
			}
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

// function distance($lat1, $lon1, $lat2, $lon2, $unit) {

//   $theta = $lon1 - $lon2;
//   $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
//   $dist = acos($dist);
//   $dist = rad2deg($dist);
//   $miles = $dist * 60 * 1.1515;
//   $unit = strtoupper($unit);

//   if ($unit == "K") {
//     return ($miles * 1.609344);
//   } 
// }

// $distance1 = distance($lat1, $lon1, $lat2, $lon2, "K") . " Kilometers";
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } 
}

 distance($lat1, $lon1, $lat2, $lon2, "K") . " Kilometers";



function getCurrentDriverInfo()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {      
        $customer_id=$data[0]['customer_id'];       
        $driverId=$data[0]['driverId'];
        $sql = mysql_query("select * from `trip_log` where `driver_id` = '$driverId' order by `id` DESC limit 1,5");
        $row = mysql_fetch_array($sql);
        
        $lat=   $row['latitude'];
        $lon=   $row['longitude'];
        


        $sql1 ="select * from `trip_log` where `driver_id` = '$driverId' order by `id` DESC limit 1";
        $res1= mysql_query($sql1);
        $row1=mysql_fetch_object($res1);        
        
        $list['driver_id'] = $row['driver_id'];
        $list2['latitude'] = $lat;
        $list2['longitude'] = $lon;
        $list['prelatitude'] = $row1->latitude;
        $list['prelongitude'] = $row1->longitude;
        $distance=distance($list2['latitude'],$list2['longitude'],$list['prelatitude'],$list['prelongitude'],'k')/1000;
        if($distance < 20)
        {
         $nee[] = $list;
        }
        else
        {
          $list1['prelatitude'] = $row1->latitude;
          $list1['prelongitude'] = $row1->longitude;
          $nee[] = $list1;
        }
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


