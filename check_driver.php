<?php
$host = $_SERVER['HTTP_HOST'];
$hostname = 'localhost';
$database = 'hvantage_taxi-central';
$username = 'hvantage_central';
$password = 'hvantage_taxi-central';
     
$connection = mysql_connect($hostname, $username, $password) or die("Error : ".mysql_error());
 $select_db = mysql_select_db($database, $connection);
if (!$select_db) {
    die("Cannot access database: " . mysql_error());
}


date_default_timezone_set("Asia/Kolkata");
  $currentDate = date('Y-m-d H:i:s');


$nj = "insert into `chk_data_nj` (`name`,`date`) values ('nj','".$currentDate."')";
mysql_query($nj);


 $expire_stamp = date('Y-m-d H:i:s', strtotime("-3 min"));

$data = "select * from `trip_log` GROUP by `driver_id` ORDER by driver_id DESC";
//$data = "select * from `trip_log` ORDER BY `trip_log`.id DESC LIMIT 0,5";
$result = mysql_query($data);
while($rowData11=mysql_fetch_array($result))
{
 $driver_id = $rowData11['driver_id']."<br>";

 $checkDriver="select * from `trip_log` where driver_id='".$driver_id."' and `date` >= '$expire_stamp' and `date` <= '$currentDate'";
$result1=mysql_query($checkDriver);
$dateData=mysql_num_rows($result1);
if($dateData>0)
{
	 $updateDriver="update driver set login_status='1' where id='".$driver_id."'";
	 $resultDriver=mysql_query($updateDriver);
	// $updateDriver="update driver set login_status='1' where id='".$driver_id."'";
	// $resultDriver=mysql_query($updateDriver);
	// if($resultDriver)
	// {
 	echo "yes";
	// }
}
else
{
	 $updateDriver="update driver set login_status='0' where id='".$driver_id."'";
	$resultDriver=mysql_query($updateDriver);
	// if($resultDriver)
	// {
		echo "no";
	//}
}
}
?>
