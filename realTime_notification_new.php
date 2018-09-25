<?php
include("include/define.php"); 
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
        while ($row = mysql_fetch_array($resDriver)) {
            $todayDate = date('Y-m-d') . ' ' . '00:00:00';
            $todayDate1 = date('Y-m-d') . ' ' . '23:59:59';
            $getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '$todayDate' and '$todayDate1' and `driver_id` = '".$row['id']."'";
            $res = mysql_query($getTrip);
            if (mysql_affected_rows() > 0) {
                echo '||nj||1';
            }
            else
            {
                echo '||nj||1';
            }
        }
    }
}
?>