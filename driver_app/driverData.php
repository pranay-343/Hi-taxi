<?php
include '../include/define.php';
OnLoad();

function OnLoad()
{
    $method = $_GET['method'];
    if($method == 'SignIn')
    {
        SignIn();
    }
    elseif($method == 'getTrip')
    {
        getTrip();
    }
    elseif($method == 'previousTrip')
    {
        previousTrip();
    }
    elseif($method == 'acceptTrip')
    {
        acceptTrip();
    }
    elseif($method == 'rejectTrip')
    {
        rejectTrip();
    }
    elseif($method == 'sendMessage')
    {
        sendMessage();
    }
    elseif($method == 'arrivedTrip')
    {
        arrivedTrip();
    }
    elseif($method == 'boardedTrip')
    {
        boardedTrip();
    }
    elseif($method == 'endTrip')
    {
        endTrip();
    }
     elseif($method == 'rateing')
    {
        rateing();
    }
    elseif($method == 'anonymousReport')
    {
        anonymousReport();
    }
    elseif($method == 'news')
    {
        news();
    }
    elseif($method == 'tripHistory')
    {
        tripHistory();
    }
    elseif($method == 'locationUpdate')
    {
        locationUpdate();
    }
    elseif($method == 'PayPayment')
    {
        PayPayment();
    }
    elseif($method == 'corporateAccount')
    {
        corporateAccount();
    }
    elseif($method == 'userAccount')
    {
        userAccount();
    }
    elseif($method == 'getAdminNotification')
    {
        getAdminNotification();
    }
    elseif($method == 'zoneDriverData')
    {
        zoneDriverData();
    }
    elseif($method == 'driverCondition')
    {
        driverCondition();
    }
    elseif($method == 'temporarly')
    {
        temporarly();
    }
}
//for ios device notification
function iosDevice($deviceToken,$message, $types)
{
    if($types=='7')
    {
        //$change='pushcertuser.pem';
        $change='CertificatesUser.pem';
    }
    else
    {
        $change='pushcert.pem';
    }
 
        //echo $deviceToken=$data[0]['DoviceTokan'];        
        //echo $message=$data[0]['msg'];
// Put your device token here (without spaces):
//$deviceToken ='0bb37f504788f3a66c3d5fb1f2506bccbe8c02ea84e84a9e66221e29cde43294';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
//$deviceToken ='928035737063df3e83586a7246f0c4eb8fd9ce60b84387fd60ad7c71480dbd2a';// 'd1a9879de0a90ad5b66e568ac216f88f9997f7e9ba33b384fbba85ea33fc8acb';
// Put your private key's passphrase here:
$passphrase = '123456789';


// Put your alert message here:
//$message = 'Hello, I am a TAXI USER!';
////////////////////////////////////////////////////////////////////////////////
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', $change /* drinkswap.pem'/*'VeilcomApn.pem'*/);
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
     'Message not delivered' . PHP_EOL;
else
    
     'Message successfully delivered' . PHP_EOL;
// Close the connection to the server
fclose($fp);
}


