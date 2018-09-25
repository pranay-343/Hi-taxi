<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#load_tweets').load('new_polygon11.php').fadeIn("slow");console.log('nj');
}, 30000); // refresh every 10000 milliseconds
</script>
<?php

// delete old data of trip log
//$qry = mysql_query("delete from `trip_log` where 1 and status = 0 and date < NOW() - INTERVAL 2 DAY order by id desc");

// delete old data of trip log

//$pointLocation = new pointLocation();
$data11="select * from `trip_log` GROUP by `driver_id` ORDER by driver_id DESC";
$result11=mysql_query($data11);
while($rowData11=mysql_fetch_array($result11))
{
 $driver_id = $rowData11['driver_id'];
// $driver_id = '28';
 $str900="select id, company_id, name, device_id, zone_id from driver where id='".$driver_id."'";
 $res900=mysql_query($str900);
 $row900=mysql_fetch_assoc($res900);
	if($row900['zone_id'] == '0')
	{
		$data21="select * from `trip_log` where `driver_id`= '$driver_id' ORDER by id DESC limit 0,1";
		//echo $data21.'------get trip log data--<br/>';
		$result=mysql_query($data21);
		$rowData=mysql_fetch_array($result);
		$longitude = trim($rowData['longitude']); // x-coordinate of the point to test "23.0329783";// 
		$latitude = trim($rowData['latitude']);//"-102.6782216";//"
		$query_taxi_com = "SELECT driver.company_id,driver.zone_id,taxicompany.zone_area_id_sess FROM driver LEFT JOIN taxicompany ON driver.id = taxicompany.web_user_id WHERE driver.id ='$driver_id'";
		//echo $query_taxi_com.'------get zone area details--<br/>';
		$result_taxi_com = mysql_query($query_taxi_com);
		$data_taxi_com=mysql_fetch_array($result_taxi_com);
		$zone_id = $data_taxi_com['zone_id'];
		$str="select cordinated from zone_cordinater WHERE zone_area_id ='$zone_id' ";
		//echo $str.'------get zone area cordinates--<br/>';
		$res=mysql_query($str) or die(mysql_error());
		$row=mysql_fetch_array($res);
		$data1= $row['cordinated']; 
		$arr=explode(",", $data1);
		$arr= str_replace("(", "", $arr);
		$arr= str_replace(")", "", $arr);
		// print_r($arr);
		//echo count($arr);
		for ($b=0; $b < count($arr); $b++) 
		   { 
			if($b == '0' || $b%2 == '0')
				{
					$axis_x[] = $arr[$b];
				}
			else
			   {
					$axis_y[] = $arr[$b];
				}
			}
		$vertices_x = $axis_x;
		$vertices_y = $axis_y; // y-coordinates of the vertices of the polygon
		$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
		$longitude_x = $rowData['latitude'];  // x-coordinate of the point to test
		$latitude_y = $rowData['longitude'];    // y-coordinate of the point to test
		if (is_in_polygonnjj($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
		{
			$nj = "Is in polygon!";$nj_message = "400";
			$message1['messsage']="Driver In zone";
			$message1['status']="400";
		}
		else
		{ 
			$nj = "Is not in polygon";$nj_message = "200";
			$message1['messsage']="Driver out of zone";
			$message1['status']="200";
		}
		
	}
	else
	{
	  $data21="select * from `trip_log` where `driver_id`= '$driver_id' ORDER by id DESC limit 1";
	 // echo $data21.'------get trip log data--<br/>';
	  $result=mysql_query($data21);
	  $rowData=mysql_fetch_array($result);
	  $longitude = trim($rowData['longitude']); // x-coordinate of the point to test "23.0329783";// 
	  $latitude = trim($rowData['latitude']);//"-102.6782216";//"
	  $query_taxi_com = "SELECT driver.company_id,driver.zone_id,taxicompany.zone_area_id_sess FROM driver LEFT JOIN taxicompany ON driver.id = taxicompany.web_user_id WHERE driver.id ='$driver_id'";
	  //echo $query_taxi_com.'------get zone area details--<br/>';
	  $result_taxi_com = mysql_query($query_taxi_com);
	  $data_taxi_com=mysql_fetch_array($result_taxi_com);
	  $zone_id = $data_taxi_com['zone_id'];
	  $str="select * from zone_cordinater_driver WHERE id ='$zone_id' ";
	  //echo $str.'------get zone area cordinates--<br/>';
	  $res=mysql_query($str) or die(mysql_error());
	  $row=mysql_fetch_array($res);
	  $data1= $row['cordinated']; 
	  $dinesh=explode(",", $data1);
	  $dinesh= str_replace("(", "", $dinesh);
	  $dinesh= str_replace(")", "", $dinesh);
	   // print_r($dinesh);
	  //echo count($dinesh);
		for ($b=0; $b < count($dinesh); $b++) 
		{ 
		  if($b == '0' || $b%2 == '0')
			{
				$axis_x[] = $dinesh[$b];
			}
		 else
			{
				$axis_y[] = $dinesh[$b];
			}
		}
		$vertices_x = $axis_x;
		$vertices_y = $axis_y; // y-coordinates of the vertices of the polygon
		$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
		$longitude_x = $rowData['latitude'];  // x-coordinate of the point to test
		$latitude_y = $rowData['longitude'];    // y-coordinate of the point to test
		if (is_in_polygonnjj($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
		{
			$nj = "Is in polygon!";
			$nj_message = "Driver In zone";
			$message1['messsage']="Driver In Zone";
			$message1['status']="400";
		}
		else
		{ 
			$nj = "Is not in polygon";$nj_message = "200";
			$message1['messsage']="Driver out of zone";
			$message1['status']="200";
		}
	}
	$str6 = "select * from driver where id = '$driver_id'";
	$res6=mysql_query($str6) or die(mysql_error());
	$row5=mysql_fetch_array($res6);
	$gcm_regid = $row5["device_id"];
	$registatoin_ids = array($gcm_regid);
	$message = array("adminNotification" => $message1);
	send_notification($registatoin_ids, $message);
	//echo $driver_id.'-- driver_id ---> <em>'.$nj.'--'.$nj_message.'</em><br/>';
}
?>
