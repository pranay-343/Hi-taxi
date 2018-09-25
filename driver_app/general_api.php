<?php
include '../include/config.php';
define("SUPER_ADMIN_URL","http://www.hvantagetechnologies.com/Hi-taxi/super-admin/");
define("CORPORATE_URL","http://www.hvantagetechnologies.com/Hi-taxi/corp-user/");
//define("ACCOUNT_URL","http://www.hvantagetechnologies.com/central-taxi/account/");
define("TAXI_URL","http://www.hvantagetechnologies.com/Hi-taxi/taxi-company/");
define("ZONE_URL","http://www.hvantagetechnologies.com/Hi-taxi/zone-admin/");
define("MAIN_URL","http://www.hvantagetechnologies.com/Hi-taxi/");
define("image_PATH","http://www.hvantagetechnologies.com/Hi-taxi/images/");
define("MAIN_URL_WWW","http://www.hvantagetechnologies.com/Hi-taxi/");
//include '../include/define.php';
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
    // elseif($method == 'locationUpdate')
    // {
    //     locationUpdate();
    // }
    elseif($method == 'changePassword')
    {
        changePassword();
	}
    elseif($method == 'logout')
    {
        logout();
    }
    elseif($method == 'statusMaintain')
    {
        statusMaintain();
    }
}

