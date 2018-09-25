<?php
include("../include/define.php"); 
$mode = base64_decode($_REQUEST['mode']);
if($mode == 'getRealTimeData'){
    if ($_SESSION['uid'] != "") {
        $get_cetral = mysql_query("SELECT * FROM login WHERE added_by = '" . $_SESSION['uid'] . "'");
        while ($get_cetral_array = mysql_fetch_array($get_cetral)) {
            $getCenIds[] = ($get_cetral_array['id']);
        }
        $idss = implode(",", $getCenIds);

        $getDriver = "select `id` from `driver` where `company_id` IN ($idss) ";
        $resDriver = mysql_query($getDriver);
        $nj = '';
        while ($row = mysql_fetch_array($resDriver)) {
            $getDriIds[] = ($row['id']);
        }    
            $idss = implode(",", $getDriIds);
            $todayDate = date('Y-m-d') . ' ' . '00:00:00';
            $todayDate1 = date('Y-m-d') . ' ' . '23:59:59';
            $getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '$todayDate' and '$todayDate1' and `driver_id` IN ($idss)";
             //$getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '2016-04-29 00:00:00' and '2016-04-29 23:59:59' and `driver_id` = '7'";
            $res = mysql_query($getTrip);
            if (mysql_num_rows($res) > 0) {
                $nj = '||nj||1';
            } else {
                $nj = '||nj||22';
            }
             echo $nj;
        //}
    }
}
?>