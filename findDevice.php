<?php
    session_start();

    $location = $type = '';

    function findDevice($location, $type){
        $sqlQuery = '';

        if($location !== ''){
            if($sqlQuery === ''){
                $sqlQuery .= 'WHERE ';
            }elseif($sqlQuery.contains('WHERE')){
                $sqlQuery .= ', ';
            }
            $sqlQuery .= "location = '{$location}'";
        }

        if($type !== ''){
            $sqlCommand = "SELECT deviceId, deviceName FROM {$type}"
        }
        else{
            $sqlCommand = 'SELECT deviceId, deviceName FROM Devices';
        }
        $sqlCommand .= $sqlQuery . ';';
        
    }
?>

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
                <h1 class='title1'>Find Device</h1>            
            </div>
            
            <div class="row">
                <div class="col-2">
                    <form>
                        Location:<br>
                        <input type="text" name="location" value="Zip Code"><br>
                        
                        Type<br>
                        <input type="radio" name="type" value="Printer">Printer<br>
                        <input type="radio" name="type" value="Smart Plug">Smart Plug<br>
                        <input type="radio" name="type" value="WIFI">WIFI<br>
                        <input type="radio" name="type" value="All" checked>All<br>
                    
                     </form>
                    <div class="col-10">
                        <div class="contentBox">
                            <h3 class="title1"></h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'navmenu.php'; ?>
        </div>
    </body>
</html>
