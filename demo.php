<?php

	$passphrase = 'Demo Praveen';
	// Put your alert message here:
	$message = 'Just check Push Notification...! ';
	$deviceToken= '084681d1a5703e19da8075cb897f50fdc21b21b62861c4efbe28de5765e727ee';
	//a8e2e09c453c67310ed45f6ee2458132eb52a9fe9fc05958f59750e3982c17fb
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	
	// Open a connection to the APNS server
	//$gateway = 'gateway.sandbox.push.apple.com:2195';
	$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr,60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	//$fp = stream_socket_client(
   // $gateway, $err,
   /// $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);
	//echo 'Connected to APNS' . PHP_EOL;
	$badge = 6;
	
	$body['aps'] = array(
	'alert' => $message,
	'sound' => 'default',
	'badge'=> $badge
	);
	
	// Encode the payload as JSON
	$payload = json_encode($body);
	
	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
	// Send it to the server
	echo $result = fwrite($fp, $msg, strlen($msg));
	if (!$result)
	{
	echo 'Message not delivered' . PHP_EOL;
	//echo '111';
	}
	else
	{
	echo "Message send success";
	}	


?>

<?php
// Provide the Host Information.
//$tHost = 'gateway.sandbox.push.apple.com';
$tHost = 'gateway.push.apple.com';
$tPort = 2195;
// Provide the Certificate and Key Data.
	
$tCert = 'ck.pem';
// Provide the Private Key Passphrase (alternatively you can keep this secrete
// and enter the key manually on the terminal -> remove relevant line from code).
// Replace XXXXX with your Passphrase
$tPassphrase = 'choc3747*';
// Provide the Device Identifier (Ensure that the Identifier does not have spaces in it).
// Replace this token with the token of the iOS device that is to receive the notification.
//$tToken = 'b3d7a96d5bfc73f96d5bfc73f96d5bfc73f7a06c3b0101296d5bfc73f38311b4';
$tToken = '084681d1a5703e19da8075cb897f50fdc21b21b62861c4efbe28de5765e727ee';
//0a32cbcc8464ec05ac3389429813119b6febca1cd567939b2f54892cd1dcb134
// The message that is to appear on the dialog.
$tAlert = 'You have a LiveCode APNS Message';
// The Badge Number for the Application Icon (integer >=0).
$tBadge = 8;
// Audible Notification Option.
$tSound = 'default';
// The content that is returned by the LiveCode "pushNotificationReceived" message.
$tPayload = 'APNS Message Handled by LiveCode';
// Create the message content that is to be sent to the device.
$tBody['aps'] = array (
'alert' => $tAlert,
'badge' => $tBadge,
'sound' => $tSound,
);
$tBody ['payload'] = $tPayload;
// Encode the body to JSON.
$tBody = json_encode ($tBody);
// Create the Socket Stream.
$tContext = stream_context_create ();
stream_context_set_option ($tContext, 'ssl', 'local_cert', $tCert);
// Remove this line if you would like to enter the Private Key Passphrase manually.
stream_context_set_option ($tContext, 'ssl', 'passphrase', $tPassphrase);
// Open the Connection to the APNS Server.
$tSocket = stream_socket_client ('ssl://'.$tHost.':'.$tPort, $error, $errstr, 30, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $tContext);
// Check if we were able to open a socket.
if (!$tSocket)
exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
// Build the Binary Notification.
$tMsg = chr (0) . chr (0) . chr (32) . pack ('H*', $tToken) . pack ('n', strlen ($tBody)) . $tBody;
// Send the Notification to the Server.
$tResult = fwrite ($tSocket, $tMsg, strlen ($tMsg));
if ($tResult)
echo 'Delivered Message to APNS' . PHP_EOL;
else
echo 'Could not Deliver Message to APNS' . PHP_EOL;
// Close the Connection to the Server.
fclose ($tSocket);
?>