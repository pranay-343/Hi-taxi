<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
<?php include '../include/corp-navbar.php'; ?>
<div class="main_content">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 pal0">
        <?php include '../include/corp-sidebar.php'; ?>
      </div>
      <div class="col-sm-9">
        <?php include '../include/corp-rsidebar.php'; ?>
        <div class="c-acc-status">
          <h2 class="txt-style-3">Notification</h2>
          <form method="post" name="search" action="">
            <div class="row bts">
              <div class="col-sm-4">
                <div class="form-group">
                  <label> From </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="From Date"  name="start_date" value="<?php echo $_POST['start_date']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' class='datepicker-here input-style' data-language='en' placeholder="To Date"  name="end_date" value="<?php echo $_POST['end_date']?>"/>
                </div>
              </div>
            
              <div class="col-lg-12">
                  <button class="dash-button hvr-wobble-horizontal wap top20" type="submit" name="submit">Notification Search</button>
              </div>
            </div>
          </form>
        </div>
        <div class="c-acc-status mg5 bst pad0">
          <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
            <tr>
              <!-- <?php  echo $_SESSION['uid'];?> -->
              <th width="20%" class="tab-txt1">YOUR NAME</th>
              <th width="20%" class="tab-txt1">NAME OF SENDER</th>
              <th width="20%" class="tab-txt1">MESSAGE	</th>
              <th width="20%" class="tab-txt1">DATE</th>
              <th width="20%" class="tab-txt1">PLACE LINK</th>
            </tr>
            <?php 
            if(isset($_POST['submit'])) {
                if ($_POST['start_date'] != '' && $_POST['end_date'] != '') {
                    $date = "AND send_message_new.added_on between '" . date('Y-m-d', strtotime($_POST['start_date'])) . "' AND  '" . date('Y-m-d', strtotime($_POST['end_date'])) . "'";
				}
			}
                else {
                    $date = '';
                }
        $query = "SELECT send_message_new.*, login.name as senderName, login.id as senderId FROM send_message_new LEFT JOIN login ON send_message_new.added_by = login.id WHERE 1 and send_message_new.user_id = '".$_SESSION['uid']."' $date ORDER BY send_message_new.id DESC";
		$result = mysql_query($query);
                $rows = mysql_num_rows($result);               
                if($rows>0){
            while($info = mysql_fetch_array($result)){
                $dataSendId = base64_encode($info['id']);
            ?>
            
            <tr>
              <td class="tab-txt2"><?php echo $_SESSION['uname'];?></td>
              <td class="tab-txt2"><?php echo $info['senderName'];?></td>
              <td class="tab-txt2 message_display"><?php echo base64_decode($info['message']);?></td>
              <td class="tab-txt2"><?php echo date("Y-m-d", strtotime($info['added_on'])); ?></td>
              <td class="tab-txt2"><?php if($info['latitude']) {?><a href="<?php echo CORPORATE_URL.'map_link.php?id='.$dataSendId; ?>"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a><?php }?></td>
            </tr>
            <?php } }else{ ?>
            <tr>
                <td style="color: red; padding:10px" colspan="6">No Records Found</td>
                </tr>
            <?php }?>
          
          </table>
          
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../include/footer.php'; ?>
</body>
</html><script>
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