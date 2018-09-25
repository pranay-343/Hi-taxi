<?php
//echo "sss";
include '../include/define.php';
OnLoad();

 function OnLoad()
 {
 	//echo "<script>alert('ok')</script>";
	//$method = $_GET['method'];
 //	if($method == 'iosDevice') 	{
		iosDevice();
 ///	}
 }
function iosDevice()
{
	//echo "<script>alert('ok')</script>";
 
		//echo $deviceToken=$data[0]['DoviceTokan'];		
        //echo $message=$data[0]['msg'];
// Put your device token here (without spaces):
$deviceToken ='9997e76c47e74365b469f53bc3543658e4d084acbe2a37210e40362c81a8d76b';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
//$deviceToken ='928035737063df3e83586a7246f0c4eb8fd9ce60b84387fd60ad7c71480dbd2a';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
// Put your private key's passphrase here:
$passphrase = '123456789';


// Put your alert message here:
 $message = 'Hello, I am a TAXI USER!';
////////////////////////////////////////////////////////////////////////////////
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'pushcert.pem'/* drinkswap.pem'/*'VeilcomApn.pem'*/);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
// Open a connection to the APNS server
$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
 'Connected to APNS' . PHP_EOL;
// Create the payload body
$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'userid'=>'1'
	);
// Encode the payload as JSON
$payload = json_encode($body);
// Build the binary notification



$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	
	echo  'Message successfully delivered' . PHP_EOL;
// Close the connection to the server
fclose($fp);
}

?>
