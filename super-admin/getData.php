<?php
include("../include/define.php"); 
$mode = base64_decode($_REQUEST['mode']);
if($mode == 'getZoneAdministratorDetails')
{
	$query="select * from `login` where 1 and account_type = '2'";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
	$linkss = '<a href="view-account-administrator.php?a='.$row["id"].'" title="View" class="btn btn-xs btn-outline btn-primary add-tooltip" data-original-title="View"><i class="fa fa-eye fa-1x"></i></a>
	<a href="javascript:;" title="Delete" onclick="return deleteWorkZoneAdministartor('.$row['id'].');" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Eliminar"><i class="fa fa-times fa-1x"></i></a>
';
	$location[]=array($i,$row['name'],$row['email'],$row['contact_number'],date("d M Y h:i a",strtotime($row['added_on'])),$logg,$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));
}

if($mode == 'getworkZoneAdministratorDetails')
{
	$query="select l.id,zone_title,name from `login` as l Left Join `zone_area` as z On l.id=z.allot_to where 1 and z.zone_title != '' and account_type = '2'";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
	$linkss = '<a href="save_create_zone.php?a='.$row["id"].'" title="View" class="btn btn-xs btn-outline btn-primary add-tooltip" data-original-title="View"><i class="fa fa-eye fa-1x"></i></a>
	<a href="javascript:;" title="Delete" onclick="return deleteZoneAdministrator('.$row['id'].');" class="btn btn-xs btn-outline btn-danger add-tooltip" data-original-title="Delete"><i class="fa fa-times fa-1x"></i></a>
';
$zone_title = base64_decode($row['zone_title']);
	$location[]=array($i,$zone_title,$row['name'],'10','30','250','500',$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));
}


if($mode == 'getcordeinatesDetails')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select * from `zone_area`  where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$title['zone_title']= base64_decode($response['zone_title']);
	$title['zone_description']=base64_decode($response['zone_description']);
	
	$query = "select cordinate_title,cordinated as cordinatess,map_zoom,map_type,zone_type,id as cordinate_id from `zone_cordinater` where 1 and zone_area_id='".$response['id']."'";
	$res = mysql_query($query);
	$reactangle = array();
	$circle = array();
	$line = array();
	$polygon = array();
	while($data = mysql_fetch_assoc($res))
	{
		$dataa['zone_name'][] =array('zone_name'=>$data['zone_type']);
		if($data['zone_type'] == 'circle')
		{
			$dataa['circle'][] =$data;
		}
		
		if($data['zone_type'] == 'line')
		{
			$dataa['line'][] =$data;
		}
		
		if($data['zone_type'] == 'polygon')
		{
			$dataa['polygon'][] =$data;
		}
		

	}
	$msg['title']=$title;
	$msg['dataa']=$dataa;
	echo json_encode($msg);
}

if($mode == 'deleteZonesAdministrator')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select id from `zone_area`  where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$qryDelete = mysql_query("delete from `zone_cordinater`  where 1 and zone_area_id='".$response['id']."'");
	$qryDelete = mysql_query("delete from `zone_area`  where 1 and id='".$response['id']."'");
	$qryDelete = mysql_query("delete from `login`  where 1 and id='".$zoneId."'");
	echo '0';
}

if($mode == 'checkAdminPassword')
{
	$password = md5($_POST['a']);
	$query = mysql_query("select password from `login`  where 1 and id='".$_SESSION['uid']."'");
	$response = mysql_fetch_assoc($query);
	if($response['password'] == $password)
	{
		echo '1';
	}
	else
	{
		echo '0';
	}
}

