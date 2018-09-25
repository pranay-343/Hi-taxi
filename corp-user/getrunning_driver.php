<?php
include '../include/define.php';
    $today=date("Y-m-d H:i:s", strtotime("-2 min"));
    //$query = "SELECT * FROM `trip_log` LEFT JOIN driver ON trip_log.driver_id = driver.id WHERE driver.status = 200 GROUP BY `driver_id` DESC";
    $query ="SELECT * FROM `trip_log` LEFT JOIN driver ON trip_log.driver_id = driver.id WHERE 1 AND trip_log.date >= '".$today."' GROUP BY `driver_id` DESC ";
    $result = mysql_query($query);
    $rows = mysql_num_rows($result);
    $driversArray = array();
    while($info = mysql_fetch_assoc($result)){
        $driversArray[] = $info;        
    }
    $data['dataa'] = $driversArray;
    echo json_encode($data);
?>
