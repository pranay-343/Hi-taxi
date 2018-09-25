<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
    <body class="test2">
    <?php include '../include/zone-navbar.php'; ?>
	
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0 mis1">
        <?php include '../include/zone-admin-sidebar.php'; ?>
      </div>
      <div class="col-sm-9 mg5 mis">
        <?php include '../include/za-rsidebar.php'; ?>
		
		<?php 
			// Query for driver detail
			$query_driver_detail="SELECT `driver`.company_id,`taxicompany`.web_user_id,`taxicompany`.added_by,`login`.id,`driver`.name,`driver`.id as driID,`driver`.email FROM `driver`
			LEFT JOIN `taxicompany` ON `driver`.company_id=`taxicompany`.web_user_id
			LEFT JOIN `login` ON `taxicompany`.added_by=`login`.id
			where `driver`.name like '%$q%' and `login`.id='".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'";
			$result_driver_detail = mysql_query($query_driver_detail);
			$num_rows_driver_detail = mysql_num_rows($result_driver_detail);
			
			// Query for corporaion detail 
			$nj = '';$njj = '';
			$query = mysql_query("SELECT login.id, login.name, login.account_type, login.added_by FROM `login` LEFT JOIN taxicompany ON login.id = taxicompany.web_user_id WHERE 1 AND login.added_by =  '".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'");
			while($data = mysql_fetch_array($query))
			{
				  $nj .= $data[id].',';
			}
			$nj = rtrim($nj,',');
			if(isset($nj) && $nj){
				$query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
				while($data = mysql_fetch_array($query)){
					  $njj .= $data[id].',';
				}
			}
			$njj = rtrim($njj,',');
			if(isset($njj) && $njj){	
				$query_corporation_detail="SELECT name,web_user_id  FROM `corporate` where 1 and web_user_id in ($njj) and name like '%".$q."%' ";
				$result_corporation_detail = mysql_query($query_corporation_detail);
				$num_rows_corporation_detail = mysql_num_rows($result_corporation_detail);
			}
			
			// Query for centrals
			$query_central_detail = "SELECT login.name, login.id FROM login LEFT JOIN taxicompany ON login.id = taxicompany.web_user_id WHERE login.name like '%$q%' and login.account_type ='4' and login.added_by='".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."'";
			$result_central_detail = mysql_query($query_central_detail);
			$num_rows_central_detail = mysql_num_rows($result_central_detail);
		?>
        <div class="c-acc-status mg0">
          <h2 class="txt-style-3">Message History</h2>
          <form method="POST" action="">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Start Date"  name="from_date" value="<?php echo $_POST['from_date']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="End Date"  name="to_date" value="<?php echo $_POST['to_date']?>" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Operators </label>
                  <ul>
                        <?php 
                        //Query for app users detail
                          $nj = '';$njj = '';
                          $query = mysql_query("SELECT login.id, login.name, login.account_type, login.added_by FROM `login` LEFT JOIN taxicompany ON login.id = taxicompany.web_user_id WHERE 1 AND login.added_by =  '".$_SESSION['uid']."' AND taxicompany.zone_area_id_sess = '".$_SESSION['zoneArea']."' ");
                          while($data = mysql_fetch_array($query))
                          {
                                    $nj .= $data[id].',';
                          }
                          $nj = rtrim($nj,',');
                          if(isset($nj) && $nj){
                                  $query = mysql_query("SELECT id, name, account_type, added_by FROM  `login` WHERE 1 AND added_by in ($nj)");
                                  while($data = mysql_fetch_array($query))
                                  {
                                            $njj .= $data[id].',';
                                  }
                          }
                          $njj = rtrim($njj,',');
                          if(isset($njj) && $njj){	
                                  $query_users_detail="SELECT name, id FROM `users` where 1 and corporate_id in ($njj) and name like '%".$q."%' ";
                                  $result_users_detail = mysql_query($query_users_detail);
                                  $num_rows_users_detail = mysql_num_rows($result_users_detail);
                          }
                          //$num_rows_users_detail = mysql_num_rows($result_users_detail);
                          if ($num_rows_users_detail > 0) {
                          while($row_users_detail = mysql_fetch_array($result_users_detail)){
                        ?>
                    <li>
                      <input type="checkbox" value="<?php echo $row_users_detail['id']?>" name="opeUsers[]"/>
                      <span><?php echo $row_users_detail['name']?></span>
                    </li>
		<?php  } }?>  
                  </ul>
                </div>
              </div>
            
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Taxi Drivers </label>
                  <!--<input type='text' name="driverName" id="searchid" class='input-style' placeholder="Enter Text Here" value="<?php echo $_POST['driverName'];?>"/>
                  <span id="party_id12"></span>-->
				   <select name="selDriverName" id="selDriverName" class="form-control ">
					<option value="">Select Taxi Driver</option>
					<?php  				
						if(isset($num_rows_driver_detail) && $num_rows_driver_detail>0){
						while($row = mysql_fetch_array($result_driver_detail)){?>
							<option value="<?php echo $row['driID'];?>"><?php echo $row['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Corporation </label>
                  <select name="selCorName" id="selCorName" class="form-control ">
					<option value="">Select Corporation</option>
					<?php   
						if ($num_rows_corporation_detail >0) {            
						while ($row = mysql_fetch_array($result_corporation_detail))
						{?>
							<option value="<?php echo $row['web_user_id'];?>"><?php echo $row['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Central </label>
                  <!--<input type='text' name="taxiName" class='input-style' id="searchid2" placeholder="Enter Text Here" value="<?php echo $_POST['taxiName'];?>"  />
                  <span id="party_id14"></span>-->
				  <select name="selCentralName" id="selCentralName" class="form-control ">
					<option value="">Select central</option>
					<?php  
						if ($num_rows_central_detail > 0) {
						while($row_central_detail = mysql_fetch_array($result_central_detail)){?>
							<option value="<?php echo $row_central_detail['id'];?>"><?php echo $row_central_detail['name'];?></option>
					<?php } }?>
				</select>
                </div>
              </div>
            <div class="col-sm-4">
                <div class="form-group">
                  <label> &nbsp; </label>
                   <ul class="dsp">
                    <?php 
                    if($_POST['particular'])
                    {
                      $checked='checked';
                    }
                    elseif($_POST['all'])
                    {
                      $checked1='checked';
                    }
                    else
                    {
                      $checked='';
                      $checked1='';
                    }
                    ?>
                    <li>
                      <input type="checkbox" name="particular" value="particular" <?php echo $checked;?>/>
                      <span>Especial</span></li>
                      <li>
                       <li>
                      <input type="checkbox" name="all" value="all" <?php echo $checked1;?> />
                      <span>A todos</span></li>
                      <li>
                      </ul>
                </div>
              </div>
                <div class="col-sm-12" >
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="dash-button hvr-wobble-horizontal w100 wap" name="submit">Search</button>
                    </div>
                    <div class="col-sm-4 ">
                        <a class="dash-button hvr-wobble-horizontal w100 wap" href="<?php echo ZONE_URL . "new-msgs.php" ?>">New Message </a>
                    </div>
                </div>
            </div>
          </form>
          
          <br/>
          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
               <tr>
                <th width="5%" class="tab-txt1">Taxi Driver Name</th>            
                <th width="40%" class="tab-txt1">Message</th>
                <th width="7%" class="tab-txt1">Added Date</th>  
                <th width="5%" class="tab-txt1">More Information</th>
              </tr>
              <?php 
              if (isset($_POST['submit'])) {  
                  $fromDate = $_POST['fromDate'] . ' ' . '00:00:00';
                    $toDate = $_POST['toDate'] . ' ' . '23:59:59';
                    $userList = $_POST['opeUsers'];
                    if (isset($userList) && $userList) {
                        $chekUser = implode(",", $userList);

                        if ($_POST['opeUsers'] != '' || $_POST['opeUsers'] == '') {
                            $corp_user = " AND user_id IN ($chekUser)";
                        }
                    }

    //if ($_POST['selDriverName'] != '' || $_POST['selDriverName'] == '' && $_POST['selCorName'] != '' || $_POST['selCorName'] == ''  && $_POST['selCentralName'] != '' || $_POST['selCentralName'] == '' && $_POST['sendMessage'] != '' || $_POST['sendMessage'] == '' && $_POST['particular'] != '' || $_POST['particular'] == '' && $_POST['all'] != '' || $_POST['all'] == '') {
					// $zoneTitle = " AND driver_name LIKE '%" .($_POST['selDriverName']). "%' AND corporation_name LIKE '%" .($_POST['selCorName']). "%'  AND company_name LIKE '%" .($_POST['selCentralName']). "%' AND type LIKE '%" .($_POST['particular']). "%' AND type LIKE '%" .($_POST['all']). "%'";
				  //}
								
                if($_POST['from_date'] != '' && $_POST['to_date'] != ''){
                        $date = "AND added_on between '".date('Y-m-d',strtotime($_POST['from_date']))."' AND  '".date('Y-m-d',strtotime($_POST['to_date']))."'+ INTERVAL 1 DAY";
                }
              }
                else{
                        //$zoneTitle = '';
                        $date = '';
			//$corp_user ='';
                 }
        //$str="select * from send_message where 1 and zone_arae_id = '".$_SESSION['zoneArea']."' $zoneTitle $date $corp_user order by added_on desc ";
        $str="select * from send_message_new where 1 and send_message_new.zone_area_id = '".$_SESSION['zoneArea']."' AND send_message_new.added_by = '".$_SESSION['uid']."' AND send_message_new.message_type ='particular'  $date order by added_on desc ";
              $res=mysql_query($str);
            $data_row = mysql_num_rows($res);
              if($data_row>0){
				  while($row=mysql_fetch_array($res))
              {
                // Query for driver name
                if($row['user_type'] == 'driver' && $row['message_type'] == 'particular') {     
                    $query_drriver_name = "SELECT driver.id, driver.name FROM  driver LEFT JOIN send_message_new ON driver.id = send_message_new.user_id WHERE driver.id ='".$row['user_id']."' AND send_message_new.user_type = 'driver'";
                    $result_drriver_name =mysql_query($query_drriver_name);
                    $data_res = mysql_fetch_array($result_drriver_name);
                    $name = $data_res['name'];
                }
                elseif($row['user_type'] == 'crop' && $row['message_type'] == 'particular'){
                    $query_crop_name = "SELECT corporate.web_user_id, corporate.name FROM corporate LEFT JOIN send_message_new ON corporate.web_user_id = send_message_new.user_id  WHERE corporate.web_user_id ='".$row['user_id']."' AND send_message_new.user_type = 'crop'";
                    $result_crop_name =mysql_query($query_crop_name);
                    $data_res_crop = mysql_fetch_array($result_crop_name);
                    $name = $data_res_crop['name'];

                }elseif ($row['user_type'] == 'compnay' && $row['message_type'] == 'particular') {
                    $query_central_name = "SELECT login.id, login.name FROM login LEFT JOIN send_message_new ON login.id = send_message_new.user_id WHERE login.id ='".$row['user_id']."' AND account_type ='4' AND send_message_new.user_type = 'compnay'";
                    $result_central_name =mysql_query($query_central_name);
                    $data_res_com = mysql_fetch_array($result_central_name);
                    $name = $data_res_com['name'];
                }elseif($row['user_type'] == 'cropuser' && $row['message_type'] == 'particular'){
                    $query_corporate_user_name = "SELECT  users.id, users.name FROM  users LEFT JOIN send_message_new ON users.id = send_message_new.user_id WHERE users.id ='".$row['user_id']."' AND send_message_new.user_type = 'cropuser'";
                    $result_corporate_user_name =mysql_query($query_corporate_user_name);
                    $data_res_corpuser = mysql_fetch_array($result_corporate_user_name);
                    $name = $data_res_corpuser['name'];
                }
              ?>
              <tr>
                <td class="tab-txt2"><?php echo $name;?></td>                               
                <td class="tab-txt2 message_display"><?php echo base64_decode($row['message']);?></td>
                <td class="tab-txt2"><?php echo $row['added_on'];?></td>
                <td class="tab-txt2"><a href="<?php echo ZONE_URL?>view_message_info.php?id=<?php echo $row['id'];?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a></td>
              </tr>
              <?php }
              }
              else
              {
                  echo "<tr>";
                  echo "<td style='color:red;padding:10px;' colspan='8'>No Record Found</td>";
                  echo "</tr>";
              } ?>
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



<!-- live search script -->
<?php /*?>
 <script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid").autocomplete({
                        source:'gethint1.php',
            select: function (event, ui) {
            $('#party_id12').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid2").autocomplete({
                        source:'gethint3.php',
            select: function (event, ui) {
            $('#party_id14').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<script type="text/javascript">
  $.ui.autocomplete.prototype._renderItem = function( ul, item){
          var term = this.term.split(' ').join('|');
          var re = new RegExp("(" + term + ")", "gi") ;
          var t = item.label.replace(re,"<strong>$1</strong>");
          return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append( "<a>" + t + "</a>" )
             .appendTo( ul );
        };
              $(document).ready(function(){
             $("#searchid3").autocomplete({
                        source:'gethint4.php',
            select: function (event, ui) {
            $('#party_id15').html(ui.item.id);
             },
                        minLength:1
                    });
                });
</script>
<?php */?>
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
<script>

$(function(){

    var minimized_elements = $('td.message_display');
    
    minimized_elements.each(function(){    
        var t = $(this).text();        
        if(t.length < 50) return;
        
        $(this).html(
            t.slice(0,50)+'<span>... </span><a href="#" class="more">More</a>'+
            '<span style="display:none;">'+ t.slice(100,t.length)+' <a href="#" class="less">Less</a></span>'
        );
        
    }); 
    
    $('a.more', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).hide().prev().hide();
        $(this).next().show();        
    });
    
    $('a.less', minimized_elements).click(function(event){
        event.preventDefault();
        $(this).parent().hide().prev().show().prev().show();    
    });

});
</script>