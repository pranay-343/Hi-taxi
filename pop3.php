<?php
include 'include/define.php';
if($_SESSION['uid'] !="")
{
$getDriver = "select `id` from `driver` where `company_id` = '".$_SESSION['uid']."' ";
$resDriver = mysql_query($getDriver);
while($row=mysql_fetch_array($resDriver))
{
$todayDate = date('Y-m-d').' '.'00:00:00';
$todayDate1 = date('Y-m-d').' '.'23:59:59';
$getTrip = "select `panictaxirequest`,`driver_id` from `trip` where `panictaxirequest` !='' and `tripdatetime` BETWEEN '$todayDate' and '$todayDate1' and `driver_id` = '".$row['id']."'";
$res=mysql_query($getTrip);
if(mysql_affected_rows()>0)
{
	//echo "<script>alert('dk')</script>";
     echo '
       <script type="text/javascript">
         function hideMsg()
         {
            document.getElementById("show").style.visibility = "hidden";
         }

         document.getElementById("show").style.visibility = "visible";
         window.setTimeout("hideMsg()", 6000);
       </script>';
    }
// else
// {
// 	 echo "hello all";
// }
}
}
// else
// {
// 	echo "No Session available at this momment";
// }
?>