<?php 
$host = $_SERVER['HTTP_HOST'];
$hostname = 'localhost';
$database = 'hvantage_taxi-central';
$username = 'hvantage_central';
$password = 'hvantage_taxi-central';
     
$connection = mysql_connect($hostname, $username, $password) or die("Error : ".mysql_error());
$select_db = mysql_select_db($database, $connection);
 
    $get_all_drivers = mysql_query("SELECT id FROM driver");
    $num_rows = mysql_num_rows($get_all_drivers);
    $driversId = '';
    while($data = mysql_fetch_array($get_all_drivers)){
   
    $driversId = $data['id'];
    $get_last_driver_payment  = "SELECT  driver_name, paymentDateTo  FROM driverPayment WHERE driver_name = $driversId ORDER BY id DESC LIMIT 1";
    $res_last_driver_payment = mysql_query($get_last_driver_payment);
    while ($row = mysql_fetch_array($res_last_driver_payment)) {
        $current_date = date('Y-m-d H:i:s');
        $acti_last_date =  date('Y-m-d', strtotime($row['paymentDateTo']));
        $suspend_date= date('Y-m-d', strtotime($acti_last_date. ' + 21 days'));
        
        if($current_date > $row['paymentDateTo'] AND $row['paymentDateTo'] < $suspend_date)
        {
         echo  $unpaidDriver = "UPDATE `driver` set `status` = '900' where `id` = '".$row['driver_name']."'" ;
           $resUnpaid = mysql_query($unpaidDriver);
        }

        echo ' SUS : -'.$row['driver_name'].'---'; print_r($suspend_date);echo'<br/>';
        if($suspend_date < $current_date){
        echo $row['driver_name'].'--------';echo'<br/>';
        $update_driver = "UPDATE  `driver` set `status`='400', `updated_on` = '$current_date', `by_cron_job` = 'end_activation' WHERE id = '".$row['driver_name']."'";
        $result_update = mysql_query($update_driver);
           
          mysql_query("INSERT into `chk_data_nj` (`name`,`date`) values ('suspend', '$current_date')");
        }
        
    }

     }// end first while here
?>