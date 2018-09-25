<?php

//Common functions
// For Polygon check
// for send notification on android phone
function send_notification($registatoin_ids, $message) {

    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
        'registration_ids' => $registatoin_ids,
        'data' => $message,
    );

    $headers = array(
        'Authorization: key = AIzaSyDUg7BnaTA5dQTVgtWoYJh4IDGKY9tBg64',
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

/** Fro Point in polygon section Start * */
$pointLocation = new pointLocation();

class pointLocation {

    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices

    

    function pointLocation() {
        
    }

    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        // Check if the point sits exactly on a vertex
        /* if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
          return "vertex";
          } */

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);

        for ($i = 1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i - 1];
            $vertex2 = $vertices[$i];
            /* if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
              return "boundary";
              } */
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                /* if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                  return "boundary";
                  } */
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        //echo $intersections;
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    function pointOnVertex($point, $vertices) {
        foreach ($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

}

/** Fro Point in polygon section End * */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function submitNews() {
    $title = $_REQUEST['title'];
    $discription = $_REQUEST['discription'];
    $addedon = date('Y-m-d');

    function GetImageExtension($imagetype) {
        if (empty($imagetype))
            return false;
        switch ($imagetype) {
            case 'image/bmp': return '.bmp';
            case 'image/gif': return '.gif';
            case 'image/jpeg': return '.jpg';
            case 'image/png': return '.png';
            default: return false;
        }
    }

    $file_name = $_FILES["file"]["name"];
    $temp_name = $_FILES["file"]["tmp_name"];
    $imgtype = $_FILES["file"]["type"];
    $ext = GetImageExtension($imgtype);
    $imagename = date("d-m-Y") . "-" . time() . $ext;
    $target_path = "news/" . $imagename;
    move_uploaded_file($temp_name, $target_path);

    /*
      $getTaxicom = "SELECT * FROM login WHERE added_by = '".$_SESSION['uid']."'";
      $rowDatacom = mysql_query($getTaxicom);
      while ($data = mysql_fetch_array($rowDatacom)) {
      $getTaxiId[] = $data['id'];
      }
      $taxiIDs = implode(",", $getTaxiId);
      $getDri = "SELECT id FROM driver WHERE company_id IN ($taxiIDs)";
      $resDri = mysql_query($getDri);
      while ($dataDri = mysql_fetch_array($resDri)) {
      $getDriId[] = $dataDri['id'];

      }
      $driIDs = implode(",", $getDriId);
      $length = count(($getDriId));

      if(($length > 1)){
      for($i = 0; $i < $length; $i++) {
      $getDriId[$i];
      $str="insert into news (`title`,`discription`,`newsImage`,`added_on`,`added_by`,`driver_id`) values ('$title','$discription','$target_path','$addedon','".$_SESSION['uid']."','".$getDriId[$i]."')";
      $res=mysql_query($str) or die(mysql_error());

      }
      }else{
      $str="insert into news (`title`,`discription`,`newsImage`,`added_on`,`added_by`,`driver_id`) values ('$title','$discription','$target_path','$addedon','".$_SESSION['uid']."','$driIDs')";
      $res=mysql_query($str) or die(mysql_error());
      } */

    $str = "insert into news (`title`,`discription`,`newsImage`,`added_on`,`added_by`) values ('$title','$discription','$target_path','$addedon','" . $_SESSION['uid'] . "')";
    $res = mysql_query($str) or die(mysql_error());

    if ($res) {
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Message Inserted Successfully</div>';
    } else {
        echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error in Coding</div>';
    }
}

function message() {

    global $objConnect;
    global $objCommon;
    $type = $_REQUEST['sendMessage'];
    $added_on = date('Y-m-d H:i:s');
    $driverName = $_REQUEST['selDriverName'];

    $corpName = $_REQUEST['selCorName'];
    $taxiName = $_REQUEST['selCentralName'];
    $corpUser = $_REQUEST['selUsersName'];
    $added_by = $_SESSION['uid'];
    $messageHeading = $_REQUEST['txtHeading'];
    $optional_check = $_REQUEST['getOptional'];
    $sentMessage = base64_encode($_REQUEST['sentMessage']);
    if ($_REQUEST['searchAddress'] == '') {
        $latitude = '23.77717633993925';
        $longitude = '-102.51548767089844';
        $searchAddress = 'Mexico City';
    } else {
        $latitude = $_REQUEST['latitude'];
        $longitude = $_REQUEST['longitude'];
        $searchAddress = $_REQUEST['searchAddress'];
    }

    if ($driverName == "" and $corpName == "" and $taxiName == "" and $corpUser == "") {
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Por favor, seleccione al menos una</div>';
    } else {

        // For driver add
        if ($driverName == '0') {
            $str = "insert into send_message (`driver_name`,`driver_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$driverName','all','$messageHeading','$sentMessage','all','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
            $last_id = mysql_insert_id();
        } else {
            $getNotify = mysql_fetch_array(mysql_query("select device_id from driver where id ='" . $driverName . "'"));
            $deviceId = $getNotify['device_id'];

            $registatoin_ids = array($deviceId);
            $message = array("administratorMessage" => "New message from zone administrator");
            send_notification($registatoin_ids, $message);

            $str = "insert into send_message (`driver_name`,`driver_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$driverName','particular','$messageHeading','$sentMessage','particular','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
            $last_id = mysql_insert_id();
        }

        // For corporation company name add
        if ($corpName == '0') {
            $str = "insert into send_message (`corporation_name`,`crop_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$corpName','all','$messageHeading','$sentMessage','all','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message (`corporation_name`,`crop_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$corpName','particular','$messageHeading','$sentMessage','particular','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        }

        // For taxicompany company name add
        if ($taxiName == '0') {
            $str = "insert into send_message (`company_name`,`central_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$taxiName','all','$messageHeading','$sentMessage','all','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message (`company_name`,`central_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$taxiName','particular','$messageHeading','$sentMessage','particular','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        }

        // For corporation user add
        if ($corpUser == '0') {
            $str = "insert into send_message (`corporate_user`,`user_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$corpUser','all','$messageHeading','$sentMessage','all','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message (`corporate_user`,`user_type`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`,`primary_id`,`latitude`,`longitude`,`location_address`) values ('$corpUser','particular','$messageHeading','$sentMessage','particular','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$last_id','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        }


        /* if ($type == "all") {

          $str = "insert into send_message (`driver_name`,`corporation_name`,`company_name`,`corporate_user`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`) values ('$driverName','$corpName','$taxiName','$corpUser','$messageHeading','$sentMessage','$type','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check')";
          $res = mysql_query($str);
          $last_id = mysql_insert_id();
          } else {
          if ($driverName == "" and $corpName == "" and $taxiName == "" and $corpUser == "") {
          echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please select atleast one field.</div>';
          HTMLRedirectURL(ZONE_URL . "new-msgs.php");
          die;
          } else {
          $str = "insert into send_message (`driver_name`,`corporation_name`,`company_name`,`corporate_user`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`) values ('$driverName','$corpName','$taxiName','$corpUser','$messageHeading','$sentMessage','$type','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check')";
          $res = mysql_query($str);
          $last_id = mysql_insert_id();
          }
          } */

        if ($optional_check == 1) {
            if ($driverName != '0') {
                //$get_driver_id = mysql_fetch_array(mysql_query("SELECT * FROM driver where  id = $driverName"));
                $get_driver_location = mysql_query("SELECT * FROM trip_log where  driver_id = $driverName ORDER BY id DESC LIMIT 1");
                $data_driver_location = mysql_fetch_array($get_driver_location);
                $rows_driver = mysql_num_rows($get_driver_location);
                if ($rows_driver > 0) {
                    $lat = $data_driver_location['latitude'];
                    $lon = $data_driver_location['longitude'];

                    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&sensor=false";

                    $json = @file_get_contents($url);
                    $data = json_decode($json);
                    $status = $data->status;
                    $address = '';
                    if ($status == "OK") {
                        $address = $data->results[0]->formatted_address;
                    }
                    $str_address = "insert into send_message_location (`send_message_id`,`driver_id`,`user_id`,`location_address`,`latitude`,`longitude`) values ('$last_id','$driverName',0,'$address','$lat','$lon')";
                    $res_address = mysql_query($str_address);
                }
                $get_crop_user_location = mysql_query("SELECT * FROM trip where  customer_id = $corpUser ORDER BY id DESC LIMIT 1");
                $data_crop_location = mysql_fetch_array($get_crop_user_location);
                $rows_crop = mysql_num_rows($get_crop_user_location);
                if ($rows_crop > 0) {
                    $lat = $data_crop_location['latitude'];
                    $lon = $data_crop_location['longitude'];

                    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&sensor=false";

                    $json = @file_get_contents($url);
                    $data = json_decode($json);
                    $status = $data->status;
                    $address = '';
                    if ($status == "OK") {
                        $address = $data->results[0]->formatted_address;
                    }
                    $str_address = "insert into send_message_location (`send_message_id`,`driver_id`,`user_id`,`location_address`,`latitude`,`longitude`) values ('$last_id','0','$corpUser','$address','$lat','$lon')";
                    $res_address = mysql_query($str_address);
                }
            } else {
                $query_driver_detail = "SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name,`driver`.id as driID,`driver`.email FROM `driver`
        LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
        where `driver`.name like '%$q%' and `login`.id='" . $_SESSION['uid'] . "'";
                $result_driver_detail = mysql_query($query_driver_detail);
                $num_rows_driver_detail = mysql_num_rows($result_driver_detail);
                if (isset($num_rows_driver_detail) && $num_rows_driver_detail > 0) {
                    while ($row = mysql_fetch_array($result_driver_detail)) {
                        $driverid = $row['driID'];
                        $get_driver_location = mysql_query("SELECT * FROM trip_log where  driver_id = $driverid ORDER BY id DESC LIMIT 1");
                        $data_driver_location = mysql_fetch_array($get_driver_location);
                        $rows_driver = mysql_num_rows($get_driver_location);
                        if ($rows_driver > 0) {
                            $lat = $data_driver_location['latitude'];
                            $lon = $data_driver_location['longitude'];

                            $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&sensor=false";

                            $json = @file_get_contents($url);
                            $data = json_decode($json);
                            $status = $data->status;
                            $address = '';
                            if ($status == "OK") {
                                $address = $data->results[0]->formatted_address;
                            }
                            $str_address = "insert into send_message_location (`send_message_id`,`driver_id`,`user_id`,`location_address`,`latitude`,`longitude`) values ('$last_id','$driverid',0,'$address','$lat','$lon')";
                            $res_address = mysql_query($str_address);
                        }
                    }
                }

                //Query for app users detail
                $nj = '';
                $njj = '';
                $query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by =  '" . $_SESSION['uid'] . "'");
                while ($data = mysql_fetch_array($query)) {
                    $nj .= $data[id] . ',';
                }
                $nj = rtrim($nj, ',');
                if (isset($nj) && $nj) {
                    $query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
                    while ($data = mysql_fetch_array($query)) {
                        $njj .= $data[id] . ',';
                    }
                }
                $njj = rtrim($njj, ',');
                if (isset($njj) && $njj) {
                    $query_users_detail = "SELECT name, id FROM `users` where 1 and corporate_id in ($njj) and name like '%" . $q . "%' ";
                    $result_users_detail = mysql_query($query_users_detail);
                    $num_rows_users_detail = mysql_num_rows($result_users_detail);
                }
                while ($row_users_detail = mysql_fetch_array($result_users_detail)) {
                    $usersId = $row_users_detail['id'];

                    $get_crop_user_location = mysql_query("SELECT * FROM trip where  customer_id = $usersId ORDER BY id DESC LIMIT 1");
                    $data_crop_location = mysql_fetch_array($get_crop_user_location);
                    $rows_crop = mysql_num_rows($get_crop_user_location);
                    if ($rows_crop > 0) {
                        $lat = $data_crop_location['latitude'];
                        $lon = $data_crop_location['longitude'];

                        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&sensor=false";

                        $json = @file_get_contents($url);
                        $data = json_decode($json);
                        $status = $data->status;
                        $address = '';
                        if ($status == "OK") {
                            $address = $data->results[0]->formatted_address;
                        }
                        $str_address = "insert into send_message_location (`send_message_id`,`driver_id`,`user_id`,`location_address`,`latitude`,`longitude`) values ('$last_id','0','$usersId','$address','$lat','$lon')";
                        $res_address = mysql_query($str_address);
                    }
                }
                //echo "SELECT * FROM trip_log where  driver_id IN ($driverid) ORDER BY id DESC LIMIT 1";
                //$get_driver_location = mysql_query("SELECT * FROM trip_log where  driver_id IN ($driverid) ORDER BY id DESC LIMIT 1"); die;
            }
        }
        if ($res) {
            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Mensaje insertado con exito</div>';
        } else {
            echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error en la codificacion</div>';
        }
    }
}

function updatemessage() {
    $id = $_REQUEST['id'];
    $type = $_REQUEST['sendMessage'];
    $updated_on = date('Y-m-d H:i:s');
    $driverName = $_REQUEST['selDriverName'];
    $corpName = $_REQUEST['selCorName'];
    $taxiName = $_REQUEST['selCentralName'];
    $corpUser = $_REQUEST['selUsersName'];
    $added_by = $_SESSION['uid'];
    $messageHeading = $_REQUEST['txtHeading'];
    $sentMessage = base64_encode($_REQUEST['sentMessage']);


    // if($type == "all")
    // {
    // $str="insert into send_message (`driver_name`,`corporation_name`,`company_name`,`corporate_user`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`) values ('$driverName','$corpName','$taxiName','$corpUser','$messageHeading','$sentMessage','$type','$added_on','$added_by','".$_SESSION['zoneArea']."','$optional_check')";
    // $res=mysql_query($str);
    // $last_id = mysql_insert_id();
    // }
    // else
    // {
    //   if($driverName == "" || $corpName == "" || $taxiName == "" || $corpUser == "" )
    //   {
    //     echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please select field.</div>';
    //     HTMLRedirectURL(ZONE_URL."new-msgs.php");
    //     die;
    //   }
    //   else
    //   {
    //     $str="insert into send_message (`driver_name`,`corporation_name`,`company_name`,`corporate_user`,`heading`,`message`,`type`,`added_on`,`added_by`,`zone_arae_id`,`get_optional_check`) values ('$driverName','$corpName','$taxiName','$corpUser','$messageHeading','$sentMessage','$type','$added_on','$added_by','".$_SESSION['zoneArea']."','$optional_check')";
    //     $res=mysql_query($str);
    //     $last_id = mysql_insert_id();
    //   }
    // }
    if ($type == "particular") {
        if ($driverName == "" and $corpName == "" and $taxiName == "" and $corpUser == "") {
            echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please select atleast one field.</div>';
            HTMLRedirectURL(ZONE_URL . "update-my-msgs.php?id=$id");
            die;
        }
    }

    $str = "update send_message  set `driver_name`='$driverName',`corporation_name`='$corpName',`company_name`='$taxiName',`corporate_user`='$corpUser',`heading`='$messageHeading',`message`='$sentMessage',`type`='$type',`updated_on`='$updated_on',`added_by`='$added_by' where id='$id'";
    $res = mysql_query($str);
    if ($res) {
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Message updated successfully</div>';
    } else {
        echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error in Coding</div>';
    }
}

function addPayemnt() {
    global $objConnect;
    global $objCommon;
    $week = $_POST['week'];
    $name = $_POST['driverName'];
    $driverPayment = $_POST['driverPayment'];
    $fromDate1 = $_POST['fromDate'];
    $toDate1 = $_POST['toDate'];
    //echo $name; die;
    $added_by = $_SESSION['uid'];
    $added_on = date('Y-m-d H:i:s');


    $get_driver = mysql_query("SELECT * FROM driver WHERE id = '$name'");
    $data_driver = mysql_fetch_array($get_driver);

    $str = "insert into driverPayment (`driver_name`,`payment`,`week`,`paymentDateFrom`,`paymentDateTo`,`added_by`,`added_on`,`amount_type`) values ('$name','$driverPayment','$week',$fromDate1,$toDate1,'$added_by','$added_on','activation')";
    $res = mysql_query($str) or die(mysql_error());
    if ($res) {
        $message = array("driverAddPayment" => "Yout Activation has been paid between $fromDate1 to $toDate1");
        $gcm_regid = $data_driver['device_id'];

        $registatoin_ids = array($gcm_regid);
        send_notification($registatoin_ids, $message);
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Pago agregado correctamente</div>';
    } else {
        echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error in Coding</div>';
    }
}

function login($table) {
    global $objConnect;
    global $objCommon;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);


    if (empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0) {
        $msg = "0";
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please enter correct Captcha.</div>';
    } else {
        //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
        $query = "select * from `$table` where `email` = '$email' and `password` = '$password'";
        $getAttemp = mysql_query("select * from `$table` where `email` = '$email'");
        $result = mysql_query($query);
        $num = mysql_num_rows($result);
        $getNumAttemp = mysql_fetch_array($getAttemp);
        $login_count = $getNumAttemp['login_attempt'];
        if ($login_count >= 3) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button> You are blocked due 3 failure attempt. Please contact your administrator</div>';
        } else {
            if ($num > 0) {
                $query = "select * from `$table` where `email` = '$email' and `password` = '$password'";
                $result = mysql_query($query);
                $row = mysql_fetch_assoc($result);
                $queryAttem = mysql_query("UPDATE `$table` SET login_attempt = '0' WHERE 1 and `email` = '$email'");
                $logUpdate = "UPDATE `$table` SET login_status = '1',`last_login`='" . date('Y-m-d H:i:g') . "' WHERE `id` = '" . $row['id'] . "'"; // manage login details
                $result = mysql_query($logUpdate);
                $_SESSION['uname'] = $row['name'];
                $_SESSION['uid'] = $row['id'];
                $_SESSION['utype'] = $row['account_type'];
                $_SESSION['uemail'] = $row['email'];

                //$_SESSION['expire'] = time()+30*60;

                if ($row['account_type'] == '1') {
                    $_SESSION['typeUrl'] = SUPER_ADMIN_URL;
                    RedirectURL(SUPER_ADMIN_URL . "index.php");
                } else if ($row['account_type'] == '2') {
                    $_SESSION['typeUrl'] = ZONE_URL;
                    RedirectURL(ZONE_URL . "index.php");
                } else if ($row['account_type'] == '4') {
                    $_SESSION['typeUrl'] = TAXI_URL;
                    RedirectURL(TAXI_URL . "index.php");
                } else if ($row['account_type'] == '5') {
                    $_SESSION['typeUrl'] = CORPORATE_URL;
                    RedirectURL(CORPORATE_URL . "index.php");
                } else if ($row['account_type'] == '6') {
                    $_SESSION['typeUrl'] = TAXI_URL;
                    RedirectURL(TAXI_URL . "index.php");
                } else {
                    echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button> Some error ouccred due to login. Please try again</div>';
                }
            } else {
                $login_count = $login_count + 1;
                $queryAttem = mysql_query("UPDATE `$table` SET login_attempt = $login_count WHERE 1 and `email` = '$email'");
                $Remainlogin_count = 3 - $login_count;
                echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button> Invalid Email-Id / Password. You have ' . $Remainlogin_count . ' attempt remian. Please try again</div>';
            }
        }
    }
}

function check_user($email = "") {
    if (isset($_POST['email']) and $_POST['email'] != "") {
        $email = $_POST['email'];
    } else if (isset($email)) {
        $email = $email;
    }
    $query = mysql_query("SELECT * FROM `web_users` WHERE email_id = '$email'") or die(mysql_error());
    if (mysql_num_rows($query) > 0) {
        return 1;
    } else {
        return 0;
    }
}

function strip_slashes_value($value) {
    $value = stripslashes(str_replace("''", "'", trim($value)));

    return $value;
}

function Defaultlogout() {
    session_destroy();
    RedirectURL(MAIN_URL . "login.php");
}

function logout() {

    $logUpdate = "UPDATE `login` SET login_status = '0' WHERE `id` = '" . $_SESSION['uid'] . "'"; // manage login details
    $result = mysql_query($logUpdate);
    unset($_SESSION['uid']);
    unset($_SESSION['uname']);
    unset($_SESSION['utype']);
    unset($_SESSION['uemail']);
    unset($_SESSION['typeUrl']);
    session_destroy();
    RedirectURL(MAIN_URL . "login.php");
}

function verifyLogin() {
    if (!isset($_SESSION['uid'])) {
        Defaultlogout();
    }

    // -- check url
    $url = $_SERVER['REQUEST_URI']; //returns the current URL
    $parts = explode('/', $url);
    $dir = 'http://' . $_SERVER['SERVER_NAME'];
    for ($i = 0; $i < count($parts) - 1; $i++) {
        $dir .= $parts[$i] . "/";
    }
    $loginUrl = $_SESSION['typeUrl'];
    if ($dir == $loginUrl) {
        
    } else {
        echo '<script>alert("Access denied! You do not have permission to view this page using your current user account. And you have been logged out.");</script>';
        Defaultlogout();
    }
}

function RedirectURL($url) {
    ?>
    <script>window.location = "<?php echo $url; ?>";</script>
    <?php
    exit;
}

function HTMLRedirectURL($url) {
    ?>
    <meta http-equiv="refresh" content="0.5; url=<?php echo $url; ?>">
    <?php
}

function getAddress($lat, $lon) {
    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat . "," . $lon . "&sensor=false";
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    $address = '';
    if ($status == "OK") {
        $address = $data->results[0]->formatted_address;
    } return $address;
}

function get_lat_lon() {
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . urlencode($_POST["address"]) . '&sensor=false');
    print_r($geocode);
    die();
}

function sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name) {
    require_once('phpmailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    /*
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'user@example.com';                 // SMTP username
      $mail->Password = 'secret';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to
     */
    $mail->From = $from;
    $mail->FromName = $from_name;
    $mail->addAddress($to, $to_name);     // Add a recipi
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo($reply_to, $reply_name);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if (!$mail->send()) {
        return 0;
        'Message could not be sent.';
    } else {
        return 1;
        'Message has been sent';
    }
}

function forgot_password() {
    global $objConnect;
    global $objCommon;
    $txtemail = $_POST['txtemail'];
    $query = "select * from `login` where `email` = '$txtemail'";
    $result = $objConnect->execute($query);
    $num = $objConnect->total_rows();
    if ($num) {
        $row = $objConnect->fetch_assoc();
        $email = $row['email'];
        $username = $row['name'];
        $pass1 = $objCommon->getDecryptPassword($row['password_de']);
        $pass = $row['password_de'];
        $to = $email;
        $to_name = $username;
        $from = FROM_ADMIN_EMAIL_ID;
        $from_name = FROM_ADMIN_NAME;
        $reply_to = REPLY_ADMIN_EMAIL_ID;
        $reply_name = REPLY_ADMIN_NAME;
        $subject = "Forgot Password";
        $message = "<table width='100%'><tr><td colspan='2'>Hello, " . ucfirst($to_name) . "</td></tr><tr><td colspan='2'>We have received forgot password request, following is your password:-</td></tr><tr><td>&nbsp;</td></tr><tr><td colspan='2' style='font-size:14px;' bgcolor='#CCCCCC'><b><i>" . $pass . "</i></b></td></tr><tr><td>&nbsp;</td></tr><tr><td colspan='2'>You can login here:- " . MAIN_URL . "</td></tr></table>";
        $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        if ($mail_status == 1) {
            echo "<span class='success_message'>Password sent to your registered email id!</span>";
            HTMLRedirectURL(MAIN_URL);
        } elseif ($mail_status == 0) {
            echo "<span class='errorMessage'>Please try again!</span>";
        }
    } else {
        echo "<span class='errorMessage'>Wrong Email!</span>";
    }
}

function contact_form() {
    global $objConnect;
    global $objCommon;
    $err_string = "";
    $error = false;
    $contact_name = $objCommon->sanitize($_POST['contact_name']);
    $contact_email = $objCommon->sanitize($_POST['contact_email']);
    $contact_phone = $objCommon->sanitize($_POST['contact_phone']);
    $contact_message = $objCommon->sanitize($_POST['contact_message']);
    if (empty($contact_name)) {
        $err_string .= "Name required<br>";
        $error = true;
    }

    if (empty($contact_email)) {
        $err_string .= "Email required<br>";
        $error = true;
    }
    if (empty($contact_phone)) {
        $err_string .= "Phone no. required<br>";
        $error = true;
    }
    if (!preg_match('/^[1-9][0-9]*$/', $contact_phone)) {
        $err_string .= "Phone no. should be numeric value<br>";
        $error = true;
    }
    if (empty($contact_message)) {
        $err_string .= "Message required<br>";
        $error = true;
    }
    if ($error) {
        echo "<span class='error_message'>" . $err_string . "</span>";
    } else {
        $to = TO_ADMIN_EMAIL_ID;
        $to_name = TO_ADMIN_NAME;
        $from = FROM_ADMIN_EMAIL_ID;
        $from_name = FROM_ADMIN_NAME;
        $reply_to = REPLY_ADMIN_EMAIL_ID;
        $reply_name = REPLY_ADMIN_NAME;
        $subject = "Contact form";
        $message = "<table width='100%'><tr><td colspan='2'>Hello,</td></tr><tr><td colspan='2'>Following is the details of contact us form:-</td></tr><tr><td>&nbsp;</td></tr><tr><td><b>Name:</b></td><td>" . ucfirst($contact_name) . "</td></tr><tr><td><b>Email:</b></td><td>" . $contact_email . "</td></tr><tr><td><b>Phone:</b></td><td>" . $contact_phone . "</td></tr><tr><td><b>Message:</b></td><td>" . nl2br($contact_message) . "</td></tr><tr><tr><td>&nbsp;</td></tr></table>";
        $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        if ($mail_status == 1) {
            echo "<span class='success_message'>Thanks for contact us, we will get back to you soon!</span>";
        } elseif ($mail_status == 0) {
            echo "<span class='error_message'>Please try again!</span>";
        }
    }
    die();
}

// -- Super Admin Coding Here---
function updateLoginDetails() {
    global $objCommon;
    $err_string = "";
    $error = false;
    $u_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];

    $address = $_POST['address'];
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];

    $updated_on = date('Y-m-d H:i:g');
    if ($new_password != '') {
        $getOldPassword = mysql_fetch_array(mysql_query("select * from `login` where 1 and id = '" . $_SESSION['uid'] . "'"));
        if (md5($u_password) == $getOldPassword['password']) {
            $new_password = md5($new_password);
            $qryP = "update `login` set name='$name',contact_number='$contact_number',address='$address',password='$new_password',updated_on='$updated_on',updated_by='" . $_SESSION['uid'] . "' where 1 and id = '" . $_SESSION['uid'] . "'";
            mysql_query($qryP);
            echo '1';
        } else {
            echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Your current password not correct</div>';
        }
    } else {
        $qryP = "update `login` set name='$name',contact_number='$contact_number',address='$address' where 1 and id = '" . $_SESSION['uid'] . "'";
        mysql_query($qryP);
        echo '1';
    }
    //die();
}

