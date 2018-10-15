<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'addbootstrap.php';?>

        <title>Database Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
    </head>
        
    <body>
        <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>IoT Database Project</h1>            
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
                        <h1 class='title2'>Devices</h1>
                    </div>   
                    <br>
                    <div id='device0' class='row'></div>
                    <div  class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Device 0</h5>
                            <br>
                            <p class='homeInfo'>This is the device info</p>
                        </div>
                    </div>
                    <br>
                    <div id='device1' class='row'></div>
                    <div  class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Device 1</h5>
                            <br>
                            <p class='homeInfo'>This is the device info</p>
                        </div>
                    </div>
                    <br>
                    <div id='device2' class='row'></div>
                    <div  class="contentBox row">                   
                        <div class='col-12'>
                            <h5 class='title1'>Device 2</h5>
                            <br>
                            <p class='homeInfo'>This is the device info</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id='footer' class='container-fluid footerBox'>
                <h3 class='footer1'>Created By: Group 50</h1>
            </div>
        </div>
    </body>
</html>