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
$pointLocation = new pointLocation();
$points = array("23.6345 -102.5527833","22.7195683 75.857725","22.638189995168243 75.72798004150388", "22.663245 75.766525", "22.692388 75.844803", "22.703138 75.816783","22.718191 75.859359", "21.919478 -102.733154", "22.407855 -105.413818", "28.375694 -105.754395", "28.838659 -98.063965","28.954081 -97.185059","27.638524 -101.843262","25.238485 -103.952637","27.638524 -101.843262","24.287027 -100.964355");
//$points = array("22.638189995168243 75.72798004150388");
$str="select * from zone_cordinater where zone_area_id='21'";
$res=mysql_query($str);
$text1=array();
while($row=mysql_fetch_array($res))
{  
$data1=$row['cordinated'];
/*
$text = str_replace('),(','","',$text);
$text = str_replace(', ',' ',$text);
$text = str_replace('(','("',$text);
$text = str_replace(')','")',$text);

$text1[]=$text;
}
$array=implode(" ",$text1);
$array=str_replace("("," ", $array);
$array=str_replace(")"," ", $array);*/

$data=str_replace("),(","/",$data1);
$data2 = str_replace(",","",$data);
$data5 = str_replace("(","",$data2);
$data6 = str_replace(")","",$data5);

$data3 = explode("/",$data6);
//echo'<pre>';print_r($data3);
//$polygon = $data3;
//print_r($polygon);
//echo '<<<<<<<<';
//$polygon = array($array);
//print_r($polygon1);echo'!!!!!!!!!';
// "25.774 -80.190","18.466 -66.118","32.321 -64.757","25.774 -80.190"
//(20.926701958681683, -106.05400390624999),(20.926701958681683, -99.65400390625001),(28.992591824712022, -96.53388671875007),(29.075357239469596, -106.14990234375)
$polygon = array("20.926701958681683 -106.05400390624999","20.926701958681683 -99.65400390625001","28.992591824712022 -96.53388671875007","29.075357239469596 -106.14990234375");
// The last point's coordinates must be the same as the first one's, to "close the loop"

}
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}
?>