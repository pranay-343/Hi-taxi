<?php

OnLoad();


 function OnLoad()
 {

    $method = $_GET['method'];
	if($method == 'iosDevice')
	{
		iosDevice();
	}
 }
function iosDevice()
{
	$data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
	if(!empty($data['0']))
	{
	$deviceToken1 = $data[0]['deviceTokan'];


$deviceToken =$deviceToken1;// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
//$deviceToken ='928035737063df3e83586a7246f0c4eb8fd9ce60b84387fd60ad7c71480dbd2a';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
// Put your private key's passphrase here:
$passphrase = 'mmf123';
// Put your alert message here:
$message = 'Hello, notification recevied';
////////////////////////////////////////////////////////////////////////////////
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'APNSDemoDistribution.pem'/* drinkswap.pem'/*'VeilcomApn.pem'*/);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
// Open a connection to the APNS server
//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
echo 'Connected to APNS' . PHP_EOL;
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
	echo 'Message successfully delivered' . PHP_EOL.' '.$deviceToken;
// Close the connection to the server
fclose($fp);
}
}
?>