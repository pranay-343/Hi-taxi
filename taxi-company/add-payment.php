<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<style>
   td.dp-highlight {
    pointer-events: none !important;
}
    td.dp-highlight .ui-state-default {
      background: #484;
      color: #FFF;
          pointer-events: none !important;
    }
    select.ui-datepicker-month {
    color: #000;
}
</style>
<link rel="stylesheet" type="text/css" href="filess/mdp.css">
<?php
$id = $_GET['a'];
$nj = '';
if($id != '')
{
	$qry = mysql_query("select * from `driverPayment` where 1 and driver_name= $id ORDER BY id DESC");
    while($data = mysql_fetch_assoc($qry))
	{
	$nj .= date_range($data['paymentDateFrom'],$data['paymentDateTo']);	
	$njArr .= date_range_arr($data['paymentDateFrom'],$data['paymentDateTo']);	
	
	}
}
function date_range($first, $last, $step = '+1 day', $output_format = 'm/d/Y' ) {
    $dates = '';
    $current = strtotime($first);
    $last = strtotime($last);
    while( $current <= $last ) {
        $dates .= "'".date($output_format, $current)."'".',';
        $current = strtotime($step, $current);
   }
    return $dates;
}

function date_range_arr($first, $last, $step = '+1 day', $output_format = 'm/d/Y' ) {
    $dates = '';
    $current = strtotime($first);
    $last = strtotime($last);
    while( $current <= $last ) {
        $dates .= date($output_format, $current).',';
        $current = strtotime($step, $current);
    }
    return $dates;
}

$getalldates = rtrim($nj,','); //"'02/02/2016','02/01/2016','01/02/2016','01/01/2016'";

$nj1 = date("m/d/Y", strtotime('monday this week'));
$date = $nj1;//'02/29/2016';
$ts = strtotime($date);
// calculate the number of days since Monday
$dow = date('w', $ts);
$offset = $dow - 1;
if ($offset < 0) {
    $offset = 6;
}
// calculate timestamp for the Monday
$ts = $ts - $offset*86400;
// loop from Monday till Sunday 
$CurentWeekFull = '';
for ($i = 0; $i < 7; $i++, $ts += 86400){
    $checkData = date("m/d/Y", $ts);
	$arr = explode(',',$njArr);
	for($j=0;$j<=count($arr);$j++)
	{
		if($arr[$j] == $checkData) 
		{
			$CurentWeekFull = '1';
		}
		else{}
	}
}

if($CurentWeekFull != ''){$currentWeekk = '+7 days';}
else{$currentWeekk = 'monday this week';}
$nj1 = date("m/d/Y", strtotime($currentWeekk));
$date = $nj1;//'02/29/2016';
$ts = strtotime($date);
// calculate the number of days since Monday
$dow = date('w', $ts);
$offset = $dow - 1;
if ($offset < 0) {
    $offset = 6;
}
// calculate timestamp for the Monday
$ts = $ts - $offset*86400;
// loop from Monday till Sunday 
$selectBox='';
for ($i = 0; $i < 7; $i++, $ts += 86400){

if(date("l", $ts) == 'Monday'){$dayName = 'lunes';}
elseif(date("l", $ts) == 'Tuesday'){$dayName = 'martes';}
elseif(date("l", $ts) == 'Wednesday'){$dayName = 'miércoles';}
elseif(date("l", $ts) == 'Thursday'){$dayName = 'jueves';}
elseif(date("l", $ts) == 'Friday'){$dayName = 'viernes';}
elseif(date("l", $ts) == 'Saturday'){$dayName = 'sábado';}
else{$dayName = 'domingo';}
	$selectBox .= '<option value="'.date("m/d/Y", $ts).'">'.$dayName.'</option>';
}
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
          <div class="row br1">
<div class="col-sm-12">
<h1 class="txt-style-1 bn">Account User : <strong> <?php echo $_SESSION['uname'];?> </strong></h1>
</div>
</div>
            <div class="c-acc-status mg5 mgt0">
              <h2 class="txt-style-3">Add Payment</h2>
              <form action="view-payment.php" method="POST" name="search">
                <div class="row btss">
                  <div class="col-sm-4">
                    <div class="form-group"> 
                    <?php 
                    $str="select * from driver where company_id='".$_SESSION['uid']."' and status!='404'";
                    $res=mysql_query($str);                    
                    ?>                     
                      <label> TAXI DRIVER NAME </label>                      
                   <!-- <input type="text" name="txtDname" required class="input-style" placeholder="Enter Text Here" onKeyUp="showHint(this.value)"/> -->
                   <select name="txtDname" class="input-style" onChange="return getDriverValue(this.value);">
                    <option value="">---Select---</option>
                    <?php while($row=mysql_fetch_array($res)) 
                    {
                    ?>
                     <option value="<?php echo $row['id'];?>" <?php if($id  == $row['id']){echo 'selected';}?>><?php echo $row['name'];?></option>
                    <?php } ?>
                   </select>
                    </div>
                  </div>   
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label> Select Payment Date  </label>
                   <!-- <div id="datepicker" class="input-style"></div> -->
                   <div id="demos">
          <li class="demo">
            <div id="pre-select-dates" class="box"></div>
            <div class="code-box">