// function for send message through gcm
/*function send_notification($registatoin_ids, $message)
        { 

         $url = 'https://android.googleapis.com/gcm/send';
         $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $message,
        );
 
        $headers = array(
            'Authorization: key = AIzaSyAQ5Se4Tu1LmgZDAwQ-mguA73x__s8HsTY',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
       
        $result;
    }
*/
//Get Trip
function getTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
    }
      $driverId1=$data[0]['driverId'];
      //$str900="select * from driver"
      $str200="select * from driver where id='$driverId1'";
      $res200=mysql_query($str200);
      $row200=mysql_fetch_assoc($res200);
      //$row200['trip_fare'];
      $permission=$row200['status'];
      if($permission=='200')
      {
        $permission1='1';
      }
      else
      {
        $permission1='0';
      }
     if($row200['zone_id'] == '0')
     {
              $str100="select source_latitude,source_longitude,id from trip where status='0'";

              // $str100="SELECT `trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_landmark,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.travelTime,`trip`.tripdatetime,`trip`.agreement,`trip`.trip_distance,`trip`.price_perkm,`users`.name,`users`.contact_no,`trip`.trip_type,`trip`.trip_ammount From `trip` LEFT JOIN `users` ON `trip`.customer_id=`users`.id  WHERE `trip`.id='73' and `trip`.status='0'";
              $res100=mysql_query($str100);
              while($row100=mysql_fetch_array($res100))
              {
              //echo $row100['id'];
              $latitude = $row100['source_latitude'];
              $longitude = $row100['source_longitude'];
              //$tripId=$row100['id'];
              //$name['tripId']=$tripId;
             // $contents[]=$row100;

            // echo $getTripId[]=$row100['id']."<br>";
              
              $string = $latitude." ".$longitude;
            
              $pointLocation = new pointLocation();

              $points = array($string);
          //  print_r($points);
          
            //$strCordinated="select zone_area_id,cordinated from zone_cordinater";
            $strCordinated="SELECT `zone_cordinater`.zone_type,`taxicompany`.id,`taxicompany`.zone_area_id_sess,`taxicompany`.name,`taxicompany`.web_user_id as webtaxiid,`zone_cordinater`.zone_area_id,`zone_cordinater`.cordinated,`driver`.company_id,`driver`.name as driverName,`driver`.id as driverId FROM `zone_cordinater`
                          LEFT JOIN `taxicompany` ON `zone_cordinater`.zone_area_id=`taxicompany`.zone_area_id_sess
                        LEFT JOIN `driver` ON `taxicompany`.web_user_id=`driver`.company_id";
            $resultCordinated=mysql_query($strCordinated);
          // echo  $num=mysql_num_rows($resultCordinated);
            while($rowCordinated = mysql_fetch_array($resultCordinated))
            {
                
                if($rowCordinated['name'] != "")
                {       
                    $name['companyName'] = $rowCordinated['name'];
                    
                }
                else
                {
                    $name['companyName'] = "";
                }
                if($rowCordinated['id'] != "")
                {       
                    $name['id'] = $rowCordinated['webtaxiid'];
                }
                else
                {
                    $name['id'] = "";
                }
                //$companyId = $rowCordinated['id'];
                $zone_area_id = $rowCordinated['zone_area_id'];
                $name['driverName'] = $rowCordinated['driverName'];
                $name['driverId1'] = $rowCordinated['driverId'];

                $data1= $rowCordinated['cordinated']; 
                 
                $data  = str_replace("),(","/",$data1);
                $data2 = str_replace(",","",$data);
                $data5 = str_replace("(","",$data2);
                $data6 = str_replace(")","",$data5);

                $data3 = explode("/",$data6);
            //echo'<pre>';print_r($data3);
                $polygon = $data3;
           // print_r($polygon);

             // $getTripId[]=$row100['id'];
             // $withoutDuplicates = array_unique(array_map("strtoupper", $getTripId));
            foreach($points as $key => $point)
             {
                //echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon);
                $values = $pointLocation->pointInPolygon($point, $polygon);
               // print_r($values);
                if($values == "inside" || $values == "vertex"|| $values == "boundary")
                {                       
                       // foreach($points as $key => $point)
                        $companyName[]=$name;
                        $driverId100[]=$name['driverId1'];
                        $name['tripId']=$row100['id'];
                }
             
             }
        } // end while loop
                // if($values == "inside" || $values == "vertex"|| $values == "boundary")
                // {
                //     $getTripId[]=$row100['id'];
                // }
            }
           // print_r($companyName);
           // echo count($companyName);
            //$withoutDuplicates = array_unique(array_map("strtoupper", $getTripId));
            //print_r($withoutDuplicates);
            for($i=0;$i<count($companyName);$i++)
                        {     
                       // echo $companyName[$i]['companyName']."<br>"; 
                       // echo $companyName[$i]['tripId']."<br>" ;
                       // echo $companyName[$i]['driverId1']."<br>";                  

                          if($companyName[$i]['companyName'] != "" && $companyName[$i]['tripId'] != "" && $companyName[$i]['driverId1'] !="")
                          {
                            //echo "kuch bhi".$i;
                            
                           if($driverId1 == $companyName[$i]['driverId1'])
                          {
                          // print_r($companyName[$i]);
                            $str110="SELECT`trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_landmark,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.travelTime,`trip`.tripdatetime,`trip`.agreement,`trip`.trip_distance,`trip`.price_perkm,`users`.name,`users`.contact_no,`trip`.trip_type,`trip`.trip_ammount From `trip` LEFT JOIN `users` ON `trip`.customer_id=`users`.id  WHERE `trip`.id='".$companyName[$i]['tripId']."' and `trip`.status='0'";
                            $res110=mysql_query($str110);
                            $row110=mysql_fetch_assoc($res110);
                            $contents111[]=$row110;

                          }
                            
                          }
                      }
                             
                             if($contents111 != '')
                             {
                                 $msg['message']='successfull';
                                 $msg['result']=$contents111;
                                 $msg['permission']=$permission1;
                                 $msg['status']='200';
                                 echo json_encode($msg);
                             }
                            else
                            {
                                $contents2['msg'] = 'No trip available in your zone';
                                $msg['message']='Error';
                                $msg['result']=$contents2;
                                $msg['status']='400';
                                echo json_encode($msg);
                            }
           //  die();
  } //my first if for checking driver sub zone alot or not
  else
  {
    $str100="select source_latitude,source_longitude,id from trip where status='0'";

              // $str100="SELECT `trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_landmark,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.travelTime,`trip`.tripdatetime,`trip`.agreement,`trip`.trip_distance,`trip`.price_perkm,`users`.name,`users`.contact_no,`trip`.trip_type,`trip`.trip_ammount From `trip` LEFT JOIN `users` ON `trip`.customer_id=`users`.id  WHERE `trip`.id='73' and `trip`.status='0'";
              $res100=mysql_query($str100);
              while($row100=mysql_fetch_array($res100))
              {
              //echo $row100['id'];
              $latitude = $row100['source_latitude'];
              $longitude = $row100['source_longitude'];
              //$tripId=$row100['id'];
              //$name['tripId']=$tripId;
             // $contents[]=$row100;

            // echo $getTripId[]=$row100['id']."<br>";
            $string = $latitude." ".$longitude;
        
            $pointLocation = new pointLocation();

            $points = array($string);
           // print_r($points);
          
            //$strCordinated="select zone_area_id,cordinated from zone_cordinater";
            $strCordinated="SELECT `zone_cordinater_driver`.cordinated,`zone_cordinater_driver`.id,`zone_cordinater_driver`.zone_area_dr_id,`taxicompany`.id ,`taxicompany`.zone_area_id_sess,`taxicompany`.name,`taxicompany`.web_user_id from `zone_cordinater_driver`
                LEFT JOIN `taxicompany` ON `zone_cordinater_driver`.zone_area_dr_id=`taxicompany`.zone_area_id_sess where `zone_cordinater_driver`.id='".$row200['zone_id']."' and `taxicompany`.id='".$row200['company_id']."'";
            $resultCordinated=mysql_query($strCordinated);
          // echo  $num=mysql_num_rows($resultCordinated);
            while($rowCordinated = mysql_fetch_array($resultCordinated))
            {
               // echo "dinesh".$row100['id'];

                if($rowCordinated['name'] != "")
                {       
                    $name['companyName'] = $rowCordinated['name'];
                    
                }
                else
                {
                    $name['companyName'] = "";
                }

                $data1= $rowCordinated['cordinated']; 
                 
                $data  = str_replace("),(","/",$data1);
                $data2 = str_replace(",","",$data);
                $data5 = str_replace("(","",$data2);
                $data6 = str_replace(")","",$data5);

                $data3 = explode("/",$data6);
            //echo'<pre>';print_r($data3);
                $polygon = $data3;
           //print_r($polygon);

             // $getTripId[]=$row100['id'];
             // $withoutDuplicates = array_unique(array_map("strtoupper", $getTripId));
            foreach($points as $key => $point)
             {
                //echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon);
                $values = $pointLocation->pointInPolygon($point, $polygon);
               ///print($values);

                if($values == "inside" || $values == "vertex"|| $values == "boundary")
                {
                    //echo "ssss";
                        $name['tripId']=$row100['id'];
                        $companyName[]=$name;
                }
             
             }

        } // end while loop
             
            }
           // print_r($name);
           
                         
                          
                          // print_r($companyName[$i]);
                            $str110="SELECT`trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_landmark,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.travelTime,`trip`.tripdatetime,`trip`.agreement,`trip`.trip_distance,`trip`.price_perkm,`users`.name,`users`.contact_no,`trip`.trip_type,`trip`.trip_ammount From `trip` LEFT JOIN `users` ON `trip`.customer_id=`users`.id  WHERE `trip`.id='".$name['tripId']."' and `trip`.status='0'";
                            $res110=mysql_query($str110);
                            $n = mysql_num_rows($res110);
                            // if($n>0)
                            //      {   
                            //         $row110=mysql_fetch_assoc($res110);
                            //         $contents111[]=$row110;
                            //       }
                            //    else{

                            //         $contents111[]='Data Not Available';
                            //    }         
                        
                           //print_r($contents111);
                        
                     
                             
                             if($n>0)
                             {
                                 $msg['message']='successfull';
                                 $msg['result']=$contents111;
                                 $msg['permission']=$permission1;
                                 $msg['status']='200';
                                 echo json_encode($msg);
                             }
                            else
                            {
                                $contents2['msg'] = 'No trip available in your zone';
                                $msg['message'] = 'Error';
                                $msg['result'] = $contents2;
                                $msg['status'] = '400';
                                echo json_encode($msg);
                            }
  }       
}
// get trip ended here

