<?php 
include '../include/define.php';
include '../include/head.php'; 
?>
<style>.tab-txt1{padding: 10px 7px !important;}</style>
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
          <h2 class="txt-style-3">News</h2>
          <form action="" method="POST">
            <div class="row bts">
              <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                  <label> From  </label>
                  <input type='text' name="fromDate" class='datepicker-here input-style' data-language='en' placeholder="Start Date" value="<?php $_POST['fromDate']?>" />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label> To </label>
                  <input type='text' name="toDate" class='datepicker-here input-style' data-language='en' placeholder="End DATE" value="<?php $_POST['toDate']?>"   />
                </div>
              </div>
           
              <div class="col-sm-4 col-sm-offset-2 step1">
                <button class="dash-button hvr-wobble-horizontal w100 wap" name="searchNews">Search</button>
              </div>
              <div class="col-sm-4 step2">
				<a href="add-blog-news.php" class="dash-button hvr-wobble-horizontal w100 wap">New Blog</a>
              </div>
            </div>
          </form>
          <br/>
        
         <h2 class="txt-style-3 txt-style-31">User List</h2>

          <div class="bst">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ctabel1">
              <tr>
                <th width="25%" class="tab-txt1">TITLE</th>
                <th width="25%" class="tab-txt1">DESCRIPTION</th>
                <th width="25%" class="tab-txt1">DATE AND TIME</th>
                <th width="25%" class="tab-txt1">PHOTOS</th>
                <!--<th width="25%" class="tab-txt1">VER</th>-->
                <th width="25%" class="tab-txt1">ACTION</th>
                <!-- <th width="25%" class="tab-txt1">more info</th> -->
              </tr>
              <?php

              if(isset($_POST['searchNews']))
              {
				echo '<p># Search: <strong>"'.$_POST['fromDate'].'"  "'.$_POST['toDate'].'" </strong><p>';
				
                $fromDate=$_REQUEST['fromDate'];
                $toDate=$_REQUEST['toDate'];
                $news="and added_on >='$fromDate' and added_on <='$toDate'";
              }
              else
              {
                $news='';
              }
                $str="Select * from news where 1 and added_by='".$_SESSION['uid']."' $news";
                $res=mysql_query($str);
                if(mysql_affected_rows()>0)
                {
                while($row=mysql_fetch_array($res))
                  {
					  $linkss = '<a href="'.ZONE_URL.'Edit-blog-news.php?a=' . base64_encode($row['id']) . '"><span class="fa fa-pencil fa_iconm1" ></span>&nbsp;&nbsp;</a>';
					  $link_view = '<a href="'.ZONE_URL.'view-blog-news.php?a=' . base64_encode($row['id']) . '"><i class="fa fa-eye fa_iconm1" aria-hidden="true"></i></a>';

               if($row['newsImage'] == "" || $row['newsImage'] == null)
               {
                  echo $row['newsImage'] = ZONE_URL.'dumy_news.jpg';
               }
              ?>
              <tr>
                <td class="tab-txt2"><?php echo $row['title']; ?></td>
                <td class="tab-txt2"><?php echo $row['discription']; ?></td>
                <td class="tab-txt2"><?php echo $row['added_on']; ?></td>
                <td class="tab-txt2"><img height="100px" width="100px" src="<?php echo $row['newsImage']; ?>" /></td>
                <!-- <td class="tab-txt2">( + )</td> -->
                <td class="tab-txt2"><?php echo $link_view.'  '.$linkss; ?></td>
                <!--<td class="tab-txt2"><?php echo $linkss; ?></td>-->
              </tr>
              <?php
            }
            }
            else
            {
              echo "<tr>";
              echo "<td style='color:red;padding:10px;' colspan='4'>No Records Found</td>";
              echo "</tr>";
            }
            ?>          
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
<!-- JQUERY SUPPORT -->
<!--<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/modernizr-custom.js"></script>-->

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