//logout
function logout()
{		
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
	    $driverId=$data[0]['driverId'];
	    $dateTime=$data[0]['dateTime'];
	    $status="0";
		
		$q = "SELECT * FROM `driver` WHERE id ='".$driverId."' ";
		$res=mysql_query($q) or die(mysql_error());

		$q1="UPDATE `driver` SET login_status='".$status."',last_logout_time='".$dateTime."' where id ='".$driverId."'";
		$res1=mysql_query($q1);
		$contents = array();      
		if(mysql_num_rows($res) > 0)
		{	
			$row=mysql_fetch_assoc($res);
			//$contents['id'] = $row["id"];
			$contents['id'] = $row['id'];
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

// change password
function changePassword()
{
	//$dba="mmfinfo_texiDriverApp";
	//$obj=new funcs_code();
	//$obj->connection();			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$driverId=$data[0]['driverId'];
		$oldPassword=$data[0]['oldPassword'];
		$newPassword=$data[0]['newPassword'];	
		//$userName=$data[0]['userName'];
		$output = '';
		$q1 = "SELECT * FROM driver WHERE password =md5('".$oldPassword."') and id = '".$driverId."'";
		$res1=mysql_query($q1) or die(mysql_error());
		if(mysql_num_rows($res1) > 0)
		{	
			$q2="UPDATE driver SET password=md5('".$newPassword."') where id='".$driverId."'";
			mysql_query($q2) or die(mysql_error());
			$contents = array();      
			$q3= "SELECT * FROM driver WHERE id ='".$driverId."'";
			$res3=mysql_query($q3) or die(mysql_error());
			$row1=mysql_fetch_assoc($res3);				
			$contents['password'] = $row1['password']; 
			$msg['message']='Password Change';
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

// location updation
function locationUpdate()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))		
	{
		$longitude=$data[0]['longitude'];		
		$latitude=$data[0]['latitude'];	
		$driver_id=$data[0]['driverId'];
		$date=$data[0]['date'];			
       // $output = '';  
    $q="INSERT INTO `trip_log`(`longitude`, `latitude`, `driver_id`,`date`) VALUES ('$longitude','$latitude','$driver_id','$date')";
    $res=mysql_query($q) or die(mysql_error());
    $id=mysql_insert_id();

    // $checkData="select * from `trip_log` where id='".$id."'";
    // $resData=mysql_query($checkData);
    // $rowData=mysql_fetch_assoc($resData);
    // $rowData['date'];
    // $rowData['driver_id'];



    $q2="select * from trip where driver_id='".$driver_id."' ORDER BY id desc";
	$res1=mysql_query($q2) or die(mysql_error());
	$row1=mysql_fetch_array($res1);
	$row1['status'];

    $q1="UPDATE `trip_log` SET longitude='".$longitude."',latitude='".$latitude."',driver_id='".$driver_id."',date='".$date."',status='".$row1['status']."' where id='".$id."' ";
        $res2=mysql_query($q1) or die(mysql_error());  

    $contents=array();
    if(mysql_affected_rows() > 0)
    { 
    	$q4="select * from trip_log where driver_id='".$driver_id."' and  status ='500'";
	    $res4=mysql_query($q4) or die(mysql_error());
	    $row4=mysql_fetch_assoc($res4);
	    //print_r($row4);
	    $row4['status'];
	    if($row4['status']=='500')
	    {
	    	$q5="DELETE FROM `trip_log` WHERE `driver_id` = '".$driver_id."' AND `status` IN ( 200, 500, 202, 209 )";
	    	$res5=mysql_query($q5) or die(mysql_error());
	    }
    	$contents['longitude']=$longitude;
    	$contents['latitude']=$latitude;
    	$contents['driver_id']=$driver_id;
    	$contents['date']=$date;
    	 // $q1="UPDATE `trip_log` SET longitude='".$longitude."',latitude='".$latitude."',driver_id='".$driver_id."',date='".$date."',status='".$row1['status']."' ";
      //   $res2=mysql_query($q1) or die(mysql_error());
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

//sign in
function SignIn()
	{
 		$i=0;
		$pic="image";
		$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
		$username=$data[0]['username'];
		$password= md5($data[0]['password']);
		$device_id=$data[0]['regId'];
		$dateTime=$data[0]['dateTime'];
		$anroid_id=$data[0]['android_id'];
		$status= '1';
                
                // For current GMT Start
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
                // For current GMT End
                //print_r($data);
	     $q = "SELECT tc.name as companyName,d.name as driverName,d.image as driverImage,d.email as emailId,d.username as username,d.password as password,d.id,d.contact_number,d.image,d.login_status,d.device_id FROM `driver` d Left join `taxicompany` tc ON d.company_id=tc.web_user_id WHERE `username` = '".$username."' and password = '".$password."'";
		$res900=mysql_query($q) or die(mysql_error()); 
        $row900=mysql_fetch_assoc($res900);
        $contents = array();
		 $msg ='';
        if($row900['login_status'] == '1' && $row900['device_id'] != $device_id)
        {
        	    $contents['id'] = $row900["id"];			
				$contents['username'] = $row900["username"];
				$contents['email'] = $row900['emailId']; 
				//$contents['password'] = $row['password']; 	
				$contents['mobile'] = $row900["contact_number"];
				$contents['driverImage'] = TAXI_URL.$row900["driverImage"];
				//$contents['address'] = $row["driveraddress"];
				if($row['image'] == '' || $row900['image'] == null)
					{
						$contents['userImage'] = TAXI_URL.'driver/profile-default-user.png';
					}
				else
					{
						$contents['userImage'] = TAXI_URL.'driver/'.$row900['image'];
					}
        	    $msg['message']='You are already login with other device';
				$msg['result'][]=$contents;
				//$msg['result']=$contents;
				$msg['status']='600';
				echo json_encode($msg);
				//die();
        }
        elseif($row900['login_status'] == '1' && $row900['device_id'] == $device_id)
        {
         $q1 = "SELECT tc.name as companyName,d.name as driverName,d.image as driverImage,d.email as emailId,d.username as username,d.password as password,d.id,d.contact_number,d.image,d.login_status,d.device_id FROM `driver` d Left join `taxicompany` tc ON d.company_id=tc.web_user_id WHERE `username` = '".$username."' and password = '".$password."'";
		$res1=mysql_query($q1) or die(mysql_error());


		// $q1="UPDATE `driver` SET login_status = '".$status."',device_id = '".$device_id."' where username ='".$username."'";
		// $res1=mysql_query($q1) or die(mysql_error());
		    
		// if(mysql_num_rows($res1) <= 0)
		// 	{	
		// 		$thmsg = array("msg"=>'Id Password not matched');
		// 		$msg['message']='Error';
		// 		$msg['result'][]=$thmsg;
		// 		$msg['status']='400';
		// 		echo json_encode($msg);
		// 	}
		// 	else
		// 	{
				$row1=mysql_fetch_assoc($res1);
				$contents['id'] = $row1["id"];			
				$contents['username'] = $row1["username"];
				$contents['email'] = $row1['emailId']; 
				//$contents['password'] = $row['password']; 	
				$contents['mobile'] = $row1["contact_number"];
				$contents['driverImage'] = TAXI_URL.$row1["driverImage"];
				//$contents['address'] = $row["driveraddress"];
				if($row1['image'] == '' || $row1['image'] == null)
					{
						$contents['userImage'] = TAXI_URL.'driver/profile-default-user.png';
					}
				else
					{
						$contents['userImage'] = TAXI_URL.'driver/'.$row1['image'];
					}
				$msg['message']='You are already login';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
			//}
	//die();	
        }
		elseif($row900['login_status'] == '0')
        {
			
		    $q = "SELECT tc.name as companyName,d.name as driverName,d.image as driverImage,d.email as emailId,d.username as username,d.password as password,d.id,d.contact_number,d.image,d.login_status,d.device_id FROM `driver` d Left join `taxicompany` tc ON d.company_id=tc.web_user_id WHERE `username` = '".$username."' and password = '".$password."'";
		$res=mysql_query($q) or die(mysql_error());
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
				$q1="UPDATE `driver` SET login_status = '".$status."',device_id = '".$device_id."',last_login_time='".$dateTime."',`android_id`='".$anroid_id."',`date_server_login`='$date_server_login',`time_server_login`='$time_server_login',`time_zone_server`='$time_zone_server',`utc_server`= '$server_gmt_ori' where username ='".$username."'";
		        $res1=mysql_query($q1) or die(mysql_error());
				$row=mysql_fetch_assoc($res);
				 
				$contents['id'] = $row["id"];			
				$contents['username'] = $row["username"];
				$contents['email'] = $row['emailId']; 
				//$contents['password'] = $row['password']; 	
				$contents['mobile'] = $row["contact_number"];
				$contents['driverImage'] = TAXI_URL.$row["driverImage"];
				$contents['anroid_id'] = $row["android_id"];
				if($row['image'] == '' || $row['image'] == null)
					{
						$contents['userImage'] = TAXI_URL.'driver/profile-default-user.png';
					}
				else
					{
						$contents['userImage'] = TAXI_URL.'driver/'.$row['image'];
					}
				$msg['message']='LoggedIn';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
			}
			
			
				 


		
		}
      
	die();	
}

function statusMaintain()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$driverId=$data[0]['driverId'];
		$status=$data[0]['status'];
        $str="update driver set login_status='".$status."' where id='".$driverId."'";
        $res=mysql_query($str);
        $msg['message']='Successfully uninstall';
		//$msg['result'][]=$contents;
		$msg['status']='200';
		echo json_encode($msg);
	}
}


?>