//accept Trip
function acceptTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
        $dateTime=$data[0]['dateTime'];
        //$status2="200";
        
        $q1 = "SELECT * FROM trip WHERE id='".$tripId."'";
        $res=mysql_query($q1) or die(mysql_error());
        while($row=mysql_fetch_array($res)) 
        {
        $status=$row['status'];
        }
        if($status=='0')
        {
        $q2="UPDATE trip SET status='200',driver_id='".$driverId."',trip_mode='waiting' where id='".$tripId."'";
        mysql_query($q2) or die(mysql_error());
        $q3= "SELECT `trip`.id,`trip`.customer_id,`trip`.source_address,`trip`.source_latitude,`trip`.source_longitude,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`driver`.company_id,`driver`.vehicle_name,`driver`.vehicle_number,`driver`.image,`taxicompany`.name,`users`.credit_limit,`trip`.device_type,`trip`.device_id as tripId,`trip`.account_type
        From `trip` 
        LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        WHERE `trip`.id ='".$tripId."' ";
        $res3=mysql_query($q3) or die(mysql_error());
        $row1=mysql_fetch_assoc($res3);             
        $gcm_regid=$row1['device_id'];
        $gcm_regid1=$row1['tripId'];
        $contents = array();    
        $contents['username'] = $row1['username']; 
        $contents['source_address'] = $row1['source_address']; 
        $contents['source_latitude'] = $row1['source_latitude']; 
        $contents['source_longitude'] = $row1['source_longitude']; 
        $contents['driverImage'] = TAXI_URL.$row1['image']; 
        $contents['driverId'] = $row1['driver_id']; 
        $contents['mobile'] = $row1['contact_number']; 
        $contents['taxicompany'] = $row1['name']; 
        $contents['vehicalname'] = $row1['vehicle_name']; 
        $contents['vehicle_number'] = $row1['vehicle_number']; 
        $contents['avl_credit'] = $row1['credit_limit']; 
        $contents['device_type'] = $row1['tripId']; 
        $contents['trip_id'] = $row1['id']; 
        //$contents['latitude'] = $latitude;
        //$contents['longitude'] = $longitude; 

        $types=$row1['account_type'];


        if($row1['device_type'] == 'IOS')
        {
            
            $deviceToken = $gcm_regid1;
            $message = array("acceptTrip" => $contents);
            $string = json_encode($message);
            iosDevice($deviceToken, $string, $types);
        }
        else
        {
        $registatoin_ids = array($gcm_regid);
        $message = array("tripaccept" => $contents);
        send_notification($registatoin_ids, $message);
        }
        
        $msg['message']='successfull';
        $msg['result']=$contents;
        $msg['status']='200';
        echo json_encode($msg);
    }   
        else
        {
            $contents['msg'] = 'error';
            $msg['message']='Already Bookked';
            $msg['result']=$contents;
            $msg['status']='100';
            echo json_encode($msg);
        }
    }
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result'][]=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }
}

//Reject Trip
function rejectTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $message=$data[0]['message'];
        $dateTime=$data[0]['dateTime']; 
        $latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
        $status='600';
        $driverId1='0';
        $output = '';
        $q="UPDATE trip SET status='".$status."',rejectMessage='".$message."',driver_id='".$driverId1."' where id='".$tripId."'";
        $res1=mysql_query($q) or die(mysql_error());
        $q3= "SELECT `trip`.customer_id,`users`.id,`trip`.rejectMessage,`users`.device_id From `trip` LEFT JOIN `users` ON `trip`.customer_id=`users`.id WHERE `trip`.id ='".$tripId."' ";     
                $res3=mysql_query($q3) or die(mysql_error());
                $row1=mysql_fetch_assoc($res3);     
                $gcm_regid=$row1['device_id'];
                $contents = array();   
                $contents['tripId'] = $tripId; 
                $contents['driverId'] = $row1['id']; 
                $contents['message'] = $row1['rejectMessage'];
                $registatoin_ids = array($gcm_regid);
                $message = array("tripcancelled" => $contents); 
                send_notification($registatoin_ids, $message); 
                $msg['message']='successfull';
                $msg['result']=$contents;
                $msg['status']='200';
                echo json_encode($msg);
        }   
        else
        {
            $contents['msg'] = 'error';
            $msg['message']='Error';
            $msg['result']=$contents;
            $msg['status']='100';
            echo json_encode($msg);
        }
}

//send message

function sendMessage()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        //print_r($data);
        $driverId=$data[0]['driverId'];
        $tripId=$data[0]['tripId'];     
        $message=$data[0]['message'];
            //$output = '';
            $q="INSERT INTO `driver_sendMessage`(`driver_id`,`message`,`trip_id`)VALUES ('$driverId','$message','$tripId')";
            $res=mysql_query($q) or die(mysql_error());
                $q3= "SELECT `trip`.id,`trip`.customer_id,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number
                From `trip` 
                LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
                LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
                LEFT JOIN `driver_sendMessage` ON `trip`.id=`driver_sendMessage`.trip_id 
                WHERE `trip`.id ='".$tripId."' ";   
                $res3=mysql_query($q3) or die(mysql_error());
                $row1=mysql_fetch_assoc($res3);
                $gcm_regid=$row1['device_id'];
                $contents = array();
                $contents['trip_id'] = $row1['id']; 
                $contents['driverId'] = $row1['driver_id'];
                $contents['message'] = $message;
                $registatoin_ids = array($gcm_regid);
                $message = array("sendmessage" => $contents);
                send_notification($registatoin_ids, $message);
                $contents=array();
                if(mysql_affected_rows() > 0)
                {
                    $id=mysql_insert_id();
                    $contents['id']="$id";                  
                    $msg['message']='Send Message Successfully';
                    $msg['result']=$contents;
                    $msg['status']='200'; 
                    echo json_encode($msg);     
                }
                else
                {
                    $contents['msg']='Error';
                    $msg['message']='Error in Coding';
                    $msg['result']=$contents;
                    $msg['status']='400';
                    echo json_encode($msg);
                }
  }
}

//Customer boarded
function boardedTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {      
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $dateTime=$data[0]['dateTime'];
        $latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
        $q1 = "SELECT * FROM trip WHERE id='".$tripId."'";
        $res=mysql_query($q1) or die(mysql_error());
        $q2="UPDATE trip SET status='202',driver_id='".$driverId."',trip_mode='travel' where id='".$tripId."'";
        mysql_query($q2) or die(mysql_error());
        if($res)
        {
        // $q3= "SELECT `trip`.id,`trip`.customer_id,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`driver`.vehicle_name,`driver`.vehicle_number,`taxicompany`.name,`driver`.image";
        $q3= "SELECT `trip`.id,`trip`.customer_id,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`taxicompany`.name,`driver`.vehicle_name,`driver`.image,`driver`.vehicle_number,`users`.corporate_id,`login`.id,`login`.name as corporateName,`trip`.destination_landmark,`trip`.trip_ammount
        From `trip` 
        LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `users`.corporate_id=`login`.id
        WHERE `trip`.id ='".$tripId."' ";
        $res3=mysql_query($q3) or die(mysql_error());
        $row1=mysql_fetch_assoc($res3);
        $gcm_regid=$row1['device_id'];
        $contents = array();    
        //$contents['message'] = "yes";
        $contents['username'] = $row1['username']; 
        $contents['driverImage'] = TAXI_URL.$row1['image'];
        $contents['mobile'] = $row1['contact_number'];
        $contents['taxicompany'] = $row1['name']; 
        $contents['corporatecompany'] = $row1['corporateName']; 
        $contents['vehicalname'] = $row1['vehicle_name']; 
        $contents['destination'] = $row1['destination_landmark']; 
        $contents['vehicle_number'] = $row1['vehicle_number'];
        //$contents['totalFare'] = $totalFare;
        $contents['tripId'] = $row1['id'];
        $contents['trip_amount'] = $row1['trip_ammount'];
        /*$contents['mobile'] = $row1['contact_number'];
        $contents['taxicompany'] = $row1['name']; 
        $contents['vehicalname'] = $row1['vehicle_name']; 
        $contents['vehicle_number'] = $row1['vehicle_number'];*/
        $registatoin_ids = array($gcm_regid);
        $message = array("borded" => $contents);
        send_notification($registatoin_ids, $message);
        $msg['message']='successfull';
        $msg['result']=$contents;
        $msg['status']='200';
        echo json_encode($msg);
    }   
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result']=$contents;
        $msg['status']='100';
        echo json_encode($msg);
    }
    }
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result'][]=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }
}

