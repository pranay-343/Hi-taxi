<?php  ?>
<?php 
include '../include/define.php';
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
</style>
    <body>
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
          <h2 class="txt-style-3">Nuevos mensajes</h2>
		  <?php 
				// Query for driver detail
				$query_driver_detail="SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name,`driver`.id as driID,`driver`.email FROM `driver`
				LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
				LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
				where `driver`.name like '%$q%' and `login`.id='".$_SESSION['uid']."'";
				$result_driver_detail = mysql_query($query_driver_detail);
				$num_rows_driver_detail = mysql_num_rows($result_driver_detail);
				
				// Query for corporaion detail 
				$nj = '';$njj = '';
				$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by =  '".$_SESSION['uid']."'");
				while($data = mysql_fetch_array($query))
				{
					  $nj .= $data[id].',';
				}
				$nj = rtrim($nj,',');
				$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
				while($data = mysql_fetch_array($query)){
					  $njj .= $data[id].',';
				}
				$njj = rtrim($njj,',');
				
				$query_corporation_detail="SELECT name,web_user_id  FROM `corporate` where 1 and web_user_id in ($njj) and name like '%".$q."%' ";
				$result_corporation_detail = mysql_query($query_corporation_detail);
				//$num_rows_corporation_detail = mysql_num_rows($result_corporation_detail);
				
				
				// Query for centrals
				$query_central_detail = "SELECT name, id FROM login WHERE name like '%$q%' and account_type ='4' and added_by='".$_SESSION['uid']."'";
				$result_central_detail = mysql_query($query_central_detail);
				$num_rows_central_detail = mysql_num_rows($result_central_detail);
				
				//Query for app users detail
				$nj = '';$njj = '';
				$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by =  '".$_SESSION['uid']."'");
				while($data = mysql_fetch_array($query))
				{
					  $nj .= $data[id].',';
				}
				$nj = rtrim($nj,',');
				$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
				while($data = mysql_fetch_array($query))
				{
					  $njj .= $data[id].',';
				}
				$njj = rtrim($njj,',');

				$query_users_detail="SELECT name, id FROM `users` where 1 and corporate_id in ($njj) and name like '%".$q."%' ";
				$result_users_detail = mysql_query($query_users_detail);
				//$num_rows_users_detail = mysql_num_rows($result_users_detail);		
			?>
		  
		  
          <?php 
              $id=$_REQUEST['id'];
              $str="select * from send_message where 1 and id='$id'";
              $res=mysql_query($str);
              $row=mysql_fetch_array($res);
                ?>
          <form method="post" name="search" action=""  onSubmit="return updatemessage();">
             <?php
              if(isset($_POST['submit1']) and $_POST['submit1']!="")
              { 
                updatemessage(); 
                HTMLRedirectURL(ZONE_URL."message-history.php");
              }            
            ?>
            <div class="row">
              <div class="col-sm-12">
                <?php
                 if($row['type']=='particular')
                 {
                 $checked='checked';
                 }
                 elseif($row['type']=='all')
                 {
                  $checked1='checked';
                 }
                 else
                 {
                  $checked='';
                  $checked1='';
                 }
                ?>
               
                <input type="radio" name="sendMessage" value="particular" <?php echo $checked?> class="chooseType" />Especial
                <input type="radio" name="sendMessage" value="all" <?php echo $checked1?> class="chooseType" />Todas
               <!--  <div class="radio">
                   <label><input type="radio" name="send" value="particular">Particular</label>
                </div>
                <div class="radio">
                   <label><input type="radio" name="send" value="all">All</label>
                </div> -->
              </div>
            </div>
           
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Conductor de taxi </label>
				  <select name="selDriverName" id="selDriverName" class="form-control " >
					<option value="">Elija un taxista</option>
					<?php  				
						if($num_rows_driver_detail>0){
						while($row_driver_detail = mysql_fetch_array($result_driver_detail)){?>
							<option <?php if ($row_driver_detail['driID']) {
                    echo (($row_driver_detail['driID'] == $row['driver_name'] ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $row_driver_detail['driID'];?>"><?php echo $row_driver_detail['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Corporación </label>
                  <!--<input type='text' name="corpName" class='input-style' id="searchid1" placeholder="Introduzca el texto aquí" value="<?php echo $row['corporation_name'];?>"  />
                  <span id="party_id13"></span>-->
					<select name="selCorName" id="selCorName" class="form-control " >
						<option value="">Seleccione Corporación</option>
						<?php   
							if ($num_rows_corporation_detail >0) {            
							while ($row_corp_detail = mysql_fetch_array($result_corporation_detail))
							{?>
								<option <?php if ($row_corp_detail['web_user_id']) {
                    echo (($row_corp_detail['web_user_id'] == $row['corporation_name'] ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $row_corp_detail['web_user_id'];?>"><?php echo $row_corp_detail['name'];?></option>
						<?php } }?>
					</select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Central </label>
                  <!--<input type='text' name="taxiName" id="searchid2" class='input-style' placeholder="Introduzca el texto aquí" value="<?php echo $row['company_name'];?>"  />
                  <span id="party_id14"></span>-->
				  <select name="selCentralName" id="selCentralName" class="form-control " >
					<option value="">Seleccionar central</option>
					<?php  
						if ($num_rows_central_detail > 0) {
						while($row_central_detail = mysql_fetch_array($result_central_detail)){?>
							<option <?php if ($row_central_detail['id']) {
                    echo (($row_central_detail['id'] == $row['company_name'] ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $row_central_detail['id'];?>"><?php echo $row_central_detail['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Usuario</label>
                  <!--<input type='text' name="corpUser" id="searchid3" class='input-style' placeholder="Introduzca el texto aquí" value="<?php echo $row['corporate_user'];?>"  />
                  <span id="party_id15"></span>-->
				  
				  <select name="selUsersName" id="selUsersName" class="form-control " >
					<option value="">Seleccione Usuarios de la aplicación</option>
					<?php  
						$num_rows_users_detail = mysql_num_rows($result_users_detail);
						if ($num_rows_users_detail > 0) {
						while($row_users_detail = mysql_fetch_array($result_users_detail)){?>
							<option <?php if ($row_users_detail['id']) {
                    echo (($row_users_detail['id'] == $row['corporate_user'] ) ? 'selected=selected' : '');
                    } ?> value="<?php echo $row_users_detail['id'];?>"><?php echo $row_users_detail['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
             <!--  <div class="col-sm-4">
                <div class="form-group">
                  <label> &nbsp; </label>
                   <ul class="dsp">
                    <li>
                      <input type="checkbox" />
                      <span>Perticular</span></li>
                      <li>
                       <li>
                      <input type="checkbox" />
                      <span>To All</span></li>
                      <li>
                      </ul>
                </div>
              </div> -->
             
            </div>
			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
					  <label>La partida de mensajes</label>
					  <input type="text" name="txtHeading" placeholder="Introduzca el texto aquí" class="input-style" value="<?php echo ($row['heading']);?>" required/>
					</div>
                </div>
			</div>
            <div class="row ter">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Mensaje</label>
                  <textarea class="input-style" name="sentMessage"  placeholder="Introduzca el texto aquí" style="min-height:330px;" required><?php echo base64_decode($row['message']);?></textarea>
                  </div>
                  </div>
                  <div class="col-sm-6">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d115002.39064241787!2d-100.35138939102713!3d25.743309851093922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1staxi+near+Central%2C+Monterrey%2C+Mexico!5e0!3m2!1sen!2sin!4v1450159257013" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                  </div>
                  </div>
                  </div>
            <div class="row btsa">
              <div class="col-sm-4 col-sm-offset-4 f74">
                <!-- <button class="dash-button hvr-wobble-horizontal w100" name="submit">Update message</button> -->
                <input type="hidden" name="mode" id="mode" value="<?php echo base64_encode('updatemessage')?>" />
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
                <input type="submit" class="dash-button hvr-wobble-horizontal w100 f74" name="submit1" id="submit1" value="mensaje de actualización" />
              </div>             
            </div>
          </form>        
        </div>        
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html>


<!-- live search script -->


<!-- JQUERY SUPPORT -->
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>

<!-- datepicker -->
<script src="../js/datepicker.js"></script>
<script src="../js/datepicker.en.js"></script>
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
  
	$(function() {
		$('.chooseType').change(function() {
			if ($(this).val() == 'all') {
				//alert("all");
				$("#selDriverName").addClass("input-style1");
				$("#selCorName").addClass("input-style1");
				$("#selCentralName").addClass("input-style1");
				$("#selUsersName").addClass("input-style1");
			} else {
				$("#selDriverName").removeClass("input-style1");
				$("#selCorName").removeClass("input-style1");
				$("#selCentralName").removeClass("input-style1");
				$("#selUsersName").removeClass("input-style1");
				//alert("particular");
			}
		});
	});
</script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.min.js"></script>
<!-- live search script -->




