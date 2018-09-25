<?php

include("../include/define.php");
$mode = base64_decode($_REQUEST['mode']);


if($mode == 'getAllTripsDataBy_Nj')
{
    $query = mysql_query("SELECT latitude,longitude FROM trip_log WHERE trip_id =  '4360' ");
    while($tripData = mysql_fetch_object($query))
    {
        $dta[] = "new google.maps.LatLng(".$tripData['latitude'].",".$tripData['longitude']."),";
    }
    $nj['result'] = rtrim($dta,',');
    echo json_encode($nj);
}




if ($mode == 'getallDriversDetails') {
    $centralId = $_POST['a'];
    $queryy = "SELECT `login`.id,`login`.name,`login`.contact_number From `login` LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by ='" . $_SESSION['uid'] . "' and account_type='4' AND zone_area_id_sess = '" . $_SESSION['zoneArea'] . "'";
    if ($centralId != '') {
        $queryy .= ' and `login`.id = "' . $centralId . '"';
    }
    $qruy = mysql_query($queryy);
    if (mysql_num_rows($qruy) > 0) {
        while ($dat = mysql_fetch_assoc($qruy)) {   
            $query1 = "SELECT * From `driver`  where login_status='1' and company_id = '".$dat['id']."'";
            $result1 = mysql_query($query1);
            $neer2 = array();
            while ($row1 = mysql_fetch_assoc($result1)) {
                $query2 = "SELECT * From `trip_log`  where driver_id='" . $row1['id'] . "'  ORDER BY id desc LIMIT 1";
                $result2 = mysql_query($query2);
                if (mysql_num_rows($result2) > 0) {
                    while ($row2 = mysql_fetch_assoc($result2)) {
                        $data['id'] = $row2['id'];
                        $data['latitude'] = $row2['latitude'];
                        $data['longitude'] = $row2['longitude'];
                        $data['driver_id'] = $row1['id'];
                        $data['username'] = $row1['username'];
                        $data['mobile'] = $row1['contact_number'];
                        $data['central'] = $dat['name'];
                    }
                } else {
                    $data['id'] = '0';
                    $data['latitude'] = '0';
                    $data['longitude'] = '0';
                    $data['driver_id'] = '0';
                    $data['username'] = '0';
                    $data['mobile'] = '0';
                    $data['central'] = '0';
                }
                $nj['getallDriversDetails'][] = $data;
            }
        }
        echo json_encode($nj);
    }
}

if($mode == 'getAllTripsDataBy_Nj')
{
    $query = mysql_query("SELECT latitude,longitude FROM trip_log WHERE trip_id =  '3' ");
    $i = 0;
    $count = mysql_num_rows($query);
    while($tripData = mysql_fetch_assoc($query))
    {
        $i++;
       // echo $i.' == '.$count.'---<br/>';
        if($i == $count)
        {
            $dta[] = "new google.maps.LatLng(".$tripData['latitude'].",".$tripData['longitude'].")";
        }
        else
        {
            $dta[] = "new google.maps.LatLng(".$tripData['latitude'].",".$tripData['longitude']."),";
        }
        
        // new google.maps.LatLng(123,123)
        
    }
    $nj['result'] = $dta;
   echo json_encode($nj,true);
}
if ($mode == 'getallDriversDetails_zone') {
    $companyIdd = '';
    $centralId = $_POST['a'];
    $queryy = "SELECT `login`.id,`login`.name,`login`.contact_number From `login` LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by ='" . $_SESSION['uid'] . "' and account_type='4' AND zone_area_id_sess = '" . $_SESSION['zoneArea'] . "'";
    if ($centralId != '') {
        $queryy .= ' and `login`.id = "' . $centralId . '"';
    }
    $qruy = mysql_query($queryy);
    if (mysql_num_rows($qruy) > 0) 
    {
        while ($dat = mysql_fetch_assoc($qruy)) {
         $companyIdd .= $dat['id'].',';   
        }
        $companyIdd = rtrim($companyIdd,',');
        $getDriver = mysql_query("SELECT * From `driver`  where login_status='1' and company_id in ($companyIdd)");
        while ($row1 = mysql_fetch_assoc($getDriver)) {
                $query2 = "SELECT * From `trip`  where driver_id='" . $row1['id'] . "'  AND trip.status = '500'  ORDER BY id desc LIMIT 1";
                $result2 = mysql_query($query2);
                if (mysql_num_rows($result2) > 0) {
                    while ($row2 = mysql_fetch_assoc($result2)) {
                        $data['id'] = $row2['id'];
                        $data['latitude'] = $row2['source_latitude'];
                        $data['longitude'] = $row2['source_longitude'];
                        $data['driver_id'] = $row1['id'];
                        $data['username'] = $row1['username'];
                        $data['mobile'] = $row1['contact_number'];
                       // $data['central'] = $dat['name'];
                    }
                } else {
                    $data['id'] = '0';
                    $data['latitude'] = '0';
                    $data['longitude'] = '0';
                    $data['driver_id'] = '0';
                    $data['username'] = '0';
                    $data['mobile'] = '0';
                    //$data['central'] = '0';
                }
                $nj['getallDriversDetails_zone'][] = $data;
            }
            echo json_encode($nj);
    }       
}