// Arrived Trip
function arrivedTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {      
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $dateTime=$data[0]['dateTime'];
        $latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
        $q1 = "SELECT * FROM trip WHERE id='".$tripId."'";
        $res=mysql_query($q1) or die(mysql_error());
        $q2="UPDATE trip SET status='201',driver_id='".$driverId."',trip_mode='waiting' where id='".$tripId."'";
        mysql_query($q2) or die(mysql_error());
        if($res)
        {
        $q3= "SELECT `trip`.id,`trip`.customer_id,`trip`.source_address,`trip`.source_longitude,`trip`.source_latitude,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`driver`.vehicle_name,`driver`.vehicle_number,`driver`.image,`taxicompany`.name,`users`.credit_limit,`login`.id,`login`.name as corporateName,`trip`.destination_landmark,`trip`.trip_ammount
        From `trip`
        LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `users`.corporate_id=`login`.id
        WHERE `trip`.id ='".$tripId."' ";
        $res3=mysql_query($q3) or die(mysql_error());
        $row1=mysql_fetch_assoc($res3);
        $gcm_regid=$row1['device_id'];
        $contents = array();    
        $contents['username'] = $row1['username'];
        $contents['source_address'] = $row1['source_address'];
        $contents['source_longitude'] = $row1['source_longitude'];
        $contents['source_latitude'] = $row1['source_latitude'];
        $contents['driverImage'] = TAXI_URL.$row1['image'];
        $contents['mobile'] = $row1['contact_number'];
        $contents['corporatecompany'] = $row1['corporateName'];
        $contents['taxicompany'] = $row1['name']; 
        $contents['vehicalname'] = $row1['vehicle_name']; 
        $contents['vehicle_number'] = $row1['vehicle_number'];
        $contents['destination'] = $row1['destination_landmark'];
        $contents['amount'] = $row1['trip_ammount'];
        $contents['latitude'] = $latitude;
        $contents['longitude'] = $longitude;
        $registatoin_ids = array($gcm_regid);
        $message = array("triparrived" => $contents);
        send_notification($registatoin_ids, $message);
        $msg['message']='successfull';
        $msg['result']=$contents;
        $msg['status']='200';
        echo json_encode($msg);
    }   
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result']=$contents;
        $msg['status']='100';
        echo json_encode($msg);
    }
    }
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result'][]=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }   
}

//end trip

function endTrip()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {     
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $dateTime=$data[0]['dateTime'];
        $latitude=$data[0]['latitude'];
        $longitude=$data[0]['longitude'];
        //$totalFare=$data[0]['totalFare'];
        //$status2="300";       
        $q1 = "SELECT * FROM trip WHERE id='".$driverId."'";
        $res=mysql_query($q1) or die(mysql_error());
         $q2="UPDATE trip SET status='500',trip_mode='complete' where id='".$tripId."'";
        mysql_query($q2) or die(mysql_error());
        $q3= "SELECT `trip`.id,`trip`.customer_id,`users`.device_id,`trip`.driver_id,`driver`.username,`driver`.contact_number,`taxicompany`.name,`driver`.vehicle_name,`driver`.image,`driver`.vehicle_number,`users`.corporate_id,`login`.id,`login`.name as corporateName,`trip`.destination_landmark,`trip`.trip_ammount
        From `trip` 
        LEFT JOIN `users` ON `trip`.customer_id=`users`.id 
        LEFT JOIN `driver` ON `trip`.driver_id=`driver`.id 
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `users`.corporate_id=`login`.id
        WHERE `trip`.id ='".$tripId."' ";
        $res3=mysql_query($q3) or die(mysql_error());
        $row1=mysql_fetch_assoc($res3);

        $str90="select * from users where id='".$row1['customer_id']."'";
        $res90=mysql_query($str90);
        $row90=mysql_fetch_array($res90);
        $row90['credit_limit'];
        $row90['id'];
        // if($row90['credit_limit'] < $row1['trip_ammount'])
        // {
        //  $contents['msg'] = 'error';
        //  $msg['message']='Customer Dont Have sufficient Balance';
        //  $msg['result']=$contents;
        //  $msg['status']='400';
        //  echo json_encode($msg);
        // }
        $finalAmount=$row90['credit_limit']-$row1['trip_ammount'];
        if($finalAmount<0)
        {
        $str91="update users set credit_limit='".$row90['credit_limit']."' where id='".$row90['id']."'";
        $res91=mysql_query($str91);
        }
        else
        {
        $str91="update users set credit_limit='".$finalAmount."' where id='".$row90['id']."'";
        $res91=mysql_query($str91);
        }

        $gcm_regid=$row1['device_id'];
        $contents = array();    
        $contents['username'] = $row1['username']; 
        $contents['driverImage'] = TAXI_URL.$row1['image'];
        $contents['mobile'] = $row1['contact_number'];
        $contents['taxicompany'] = $row1['name']; 
        $contents['corporatecompany'] = $row1['corporateName']; 
        $contents['vehicalname'] = $row1['vehicle_name']; 
        $contents['destination'] = $row1['destination_landmark']; 
        $contents['vehicle_number'] = $row1['vehicle_number'];
        $contents['trip_amount'] = $row1['trip_ammount'];
        $contents['tripId'] = $row1['id'];
        //$contents['canceltaxirequest'] = $row1['rejectRessonTrip'];
     //    $registatoin_ids = array($gcm_regid);
        // $message = array("tripend" => $contents);
     //    send_notification($registatoin_ids, $message);
        if($res)
        {           
            //  $contents = array();      
            //  $q3= "SELECT * FROM trip WHERE id ='".$tripId."'";
                // $res3=mysql_query($q3) or die(mysql_error());
                // $row1=mysql_fetch_assoc($res3);
                // $contents['customerId'] = $row1['id']; 
                $msg['message']='Trip Ended';
                //$msg['result']=$contents;
                $msg['status']='200';
                echo json_encode($msg);                 
        }   
        else
        {
            $contents['msg'] = 'error';
            $msg['message']='Something Wrong';
            $msg['result']=$contents;
            $msg['status']='400';
            echo json_encode($msg);
        }
    }
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='No Data Found';
        $msg['result'][]=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }
}


