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

	 elseif($method == 'companyName')
	{
		companyName();
	} 	
}



function getColonies()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{      
		$uid=$data[0]['uid'];	
		//echo $uid;die;
		$user_login =  "SELECT * FROM users WHERE id = '$uid'";
		$result_login = mysql_query($user_login);
		$user_array = mysql_fetch_array($result_login);
		//$user_login = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE id = '".$user_array['added_by']."'"));	

		$q1 = "SELECT * From corporate_colony where corporate_id='".$user_array['added_by']."'";
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
function companyName()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
		$lat = $data[0]['sourcelatitute'];
		$lng = $data[0]['sourcelongitude'];
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
				//echo strpos($cordinate_title, 'Polygon') !== false; 
				//echo'ashu';	echo strpos($cordinate_title, 'Circle') !== false ;die;
				if(strpos($cordinate_title, 'Polygon') !== false)
					{
						
						//echo 	$cordinated. '<br>';echo 	$cordinate_title;	
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
										$tempd = str_replace(")",",",$pieces[$i]);
										$piecessddd = $piecessddd . $tempd;
								}

								//echo $piecessdd;
							} 
							//$points = array("22.718092 75.857686");
							//$polygon = array("22.718191 75.859359","22.718027 75.856698","22.718077 75.855384","22.718121 75.858281");
									
						$vertices_x = array($piecessdd);// 22.718191, 22.718027, 22.718077, 22.718121
						$vertices_y = array($piecessddd);//75.859359,75.856698,75.855384, 75.858281
						$points_polygon = count($vertices_x) - 1; 
//						print_r($vertices_x); echo 'ak';
//						print_r($vertices_y);
						echo "is in : ".is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y);
						if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
							{
								$zone_area_id[] = $row->zone_area_id;

								//print_r($zone_area_id);
							}
						}

/*						elseif(strpos($cordinate_title, 'Circle') !== false)
						{
							//echo 'dsffsdfds';
								$locationRadiusArray[] = explode('),(', $cordinated); 
								$locationString = str_replace("(","",$locationRadiusArray[0]);
								//print_r($locationString);
								$centerArray[] = explode(', ', $locationString[0]);
								$Cx = $centerArray[0][0];
								$Cy = $centerArray[0][1];
								$Px = $latitude_y;
								$Py = $longitude_x;

								$D = SQRT((($Cx - $Px)*($Cx - $Px)) + (($Cy - $Py)*($Cy - $Py)));
								$R = str_replace(")","",$locationRadiusArray[1]);
								if( $D  <= $R )
								{ 
									$zone_area_id[] = $row->zone_area_id;
								}
						}*/

				}
				//print_r($zone_area_id);
					//die;		
		}

		$queryString = "";
		print_r($zone_area_id);
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
		//print_r($queryString);
		
		$q = "SELECT * FROM taxicompany where zone_area_id_sess in(". $queryString .")";

		$res=mysql_query($q) or die(mysql_error());
		$contents = array();      
		$com = array();   

		if(mysql_num_rows($res) > 0){
			while($row=mysql_fetch_assoc($res)){
				$contents['companyName'] = $row['name'];
				$contents['company_id'] = $row['id'];
				$com[] =$contents;
			}
			$msg['message']='Successfully';
			$msg['result']=$com;
			$msg['status']='200';
			echo json_encode($msg);	
		 
		}
		else{
			$contents['msg'] = 'error';
			$msg['message']='Error';
			$msg['result']=$contents;
			$msg['status']='400';
			echo json_encode($msg);
		}
}


	function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y){
		//echo $latitude_y;
 	 	$i = $j = $c = 0;
 		 for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) 
		 	{
				if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
	 ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + 	$vertices_x[$i]) ) )
	   			$c = !$c;
  			}
  		return $c;
	}
