<?php
include("../include/define.php"); 

$mode = base64_decode($_REQUEST['mode']);

// for send notification on android phone
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

if($mode == 'getDriverDetails')
{
	$query="select * from `driver` where 1 and status != '404' order by id ASC";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	if($row['status'] == 200){$status = 'Active';}else if($row['status'] == 99){$status = 'Block';}else if($row['status'] == 400){$status = 'Suspended';}
	if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
	$linkss = '<div class="btn-group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
    <li><a href="view-taxi-driver.php?a='.$row["id"].'">View</a></li>
   	<li><a href="javascript:0" onclick="return editDriver('.$row["id"].');">Edit</a></li>
    <li><a href="javascript:0" onclick="return deleteDriver('.$row["id"].');">suspend</a></li>
    <li><a href="javascript:0" onclick="return activeDriver('.$row["id"].');">Active</a></li>
    <li><a href="javascript:0" onclick="return deleteDriver('.$row["id"].');">Delete</a></li>
    </ul></div>';
        
	$location[]=array($row['name'],$row['contact_number'],$row['liecence_number'],date("d M Y",strtotime($row['added_on'])),$status,$logg,$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));
}


if($mode == 'getCorporateUserDetails')
{
	$query="select c.name,l.email,c.added_on,l.login_status from `corporate` c Left Join `login` l ON c.web_user_id = l.id where 1 and company_id = '".$_SESSION['uid']."' and email != '' order by c.id ASC";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	if($row['login_status'] == 0){$logg = 'LogOff';}else{$logg = 'LogIn';}
	$linkss = '<div class="btn-group"><button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Action<span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
  	<li><a href="javascript:0" onclick="return editTaxiCompany('.$row["id"].');">Edit</a></li>
    <li><a href="javascript:0" onclick="return deleteTaxiCompany('.$row["id"].');">Delete</a></li>
    </ul></div>';
	$location[]=array($i,$row['name'],$row['email'],date("d M Y",strtotime($row['added_on'])),$logg,$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));

}


// Driver Details Update Here Start---


if($mode == 'accountSuspendDriver')
{
	$suspend_description = $_POST['suspend_description'];
	$driverId = $_POST['b'];
	$qur = mysql_query("select * from `driver` where 1 and id='".$driverId."'");
	$num = mysql_num_rows($qur);
	if($num == 0)
	{
		echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details not found ..!</div>';
	}
	else
	{
		$query = "update `driver` set `status` = '400',`suspend_description`='".$suspend_description."' where id='".$driverId."'";
		mysql_query($query);

		$str="SELECT device_id from driver where id='".$driverId."'";
        $res=mysql_query($str);
		$row=mysql_fetch_assoc($res);
		$gcm_regid=$row['device_id'];
		$registatoin_ids = array($gcm_regid);
	    $message = array("adminSuspend" => $contents);
	    send_notification($registatoin_ids, $message);
		echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Suspended ..!</div>';	
	}
}


if($mode == 'deleteDriver')
{
	$currentDate= date('Y-m-d H:i:s');
	$vehicleId = $_POST['a'];        
         $qur = mysql_query("select * from `driver` where 1 and id='".$vehicleId."'");
	$num = mysql_num_rows($qur);
	if($num == 0)
	{
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details not found ..!</div>';
	}
	else{
            $query = "update `driver` set `status` = '404',`driver_delete_date` ='".$currentDate."' where `id` ='".$vehicleId."'";
            mysql_query($query);
            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details Deleted ..!</div>';	
	}
}

// Driver Details Update Here End---

if($mode == 'deleteAgreement')
{
	$agreementId = $_POST['b'];
	$qur = mysql_query("select * from `agreements` where 1 and id='".$agreementId."'");
	$num = mysql_num_rows($qur);
	if($num == 0)
	{
		echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Agreements Details not found ..!</div>';
	}
	else
	{
		$query = "delete from `agreements` where 1 and id='".$agreementId."'";
		mysql_query($query);
		echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Agreements Details Deleted ..!</div>';	
	}
}