//Rating
function rateing()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];     
        $rateing=$data[0]['rateing'];

        $status="";
        if ($rateing<=2) {
            # code...
            $status='pending';
        }

       // $q="INSERT INTO `driver_rateing`(`customer_id`,`rateing`)VALUES ('$customer_id','$rateing')";
        $q="update trip set driver_id='".$driverId."',driver_rateing='".$rateing."',complain_status='".$status."' where id='".$tripId."'";      
        $res=mysql_query($q) or die(mysql_error());
        $contents=array();
        if(mysql_affected_rows() > 0)
        {
            //$id=mysql_insert_id();
            $contents['id']="$id";      
            $msg['message']='Rating Inserted';
            //$msg['result']=$contents;
            $msg['status']='200'; 
            echo json_encode($msg);     
        }
        else
        {
            $contents['msg']='Error';
            $msg['message']='Error in Coding';
            $msg['result']=$contents;
            $msg['status']='400';
            echo json_encode($msg);
        }
     }
}

//AnonymousReport
function anonymousReport()
{
  $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $image=$data[0]['image'];
        $reportDiscription=$data[0]['reportDiscription'];       
        $latitude=$data[0]['latitude']; 
        $longitude=$data[0]['longitude'];
        $dateTime=$data[0]['dateTime'];
        $driverId=$data[0]['driverId'];
    $q="INSERT INTO `driver_anonymousReport`(`image`, `reportDiscription`, `latitude`,`longitude`,`dateTime`,`driver_id`)VALUES ('$image','$reportDiscription','$latitude','$longitude','$dateTime','$driverId')";
    $res=mysql_query($q) or die(mysql_error());
    $contents=array();
    if(mysql_affected_rows() > 0)
    {
        $id=mysql_insert_id();
        $contents['id']="$id";      
        $msg['message']='Data Insert';
        $msg['result']=$contents;
        $msg['status']='200';  
        echo json_encode($msg);     
    }
    else
    {
        $contents['msg']='Error';
        $msg['message']='Error in Coding';
        $msg['result']=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }
  }
}

// news
function news()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $driverId=$data[0]['driverId'];     
        // $latitude=$data[0]['latitude']   ;
        // $longitude=$data[0]['longitude'];
        $q = "SELECT * FROM news WHERE  driver_id = '".$driverId."' ";
            //$q1="UPDATE `adddriver` SET latitude='$latitude',longitude='$longitude' where username='".$username."'";
            $res=mysql_query($q) or die(mysql_error());
           // $num=mysql_num_rows($res);
            $contents = array();      
            if(mysql_affected_rows()>0)
                {   
                while($row=mysql_fetch_array($res))
                {
                $contents['id'] = $row["id"];           
                //$contents['name'] = $row["name"];
                $contents['title'] = $row["title"];
                $contents['discription'] = $row["discription"];
                $contents['newsImage'] = MAIN_URL.$row['newsImage'];
                $pp[]=$contents;
                }
                $msg['message']='News';
                $msg['result']=$pp;
                $msg['status']='200';
                echo json_encode($msg);
                }
            else
                {
                $contents['msg'] = 'Ok';
                $msg['message']='No News  ';
                $msg['result']=$contents;
                $msg['status']='400';
                echo json_encode($msg);
                }
    }   
}

// Trip History
function tripHistory()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
         $driverId=$data[0]['driverId'];
         if(!empty($data[0]['fromDate']) && !empty($data[0]['toDate']))
         {
         $fromDate=$data[0]['fromDate'].' '.'00:00:00';
         $toDate=$data[0]['toDate'].' '.'23:59:59';
         $fdate = " and tripdatetime >='".$fromDate."' AND tripdatetime <='".$toDate."'";
         }
         else{

            $fdate = '';
         }
         
         $contents = array(); 
         $thang = array();
         $month=array();
         $str="select DISTINCT MONTH(tripdatetime) as month, YEAR(tripdatetime) as year  from `trip` where driver_id = '".$driverId."' $fdate ";
         $res=mysql_query($str) or die(mysql_error());
         if(mysql_num_rows($res) > 0)
         {
            while($row=mysql_fetch_array($res))
            {
            $str1 = "SELECT `trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_country,`trip`.streetnumber,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.tripdatetime,`trip`.trip_type,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_zip,`trip`.destination_landmark,`trip`.destination_country,`users`.name,`users`.image,`trip`.trip_ammount,`trip`.trip_distance,`trip`.travelTime,`trip`.customer_rating,`trip`.driver_rateing FROM `trip` 
                LEFT JOIN `users` ON `trip`.customer_id=`users`.id
                where MONTH(`tripdatetime`) = '".$row['month']."' AND YEAR(`tripdatetime`) = '".$row['year']."' AND driver_id = '".$driverId."' $fdate ORDER BY id desc";
                $res1=mysql_query($str1) or die(mysql_error());
                while($row1=mysql_fetch_array($res1))
                {
                    $contents['id']=$row1['id'];
                    $contents['source_address']=$row1['source_address'].','.$row1['source_city'].','.$row1['streetnumber'].','.$row1['source_country'].','.$row1['source_zip'];
                    $contents['source_latitude']=$row1['source_latitude'];
                    $contents['source_longitude']=$row1['source_longitude'];
                     $contents['source_landmark']=$row1['source_landmark'];
                     $contents['destination_landmark']=$row1['destination_landmark'];
                    //$contents['source_country']=$row1['source_country'];
                   // $contents['streetnumber']=$row1['streetnumber'];
                    $contents['tripdatetime']=$row1['tripdatetime'];
                    $contents['trip_type']=$row1['trip_type'];
                    $contents['destination_address']=$row1['destination_address'].','.$row1['destination_city'].','.$row1['destination_state'].','.$row1['destination_country'].','.$row1['destination_zip'];
                    $contents['destination_latitude']=$row1['destination_latitude'];
                    $contents['destination_longitude']=$row1['destination_longitude'];
                    $contents['customer_rating']=$row1['customer_rating'];
                    $contents['driver_rateing']=$row1['driver_rateing'];
                    $contents['rateing']=$row1['rateing'];
                    $contents['userName']=$row1['name'];
                    $contents['userImage']= MAIN_URL.$row1['image'];
                    $thang[] = $contents;
                }                   
                    if($row['month']=="1") {   $mm='JANUARY'.' '.$row['year']; }
                    elseif($row['month'] =="2") {   $mm ='FEBUARY'.' '.$row['year']; }  
                    elseif($row['month']=="3")  {   $mm ='MARCH'.' '.$row['year']; }    
                    elseif($row['month']=="4")  {   $mm ='APRIL'.' '.$row['year']; }    
                    elseif($row['month']=="5")  {   $mm ='MAY'.' '.$row['year']; }  
                    elseif($row['month']=="6")  {   $mm  ='JUNE'.' '.$row['year']; }    
                    elseif($row['month']=="7")  {   $mm ='JULY'.' '.$row['year']; } 
                    elseif($row['month']=="8")  {   $mm ='AUGUST'.' '.$row['year']; }   
                    elseif($row['month']=="9")  {   $mm ='SEPTEMBER'.' '.$row['year']; }    
                    elseif($row['month']=="10") {   $mm ='OCTOBER'.' '.$row['year']; }  
                    elseif($row['month']=="11") {   $mm ='NOVEMBER'.' '.$row['year']; } 
                    elseif($row['month']=="12") {   $mm ='DECEMBER'.' '.$row['year']; }
                    $pp[$mm] =$thang;
                    //print_r($pp);
                    $thang = '';
                    $contents = '';
                    $month['name']=$mm;
                    //print_r($month);
                    $aa[] = $month;
                    //print_r($aa);
                    }
                    $msg['message']='Successfully';
                    $msg['month']=$aa;
                    $msg['result'][]=$pp;
                    $msg['status']='200';
                    echo json_encode($msg);
                     }
                     else
                    {
                    $msg['message']='No Data Found';
                    //$msg['result'][]='No Data Found';
                    $msg['status']='100';
                    echo json_encode($msg);
                    }
                 }
                else
                  {         

                    $msg['message'] = 'Error';
                    $msg['result'][] = 'please send request';
                    $msg['status'] = '400';
                    echo json_encode($msg);
                  }
            }