if ($mode == 'getallDriversDetails_endPont') {
    $centralId = $_POST['a'];
    $queryy = "SELECT `login`.id,`login`.name,`login`.contact_number From `login` LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by ='" . $_SESSION['uid'] . "' and account_type='4' AND zone_area_id_sess = '" . $_SESSION['zoneArea'] . "'";
    if ($centralId != '') {
        $queryy .= ' and `login`.id = "' . $centralId . '"';
    }
    $qruy = mysql_query($queryy);
    if (mysql_num_rows($qruy) > 0) {
        while ($dat = mysql_fetch_assoc($qruy)) {
            $query1 = "SELECT * From `driver`  where login_status='1' and company_id = '" . $dat['id'] . "'";
            $result1 = mysql_query($query1);
            $neer2 = array();
            while ($row1 = mysql_fetch_assoc($result1)) {
                $query2 = "SELECT * From `trip`  where driver_id='" . $row1['id'] . "'  AND trip.status = '500'  ORDER BY id desc LIMIT 1";
                $result2 = mysql_query($query2);
                if (mysql_num_rows($result2) > 0) {
                    while ($row2 = mysql_fetch_assoc($result2)) {
                        $data['id'] = $row2['id'];
                        $data['latitude'] = $row2['endTrip_sourcelatitude'];
                        $data['longitude'] = $row2['endTrip_sourcelongitude'];
                        $data['driver_id'] = $row1['id'];
                        $data['username'] = $row1['username'];
                        $data['mobile'] = $row1['contact_number'];
                        $data['central'] = $dat['name'];
                    }
                } else {
                    $data['id'] = '0';
                    $data['latitude'] = '0';
                    $data['longitude'] = '0';
                    $data['driver_id'] = '0';
                    $data['username'] = '0';
                    $data['mobile'] = '0';
                    $data['central'] = '0';
                }
                $nj['getallDriversDetails_endPont'][] = $data;
            }
        }
        echo json_encode($nj);
    }
}
if ($mode == 'getallDriversDetails_zone11') {
    //$query1 = "SELECT * From `driver` where login_status='1'";
    $query1 = "SELECT * From `driver` LEFT JOIN taxicompany ON driver.company_id = taxicompany.web_user_id `driver` where login_status='1' AND taxicompany.zone_area_id_sess = '" . $_SESSION['zoneArea'] . "'";
    $result1 = mysql_query($query1);
    $nj = array();
    $i = '0';
    while ($row1 = mysql_fetch_assoc($result1)) {
        $i++;
        $query2 = "SELECT * From `trip` where trip.driver_id='" . $row1['id'] . "' AND trip.status = '500' ORDER BY id desc LIMIT 0,1";
        $result2 = mysql_query($query2);
        if (mysql_num_rows($result2) > 0) {
            //$row2 = mysql_fetch_assoc($result2);
            while ($row2 = mysql_fetch_array($result2)) {
                $data['latitude'] = $row2['source_latitude'];
                $data['longitude'] = $row2['source_longitude'];
                $data['driver_id'] = $row2['driver_id'];
                $data['username'] = $row1['username'];
                $data['mobile'] = $row1['contact_number'];
            }
        } else {
            
        }
        $nj[] = $data;
        unset($row2['latitude'], $row2['longitude'], $row2['id'], $row2['username'], $row2['contact_number']);
    }
    echo json_encode($nj);
}
?>
