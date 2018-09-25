<HTML>
<HEAD>
<TITLE>Crunchify - Refresh Div without Reloading Page</TITLE>
 
<style type="text/css">
/*body {
    background-image:
        url('http://cdn3.crunchify.com/wp-content/uploads/2013/03/Crunchify.bg_.300.png');
}*/
#show {
    visibility: hidden; 
    background-color: yellow; 
    position: absolute;
    top: 35%;
    left:40%;
    border-radius: 10px;
    z-index: 100; 
    height: 100px;
    width: 300px
}
</style>
<script type="text/javascript"
    src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
    $(document).ready(
            function() {
                setInterval(function() {

                    $.post('pop3.php',{mode:"select"},function (data)
                    {
                        console.log(data);
                        if(data)
                        {
                            $("#show").html(data);
                        }
                    })
                    // var randomnumber = Math.floor(Math.random() * 100);
                    // $('#show').text(
                    //         'I am getting refreshed every 3 seconds..! Random Number ==> '
                    //                 + randomnumber);
                }, 15000);
            });
           //         return false;

</script>
 
</HEAD>
<BODY>
    <br>
    <br>
    <div id="show" align="center">
        <!-- <h2>User is in panic</h2> -->
        <p style="text-align: -webkit-center;margin-top: 38px;color:red;">User is in panic</p>
    </div>
</BODY>
</HTML>