if($mode == 'getOfZoneDriver')
{
		$getDriverCurrentZone = "SELECT * FROM trip_log WHERE 1 AND driver_id!='0' GROUP BY driver_id ORDER BY driver_id DESC ";
		$resDriverCurrentZone = mysql_query($getDriverCurrentZone);	
		while($dataDriver = mysql_fetch_array($resDriverCurrentZone)){
			$driver_id =  $dataDriver['driver_id'];
			$longitude =  $dataDriver['longitude'];
			$latitude =  $dataDriver['latitude'];
			 $str="SELECT `driver`.id,`driver`.added_by,`taxicompany`.web_user_id,`taxicompany`.zone_area_id_sess,`zone_cordinater`.zone_area_id,`zone_cordinater`.cordinated,`zone_cordinater`.zone_type FROM `driver`
              LEFT JOIN `taxicompany` ON `driver`.added_by=`taxicompany`.web_user_id
              LEFT JOIN `zone_cordinater` ON `taxicompany`.zone_area_id_sess=`zone_cordinater`.zone_area_id where `driver`.id = '".$driver_id."'";
		}
		//print_r($driver_id);
		
	/*
    $getNewMessage = mysql_fetch_assoc(mysql_query("select count(*)as totalMessage from `chat_system` where 1 and `status_company`=0 and `receiver_id`='".$_SESSION['uid']."'"));
    if($getNewMessage['totalMessage'] > 0)
    {
        $query = mysql_query("select * from `chat_system` where 1 and `job_id`='$job_id' and `status_company`=0 and ((`sender_id`='$sender_id' and `receiver_id`='$reciver_id') or (`sender_id`='$reciver_id' and `receiver_id`='$sender_id')) order by id ASC");
        if(mysql_num_rows($query) > 0)
        {
            $data = '';
            while($chatData = mysql_fetch_assoc($query))
            {
                if($_SESSION['utype']=='0')
                    {
                        $status = '`status_business` = "1"';
                    }
                else
                    {
                        $status = '`status_company` = "1"';
                    }
                $dataUpdate = mysql_query("update `chat_system` set $status where id = '".$chatData['id']."'");
                $senderData = mysql_fetch_assoc(mysql_query("select id,first_name,last_name from `web_users` where 1 and id='".$chatData['sender_id']."'"));
                $reciverData = mysql_fetch_assoc(mysql_query("select id,first_name,last_name from `web_users` where 1 and id='".$chatData['receiver_id']."'"));
                $data['senderName'] = $senderData['first_name'].' '.$senderData['last_name'];
                $data['receiverName'] = $reciverData['first_name'].' '.$reciverData['last_name'];
                $data['message'] = base64_decode($chatData['message']);
                $data['datetim'] = date("D, d M Y", strtotime($chatData['added_on']));
                $nj[]=$data;
            }
            echo json_encode($nj);
        }
    }
    else
    {
       echo '|nj|';
    }
	*/
}


if($mode == 'getcordeinatesDetails_driver')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select * from `zone_area`  where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$title['zone_title']= base64_decode($response['zone_title']);
	$title['zone_description']=base64_decode($response['zone_description']);
	
	/*$query = "select zone_cordinater.cordinate_title,zone_cordinater.cordinated as cordinatess,zone_cordinater.map_zoom,zone_cordinater.map_type,zone_cordinater.zone_type,zone_cordinater.id as cordinate_id,
	zone_cordinater_driver.cordinate_title as dr_cordinate_title,zone_cordinater_driver.cordinated as dr_cordinatess,zone_cordinater_driver.map_zoom as dr_map_zoom,zone_cordinater_driver.map_type as dr_map_type,
	zone_cordinater_driver.zone_type as dr_zone_type,zone_cordinater_driver.zone_area_dr_id as dr_cordinate_id
	from `zone_cordinater` LEFT JOIN zone_cordinater_driver ON  zone_cordinater.zone_area_id = zone_cordinater_driver.zone_area_dr_id
	where 1 and zone_area_id='".$response['id']."' AND zone_area_dr_id = '".$response['id']."'";*/
	$query = "select cordinate_title,cordinated as cordinatess,map_zoom,map_type,zone_type,id as cordinate_id from `zone_cordinater` where 1 and zone_area_id='".$response['id']."'";
	$res = mysql_query($query);
	$rectangle = array();
	$circle = array();
	$line = array();
	$polygon = array();
	while($data = mysql_fetch_assoc($res))
	{
		$dataa['zone_name'][] =array('zone_name'=>$data['zone_type']);
		if($data['zone_type'] == 'circle')
		{
			$dataa['circle'][] =$data;
		}		
		if($data['zone_type'] == 'line')
		{
			$dataa['line'][] =$data;
		}		
		if($data['zone_type'] == 'polygon')
		{
			$dataa['polygon'][] =$data;
		}
		if($data['zone_type'] == 'rectangle')
		{
			$dataa['rectangle'][] =$data;
		}	

	}
	$msg['title']=$title;
	$msg['dataa']=$dataa;
	echo json_encode($msg);
}	

