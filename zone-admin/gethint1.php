<?php
include '../include/define.php';
// echo "<script>alert('hello');</script>";
$mode = $_POST['mode'];
$q = $_GET["term"];

if ($q == '' || $q == null) {
    
} else {
    $mode = 'corporation';
}


switch ($mode) {
    case "corporation":
       // $query = "SELECT name, id FROM driver WHERE name like '%$q%' ";
        $query="SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name,`driver`.id,`driver`.email FROM `driver`
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
        where `driver`.name like '%$q%' and `login`.id='".$_SESSION['uid']."'";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == "0") {
            $json[] = array( 'value' => 'not found');
        } else
         {
            while ($row = mysql_fetch_array($result))
             {
                $json[] = array(
                    //'id' => $row['id'],
                    'value' => $row["name"]                  
                   // 'email' => $row['email']

                );
            }
        }
        echo json_encode($json);
        break;
}
?>