function addAdministrator() {
    ////1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer

    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $contactno = $_POST['contactno'];
    $emailID = $_POST['emailID'];
    $password = md5($_POST['password']);
    $password_de = $_POST['password'];
    $super_email = $_POST['super_email'];
    $super_name = $_POST['super_name'];
    //$workZone = $_POST['workZone'];
    $account_type = '2';
    $added_on = date('Y-m-d H:i:g');
    $checkEmail = mysql_query("select * from `login` where 1 and email = '" . $emailID . "'");
    if (mysql_num_rows($checkEmail) == 0) {
        $qryP1 = "insert into `login` (`name`,`email`,`contact_number`,`password`,`password_de`,`account_type`,`added_on`,`added_by`,`login_status`,`status`) values ('$name','$emailID','$contactno','$password','$password_de','$account_type','$added_on','" . $_SESSION['uid'] . "','0','200')";
        mysql_query($qryP1);
        $idd = mysql_insert_id();

        $to = $emailID;
        $to_name = $name;
        $from = $super_email;
        $from_name = $super_name;
        $reply_to = $super_email;
        $reply_name = $super_name;
        $subject = "Cuenta Creada en Taxi Central";
        $message = file_get_contents(MAIN_URL . 'email-template/header.php');
        $message .='Hi, We need to make sure you are human. Please verify your email and get started using your Website account. <a href="http://www.hvantagetechnologies.com/central-taxi/activation/adminActivation.php?id=' . $idd . '">' . $base_url . 'activation/' . $to . '</a>';
        //$message = "Una cuenta de (“Administrador de Zona”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
        $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


        $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);

        $file = $_FILES["file_name"];
        $name1 = $file ['name'];
        foreach ($name1 as $key => $value) {
            $tmppath = $file['tmp_name'][$key];
            if ($tmppath != '') {
                $names = explode('.', $value);
                $value = rand() . _ . $value;
                $path = "upload_file/" . $value;
                move_uploaded_file($tmppath, $path);
                $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$idd','$added_on','$idd','2','$names')";
                $res = mysql_query($query) or die('could not updated:' . mysql_error());
            }
        }

        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Cuenta a&ntilde;adido correctamente</div>';
        //HTMLRedirectURL(SUPER_ADMIN_URL.'administrators.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-Id already exists. Please use other Email-Id</div>';
    }
    //die();
}