if($mode == 'getcordeinatesDetails_driver_2')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select * from `zone_area`  where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$title['zone_title']= base64_decode($response['zone_title']);
	$title['zone_description']=base64_decode($response['zone_description']);
	
	$query = "select zone_cordinater_driver.id as driver_cordinated_ID,zone_cordinater_driver.cordinate_title as dr_cordinate_title,zone_cordinater_driver.cordinated as dr_cordinatess,zone_cordinater_driver.map_zoom as dr_map_zoom,zone_cordinater_driver.map_type as dr_map_type,
	zone_cordinater_driver.zone_type as dr_zone_type,zone_cordinater_driver.zone_area_dr_id as dr_cordinate_id
	from `zone_cordinater_driver` where 1 and zone_area_dr_id = '".$response['id']."' AND zone_cordinater_driver.added_by = '".$_SESSION['uid']."' AND zone_cordinater_driver.forbidden_zone = '0'";
	//$query = "select cordinate_title,cordinated as cordinatess,map_zoom,map_type,zone_type,id as cordinate_id from `zone_cordinater` where 1 and zone_area_id='".$response['id']."'";
	$res = mysql_query($query);
	$rectangle = array();
	$circle = array();
	$line = array();
	$polygon = array();
	while($data = mysql_fetch_assoc($res))
	{
		$dataa['zone_name'][] =array('zone_name'=>$data['dr_zone_type']);
		
		
		if($data['dr_zone_type'] == 'polygon')
		{
			$dataa['dr_polygon'][] =$data;
		}	
		

	}
	//print_r($dataa);echo'<><>';
	$msg['title']=$title;
	$msg['dataa']=$dataa;
	//$msg['title']=$title;
	//$msg['dataa1']=$dataa1;
	echo json_encode($msg);
}

if($mode == 'getcordeinatesDetails_driver_3')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select * from `zone_area`  where 1 and id='".$zoneId."'");
	$response = mysql_fetch_assoc($query);
	$title['zone_title']= base64_decode($response['zone_title']);
	$title['zone_description']=base64_decode($response['zone_description']);
	
	$query = "select zone_cordinater_driver.id as driver_cordinated_ID,zone_cordinater_driver.cordinate_title as dr_cordinate_title,zone_cordinater_driver.cordinated as dr_cordinatess,zone_cordinater_driver.map_zoom as dr_map_zoom,zone_cordinater_driver.map_type as dr_map_type,
	zone_cordinater_driver.zone_type as dr_zone_type,zone_cordinater_driver.zone_area_dr_id as dr_cordinate_id
	from `zone_cordinater_driver` where 1 and zone_area_dr_id = '".$response['id']."' AND zone_cordinater_driver.added_by = '".$_SESSION['uid']."' and zone_cordinater_driver.forbidden_zone = '1'";
	//$query = "select cordinate_title,cordinated as cordinatess,map_zoom,map_type,zone_type,id as cordinate_id from `zone_cordinater` where 1 and zone_area_id='".$response['id']."'";
	$res = mysql_query($query);
	$rectangle = array();
	$circle = array();
	$line = array();
	$polygon = array();
	while($data = mysql_fetch_assoc($res))
	{
		$dataa['zone_name'][] =array('zone_name'=>$data['dr_zone_type']);
		
		
		if($data['dr_zone_type'] == 'polygon')
		{
			$dataa['dr_polygon'][] =$data;
		}	
		

	}
	//print_r($dataa);echo'<><>';
	$msg['title']=$title;
	$msg['dataa']=$dataa;
	//$msg['title']=$title;
	//$msg['dataa1']=$dataa1;
	echo json_encode($msg);
}


if($mode == 'remove_cordinateds_of_drivers')
{
	$zoneId = $_POST['a'];
	$nj = "delete from `zone_cordinater_driver` where 1 and id='".$zoneId."'";
	$query = mysql_query($nj);
}

// For autocomplete zone admin name
if($mode == 'getZoneAdminName'){
    $query="SELECT name,id FROM `login` where 1 and account_type ='2' ";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == "0") {
            $json[] = array('value' => 'not found');
        } else
        {
            while ($row = mysql_fetch_array($result))
            {
                $json[] = array(
                    //'id' => $row['id'],
                    'value' => $row['name']
                );
            }
        }
        echo json_encode($json);
}

// For autocomplete zone area name
if($mode == 'getZoneAreaName'){
    $query="SELECT zone_title,id FROM `zone_area`";
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == "0") {
            $json[] = array('value' => 'not found');
        } else
        {
            while ($row = mysql_fetch_array($result))
            {
                $json[] = array(
                    //'id' => $row['id'],
                    'value' => base64_decode($row['zone_title'])
                );
            }
        }
        echo json_encode($json);
}

?>