<pre class="code" style="display:none">
var date = new Date();
$('#pre-select-dates').multiDatesPicker({
  addDates: [<?php echo $getalldates;?>]
});</pre>
</div>
</li>
</ul>
    </div>
                    
                      <input type="text" name="fromDate" class="input-style" id="input1"  disabled="disabled" size="10" value="<?php echo $data['paymentDateFrom']?>" style="display:none">
                      <input type="text" name="toDate" class="input-style" id="input2"  disabled="disabled" size="10" value="<?php echo $data['paymentDateTo']?>" style="display:none">
                    </div>
                  </div>
                  <div class="col-sm-4" id="month">
                    <div class="form-group">
                      <label> Pay Day </label>
              <select id="month" size="1" class="input-style" name="selDay">
                    <option value="">--Select--</option>
					<?php echo $selectBox;?>
              </select>
                    </div>
                  </div>

                 
                </div> 
                  
                <div class="row bts">
                  <div class="col-lg-12" style="text-align:center;">
                    <!-- <a href="<?php echo TAXI_URL; ?>payment_confirm.php" class="dash-button hvr-wobble-horizontal">Add Payment</a> -->
                     <button class="dash-button hvr-wobble-horizontal wap" name="submit" type="submit">Add Payment</button>
                  </div>
                </div>
              </form>
            </div>           
               <div class="row">
                <div class="col-lg-12">
                  
               </div>    
          </div>          
        </div>
      </div>
    </div>
<div class="footer">
  Copyright @<?php echo date('Y');?>. Desarrollado por : <a href="http://www.hvantagetechnologies.com/" target="_blank">Hvantage Technologies</a>
</div>
<!-- JQUERY SUPPORT -->

<script src="<?php echo MAIN_URL;?>js/jquery.js"></script>
<script src="<?php echo MAIN_URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo MAIN_URL;?>js/modernizr-custom.js"></script>
<!-- datepicker -->

<!-- sidebar menu -->

<script type="text/javascript" src="filess/jquery-1.11.1.js"></script>
<script type="text/javascript" src="filess/jquery-ui-1.11.1.js"></script>
<script type="text/javascript" src="filess/jquery-ui.multidatespicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("input1").click(function(){
        $(this).attr('readonly',true);
    });
    $("input2").click(function(){
        $(this).attr('readonly',true);
    });
});
// $('#input1').attr('readonly',true);
// $('#input2').attr('readonly',true);
      // .datepicker("destroy");
</script>
<script type="text/javascript">
    <!--
      var latestMDPver = $.ui.multiDatesPicker.version;
      var lastMDPupdate = '2014-09-19';
      
      $(function() {
        // Version //
        //$('title').append(' v' + latestMDPver);
        $('.mdp-version').text('v' + latestMDPver);
        $('#mdp-title').attr('title', 'last update: ' + lastMDPupdate);
        
        // Documentation //
        $('i:contains(type)').attr('title', '[Optional] accepted values are: "allowed" [default]; "disabled".');
        $('i:contains(format)').attr('title', '[Optional] accepted values are: "string" [default]; "object".');
        $('#how-to h4').each(function () {
          var a = $(this).closest('li').attr('id');
          $(this).wrap('<'+'a href="#'+a+'"></'+'a>');
        });
        $('#demos .demo').each(function () {
          var id = $(this).find('.box').attr('id') + '-demo';
          $(this).attr('id', id)
            .find('h3').wrapInner('<'+'a href="#'+id+'"></'+'a>');
        });
        
        // Run Demos
        $('.demo .code').each(function() {
          eval($(this).attr('title','NUEVO: editar el código y probarlo!').text());
          this.contentEditable = true;
        }).focus(function() {
          if(!$(this).next().hasClass('test'))
            $(this)
              .after('<button class="test">test</button>')
              .next('.test').click(function() {
                $(this).closest('.demo').find('.hasDatepicker').multiDatesPicker('destroy');	
							
                eval($(this).prev().text());
                $(this).remove();
              });
        });
      });
    // -->

function getDriverValue(a)
{
  if(a != '')
  {
  var url = '<?php echo TAXI_URL;?>add-payment.php?a='+a;
  window.location.href = url;
    return true;
  }

  return false;
}
  </script>
</body>
</html>