function updateAdministrator() {
    ////1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $contactno = $_POST['contactno'];
    $name = $_POST['name'];
    $account_type = '2';
    $administratorId = $_POST['administratorId'];
    //$password = $_POST['password'];
    $password = md5($_POST['password_hi']);
    $newpassword = md5($_POST['newpassword']);

    $password_de = $_POST['password_hi'];
    $password_new_de = $_POST['newpassword'];

    /* if($password != '')
      {
      $password = md5($password);
      $password = ",password = '".$password."'";
      }
      else
      {
      $password = "";
      } */

    $updated_on = date('Y-m-d H:i:g');
    $checkEmail = mysql_query("select * from `login` where 1 and id = '" . $administratorId . "'");
    mysql_num_rows($checkEmail);
    if (mysql_num_rows($checkEmail) > 0) {
        if (isset($_POST['newpassword']) && $_POST['newpassword'] != '') {
            $to = $_POST['emailID'];
            $to_name = $_POST['name'];
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = $_SESSION['uname'];
            $subject = "Profile Update";
            $message = 'Mail <br/>';
            $message .= '<b>Your New Passowrd : - </b>' . $password_new_de . '';
            $reply_to = FROM_ADMIN_EMAIL_ID;
            $reply_name = $_SESSION['uname'];
            //echo 'aa';die;
            //sendMail($to,$to_name,$from,$from_name,$subject,$message,$reply_to,$reply_name);

            $password = $newpassword;

            $qryP1 = "update `login` set `name`='$name',`contact_number`='$contactno',`updated_on`='$updated_on',`updated_by`='$administratorId' ,`password`='$password',`password_de`='$password_new_de' where 1 and id = '" . $administratorId . "'";
            mysql_query($qryP1);

            //echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>User Updated Successfully.</div>';
            //HTMLRedirectURL(SUPER_ADMIN_URL."administrators.php");	
        } else {
            $qryP1 = "update `login` set `name`='$name',`contact_number`='$contactno',`updated_on`='$updated_on',`updated_by`='$administratorId',`password`=' $password',`password_de`='$password_de' where 1 and id = '" . $administratorId . "'";
            mysql_query($qryP1);
        }
        $file = $_FILES["file_name"];
        $name1 = $file ['name'];
        foreach ($name1 as $key => $value) {
            $tmppath = $file['tmp_name'][$key];
            if ($tmppath != '') {
                $names = explode('.', $value);
                $value = rand() . _ . $value;
                $path = "upload_file/" . $value;
                move_uploaded_file($tmppath, $path);
                $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$administratorId','$added_on','$administratorId','2','$names[0]')";
                $res = mysql_query($query) or die('could not updated:' . mysql_error());
            }
        }

        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Cuenta actualizada correctamente</div>';
        HTMLRedirectURL(SUPER_ADMIN_URL . 'administrators.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Account not exists. Please try again</div>';
    }
    //die();
}

// -- Super Admin Coding End Here---
// -- Account Administrator Coding Here---
function addTaxiCentralByZone() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $Company_name = $_POST['Company_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $emailID = $_POST['emailID'];
    $contactno = $_POST['contactno'];
    $password = md5($_POST['password']);
    $password_de = $_POST['password'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $systemAllow = $_POST['systemAllow'];
    $worklimit = $_POST['worklimit'];
    $per_week_cost = $_POST['per_week_cost'];
    $company_email = $_POST['super_email'];
    $company_name = $_POST['super_name'];
    $systemAllow = $_POST['systemAllow'];
    if ($systemAllow == "" || $systemAllow == null) {
        $account_type = '6';
    } else {
        $account_type = '4';
    }

    $added_on = date('Y-m-d H:i:g');
    $end_date = date('Y-m-d H:i:g', strtotime('+7 days'));
    //print_r($end_date);die;

    $checkEmail = mysql_query("select * from `login` where 1 and email = '" . $emailID . "'");
    if (mysql_num_rows($checkEmail) == 0) {
        $qryP1 = "insert into `login` (`name`,`email`,`contact_number`,`password`,`password_de`,`account_type`,`added_on`,`added_by`,`login_status`,`status`) values ('$Company_name','$emailID','$contactno','$password','$password_de','$account_type','$added_on','" . $_SESSION['uid'] . "','0','200')";
        mysql_query($qryP1);
        $logId = mysql_insert_id();

        // For send mail
        $to = $emailID;
        $to_name = $name;
        $from = $company_email;
        $from_name = $super_name;
        $reply_to = $company_name;
        $reply_name = $company_email;
        $subject = "Account Created in Hi Taxi";
        $message = file_get_contents(MAIN_URL . 'email-template/header.php');
        $message .='Hi, We need to make sure you are human. Please verify your email and get started using your Website account. <a href="' . MAIN_URL . 'activation/adminActivation.php?id=' . $logId . '">' . $base_url . 'activation/' . $to . '</a>';
        //$message = "Una cuenta de (“Administrador de Zona”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
        $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


        $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        // $to  = $emailID;
        // $to_name = $Company_name;
        // $from = FROM_ADMIN_EMAIL_ID;
        // $from_name = FROM_ADMIN_NAME;
        // $reply_to = REPLY_ADMIN_EMAIL_ID;
        // $reply_name = REPLY_ADMIN_NAME;
        // $subject="Cuenta Creada en Taxi Central";
        // $message = "Una cuenta de (“Usuario Contable”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
        // $mail_status = sendMail($to,$to_name,$from,$from_name,$subject,$message,$reply_to,$reply_name);



        $qryP1 = "insert into `taxicompany` (`name`,`contact`,`address`,`city`,`state`,`country`,`per_week_cost`,`work_limit`,`system_allow`,`added_on`,`added_by`,`web_user_id`,`latitude`,`longitude`,`zone_area_id_sess`) 
	    values ('$Company_name','$contactno','$address','$city','$state','$country','$per_week_cost','$worklimit','$systemAllow','$added_on','" . $_SESSION['uid'] . "','$logId','$latitude','$longitude','" . $_SESSION['zoneArea'] . "')";
        mysql_query($qryP1);

        $qry_amt_update = "insert into `manage_master_amount` (`zone_id`,`company_id`,`type`,`amount`,`added_by`,`added_on`, `end_date_time`,`amount_type`,`start_date`) 
	    values ('" . $_SESSION['uid'] . "','$logId','begning_amount','$per_week_cost','" . $_SESSION['uid'] . "','$added_on','$end_date','activation','$added_on')";
        mysql_query($qry_amt_update);


        $file = $_FILES["file_name"];
        $name1 = $file ['name'];
        foreach ($name1 as $key => $value) {
            $tmppath = $file['tmp_name'][$key];
            if ($tmppath != '') {
                $names = explode('.', $value);
                $value = rand() . _ . $value;
                $path = "../taxi-company/upload_file/" . $value;
                move_uploaded_file($tmppath, $path);
                $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$logId','$added_on','$logId','4','$names[0]')";
                $res = mysql_query($query) or die('could not updated:' . mysql_error());
            }
        }


        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Central created correctly</div>';
        HTMLRedirectURL(ZONE_URL . 'taxi-companies.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-ID already exists. Please use other Email-ID</div>';
    }
    //die();
}

function editUpdateTaxiCentralByZone() {

    global $objCommon;
    $err_string = "";
    $error = false;
    $u_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $updated_on = date('Y-m-d H:i:g');

    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $Company_name = $_POST['Company_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $emailID = $_POST['emailID'];
    $contactno = $_POST['contactno'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $systemAllow = $_POST['systemAllow'];
    $worklimit = $_POST['worklimit'];
    $per_week_cost = $_POST['per_week_cost'];
    $user_id = $_POST['web_user_id'];
    $account_type = '4';

    $added_on = date('Y-m-d H:i:g');
    $end_date = date('Y-m-d', strtotime('+7 days'));
    //$new_password = md5($_POST['newPassword']);
    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);

    $password_de = $_POST['password'];
    $password_new_de = $_POST['newpassword'];

    $file = $_FILES["file_name"];
    $name1 = $file ['name'];
    $updated_on = date('Y-m-d H:i:g');
    if ($_POST != '') {

        if (isset($_POST['newpassword']) && $_POST['newpassword'] != '') {
            $query_login = "UPDATE `login` set `name`='$Company_name',`email`='$emailID',`password`='$newpassword',`password_de`='$password_new_de',`updated_by`='" . $_SESSION['uid'] . "' where id ='$user_id'";
            mysql_query($query_login);
        } else {
            $query_login = "UPDATE `login` set `name`='$Company_name',`email`='$emailID',`password`='$password',`password_de`='$password_de',`updated_by`='" . $_SESSION['uid'] . "' where id ='$user_id'";
            mysql_query($query_login);
        }

        //$query_login  = "UPDATE `login` set `name`='$Company_name',`email`='$emailID',`password`='$new_password',`updated_by`='".$_SESSION['uid']."' where id ='$user_id'";
        //mysql_query($query_login);  

        $query_last_credit = mysql_fetch_assoc(mysql_query("SELECT * FROM manage_master_amount where company_id = '$user_id' AND zone_id!=''  order by id DESC"));
        $start_date_cre = $query_last_credit['end_date_time'];
        $end_date_cre = date("Y-m-d", strtotime("$start_date_cre + 7 day"));

        $qry_amt_update = "insert into `manage_master_amount` (`zone_id`,`company_id`,`type`,`amount`,`added_by`,`added_on`,`start_date`,`end_date_time`,`amount_type`) 
		values ('" . $_SESSION['uid'] . "','$user_id','credit_amount','$per_week_cost','" . $_SESSION['uid'] . "','$added_on','$start_date_cre' ,'$end_date_cre','activation')";
        mysql_query($qry_amt_update);

        $query_taxicompany = "UPDATE `taxicompany` SET `name` = '$Company_name',`contact`='$contactno',`address`='$address',`city`='$city',`state`='$state',`country`='$country',`work_limit`='$worklimit',`system_allow`='$systemAllow',`added_on`='$added_on',`added_by`='" . $_SESSION['uid'] . "',`web_user_id`='$user_id',`latitude`='$latitude',`longitude`='$longitude', `zone_area_id_sess` = '" . $_SESSION['zoneArea'] . "' where `web_user_id`= $user_id";
        mysql_query($query_taxicompany);


        foreach ($name1 as $key => $value) {
            $tmppath = $file['tmp_name'][$key];
            if ($tmppath != '') {
                $names = explode('.', $value);
                $value = rand() . _ . $value;
                //$path = "'".TAXI_URL."'upload_file/".$value;
                $path = "../taxi-company/upload_file/" . $value;
                move_uploaded_file($tmppath, $path);
                $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$user_id','$added_on','$user_id','4','$names[0]')";
                $res = mysql_query($query) or die('could not updated:' . mysql_error());
            }
        }


        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Central correctly updated</div>';
        HTMLRedirectURL(ZONE_URL . 'taxi-companies.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Please enter your password:</div>';
    }
}

function addTaxiCompany() {
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $Company_name = $_POST['Company_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $emailID = $_POST['emailID'];
    $contactno = $_POST['contactno'];
    $password = md5($_POST['password']);
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $account_type = '4';

    $added_on = date('Y-m-d H:i:g');

    $checkEmail = mysql_query("select * from `login` where 1 and email = '" . $emailID . "'");
    if (mysql_num_rows($checkEmail) == 0) {
        $qryP1 = "insert into `login` (`name`,`email`,`contact_number`,`password`,`account_type`,`added_on`,`added_by`,`login_status`,`status`) values ('$Company_name','$emailID','$contactno','$password','$account_type','$added_on','" . $_SESSION['uid'] . "','0','200')";
        mysql_query($qryP1);
        $logId = mysql_insert_id();
        $qryP1 = "insert into `taxiCompany` (`name`,`contact`,`address`,`street_no`,`city`,`state`,`country`,`zip_code`,`added_on`,`added_by`,`web_user_id`,`latitude`,`longitude`) 
	    values ('$Company_name','$contactno','$address','','$city','$state','$country','$zip_code','$added_on','" . $_SESSION['uid'] . "','$logId','$latitude','$longitude')";
        mysql_query($qryP1);
        echo '1';
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-Id already exists. Please use other Email-Id</div>';
    }
    //die();
}

// -- Account Administrator Coding End Here---
// -- Taxi Company Administrator Coding Here---
function add_driver() {
    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $contactno = $_POST['contactno'];
    $liecence_number = $_POST['liecence_number'];
    $username = $_POST['username'];
    $insurance_expiration_date = date('Y-m-d', strtotime($_POST['insurance_expiration_date']));
    $licence_expiration_date = date('Y-m-d', strtotime($_POST['licence_expiration_date']));
    $vehicle_owner_name = $_POST['vehicle_owner_name'];
    $vehicle_contact = $_POST['vehicle_contact'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_number = $_POST['vehicle_number'];
    $username = $_POST['username'];
    $trip_fare = $_POST['trip_fare'];
    $driver_type = $_POST['driver_type'];
    $added_on = date('Y-m-d H:i:g');
    $password = md5($_POST['password']);
    $zone_main_area_id = '0';
    /* Zone area insert */
    // Main zone area
    $main_zone_id = $_POST['driver_zoneaera'];
    //sub zone area
    $sab_zone_id = $_POST['driver_zone'];

    if ($_POST['driver_zone'] != '') {
        $zone_area_id = $sab_zone_id;
    } else {
        $zone_main_area_id = $main_zone_id;
    }
    /**/
    //====================================== file upload ==========================

    define('UPLOAD_DIR', 'driver/');
    $img = $_REQUEST['cropImage'];
    if ($img == '' || $img == null) {
        $err_string .= "Por favor ingrese una foto de Taxista.";
        $error = true;
    }

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $target_file = UPLOAD_DIR . uniqid() . '.png';
    $target_file1 = file_put_contents($target_file, $data);
    /*
      $file = UPLOAD_DIR . uniqid() . '.png';
      $image_name="";
      if($_FILES['image']['tmp_name'] != '')
      {
      $target_dir = "driver/";
      $path_parts = pathinfo($_FILES["image"]["name"]);
      $image_name = strtolower($path_parts['filename'].'_'.time().'.'.$path_parts['extension']);
      $target_file = $target_dir .$image_name;
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if($check == false) {
      $err_string .= "driver picture is not an image<br>";
      $uploadOk = 0;
      $error = true;
      }
      // Check if file already exists
      if (file_exists($target_file)) {
      $err_string .= "Sorry, driver picture already exists<br>";
      $uploadOk = 0;
      $error = true;
      }
      // Check file size
      if ($_FILES["image"]["size"] > 10000000) {
      $err_string .= "Please upload driver picture upto 10MB<br>";
      $uploadOk = 0;
      $error = true;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
      $err_string .= "Sorry, only JPG, JPEG, PNG & GIF format for driver picture are allowed<br>";
      $uploadOk = 0;
      $error = true;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
      $err_string .= "Sorry, your driver picture was not uploaded<br>";
      $error = true;
      // if everything is ok, try to upload file
      } else {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      //$err_string .= "The file has been uploaded.";
      } else {
      $err_string .= "Sorry, there was an error uploading your driver picture.";
      $error = true;
      }
      }
      }
     */
    if ($error) {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>' . $err_string . '</div>';
    } else {
        $query = mysql_query("select * from `driver` where 1 and username = '" . $username . "'");
        $num = mysql_num_rows($query);

        $query_liecence_number = mysql_query("select * from `driver` where 1 and liecence_number = '" . $liecence_number . "'");
        $num_liecence_number = mysql_num_rows($query_liecence_number);

        $query_vehicle_number = mysql_query("select * from `driver` where 1 and vehicle_number = '" . $vehicle_number . "'");
        $num_vehicle_number = mysql_num_rows($query_vehicle_number);


        if ($num_liecence_number > 0) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>El numero de licencia ya existe en el sistema</div>';
        } elseif ($num_vehicle_number > 0) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Vehicle  number Already Exists</div>';
        } elseif ($num > 0) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email Id  Already Exists</div>';
        } else {
            $qryP = " INSERT INTO `driver` (`trip_fare`,`liecence_number`,`company_id`, `name`, `username`, `password`, `contact_number`, `image`, `insurance_expiration_date`, `licence_expiration_date`,`vehicle_owner_name`, `vehicle_contact`, `vehicle_name`, `vehicle_number`, `added_on`,`added_by`,`status`,`login_status`,`driverType`,`zone_id`,`zone_primary_id`) values ('$trip_fare','$liecence_number','" . $_SESSION['uid'] . "','$name','$username','$password','$contactno','$target_file','$insurance_expiration_date','$licence_expiration_date','$vehicle_owner_name','$vehicle_contact','$vehicle_name','$vehicle_number','$added_on','" . $_SESSION['uid'] . "','200','0','$driver_type','$zone_area_id','$zone_main_area_id')";
            mysql_query($qryP);
            $idd = mysql_insert_id();


            // For send mail
            $to = $username;
            $to_name = $name;
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = FROM_ADMIN_NAME;
            $reply_to = REPLY_ADMIN_EMAIL_ID;
            $reply_name = REPLY_ADMIN_NAME;
            $subject = "Cuenta Creada en Taxi Central";
            $message = "Una cuenta de (“Taxista”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";

            $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);


            $file = $_FILES["file_name"];
            //print_r($file);
            $name1 = $file ['name'];
            foreach ($name1 as $key => $value) {
                $tmppath = $file['tmp_name'][$key];
                if ($tmppath != '') {
                    $names = explode('.', $value);
                    $value = rand() . _ . $value;
                    $path = "upload_file/" . $value;
                    move_uploaded_file($tmppath, $path);
                    $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$idd','$added_on','" . $_SESSION['uid'] . "','driver','$names[0]')";
                    $res = mysql_query($query) or die('could not updated:' . mysql_error());
                }
            }

            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>El taxista ha sido ingresado en el sisteam</div>';
            HTMLRedirectURL(TAXI_URL . 'taxi_drivers.php');
        }
    }
}

function editDriver() {

    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $username = $_POST['username'];
    $contactno = $_POST['contactno'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_owner_name = $_POST['vehicle_owner_name'];
    $liecence_number = $_POST['liecence_number'];
    $insurance_expiration_date = date('Y-m-d', strtotime($_POST['insurance_expiration_date']));
    $licence_expiration_date = date('Y-m-d', strtotime($_POST['licence_expiration_date']));
    $vehicle_contact = $_POST['vehicle_contact'];
    $trip_fare = $_POST['trip_fare'];

    $updated_on = date('Y-m-d H:i:g');
    $driverId = $_POST['driverId'];
    $status = $_POST['status'];
    $zone_main_area_id = '0';
    /* Zone area insert */
    // Main zone area
    $main_zone_id = $_POST['driver_zoneaera'];
    //sub zone area
    $sab_zone_id = $_POST['driver_zone'];

    if ($_POST['driver_zone'] != '') {
        $zone_area_id = $sab_zone_id;
    } else {
        $zone_main_area_id = $main_zone_id;
    }
    if ($_POST['insurance_expired'] != '' || $_POST['insurance_expired'] != null) {
        $insurance_expired = '1';
    } else {
        $insurance_expired = '0';
    }
    if ($_POST['insurance_overdue'] != '' || $_POST['insurance_overdue'] != null) {
        $insurance_overdue = '1';
    } else {
        $insurance_overdue = '0';
    }
    if ($_POST['non_payment'] != '' || $_POST['non_payment'] != null) {
        $non_payment = '1';
    } else {
        $non_payment = '0';
    }

    if ($error) {
        echo $err_string;
    } else {

        $query = mysql_query("select * from `driver` where 1 and id != $driverId");
        $num = mysql_num_rows($query);
        if ($num > 0) {
            $qryP = " update `driver` set `zone_id`='$zone_area_id',`zone_primary_id`='$zone_main_area_id',`status`='$status',`insurance_expired`='$insurance_expired',`insurance_overdue`=$insurance_overdue,`non_payment`=$non_payment,`name`='$name', `username`='$username',`contact_number`='$contactno',`vehicle_owner_name`='$vehicle_owner_name',`vehicle_name`='$vehicle_name',`updated_on` = '$updated_on',`updated_by`='" . $_SESSION['uid'] . "',`liecence_number`='$liecence_number',`insurance_expiration_date`='$insurance_expiration_date',`licence_expiration_date`='$licence_expiration_date',`vehicle_contact`='$vehicle_contact',`trip_fare`='$trip_fare' where 1 and id = $driverId";
            mysql_query($qryP);
            if ($status == '200') {
                $str = "SELECT device_id from driver where id='" . $driverId . "'";
                $res = mysql_query($str);
                $row = mysql_fetch_assoc($res);
                $gcm_regid = $row['device_id'];
                $registatoin_ids = array($gcm_regid);
                $message = array("adminActive" => $contents);
                send_notification($registatoin_ids, $message);
            }
            $file = $_FILES["file_name"];
            $name1 = $file ['name'];
            foreach ($name1 as $key => $value) {
                $tmppath = $file['tmp_name'][$key];
                if ($tmppath != '') {
                    $names = explode('.', $value);
                    $value = rand() . _ . $value;
                    $path = "upload_file/" . $value;
                    move_uploaded_file($tmppath, $path);
                    $query = "insert into files_upload(`file_name`,`added_by`,`added_on`,`login_id`,`login_type`,`name`)values('$value','$driverId','$added_on','$driverId','driver','$names[0]')";
                    $res = mysql_query($query) or die('could not updated:' . mysql_error());
                }
            }

            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details Updated</div>';
            HTMLRedirectURL(TAXI_URL . "taxi_drivers.php");
        } else {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details Not Exists. Please try again</div>';
        }
    }
}

function addaggrementCreate() {
    //print_r($_POST);
    error_reporting('0');
    $name = $_POST['name'];
    $percentage = $_POST['percentage'];
    $descripition = $_POST['descripition'];
    $aggrement_by = $_POST['aggrement_by'];

    $added_on = date('Y-m-d H:i:g');
    $value = '';

    $file = $_FILES["file_name"];
    $name1 = $file ['name'];
    $tmppath = $file['tmp_name'][$name1];
    if ($tmppath != '') {
        $names = explode('.', $value);
        $value = rand() . _ . $value;
        $path = "upload_file/" . $value;
        move_uploaded_file($tmppath, $path);
    }
    $query = "insert into agreements (`name`,`percentage`,`descripition`,`doct_attach`,`aggrement_for`,`aggrement_by`,`added_by`,`added_on`)values('$name','$percentage','$descripition','$value','','$aggrement_by','$aggrement_by','$added_on')";
    $res = mysql_query($query) or die('could not updated:' . mysql_error());
    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Acuerdo agregado correctamente</div>';
    HTMLRedirectURL(TAXI_URL . "agreements.php");
}

function update_aggrementCreate() {
    error_reporting('0');
    $name = $_POST['name'];
    $percentage = $_POST['percentage'];
    $descripition = $_POST['descripition'];
    $aggrement_by = $_POST['aggrement_by'];
    $aggrement_IDD = $_POST['aggrement_IDD'];
    $added_on = date('Y-m-d H:i:g');
    $value = '';

    $file = $_FILES["file_name"];
    $name1 = $file ['name'];
    $tmppath = $file['tmp_name'][$name1];
    if ($tmppath != '') {
        $names = explode('.', $value);
        $value = rand() . _ . $value;
        $path = "upload_file/" . $value;
        move_uploaded_file($tmppath, $path);
    }
    $query = "update `agreements` set `name`='$name',`percentage`='$percentage',`descripition`='$descripition',`doct_attach`='$value',`aggrement_by`='$aggrement_by' where 1 and id='" . $aggrement_IDD . "'";
    $res = mysql_query($query) or die('could not updated:' . mysql_error());
    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Agreement updated successfully</div>';
    HTMLRedirectURL(TAXI_URL . "agreements.php");
}

function addCorporateCompany() {
    //echo '<pre>';
    //print_r($_POST); //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    //echo '</pre>';
    global $objCommon;

    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $creditLimit = $_POST['creditLimit'];
    $agreement = $_POST['agreement'];
    $email = $_POST['emailID'];
    $password = md5($_POST['password']);
    $password_de = $_POST['password'];
    $added_on = date('Y-m-d H:i:g');
    $corporate_email = $_POST['corporate_email'];
    $corporate_name = $_POST['corporate_name'];
    $account_type = '5';
    $start_date = date('Y-m-d H:i:g');
    $end_date = date('Y-m-d', strtotime($start_date . " + 7 days"));

    $percentage_credit_amt = $creditLimit * $agreement / 100;
    $main_credit = $creditLimit - $percentage_credit_amt;
    $query = mysql_query("select * from `login` where 1 and email = '" . $email . "'");
    $num = mysql_num_rows($query);
    if (mysql_num_rows($query) == 0) {
        $qryP1 = "insert into `login` (`name`,`email`,`password`,`account_type`,`added_on`,`added_by`,`login_status`,`status`,`password_de`) values ('$name','$email','$password','$account_type','$added_on','" . $_SESSION['uid'] . "','0','200','$password_de')";
        mysql_query($qryP1);
        $logId = mysql_insert_id();

        // For send mail
        $to = $email;
        $to_name = $name;
        $from = $corporate_email;
        $from_name = $corporate_name;
        $reply_to = $corporate_email;
        $reply_name = $corporate_email;
        $subject = "Cuenta Creada en Taxi Central";
        $message = file_get_contents(MAIN_URL . 'email-template/header.php');
        $message .='Hi, We need to make sure you are human. Please verify your email and get started using your Website account. <a href="http://www.hvantagetechnologies.com/central-taxi/activation/adminActivation.php?id=' . $logId . '">' . $base_url . 'activation/' . $to . '</a>';
        //$message = "Una cuenta de (“Administrador de Zona”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
        $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


        $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        // $to  = $email;
        // $to_name = $name;
        // $from = FROM_ADMIN_EMAIL_ID;
        // $from_name = FROM_ADMIN_NAME;
        // $reply_to = REPLY_ADMIN_EMAIL_ID;
        // $reply_name = REPLY_ADMIN_NAME;
        // $subject="Cuenta Creada en Taxi Central";
        // $message = "Una cuenta de (“empresa corporativa”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
        // $mail_status = sendMail($to,$to_name,$from,$from_name,$subject,$message,$reply_to,$reply_name);



        $qryP1 = "insert into `corporate` (`name`,`company_id`,`begning_credit`,`agreement_id`,`added_on`,`added_by`,`web_user_id`,`password`) values ('$name','" . $_SESSION['uid'] . "','$main_credit','$agreement','$added_on','" . $_SESSION['uid'] . "','$logId','" . $_POST['password'] . "')";
        mysql_query($qryP1);

        $qry_amt_insert = "insert into `manage_master_amount` (`company_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`,`start_date`,`end_date_time`,`amount_type`) 
                values ('" . $_SESSION['uid'] . "','$logId','begning_amount','$main_credit','" . $_SESSION['uid'] . "','$added_on','$start_date','$end_date','activation')";
        mysql_query($qry_amt_insert);



        foreach ($_POST['fare'] as $row => $fare) {
            $fare = $fare;
            $colonyA = $_POST['colonyA'][$row];
            $colonyB = $_POST['colonyB'][$row];
            $currentRowStatus = $_POST['currentRowStatus'][$row];

            if ($currentRowStatus == 9) {
                $qryCol = "insert into `corporate_colony` (`corporate_id`,`colonyA`,`colonyB`,`fare`,`added_on`,`added_by`) values ('$logId','" . $colonyA . "','$colonyB','$fare','$added_on','" . $_SESSION['uid'] . "')";
                mysql_query($qryCol);
            }
        }
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Administrador cororativo agregado correctamente</div>';
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email Id Already El Email ya existe en el sistema</div>';
    }
}

function updateTaxiCompanyLoginDetails() {
    global $objCommon;
    $err_string = "";
    $error = false;
    $u_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $updated_on = date('Y-m-d H:i:g');
    if ($new_password != '') {
        $getOldPassword = mysql_fetch_array(mysql_query("select * from `login` where 1 and id = '" . $_SESSION['uid'] . "'"));
        if (md5($u_password) == $getOldPassword['password']) {
            $new_password = md5($new_password);
            $qryP = "update `login` set password='$new_password',updated_on='$updated_on',updated_by='" . $_SESSION['uid'] . "' where 1 and id = '" . $_SESSION['uid'] . "'";
            mysql_query($qryP);
            $qryP1 = "update `login` set password='$new_password',updated_on='$updated_on',updated_by='" . $_SESSION['uid'] . "' where 1 and id = '" . $_SESSION['uid'] . "'";
            mysql_query($qryP1);
            echo '1';
        } else {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Your current password not correct</div>';
        }
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>New password should not be empty</div>';
    }
    //die();
}

// -- Taxi Company Administrator Coding End Here---
// -- Corporate Administrator Coding Here---

function addCorporateUser() {
    // print_r($_POST); //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer 
    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $email = $_POST['emailID'];
    $contact = $_POST['contact'];
    $city = $_POST['city'];
    $zipCode = $_POST['zipCode'];
    $creditLimit = $_POST['creditLimit'];
    $creditLimitPerDay = $_POST['creditLimitPerDay'];
    $username = $_POST['username'];
    $blockUser = $_POST['blockUser'];
    $password = md5($_POST['password']);
    $password_de = $_POST['password'];
    $added_on = date('Y-m-d H:i:g');
    $account_type = '99';


    $checkEmail = mysql_query("select * from `users` where 1 and email_id = '" . $email . "'");
    if (mysql_num_rows($checkEmail) == 0) {
        $query = "SELECT begning_credit FROM `corporate` WHERE web_user_id ='" . $_SESSION['uid'] . "' LIMIT 0 , 30";
        $result = mysql_query($query);
        $amount = 0;
        if ($row = mysql_fetch_array($result)) {
            $amount = $row['begning_credit'];
        }
        $query_user_amt = mysql_query("select credit_limit  from `users` where 1 and corporate_id = '" . $_SESSION['uid'] . "'");
        $rows = mysql_num_rows($query_user_amt);
        $noitems = 0;
        while ($info = mysql_fetch_array($query_user_amt)) {
            $numberitems = explode(',', $info['credit_limit']);
            //$numberitems_per_day = explode(',',$info['credit_limit_per_day']);
            for ($i = 0; $i < $rows; $i++) {
                $noitems += $creditLimit + $numberitems[$i];
            }
        }
        $accutualAmtPerDay = $creditLimitPerDay >= $creditLimit;
        $accutualAmt = $noitems > $amount;
        if ($accutualAmt && $accutualAmtPerDay) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Your credit limit is not enough</div>';
        } else {
            $query = mysql_query("select * from `corporate` where 1 and web_user_id = '" . $email . "'");
            $num = mysql_num_rows($query);
            if ($num == 0) {
                //$qryP1 = "insert into `login` (`name`,`email`,`password`,`contact_number`,`account_type`,`added_on`,`added_by`,`login_status`,`status`) values ('$name','$email','$password','$contact','$account_type','$added_on','".$_SESSION['uid']."','0','200')";
                //mysql_query($qryP1); 
                //$logId = mysql_insert_id();
                //$qryP1 = "insert into `users` (`corporate_id`,`name`,`email_id`,`contact_no`,`city`,`zip_code`,`credit_limit`,`credit_limit_per_day`,`username`,`password`,`status`,`account_type`,`blockUser`,`added_on`,`added_by`,`web_user_id`) values ('".$_SESSION['uid']."','$name','$email','$contact','$city','$zipCode','$creditLimit','$creditLimitPerDay','$username','$password','200','$account_type','$blockUser','$added_on','".$_SESSION['uid']."','$logId')";
                $qryP1 = "insert into `users` (`corporate_id`,`name`,`email_id`,`contact_no`,`credit_limit`,`credit_limit_per_day`,`username`,`password`,`status`,`account_type`,`blockUser`,`added_on`,`added_by`,`web_user_id`,`password_de`) values ('" . $_SESSION['uid'] . "','$name','$email','$contact','$creditLimit','$creditLimitPerDay','$username','$password','200','$account_type','$blockUser','$added_on','" . $_SESSION['uid'] . "','$logId','$password_de')";
                mysql_query($qryP1);
                $last_id = mysql_insert_id();

                $qry_manage_master = "insert into `manage_master_amount` (`crop_mb_u_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`) values ('$last_id','" . $_SESSION['uid'] . "','credit_amount','$creditLimit','" . $_SESSION['uid'] . "','$added_on')";
                mysql_query($qry_manage_master);
                // For send mail
                $to = $email;
                $to_name = $name;
                $from = FROM_ADMIN_EMAIL_ID;
                $from_name = FROM_ADMIN_NAME;
                $reply_to = REPLY_ADMIN_EMAIL_ID;
                $reply_name = REPLY_ADMIN_NAME;
                $subject = "Account Created in Central Taxi";
                $message = "Account (corporate user) has been created with this email. For any questions contact us at our email.";
                $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);

                echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>User added successfully</div>';
            } else {
                echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>The Email already exists in the system</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>The Email already exists in the system, please enter another</div>';
    }
}

function updateCorporateUser() {
    //echo "<script>alert('ok')</script>";
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer die;
    global $objCommon;
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $email = $_POST['emailID'];
    $oldEmail = $_POST['oldEmail'];
    $contact = $_POST['contact'];
    // $city = $_POST['city'];
    // $zipCode = $_POST['zipCode'];
    $creditLimit = $_POST['creditLimit'];
    $creditLimitPerDay = $_POST['creditLimitPerDay'];
    $username = $_POST['username'];
    $blockUser = $_POST['blockUser'];

    $password = md5($_POST['password']);
    $newpassword = md5($_POST['newpassword']);
    $password_de = $_POST['password'];
    $password_new_de = $_POST['newpassword'];

    $added_on = date('Y-m-d H:i:s');
    $account_type = '99';
    $userId = $_POST['userId'];
    $Idd = $_POST['Idd'];

    if ($password_new_de == '') {

        $getOldPassword = mysql_fetch_array(mysql_query("select * from `users` where 1 and id = '$Idd'"));
        $password = md5($getOldPassword['password_de']);
        $password_de = $getOldPassword['password_de'];
        //echo $getOldPassword['password_de'].'<br/>';
    } else {

        $password = md5($_POST['newpassword']);
        $password_de = $_POST['newpassword'];
    }

    if ($email != $oldEmail) {
        $checkEmail = "select * from users where email_id='" . $email . "'";
        $resEmail = mysql_query($checkEmail) or die(mysql_error());
        if (mysql_affected_rows() > 0) {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-Id already exists. Please use other Email-Id</div>';
        } else {
            //$str="update `users` set `name`='$name',`email_id`='$email',`contact_no`='$contact',`credit_limit`='$creditLimit',`credit_limit_per_day`='$creditLimitPerDay',`username`='$username',`password`='$newpassword',`password_de`='$password_new_de',`blockUser`='$blockUser' where id='$Idd'";
            //$res=mysql_query($str);


            $str = "update `users` set `name`='$name',`email_id`='$email',`contact_no`='$contact',`username`='$username',`password`='$password',`password_de`='$password_de',`blockUser`='$blockUser' where id='$Idd'";
            $res = mysql_query($str);

            $qry_manage_master = "insert into `manage_master_amount` (`crop_mb_u_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`) values ('$Idd','" . $_SESSION['uid'] . "','credit_amount','$creditLimit','" . $_SESSION['uid'] . "','$added_on')";
            mysql_query($qry_manage_master);
            if ($res) {
                echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>User Updated Successfully.</div>';
            } else {
                echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error in coding</div>';
            }
        }
    } else {
        // $str="update `users` set `name`='$name',`email_id`='$email',`contact_no`='$contact',`credit_limit`='$creditLimit',`credit_limit_per_day`='$creditLimitPerDay',`username`='$username',`password`='$newpassword',`password_de`='$password_new_de',`blockUser`='$blockUser' where id='$Idd'";
        //$res=mysql_query($str);

        $str = "update `users` set `name`='$name',`email_id`='$email',`contact_no`='$contact',`username`='$username',`password`='$password',`password_de`='$password_de',`blockUser`='$blockUser' where id='$Idd'";
        $res = mysql_query($str);

        $qry_manage_master = "insert into `manage_master_amount` (`crop_mb_u_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`) values ('$Idd','" . $_SESSION['uid'] . "','credit_amount','$creditLimit','" . $_SESSION['uid'] . "','$added_on')";
        mysql_query($qry_manage_master);

        if ($res) {
            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>User Updated Successfully.</div>';
        } else {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Error in coding</div>';
        }
    }
}

function updatePasswordCorporate() {
    //print_r($_POST);
    global $objCommon;
    $oldPassword = md5($_POST['oldPassword']);
    $newPassword = md5($_POST['newPassword']);
    $Idd = $_POST['b'];


    if ($oldPassword != '') {


        $query = mysql_fetch_array(mysql_query("select * from `login` where 1 and id = $Idd"));
        if ($query['password'] == $oldPassword) {

            $password = '`password`="' . $newPassword . '"';
            $qryP1 = "update `login` set $password where 1 and id = '" . $Idd . "'";
            mysql_query($qryP1);
            echo '1';
        } else {
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Old Password not match</div>';
        }
    }
}

// create zone code here

function createzoneCordinated() {
    //echo '<pre>';
    //print_r($_POST);
    //echo '</pre>';
    $map_title = base64_encode($_POST['map_title']);
    $map_description = base64_encode($_POST['map_description']);
    $map_center_lat = $_POST['map_center_lat'];
    $map_center_lng = $_POST['map_center_lng'];
    $map_zoom = $_POST['map_zoom'];
    $map_typeid = $_POST['map_typeid'];
    $map_Lineid = $_POST['map_Lineid'];
    $map_Polygonid = $_POST['map_Polygonid'];
    $map_Rectangleid = $_POST['map_Rectangleid'];
    $map_Circleid = $_POST['map_Circleid'];
    $added_on = date('Y-m-d H:i:g');


    $query = "select * from `zone_area` where 1 and `zone_title` = '" . $map_title . "'";
    $res = mysql_query($query);
    $nums = mysql_num_rows($res);
    if ($nums == 0) {
        $quy = "insert into `zone_area` (`zone_title`,`zone_description`,`added_by`,`added_on`,`status`) values ('$map_title','$map_description','" . $_SESSION['uid'] . "','$added_on','200')";
        $result = mysql_query($quy);
        $zone_area_id = mysql_insert_id();

        //rect_title , rect_coords
        for ($i = 0; $i <= $map_Rectangleid; $i++) {
            $rect_title = $_POST['rect_title'][$i];
            $rect_coords = $_POST['rect_coords'][$i];
            if ($rect_coords != '' || $rect_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$rect_title','$rect_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','reactangle','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        //circle_title , circle_coords
        for ($j = 0; $j <= $map_Circleid; $j++) {
            $circle_title = $_POST['circle_title'][$j];
            $circle_coords = $_POST['circle_coords'][$j];
            if ($circle_coords != '' || $circle_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$circle_title','$circle_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','circle','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        // line_title , line_coords
        for ($k = 0; $k <= $map_Lineid; $k++) {
            $line_title = $_POST['line_title'][$k];
            $line_coords = $_POST['line_coords'][$k];
            if ($line_coords != '' || $line_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$line_title','$line_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','line','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        // poly_title , poly_coords
        for ($l = 0; $l <= $map_Polygonid; $l++) {
            $poly_title = $_POST['poly_title'][$l];
            $poly_coords = $_POST['poly_coords'][$l];
            if ($poly_coords != '' || $poly_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>&aacute;rea de la zona ha a&ntilde;adido correctamente</div>';
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Zone area name already exists. Please use another name</div>';
    }
}

// zone code end here


function createzoneCordinatedWithAdministrator() {
    ///echo '<pre>';
    //print_r($_POST);
    //echo '</pre>';

    $administratorId = $_POST['administratorId'];
    //    $added_on = date('Y-m-d H:i:g');

    $map_title = base64_encode($_POST['map_title']);
    $map_description = base64_encode($_POST['map_description']);
    $map_center_lat = $_POST['map_center_lat'];
    $map_center_lng = $_POST['map_center_lng'];
    $map_zoom = $_POST['map_zoom'];
    $map_typeid = $_POST['map_typeid'];
    $map_Lineid = $_POST['map_Lineid'];
    $map_Polygonid = $_POST['map_Polygonid'];
    $map_Rectangleid = $_POST['map_Rectangleid'];
    $map_Circleid = $_POST['map_Circleid'];
    $added_on = date('Y-m-d H:i:g');

    $zonId = $administratorId;

    $quy = "insert into `zone_area` (`allot_to`,`zone_title`,`zone_description`,`added_by`,`added_on`,`status`) values ('$zonId','$map_title','$map_description','" . $_SESSION['uid'] . "','$added_on','200')";
    $result = mysql_query($quy);
    $zone_area_id = mysql_insert_id();



    // For send mail
    $zone_admin_mail_id = mysql_fetch_array(mysql_query("SELECT email FROM login WHERE id = $administratorId"));
    $to = $zone_admin_mail_id['email'];
    $to_name = $map_title;
    $from = FROM_ADMIN_EMAIL_ID;
    $from_name = FROM_ADMIN_NAME;
    $reply_to = REPLY_ADMIN_EMAIL_ID;
    $reply_name = REPLY_ADMIN_NAME;
    $subject = "zone allot ";
    //echo $to.'------'.$to_name;
    $message = "Una cuenta de '" . base64_decode($map_title) . "' (“--------------”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";


    $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);

    //circle_title , circle_coords
    for ($j = 0; $j <= $map_Circleid; $j++) {
        $circle_title = $_POST['circle_title'][$j];
        $circle_coords = $_POST['circle_coords'][$j];
        if ($circle_coords != '' || $circle_title != '') {
            $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$circle_title','$circle_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','circle','" . $_SESSION['uid'] . "','$added_on','200')";
            mysql_query($rect_query);
        }
    }
    // line_title , line_coords
    for ($k = 0; $k <= $map_Lineid; $k++) {
        $line_title = $_POST['line_title'][$k];
        $line_coords = $_POST['line_coords'][$k];
        if ($line_coords != '' || $line_title != '') {
            $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$line_title','$line_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','line','" . $_SESSION['uid'] . "','$added_on','200')";
            mysql_query($rect_query);
        }
    }
    // poly_title , poly_coords
    for ($l = 0; $l <= $map_Polygonid; $l++) {
        $poly_title = $_POST['poly_title'][$l];
        $poly_coords = $_POST['poly_coords'][$l];
        if ($poly_coords != '' || $poly_title != '') {
            $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','" . $_SESSION['uid'] . "','$added_on','200')";
            mysql_query($rect_query);
        }
    }
    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Adminsitrador de Zona agregado correctamente</div>';
    HTMLRedirectURL(SUPER_ADMIN_URL . 'administrators.php');
}

function updatezoneCordinatedWithAdministrator() {
    $zoneId = $_POST['zoneId'];
    $cordinateId = $_POST['cordinateId'];
    $administratorId = $_POST['administratorId'];
    $account_type = '2';
    $added_on = date('Y-m-d H:i:g');
    $updated_on = date('Y-m-d H:i:g');

    $map_title = base64_encode($_POST['map_title']);
    $map_description = base64_encode($_POST['map_description']);
    $map_center_lat = $_POST['map_center_lat'];
    $map_center_lng = $_POST['map_center_lng'];
    $map_zoom = $_POST['map_zoom'];
    $map_typeid = $_POST['map_typeid'];

    $map_Lineid = $_POST['map_Lineid'];
    if ($map_Lineid == '' || $map_Lineid == null) {
        $map_Lineid = '0';
    }

    $map_Polygonid = $_POST['map_Polygonid'];
    if ($map_Polygonid == '' || $map_Polygonid == null) {
        $map_Polygonid = '0';
    }

    $map_Rectangleid = $_POST['map_Rectangleid'];
    if ($map_Rectangleid == '' || $map_Rectangleid == null) {
        $map_Rectangleid = '0';
    }

    $map_Circleid = $_POST['map_Circleid'];
    if ($map_Circleid == '' || $map_Circleid == null) {
        $map_Circleid = '0';
    }

    $checkEmail = mysql_query("select * from `login` where 1 and `id` = '" . $_SESSION['uid'] . "'");
    if (mysql_num_rows($checkEmail) == 0) {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-Id not exists. Please use correct  zone administrator Email-Id</div>';
    } else {
        $qryDelete = mysql_query("delete from `zone_cordinater`  where 1 and zone_area_id='" . $zoneId . "'");
        $qryDelete = mysql_query("delete from `zone_area`  where 1 and id='" . $zoneId . "'");

        $quy = "insert into `zone_area` (`allot_to`,`zone_title`,`zone_description`,`added_by`,`added_on`,`status`) values ('$administratorId','$map_title','$map_description','" . $_SESSION['uid'] . "','$added_on','200')";



        //$quy = "update `zone_area` set `zone_title`='$map_title',`zone_description`='$map_description',`updated_by`='".$_SESSION['uid']."',`updated_on`='$updated_on',`allot_to` = '$administratorId' where 1 and id='".$cordinateId."'";
        $result = mysql_query($quy);
        $zone_area_id = mysql_insert_id();

        // Update Taxi company detail by zone area according
        //$all_taxi_zone = "SELECT * FROM taxicompany where zone"
        $update_taxicom = "UPDATE  `taxicompany` SET  `added_by` =  '$administratorId',`zone_area_id_sess` =  '$zone_area_id' WHERE  `zone_area_id_sess` =  '$cordinateId'";
        mysql_query($update_taxicom);

        //circle_title , circle_coords
        for ($j = 0; $j <= $map_Circleid; $j++) {
            $circle_title = $_POST['circle_title'][$j];
            $circle_coords = $_POST['circle_coords'][$j];
            if ($circle_coords != '' || $circle_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$circle_title','$circle_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','circle','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        // line_title , line_coords
        for ($k = 0; $k <= $map_Lineid; $k++) {
            $line_title = $_POST['line_title'][$k];
            $line_coords = $_POST['line_coords'][$k];
            if ($line_coords != '' || $line_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$line_title','$line_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','line','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        // poly_title , poly_coords
        for ($l = 0; $l <= $map_Polygonid; $l++) {
            $poly_title = $_POST['poly_title'][$l];
            $poly_coords = $_POST['poly_coords'][$l];
            if ($poly_coords != '' || $poly_title != '') {
                $rect_query = "insert into `zone_cordinater` (`zone_area_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zone_area_id','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','" . $_SESSION['uid'] . "','$added_on','200')";
                mysql_query($rect_query);
            }
        }
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Zone Administrator Updated Successfully Chanages may take up to 24hs to take effect.</div>';
        HTMLRedirectURL(SUPER_ADMIN_URL . 'work-zone.php');
    }
}

function saveColoniess() {
    //echo '<pre>';
    //print_r($_POST);
    //echo '</pre>';
    $colonyNameA = $_POST['colonyNameA'];
    $colonyNameB = $_POST['colonyNameB'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $end_street_number = $_POST['end_street_number'];
    $end_city = $_POST['end_city'];
    $end_state = $_POST['end_state'];
    $end_postal_code = $_POST['end_postal_code'];
    $end_latitude = $_POST['end_latitude'];
    $end_longitude = $_POST['end_longitude'];
    $start_street_number = $_POST['start_street_number'];
    $start_city = $_POST['start_city'];
    $start_state = $_POST['start_state'];
    $start_postal_code = $_POST['start_postal_code'];
    $start_latitude = $_POST['start_latitude'];
    $start_longitude = $_POST['start_longitude'];
    $totalDistanceInKM = $_POST['totalDistanceInKM'];
    $fare = $_POST['fare'];
    $added_on = date('Y-m-d H:i:g');

    $query = "insert into `colony` (`name_A`,`name_B`,`description`,`a_address`,`b_address`,`a_city`,`a_state`,`a_postal_code`,`a_latitude`,`a_longitude`,`b_city`,`b_state`,`b_postal_code`,`b_latitude`,`b_longitude`,`fare`,`km_distance`,`taxi_company_id`,`addded_by`,`added_on`) values ('$colonyNameA','$colonyNameB','description','$start','$end','$start_city','$start_state','$start_postal_code','$start_latitude','$start_longitude','$end_city','$end_state','$end_postal_code','$end_latitude','$end_longitude','$fare','$totalDistanceInKM','" . $_SESSION['uid'] . "','" . $_SESSION['uid'] . "','$added_on')";
    mysql_query($query);
    echo '1';
    die;
}

function updateeCorporateCompany() {
    //echo '<pre>';
    //print_r($_POST); //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    //echo '</pre>';
    global $objCommon;
    $logIDD = $_POST['logIDD'];
    $corIDD = $_POST['corIDD'];
    $err_string = "";
    $error = false;
    $name = $_POST['name'];
    $creditLimit = $_POST['creditLimit'];
    $agreement = $_POST['agreement'];
    $email = $_POST['emailID'];
    if ($_POST['password'] == '**********') {
        $password = md5($_POST['password_old']);
        $new_password = $_POST['password_old'];
    } else {
        $password = md5($_POST['password']);
        $new_password = $_POST['password'];
    }
    $added_on = date('Y-m-d H:i:g');
    $account_type = '5';

    $qryP1 = "update `login` set `name` = '$name',`email`='$email', `password` = '$password', `password_de` = '$new_password' where 1 and id='" . $logIDD . "'";
    mysql_query($qryP1);
    $logId = mysql_insert_id();
    $qryP1 = "update `corporate` set `name`='$name',`agreement_id`='$agreement' where 1 and id = '" . $corIDD . "'";
    mysql_query($qryP1);

    $qry_amt_update = "insert into `manage_master_amount` (`company_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`) 
                values ('" . $_SESSION['uid'] . "','$corIDD','credit_amount','$creditLimit','" . $_SESSION['uid'] . "','$added_on')";
    mysql_query($qry_amt_update);

    $deleCol = mysql_query('delete from `corporate_colony` where 1 and corporate_id="' . $logIDD . '"');
    foreach ($_POST['fare'] as $row => $fare) {
        $fare = $fare;
        $colonyA = $_POST['colonyA'][$row];
        $colonyB = $_POST['colonyB'][$row];
        $currentRowStatus = $_POST['currentRowStatus'][$row];

        if ($currentRowStatus == 9) {
            $qryCol = "insert into `corporate_colony` (`corporate_id`,`colonyA`,`colonyB`,`fare`,`added_on`,`added_by`) values ('" . $logIDD . "','" . $colonyA . "','$colonyB','$fare','$added_on','" . $_SESSION['uid'] . "')";
            mysql_query($qryCol);
        }
    }
    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Administrador corporativo actualizado correctamente</div>';
}

/* By Zone Admin add payment for taxi company
  BY Ashutosh Khare
 * * */

function addTaxiCompanyPayment() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    //$from_date = date('Y-m-d',strtotime($_POST['fromDate']));
    //$toDate = date('Y-m-d',strtotime($_POST['toDate']));
    $amount = $_POST['txtamount'];
    $companyId = $_POST['selComName'];
    $amttype = $_POST['selAmtType'];
    $message = $_POST['txtMessage'];

    $added_on = date('Y-m-d H:i:g');
    //print_r($_POST);die;
    // get Last inserted date
    $query_last_date = mysql_fetch_array(mysql_query("SELECT * FROM manage_master_amount where end_date_time!='0000-00-00'    AND corporate_id ='$corIDD' ORDER BY id DESC LIMIT 1"));
    $last_date = $query_last_date['end_date_time'];
    //$start_date = date('Y-m-d', strtotime('+1 days'));

    $start_date = date('Y-m-d', strtotime($last_date . " + 1 days"));
    $end_date = date('Y-m-d', strtotime($last_date . " + 7 days"));
    if (isset($_POST) && $_POST['txtamount']) {
        $qry_amt_insert = "insert into `manage_master_amount` (`zone_id`,`company_id`,`type`,`amount`,`added_by`,`added_on`,`start_date`, `end_date_time`,`amount_type`,`message`) 
	    values ('" . $_SESSION['uid'] . "','$companyId','credit_amount','$amount','" . $_SESSION['uid'] . "','$added_on','$start_date','$end_date','$amttype','$message')";
        mysql_query($qry_amt_insert);
        $last_id = mysql_insert_id();


        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Amount Updated successfully</div>';
        HTMLRedirectURL(ZONE_URL . 'payement_print.php?id=' . base64_encode($companyId));
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Amount Not insert!</div>';
    }
    //die();
}

function amountComfirmToTaxtidriver() {
    global $objCommon;
    $err_string = "";
    $error = false;
    //echo '<pre>';print_r($_POST);die;
    foreach ($_POST['trip_id'] as $key => $value) {
        $trip_id = $value;
        $amount = $_POST['amount'][$key];
        $driver_id = $_POST['driver_id'][$key];
        $corporateId = $_POST['corporateId'][$key];
        $added_on = date('Y-m-d H:i:g');

        $qryCol = "insert into `driver_trip_payment` (`driver_id`,`trip_id`,`amount`,`corporate_id`,`added_by`,`added_on`) values ('$driver_id','$trip_id','$amount','$corporateId','" . $_SESSION['uid'] . "','$added_on')";
        mysql_query($qryCol);

        $query_update_trip = "UPDATE `trip` set payment_to_driver='500' where 1 and trip.id = '$trip_id'";
        mysql_query($query_update_trip);
    }
}

function addCorporateAmount() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $corIDD = $_POST['selCorName'];
    $amount = $_POST['txtamount'];
    $message = $_POST['txtMessage'];
    $added_on = date('Y-m-d H:i:g');

    // get Last inserted date
    $query_last_date = mysql_fetch_array(mysql_query("SELECT * FROM manage_master_amount where end_date_time!='0000-00-00' AND corporate_id ='$corIDD' ORDER BY id DESC LIMIT 1"));
    $last_date = $query_last_date['end_date_time'];
    //$start_date = date('Y-m-d', strtotime('+1 days'));

    $start_date = date('Y-m-d', strtotime($last_date . " + 1 days"));
    $end_date = date('Y-m-d', strtotime($last_date . " + 7 days"));

    if (isset($_POST) && $_POST['selCorName']) {
        $qry_amt_update = "insert into `manage_master_amount` (`company_id`,`corporate_id`,`type`,`amount`,`added_by`,`added_on`,`message`,`start_date`,`end_date_time`,`amount_type`) 
                values ('" . $_SESSION['uid'] . "','$corIDD','credit_amount','$amount','" . $_SESSION['uid'] . "','$added_on','$message','$start_date','$end_date','payment')";
        mysql_query($qry_amt_update);

        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Amount Updated successfully</div>';
        HTMLRedirectURL(ZONE_URL . 'account-status.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Amount Not insert!</div>';
    }
    //die();
}

function solvedReportPayment() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $trip_id = $_POST['trip_id'];
    $txtSolved = $_POST['txtSolved'];
    $report_updated_by = $_SESSION['uid'];
    $report_updated_on = date('Y-m-d H:i:g');

    if (isset($_POST) && $_POST['trip_id']) {
        $qry_sloved_update = "update `trip` set `complain_status` = '$txtSolved',`report_updated_by` = '$report_updated_by', `report_updated_on` = '$report_updated_on' where 1 and id='" . $trip_id . "'";
        mysql_query($qry_sloved_update);

        echo '<div class="alert alert-success"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Updated successfully</div>';
        HTMLRedirectURL(ZONE_URL . 'reports.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Not insert!</div>';
    }
    //die();
}

function discardedReportPayment() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $trip_id = $_POST['trip_id'];
    $txtDiscard = $_POST['txtDiscard'];
    $report_updated_by = $_SESSION['uid'];
    $report_updated_on = date('Y-m-d H:i:g');

    if (isset($_POST) && $_POST['trip_id']) {
        $qry_discard_update = "update `trip` set `complain_status` = '$txtDiscard',`report_updated_by` = '$report_updated_by', `report_updated_on` = '$report_updated_on' where 1 and id='" . $trip_id . "'";
        mysql_query($qry_discard_update);

        echo '<div class="alert alert-success"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Updated successfully</div>';
        HTMLRedirectURL(ZONE_URL . 'reports.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Not insert!</div>';
    }
    //die();
}

function panicClose() {
    error_reporting(0);
    //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
    global $objCommon;
    $err_string = "";
    $error = false;
    $trip_id = $_POST['trip_id'];
    $txtPanicClose = $_POST['txtPanicClose'];
    $panic_updated_by = $_SESSION['uid'];
    $panic_updated_on = date('Y-m-d H:i:g');

    if (isset($_POST) && $_POST['trip_id']) {
        $qry_discard_update = "update `trip` set `panic_close` = '$txtPanicClose',`panic_updated_by` = '$panic_updated_by', `panic_updated_on` = '$panic_updated_on' where 1 and id='" . $trip_id . "'";
        mysql_query($qry_discard_update);

        echo '<div class="alert alert-success"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Updated successfully</div>';
        HTMLRedirectURL(ZONE_URL . 'alerts.php');
    } else {
        echo '<div class="alert alert-danger"><button class="close errorMessage" data-dismiss="alert" type="button">x</button>Amount Not insert!</div>';
    }
    //die();
}

function createzoneCordinatedForDriver() {
    //error_reporting(0);
    $zoneAreaId = $_GET['map_id'];

    $map_center_lat = $_POST['map_center_lat'];
    $map_center_lng = $_POST['map_center_lng'];
    $map_zoom = $_POST['map_zoom'];
    $map_typeid = $_POST['map_typeid'];
    $map_Lineid = $_POST['map_Lineid'];
    $map_Polygonid = $_POST['map_Polygonid'];
    $map_Rectangleid = $_POST['map_Rectangleid'];
    $map_Circleid = $_POST['map_Circleid'];
    $added_on = date('Y-m-d H:i:g');

    $query_zone_id = mysql_fetch_array(mysql_query("SELECT web_user_id,zone_area_id_sess FROM taxicompany WHERE web_user_id = '" . $_SESSION['uid'] . "'"));

    $query_for_zone_codinate = mysql_fetch_array(mysql_query("SELECT zone_area_id ,cordinated FROM zone_cordinater WHERE zone_area_id = '" . $query_zone_id['zone_area_id_sess'] . "'"));

    //echo $zoneAreaId;
    $query_driver_codi = "SELECT * FROM zone_cordinater_driver WHERE zone_area_dr_id='$zoneAreaId'";
    //$query_driver_codi ="SELECT a.*, b.*,c.*, c.id as driverID FROM zone_cordinater_driver as a LEFT JOIN taxicompany as b ON a.zone_area_dr_id = b.zone_area_id_sess LEFT JOIN driver as c ON b.web_user_id = c.company_id WHERE zone_area_dr_id='$zoneAreaId'";
    $resu_driver_cord = mysql_query($query_driver_codi);
    $num_rows = mysql_num_rows($resu_driver_cord);
    while ($dataDri = mysql_fetch_array($resu_driver_cord)) {
        $cordiee = $dataDri['cordinate_title'];
        $array_d_title[] = $cordiee;
        $dataDri['driverID'];
    } 

    for ($l = 0; $l <= count($_POST['poly_title']); $l++) {
        //echo $_POST['cordinateId_Main_Zone'][$l];
        if ($_POST['cordinateId_Main_Zone'][$l] != '') {
            $qry_zone_update = "UPDATE `zone_cordinater_driver` set `cordinate_title` = '" . $_POST['poly_title'][$l] . "',`cordinated` = '" . $_POST['poly_coords'][$l] . "', `updated_on` = '$added_on' where 1 and zone_area_dr_id='" . $_POST['cordinateId_Main_Zone'][$l] . "'";
            mysql_query($qry_zone_update);
        } else {

            $poly_title = $_POST['poly_title'][$l];
            $poly_coords = $_POST['poly_coords'][$l];

            if ($poly_coords != '' || $poly_title != '') {

                // code start by nj
                $data1 = $query_for_zone_codinate['cordinated'];
                $arr = explode(",", $data1);
                $arr = str_replace("(", "", $arr);
                $arr = str_replace(")", "", $arr);
                //print_r($arr);echo'<br/>';
                //echo count($arr);
                //(22.712115783657264, 75.83186798095699),(22.747265000632
                for ($b = 0; $b < count($arr); $b++) {
                    if ($b == '0' || $b % 2 == '0') {
                        $axis_x[] = $arr[$b];
                    } else {
                        $axis_y[] = $arr[$b];
                    }
                }
                $vertices_x = $axis_x;
                $vertices_y = $axis_y; // y-coordinates of the vertices of the polygon
                $points_polygon = count($vertices_x); // number vertices
                $njArr = explode('),(', $poly_coords);
                // echo count($njArr).'--count number ---<br/>';
                $nj_Msg = '';
                for ($k = 0; $k < count($njArr); $k++) {
                    $njArr[$k] = str_replace("(", "", $njArr[$k]);
                    $njArr[$k] = str_replace(")", "", $njArr[$k]);
                    $exp_cord = explode(', ', $njArr[$k]);
                    //echo $njArr[$k].'<br/>';
                    $longitude_x = $exp_cord[0]; //22.7677003978487; //22.684873419893734; // 37.62850;
                    $latitude_y = $exp_cord[1]; // 75.8815320203064;// 75.84284667935776;//-77.4499;  22.744807,75.877511

                    if (is_in_polygon__by_Nj($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)) {
                        $nj_Msg = '1'; // echo "Is in polygon!";
                    } else {
                        $nj_Msg = '0'; //else echo "Is not in polygon";	
                    }
                }
                $forzone = $_POST['chkFarbidden'];
                // if(isset($forzone) && $nj_Msg == 1){
                if (($_POST['chkFarbidden'] == 1) && ($nj_Msg == 1)) {

                    $rect_query1 = "insert into `zone_cordinater_driver` (`zone_area_dr_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`,`forbidden_zone`) values ('$zoneAreaId','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','" . $_SESSION['uid'] . "','$added_on','200','1')";
                    mysql_query($rect_query1);

                    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Zona prohibida agregado con &eacute;xito</div>';
                } elseif ($nj_Msg == 1) {
                    $rect_query = "insert into `zone_cordinater_driver` (`zone_area_dr_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zoneAreaId','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','" . $_SESSION['uid'] . "','$added_on','200')";
                    mysql_query($rect_query);

                    echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Subzona agregado con &eacute;xito</div>';
                } else {
                    echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Fuera, en la zona es de pol&iacute;gonos</div>';
                }



                die;
                // code end by nj
                /*
                  $pointLocation = new pointLocation();
                  $latlng = $poly_coords;
                  $points_main = $latlng;
                  $points1=str_replace("),(","/",$points_main);
                  $points2 = str_replace(",","",$points1);
                  $points5 = str_replace("(","",$points2);
                  $points6 = str_replace(")","",$points5);
                  $points33 = explode("/",$points6);

                  $points = $points33;
                  //echo'points :';print_r($points);
                  // for points matching in database
                  $points_match = str_replace("/",",",$points6);

                  $data1= $query_for_zone_codinate['cordinated'];

                  $data=str_replace("),(","/",$data1);
                  $data2 = str_replace(",","",$data);
                  $data5 = str_replace("(","",$data2);
                  $data6 = str_replace(")","",$data5);

                  $data3 = explode("/",$data6);

                  $polygon = $data3;
                  //	echo'polygon :';print_r($polygon);
                  foreach($points as $key => $point) {
                  $polytitleee[] = $_POST['poly_title'][$l];
                  $string =  $pointLocation->pointInPolygon($point, $polygon);
                  //echo 'String : ';
                  //	print_r($string);
                  if($string == 'inside'){
                  //echo 'in Poly';
                  $rect_query = "insert into `zone_cordinater_driver` (`zone_area_dr_id`,`cordinate_title`,`cordinated`,`map_center_latitude`,`map_center_longitude`,`map_zoom`,`map_type`,`zone_type`,`added_by`,`added_on`,`status`) values ('$zoneAreaId','$poly_title','$poly_coords','$map_center_lat','$map_center_lng','$map_zoom','$map_typeid','polygon','".$_SESSION['uid']."','$added_on','200')";
                  mysql_query($rect_query);

                  echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Sub zone Added Successfully</div>';
                  break 2;
                  HTMLRedirectURL(TAXI_URL);
                  }
                  else{
                  echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Sub zone is Outside in polygon</div>';
                  break 2;
                  }

                  }
                 */
            }
        }
        // gcm notification --
        $query_driver_codi = "SELECT a.*, b.*,c.*, c.id as driverID FROM zone_cordinater_driver as a LEFT JOIN taxicompany as b ON a.zone_area_dr_id = b.zone_area_id_sess LEFT JOIN driver as c ON b.web_user_id = c.company_id WHERE zone_area_dr_id='$zoneAreaId'";
        $resu_driver_cord = mysql_query($query_driver_codi);
        $num_rows = mysql_num_rows($resu_driver_cord);
        while ($dataDri = mysql_fetch_array($resu_driver_cord)) {
            $contents['cordinated'] = $dataDri['cordinated'];
            // $dataDri['driverID']; 

            $deviceToken = $dataDri['device_id'];
            $registatoin_ids = array($deviceToken);
            $message = array("zoneUpdate" => $contents);
            send_notification($registatoin_ids, $message);
        }
        HTMLRedirectURL(TAXI_URL);
    }
}

function is_in_polygon__by_Nj($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y) {
    $i = $j = $c = 0;
    for ($i = 0, $j = $points_polygon - 1; $i < $points_polygon; $j = $i++) {
        if ((($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
                ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])))
            $c = !$c;
    }
    return $c;
}

// zone araer session
function verifyZoneAreaSession() {
    if (!isset($_SESSION['zoneArea'])) {
        HTMLRedirectURL(ZONE_URL . 'index.php');
    }
}

// for current tine get mopbile application
function getCurrentTimezone($gmt_time) {
    $offset = $gmt_time;
    list($hours, $minutes) = explode(':', $offset);
    $seconds = $hours * 60 * 60 + $minutes * 60;
    $tz = timezone_name_from_abbr('', $seconds, 1);
    if ($tz === false)
        $tz = timezone_name_from_abbr('', $seconds, 0);
    date_default_timezone_set($tz);

    $date_time = date('Y-m-d H:i:s');
    //return $tz.','.$date_time;
    $arr['tz'] = $tz;
    $arr['date'] = date('Y-m-d', strtotime($date_time));
    $arr['time'] = date('H:i:s', strtotime($date_time));
    $arr['date_time'] = $date_time;

    return $arr;
}

function message_new() {

    global $objConnect;
    global $objCommon;
    $type = $_REQUEST['sendMessage'];
    $added_on = date('Y-m-d H:i:s');
    $driverName = $_REQUEST['selDriverName'];

    $corpName = $_REQUEST['selCorName'];
    $taxiName = $_REQUEST['selCentralName'];
    $corpUser = $_REQUEST['selUsersName'];
    $added_by = $_SESSION['uid'];
    $messageHeading = $_REQUEST['txtHeading'];
    $optional_check = $_REQUEST['getOptional'];
    $sentMessage = base64_encode($_REQUEST['sentMessage']);
    if ($_REQUEST['searchAddress'] == '') {
        $latitude = '23.77717633993925';
        $longitude = '-102.51548767089844';
        $searchAddress = 'Mexico City';
    } else {
        $latitude = $_REQUEST['latitude'];
        $longitude = $_REQUEST['longitude'];
        $searchAddress = $_REQUEST['searchAddress'];
    }

    if ($driverName == "" and $corpName == "" and $taxiName == "" and $corpUser == "") {
        echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Por favor, seleccione al menos una</div>';
    } else {

        // For driver add
        if ($driverName == '0' && ($driverName != ' ' || $driverName != null)) {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$driverName','driver','all','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
            $last_id = mysql_insert_id();
        } else {
            $getNotify = mysql_fetch_array(mysql_query("select device_id from driver where id ='" . $driverName . "'"));
            $deviceId = $getNotify['device_id'];

            $registatoin_ids = array($deviceId);
            $message = array("administratorMessage" => "New message from zone administrator");
            send_notification($registatoin_ids, $message);

            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$driverName','driver','particular','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
            $last_id = mysql_insert_id();

            $sqlforDri = mysql_fetch_array(mysql_query("SELECT username , name FROM driver WHERE id = '$driverName'"));
            $to = $sqlforDri['username'];
            $to_name = $sqlforDri['name'];
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = FROM_ADMIN_NAME;
            $reply_to = FROM_ADMIN_NAME;
            $reply_name = FROM_ADMIN_EMAIL_ID;
            $subject = "Zone Admin Message";
            $message = file_get_contents(MAIN_URL . 'email-template/header.php');
            $message .='For : -' . $messageHeading . '</br></br>';
            $message .=$_REQUEST['sentMessage'];
            //$message = "Una cuenta de (“Administrador de Zona”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
            $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


            $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        }

        // For corporation company name add
        if ($corpName == '0' && ($corpName != ' ' || $corpName != null)) {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$corpName','crop','all','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values  ('$corpName','crop','particular','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);

            $sqlforCorCom = mysql_fetch_array(mysql_query("SELECT email , name FROM login WHERE id = '$corpName'"));
            $to = $sqlforCorCom['email'];
            $to_name = $sqlforCorCom['name'];
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = FROM_ADMIN_NAME;
            $reply_to = FROM_ADMIN_NAME;
            $reply_name = FROM_ADMIN_EMAIL_ID;
            $subject = "Zone Admin Message";
            $message = file_get_contents(MAIN_URL . 'email-template/header.php');
            $message .='For : -' . $messageHeading . '</br></br>';
            $message .=$_REQUEST['sentMessage'];
            //$message = "Una cuenta de (“Administrador de Zona”) ha sido creada con este email. Ante cualquier duda contáctenos a nuestro email.";
            $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


            $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        }

        // For taxicompany company name add
        if ($taxiName == '0' && ($taxiName != ' ' || $taxiName != null)) {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values ('$taxiName','compnay','all','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values  ('$taxiName','compnay','particular','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);

            $sqlforTaxiCom = mysql_fetch_array(mysql_query("SELECT email , name FROM login WHERE id = '$taxiName'"));
            $to = $sqlforTaxiCom['email'];
            $to_name = $sqlforTaxiCom['name'];
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = FROM_ADMIN_NAME;
            $reply_to = FROM_ADMIN_NAME;
            $reply_name = FROM_ADMIN_EMAIL_ID;
            $subject = "Zone Admin Message";
            $message = file_get_contents(MAIN_URL . 'email-template/header.php');
            $message .='For : -' . $messageHeading . '</br></br>';
            $message .=$_REQUEST['sentMessage'];
            $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


            $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        }

        // For corporation user add
        if ($corpUser == '0' && ($corpUser != ' ' || $corpUser != null)) {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values  ('$corpUser','cropuser','all','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);
        } else {
            $str = "insert into send_message_new (`user_id`,`user_type`,`message_type`,`heading`,`message`,`added_on`,`added_by`,`zone_area_id`,`get_optional_check`,`latitude`,`longitude`,`location_address`) values  ('$corpUser','cropuser','particular','$messageHeading','$sentMessage','$added_on','$added_by','" . $_SESSION['zoneArea'] . "','$optional_check','$latitude','$longitude','$searchAddress')";
            $res = mysql_query($str);


            $sqlforCorpUser = mysql_fetch_array(mysql_query("SELECT email_id , name FROM users WHERE id = '$corpUser'"));
            $to = $sqlforCorpUser['email_id'];
            $to_name = $sqlforCorpUser['name'];
            $from = FROM_ADMIN_EMAIL_ID;
            $from_name = FROM_ADMIN_NAME;
            $reply_to = FROM_ADMIN_NAME;
            $reply_name = FROM_ADMIN_EMAIL_ID;
            $subject = "Zone Admin Message";
            $message = file_get_contents(MAIN_URL . 'email-template/header.php');
            $message .='For : -' . $messageHeading . '</br></br>';
            $message .=$_REQUEST['sentMessage'];
            $message .= file_get_contents(MAIN_URL . 'email-template/footer.php');


            $mail_status = sendMail($to, $to_name, $from, $from_name, $subject, $message, $reply_to, $reply_name);
        }

        if ($res) {
            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Message inserted successfully</div>';
        } else {
            echo '<div class="alert alert-warning"><button class="close loginError" data-dismiss="alert" type="button">x</button>Coding error</div>';
        }
    }
}

// For create manaual trip 

function addTripManualCorporate() {

    //echo'<pre>';print_r($_POST);
    //echo "SELECT * FROM colony WHERE id = '".$_POST['colonyA']."'";
    // die;
    /* error_reporting(0);
      //1=super admin,2=zone,3=account,4=taxi,5=corporate,99=coprporateUser,7=customer
      global $objCommon;
      $err_string="";
      $error = false;
      $Company_name = $_POST['username'];
      $address = $_POST['startAddress'];
      $city = $_POST['endAddress'];
      $state = $_POST['state'];
      $country = $_POST['country'];
      $emailID = $_POST['emailID'];
      $contactno = $_POST['contactno'];
      $password = md5($_POST['password']);
      $password_de = $_POST['password'];
      $latitude = $_POST['latitude'];
      $longitude = $_POST['longitude'];
      $systemAllow = $_POST['systemAllow'];
      $worklimit = $_POST['worklimit'];
      $per_week_cost = $_POST['per_week_cost'];
      $company_email = $_POST['super_email'];
      $company_name = $_POST['super_name'];
      $systemAllow = $_POST['systemAllow'];



      date_default_timezone_set('asia/kolkata');
      $dateTime=date('Y-m-d H:i:s');
      $desti_city=$_POST['desti_city'];
      $desti_zip=$_POST['desti_zip'];
      $source_country=$_POST['source_country'];

     */
    $getColony = mysql_fetch_array(mysql_query("SELECT * FROM colony WHERE id = '" . $_POST['colonyA'] . "'"));

    $customer_id = $_POST['name'];

    $currentlongitude = '';
    $currentlatitute = '';
    $desti_country = '';
    $tripType = 'corporate';
    $destinationlandmark = $getColony['b_address'];
    $source_state = $getColony['a_state'];
    $destination_lat = $getColony['b_latitude'];
    $companyname = $_POST['companyname'];
    $sourcelongitude = $getColony['a_longitude'];
    $source_city = $getColony['a_city'];
    $sourcelatitute = $getColony['a_latitude'];
    $account_types = '99';
    $destination_address = $getColony['b_address'];
    $sourcelandmark = $getColony['a_address'];
    $description = 'by corpoate';
    $desti_state = $getColony['b_state'];
    $sourceaddress = $getColony['a_address'];
    $destination_lon = $getColony['b_longitude'];

    $getUserDeive = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='" . $customer_id . "'"));
    $device_id = $getUserDeive['device_id'];
    $date_time = date('Y-m-d H:i:s');
    // For referesh Amount
    $queryTotal = mysql_fetch_array(mysql_query("SELECT SUM( amount ) AS totalamt FROM manage_master_amount WHERE crop_mb_u_id = '" . $customer_id . "'"));
    $str1 = "SELECT `trip`.customer_id,`trip`.trip_ammount FROM `trip` where `trip`.customer_id='" . $customer_id . "' and `trip`.payment_mode = 'credit' ";
    $res1 = mysql_query($str1);
    $num1 = mysql_num_rows($res1);
    if ($num1 == '0') {
        $string = "select amount from `manage_master_amount` where crop_mb_u_id='" . $customer_id . "'";
        $result = mysql_query($string);
        $rowString = mysql_fetch_assoc($result);
        $final = $rowString['amount'];
    } else {
        while ($row1 = mysql_fetch_assoc($res1)) {
            $value +=$row1['trip_ammount'];
            //$value1 += $row1['amount'];
        }
        $value1 = $queryTotal['totalamt'];

        $final = $value1 - $value;
    }

    if ($final > 0) {
        $trip_ammount = $final;
    } else {

        $trip_ammount = '0';
    }

    //print_r($final); die;

    $amount = $trip_ammount;
    $device_type = '';
    $status = '0';

    $point1_lat = $sourcelatitute;
    $point1_lng = $sourcelongitude;
    $point2_lat = $destination_lat;
    $point2_lng = $destination_lon;

    function distance($point1_lat, $point1_lng, $point2_lat, $point2_lng, $unit) {
        $theta = $point1_lng - $point2_lng;
        $dist = sin(deg2rad($point1_lat)) * sin(deg2rad($point2_lat)) + cos(deg2rad($point1_lat)) * cos(deg2rad($point2_lat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344);
        }
    }

    $distance = ceil(distance($point1_lat, $point1_lng, $point2_lat, $point2_lng, "k"));

    //print_r($distance);echo "------fsdfdsfsf";die;
    if ($device_id == "" || $account_types == "") {
        echo 'sdfdsfsdfs';
        die;
    } else {
        $map = " ( 3959 * acos( cos( radians('$sourcelatitute') ) * cos( radians( a_latitude ) ) * cos( radians( a_longitude ) - radians('$sourcelongitude') ) + sin( radians('$sourcelatitute') ) * sin( radians( a_latitude ) ) ) ) AS distance ";
        $condition = " and a_latitude IS NOT NULL AND a_longitude IS NOT NULL ";
        $having = " HAVING distance BETWEEN 0 AND 300  ";

        $str77 = "select a.taxi_company_id,$map from `colony` as a where 1 $condition group by a.taxi_company_id $having";
        $res77 = mysql_query($str77);
        while ($row77 = mysql_fetch_array($res77)) {
            $str78 = "select * from driver where company_id='" . $row77['taxi_company_id'] . "' and login_status='1'";
            $res78 = mysql_query($str78);
            $row78 = mysql_fetch_assoc($res78);
            $getDriverDetails[] = $row78['device_id'];
        }
        $getDriverDevice = $getDriverDetails;

        if ($getDriverDevice >= 0) {
            $str55 = "update users set device_id='" . $device_id . "' where id='" . $customer_id . "'";
            $res55 = mysql_query($str55);
            $q = "INSERT INTO `trip`(`current_latitude`,`current_longitude`,`source_latitude`,`source_longitude`,`source_city`,`source_state`,`source_landmark`,`source_country`,`destination_latitude`,`source_address`,`destination_address`,`destination_longitude`,`destination_city`,`destination_state`,`destination_zip`,`destination_landmark`,`destination_country`,`account_type`,`description`,`customer_id`,`trip_distance`,`tripdatetime`,`device_id`,`trip_type`,`addedby`,`addedon`,`status`,`trip_ammount`,`device_type`)
                VALUES ('$currentlatitute','$currentlongitude','$sourcelatitute','$sourcelongitude','$source_city','$source_state','$sourcelandmark','$source_country','$destination_lat','$sourceaddress','$destination_address','$destination_lon','$desti_city','$desti_state','$desti_zip','$destinationlandmark','$desti_country','$account_types','$description','$customer_id','$distance','$date_time','$device_id','$tripType','$customer_id','$date_time','$status','$amount','$device_type')";
            $res = mysql_query($q) or die(mysql_error());

            $registatoin_ids = $getDriverDevice;
            $message = array("newTrip" => "You have get a new trip");
            send_notification($registatoin_ids, $message);

            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>A&ntilde;adido viaje con &eacute;xito</div>';
            HTMLRedirectURL(CORPORATE_URL . 'index.php');
        }
    }

    /*

      echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Central creada correctamente</div>';
      HTMLRedirectURL(ZONE_URL.'taxi-companies.php');
      }
      else
      {
      echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Email-Id already exists. Please use other Email-Id</div>';
      }
      //die(); */
}
?>