<?php 

    session_start();
    include 'util/sqlFunctions.php';
    
    if(!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'NONE';
    }

    $daysOfWeek = array('Sun', 'Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat');
    
    function useUserFilter(){
        if(isset($_POST['divId']) && $_POST['divId'] != ""){
            return true;
        }
        if(isset($_POST['divfName']) && $_POST['divfName'] != ""){
            return true;
        }
        if(isset($_POST['divlName']) && $_POST['divlName'] != ""){
            return true;
        }
        if(isset($_POST['divEmail']) && $_POST['divEmail'] != ""){
            return true;
        }
        if(isset($_POST['divPackage']) && $_POST['divPackage'] != ""){
            return true;
        }
        if(isset($_POST['divRole']) && $_POST['divRole'] != ""){
            return true;
        }
        
        return false;
    }

    function GetDaysToFilter($start, $end){
        if($start === $end){
            return array($GLOBALS['daysOfWeek'][$start]);
        }
        else if($start < $end){
            $days = array();
            for($i = $start; $i <= $end; $i++){
                array_push($days, $GLOBALS['daysOfWeek'][$i]);
            }
            return $days;
        }
        else{
            $days = array();
            for($i = $start; $i < 7; $i++){
                array_push($days, $GLOBALS['daysOfWeek'][$i]);
            }
            for($i = 0; $i <= $end; $i++){
                array_push($days, $GLOBALS['daysOfWeek'][$i]);
            }
            return $days;
        }
    }

    function useLogFilter(){
        if(isset($_POST['divLogId']) && $_POST['divLogId'] != ""){
            return true;
        }
        if(isset($_POST['divTime']) && $_POST['divTime'] != ""){
            return true;
        }
        if(isset($_POST['divResult']) && $_POST['divResult'] != ""){
            return true;
        }
        if(isset($_POST['divUserName']) && $_POST['divUserName'] != ""){
            return true;
        }
        if(isset($_POST['divDeviceId']) && $_POST['divDeviceId'] != ""){
            return true;
        }
//        if(isset($_POST['divDevice']) && $_POST['divDevice'] != ""){
//            return true;
//        }
        if(isset($_POST['divRole']) && $_POST['divRole'] != ""){
            return true;
        }
        
        return false;
    }

    function roleCheck(){
        if($_POST['divRole'] == "User"){
            return 0;
        }
        else if($_POST['divRole'] == "Admin"){
            return 1;
        }
        else{ 
            $_POST['divRole'] = "";
        }
    }

    function packageCheck(){
        if($_POST['divPackage'] == "Basic"){
            return 0;
        }
        else if($_POST['divPackage'] == "Premium"){
            return 1;
        }
        else if($_POST['divPackage'] == "Gold"){
            return 2;
        }
        else{
            $_POST['divPackage'] = "";
        }
    }

    function deviceTypeCheck(){
        if($_POST['divDevice'] == "Smart Plug"){
            return 0;
        }
        else if($_POST['divDevice'] == "Printer"){
            return 1;
        }
        else if($_POST['divDevice'] == "Wifi"){
            return 2;
        }
        else{
            $_POST['divDevice'] = "";
        }
    }
    
    $location = $type = '';

    function findUser($location, $type){
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
<?php include 'navmenu.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'util/addbootstrap.php';?>

        <title>Database Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#969696">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
        <script>
        function DefaultTab(){
            var tabName = localStorage.getItem("lastTab");
            if(!tabName){
                tabName = "Logs";
            }
            var tab = document.getElementById(tabName);
            var tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            var tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            tab.style.display = "block";
            document.getElementById(tabName + "Button").className += " active";
        }

        window.onload = DefaultTab;
        </script>
        <style>
            #addDevice{
                width: 125px;
                height: 1.5em;
            }
        </style>
    </head>
    <body>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";

            localStorage.setItem("lastTab", tabName);
        }
        
    </script>
        <div class="tab">
          <button class="tablinks" id='LogsButton' onclick="openTab(event, 'Logs')">Logs</button>
          <button class="tablinks" id='DevicesButton' onclick="openTab(event, 'Devices')">Devices</button>
          <button class="tablinks" id='UserButton' onclick="openTab(event, 'User')">User</button>
        </div>

        <div id="Logs" class="tabcontent" style='display:none;padding-left:0;'>
            <div class="background" style='max-width:99.8%'>  
                <div id='title' class='container-fluid titleBox'>            
                    <h1 class='title1'>Log Search</h1>            
                </div>
            
                <div class="row" style='max-width:100%;'>
                    <div class='col-3' style='margin-left:2rem;'>
                        <div id='filters' class='contentBoxLight'>
                            <h5 class='title1'>Filters</h5>
                            <form action="#" method="POST">
                                <div class='form-group'>
                                    <input type="text" name="divName" placeholder="Log Id">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divTime" placeholder="Time">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divResult" placeholder="Result">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divUserName" placeholder="User Id">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divDeviceId" placeholder="Device Id">
                                </div>
                                <div class='form-group'>
                                    <select name="divDevice">
                                        <option>Device</option>
                                        <option>Smart Plug</option>
                                        <option>Printer</option>
                                        <option>WiFi</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <select name="divRole">
                                        <option>Role</option>
                                        <option>User</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <input type="submit" value="Submit" onclick="openTab(event, 'Logs')">
                                </div>
                            </form>
                
                        </div>
                    </div>
                    <div class='col-1'></div>
                    <div class='col-7'>
                        <div id='logList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Logs</h3>
                            <?php include 'createDeviceList.php'; ?>
                            <?php 
                                $html ="<div><ul>";
                                $query = "Select * From deviceLogs d";
                               if(useLogFilter()){
                                   
                                roleCheck();
//                                   useLogFilter();
                                   if(isset($_POST['divRole']) && !empty($_POST['divRole'])){ 
                                       $query .= ", user_role r Where d.userId = r.userId ";
                                    }     
                                   else{
                                        roleCheck();
                                        if(useLogFilter()){
                                            $query .= " WHERE ";
                                        }
                                   }
                                                              
                                   if(isset($_POST['divRole']) && !empty($_POST['divRole'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       }
                                       
                                       $roleResult = roleCheck();
                                       $query .= " r.roleId = $roleResult";
                                   }
                                   
                                   if(isset($_POST['divLogId']) && !empty($_POST['divLogId'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "logid = '{$_POST['divLogId']}'";
                                    }
                                    if(isset($_POST['divTime']) && !empty($_POST['divTime'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "logTime = '{$_POST['divTime']}'";
                                    }
                                    if(isset($_POST['divResult']) && !empty($_POST['divResult'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "result = {$_POST['divResult']}";
                                    }
                                    if(isset($_POST['divUserName']) && !empty($_POST['divUserName'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "d.userId = {$_POST['divUserName']}";
                                    }
                                   if(isset($_POST['divDeviceId']) && !empty($_POST['divDeviceId'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "deviceId = {$_POST['divDeviceId']}";
                                    }
                                   
                                   echo $query;
                                   $result = SqlQueryRaw($query);
                                   
                                   while($row = mysqli_fetch_assoc($result)){
                                       $html .= "<button class='btn' onclick='OpenModal(2, "."{$row['logId']}".");'  style='display:block;width:95%'>" . 
                                       "{$row['logId']} {$row['deviceId']} ({$row['userId']})". 
                                        "</button><br>";  
                                       //echo $row['id'];
                                   }
                                                             
                               }else{
                                   //send query
                                   echo "No Logs Found";
                                    $result = SqlQueryRaw($query);
                                    //echo $result;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $html .= "<button class='btn' onclick='OpenModal(2, "."{$row['logId']}".");'  style='display:block;width:95%'>" . 
                                        "{$row['logId']} {$row['deviceId']} ({$row['userId']})". 
                                        "</button><br>";    
                                    }
                                    
                               }
                               $html .= "</ul></div>";
                                echo $html;
                             ?>
                        </div>
                    </div>
                    <div class='col-1'></div>

                </div>
            </div>   
        </div>      
        
    <div id="Devices" class="tabcontent" style='display:none;padding-left:0;'>    
        <div class="background" style='max-width:99.8%'> 
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>Find Device</h1>            
            </div>     
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
                            <button id="addDeviceButton" onclick="OpenAddDeviceModal()">Add Device</button>
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
                        
                        if((strcmp($type, "SelectType") == 0 || empty($type) == true)&&
                           (strcmp($divLoc, "Location") == 0 || empty($divLoc) == true)&&
                           (strcmp($package, "0") == 0 || empty($package) == true)){ // if type value is select type or is empty
//                           if(strcmp($divLoc, "Location") == 0 || empty($divLoc) == true){// if location is empty or defalt value 'location'
//                               if(strcmp($package, "0") == 0 || empty($package) == true){// if package is empty or 'package'
                            $query =  "select * FROM devices;";
                            print $query; // for debugging
                            $result = SqlQueryRaw($query);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<br/>{$row['id']}";
                            }
                        }
                        else{
                            $query = "";
                            $query = "select * from devices ";
                            if(strcmp($type, "SelectType") != 0 && empty($type) != true){// if type is not empty and not 'SelectType'
                                $query .= "where id = (select id from {$type}) "; //query using where
                            }
                            
                            if(strcmp($package, "0") != 0 && empty($package) != true){ // if package is not empty and not 'package'
                                if(strcmp($type, "SelectType") == 0 || empty($type) == true){ // if type is is empty or set to 'SelectType' 
                                    $query .= "where "; // query using where
                                }
                                
                                else {
                                    $query .= "and "; //if type is not set to a valid option
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
                            
                            print $query; // for debugging
                            
                            $result = SqlQueryRaw($query);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<br/>{$row['id']}";
                            }  
                        }
                        ?>                 
                    </div>
                </div>
                <div class='col-1'></div>
            </div>   
        </div>
    </div>       
        <div id="User" class="tabcontent" style='display:none;padding-left:0;'>
            
            <div class="background" style='max-width:99.8%'>  
                <div id='title' class='container-fluid titleBox'>            
                    <h1 class='title1'>User Search</h1>            
                </div>
            
                <div class="row" style='max-width:100%;'>
                    <div class='col-3' style='margin-left:2rem;'>
                        <div id='filters' class='contentBoxLight'>
                            <h5 class='title1'>Filters</h5>
                            <form action="#" method="POST">
                                <div class='form-group'>
                                    <input type="text" name="divId" placeholder="User Id">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divfName" placeholder="First Name">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divlName" placeholder="Last Name">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divEmail" placeholder="Email">
                                </div>
                                <div class='form-group'>
                                    <select name='divPackage'>
                                        <option>Package</option>
                                        <option>Basic</option>
                                        <option>Premium</option>
                                        <option>Gold</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <select name="divRole">
                                        <option>Role</option>
                                        <option>User</option>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <input type="submit" value="Submit" onclick="openTab(event, 'User')">
                                </div>
                            </form>
                
                        </div>
                    </div>
                    <div class='col-1'></div>
                    <div class='col-7'>
                        <script>
                        function OpenModal(type, id){
                            var modal = document.getElementById("Modal");
                            modal.style.visibility = 'visible';
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("modalInfo").innerHTML = this.responseText;
                                }
                            };
                            if(type = "device"){
                                xmlhttp.open("GET", "util/find" + modalType[type] + ".php?id=" + id + "&admin=true", true);
                            }
                            else{
                                xmlhttp.open("GET", "util/find" + modalType[type] + ".php?id=" + id, true);
                            }
                            xmlhttp.send();  
                        }

                        function OpenAddDeviceModal(){
                            var modal = document.getElementById("Modal");
                            modal.style.visibility = 'visible';
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("modalInfo").innerHTML = this.responseText;
                                }
                            };

                            xmlhttp.open("GET", "util/adddevice.php", true);
                            xmlhttp.send();  
                        }
                        
                        var modalType = ["user", "device", "log"];

                        function CloseModal(type){
                            var modal = document.getElementById("Modal").style.visibility = 'hidden';
                            document.getElementById("modalInfo").innerHTML = '';
                        }

                        function EditUserModal(event){
                            event.currentTarget.disabled = true;
                            document.getElementById('bdayModal').disabled = false;
                            document.getElementById('phoneModal').disabled = false;
                            document.getElementById('usernameModal').disabled = false;
                            document.getElementById('lnameModal').disabled = false;
                            document.getElementById('fnameModal').disabled = false;
                            document.getElementById('emailModal').disabled = false;
                            document.getElementById('passwordModal').disabled = false;
                            document.getElementById('saveButton').style.display = 'inline';
                            document.getElementById('cancelButton').style.display = 'inline';
                        }

                        function CancelUserEdit(event){
                            document.getElementById('bdayModal').disabled = true;
                            document.getElementById('phoneModal').disabled = true;
                            document.getElementById('usernameModal').disabled = true;
                            document.getElementById('lnameModal').disabled = true;
                            document.getElementById('fnameModal').disabled = true;
                            document.getElementById('emailModal').disabled = true;
                            document.getElementById('passwordModal').disabled = true;
                            document.getElementById('editButton').disabled = false;
                            document.getElementById('saveButton').style.display = 'none';
                            event.currentTarget.style.display = 'none';
                        }

                        function SaveUserModal(event){
                            var xmlhttp = new XMLHttpRequest();
                            var username, fName, lName, phone, bday, id, email, pass;
                            id = document.getElementById('idModal').innerHTML;
                            email = document.getElementById('emailModal').value;
                            bday = document.getElementById('bdayModal').value;
                            phone = document.getElementById('phoneModal').value;
                            username = document.getElementById('usernameModal').value;
                            lname = document.getElementById('lnameModal').value;
                            fname = document.getElementById('fnameModal').value;
                            pass = document.getElementById('passwordModal').value;
                            var url = "util/edituser" + ".php?id=" + id + 
                            "&username=" + username + "&fname=" + fname + "&lname=" + lname +
                            "&phone=" + phone + "&bday=" + bday + "&email=" + email + "&password=" + pass;
                            //console.dir(url);
                            xmlhttp.open("GET", url, true);
                            xmlhttp.send();

                            document.getElementById('bdayModal').disabled = true;
                            document.getElementById('phoneModal').disabled = true;
                            document.getElementById('usernameModal').disabled = true;
                            document.getElementById('lnameModal').disabled = true;
                            document.getElementById('fnameModal').disabled = true;
                            document.getElementById('emailModal').disabled = true;
                            document.getElementById('passwordModal').disabled = true;
                            document.getElementById('editButton').disabled = false;
                            document.getElementById('cancelButton').style.display = 'none';
                            event.currentTarget.style.display = 'none';
                        }
                        
                        function DeleteUser(event, id){
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    console.dir(this.responseText);
                                }
                            };
                            xmlhttp.open("GET", "util/deleteusers.php?id=" + id, true);
                            xmlhttp.send();
                            CloseModal(0);
                        }
                       </script>
                        <div id='userList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Users</h3>
                            <?php 
                                $html ="<div class='container' style='overflow:hidden;overflow-y:scroll;height:15em;max-height:90%'><div class='btn-group' style='width:100%'>";
                                $query = "Select * From users u";
                               if(useUserFilter()){
                                   
                                   packageCheck();
                                   roleCheck();
                                   
                                   if(isset($_POST['divPackage']) && !empty($_POST['divPackage'])){ 
                                       if(isset($_POST['divRole']) && !empty($_POST['divRole'])){
                                            $query .= ", user_package p, user_role r Where u.id = p.userId and p.userId = r.userId and u.id = p.userId";
                                        }else{
                                           $query .= " user_package p Where u.id = p.userId";
                                       }
                                    }
                                   else if(isset($_POST['divRole']) && !empty($_POST['divRole'])){
                                        $query .= ", user_role r Where u.id = r.userId";
                                    }     
                                else{
                                        packageCheck();
                                        roleCheck();
                                        if(useUserFilter()){
                                            $query .= " WHERE ";
                                        }
                                   }
                                   
                                   
                                   if(isset($_POST['divRole']) && !empty($_POST['divRole'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       }
                                       
                                       $roleResult = roleCheck();
                                       $query .= " r.roleId = $roleResult";
                                   }
                                   
                                   if(isset($_POST['divPackage']) && !empty($_POST['divPackage'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       }
                                       
                                       $packageResult = packageCheck();
                                       $query .= " p.packageId = $packageResult";
                                   }
                                   
                                   if(isset($_POST['divId']) && !empty($_POST['divId'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "id = {$_POST['divId']}";
                                    }
                                    if(isset($_POST['divfName']) && !empty($_POST['divfName'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "firstName = '{$_POST['divfName']}'";
                                    }
                                    if(isset($_POST['divlName']) && !empty($_POST['divlName'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "lastName = '{$_POST['divlName']}'";
                                    }
                                    if(isset($_POST['divEmail']) && !empty($_POST['divEmail'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "email = '{$_POST['divEmail']}'";
                                    }
                                   
                                   echo $query;
                                   $result = SqlQueryRaw($query);
                                   
                                   while($row = mysqli_fetch_assoc($result)){
                                       $html .= "<button class='btn' onclick='OpenModal(0, "."{$row['id']}".");'  style='display:block;width:95%'>" . 
                                        "{$row['firstName']} {$row['lastName']} ({$row['userName']})". 
                                        "</button><br>"; 
                                   }       
                               }else{
                                   //send query
                                    $result = SqlQueryRaw($query);
                                    //echo $result;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $html .= "<button class='btn' onclick='OpenModal(0, "."{$row['id']}".");'  style='display:block;width:95%'>" . 
                                        "{$row['firstName']} {$row['lastName']} ({$row['userName']})". 
                                        "</button><br>";  
                                    }        
                               }
                               $html .= "</div></div>";
                                echo $html;
                             ?>
                        </div>
                       
                    </div>
                    <div class='col-1'></div>
                    
                </div>   
            </div>    
            <div class='modal' id='addDeviceModal' style='visibility:hidden;'>
                <div class='modal-dialog modal-lg' style='z-index:10'>
                    <div class='modal-content' id='userEdit'>
                    <div class='modal-header'>
                        <h4 class='modal-title' id='idModal' style='margin:auto;width:100%;text-align:center'>"."{$row['id']}"."</h4>
                        <button type='button' class='close' onclick='CloseModal(0);'>×</button>
                    </div>
                    <div class='modal-body'>
                        <div class='row'>
                            <div class='col-1'></div>
                            <div class='col-5'>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Name</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='firstName' id='fnameModal'>
                                    <input type='text' class='form-control' placeholder='lastName' id='lnameModal'> 
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Username</span>
                                    </div>
                                <input type='text' class='form-control' placeholder='userName' id='usernameModal'>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Email</span>
                                    </div>
                                <input type='text' class='form-control' placeholder='email' id='emailModal'>
                                </div>
                            </div>
                            <div class='col-5'>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Phone#</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='555-555-5555' id='phoneModal'>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Birth Date</span>
                                    </div>
                                <input type='date' class='form-control' id='bdayModal'>
                                </div>
                            </div>
                            <div class='col-1'></div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <form style='width:100%'>
                            <button class='btn btn-secondary' id='editButton' onclick='EditModal(event);return false;' style='text-align:left;'>Edit</button>
                            <button class='btn btn-secondary' id='saveButton' onclick='SaveUserModal(event);return false;' style='display:none'>Save</button>
                            <button class='btn btn-secondary' id='cancelButton' onclick='CancelEdit(event);return false;' style='display:none'>Cancel</button>
                            <button class='btn btn-danger' type='submit' name='deleteAcct' style='float:right'>DELETE</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div> 
        <div id='Modal' style='visibility:hidden;'>
            <div class='modal-dialog modal-lg' style='z-index:10'>
                <div class='modal-content' id='modalInfo'>
                    
                </div>
                </div>
            </div>
        </div>      

    </body>
</html>
