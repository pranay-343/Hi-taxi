<?php
session_start();
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#load_tweets').load('new_polygon.php').fadeIn("slow");console.log('nj');
}, 60000); // refresh every 10000 milliseconds

</script>
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




		$axis_x ='';$axis_y='';
//(22.742370622399648, 75.82750175695833),(22.744270390717073, 75.84161597985758),(22.75940486940229, 75.83371955651774)

		$longitude = '22.742370622399648'; // x-coordinate of the point to test "23.0329783";// 
		$latitude = '75.82750175695833';//"-102.6782216";//"

		
		$data1= '(22.740541629490483, 75.76182830836728),(22.693671696844316, 75.81945724487241),(22.634665630821193, 75.83738353722617),(22.67070590912628, 75.89788185106431),(22.710458044513597, 75.9423175046195),(22.796000105622063, 75.95811035129918),(22.807048024779295, 75.84692306518491)'; 
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
		//print_r($vertices_x);
		$vertices_y = $axis_y; // y-coordinates of the vertices of the polygon
		$points_polygon = count($vertices_x) - 2;  // number vertices - zero-based array
		$longitude_x = $rowData['latitude'];  // x-coordinate of the point to test
		$latitude_y = $rowData['longitude'];    // y-coordinate of the point to test
		if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
		{
			$nj = "Is in polygon!";
		
		}
		else
		{ 
			$nj = "Is not in polygon";
			
			
		}
		
	echo $nj.'<br/>';
?>
