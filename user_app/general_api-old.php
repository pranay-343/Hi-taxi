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
    elseif($method == 'companyName')
    {
        companyName();
    }
    elseif($method == 'updateProfile')
    {
        updateProfile();
    }
}


// Profile Update for user
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

//Company Name Fetching
function companyName()
{	

	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$lat = $data['sourcelatitute'];
		$lng = $data['sourcelongitude'];
		$sql = mysql_query("select * from `zone_cordinater`");
		$strConcat="";
		$intCount=0;
		$strAddEvenValue="";
		$longitude_x = $data[0]['sourcelongitude']; 
		$latitude_y =  $data[0]['sourcelatitute']; 		
		while($row = mysql_fetch_object($sql))
			{
				
				$cordinated = $row->cordinated;						
				$cordinate_title = $row->cordinate_title;
				if(strpos($cordinate_title, 'Polygon') !== false)//$cordinate_title == 'Polygon #0'
					{
						$pizza  = $cordinated;
						$pieces = explode(",", $pizza);
						$intGetCount=count($pieces);
						$strAddLatitudeValue="";
						for($i=0;$i<$intGetCount;$i++)
							{
								if($i%2==0)
								{
									if($i == 0)
									{
										$temp = str_replace('(','',$pieces[$i]);
										$piecessdd = $piecessdd . $temp;
									}else
									{
										$tempc = str_replace("(",",",$pieces[$i]);
										$piecessdd = $piecessdd . $tempc;
									}
								}
								else
								{
							//			echo $tempd;
										$tempd = str_replace(")",",",$pieces[$i]);
										$piecessddd = $piecessddd . $tempd;
										//echo $piecessddd;			 //"hello".
								}
							} 
									//echo $piecessdd;
									
															$vertices_x = array($piecessdd); 
															$vertices_y = array($piecessddd);
															$points_polygon = count($vertices_x) - 1; 
															
															if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
																{
																	$zone_area_id[] = $row->zone_area_id;
																}
															else{
																	$zone_area_id = "";
																}	
						}
						else if(strpos($cordinate_title, 'Circle') !== false)
						{
//							(22.71768901296803, 75.87830007672119),(478.9892999653565)
								$locationRadiusArray[] = explode('),(', $cordinated); 
								$locationString = str_replace("(","",$locationRadiusArray[0]);
								//print_r($locationString);
								$centerArray[] = explode(', ', $locationString[0]);
	//							print_r($centerArray[0]);
//								echo " center x point : ".$centerArray[0][0]." center y point ".$centerArray[0][1];
								$Cx = $centerArray[0][0];
								$Cy = $centerArray[0][1];
								$Px = $latitude_y;
								$Py = $longitude_x;

								$D = SQRT((($Cx - $Px)*($Cx - $Px)) + (($Cy - $Py)*($Cy - $Py)));
								$R = str_replace(")","",$locationRadiusArray[1]);
//								print_r($R); 
//								die(); 
								
							//	echo " $Cx ".$Cx." $Cy ".$Cy." $Px ".$Px." $Py ".$Py." $D ".$D." $R ".$R;
								if( $D  <= $R )
								{ 
									$zone_area_id[] = $row->zone_area_id;
								}
								else
								{
									$zone_area_id = "";
								}
					}
				
		
	$queryString = "";
	for($j = 0;$j<count($zone_area_id);$j++)
	{
		if($j == 0)
		{
			$queryString = $zone_area_id[$j];
		}else
		{
			$queryString = $queryString . ",". $zone_area_id[$j] ;
		}
	}
		
$q = "SELECT * FROM taxicompany where zone_area_id_sess in(". $queryString .")";

$res=mysql_query($q) or die(mysql_error());
$contents = array();      
$com = array();     

//echo mysql_num_rows($res);
//die(); 

if(mysql_num_rows($res) > 0)
	{
	while($row=mysql_fetch_assoc($res))
	{
		$contents['companyName'] = $row['name'];
		$contents['company_id'] = $row['id'];
		$com[] =$contents;
	}
$msg['message']='Successfully';
$msg['result']=$com;
$msg['status']='200';
echo json_encode($msg);	
 
}
else
{
	$contents['msg'] = 'error';
	$msg['message']='Error';
	$msg['result']=$contents;
	$msg['status']='400';
	echo json_encode($msg);
}
}
}		
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
	$dba="mmfinfo_texiDriverApp";
	$obj=new funcs_code();
	$obj->connection();			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
	$email=$data[0]['email'];
		$output='';
		$q = "SELECT * FROM customer_info WHERE email ='".$email."' ";
		$res=mysql_query($q) or die(mysql_error());
		$contents = array();      
		if(mysql_num_rows($res) > 0)
		{	
			$row=mysql_fetch_assoc($res);
			//$contents['id'] = $row["id"];
			$contents['email'] = $row['email'];
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
		$device_type = $data[0]["device_type"];	
		$account_type=$data[0]["account_type"];
	   	$output = '';
        $q1="select * from users where email_id='".$email."'";
    	$res1=mysql_query($q1);
	   	$row22=mysql_fetch_array($res1);
	    if(mysql_num_rows($res1)>0)
	   	{
	        $number=$row22['device_token']+1;
	        $id22 = $row22['id'];
			$q2="UPDATE users SET name='".$name."',email_id='".$email."',contact_no='".$mobile."',latitude='".$latitude."',longitude='".$longitude."',device_id='".$gcm_regid."',device_token='".$number."',device_type='".$device_type."' where email_id='".$email."'";
			mysql_query($q2) or die(mysql_error());
			$q99="select * from users where email_id='".$email."'";
			$res99=mysql_query($q99);
			$row99=mysql_fetch_array($res99);
			$id=mysql_insert_id();
	    	$contents['id']="$id22";
		   	$contents['name']=$row99['name'];
	    	$contents['email']=$row99['email_id'];
	    	$contents['mobile']=$row99['contact_no'];
	    	$contents['latitute']=$row99['latitude'];
	    	$contents['longitude']=$row99['longitude'];
	    	$contents['account_type']=$row99['account_type'];
	    	$contents['regId']=$row99['device_id'];
		   	$msg['message']='Update Successfully';
		   	$msg['result']=$contents;
		   	$msg['status']='200';  
		   	echo json_encode($msg);
		   	die();
	    }
	    if(mysql_num_rows($res1)==0)
	    {
		   $q="INSERT INTO `users`(`name`, `email_id`, `contact_no`,`device_id`,`longitude`,`latitude`,`account_type`,`device_type`)VALUES ('$name','$email','$mobile','$gcm_regid','$longitude','$latitude','$account_type','$device_type')";
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
	$dba="mmfinfo_texiDriverApp";
	$obj=new funcs_code();
	$obj->connection();			
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$uid=$data[0]['uid'];
		$oldPassword=$data[0]['oldPassword'];
		$newPassword=$data[0]['newPassword'];	
		//$userName=$data[0]['userName'];
		$output = '';
		$q1 = "SELECT * FROM customer_info WHERE password ='".$oldPassword."' and id = '".$uid."'";
		$res1=mysql_query($q1) or die(mysql_error());
		if(mysql_num_rows($res1) > 0)
		{	
			$q2="UPDATE customer_info SET password='".$newPassword."' where id='".$uid."'";
			mysql_query($q2) or die(mysql_error());
			$contents = array();      
			$q3= "SELECT * FROM customer_info WHERE id ='".$uid."'";
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

		$q = "SELECT id,corporate_id,name,email_id,contact_no,city,zip_code,credit_limit,username,account_type FROM `users` WHERE `email_id` = '$email' and password = '$password'";
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
				$row=mysql_fetch_assoc($res);
				if($row['corporate_id'] != '' || $row['corporate_id'] != null)
				{
					$query = mysql_fetch_assoc(mysql_query("select name from `corporate` where 1 and web_user_id = '".$row['corporate_id']."'"));
				}
				else
				{
					$query['name'] = '';
				}

				$qry = mysql_query("update `users` set `latitude`=$latitude,`longitude`=$longitude,`device_id`=$device_id where '".$row["id"]."'");

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
				$msg['message']='Log-In success';
				$msg['result'][]=$contents;
				$msg['status']='200';
				echo json_encode($msg);
			}
	die();	
}

							function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
							{
						 	 	$i = $j = $c = 0;
						 		 for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) 
								 	{
										if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
							 ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + 	$vertices_x[$i]) ) )
							   			$c = !$c;
						  			}
						  		return $c;
							}


?>

