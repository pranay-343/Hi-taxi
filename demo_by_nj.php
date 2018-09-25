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

//$deleteQry = mysql_query("delete from `chk_nj_data` where 1");
$insertdata = mysql_query("insert into `chk_nj_data` (`name`) values ('nj')");
?>