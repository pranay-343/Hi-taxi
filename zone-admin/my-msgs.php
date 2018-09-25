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
          <h2 class="txt-style-3">Mis mensajes</h2>
          <form method="POST" action="">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                  <label> de </label>
                  <input type='text' name="fromDate" class='datepicker-here input-style' data-language='en' placeholder="Seleccionar fecha desde" value="<?php echo $_POST['fromDate'];?>"  />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> entonces </label>
                  <input type='text' name="toDate" class='datepicker-here input-style' data-language='en' placeholder="Seleccionar fecha hasta"  value="<?php echo $_POST['toDate'];?>" />
                </div>
              </div>
              
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Taxistas </label>
                  <input type='text' class='input-style' name="driverName" id="searchid" placeholder="Introduzca texto aquí" value="<?php echo $_POST['driverName'];?>"/>
                  <span id="party_id12"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Corporación </label>
                  <input type='text' name="corpName" class='input-style' id="searchid1" placeholder="Introduzca texto aquí" value="<?php echo $_POST['corpName'];?>"  />
                  <span id="party_id13"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> Central </label>
                  <input type='text' name="taxiName" class='input-style' id="searchid2" placeholder="Introduzca texto aquí" value="<?php echo $_POST['taxiName'];?>"  />
                  <span id="party_id14"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="form-group">
                  <label>Usuario</label>
                  <input type='text' name="corpUser" class='input-style' id="searchid3" placeholder="Introduzca texto aquí" value="<?php echo $_POST['corpUser'];?>"  />
                  <span id="party_id15"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> &nbsp; </label>
                   <ul class="dsp">
                    <li>
                      <input type="checkbox" name="particular" value="particular" />
                      <span>Especial</span></li>
                      <li>
                       <li>
                      <input type="checkbox" name="all" value="all" />
                      <span>A todos</span></li>
                      <li>
                      </ul>
                </div>
              </div>
             
            </div>
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2">
                <button class="dash-button hvr-wobble-horizontal w100" name="submit">mensajes de búsqueda</button>
              </div>
              <div class="col-sm-4">
                <a href="<?php echo ZONE_URL?>new-msgs.php" style="color:#333; text-decoration:none;" class="dash-button hvr-wobble-horizontal w100">Nuevos mensajes</a>
              </div>
            </div>
          </form>
          
          <br/><br/>
         <!--  <div>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="5%" class="tab-txt1">Driver Name</th>
                <th width="5%" class="tab-txt1">Corporation Name</th>
                <th width="5%" class="tab-txt1">Company Name</th>
                <th width="5%" class="tab-txt1">Corporate User</th>                
                <th width="40%" class="tab-txt1">Message</th>
                <th width="5%" class="tab-txt1">Message Type</th>
                <th width="7%" class="tab-txt1">Added On</th>
                <th width="5%" class="tab-txt1">more info</th>
              </tr>
              <?php 
              if (isset($_POST['submit'])) 
              {  
                $fromDate=$_POST['fromDate'].' '.'00:00:00';
                $toDate=$_POST['toDate'].' '.'23:59:59';
                if ($_POST['driverName'] != '' || $_POST['driverName'] == '' && $_POST['corpName'] != '' || $_POST['corpName'] == '' && $_POST['corpUser'] != '' || $_POST['corpUser'] == '' && $_POST['taxiName'] != '' || $_POST['taxiName'] == '' && $_POST['sendMessage'] != '' || $_POST['sendMessage'] == '' && $_POST['particular'] != '' || $_POST['particular'] == '' && $_POST['all'] != '' || $_POST['all'] == '') {
                   $zoneTitle = " AND driver_name LIKE '%" .($_POST['driverName']). "%' AND corporation_name LIKE '%" .($_POST['corpName']). "%' AND corporate_user LIKE '%" .($_POST['corpUser']). "%' AND company_name LIKE '%" .($_POST['taxiName']). "%' AND type LIKE '%" .($_POST['particular']). "%' AND type LIKE '%" .($_POST['all']). "%'";
                }
                if($_POST['fromDate'] != '' && $_POST['toDate'] != '')
                {
                    $date1 = "and account.add_on >='".$fromDate."' AND account.add_on <='".$toDate."'";
                    $date = "and added_on >='".$fromDate."' AND added_on <='".$toDate."'";
                }
              }
              else
                  {
                          $zoneTitle = '';
                          $date = '';
                  }
             $str="select * from send_message where 1 $zoneTitle $date";
              $res=mysql_query($str);
              if($res)
              {
              while($row=mysql_fetch_array($res))
              {
              ?>
              <tr>
                <td class="tab-txt2"><?php echo $row['driver_name'];?></td>
                <td class="tab-txt2"><?php echo $row['corporation_name'];?></td>
                <td class="tab-txt2"><?php echo $row['company_name'];?></td>
                <td class="tab-txt2"><?php echo $row['corporate_user'];?></td>
                <td class="tab-txt2"><?php echo $row['message'];?></td>
                <td class="tab-txt2"><?php echo $row['type'];?></td>
                <td class="tab-txt2"><?php echo $row['added_on'];?></td>
                <td class="tab-txt2"><a href="<?php echo ZONE_URL?>update-my-msgs.php?id=<?php echo $row['id'];?>">( + )</a></td>
              </tr>
              <?php }
              }
              else
              {
                echo "error";
              } ?>              
            </table>
          </div> -->
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
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery.min1.7.2.js"></script>
<script src="<?php echo MAIN_URL;?>js/autocomplete/jquery-ui.min.js"></script>
<!-- live search script -->
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
             $("#searchid1").autocomplete({
                        source:'gethint2.php',
            select: function (event, ui) {
            $('#party_id13').html(ui.item.id);
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