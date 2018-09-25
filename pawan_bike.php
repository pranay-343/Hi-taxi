<?php
include 'include/define.php';
OnLoad();

function OnLoad()
{
	
		iosDevice();

}
//for ios device notification
function iosDevice()
{
	//print_r($devlopment1);
	    $deviceToken = "d1cab09526a33bc6df360070cf1f325f8064245e0537ea8e14657f31356da2a3";
	    $message = "Bike for everything";
		//$change='Bike4EverythingDriver.pem';
		//$change='CertificatesDistribution.pem';
		$change='CertificatesBike4EverythingCombine.pem';
		$passphrase = '12345';

////////////////////////////////////////////////////////////////////////////////
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $change /* drinkswap.pem'/*'VeilcomApn.pem'*/);
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
// Open a connection to the APNS server

	$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);	

//$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
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


//print_r($deviceToken);
//print_r($payload);
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));
if (!$result)
	 echo 'Message not delivered' . PHP_EOL;
else
	
    echo 'Message successfully delivered' . PHP_EOL;
// Close the connection to the server
fclose($fp);
}	
