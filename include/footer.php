<div class="footer">
	Copyright @<?php echo date('Y');?>. Hi Taxi : <a href="http://www.hvantagetechnologies.com/Hi-taxi/" target="_blank">Hi Taxi</a>
    <div align="right">
          <p align="right"><a href="#" class="scrollup"></a></p>
        </div>

</div>
<input type="hidden" value="<?php echo ZONE_URL?>" id="zone_login_url"/>
<!-- JQUERY SUPPORT -->

<script src="<?php echo MAIN_URL;?>js/jquery.js"></script>
<script src="<?php echo MAIN_URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo MAIN_URL;?>js/modernizr-custom.js"></script>

<!-- datepicker -->
<script src="<?php echo MAIN_URL;?>js/datepicker.js"></script>
<script src="<?php echo MAIN_URL;?>js/datepicker.en.js"></script>
<script src="<?php echo MAIN_URL;?>js/jquery.backstretch.min.js"></script>
<!-- sidebar menu -->
<!-- menu jQuery -->
<script src="<?php echo MAIN_URL;?>js/jquery.menu-aim.js"></script>
<script src="<?php echo MAIN_URL;?>js/main.js"></script>

<!-- datatable jQuery -->
<script src="<?php echo MAIN_URL;?>js/1.11.0-jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script src="<?php echo MAIN_URL;?>js/jquery.dataTables.min.js"></script>
<!-- sweetalert-master js -->
<script src="<?php echo MAIN_URL;?>js/sweetalert-dev.js"></script>
<!-- Chart js -->
<script src="<?php echo MAIN_URL;?>js/fusioncharts.js"></script>
<script src="<?php echo MAIN_URL;?>js/fusioncharts.charts.js"></script>

<script>
$('#zone_account, #zone_centrals, #zone_app_users, #zone_taxi_drivers, #zone_map, #zone_new_maps, #zone_alerts, #zone_meg_history, #zone_news, #zone_reports').click(function(){
	var area_session = "<?php echo $_SESSION['zoneArea']?>";
	var zone_url = "<?php echo ZONE_URL?>";
	
	if(!area_session){
		alert('Por favor seleccione Zona');
		window.location.href = "<?php echo ZONE_URL ;?>";
		return false;
		
	}
    
});
</script>
<script type="text/javascript">
			$(document).ready(function(){ 
			
			$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('.scrollup').fadeIn();
				} else {
					$('.scrollup').fadeOut();
				}
			}); 
			
			$('.scrollup').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			});
 
		});
		</script>
        <script type="text/javascript" src="<?php echo MAIN_URL;?>js/bootstrap-filestyle.js"></script>
        <script type="text/javascript">
                $('.input03').filestyle({
                                input : false,
                                buttonName : 'btn-primary'
                        });
                       
        
                   
        </script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php if($_SESSION['utype'] == '2') { ?>
<script>
$(document).ready(function() { 
  $(window).load(function() { 
    getAlerts();
    });
});    
    
    
    
function getAlerts(){
    var session = <?php ($_SESSION['utype'] == '2')  ?>;
    if(session == '2'){
    $.post('realTime_notification_new.php',{mode:'<?php echo base64_encode("getRealTimeData")?>'},function(response){
        response = response.trim();
        var arr = response.split('||nj||');
        //alert(arr[1]+'-----'+arr[0])
        if(arr[1] == 1)
            {
                alertNotificationAlert(arr[1]);   
            }                
          });
        }
    }
        setInterval("getAlerts()",5000);               
                   
                   
        function alertNotificationAlert(a) {
             var t = {
             theme: 'teal',
             sticky: 0,
             horizontalEdge: 'top',
             verticalEdge: 'right'
             },
             n = $(this);
             "" != $.trim('Taxi in Panic') && (t.heading = $.trim('Taxi in Panic')), t.sticky || (t.life = 3000), $.notific8("zindex", 11500), $.notific8($.trim(''), t), n.attr("disabled", "disabled"), setTimeout(function() {
             n.removeAttr("disabled")
             }, 1e3)
    }
</script>
<script src="<?php echo MAIN_URL;?>js/notification/jquery.notific8.min.js" type="text/javascript"></script>
<link href="<?php echo MAIN_URL;?>js/notification/jquery.notific8.min.css" rel="stylesheet" type="text/css" />
<?php }?>
