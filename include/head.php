<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!--<meta http-equiv="refresh" content="15; URL=<?php echo MAIN_URL.'new_polygon.php'?>">-->
<title>Hi Taxi</title>
<link rel="shortcut icon" href="<?php echo MAIN_URL;?>images/favicon.png" />
<!-- CSS Support -->
<link href="<?php echo MAIN_URL;?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo MAIN_URL;?>css/layout.css" rel="stylesheet">
<link href="<?php echo MAIN_URL;?>css/responsive.css" rel="stylesheet">
<!-- menu styles -->
<link rel="stylesheet" type="text/css" href="<?php echo MAIN_URL;?>css/style.css" />
<!-- Font Awsome -->
<link href="<?php echo MAIN_URL;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Data Table Css -->
<link href="<?php echo MAIN_URL;?>css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<!-- sweetalert-master Css -->
<link rel="stylesheet" href="<?php echo MAIN_URL;?>css/sweetalert.css">
 <!-- datepicker styles -->
<link href="<?php echo MAIN_URL;?>css/datepicker.css" rel="stylesheet" type="text/css">

<!-- Google Map-->
<link href="<?php echo MAIN_URL;?>css/drawonmaps.css" rel="stylesheet" type="text/css" />
<link href="<?php echo MAIN_URL;?>bootstrap/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
<!-- popup-master Css -->
<link rel="stylesheet" type="text/css" href="<?php echo MAIN_URL;?>css/jquery.msgbox.css" />
<!-- attached doc support -->
		<link rel="stylesheet" type="text/css" href="<?php echo MAIN_URL;?>css/add-doc.css" />
                
 
        
<style type="text/css">
        .scrollup {
                width:40px;
                height:40px;
                position:fixed;
                bottom:0px;
                right:0px;
                display:none;
                text-indent:-9999px;
                background:url(../images/icon_top.png) no-repeat;
        }
        #google_translate_element{ position:absolute !important; z-index:999 !important; top:2% !important; right:8% !important;}
        .goog-logo-link{
            display: none !important;
        }
        .goog-te-gadget{
           // display: none !important;    
        }
        iframe{
            visibility: hidden !important;
        }
       
        .goog-te-gadget .goog-te-combo{
            margin: 4px 0;
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .goog-te-gadget{
         font-size: 0px !important;   
        }
        .goog-te-combo{
          margin: 15px 0 0 25px !important;
        }
</style>
</head>
<div id="google_translate_element"></div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({ pageLanguage: "en" }, "google_translate_element");
        };

        $(function () {
            $(".loadMore").click(function () {
                $("<p/>", {
                    text: "This is some injected text that will not be translated."
                }).appendTo($(".destination"));
            });
            $.getScript("//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit");
        });
    </script>

