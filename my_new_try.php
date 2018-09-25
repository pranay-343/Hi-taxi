<?php
session_start();
//$ids = array();
?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#load_tweets').load('new_polygon.php').fadeIn("slow");
}, 11111130000); // refresh every 10000 milliseconds
</script>
<body>
<div id="load_tweets">
<?php

include 'include/define.php';
function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
{
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++)
   {
    if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
       $c = !$c;
  }
  return $c;
}
//$pointLocation = new pointLocation();

$data11="select * from `trip_log` GROUP by `driver_id` ORDER by id DESC";
$result11=mysql_query($data11);
while($rowData11=mysql_fetch_array($result11))
{
 $driver_id = $rowData11['driver_id'];
 $str900="select zone_id from driver where id='".$driver_id."'";
 $res900=mysql_query($str900);
 $row900=mysql_fetch_assoc($res900);
 
  $ids[] = $driver_id;
  
 echo $data21="select * from `trip_log` where `driver_id`= '$driver_id' ORDER by id DESC limit 1";
  $result=mysql_query($data21);
  $rowData=mysql_fetch_array($result);
  $longitude = trim($rowData['longitude']); // x-coordinate of the point to test "23.0329783";// 
  $latitude = trim($rowData['latitude']);//"-102.6782216";//"
  $string = $latitude." ".$longitude;
  $latlng[] = $string;
  $points = $latlng;
//echo $points."dinesh";
//print_r($points);
//$points = array("22.7264807 75.8797648");
//$str="select * from zone_cordinater";
//$res=mysql_query($str) or die(mysql_error());
  $query_taxi_com = "SELECT driver.company_id,driver.zone_id,taxicompany.zone_area_id_sess FROM driver LEFT JOIN taxicompany ON driver.id = taxicompany.web_user_id WHERE driver.id ='$driver_id'";
  $result_taxi_com = mysql_query($query_taxi_com);
  $data_taxi_com=mysql_fetch_array($result_taxi_com);

  $zone_id = $data_taxi_com['zone_id'];
  $str="select * from zone_cordinater_driver WHERE id ='$zone_id' ";
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
            $dhiraj[] = $dinesh[$b];
          }
          else
          {
            $ankur[] = $dinesh[$b];
          }
      }

$vertices_x = $dhiraj;
$vertices_y = $ankur; // y-coordinates of the vertices of the polygon
$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
$longitude_x = $rowData['latitude'];  // x-coordinate of the point to test
$latitude_y = $rowData['longitude'];    // y-coordinate of the point to test

//echo '<br/>'.$rowData["id"].'--id--'.$longitude_x.'--lat--lon-'.$latitude_y.'<br/>';
  if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
    echo "Is in polygon!";
  }
  else
  { 
    echo "Is not in polygon";
  }

}

?>

 </div>
</body>
