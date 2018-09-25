
<?php
/*

$vertices_x = array(22.684873419893734, 22.719079583864392, 22.767249083176246, 22.86944272079068); 
$value= count($vertices_x);
$vertices_y = array(75.84284667935776, 75.94546432528091, 75.92761154207767, 75.88248252868652);

$longitude_x = 22.684873419893734;  // x-coordinate of the point to test
$latitude_y = 75.84284667935776;    // y-coordinate of the point to test

*/
$vertices_x = array(22.684873419893734, 22.719079583864392, 22.767249083176246, 22.86944272079068); // x-coordinates of the vertices of the polygon
$vertices_y = array(75.84284667935776, 75.94546432528091, 75.92761154207767, 75.88248252868652); // y-coordinates of the vertices of the polygon
$points_polygon = count($vertices_x); // number vertices
//$longitude_x = $_GET["longitude"]; // x-coordinate of the point to test
//$latitude_y = $_GET["latitude"]; // y-coordinate of the point to test
//// For testing.  This point lies inside the test polygon.
 $longitude_x = 22.7677003978487; //22.684873419893734; // 37.62850;
 $latitude_y = 75.8815320203064;// 75.84284667935776;//-77.4499;  22.744807,75.877511

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
  }
  return $c;
}
?>