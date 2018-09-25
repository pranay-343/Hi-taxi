<?php
include("../include/define.php"); 
$mode = base64_decode($_REQUEST['mode']);
if($mode == 'getviewUsers')
{
    $query="select u.*,l.login_status from `users` u left join `login` l ON u.web_user_id=l.id where 1 and corporate_id = '".$_SESSION['uid']."' order by id ASC";
    $result=mysql_query($query) or die();
    $num_rows=mysql_num_rows($result);
    $i=0;$location=array();
    while($row=mysql_fetch_assoc($result))
    { 
        $i++;
        if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
        $linkss = '<a href="'.CORPORATE_URL.'edit-user.php?a='.base64_encode($row['id']).'"><img src="../images/edit.png" alt="" title="" /></a>';
        $location[]=array($i,$row['name'],$row['email_id'],$row['username'],date("d M Y",strtotime($row['added_on'])),'0.00','0.00',$logg,$linkss);
    }
    $data = array("data"=>$location);
    print_r(json_encode($data));
}

if($mode == 'getColonyB')
{
    //print_r($_POST);
    $qry = 'select * from `colony` where 1 and id = "'.$_POST['a'].'" order by name_B ASC';
    $result=mysql_query($qry) or die("Error ".$qry);
    if(mysql_num_rows($result) > 0)
    {
        while($datarow=mysql_fetch_array($result))
        {
            $nj = array("option"=>"<option value='".$datarow['id']."' selected>".$datarow['b_address']."</option>","fare"=>$datarow['fare']);
        }
        echo json_encode($nj);
    }
    else
    {
        echo '0';
    }
    die;
}
?>
