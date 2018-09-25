<?php
//error_reporting(0);
//session_start();
date_default_timezone_set("Asia/Kolkata");
include ('../include/define.php');
include ('../../config/define.php');
include ('../../controller/general_controller.php');
include ('../../controller/admin_user.php');

$objCommon = new generalFunctions();
$objAdminUser = new adminUser();
function fill_combo($id,$qry,$attr,$plsval="")
        {echo "<select id='$id' class='form-control' name='$id' $attr>";
        if($plsval!=""){
            echo "<option value=''>".$plsval."</option>";
            }$result=mysql_query($qry) or die("Error ".$qry);
            while($datarow=mysql_fetch_array($result))	{
                echo "<option value='".$datarow[0]."'>".$datarow[1]."</option>";
                }	
                echo "</select>";
                
            }
                
   function fill_combo_option($qry,$attr,$plsval="")
        {if($plsval!="")
       {
            echo "<option value=''>".$plsval."</option>";
       }
       $result=mysql_query($qry) or die("Error ".$qry);
       while($datarow=mysql_fetch_array($result))
        {
           echo "<option value='".$datarow[0]."'>".$datarow[1]."</option>";
           
        }
        
        }
?>