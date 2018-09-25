<?php
include 'include/define.php';
/*
Description: The point-in-polygon algorithm allows you to check if a point is
inside a polygon or outside of it.
Author: Michaël Niessen (2009)
Website: http://AssemblySys.com
 
If you find this script useful, you can show your
appreciation by getting Michaël a cup of coffee ;)
PayPal: michael.niessen@assemblysys.com
 
As long as this notice (including author name and details) is included and
UNALTERED, this code is licensed under the GNU General Public License version 3:
http://www.gnu.org/licenses/gpl.html
*/
 

function send_notification($registatoin_ids, $message)
    { 
		//print_r($message);
         $url = 'https://android.googleapis.com/gcm/send';
		$fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $message,
        );
 
        $headers = array(
            'Authorization: key = AIzaSyAQ5Se4Tu1LmgZDAwQ-mguA73x__s8HsTY',
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
	
	$pointLocation = new pointLocation();
	
	$data11="select * from `trip_log` GROUP by `driver_id` ORDER by id DESC";
	$result11=mysql_query($data11);
	/* $latlng = array();
	$points1 = array(); */
	while($rowData11=mysql_fetch_array($result11))
	{
		$driver_id = $rowData11['driver_id']."<br>";
		$ids[] = $driver_id;
		//echo '&&&'; print_r($driver_id);
		$data21="select * from `trip_log` where `driver_id`= '$driver_id' ORDER by id DESC limit 1";
		$result=mysql_query($data21);
		$rowData=mysql_fetch_array($result);

		 //$driver_id; // x-coordinate of the point to test
		 $longitude = trim($rowData['longitude']); // x-coordinate of the point to test "23.0329783";// 
		 $latitude = trim($rowData['latitude']);//"-102.6782216";//"
		//echo $id= 'tripid'.$rowData['id'];
		

		//echo "manish>".$driver_id."=".$longitude;
		$string = $latitude." ".$longitude;
		//echo $string;
		$latlng[] = $string;
		$points1 = $latlng;
		//echo'Point1 : @@@@@@@';print_r($points1); 
		$query_taxi_com = "SELECT driver.company_id, taxicompany.zone_area_id_sess FROM driver LEFT JOIN taxicompany ON driver.id = taxicompany.web_user_id WHERE driver.id ='$driver_id'";
		$result_taxi_com = mysql_query($query_taxi_com);
		while($data_taxi_com = mysql_fetch_array($result_taxi_com)){
			$taxi_zone_id = $data_taxi_com['zone_area_id_sess'];
			//echo'@@@';print_r($taxi_zone_id);
			//$points = $latlng; 22.7195683 75.857725
			//$points = array("23.0329783 -102.6782216","23.032979 -102.678223", "20.926701958681683 -106.05400390624999","21.990060638636972 -105.26298828125005");
			//$points = array("22.7195683 75.857725","23.0329783 -102.6782216","22.7267569 75.8796892");
			$points = array("23.08108663385891 -104.1345189726402","23.08108663385891 -101.56250251173401","25.653103094764262 -101.5625025117348");
			
			echo'Point : ##########';print_r($points);
			$str="select * from zone_cordinater WHERE zone_area_id ='24' ";echo'<br/>';
			$res=mysql_query($str) or die(mysql_error());
			$row=mysql_fetch_array($res);

			 $data1= $row['cordinated']; 
			 echo 'Poly~~~~'.$data1;
			 //echo'codi..'; print_r($data1);
			 $data=str_replace("),(","/",$data1);
			 $data2 = str_replace(",","",$data);
			 $data5 = str_replace("(","",$data2);
			 $data6 = str_replace(")","",$data5);

			 $data3 = explode("/",$data6);
			//echo'<pre>';print_r($data3);
			$polygon = $data3;
			//echo '~~~~~';print_r($polygon);
			// The last point's coordinates must be the same as the first one's, to "close the loop"
			foreach($points as $key => $point) {
				//echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
			   $string =  $pointLocation->pointInPolygon($point, $polygon,$driver_id);
			   echo $string.'>>>>>';
			   if($string == "inside"){
				echo $string . "<br>";
			   //break 2;
			   }else{
				echo $string . "<br>";
			   }
			}
			
			foreach($points1 as $key => $point1) {
				//echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
			   $string =  $pointLocation->pointInPolygon($point1, $polygon,$driver_id);
			   echo $string.'-------';
			   if($string == "inside"){
				echo $string . "<br>";
			   //break 2;
			   }else{
				echo $string . "<br>";
			   }
			}
		}
	}
	
	
	
class pointLocation {
		var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
	 
		function pointLocation() {
		}
 
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
 
}
?>

<?php
/*
$pointLocation = new pointLocation();
$points = array("23.6345 -102.5527833","22.7195683 75.857725","22.638189995168243 75.72798004150388", "22.663245 75.766525", "22.692388 75.844803", "22.703138 75.816783","22.718191 75.859359", "21.919478 -102.733154", "22.407855 -105.413818", "28.375694 -105.754395", "28.838659 -98.063965","28.954081 -97.185059","27.638524 -101.843262","25.238485 -103.952637","27.638524 -101.843262","24.287027 -100.964355");
//$points = array("22.638189995168243 75.72798004150388");
$str="select * from zone_cordinater where zone_area_id='21'";
$res=mysql_query($str);
$text1=array();
while($row=mysql_fetch_array($res))
{  
$data1=$row['cordinated'];

$data=str_replace("),(","/",$data1);
$data2 = str_replace(",","",$data);
$data5 = str_replace("(","",$data2);
$data6 = str_replace(")","",$data5);
$data3 = explode("/",$data6);
$polygon = $data3;
$polygon = array("20.926701958681683 -106.05400390624999","20.926701958681683 -99.65400390625001","28.992591824712022 -96.53388671875007","29.075357239469596 -106.14990234375");
// The last point's coordinates must be the same as the first one's, to "close the loop"

}
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}
*/
?>