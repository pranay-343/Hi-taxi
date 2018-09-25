<?php
include '../include/define.php';
verifyLogin();
include '../include/head.php';

$paymentID = base64_decode($_GET['id']);

$query_paid_detail = "SELECT * FROM driverPayment WHERE id= '$paymentID'";
$result_payment = mysql_fetch_array(mysql_query($query_paid_detail));

$start = $result_payment['paymentDateFrom'];
$dateArray = '';
for ($i = 0; $i <= 6; $i++) {
    $nj = "'" . date('m/d/Y', strtotime($start . ' +' . $i . ' days')) . "',";
    $dateArray .= $nj;
}
$getalldates = rtrim($dateArray, ',');
$dates = explode(',', $getalldates);
$start_date = $dates[0];
$end_date = $dates[6];
//print_r($start_date);
//print_r($end_date);
?>
<style>
    td.dp-highlight {
        pointer-events: none !important;
    }
    td.dp-highlight .ui-state-default {
        background: #484;
        color: #FFF;
        pointer-events: none !important;
    }
    select.ui-datepicker-month {
        color: #000;
    }
</style>
<link rel="stylesheet" type="text/css" href="filess/mdp.css">
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
        <div class="container pal0">
            <div class="row btss">
                <div class="col-sm-3 pa10">
                    <?php include '../include/taxi-sidebar.php'; ?>
                </div>
                <div class="col-sm-9">
                    <div class="row br1">
                        <div class="col-sm-12">
                            <h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname']; ?> </strong></h1>
                        </div>
                    </div>
                    <div class="c-acc-status mg5 mgt0">
                        <h2 class="txt-style-3">Payment Detail</h2>
                        <div id="errorMessage"></div>             

                        <div class="row">                  
                            <?php
                            $str_dr_detail = "select * from driver where id='" . $result_payment['driver_name'] . "'";
                            $res_dr_detail = mysql_query($str_dr_detail);
                            $row_dr_detail = mysql_fetch_array($res_dr_detail);
                            ?>
                            <div class="c-acc-status bst" style="margin-top:0;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="tab-txt1">Driver Name</th>
                                            <th width="20%" class="tab-txt1">Driver Contact Number</th>
                                            <th width="20%" class="tab-txt1">Car Plate Number</th>                            
                                        </tr>
                                        <tr>
                                            <td width="5%" class="tab-txt1"><?php echo $row_dr_detail['name']; ?></td>
                                            <td width="5%" class="tab-txt1"><?php echo $row_dr_detail['contact_number']; ?></td>
                                            <td width="5%" class="tab-txt1"><?php echo $row_dr_detail['vehicle_number']; ?></td>                    
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <input type="hidden" name="week" value="<?php echo $week; ?>">
                            <input type="hidden" name="driverName" value="<?php echo $driverName; ?>">
                            <div class="row">  
                                <div class="col-sm-8">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Payment Date</label>
                                            <p><?php echo date('d-m-Y', strtotime($result_payment['paymentDateFrom'])) . '<strong> To  </strong>' . date('d-m-Y', strtotime($result_payment['paymentDateTo'])) ?></p>
                                        </div>  </div>                                   


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Amount </label>
                                            <p class="input-style"><?php echo $result_payment['payment'] . '.00 MX' ?></p>                      
                                        </div>
                                    </div> 

                                </div> 


                            </div>           

                        </div>          
                    </div>
                </div>
            </div>
            <?php
            include '../include/footer.php';
            ?>
            <!-- JQUERY SUPPORT -->

           

            </body>
            </html>