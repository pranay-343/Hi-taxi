<?php 
session_start();

include_once("class/class.connect.php");
include_once("class/class.common.php"); 
include_once("common_functions.php");
//include_once("../pop2.php");

//include_once("../pageFragment/corporateUserAccount.php");

define("SUPER_ADMIN_URL","http://truckslogistics.com/Projects-Work/Hi-taxi/super-admin/");
define("CORPORATE_URL","http://truckslogistics.com/Projects-Work/Hi-taxi/corp-user/");
define("TAXI_URL","http://truckslogistics.com/Projects-Work/Hi-taxi/taxi-company/");
define("ZONE_URL","http://truckslogistics.com/Projects-Work/Hi-taxi/zone-admin/");
define("MAIN_URL","http://truckslogistics.com/Projects-Work/Hi-taxi/");
define("image_PATH","http://truckslogistics.com/Projects-Work/Hi-taxi/images/");
define("MAIN_URL_WWW","http://truckslogistics.com/Projects-Work/Hi-taxi/");

//Email settings variables
define("FROM_ADMIN_EMAIL_ID","andy.hvantage@gmail.com");
define("TO_ADMIN_EMAIL_ID","andy.hvantage@gmail.com");
define("FROM_ADMIN_NAME","Admin");
define("TO_ADMIN_NAME","Admin");
define("REPLY_ADMIN_EMAIL_ID","andy.hvantage@gmail.com");
define("REPLY_ADMIN_NAME","Admin");
define("CURRENCY"," $");
//=======================

define("INC_HEAD","../include/head.php");
define("INC_HEADER","../include/header.php");
define("INC_NAV","../include/navbar.php");
define("INC_SIDE","../include/sidebar.php");
define("INC_FOOTER","../include/footer.php");
define("INC_TOP_SCRIPT","../include/top-script.php");
define("INC_FOOT_SCRIPT","../include/footer-script.php");

define("account_act_amt","1000");
define("corporation_act_amt","500");
define("driver_act_amt","300");

$objConnect = new connect;
$objCommon = new common;
date_default_timezone_set("Asia/Kolkata");


//include("new_polygon.php");
?>