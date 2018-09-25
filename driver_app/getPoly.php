<?php
include '../include/define.php';
$str="select * from zone_cordinater where zone_area_id='16'";
$res=mysql_query($str);
while($row = mysql_fetch_object($res)){
    $cordinated = $row->cordinated;     
    $cordinate_title = $row->zone_type;       
    $cordi  = $cordinated;
    $all_cordinate = explode(",", $cordi);
    //echo '<pre>';print_r($all_cordinate); 
    $intGetCount=count($all_cordinate);
    //print_r($intGetCount);
    $strAddLatitudeValue="";
    for($i=0;$i<$intGetCount;$i++)
    {
      if($i%2==0)
      {
        if($i == 0)
        {
          $temp = str_replace('(','',$all_cordinate[$i]);
          $latitude = $latitude . $temp;
        }else{
          $tempc = str_replace("(",", ",$all_cordinate[$i]);
          $latitude = $latitude . $tempc;
        }
      }
      else{
          $tempd = str_replace(")",", ",$all_cordinate[$i]);
          $longitude = $longitude . $tempd;
      }
    }
   echo '<pre>' .'Lati : '; print_r($latitude);
   echo '<pre>' .'Long : '; print_r($longitude);
   }  
// print_r($latitude) ;

$vertices_x1 = array($latitude); // x-coordinates of the vertices of the polygon
for($i=0; $i<count($vertices_x1); $i++){
$a = explode(',', $vertices_x1[$i]);
}

$vertices_x = $a;
 
print_r($vertices_x);
//$vertices_y = array($longitude); // y-coordinates of the vertices of the polygon

$vertices_y1 = explode(",", $longitude); // y-coordinates of the vertices of the polygon
foreach ($vertices_y1 as  $value_Y)
{
  $vertices_y[] = $value_Y;
}
//print_r($vertices_y);
echo "</br>";
echo $points_polygon = count($vertices_x); // number vertices


$longitude_x = 24.28702686537646; // x-coordinate of the point to test
$latitude_y = -100.96435546875; // y-coordinate of the point to test
 
if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)){
  echo "Is in polygon!";
}
else echo "Is not in polygon";
 
 
function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
{
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
    if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
    ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
        $c = !$c;
   //   print_r($c);
  }
  return $c;
  print_r($c);
}
?>