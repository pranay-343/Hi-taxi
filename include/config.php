<?php 

$hostname = 'localhost';
$database = 'Hitaxi';
$username = 'Hitaxi';
$password = 'Hitaxi@123';

$conn = mysql_connect($hostname,$username,$password) or die(mysql_error());	
$dba = mysql_select_db($database,$conn) or die(mysql_error());


//Email settings variables
define("FROM_ADMIN_EMAIL_ID","mmfinfotech253@gmail.com");
define("TO_ADMIN_EMAIL_ID","mmfinfotech253@gmail.com");
define("FROM_ADMIN_NAME","Admin");
define("TO_ADMIN_NAME","Admin");
define("REPLY_ADMIN_EMAIL_ID","mmfinfotech253@gmail.com");
define("REPLY_ADMIN_NAME","Admin");
//=======================

date_default_timezone_set("Asia/Kolkata");

?>