<?php
    session_start();

    include 'util/sqlFunctions.php';
    
    if(!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'NONE';
    }
    
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
            $sqlCommand = "SELECT deviceId, deviceName FROM {$type}";
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
        <?php include 'util/addbootstrap.php';?>

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
            <?php include 'navmenu.php'; ?>
            <div class="row" style='max-width:100%;'>
                <div class='col-3' style='margin-left:2rem;'>
                    <div id='filters' class='contentBoxLight'>
                        <h5 class='title1'>Filters</h5>
                        <form>
                            <div class='form-group'>
                                <input type="text" name="divName" placeholder="Name">
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divType" placeholder="Type">
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divLoc" placeholder="Location">
                            </div>
                            <div class='form-group'>
                                <select name= "Package">
                                    <option>Package</option>
                                    <option>Basic</option>
                                    <option>Premiume</option>
                                    <option>Gold</option>
                                </select>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <div class='col-1'></div>
                <div class='col-7'>
                    <div id='deviceList' class='contentBoxLight'>
                        <h3 class='title1' style='margin-top:0.25rem;'>Devices</h3>
                        <?php include 'createDeviceList.php'; ?>
                    </div>
                </div>
                <div class='col-1'></div>
            </div>   
        </div>
    </body>
</html>
