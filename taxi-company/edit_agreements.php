<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
$data = mysql_fetch_array(mysql_query("select * from `agreements` where 1 and id = '".$_GET['a']."'"));

?>
<body class="pop">
    <?php include '../include/taxi-navbar.php'; ?>
    <div class="main_content">
      <div class="container pal0">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/taxi-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <div class="c-acc-status mg5">
              <h2 class="txt-style-3">AGREEMENT</h2>
<?php
if(isset($_POST['updateaggrement']) and $_POST['updateaggrement']!=""){
update_aggrementCreate();
unset($_POST);
}
?>
              <form method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-4">
                    <div class="form-group">
                    	<label>AGREEMENT NAME
 </label>
			<input type="text" name="name" class="input-style" placeholder="AGREEMENT NAME" required value="<?php echo $data['name'];?>"/>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                    	<label>AGREEMENT PERCENT </label>
			<input type="text" name="percentage" class="input-style" placeholder="AGREEMENT PERCENT" required value="<?php echo $data['percentage'];?>"/>
                    </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                    	<label>Document File </label>
                        <input type="file" name="file_name" class="input-style" placeholder="Documentos extras del convenio" value=""/>
                    </div>
                    </div>
                    <div class="col-md-12">
                    <div class="form-group">
                    	<label>DESCRIPTION OF AGREEMENT </label>
			<textarea name="descripition" class="input-style" placeholder="DESCRIPTION OF AGREEMENT......." required><?php echo $data['descripition'];?></textarea>
                    </div>
                    </div>
                </div>
                <div class="row mghji">
				<div class="col-lg-12" style="text-align:center;">
                <input type="hidden" name="aggrement_by" id="aggrement_by" value="<?php echo $_SESSION['uid'];?>"/>
                <input type="hidden" name="aggrement_IDD" id="aggrement_IDD" value="<?php echo $data['id'];?>"/>
                 <input class="dash-button hvr-wobble-horizontal" style="margin-top:0px;" type="submit" name="updateaggrement" id="updateaggrement" value="Update AGREEMENT" />
                    </div>
                </div>
              </form>
              <div>
          
          </div>
          
          
            </div>
          </div>
        </div>
      </div>
    </div>
   <?php 
include '../include/footer.php'; 
?>
</body>
</html>