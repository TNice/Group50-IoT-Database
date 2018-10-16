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
                <h1 class='title1'>Packages</h1>            
            </div>   
            <?php include 'navmenu.php'; ?>
            <div id='info' class="row" style='width:100%'>
                <div class='col-2'>
                   <div class='list-group list-group-flush contentBox2 sticky-top stickyOffset'>
                        <li class='list-group-item homeTitle' style='font-weight:bold;color:lightgrey;'>Packages</li>
                        <a href='#package0' class='list-group-item homeList' style='color:lightgrey;'>Package0</a>
                        <a href='#package1' class='list-group-item homeList' style='color:lightgrey;'>Package1</a>
                        <a href='#package2' class='list-group-item homeList' style='color:lightgrey;'>Package2</a>
                    </div> 
                </div>    
                <div class='col-10'>
                    <br>
                    <div>
                        <h1 class='title2'>Packages</h1>
                    </div>   
                    <div id='package0'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-8'>
                            <h5 class='title1'>Package 0</h5>
                            <br>
                            <p class='homeInfo'>This is the package info</p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <ul>
                                <li>Device1</li>
                                <li>Device2</li>
                            </ul>
                        </div>  
                    </div>
                    <div id='package1'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-8'>
                            <h5 class='title1'>Package 1</h5>
                            <br>
                            <p class='homeInfo'>This is the package info</p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <ul>
                                <li>Device1</li>
                                <li>Device2</li>
                            </ul>
                        </div>  
                    </div>
                    <div id='package2'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-8'>
                            <h5 class='title1'>Package 2</h5>
                            <br>
                            <p class='homeInfo'>This is the package info</p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <ul>
                                <li>Device1</li>
                                <li>Device2</li>
                            </ul>
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