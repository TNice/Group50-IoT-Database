<?php
    include 'util/sqlFunctions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'util/addbootstrap.php';?>

        <title>Database Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
    </head>
        
    <body>
        <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>Device Types</h1>            
            </div> 
            <?php include 'navmenu.php'; ?>
            <div id='info' class="row" style='width: 100%'>
                <div class='col-2'>
                    <div class='list-group list-group-flush contentBox2 sticky-top stickyOffset'>
                        <li class='list-group-item homeTitle' style='font-weight:bold;color:lightgrey;'>Devices</li>
                        <a href='#device0' class='list-group-item homeList' style='color:lightgrey;'>Device0</a>
                        <a href='#device1' class='list-group-item homeList' style='color:lightgrey;'>Device1</a>
                        <a href='#device2' class='list-group-item homeList' style='color:lightgrey;'>Device2</a>
                    </div>
                </div>    
                <div class='col-10'>
                    <br>
                    <div>
                        <h1 class='title2'>Device Types</h1>
                    </div>
                    <div id='device0'></div> 
                    <br>
                    <div class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Smart Plug</h5>
                            <br>
                            <p class='homeInfo'>By being connected to this device, users will have the ability to charge a wide variety of devices.</p>
                        </div>
                    </div>
                    <div id='device1'></div>
                    <br>     
                    <div  class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Printer</h5>
                            <br>
                            <p class='homeInfo'>By being connected to this device, users will have the ability to scan, print, and fax documents.</p>
                        </div>
                    </div>
                    <div id='device2'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Wifi</h5>
                            <br>
                            <p class='homeInfo'>By being connected to this device, users will have the ability to connect to the Internet.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id='footer' class='container-fluid footerBox'>
                <h3 class='footer1'>Created By: Group 50</h3>
            </div>
        </div>
    </body>
</html>