<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Super Admin Taxi Central</h1>
            <div class="c-acc-status mgr">
              <h2 class="txt-style-3">Administrators</h2>
              <form>
                <div class="row">
                  
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> FROM </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select From Date"  />
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                      <label> TO </label>
                      <input type='text' class='datepicker-here input-style' data-language='en' placeholder="Select To Date"  />
                    </div>
                  </div>
                  <div class="col-sm-4">
                  <div class="form-group">
                     <label> First Name </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Enter Text Here" />
                      <br/><br/>
                      <label>Administrator </label>
                      <input type="text" name="txtname" class="input-style" placeholder="Enter Text Here" />
                    </div>
                  </div>
                </div>
                <div class="row">
                	<div class="col-sm-4 col-sm-offset-4">
                    	<button class="dash-button hvr-wobble-horizontal w100">search administrators</button>
                    </div>
                </div>
              </form>
            </div>
            <div class="c-acc-status mg5">
            	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
                	<tr>
                    	<th width="20%" class="tab-txt1">name</th>
                        <th width="20%" class="tab-txt1">administrators</th>
                        <th width="10%" class="tab-txt1">centrals</th>
                        <th width="10%" class="tab-txt1">taxis</th>
                        <th width="10%" class="tab-txt1">travel</th>
                        <th width="15%" class="tab-txt1">collection</th>
                        <th width="15%" class="tab-txt1">more info</th>
                    </tr>
                    <tr>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                     <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    </tr>
                    <tr>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                     <td class="tab-txt2">test</td>
                    <td class="tab-txt2">test</td>
                    </tr>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
</body>
</html>
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