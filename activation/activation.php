<?php 
include '../include/define.php';

function iosDevice($registatoin_ids, $message)
{
	// if($types=='7')
	// {
	print_r($registatoin_ids);
		//$change='pushcertuser.pem';
		//$change='CertificatesUser.pem';
		//$change='APNSDemoDevelopment.pem';
		//$change='APNSDemoDevelopment.pem';
		//$passphrase = 'mmf123';
	    $change='pushcert.pem';
		$passphrase = 'mmf123';
		$string = json_encode($message);
	// }
	// else
	// {
	// 	$change='CertificatesDistribution.pem';
	// 	$passphrase = '12345';
	// }
 
		//echo $deviceToken=$data[0]['DoviceTokan'];		
        //echo $message=$data[0]['msg'];
// Put your device token here (without spaces):
//$deviceToken ='0bb37f504788f3a66c3d5fb1f2506bccbe8c02ea84e84a9e66221e29cde43294';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
//$deviceToken ='928035737063df3e83586a7246f0c4eb8fd9ce60b84387fd60ad7c71480dbd2a';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
// Put your private key's passphrase here:
//$passphrase = 'mmf123';


// Put your alert message here:
//$message = 'Hello, I am a TAXI USER!';
////////////////////////////////////////////////////////////////////////////////
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $change /* drinkswap.pem'/*'VeilcomApn.pem'*/);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
// Open a connection to the APNS server
// if($types == '99')
// {
// 	if($devlopment == '0')
// 	{
// 	$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
// 	}
// 	else
// 	{
// 	 $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);	
// 	}
// }

	// $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
       $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	
	// $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);	

//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
 'Connected to APNS' . PHP_EOL;
// Create the payload body
$body['aps'] = array(
	'alert' => $string,
	'sound' => 'default',
	'userid'=>'1'
	);
// Encode the payload as JSON
$payload = json_encode($body);
// Build the binary notification


//print_r($deviceToken);
//print_r($payload);
$msg = chr(0) . pack('n', 32) . pack('H*', $registatoin_ids) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
if (!$result)
echo	 'Message not delivered' . PHP_EOL;
else
	
 echo    'Message successfully delivered' . PHP_EOL;
// Close the connection to the server
     fclose($fp);
}



 $id=$_REQUEST['id'];
 $str1="select device_type,device_id,email_verify,id from users where id='$id'";
 $res1=mysql_query($str1);
 $row=mysql_fetch_array($res1);

 $gcm_regid=$row['device_id'];
 if($row['email_verify'] == '1')
 {
 	echo "Su cuenta ya está activa, no hay necesidad de verificarla nuevamente.";
 }
 else
 {
 $str="update users set email_verify='1' where id='$id' ";
 $res=mysql_query($str); 
 $contents['verifyEmail'] = "Yes";
 $message = array("activation" => $contents);
 if($row['device_type']=="IOS")
 {
 	
   $registatoin_ids = $gcm_regid;
   iosDevice($registatoin_ids, $message);
 }
 else
 {
 $registatoin_ids = array($gcm_regid);

 send_notification($registatoin_ids, $message);
 }
?>
<h1>Gracias por activar su cuenta.</h1>
<?php
}
?>
