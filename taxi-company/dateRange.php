<!DOCTYPE html>
<html>
    <head>
        <title>bootstrap datepicker examples</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Bootstrap CSS and bootstrap datepicker CSS used for styling the demo pages-->
        <link rel="stylesheet" href="../css/datepicker.css">
        <link rel="stylesheet" href="../css/bootstrap.css">
    </head>
    <body>
        <div class="container">
            <div class="hero-unit">
                <div class="input-daterange" id="datepicker" >
                    <input type="text" class="input-small" name="start" />
                    <span class="add-on" style="vertical-align: top;height:20px">to</span>
                    <input type="text" class="input-small" name="end" />
                </div>
            </div>
        </div>
        <!-- Load jQuery and bootstrap datepicker scripts -->
        <script src="../js/1.11.0-jquery.min.js"></script>
        <script src="../js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('.input-daterange').datepicker({
                    todayBtn: "linked"
                });
            
            });
        </script>
    </body>
</html>