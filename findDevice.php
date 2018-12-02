<?php
    session_start();

    include 'util/sqlFunctions.php';
    
    if(!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'NONE';
    }
    
    $location = $type = '';

    function findDevice($location, $type){
        //sqlquery = search parms
        //sqlcommand = full sql query
        
        $sqlQuery = '';

        if($location !== ''){
            if($sqlQuery === ''){
                $sqlQuery .= ' WHERE ';
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

    /*function findDeviceByType($type){
        $query =  "SELLECT * FROM {$type}";
        $row = SqlQuery($query);
        echo $row['id'];
    }
    
    function findDeviceByTLoc($Loc){
        $query =  "SELLECT * FROM {$loc}";
    }*/
    //querry all devices from the devices table
    //querry based on type and if its on 'select Type' querry for every thing
    //query ased on package
    /*if(isset($_GET['Submit'])){
        $type = $_GET['divType'];
        $loc = $_GET['divLoc'];
        $package = $_GET['Package'];        
        }*/
?>

<html>
    <head>
        <meta charset="UTF-8" />
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
            
            <div id='Modal' style='visibility:hidden; z-index:2; width:100%; position: absolute;'>
                <div class='modal-dialog modal-lg' style='z-index:2'>
                    <div class='modal-content' id='modalInfo'>
                        
                    </div>
                </div>
            </div>
            
            <script>

            function OpenModal(id){
                console.dir(id);
                var modal = document.getElementById("Modal");
                modal.style.visibility = 'visible';
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                       document.getElementById("modalInfo").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "util/finddevice.php?id=" + id, true);
                xmlhttp.send();  
            }

            function CloseModal(type){
                var modal = document.getElementById("Modal").style.visibility = 'hidden';
                document.getElementById("modalInfo").innerHTML = '';
            }

            function TryConnectToDevice(id){
                console.dir(id);
              var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = this.responseText;
                        console.dir(response);
                    }
                };
                xmlhttp.open("GET", "util/deviceconnect.php?id=" + id, true);
                xmlhttp.send();
            }
            </script>
            <div class="row" style='max-width:100%;'>
                <div class='col-3' style='margin-left:2rem;'>
                    <div id='filters' class='contentBoxLight'>
                        <h5 class='title1'>Filters</h5>
                        <form method= "get">
                            <div class='form-group'>
                                <select id= "divType"name= "divType">
                                    <option value="SelectType" selected>Select Type</option>
                                    <option value="smartplug">Smart Plug</option>
                                    <option value = "wifi">WIFI</option>
                                    <option value = "printer">Printer</option>
                                </select>
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divLoc" id = "divLoc" placeholder="Location">
                            </div>
                            <div class='form-group'>
                                <select id = "package" name= "package">
                                    <option value= 0 selected>Package</option>
                                    <option value= 1>Basic</option>
                                    <option value= 2>Premium</option>
                                    <option value= 3>Gold</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" name="submit" value="submit">Submit</button>
                            </div>
                        </form> 
                        
                    </div>
                </div>
                <div class='col-1'></div>
                <div class='col-7'>
                    <div id='deviceList' class='contentBoxLight'>
                        <h3 class='title1' style='margin-top:0.25rem;'>Devices</h3>
                        <br/>
                        <?php
                        $type = $divLoc = $package = '';
                        if ( isset($_GET['divType'])){
                            $type = $_GET['divType'];
                        }
                        if ( isset($_GET['divLoc'])){
                            $divLoc = $_GET['divLoc'];
                        }
                        if ( isset($_GET['package'])){
                            $package = $_GET['package'];
                        }
                        
                        $result = '';
                        $query = '';
                        if((strcmp($type, "SelectType") == 0 || empty($type) == true)&&
                           (strcmp($divLoc, "Location") == 0 || empty($divLoc) == true)&&
                           (strcmp($package, "0") == 0 || empty($package) == true)){ 
                            $query =  "select * FROM devices;";
                            $result = SqlQueryRaw($query);
                        }
                        
                        else{
                            $query = "";
                            $query = "select * from devices ";
                            if(strcmp($type, "SelectType") != 0 && empty($type) != true){
                                $query .= "where id = (select id from {$type}) ";
                            }
                            
                            if(strcmp($package, "0") != 0 && empty($package) != true){
                                if(strcmp($type, "SelectType") == 0 || empty($type) == true){ 
                                    $query .= "where ";
                                }
                                
                                else {
                                    $query .= "and "; 
                                }
                                $query .= "id = (select deviceId from package_device where packageId = {$package}) ";
                            }
                            
                            if(strcmp($divLoc, "Location") != 0 && empty($divLoc) != true){ // if divLoc is not 'locatioin' and empty
                                if(preg_match('/^[0-9]{5}([- ]?[0-9]{4})?$/', $divLoc)){// if it is a valid zipcode
                                    
                                    //check if the type and package is set or not
                                    if((strcmp($type, "SelectType") == 0 || empty($type) == true)&&(strcmp($package, "0") == 0 || empty($package) == true)){ //if is empty or set to 'SelectType' 
                                       $query .= "where ";
                                    }
                                    
                                    else {
                                        $query .= "and ";
                                    }
                                    
                                    $query .= "location = {$divLoc} ";
                                }
                            }
                            
                            $query .= ";";
                            

                            
                        }
                        
                        $result = SqlQueryRaw($query);
                        $html = "<div style='overflow: hidden; overflow-y: scroll; height: 15em; max-height:90%'><div class='list-group'>";
                        while($row = mysqli_fetch_assoc($result)){
                            $html .= "<button class='btn list-group-item' onclick='OpenModal("."{$row['id']}".");'  style='display:block;width:95%;word-spacing: 50px;margin-bottom:.5em;'>";
                            $html.= "id:{$row['id']} location:{$row['location']}";
                            $html .= "</button>";
                        }


                                

                        
                        $html .= "</div></div>";  
                        echo $html;
                        
                        ?>

                    </div></div>
                </div>
                <div class='col-1'></div>
                
            </div>
            
<!--        </div>-->
        
    </body>
</html>
