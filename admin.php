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
<!--
                                <div class='form-group'>
                                    <select name="divDevice">
                                        <option>Device</option>
                                        <option>Smart Plug</option>
                                        <option>Printer</option>
                                        <option>WiFi</option>
                                    </select>
                                </div>
-->
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
                                   if(isset($_POST['divRole']) && !empty($_POST['divRole'])){ 
                                       $query .= ", user_role r Where d.userId = r.userId ";
                                    }     
                                   else{
                                       $query .= " WHERE ";
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
                                       $html .= "<li> {$row['id']} </li>";
                                       //echo $row['id'];
                                   }
                                     
                                   
                               }else{
                                   //send query
                                   echo "ERROR";
                                    $result = SqlQueryRaw($query);
                                    //echo $result;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $html .= "<li> {$row['id']} </li>";  
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
          <h3>Devices</h3>
          <p>This is where Devices go.</p> 
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
                            var modal = document.getElementById(modalType[type] + "Modal");
                            modal.style.visibility = 'visible';
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById("userInfo").innerHTML = this.responseText;
                                }
                            };

                            xmlhttp.open("GET", "util/find" + modalType[type] + ".php?id=" + id, true);
                            xmlhttp.send();  
                        }
                        
                        var modalType = ["user", "device", "log"];

                        function CloseModal(type){
                            var modal = document.getElementById(modalType[type] + "Modal").style.visibility = 'hidden';
                            modal.innerHTML = '';
                        }

                        function EditModal(event){
                            event.currentTarget.disabled = true;
                            document.getElementById('bdayModal').disabled = false;
                            document.getElementById('phoneModal').disabled = false;
                            document.getElementById('usernameModal').disabled = false;
                            document.getElementById('lnameModal').disabled = false;
                            document.getElementById('fnameModal').disabled = false;
                            document.getElementById('emailModal').disabled = false;
                            document.getElementById('saveButton').style.display = 'inline';
                            document.getElementById('cancelButton').style.display = 'inline';
                        }

                        function CancelEdit(event){
                            document.getElementById('bdayModal').disabled = true;
                            document.getElementById('phoneModal').disabled = true;
                            document.getElementById('usernameModal').disabled = true;
                            document.getElementById('lnameModal').disabled = true;
                            document.getElementById('fnameModal').disabled = true;
                            document.getElementById('emailModal').disabled = true;
                            document.getElementById('editButton').disabled = false;
                            document.getElementById('saveButton').style.display = 'none';
                            event.currentTarget.style.display = 'none';
                        }

                        function SaveUserModal(event){
                            var xmlhttp = new XMLHttpRequest();
                            var username, fName, lName, phone, bday, id, email;
                            id = document.getElementById('idModal').innerHTML;
                            email = document.getElementById('emailModal').value;
                            bday = document.getElementById('bdayModal').value;
                            phone = document.getElementById('phoneModal').value;
                            username = document.getElementById('usernameModal').value;
                            lname = document.getElementById('lnameModal').value;
                            fname = document.getElementById('fnameModal').value;

                            var url = "util/edituser" + ".php?id=" + id + 
                            "&username=" + username + "&fname=" + fname + "&lname=" + lname +
                            "&phone=" + phone + "&bday=" + bday + "&email=" + email;
                            //console.dir(url);
                            xmlhttp.open("GET", url, true);
                            xmlhttp.send();

                            document.getElementById('bdayModal').disabled = true;
                            document.getElementById('phoneModal').disabled = true;
                            document.getElementById('usernameModal').disabled = true;
                            document.getElementById('lnameModal').disabled = true;
                            document.getElementById('fnameModal').disabled = true;
                            document.getElementById('emailModal').disabled = true;
                            document.getElementById('editButton').disabled = false;
                            document.getElementById('cancelButton').style.display = 'none';
                            event.currentTarget.style.display = 'none';
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
                                       $html .= "<button style='display:block;width:95%'>{$row['id']}</button>";
                                       echo $row['id'];
                                   }       
                               }else{
                                   //send query
                                    $result = SqlQueryRaw($query);
                                    //echo $result;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $html .= "<button class='btn' onclick='OpenModal(0, "."{$row['id']}".");'  style='display:block;width:95%'>" . 
                                        "{$row['firstName']} {$row['lastName']} ({$row['userName']})". 
                                        "</button>";  
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
            <div id='userModal' style='visibility:hidden;'>
                <div class='modal-dialog modal-lg' style='z-index:10'>
                    <div class='modal-content' id='userInfo'>
                    
                    </div>
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
                                    <input type='text' class='form-control' value='{$row['firstName']}' id='fnameModal' disabled>
                                    <input type='text' class='form-control' value='{$row['lastName']}' id='lnameModal' disabled> 
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Username</span>
                                    </div>
                                <input type='text' class='form-control' value='{$row['userName']}' id='usernameModal' disabled>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Email</span>
                                    </div>
                                <input type='text' class='form-control' value='{$row['email']}' id='emailModal' disabled>
                                </div>
                            </div>
                            <div class='col-5'>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Phone#</span>
                                    </div>
                                    <input type='text' class='form-control' value='{$row['phoneNumber']}' id='phoneModal' disabled>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Birth Date</span>
                                    </div>
                                <input type='date' class='form-control' value='{$row['birthDate']}' id='bdayModal' disabled>
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
    </body>
</html>
