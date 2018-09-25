<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php';

$id = base64_decode($_GET['a']);
//print_r($id);
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
</style>
<body>
    
<?php include '../include/zone-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/zone-admin-sidebar.php'; ?>
          </div>
          <div class="col-sm-9 mg5">
        <?php include '../include/za-rsidebar.php'; ?>
            <div class="c-acc-status mg0">
              <h2 class="txt-style-3">Estado de la cuenta: Detalle Taxi Company</h2>
              <!--<form method="post" name="search" action="" autocomplete="off">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> From </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select From Date"  name="start_date" value="<?php echo $_POST['start_date'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> To </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select To Date"  name="end_date"  value="<?php echo $_POST['end_date'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Type</label>
                  <ul>
                      <li> <input type="checkbox" name="travel" value="202" <?php if (!empty($_POST['travel'])): ?> checked="checked"<?php endif; ?> /> <span>Travel</span> </li>
                      <li> <input type="checkbox" name="complete" value="500"  <?php if (!empty($_POST['complete'])): ?> checked="checked"<?php endif; ?> /> <span>Complete</span> </li>
                  </ul>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Corporation </label>
                      <input type="text" name="txtCorName" class="input-style search1" id="searchid" placeholder="Enter text here"  value="<?php echo $_POST['txtCorName'];?>"/>
                      <span id="party_id12" style="display:none"></span>   
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Taxi Driver </label>
                      <input type="text" name="txtDriName" class="input-style" placeholder="Enter text here"  value="<?php echo $_POST['txtDriName'];?>"/>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Type</label>
                  <ul>
                      <li> <input type="checkbox" name="paid" value="paid" <?php if (!empty($_POST['paid'])): ?> checked="checked"<?php endif; ?>/> <span>Paid</span> </li>
                      <li> <input type="checkbox" name="unpaid" value="unpaid" <?php if (!empty($_POST['unpaid'])): ?> checked="checked"<?php endif; ?>/> <span>Non Paid</span> </li>
                  </ul>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-12" style="text-align:center;">
                      <button class="dash-button hvr-wobble-horizontal" type="submit" name="submit">Filters</button>
                  </div>
                </div>
              </form>-->
              </div>
     
         
        <div class="c-acc-status">
          <h2 class="txt-style-3">Historial de la cuenta</h2>
          
          <div class="bst spacetop">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
            <tr>
                <th class="tab-txt1">Taxi Company</th>
                <th class="tab-txt1">Cantidad</th>
                <th class="tab-txt1">Fecha de inicio</th>
                <th class="tab-txt1">Fecha final</th>
            </tr>
            <?php
                
            $query=" SELECT taxicompany.name, taxicompany.web_user_id, manage_master_amount.* FROM manage_master_amount LEFT JOIN taxicompany ON manage_master_amount.company_id = taxicompany.web_user_id WHERE company_id = $id and zone_id!='0'";
            $res=mysql_query($query); 
            if(mysql_affected_rows()>0){ 
                while($info=mysql_fetch_array($res))
                  {
                
            ?>
            <tr>
                <td class="tab-txt2"><?php echo $info['name'];?></td>
                <td class="tab-txt2"><?php echo '$'.$info['amount'];?></td>
                <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['start_date']));?></td>
                <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['end_date_time']));?></td>
            <?php } } else{?>
                <tr>
                    <td style="color: red; padding:10px"> No hay resultados</td>
                </tr>
            <?php }?>
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