//location update

function locationUpdate()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $longitude=$data[0]['longitude'];
        $latitude=$data[0]['latitude']; 
        $driver_id=$data[0]['driverId'];
        $date=$data[0]['date'];     
     //   $output = '';
    $q="INSERT INTO `trip_log`(`longitude`,`latitude`,`driver_id`,`date`) VALUES ('$longitude','$latitude','$driver_id','$date')";
    $res=mysql_query($q) or die(mysql_error());
    $id=mysql_insert_id() or die(mysql_error());
    $q2="select * from trip where driver_id='".$driver_id."' ORDER BY id desc";
    $res1=mysql_query($q2) or die(mysql_error());
    $row1=mysql_fetch_array($res1);
     $row1['status'];
    $row1['id'];
    $q1="UPDATE `trip_log` SET longitude='".$longitude."',latitude='".$latitude."',driver_id='".$driver_id."',date='".$date."',status='".$row1['status']."' where id='".$id."' ";
    $res2=mysql_query($q1) or die(mysql_error());
    $contents=array();
    // if(mysql_affected_rows() > 0)
    // { 
        $q4="select * from trip_log where driver_id='".$driver_id."' and  status ='500'";
        $res4=mysql_query($q4) or die(mysql_error());
        $row4=mysql_fetch_assoc($res4);
        $row4['status'];
        if($row4['status']=='500')
        {
            $q5="DELETE FROM `trip_log` WHERE `driver_id` = '".$driver_id."' AND `status` IN ( 200, 500, 202, 209 )";
            $res5=mysql_query($q5) or die(mysql_error());
        }
        $contents['longitude']=$longitude;
        $contents['latitude']=$latitude;
        $contents['driver_id']=$driver_id;
        $contents['date']=$date;
         // $q1="UPDATE `trip_log` SET longitude='".$longitude."',latitude='".$latitude."',driver_id='".$driver_id."',date='".$date."',status='".$row1['status']."' ";
      //   $res2=mysql_query($q1) or die(mysql_error());
        $msg['message']='Data Insert';
        $msg['result']=$contents;
        $msg['status']='200';  
        echo json_encode($msg);     
    // }
    // else
    // {
    //  $contents['msg']='Error';
    //  $msg['message']='Error in Coding';
    //  $msg['result']=$contents;
    //  $msg['status']='400';
    //  echo json_encode($msg);
    // }
  }
}

function PayPayment()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {      
        $driverId=$data[0]['driverId'];     
        $tripId=$data[0]['tripId'];
        $distance=$data[0]['distance'];     
        //$totalFare=$data[0]['amount'];        
        $payment_mode=$data[0]['payment_mode'];     
        $start_time=$data[0]['start_time'];     
        $waiting_time=$data[0]['waiting_time'];     
        $end_time=$data[0]['end_time'];     
        $add_on=date("y-m-d H:m:s");    
        $str1="SELECT `trip`.customer_id,`users`.credit_limit,`trip`.driver_id,`users`.account_type,`driver`.trip_fare,`trip`.trip_ammount,`users`.id from `trip`
         LEFT JOIN `users` ON `trip`.customer_id = `users`.id
         LEFT JOIN `driver` ON `trip`.driver_id = `driver`.id
          where `trip`.id='".$tripId."'";   
        $res1=mysql_query($str1);
        $row1=mysql_fetch_assoc($res1);
        $credit_limit=$row1['credit_limit']-$row1['trip_ammount'];
        if($credit_limit<0)
        {
        $str91="update users set credit_limit='".$row1['credit_limit']."' where id='".$row1['id']."'";
        $res91=mysql_query($str91);
        }
        else
        {
        $str91="update users set credit_limit='".$credit_limit."' where id='".$row1['id']."'";
        $res91=mysql_query($str91);
        }
        $customer_id=$row1['customer_id'];
        $account_type=$row1['account_type'];
        $tripAmount=$row1['trip_ammount'];
        $str55="select * from account where trip_id='".$tripId."'";
        $res55=mysql_query($str55);
        $num=mysql_num_rows($res55);
        if($num)
        {
            $contents['msg'] = 'error';
            $msg['message']='Already Paid';
            //$msg['result'][]=$contents;
            $msg['status']='400';
            echo json_encode($msg);
        }
        else
        {
        $str="insert into account (`trip_id`,`driver_id`,`payment_mode`,`payment_amount`,`user_type_id`,`add_on`,`customer_id`,`start_time`,`waiting_time`,`end_time`) Values ('$tripId','$driverId','$payment_mode','$tripAmount','$account_type','$add_on','$customer_id','$start_time','$waiting_time','$end_time')";
        $res=mysql_query($str);        
        $q55="UPDATE `users` SET credit_limit='$credit_limit' where id='$customer_id'";
        $res55=mysql_query($q55) or die(mysql_error());
        //$row=mysql_fetch_assoc($res);
        //$gcm_regid=$row1['device_id'];
        //$contents = array();  
        //$contents['avl_credit'] = $row1['credit_limit'];
        //$contents['fare'] = $tripAmount;      
        //$registatoin_ids = array($gcm_regid);
        //$message = array("triparrived" => $contents);
        //send_notification($registatoin_ids, $message);
        $msg['message']='successfull';
        //$msg['result']=$contents;
        $msg['status']='200';
        echo json_encode($msg);
        }
    }   
    else
    {
        $contents['msg'] = 'error';
        $msg['message']='Error';
        $msg['result'][]=$contents;
        $msg['status']='400';
        echo json_encode($msg);
    }
}

