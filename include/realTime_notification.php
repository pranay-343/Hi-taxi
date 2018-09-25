<?php
include '../include/define.php';
?>
 <style type="text/css">
 #popup {
    visibility: hidden; 
    background-color: yellow; 
    position: absolute;
    top: 35%;
    left:40%;
    border-radius: 10px;
    z-index: 100; 
    height: 100px;
    width: 300px
}
 </style>
 <div id="popup">
    <p style="text-align: -webkit-center;margin-top: 38px;">User is in panic</p>
</div>
<?php
//$insert = mysql_query("insert into `chk_data_nj` (`name`,`date`) values ('dk1','2016-04-08')");
if($_SESSION['uid'] !="")
{
$getDriver = "select `id` from `driver` where `company_id` = '".$_SESSION['uid']."' ";
$resDriver = mysql_query($getDriver);
while($row=mysql_fetch_array($resDriver))
{
	//$insert = mysql_query("insert into `chk_data_nj` (`name`,`date`) values ('dk2','2016-04-08')");
$todayDate = date('Y-m-d').' '.'00:00:00';
$todayDate1 = date('Y-m-d').' '.'23:59:59';
echo $getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '$todayDate' and '$todayDate1' and `driver_id` = '".$row['id']."'";
$res=mysql_query($getTrip);
if(mysql_affected_rows()>0)
{
	echo "<script>alert('dk')</script>";
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("popup").style.visibility = "hidden";
         }

         document.getElementById("popup").style.visibility = "visible";
         window.setTimeout("hideMsg()", 6000);
       </script>';
    }
else
{
	//$insert = mysql_query("insert into `chk_data_nj` (`name`,`date`) values ('dk4','2016-04-08')");
	 echo "hello all";
}
}
}
else
{
	echo "No Session available at this momment";
}
?>