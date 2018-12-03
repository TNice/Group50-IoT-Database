<?php
    include 'util/sqlFunctions.php';

    function GenerateDeviceList($id){
        $list = "<ul>";

        $query = "SELECT * FROM package_device WHERE packageId = {$id}";
        $result = SqlQueryRaw($query);

        while($row = mysqli_fetch_assoc($result)){
            $newQuery = "SELECT * FROM smartplug WHERE id = {$row['deviceId']}";
            $newRow = SqlQuery($newQuery);
            if(isset($newRow['deviceId'])){
                if(strpos($list, "<li>Smart Plug</li>") == FALSE){
                    $list .= "<li>Smart Plug</li>";
                }
            }
            else{
                $newQuery = "SELECT * FROM printer WHERE id = {$row['deviceId']}";
                $newRow = SqlQuery($newQuery);
                if(isset($newRow['deviceId'])){
                    if(strpos($list, "<li>Printer</li>") == FALSE){
                        $list .= "<li>Printer</li>";
                    }  
                }
                else{
                    $newQuery = "SELECT * FROM wifi WHERE id = {$row['deviceId']}";
                    $newRow = SqlQuery($newQuery);
                    if(isset($newRow['deviceId'])){
                        if(strpos($list, "<li>Wifi</li>") == FALSE){
                            $list .= "<li>Wifi</li>";
                        }
                    }
                    else{
                        if(strpos($list, "<li>Other</li>") == FALSE){
                            $list .= "<li>Other</li>";
                        }
                    }
                }
            }
        }

        $list .= "</ul>";
        return $list;
    }
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
                <h1 class='title1'>Packages</h1>            
            </div>   
            <?php include 'navmenu.php'; ?>
            <div id='info' class="row" style='width:100%'>
                <div class='col-2'>
                   <div class='list-group list-group-flush contentBox2 sticky-top stickyOffset'>
                        <li class='list-group-item homeTitle' style='font-weight:bold;color:lightgrey;'>Packages</li>
                        <a href='#package0' class='list-group-item homeList' style='color:lightgrey;'>Basic Package</a>
                        <a href='#package1' class='list-group-item homeList' style='color:lightgrey;'>Premium Package</a>
                        <a href='#package2' class='list-group-item homeList' style='color:lightgrey;'>Gold Package</a>
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
                            <h5 class='title1'>Basic Package</h5>
                            <br>
                            <p class='homeInfo'><?php echo GetPackageInfo(0); ?></p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <?php
                                echo GenerateDeviceList(0); 
                            ?>
                        </div>  
                    </div>
                    <div id='package1'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-8'>
                            <h5 class='title1'>Premium Package</h5>
                            <br>
                            <p class='homeInfo'><?php echo GetPackageInfo(1); ?></p></p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <?php
                                echo GenerateDeviceList(1); 
                            ?>
                        </div>  
                    </div>
                    <div id='package2'></div>
                    <br>
                    <div  class="contentBox row">                   
                        <div class='col-8'>
                            <h5 class='title1'>Gold Package</h5>
                            <br>
                            <p class='homeInfo'><?php echo GetPackageInfo(2); ?></p>
                        </div>
                        <div class='col-4' style='color:white'>
                            <h5 class='title1'>Devices</h5>
                            <br>
                            <?php
                                echo GenerateDeviceList(2); 
                            ?>
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