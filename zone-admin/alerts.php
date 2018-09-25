<?php
include '../include/define.php';
verifyLogin();
include '../include/head.php';
?>
<body class="test1">
    <?php include '../include/zone-navbar.php'; ?>
    <div class="main_content">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 pal0">
                    <?php include '../include/zone-admin-sidebar.php'; ?>
                </div>
                <div class="col-sm-9 mg5">
                    <?php include '../include/za-rsidebar.php'; ?>
                    <div class="c-acc-status mg0">
                        <h2 class="txt-style-3">System Alerts</h2>
                        <?php
                        // For Central
                        $query_central = "SELECT * FROM taxicompany WHERE added_by = '" . $_SESSION['uid'] . "' AND zone_area_id_sess ='" . $_SESSION['zoneArea'] . "'";
                        $result_central = mysql_query($query_central);
                        $num_rows_central_detail = mysql_num_rows($result_central);

                        // For driver
                        $query_driver = "SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name as dName,`driver`.id as driID,`driver`.email FROM `driver`
        				LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
        				LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
        				where `driver`.name like '%$q%' and `login`.id='" . $_SESSION['uid'] . "'";
                        $result_driver = mysql_query($query_driver);
                        $num_rows_driver_detail = mysql_num_rows($result_driver);

                        // Query for corporaion detail 
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
                            $query_corporation_detail = "SELECT name,web_user_id  FROM `corporate` where 1 and web_user_id in ($njj) and name like '%" . $q . "%' ";
                            $result_corporation_detail = mysql_query($query_corporation_detail);
                            $num_rows_corporation_detail = mysql_num_rows($result_corporation_detail);
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
                        ?>

                        <form method="POST" name="search">
                            <div class="row bts">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>From </label>
                                        <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date" name="start_date"value="<?php echo $_POST['start_date'] ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> To </label>
                                        <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date"   name="to_date"value="<?php echo $_POST['to_date'] ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label> Type </label>
                                        <ul>
                                            <li>
                                                <input type="checkbox" name="panic" value="1" <?php if (!empty($_POST['panic'])): ?> checked="checked"<?php endif; ?>/>
                                                <span>Panic / Emergency</span></li>
                                            

                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-4">
                                    <label>TAXI DRIVER</label>
                                    <select name="selDriver" id="selDriver"  class="form-control ">
                                        <option value="">Select Taxi Driver</option>
                                        <?php
                                        if (isset($num_rows_driver_detail) && $num_rows_driver_detail > 0) {
                                            while ($row = mysql_fetch_array($result_driver)) {
                                                ?>
                                                <option value="<?php echo $row['dName']; ?>"><?php echo $row['dName']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label>OPERATOR</label>
                                    <select name="selOperator" id="selOperator"  class="form-control ">
                                        <option value="">Select Operator</option>
                                        <?php
                                        if ($num_rows_users_detail > 0) {
                                            while ($row_users_detail = mysql_fetch_array($result_users_detail)) {
                                                ?>
                                                <option value="<?php echo $row_users_detail['name']; ?>"><?php echo $row_users_detail['name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <!--<div class="col-sm-4">
                                <label>Central</label>
                                    <select name="selCentralName" id="selCentralName" class="form-control ">
                                                          <option value="">Select Central</option>
                                <?php
                                if ($num_rows_central_detail > 0) {
                                    while ($row_central_detail = mysql_fetch_array($result_central)) {
                                        ?>
                                                                                  <option value="<?php echo $row_central_detail['id']; ?>"><?php echo $row_central_detail['name']; ?></option>
                                <?php } } ?>
                                                  </select>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-4">
                                <label>Corporation User</label>
                                                    <select name="selCorName" id="selCorName" class="form-control ">
                                                          <option value="">Select Corporation</option>
                                <?php
                                if ($num_rows_corporation_detail > 0) {
                                    while ($row = mysql_fetch_array($result_corporation_detail)) {
                                        ?>
                                                                                  <option value="<?php echo $row['web_user_id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } } ?>
                                                  </select>
                                </div>-->
                                <!--<div class="col-sm-4">
                                <div class="form-group">
                                <label>&nbsp;</label>
                                     <ul>
                                      <li>
                                        <input type="checkbox" />
                                        <span>Pending</span></li>
                                         <li>
                                         </ul>
                                         </div>
                                </div>-->

                                <div class="col-sm-4 col-sm-offset-4">
                                    <button class="dash-button hvr-wobble-horizontal w100 wap" name="submit" type="submit">buscar</button>
                                </div>             
                            </div>
                        </form>

                        <br/>
                        <h3>Panic Alert</h3>
                        <div class="bst">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                                <tr>
                                    <th width="10%" class="tab-txt1">USER</th>
                                    <th width="10%" class="tab-txt1">CONDUCTOR</th>
                                    <th width="20%" class="tab-txt1">DATE AND TIME</th>
                                    <th width="20%" class="tab-txt1">Tyoe</th>
                                    <th width="10%" class="tab-txt1">MORE INFORMATION</th>
                                    <!--<th width="20%" class="tab-txt1">cerca</th>-->
                                </tr>
                                <?php
                                if(isset($_POST['submit'])) {

                                    if($_POST['selDriver'] != '') {
                                        //echo "select * from driver where id = '".$_POST['selDriver']."'";
                                        $selDriver = mysql_query("select * from driver where id = '" . $_POST['selDriver'] . "'");
                                        $data4 = mysql_fetch_object($selDriver);
                                        $serName = $data4->name;
                                    } else {
                                        $serName = "";
                                    }

                                    if($_POST['panic'] == 1) {
                                        $panc = "Pánico / Emergencia";
                                    } else {
                                        $panc = $_POST['panic'];
                                    }

                                    echo '<p># Buscar: <strong>"' . $_POST['start_date'] . '"  "' . $_POST['to_date'] . '" "' . $serName . '"  "' . $_POST['selOperator'] . '"  "' . $panc . '" </strong><p>';

                                    if($_POST['start_date'] != '' && $_POST['to_date'] != '') {
                                        $date = "AND trip.tripdatetime between '" . date('Y-m-d', strtotime($_POST['start_date'])).' '.'00:00:00' . "' AND  '" . date('Y-m-d', strtotime($_POST['to_date'])).' '.'23:59:59' . "'";
                                    }
                                    if($_POST['selDriver'] != '' || $_POST['selDriver'] == '') {
                                        $selDriver = " AND driver.name LIKE '%" . ($_POST['selDriver']) . "%'";
                                    }
                                    if($_POST['selOperator'] != '' || $_POST['selOperator'] == '') {
                                        $selOperator = " AND users.name LIKE '%" . ($_POST['selOperator']) . "%'";
                                    }
                                    if($_POST['panic'] != '' || $_POST['panic'] == '') {
                                        $panic = " AND trip.panic_close LIKE '%" . ($_POST['panic']) . "%'";
                                    }
                                } else {
                                    $date = '';
                                    $selDriver = '';
                                    $selOperator = '';
                                    //$selCentralName = '';
                                    //$selCorName ='';
                                }
                                $str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."' $taxicompany";
                                $res=mysql_query($str);
                                if(mysql_affected_rows()>0){
                                        $getcentral = '';
                                        while($row=mysql_fetch_array($res)){
                                        $getcentral .= $row['web_user_id'].',';
                                        }
                                         $getcentral = rtrim($getcentral, ',');
                                 $query_panic = "SELECT trip.*, driver.id as drId, driver.name as dName, users.id as uId, users.name as uName FROM trip LEFT JOIN driver On trip.driver_id = driver.id LEFT JOIN users  ON trip.customer_id = users.id WHERE panictaxirequest!='' AND trip_type='corporate' and driver.added_by in ('$getcentral') $date $selDriver $selOperator $panic";
                                $result_panic = mysql_query($query_panic);
                                $num_row_panic = mysql_num_rows($result_panic);
                                if ($num_row_panic > 0) {
                                    while ($data = mysql_fetch_array($result_panic)) {
                                        ?>
                                        <tr>
                                            <td class="tab-txt2"><?php echo $data['uName'] ?></td>
                                            <td class="tab-txt2"><?php echo $data['dName'] ?></td>
                                            <td class="tab-txt2"><?php echo $data['tripdatetime'] ?></td>
                                            <td class="tab-txt2"><?php echo $data['panictaxirequest']; ?></td>
                                            <td class="tab-txt2"><a href="<?php echo ZONE_URL.'view-trip-info.php' ?>?id=<?php echo base64_encode($data['id']); ?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
<!--                                            <td class="tab-txt2"><?php if ($data['panic_close'] == '1') {
                                    echo 'Closed';
                                } else { ?><a href="javascript:void()" id="close" data-toggle="modal" data-target="#discarded-modal-<?php echo $data['id']; ?>"><i class="fa fa-eye" aria-hidden="true"></i><?php } ?></a></td>-->
                                        </tr>


                                        <div class="modal fade discarded-modal" id="discarded-modal-<?php echo $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="padding-bottom:0;">
                                                        <p><strong>Outside area</strong></p>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-30px;">
                                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                        </button>
                                                    </div>

                                                    <!-- Begin # DIV Form -->
                                                    <?php
                                                    if (isset($_POST['panic_close']) and $_POST['panic_close'] != "") {
                                                        panicClose();
                                                        unset($_POST);
                                                        HTMLRedirectURL(ZONE_URL . "alerts.php");
                                                    }
                                                    ?>
                                                    <div id="div-forms">

                                                        <!-- Begin # Login Form -->
                                                        <form id="discarded-form" method="post" action="" onSubmit="return panicClose();">
                                                            <div class="modal-body">
                                                                <p>you want to close this alert</p>
                                                            </div>
                                                            <input type="hidden" name="trip_id" value="<?php echo $data['id']; ?>"/>
                                                            <input type="hidden" name="txtPanicClose" value="1"/>
                                                            <div class="modal-footer">                            
                                                                <div class="btnCon">
                                                                    <button type="button" class="dash-button w100" style="margin-top:0;" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">No</button>
                                                                    <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('panicClose') ?>" />
                                                                    <input class="dash-button w100" type="submit" name="panic_close" id="panic_close" value="Sí" />
                                                                </div>	
                                                            </div>
                                                        </form>


                                                    </div>
                                                    <!-- End # DIV Form -->

                                                </div>
                                            </div>
                                        </div>
    <?php }
} }elseif(isset($_POST['submit'])==''){
      //$query_driver_detail = "SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name as dName,`driver`.id as driID,`driver`.email, `driver`.login_status, `driver`.last_login_time, `trip_log`.zone_type, `trip_log`.date as tlDate, `trip_log`.id as triplogId FROM `driver` LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id LEFT JOIN trip_log ON `driver`.id = `trip_log`.driver_id where `driver`.name like '%$q%' and `login`.id='" . $_SESSION['uid'] . "' GROUP BY `trip_log`. driver_id ORDER BY `trip_log`.id DESC ";
      $query_driver_detail = "SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name as dName,`driver`.id as driID,`driver`.email,`driver`.login_status, `driver`.last_login_time FROM `driver` LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id where `driver`.name like '%$q%' and `login`.id='" . $_SESSION['uid'] . "'";
      $result_driver =  mysql_query($query_driver_detail);
      if(mysql_num_rows($result_driver)>0){
          while($data_dr =  mysql_fetch_array($result_driver))
          {
                $str1="select id,zone_type,date from `trip_log` where driver_id ='".$data_dr['driID']."' order by id desc";
                $res1=mysql_query($str1);
                $row1=mysql_fetch_array($res1);
    ?> 
                                 <tr>
                                            <td class="tab-txt2"><?php echo $data['uName'] ?></td>
                                            <td class="tab-txt2"><?php echo $data_dr['dName'] ?></td>
                                            <td class="tab-txt2"><?php if($data_dr['login_status'] == '0'){echo $data_dr['last_login_time'];}else{echo $row1['tlDate'];} ?></td>
                                            <td class="tab-txt2"><?php echo $data['panictaxirequest']; ?></td>
                                            <td class="tab-txt2"><?php if($data_dr['login_status'] == '0'){echo ' Log Off';}else{echo $data_dr['zone_type'];}?></td>
                                            <td class="tab-txt2"><a href="javascript:void(0)"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
                                            <td class="tab-txt2"></td>
                                        </tr>
          <?php } } } else { ?>
                                    <tr>
                                        <td style='color:red;padding:10px;' colspan='6'>No Records Found</td>
                                    </tr>
<?php } ?>
                                    
                                    
                                    

                            </table>
                        </div>
                        
                        
                        <br/>
                        <h3> Outside area</h3>
                        <div class="bst">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable">
                                <thead><tr>
                                    <th width="10%" class="tab-txt1">Taxi Driver</th>
                                    <th width="20%" class="tab-txt1">Date And Time</th>
                                    <th width="20%" class="tab-txt1">Type</th>
                                    <!--<th width="10%" class="tab-txt1">más información</th>-->
                                    <!--<th width="20%" class="tab-txt1">cerca</th>-->
                                </tr></thead>
                                       
                                  <tbody>
                                <?php
                                
                                
                               $str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
                                $res=mysql_query($str);
                                if(mysql_affected_rows()>0){
                                        $getcentral = '';
                                        while($row=mysql_fetch_array($res)){
                                        $getcentral .= $row['web_user_id'].',';
                                        }
                                        $getcentral = rtrim($getcentral, ',');                                         
                                        $query_out_zone = "SELECT driver.id as drId, driver.name as dName, trip_log.* FROM driver LEFT JOIN trip_log ON driver.id = trip_log.driver_id WHERE driver.added_by in ('$getcentral') AND zone_type ='Out' ";
                                         
                                }
                                $result_out_zone = mysql_query($query_out_zone);
                                $num_out_zone = mysql_num_rows($result_out_zone);
                                if (isset($num_out_zone) && $num_out_zone > 0) {
                                    while ($data = mysql_fetch_array($result_out_zone)) {
                                        ?>
                                    <tr>
                                        <td class="tab-txt2"><?php echo $data['dName'] ?></td>
                                        <td class="tab-txt2"><?php echo $data['date'] ?></td>
                                        <td class="tab-txt2">Outside area</td>
                                      
                                    </tr>


                                       
                                <?php } }else{ ?>
                                        <tr>
                                            <td style="color: red; padding:10px" colspan="6"> No records found</td>
                                        </tr> 
                                <?php }?>        
                                    
                                           
                                  </tbody>
                                    

                            </table>
                        </div>
                        
                        
                        
                        <br/>
                        <h3> Restricted area</h3>
                        <div class="bst">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1" id="datatable_forbidden">
                                <thead><tr>
                                    <th width="10%" class="tab-txt1">Taxi Driver</th>
                                    <th width="20%" class="tab-txt1">Date and Time</th>
                                    <th width="20%" class="tab-txt1">Type</th>
                                    <!--<th width="10%" class="tab-txt1">más información</th>-->
                                    <!--<th width="20%" class="tab-txt1">cerca</th>-->
                                </tr></thead>
                                       
                                  <tbody>
                                <?php
                                
                                
                               $str = "SELECT `login`.id,`login`.name,`login`.contact_number,`login`.address,`taxicompany`.per_week_cost,`taxicompany`.work_limit,`taxicompany`.added_by,`taxicompany`.added_on,`taxicompany`.web_user_id From `login`
	LEFT JOIN `taxicompany` ON `login`.id=`taxicompany`.web_user_id where 1 AND `taxicompany`.added_by = '".$_SESSION['uid']."' and account_type='4' AND zone_area_id_sess = '".$_SESSION['zoneArea']."'";
                                $res=mysql_query($str);
                                if(mysql_affected_rows()>0){
                                        $getcentral = '';
                                        while($row=mysql_fetch_array($res)){
                                        $getcentral .= $row['web_user_id'].',';
                                        }
                                        $getcentral = rtrim($getcentral, ',');                                         
                                        $query_out_zone = "SELECT driver.id as drId, driver.name as dName, trip_log.* FROM driver LEFT JOIN trip_log ON driver.id = trip_log.driver_id WHERE driver.added_by in ('$getcentral') AND zone_type ='f_in' ";
                                         
                                }
                                $result_out_zone = mysql_query($query_out_zone);
                                $num_out_zone = mysql_num_rows($result_out_zone);
                                if (isset($num_out_zone) && $num_out_zone > 0) {
                                    while ($data = mysql_fetch_array($result_out_zone)) {
                                        ?>
                                    <tr>
                                        <td class="tab-txt2"><?php echo $data['dName'] ?></td>
                                        <td class="tab-txt2"><?php echo $data['date'] ?></td>
                                        <td class="tab-txt2">Outside Area</td>
                                      
                                    </tr>


                                       
                                <?php } }else{ ?>
                                        <tr>
                                            <td style="color: red; padding:10px" colspan="6"> No Records Found</td>
                                        </tr> 
                                <?php }?>        
                                    
                                           
                                  </tbody>
                                    

                            </table>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php include '../include/footer.php'; ?>
</body>
</html>
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>

<div id="snoAlertBox" class="alert alert-danger" data-alert="alert">Now Update your Search</div>
<script>
    var $start = $('#start'),
            $end = $('#end');
    $start.datepicker({
        language: 'en',
        onSelect: function (fd, date) {
            $end.data('datepicker')
                    .update('minDate', date)
        }
    })
    $end.datepicker({
        language: 'en',
        onSelect: function (fd, date) {
            $start.data('datepicker')
                    .update('maxDate', date)
        }
    })
    
  /* 
$("#snoAlertBox").fadeIn();
closeSnoAlertBox();
});
 
function closeSnoAlertBox(){
window.setTimeout(function () {
  $("#snoAlertBox").fadeOut(300)
}, 3000);


*/

/*
$('#user-login').on('click', function () {
        var $form = $(this).closest('form');

        //open blank window onclick to prevent popup blocker
        var loginWindow = window.open('', 'UserLogin');
*/
   $(document).ready(function(){
$('#snoAlertBox').on('click', function () {
        $.ajax({
            type: 'post',
            url: 'getData.php?mode:<?php echo base64_encode("getRealTimeData") ?>',
            dataType : 'json'
        }).done(function (response) {
           console.log(response); 
            
            /*$myElem = $('#user_login_message'); //performance for not checking dom
            $myElem.fadeOut('fast', function(){

                if (response.success)
                {
                    // show success
                    $myElem.html('<p><b class="text-blue">Success!</b> &nbsp;You have been logged in as \'<b>'+response.username+'</b>\' in a new browser window.</p>').fadeIn('fast');                 

                    // open new window as logged in user
                    loginWindow.location.href = 'http://www.example.com/';
                } 
                else
                {
                    // show error
                    $myElem.html('<p><b class="text-red">Error!</b> &nbsp;Please select a valid user from the dropdown list.</p>').fadeIn('fast');

                    // add error to the new window (change this to load error page)
                    loginWindow.document.body.innerHTML = '<p><b>Error!</b> &nbsp;Please select a valid user from the dropdown list.</p>';
                }               
            });*/
        });
});
});
$(document).ready(function() {
        $('#datatable').DataTable();
        $('#datatable_zone').DataTable();
	} );
</script>