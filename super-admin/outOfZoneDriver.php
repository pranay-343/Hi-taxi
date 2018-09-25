<?php 
include '../include/define.php';
verifyLogin();
include '../include/head.php'; 
?>
<body>
    <?php include '../include/navbar.php'; ?>
    <div class="main_content">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 pa10">
            <?php include '../include/super-sidebar.php'; ?>
          </div>
          <div class="col-sm-9">
            <h1 class="txt-style-1">Superadministrador Central Taxi</h1>
            <div class="c-acc-status mgr mg5">
              <h2 class="txt-style-3">Agregar Area de Trabajo</h2> </div> </div> </div> </div> </div>
    <?php include '../include/footer.php'; ?>
<script>
    $(document).ready(function () {
        
       function getNewAddedChat()
       {
        
        $.post('getData.php', {mode:'<?php echo base64_encode('getOfZoneDriver')?>'}, function (data) {
        if (data != '|nj|')
            {
                var obj = jQuery.parseJSON(data);
                for (var i = 0; i <= obj.length; i++)
                {
                   $('.msg_window').append('<div class="chat_msg clearfix" style=""><div class="chat_msg_heading"><span class="chat_msg_date">'+obj[i].datetim+'</span><span class="chat_user_name">'+obj[i].senderName+'</span></div><div class="chat_msg_body">'+obj[i].message+'</div></div>');
                   var height = 0;
                    $('div .chat_msg').each(function(i, value){
                        height += parseInt($(this).height());
                        height += parseInt(150);
                    });
                    height += '';
                    $('.msg_window').animate({ scrollTop: height }, 10000);
                }
            }
        });
       }
       setInterval(function(){
            getNewAddedChat();
          }, 5000);

    });
</script>
<?php 


?>