if($mode == 'getCorporateAdministratorDetails')
{
	$query="select c.id,c.name,c.begning_credit,a.name as agrName from `corporate` c Left Join `agreements` a ON a.id = c.agreement_id where 1 and company_id = '".$_SESSION['uid']."' order by c.id ASC";
	$result=mysql_query($query) or die();
	$num_rows=mysql_num_rows($result);
	$i=0;$location=array();
	while($row=mysql_fetch_assoc($result))
	{ 
	$i++;
	$editLink = '<a href="edit-corporate-company.php?a='.$row['id'].'"><img src="../images/edit.png" alt="" title="" /></a>';
	$linkss = '<a href="#" onclick="return deleteCorporateCompany('.$row["id"].');"><img src="../images/remove.png"  alt="" title="" /></a>';
	$location[]=array($row['name'],$row['begning_credit'],$row['agrName'],$editLink,$linkss);
	}
	$data = array("data"=>$location);
	print_r(json_encode($data));
}

if($mode == 'deleteCorporateAccount1')
{
	$corporateId = $_POST['a'];
	$query = mysql_query("delete from `login` where 1 and id='".$corporateId."'");
	$query = mysql_query("delete from `users` where 1 and corporate_id='".$corporateId."'");
 	$query1 = "delete from `corporate` where 1 and web_user_id='".$corporateId."'";
 	mysql_query($query1);
	//echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Corporate Administrator Details Deleted ..!</div>';	
	// $qur = mysql_query("select * from `corporate` where 1 and id='".$corporateId."'");
	// $data = mysql_fetch_array($qur);
	// $num = mysql_num_rows($qur);
	// if($num == 0)
	// {
	// 	echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Corporate Administrator Details not found ..!</div>';
	// }
	// else
	// {
	// 	echo $query = "delete from `login` where 1 and id='".$data['web_user_id']."'";
	// 	echo $query = "delete from `corporate` where 1 and web_user_id='".$corporateId."'";
	// 	mysql_query($query);
	// 	echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Corporate Administrator Details Deleted ..!</div>';	
	// }
}

if($mode == 'deleteCorporateAccount')
{
	$currentDate= date('Y-m-d H:i:s');
	$CorporateId = $_POST['a'];        
         $qur = mysql_query("select * from `login` where 1 and id='".$CorporateId."'");
	$num = mysql_num_rows($qur);
	if($num == 0)
	{
            echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details not found ..!</div>';
	}
	else{
            $query = "update `login` set `status` = '404',`updated_on` ='".$currentDate."' where `id` ='".$CorporateId."'";
            mysql_query($query);
            echo '<div class="alert alert-success"><button class="close loginError" data-dismiss="alert" type="button">x</button>Driver Details Deleted ..!</div>';	
	}
}

if($mode == 'changePAssword')
{
	$corporateId = $_POST['a'];
	$password = $_POST['c'];
	$qur = mysql_query("select * from `corporate` where 1 and id='".$corporateId."'");
	$data = mysql_fetch_array($qur);
	
	$updateQry = mysql_query("update `login` set `password`='".md5($password)."' where 1 and id='".$data['web_user_id']."'");
	$updateQry = mysql_query("update `corporate` set `password`='$password' where 1 and id='".$corporateId."'");
		echo '<div class="alert alert-danger"><button class="close loginError" data-dismiss="alert" type="button">x</button>Corporate Administrator Password Updated..!</div>';
	
}

