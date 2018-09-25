<?php  ?>
<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style type="text/css">
   
    
    #result
    {
        position:absolute;
        width:100%;
        padding:10px;
        display:none;
        margin-top:-1px;
        border-top:0px;
        overflow:hidden;
        border:1px #CCC solid;
        background-color: white;
    }
    .show
    {
        padding:5px; 
        border-bottom:1px #999 dashed;
        font-size:15px; 
    }
    .show:hover
    {
        background:#4c66a4;
        color:#FFF;
        cursor:pointer;
    }
	#map, #panorama {
    height: 350px;
    background: #69c;
    width: 60%;
}
</style>
    <body>
    <?php include '../include/taxi-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/taxi-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5">
        <?php //include '../include/za-rsidebar.php'; ?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">View Message </h2>
		  
		  
		  
            <?php 
                $id=  base64_decode($_REQUEST['id']);
                $str="select * from driverPayment where 1 and driver_name='$id' ORDER BY id DESC";
                $res=mysql_query($str);
                $row=mysql_fetch_array($res);

                //if($row['user_type'] == 'driver'){
                    
                    $data_dri = mysql_fetch_array(mysql_query("SELECT * FROM driver WHERE id = '".$row['driver_name']."'"));
                    $name = $data_dri['name'];
               // }
            ?>
          <div class="row bts">
              <p class="pull-right printm1">Print:<a id="print" style="float :right ; margin:-5px 17px -6px 8px"><i class="fa fa-print" style="font-size: 34px;" aria-hidden="true"></i></a></p>


              <div class="clearfix"></div>
              <!-- BY Dinesh -->
              <div class="c-acc-status bst mgmin" id="content">
                  <h2 class="txt-style-3">Payment Information</h2>

                  <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                      <tr> 
                          <th class="tab-txt1">Pago por </th>
                          <th class="tab-txt1">El pago por</th>
                          <th class="tab-txt1">Cantidad</th>
                          <th class="tab-txt1">Fecha de activacion</th>
                          <th class="tab-txt1">A&ntilde;adido el</th>
                      </tr>
                      
                      

                      <tr> 
                          <td class="tab-txt1"><?php echo $_SESSION['uname'];?></td>
                          <td class="tab-txt1"><?php echo $name;?></td>
                          <td class="tab-txt1"><?php echo $row['payment'];?></td>
                          <td class="tab-txt1"><?php echo date('Y-m-d', strtotime($row['paymentDateFrom'])).' - '.date('Y-m-d', strtotime($row['paymentDateTo']));?></td>
                          <td class="tab-txt1"><?php echo date('Y-m-d', strtotime($row['added_on']));?></td>
                      </tr>
                  </table>
                  <!-- date and signtaure Starts -->   
                    <div class="row date_sign">
                      <div class="col-sm-6">
                        <p>Date:  <?php echo date('Y-m-d', strtotime($row['added_on']));?></p>
                      </div>
                      <div class="col-sm-6 pull-right">
                        <p>Signature:</p>
                      </div>
                    </div>
                 <!-- date and signtaure Ends --> 
              </div>
          </div>       
        </div>        
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>

<script>
$("#print").click(function(){
        printcontent($("#content").html());
});

function printcontent(content)
{
    var mywindow = window.open('', '', '');
    mywindow.document.write('<html><title>Print</title><body>');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');
    mywindow.document.close();
    mywindow.print();
    return true;
}
</script>