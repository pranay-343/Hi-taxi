<?php
include '../include/define.php';
OnLoad();

function OnLoad()
{
	$method = $_GET['method'];
	if($method == 'emailVerification')
	{
		emailVerification();
	}
 	
}


function emailVerification()
{
	 $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));

	if(!empty($data['0']))
	{
		$ID=$data[0]['ID'];
		$latitute=$data[0]['latitute'];
		$email=$data[0]['email'];
		$longitude=$data[0]['longitude'];	
		$qry = mysql_query("select * from users where email_id = '$email'");
		if(mysql_num_rows($qry)>0)
			{	
				$thmsg['verify'] = "Yes"; 
				$msg['message']='Email Verified';
				$msg['result']=$thmsg;
				$msg['status']='200';  
				echo json_encode($msg); 
			}
		else{
				$msg['message']='Email Not Verified';
				$msg['status']='400';  
				echo json_encode($msg);
			}
   }
}
