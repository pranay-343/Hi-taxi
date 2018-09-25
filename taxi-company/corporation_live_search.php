<?php

include '../include/define.php';
$mode = $_POST['mode'];
$q = $_GET["term"];

if ($q == '' || $q == null) {
    
} else {
    $mode = 'corporation';
}


switch ($mode) {
    case "corporation":
        $query = "SELECT name, id FROM corporate WHERE added_by = '" . $_SESSION['uid'] . "' AND (name like '%$q%' or id like '%$q%')";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
//print_r($num_rows);
        if ($num_rows == "0") {
            $json[] = array('id' => 'NOTFOUND', 'value' => 'not found');
        } else {
            while ($row = mysql_fetch_array($result)) {
                $json[] = array(
                    'id' => $row['id'],
                    'value' => $row['name']
                );
            }
        }
        echo json_encode($json);
        break;
}
?>