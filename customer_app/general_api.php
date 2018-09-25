<?php
include '../include/config.php';
OnLoad();

function OnLoad()
{
	$method = $_GET['method'];
	if($method == 'SignIn')
	{
		SignIn();
	}
 	elseif($method == 'registration')
    {
        registration();
    }
    elseif($method == 'forgot_password')
    {
        forgot_password();
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
    elseif ($method == 'SignIn_new') {
        SignIn_new();
    }
    elseif ($method == 'SignIn_check') {
        SignIn_check();
    }
}

// Profile Update for corporate
function updateProfile()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$uid=$data[0]['uid'];
		$email=$data[0]['editemail'];
		$longitude=$data[0]['longitude'];
		$latitude=$data[0]['latitute'];
		$mobile=$data[0]['editmobile'];
		$name=$data[0]['editname'];		
		$account_type=$data[0]['account_type'];		
		//$output = '';
		$q = "SELECT * FROM users WHERE id ='".$uid."' and  account_type='".$account_type."'";
		$res=mysql_query($q) or die(mysql_error());
		if(mysql_num_rows($res) > 0)
		{			
		$q2="UPDATE users SET email_id='".$email."',longitude='".$longitude."',latitude='".$latitude."',contact_no='".$mobile."',name='".$name."',account_type='".$account_type."' where id='".$uid."'";
		mysql_query($q2) or die(mysql_error());
		$contents = array();      
				$q3= "SELECT * FROM users WHERE id ='".$uid."'";
			$res3=mysql_query($q3) or die(mysql_error());
			$row1=mysql_fetch_assoc($res3);
			$contents['id'] = $row1['id']; 
			$contents['email'] = $row1['email_id']; 
			$contents['longitude'] = $row1['longitude'];
			$contents['latitude'] = $row1['latitude'];
			$contents['mobile'] = $row1['contact_no']; 
			$contents['name'] = $row1['name'];
			$contents['account_type'] = $row1['account_type'];
			$msg['message']='Update Successfully';
			$msg['result']=$contents;
			$msg['status']='200';
			echo json_encode($msg);
		}
	else
		{
			$contents['msg'] = 'error';
			$msg['message']='Error in Updation';
			$msg['result']=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
}	
}


// for send notification for device id
function send_notification($registatoin_ids, $message)
		{ 

         $url = 'https://android.googleapis.com/gcm/send';
		 $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $message,
        );
 
        $headers = array(
            'Authorization: key= AIzaSyAQ5Se4Tu1LmgZDAwQ-mguA73x__s8HsTY',
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

//forgot Password
function forgot_password()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0'])){
		$email=$data[0]['email'];
		$output = '';
	}
}

//logout
function logout()
{			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
	 $email=$data[0]['email'];
	 $account_type=$data[0]['account_type'];
	 $dateTime=$data[0]['dateTime'];
		//$output='';
		$q = "SELECT * FROM users WHERE email_id ='".$email."' and account_type='".$account_type."'";
		$res=mysql_query($q) or die(mysql_error());
		$contents = array();      
		if(mysql_num_rows($res) > 0)
		{	
			 $update_status = mysql_query("UPDATE `users` set `login_status` = '0',last_login_time='".$dateTime."'  where `email_id` ='$email'");	
			$row=mysql_fetch_assoc($res);
			//$contents['id'] = $row["id"];
			$contents['email'] = $row['email_id'];
			$contents['account_type'] = $row['account_type'];
			$msg['message']='Logout Successfully';
			$msg['result']=$contents;
			$msg['status']='200';
			echo json_encode($msg);		
		}
		else
		{
				$contents['msg'] = 'error';
				$msg['message']='Error in Logout';
				$msg['result']=$contents;
				$msg['status']='400';
				echo json_encode($msg);
		}
	}
}