function corporateAccount()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
         $driverId=$data[0]['driverId'];
         // if(!empty($data[0]['fromDate']) && !empty($data[0]['toDate']))
         // {
         // $fromDate=$data[0]['fromDate'].' '.'00:00:00';
         // $toDate=$data[0]['toDate'].' '.'23:59:59';
         // $fdate = " and tripdatetime >='".$fromDate."' AND tripdatetime <='".$toDate."'";
         // }
         // else{

         //     $fdate = '';
         // }
         
         $contents = array(); 
        // $thang = array();
         $month=array();
         $str="select DISTINCT MONTH(tripdatetime) as month, YEAR(tripdatetime) as year  from `trip` where driver_id = '".$driverId."'";
         $res=mysql_query($str) or die(mysql_error());
         if(mysql_num_rows($res) > 0)
         {
            while($row=mysql_fetch_array($res))
            {
            $str1 = "SELECT `trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_country,`trip`.streetnumber,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.tripdatetime,`trip`.trip_type,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_zip,`trip`.destination_landmark,`trip`.destination_country,`users`.name,`users`.image,`trip`.trip_ammount,`trip`.trip_distance,`trip`.travelTime,`trip`.customer_rating,`trip`.driver_rateing,`trip`.account_type FROM `trip` 
                LEFT JOIN `users` ON `trip`.customer_id=`users`.id
                where MONTH(`tripdatetime`) = '".$row['month']."' AND YEAR(`tripdatetime`) = '".$row['year']."' AND driver_id = '".$driverId."' AND `trip`.account_type='99' ORDER BY id desc";
                $res1=mysql_query($str1) or die(mysql_error());

                $nj = '0';

                while($row1=mysql_fetch_array($res1))
                {
                    $nj += $row1['trip_ammount'];
                    $contents['trip']=$row1['trip_ammount'];
                    $thang[] = $contents;                   
                }
                $than['result'] = $thang;
                $than['amount']  = $nj;
                //$msg['result1']=
                //echo array_sum($thang);           
                    if($row['month']=="1") {   $mm='JANUARY'.' '.$row['year']; }
                    elseif($row['month'] =="2") {   $mm ='FEBUARY'.' '.$row['year']; }  
                    elseif($row['month']=="3")  {   $mm ='MARCH'.' '.$row['year']; }    
                    elseif($row['month']=="4")  {   $mm ='APRIL'.' '.$row['year']; }    
                    elseif($row['month']=="5")  {   $mm ='MAY'.' '.$row['year']; }  
                    elseif($row['month']=="6")  {   $mm  ='JUNE'.' '.$row['year']; }    
                    elseif($row['month']=="7")  {   $mm ='JULY'.' '.$row['year']; } 
                    elseif($row['month']=="8")  {   $mm ='AUGUST'.' '.$row['year']; }   
                    elseif($row['month']=="9")  {   $mm ='SEPTEMBER'.' '.$row['year']; }    
                    elseif($row['month']=="10") {   $mm ='OCTOBER'.' '.$row['year']; }  
                    elseif($row['month']=="11") {   $mm ='NOVEMBER'.' '.$row['year']; } 
                    elseif($row['month']=="12") {   $mm ='DECEMBER'.' '.$row['year']; }
                    $pp[$mm] =$than;

                    //print_r($pp);
                    $thang = '';
                    $contents = '';
                    $month['name']=$mm;
                    //print_r($month);
                    $aa[] = $month;
                    //print_r($aa);
                    }
                    $msg['message']='Successfully';
                    $msg['month']=$aa;
                    
                    $msg['result'][]=$pp;
                    $msg['status']='200';
                    echo json_encode($msg);
                     }
                     else
                    {
                    $msg['message']='No Data Found';
                    //$msg['result'][]='No Data Found';
                    $msg['status']='100';
                    echo json_encode($msg);
                    }
                 }
                else
                  {
                    $msg['message'] = 'Error';
                    $msg['result'][] = 'please send request';
                    $msg['status'] = '400';
                    echo json_encode($msg);
                  }
}

function userAccount()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
         $driverId=$data[0]['driverId'];
         if(!empty($data[0]['fromDate']) && !empty($data[0]['toDate']))
         {
         $fromDate=$data[0]['fromDate'].' '.'00:00:00';
         $toDate=$data[0]['toDate'].' '.'23:59:59';
         $fdate = " and tripdatetime >='".$fromDate."' AND tripdatetime <='".$toDate."'";
         }
         else{

            $fdate = '';
         }
         
         $contents = array(); 
         //$thang = array();
         $month=array();
         $str="select DISTINCT MONTH(tripdatetime) as month, YEAR(tripdatetime) as year  from `trip` where driver_id = '".$driverId."' $fdate ";
         $res=mysql_query($str) or die(mysql_error());
         if(mysql_num_rows($res) > 0)
         {
            while($row=mysql_fetch_array($res))
            {
            $str1 = "SELECT `trip`.id,`trip`.source_address,`trip`.source_city,`trip`.source_state,`trip`.source_landmark,`trip`.source_country,`trip`.streetnumber,`trip`.source_latitude,`trip`.source_longitude,`trip`.destination_latitude,`trip`.destination_longitude,`trip`.tripdatetime,`trip`.trip_type,`trip`.destination_address,`trip`.destination_city,`trip`.destination_state,`trip`.destination_zip,`trip`.destination_landmark,`trip`.destination_country,`users`.name,`users`.image,`trip`.trip_ammount,`trip`.trip_distance,`trip`.travelTime,`trip`.customer_rating,`trip`.driver_rateing,`trip`.account_type FROM `trip` 
                LEFT JOIN `users` ON `trip`.customer_id=`users`.id
                where MONTH(`tripdatetime`) = '".$row['month']."' AND YEAR(`tripdatetime`) = '".$row['year']."' AND driver_id = '".$driverId."' AND `trip`.account_type='7' $fdate ORDER BY id desc";
                $res1=mysql_query($str1) or die(mysql_error());
                while($row1=mysql_fetch_array($res1))
                {
                    $nj += $row1['trip_ammount'];
                   // $contents['userName']=$row1['name'];
                   
                    $than= $nj;
                }   
                //$than='paid';

                  $thang=$than;
                 // print_r($thang);
                //$thang['amount']  = $nj;              
                    if($row['month']=="1") {   $mm='JANUARY'.' '.$row['year']; }
                    elseif($row['month'] =="2") {   $mm ='FEBUARY'.' '.$row['year']; }  
                    elseif($row['month']=="3")  {   $mm ='MARCH'.' '.$row['year']; }    
                    elseif($row['month']=="4")  {   $mm ='APRIL'.' '.$row['year']; }    
                    elseif($row['month']=="5")  {   $mm ='MAY'.' '.$row['year']; }  
                    elseif($row['month']=="6")  {   $mm  ='JUNE'.' '.$row['year']; }    
                    elseif($row['month']=="7")  {   $mm ='JULY'.' '.$row['year']; } 
                    elseif($row['month']=="8")  {   $mm ='AUGUST'.' '.$row['year']; }   
                    elseif($row['month']=="9")  {   $mm ='SEPTEMBER'.' '.$row['year']; }    
                    elseif($row['month']=="10") {   $mm ='OCTOBER'.' '.$row['year']; }  
                    elseif($row['month']=="11") {   $mm ='NOVEMBER'.' '.$row['year']; } 
                    elseif($row['month']=="12") {   $mm ='DECEMBER'.' '.$row['year']; }
                    $pp['type']= 'paid';
                    $pp[$mm] =$thang;
                    //print_r($pp);
                    $thang = '';
                    $contents = '';
                    $month['name']=$mm;
                    //print_r($month);
                    $aa[] = $month;
                    //print_r($aa);
                    }
                    $msg['message']='Successfully';
                    $msg['month']=$aa;
                    //$msg['type']='paid';
                    $msg['result'][]=$pp;
                    $msg['status']='200';
                    echo json_encode($msg);
                     }
                     else
                    {
                    $msg['message']='No Data Found';
                    //$msg['result'][]='No Data Found';
                    $msg['status']='100';
                    echo json_encode($msg);
                    }
                 }
                else
                  {         

                    $msg['message'] = 'Error';
                    $msg['result'][] = 'please send request';
                    $msg['status'] = '400';
                    echo json_encode($msg);
                  }
            }
            