if($mode == 'getcordeinatesDetails')
{
	$zoneId = $_POST['a'];
	$query = mysql_query("select z.* from `zone_area` z Left Join `login` l ON z.allot_to=l.added_by where 1 and l.id='".$zoneId."'");
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

if($mode == 'getColonyB')
{
	//print_r($_POST);
	$qry = 'select * from `colony` where 1 and id = "'.$_POST['a'].'" order by name_B ASC';
	$result=mysql_query($qry) or die("Error ".$qry);
	if(mysql_num_rows($result) > 0)
	{
		while($datarow=mysql_fetch_array($result))
		{
			$nj = array("option"=>"<option value='".$datarow['id']."' selected>".$datarow['name_B']."</option>","fare"=>$datarow['fare']);
		}
		echo json_encode($nj);
	}
	else
	{
		echo '0';
	}
	die;
}
if($mode == 'RemoveRowEditCorporation')
{
	$qry = mysql_query("delete from `corporate_colony` where 1 and id = '".$_POST['a']."'");
}

if($mode == 'getCorporateMonthlyDetails'){
	if(isset($_POST['submit'])){                       
		$name = "AND corporate.name LIKE '%" . $_POST['txtCorName'] . "%'";
		if($_POST['start_date'] != '' && $_POST['end_date'] != ''){
			$date = "AND corporate.added_on between '".date('Y-m-d',strtotime($_POST['start_date']))."' AND  '".date('Y-m-d',strtotime($_POST['end_date']))."'";
		}                        
	}
	else{
		$name = '';
		$date = '';
	}
	$query =" SELECT  * FROM corporate WHERE company_id='".$_SESSION['uid']."' $name $date";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	while($row=mysql_fetch_array($result))
	{
	// List corporation user amount used 
		$nj['label'] = $row['name'];
		$name[] = $nj;        
	$query_total = " SELECT users.id,users.corporate_id,account.payment_amount, account.id,account.customer_id, SUM(account.payment_amount) as total_amount  FROM users JOIN account ON users.id = account.customer_id WHERE corporate_id ='".$row['web_user_id']."' AND payment_mode !='cash'";
	$result_user_total =mysql_query($query_total);
		while ($row1 = mysql_fetch_array($result_user_total)) {
			$amount_used =$row1['total_amount'];
		}
		$outcome_amt = $row['begning_credit']- $amount_used;
		
		$income['value'] = $row['begning_credit'];
		$outcome['value'] = $outcome_amt;
		$nj_income[] = $income;
		$nj_outcome[] = $outcome;
	}
	
	$categoryName['category'] = $name;
	$categoryName['income'] = $nj_income;
	$categoryName['outcome'] = $nj_outcome;
	echo json_encode($categoryName);
}

if($mode == 'getCorporateMonthlyDetails_new'){
	$id=$_POST['idC'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$txtCorName=$_POST['txtCorName'];
	$activation=$_POST['activation'];
	$travel=$_POST['travel'];
	
	if(isset($id)){                       
		$name = "AND login.name LIKE '%" . $txtCorName . "%'";
		if($from_date != '' && $to_date != ''){
			$date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
		}                        
	}
	else{
		$name = '';
		$date = '';
	}
	
	$query_corporation = "SELECT manage_master_amount.*,login.name as corpName, login.id as corpId FROM manage_master_amount LEFT JOIN login ON manage_master_amount.corporate_id = login.id
	where manage_master_amount.added_by ='".$_SESSION['uid']."' AND zone_id='0' $name $date $travel $actication GROUP BY manage_master_amount.corporate_id ";
	$result_corporation = mysql_query($query_corporation);
	$num_rows = mysql_num_rows($result_corporation);
	$totalAmount = '';
	while($row=mysql_fetch_array($result_corporation))
	{
	// List corporation user amount used 
		$total_income_amt = "SELECT manage_master_amount.amount, manage_master_amount.company_id, SUM(manage_master_amount.amount) as totalAmount FROM manage_master_amount WHERE corporate_id  = '".$row['corporate_id']."' AND manage_master_amount.crop_mb_u_id ='0' $date $travel $actication";
		$result_total_icome = mysql_query($total_income_amt);
		$data_total_income = mysql_fetch_array($result_total_icome);
		$totalAmount = $data_total_income['totalAmount'];
		//print_r($row['corpName'].'----';
		$nj[]['label'] = $row['corpName'];
		$name = $nj;
		 
		$income_amount	= $totalAmount;
		$start_date = $row['start_date'];
		$end_date = $row['end_date_time'];
		$query_user_outcome = "SELECT users.id, users.added_by, SUM(manage_master_amount.amount) as userLimit FROM users LEFT JOIN manage_master_amount ON users.id = manage_master_amount.crop_mb_u_id
		WHERE users.added_by = '".$row['corporate_id']."' AND users.added_on >='$start_date' AND users.added_on<='$end_date' + INTERVAL 1 DAY ";
		$result_user_data = mysql_fetch_array(mysql_query($query_user_outcome));
	
		$outcome_amt = $result_user_data['userLimit'];
		
		//$outcome_amt = $row['begning_credit']- $amount_used;
		
		$income['value'] = $income_amount;
		$outcome['value'] = $outcome_amt;
		$nj_income[] = $income;
		$nj_outcome[] = $outcome;
	}
	
	$categoryName['category'] = $name;
	$categoryName['income'] = $nj_income;
	$categoryName['outcome'] = $nj_outcome;
	echo json_encode($categoryName);
}
/*
if($mode == 'getFromTaxiDriverMonthlyDetails'){	
	$driver_detail1 ="SELECT * FROM driver"
		. " WHERE company_id='".$_SESSION['uid']."' AND driverType='monthly'";
	$result_driver1 = mysql_query($driver_detail1);
	$num_rows1 = mysql_num_rows($result_driver1);
	$totalSum = '0';
	
	if(isset($num_rows1) && $num_rows1>0){
		while($row1 = mysql_fetch_array($result_driver1)){			
			$query_amt1 = "SELECT account.payment_amount as driver_amt FROM account WHERE driver_id='".$row1['id']."' AND (payment_mode!='cash' OR payment_mode!='')";
			$result_amt1 = mysql_query($query_amt1); 						
			while($row_amt1 = mysql_fetch_array($result_amt1)){
				 $totalSum = $totalSum + $row_amt1['driver_amt'];
			}			
			$fromDriverName['label'] = $row1['name'];
			$fromDriverName['value'] = $totalSum;	
			$njj[] = $fromDriverName;
		}
	}
	
	echo json_encode($njj);
}*/
if($mode == 'getFromTaxiDriverMonthlyDetails'){

	$id=$_POST['idC'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$txtDriName=$_POST['txtDriName'];
	if($id != '') {
		
		if($to_date != '' && $from_date != ''){
			$date = "AND  driver.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
			$name = "AND driver.name LIKE '%".$_POST['txtDriName']."%'";
		}
	}
	else{
		$date = '';
		$name = '';
	}
	$driver_detail1 ="SELECT * FROM driver"
		. " WHERE company_id='".$_SESSION['uid']."' $date $name";
	$result_driver1 = mysql_query($driver_detail1);
	$num_rows1 = mysql_num_rows($result_driver1);
	$totalSum = '0';
	
	if(isset($num_rows1) && $num_rows1>0){
		while($row1 = mysql_fetch_array($result_driver1)){			
			$query_amt1 = "SELECT SUM(driverPayment.payment) as driver_amt FROM driverPayment WHERE driver_name='".$row1['id']."'";
			$result_amt1 = mysql_query($query_amt1); 						
			while($row_amt1 = mysql_fetch_array($result_amt1)){

				 $totalSum = $row_amt1['driver_amt'];
			}			
			$fromDriverName['label'] = $row1['name'];
			$fromDriverName['value'] = $totalSum;	
			$njj[] = $fromDriverName;
		}
	}
	
	echo json_encode($njj);
}
/*
if($mode == 'getToTaxiDriverMonthlyDetails'){
	
	$driver_detail ="SELECT * FROM driver"
		. " WHERE company_id='".$_SESSION['uid']."' AND driverType='trip'";
	$result_driver = mysql_query($driver_detail);
	$num_rows = mysql_num_rows($result_driver);
	$amt_driver = '0';
	if(isset($num_rows) && $num_rows>0){
		while($row = mysql_fetch_array($result_driver)){
			$query_amt = "SELECT SUM(account.payment_amount) as driver_amt FROM account WHERE driver_id='".$row['id']."' AND (payment_mode!='cash' OR payment_mode!='')";
			$result_amt = mysql_query($query_amt);
			while($row_amt = mysql_fetch_array($result_amt)){
				$amt_driver = $row_amt['driver_amt'];
			}
			$toDriverName['label'] = $row['name'];
			$toDriverName['value'] = $amt_driver;	
			$njj1[] = $toDriverName;
		}
		
	}
	//$toDriverName['category'] = $driver_name;
	//$toDriverName['income'] = $totalSum;
	echo json_encode($njj1);
}*/
	
if($mode == 'getToTaxiDriverMonthlyDetails'){
	$id=$_POST['idC'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];
	$txtDriName=$_POST['txtDriName'];
	if($id != '') {
		
		if($to_date != '' && $from_date != ''){
			$date = "AND  driver.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
			$name = "AND driver.name LIKE '%".$_POST['txtDriName']."%'";
		}
	}
	else{
		$date = '';
		$name = '';
	}
	$driver_detail ="SELECT * FROM driver"
		. " WHERE company_id='".$_SESSION['uid']."' $date $name";
	$result_driver = mysql_query($driver_detail);
	$num_rows = mysql_num_rows($result_driver);
	
	if(isset($num_rows) && $num_rows>0){
		while($row = mysql_fetch_array($result_driver)){
			$query_amt = "SELECT SUM(trip.trip_ammount) as driver_amt FROM trip WHERE trip.driver_id='".$row['id']."' AND trip.trip_type='corporate' AND trip.account_type='99' ";
			$result_amt = mysql_query($query_amt);
			while($row_amt = mysql_fetch_array($result_amt)){	
				if($row_amt['driver_amt'] =='') {			
					$amt_driver = '0'; 
				}else{
					$amt_driver = $row_amt['driver_amt'];
				}
			}
			$toDriverName['label'] = $row['name'];			
			$toDriverName['value'] = $amt_driver;	
			$njj1[] = $toDriverName;
		}
		
	}
	//$toDriverName['category'] = $driver_name;
	//$toDriverName['income'] = $totalSum;
	echo json_encode($njj1);
}

if($mode =='getTaxiPaymentDetails'){	
			if (isset($_POST['submit'])) {
				if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
					$date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
				}
				if($_POST['payment']!=''){
					$payment = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['payment']) . "%'";
				}						
				if($_POST['activation']!=''){
					$activation = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['activation']) . "%'";
				}
			}
			else{
				$payment = '';
				$activation = '';
				$date = '';
			}
			$total_amt = array();
			$query1 = "SELECT end_date_time, amount, added_on, zone_id, company_id, corporate_id FROM manage_master_amount where 1 and company_id = '".$_SESSION['uid']."' AND zone_id!='' AND (type ='credit_amount' || type ='begning_amount') $date";
			$result1 = mysql_query($query1);
			while($row1 = mysql_fetch_array($result1)){							
					//$total_amt1 = $row1['totalamount']; 
					//$total_amt=$total_amt1+$row1['totalamount'];
					$centarlName['label'] = $row1['added_on'];
					$centarlName['value'] = $row1['amount'];
					$njj[] = $centarlName;
					
				}
				//$centarlName['label'] = $row['name'];
				//$centarlName['value'] = $total_amt;	
				
		echo json_encode($njj);
}
if($mode =='getTaxiPaymentDetailsIO'){	
	if (isset($_POST['submit'])) {
		if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
			$date = "AND manage_master_amount.added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'";
		}
		if($_POST['payment']!=''){
			$payment = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['payment']) . "%'";
		}						
		if($_POST['activation']!=''){
			$activation = " AND `manage_master_amount`.amount_type LIKE '%" . ($_POST['activation']) . "%'";
		}
	}
	else{
		$payment = '';
		$activation = '';
		$date = '';
	}
	$query ="SELECT `taxicompany`.web_user_id,`taxicompany`.per_week_cost,`manage_master_amount`.company_id,`manage_master_amount`.amount,`manage_master_amount`.added_on,`manage_master_amount`.type,`manage_master_amount`.start_date,`manage_master_amount`.end_date_time,`manage_master_amount`.amount_type,`manage_master_amount`.added_by,`login`.id,`login`.name FROM `taxicompany` LEFT JOIN `manage_master_amount` ON `taxicompany`.web_user_id=`manage_master_amount`.company_id LEFT JOIN `login` ON `manage_master_amount`.added_by=`login`.id where `taxicompany`.web_user_id='".$_SESSION['uid']."' and `manage_master_amount`.zone_id!='0' $date $payment $activation";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows>0){
	$total_amt_income = array();
	$total_amt_outcome = array();
	while($row=mysql_fetch_array($result))
	{
		//For income amount
		$fromDate = date('Y-m-d', strtotime($row['start_date']));
		$toDate = date('Y-m-d', strtotime($row['end_date_time']));
		//for  Driver actication
		$query_dri_acti =mysql_fetch_assoc(mysql_query("SELECT SUM(payment) as amount FROM driverPayment WHERE added_by ='".$_SESSION['uid']."' AND (paymentDateFrom <='$fromDate' AND paymentDateTo <= '$toDate')"));
		$total_activation_amount = $query_dri_acti['amount'];
		
		//for  Corporation company actication			
		$query_corporation_acti =mysql_fetch_assoc(mysql_query("SELECT SUM(amount) as totalamount FROM manage_master_amount WHERE zone_id ='0' AND company_id ='".$_SESSION['uid']."' AND (start_date >='$fromDate' AND end_date_time <= '$toDate')  $payment $activation"));
		$total_corporation_amount = $query_corporation_acti['totalamount'];
		
	// List corporation user amount used 
		$nj['label'] = $row['added_on'];
		$name[] = $nj;        
		$query_income = "SELECT sum(trip.trip_ammount) as totalamount, driver.id, driver.name,trip.id as trId, trip.driver_id as tRID, trip.trip_mode, trip.tripdatetime FROM driver LEFT JOIN trip ON driver.id = trip.driver_id WHERE driver.added_by='6' AND trip.trip_type='corporate' AND trip.trip_mode ='complete' AND trip.tripdatetime BETWEEN '".date('Y-m-d', strtotime($row['start_date']))."' AND '".date('Y-m-d', strtotime($row['end_date_time']))."' $date $payment $activation"; 
		$result_income = mysql_query($query_income);
		$rows_income = mysql_num_rows($result_income);
		while($row_income=mysql_fetch_array($result_income)){
			
			$amount_income = ($row_income['totalamount'])+($total_activation_amount)+($total_corporation_amount);
		}
		
		$outcome_amt = $row['amount'];
		
		$income['value'] = $amount_income;
		$outcome['value'] = $outcome_amt;
		$nj_income[] = $income;
		$nj_outcome[] = $outcome;
	}
	
	$categoryName['category'] = $name;
	$categoryName['income'] = $nj_income;
	$categoryName['outcome'] = $nj_outcome;
	}
	echo json_encode($categoryName);
}