//Registration
function registration()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$name=$data[0]['name'];		
		$email=$data[0]['email'];	
		$latitude=$data[0]['latitute'];	
		$longitude=$data[0]['longitude'];	
		$mobile=$data[0]['mobile'];			
		$gcm_regid = $data[0]["regId"];	
		$account_type=$data[0]["account_type"];
	   	$output = '';
    	$q1="select * from users where email_id='".$email."'";
    	$res1=mysql_query($q1);
	   	$row22=mysql_fetch_array($res1);
	    if(mysql_num_rows($res1)>0)
	   	{
	        $number=$row22['device_token']+1;
	        $id22 = $row22['id'];
			$q2="UPDATE users SET name='".$name."',email_id='".$email."',contact_no='".$mobile."',latitude='".$latitude."',longitude='".$longitude."',device_id='".$gcm_regid."',device_token='".$number."' where email_id='".$email."'";
			mysql_query($q2) or die(mysql_error());
			$id=mysql_insert_id();
	    	$contents['id']="$id22";
		   	$contents['name']=$name;
		   	$contents['email']=$email;
		   	$contents['mobile']=$mobile;
		   	$msg['message']='Update Successfully';
		   	$msg['result']=$contents;
		   	$msg['status']='200';  
		   	echo json_encode($msg);
		   	die();
	    }
	    if(isset($_RE))
	    if(mysql_num_rows($res1)==0)
	    {
		   $q="INSERT INTO `users`(`name`, `email_id`, `contact_no`,`device_id`,`longitude`,`latitude`,`account_type`)VALUES ('$name','$email','$mobile','$gcm_regid','$longitude','$latitude','$account_type')";
		    $res=mysql_query($q) or die(mysql_error());
		    $registatoin_ids = array($gcm_regid);
		    $message = array("message" => "You have successfully registered on GCM");			 
	        send_notification($registatoin_ids, $message);
		    $contents=array();
		    $neer1=array();
	    	$id=mysql_insert_id();
	   		$contents['id']="$id";
	    	$contents['name']=$name;
	    	$contents['email']=$email;
	    	$contents['mobile']=$mobile;
	    	$contents['latitute']=$latitude;
	    	$contents['longitude']=$longitude;
	    	$contents['account_type']=$account_type;
	    	$msg['message']='Registration Successfully';
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

// change password
function changePassword()
{		
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$uid=$data[0]['uid'];
		$oldPassword=md5($data[0]['oldPassword']);
		$newPassword=md5($data[0]['newPassword']);	
		$account_type=$data[0]['account_type'];
		$output = '';
		$q1 = "SELECT * FROM users WHERE password ='".$oldPassword."' and id = '".$uid."' and account_type='".$account_type."'";
		$res1=mysql_query($q1) or die(mysql_error());
		if(mysql_num_rows($res1) > 0)
		{	
			$q2="UPDATE users SET password='".$newPassword."' where id='".$uid."'";
			mysql_query($q2) or die(mysql_error());
			$contents = array();      
			$q3= "SELECT * FROM users WHERE id ='".$uid."'";
			$res3=mysql_query($q3) or die(mysql_error());
			$row1=mysql_fetch_assoc($res3);				
			$contents['password'] = $row1['password']; 
			$msg['message']='Password Change Successfully';
			$msg['result']=$contents;
			$msg['status']='200';
			echo json_encode($msg);		
		}	
		else
		{
			$contents['msg'] = 'error';
			$msg['message']='Password not matched';
			$msg['result']=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
	}
	else
	{
		$contents['msg'] = 'error';
		$msg['message']='Old Password not matched';
		$msg['result'][]=$contents;
		$msg['status']='400';
		echo json_encode($msg);
	}
}

//sign in
function SignIn()
	{
 		$i=0;
		$pic="image";
		$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
		$email=$data[0]['email'];
		$password= md5($data[0]['password']);
		$latitude=$data[0]['latitude'];
		$longitude=$data[0]['longitude'];
		$device_id=$data[0]['device_id'];
		$device_type = $data[0]["device_type"];
		$dateTime=$data[0]['dateTime'];
		$server_gmt=$data[0]['server_gmt'];
		
                $server_gmt_ori =str_replace('GMT', '', $server_gmt);
                // For server current time
                $offset = $server_gmt_ori;
		list($hours, $minutes) = explode(':', $offset);
                $seconds = $hours * 60 * 60 + $minutes * 60;
                $tz = timezone_name_from_abbr('', $seconds, 1);
                if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
                date_default_timezone_set($tz);
               
                $date_time =  date('Y-m-d H:i:s');
                
                $date_server_login= date('Y-m-d');
                $time_server_login= date('H:i:s');
                $time_zone_server= $tz;
		$q = "SELECT id,corporate_id,name,email_id,contact_no,city,zip_code,credit_limit,username,account_type,credit_limit FROM `users` WHERE `email_id` = '$email' and password = '$password'";
		$res=mysql_query($q) or die();  
		$contents = array();     
		if(mysql_num_rows($res) <= 0)
			{	
				$thmsg = array("msg"=>'Id Password not matched');
				$msg['message']='Error';
				$msg['result'][]=$thmsg;
				$msg['status']='400';
				echo json_encode($msg);
			}
			else
			{
				//
				$row=mysql_fetch_assoc($res);
				//echo $row["id"];
				if($row['corporate_id'] != '' || $row['corporate_id'] != null)
				{
					$query = mysql_fetch_assoc(mysql_query("select name from `corporate` where 1 and web_user_id = '".$row['corporate_id']."'"));
				}
				else
				{
					$query['name'] = '';
				}
				$update_status = mysql_query("UPDATE `users` set `login_status` = '1'  where `email_id` ='$email'");	
			    $updateUserr = "update `users` set `latitude`='$latitude',last_login_time='".$date_time."',`longitude`='$longitude',`device_id`='$device_id',`device_type`='$device_type',`date_server_login`='$date_server_login',`time_server_login`='$time_server_login',`time_zone_server`='$time_zone_server',`utc_server`= '$server_gmt_ori' where id='".$row["id"]."'";
			    $qry = mysql_query($updateUserr);

				$contents['companyName'] = $query['name'];
				$contents['id'] = $row["id"];
				$contents['name'] = $row["name"];			
				$contents['email'] = $row['email_id']; 
				$contents['contact_no'] = $row['contact_no']; 	
				$contents['city'] = $row["city"];
				$contents['zip_code'] = $row["zip_code"];
				$contents['credit_limit'] = $row["credit_limit"];
				$contents['username'] = $row["username"];
				$contents['account_type'] = $row["account_type"];
				$contents['date_server_login'] = $date_server_login;
				$contents['time_server_login'] = $time_server_login;
				$contents['time_zone_server'] = $time_zone_server;
				$contents['server_gmt_ori'] = $server_gmt_ori;
				$str500="select trip_ammount from trip where customer_id='".$row['id']."'";
				$res500=mysql_query($str500);
				while($row501=mysql_fetch_assoc($res500))
		        {
		        	$value501 +=$row501['trip_ammount'];
		            //$value502 =$row['credit_limit'];
		        }
                        
                                $query_amt= "SELECT SUM(amount) as totalAMt FROM manage_master_amount WHERE crop_mb_u_id = '".$row['id']."'";
                                $res_Amt = mysql_query($query_amt);
                                $rowAmt=mysql_fetch_array($res_Amt);
                                $total_amt =$rowAmt['totalAMt'];
		      
				$contents['amount'] = $total_amt-$value501;
				$msg['message']='Log-In success';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
			}
	die();	
}


//sign in
function SignIn_check()
	{
 		$i=0;
		$pic="image";
		$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
		//$data = json_decode(file_get_contents("php://input"),TRUE);
		$email=$data[0]['data'];
		
				$contents['data'] = $email;
				
				
				
				$msg['message']='Log-In success';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
}
//	die();	


//sign in
function SignIn_new()
	{
 		$i=0;
		$pic="image";
		$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
		$email=$data[0]['email'];
		$password= md5($data[0]['password']);
		$latitude=$data[0]['latitude'];
		$longitude=$data[0]['longitude'];
		$device_id=$data[0]['device_id'];
		$device_type = $data[0]["device_type"];
		$dateTime=$data[0]['dateTime'];
		
		$getCurrentIp = '192.168.1.103';

	    $json = file_get_contents('http://getcitydetails.geobytes.com/GetCityDetails?fqcn='.$getCurrentIp); 
	    $data = json_decode($json);



	    $offset = $data->geobytestimezone;
	    list($hours, $minutes) = explode(':', $offset);
	    $seconds = $hours * 60 * 60 + $minutes * 60;
	    $tz = timezone_name_from_abbr('', $seconds, 1);
	    if($tz === false) $tz = timezone_name_from_abbr('', $seconds, 0);
	    date_default_timezone_set($tz);
	    echo $tz . ': ' . date('Y-m-d H:i:s');
	    date_default_timezone_set($tz);
	    echo date('Y-m-d H:i:s');
	    die;
		$q = "SELECT id,corporate_id,name,email_id,contact_no,city,zip_code,credit_limit,username,account_type,credit_limit FROM `users` WHERE `email_id` = '$email' and password = '$password'";
		$res=mysql_query($q) or die();  
		$contents = array();     
		if(mysql_num_rows($res) <= 0)
			{	
				$thmsg = array("msg"=>'Id Password not matched');
				$msg['message']='Error';
				$msg['result'][]=$thmsg;
				$msg['status']='400';
				echo json_encode($msg);
			}
			else
			{
				//
				$row=mysql_fetch_assoc($res);
				//echo $row["id"];
				if($row['corporate_id'] != '' || $row['corporate_id'] != null)
				{
					$query = mysql_fetch_assoc(mysql_query("select name from `corporate` where 1 and web_user_id = '".$row['corporate_id']."'"));
				}
				else
				{
					$query['name'] = '';
				}
				$update_status = mysql_query("UPDATE `users` set `login_status` = '1'  where `email_id` ='$email'");	
			    $updateUserr = "update `users` set `latitude`='$latitude',last_login_time='".$dateTime."',`longitude`='$longitude',`device_id`='$device_id',`device_type`='$device_type' where id='".$row["id"]."'";
			    $qry = mysql_query($updateUserr);

				$contents['companyName'] = $query['name'];
				$contents['id'] = $row["id"];
				$contents['name'] = $row["name"];			
				$contents['email'] = $row['email_id']; 
				$contents['contact_no'] = $row['contact_no']; 	
				$contents['city'] = $row["city"];
				$contents['zip_code'] = $row["zip_code"];
				$contents['credit_limit'] = $row["credit_limit"];
				$contents['username'] = $row["username"];
				$contents['account_type'] = $row["account_type"];
				$str500="select trip_ammount from trip where customer_id='".$row['id']."'";
				$res500=mysql_query($str500);
				while($row501=mysql_fetch_assoc($res500))
		        {
		        	$value501 +=$row501['trip_ammount'];
		            //$value502 =$row['credit_limit'];
		        }
				$contents['amount'] = $row['credit_limit']-$value501;
				$msg['message']='Log-In success';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
			}
	die();	
}
?>

