<?php 
include '../include/define.php';
include '../include/head.php'; 
?>

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
          <h2 class="txt-style-3">See App Users</h2>
          <?php
          $id=  base64_decode($_REQUEST['a']);
          
          $str="select * from driver where id='$id'";
          $res=mysql_query($str);
          $row=mysql_fetch_array($res);
		  
          ?>
          <div class="row">
          	<div class="col-sm-4">
            	<div class="wht_pd10">
                	<span class="txt-style-7"><span class="txt-style-71">User Name</span> - <?php echo $row['name']; ?></span>
                    <div class="i100 mg10">
                    	<img src="<?php echo TAXI_URL.$row['image']?>" alt="" title="" />
                    </div>
                    <span class="txt-style-7 mg10">RANKINGS</span>
                    <div class="rats">
					
                    	<ul>
                        	<li>
							<?php 
								
							   $query_rating="SELECT SUM(customer_rating) as rating, COUNT(customer_rating) as countRate FROM `trip` 
							  where `trip`.customer_id='$id' and `trip`.account_type='99' AND `trip`.trip_mode = 'complete'";
								$result_rating= mysql_query($query_rating);
								$data_rating = mysql_fetch_array($result_rating);
								if($data_rating['countRate']!='0'){
									$total_rating = $data_rating['rating']/$data_rating['countRate'];
									$rating = (int)($total_rating);
								?>
								<?php for($i= 1; $i<=$rating; $i++){ ?>
								<i class="fa fa-star"></i>
								<?php }
								}else{
									echo'<p>No Rating<p>';
								}?>
								
							</li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
            <div class="wht_pd10">
            	<span class="txt-style-7 lft">User data</span>
                <br/>
                <form>
                	<div class="row">
                    	<div class="col-sm-6">
                        <label> USERNAME </label>
                  <input type='text' class='input-style b3' placeholder="Introduzca texto aquí" value="<?php echo $row['name'];?>"/>
                        </div>
                        <div class="col-sm-6">
                        <label> IDENTIFYING MAIL </label>
                  <input type='text' class='input-style b3' placeholder="Mail" value="<?php echo $row['username'];?>" />
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                    	<div class="col-sm-6">
                        <label> MOBILE PHONE NUMBER </label>
                  <input type='text' class='input-style b3' placeholder="MOBILE PHONE NUMBER" value="<?php echo $row['contact_number'];?>" />
                        </div>
                        
                    </div>
                </form>
                <br/><br/><br/><br/><br/><br/><br/><br/>
            </div>
            <br/>
            </div>
          </div>
        <!--<div class="row">
        	<div class="col-lg-12">
<div class="wht_pd10 tabs">
                <ul id="myTab" class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#service-one" data-toggle="tab">Visita de día</a>
                    </li>
                    <li class=""><a href="#service-two" data-toggle="tab">tiempo - libre / ocupado</a>
                    </li>
                    <li class=""><a href="#service-three" data-toggle="tab">calificación</a>
                    </li>
                    <li class=""><a href="#service-four" data-toggle="tab">tiempo de respuesta</a>
                    </li>
                    <li class=""><a href="#service-five" data-toggle="tab">viajar (aceptación / rechazo)</a>
                    </li>
                   
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="service-one">
                        <div class="row">
        	<div class="col-sm-6 i00">
            	<img src="../images/chart.png" alt="" title="" />
            </div>
            <div class="col-sm-6 i100">
            	<img src="../images/car.png" alt="" title="" />
            </div>
        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="service-two">
                        <h4>Dos servicio</h4>
                        
                    </div>
                    <div class="tab-pane fade" id="service-three">
                        <h4>servicio de tres</h4>
                        
                    </div>
                    <div class="tab-pane fade" id="service-four">
                        <h4>servicio de Cuatro</h4>
                        
                    </div>
                    <div class="tab-pane fade" id="service-five">
                        <h4>servicio de Cuatro</h4>
                        
                    </div>
                    <div class="tab-pane fade" id="service-six">
                        <h4>servicio de Cuatro</h4>
                        
                    </div>
                </div>
</div>
            </div>
        </div>-->
        <br>
        <div class="row">
        	<div class="col-sm-12">
            <h2 class="txt-style-3">Your trip</h2>
            </div>
            <div>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="25%" class="tab-txt1">SOURCE ADDRESS</th>
                <th width="25%" class="tab-txt1">DESTINATION ADDRESS</th>
                <th width="5%" class="tab-txt1">TRAVEL AMOUNT</th>
                <th width="5%" class="tab-txt1">TRAVEL DISTANCE</th>
                <th width="15%" class="tab-txt1">COMMENT</th>
                <th width="5%" class="tab-txt1">CLASSIFICATION</th>
                <!-- <th width="10%" class="tab-txt1">more data</th> -->
              </tr>
              <?php
                $str="select * from trip where driver_id='$id' AND status ='500'";
                $res=mysql_query($str);
                if(mysql_num_rows($res) > 0){
                while($row=mysql_fetch_array($res)){
              ?>             
              <tr>
                <td class="tab-txt2"><?php echo $row['source_address'];?></td>
                <td class="tab-txt2"><?php echo $row['destination_address'];?></td>
                <td class="tab-txt2"><?php echo $row['trip_ammount'];?></td>
                <td class="tab-txt2"><?php echo $row['trip_distance'];?></td>
                <td class="tab-txt2"><?php echo $row['user_comment'];?></td>
                <td class="tab-txt2"><?php echo $row['driver_rateing'];?></td>
                <!-- <td class="tab-txt2"><a href="<?php echo ZONE_URL?>view-app-user.php?id=<?php echo $row['userid'] ?>">( + )</a></td> -->
              </tr>
              <?php } }?>
            </table>
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
</script>