<div class="row br1">
<div class="col-sm-9">
<h1 class="txt-style-1 bn">Administrator Area</h1>
</div>
<div class="col-sm-3">
<select class="sz" name="zone_area_session" id="zone_area_session" onchange="zoneAreaSession(this.value);">
	<option value="">-Select Zone-</option>
	<?php 
		$query = "SELECT * FROM zone_area WHERE 1 and allot_to ='".$_SESSION['uid']."'";
		$result =mysql_query($query);
		$num_rows =mysql_num_rows($result);
		if($num_rows>0){
		while($data = mysql_fetch_array($result)){?>
			<option value="<?php echo $data['id']?>" <?php if($_SESSION['zoneArea'] == $data['id']){echo 'selected';}?>><?php echo base64_decode($data['zone_title']);?></option>
		<?php }}?>
</select>
	
</div>
</div>
<script>
	
	function zoneAreaSession(a){
		if(a != '' || a != null)
		{
		$.post('getData.php',{mode:'<?php echo base64_encode('setZoneSession');?>',a:a},function(data){
			//location.reload();
			window.location.assign("<?php echo ZONE_URL.'index.php'?>")
		});
		}
	}
</script>