function getAdminNotification()
{
    $contents=array();
    //echo "hello";
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    { 
        $DriverId=$data[0]['DriverId'];
        //$str="select * from send_message GROUP BY driver_name ORDER BY ID DESC";
        //$str1="select DISTINCT corporate_user, from send_message ";
        // $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
        //      LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id GROUP BY corporate_user ORDER BY messageId DESC";
        // $str="SELECT `send_message`.corporate_user,`users`.id,`users`.device_id,`send_message`.driver_name,`send_message`.message,`send_message`.id as messageId FROM `send_message`
           //   LEFT JOIN `users` ON `send_message`.corporate_user=`users`.id "; 
        $str="SELECT `send_message`.driver_name,`send_message`.message,`driver`.id,`driver`.name,`send_message`.heading,`send_message`.added_on FROM `send_message`
              LEFT JOIN `driver` ON `send_message`.driver_name=`driver`.id where `driver`.id='$DriverId'";
        $res=mysql_query($str);
        if(mysql_affected_rows()>0)
        {
            while($row=mysql_fetch_array($res))
            {
                $contents['title']=$row['heading'];             
                $contents['adminmessage']=base64_decode($row['message']);               
                $contents['datetime']=$row['added_on'];             
                $thang[]=$contents;         
            }
            $msg['message']='successfull';
            $msg['result']=$thang;
            $msg['status']='200';
            echo json_encode($msg);
        }   
        else
        {
            $contents['msg'] = 'Sorry no data found';
            $msg['message']='Error';
            $msg['result'][]=$contents;
            $msg['status']='400';
            echo json_encode($msg);
        }
    }
}

function zoneDriverData()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        $driverId=$data[0]['driverId'];
        $str="SELECT `driver`.id,`driver`.company_id,`taxicompany`.zone_area_id_sess,`taxicompany`.id as taxicompanyId,`zone_cordinater`.zone_type,`zone_cordinater`.cordinated,`zone_cordinater`.zone_area_id FROM `driver`
            LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.id
            LEFT JOIN `zone_cordinater` ON `taxicompany`.zone_area_id_sess=`zone_cordinater`.zone_area_id where `driver`.id='".$driverId."'";
         $res=mysql_query($str);
        while($row=mysql_fetch_array($res))
        {           
            $contents['driverId']=$row['id'];               
            $contents['zone_type']=$row['zone_type'];               
            $contents['cordinated']=$row['cordinated'];
            //$contents['zone_type']=$row['zone_type'];
            $thang[]=$contents;
        }
            $msg['message']='successfull';
            $msg['result']=$thang;
            $msg['status']='200';
            echo json_encode($msg);
    }

}

//This function for driverCondition check is in polygon or not

function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
        {
          $i = $j = $c = 0;
          for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++)
          {
            if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
            ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
                $c = !$c;
          }
          return $c;
        }
        
function driverCondition()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
    $driver_id = $data[0]['driverId']; // x-coordinate of the point to test
    $longitude_x = $data[0]['longitude']; // x-coordinate of the point to test 22.718092
    $latitude_y = $data[0]['latitude']; // y-coordinate of the point to test 75.857686

    $str="SELECT `driver`.id,`driver`.added_by,`taxicompany`.web_user_id,`taxicompany`.zone_area_id_sess,`zone_cordinater`.zone_area_id,`zone_cordinater`.cordinated,`zone_cordinater`.zone_type FROM `driver`
              LEFT JOIN `taxicompany` ON `driver`.added_by=`taxicompany`.web_user_id
              LEFT JOIN `zone_cordinater` ON `taxicompany`.zone_area_id_sess=`zone_cordinater`.zone_area_id where `driver`.id='".$driver_id."'";
    $res=mysql_query($str);
    while($row = mysql_fetch_object($res))
    {
        $cordinated = $row->cordinated;     
        $cordinate_title = $row->zone_type;       
        $cordi  = $cordinated;
        $all_cordinate = explode(",", $cordi);
        //echo '<pre>';print_r($all_cordinate); 
        $intGetCount=count($all_cordinate);
        //print_r($intGetCount);
        $strAddLatitudeValue="";
        for($i=0;$i<$intGetCount;$i++)
        {
          if($i%2==0)
          {
            if($i == 0)
            {
              $temp = str_replace('(','',$all_cordinate[$i]);
              $latitude = $latitude . $temp;
            }else{
              $tempc = str_replace("(",", ",$all_cordinate[$i]);
              $latitude = $latitude . $tempc;
            }
          }
          else
          {
              $tempd = str_replace(")",", ",$all_cordinate[$i]);
              $longitude = $longitude . $tempd;
          }
        }

        $vertices_x1 = array($latitude); // x-coordinates of the vertices of the polygon
        for($i=0; $i<count($vertices_x1); $i++)
        {
        $a = explode(',', $vertices_x1[$i]);
        }

        $vertices_x = $a;

        $vertices_y1 = explode(",", $longitude); // y-coordinates of the vertices of the polygon
        foreach ($vertices_y1 as  $value_Y)
        {
          $vertices_y[] = $value_Y;
        }
        $points_polygon = count($vertices_x);
         
        if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y))
        {
          //echo "Is in polygon!"."</br>";
            $msg['message']='successfull';
            $msg['result']="Is in polygon!";
            $msg['status']='200';
            echo json_encode($msg);
        }
        else
        {
            $contents['msg'] = 'Is not in polygon';
            $msg['message']='Error';
            $msg['result'][]=$contents;
            $msg['status']='400';
            echo json_encode($msg);
        } 
         
        // function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
        // {
        //   $i = $j = $c = 0;
        //   for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++)
        //   {
        //     if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
        //     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
        //         $c = !$c;
        //   }
        //   return $c;
        // }
    }
 }
}

function temporarly()
{
    $data=array_merge($_POST,json_decode(file_get_contents('php://input'),true));
    if(!empty($data['0']))
    {
        //$driverId=$data[0]['driverId'];
        $str="select * from trip_log where id >=129414 and id <=129475 ";
        $res=mysql_query($str);
        while($row=mysql_fetch_array($res))
        {           
            $contents['lat']=$row['latitude'];              
            $contents['lon']=$row['longitude'];             
            //$contents['zone_type']=$row['zone_type'];
            $thang[]=$contents;
        }
            $msg['message']='successfull';
            $msg['result']=$thang;
            $msg['status']='200';
            echo json_encode($msg);
    }
}