if($mode =='getTaxiPaymentDetailsIO_2'){
	$id=$_POST['id1'];
	$from_date=$_POST['from_date'];
	$to_date=$_POST['to_date'];	
	$payment=$_POST['payment'];
	$activation=$_POST['activation'];	
	if (isset($id)) {
		if($from_date != '' && $to_date != ''){
			$date = "AND driverPayment.added_on between '".date('Y-m-d',strtotime($from_date))."' AND  '".date('Y-m-d',strtotime($to_date))."'";
		}
		if($_POST['payment']!=''){
			$payment = " AND `driverPayment`.amount_type LIKE '%" . ($payment) . "%'";
		}						
		if($_POST['activation']!=''){
			$activation = " AND `driverPayment`.amount_type LIKE '%" . ($activation) . "%'";
		}
	}
	else{
		$payment = '';
		$activation = '';
		$date = '';
	}
	$query_driver = "SELECT * FROM driverPayment WHERE driverPayment.added_by = '".$_SESSION['uid']."' $date $activation $payment";
	$result_driver =  mysql_query($query_driver);	
	$num_rows = mysql_num_rows($result_driver);
	//if($num_rows>0){
		while($data_driver =  mysql_fetch_array($result_driver)){
			$nj['label'] = $data_driver['added_on'];
			$name[] = $nj;
			$start_date = date ('Y-m-d',strtotime($data_driver['paymentDateFrom']));
			$end_date = date ('Y-m-d',strtotime($data_driver['paymentDateTo']));
			
			$query_trip_detail = "SELECT SUM(trip.trip_ammount) as totalAmt FROM trip  where 1 AND trip.driver_id='".$data_driver['driver_name']."' AND trip.trip_type='corporate' AND trip.tripdatetime >='$start_date' AND trip.tripdatetime<='$end_date'";
			$result_trip_amount = mysql_fetch_array(mysql_query($query_trip_detail));
		
			$outcome_amt = $result_trip_amount['totalAmt'];
			
			$income['value'] = $data_driver['payment'];
			$outcome['value'] = $outcome_amt;
			$nj_income[] = $income;
			$nj_outcome[] = $outcome;
		}
	//}
	
	$categoryName['category'] = $name;
	$categoryName['income'] = $nj_income;
	$categoryName['outcome'] = $nj_outcome;
	//}
	echo json_encode($categoryName);
}

//For create workzone in driver colony


/*
if($mode == 'getcordeinatesDetails')
{
	$query_zone_id = mysql_fetch_array(mysql_query("select * from `taxicompany`  where 1 and web_user_id='".$_SESSION['uid']."'"));
	
	$zoneId = $query_zone_id['zone_area_id_sess'];
	
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
}*/
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
?>
