<?php 

    session_start();
    include 'util/sqlFunctions.php';
    
    if(!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'NONE';
    }
    
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
        
        return false;
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
        
        return false;
    }

//    $userId = $_POST['divId'];
//    $firstName = $_POST['divfName'];
//    $lastName = $_POST['divlName'];
//    $email = $_POST['divEmail'];

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
                            <form>
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
                                    <input type="text" name="divUserName" placeholder="Username">
                                </div>
                                <div class='form-group'>
                                    <select name="Device">
                                        <option>Device</option>
                                        <option>Smart Plug</option>
                                        <option>Printer</option>
                                        <option>WiFi</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <select name="Role">
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
                        <div id='deviceList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Logs</h3>
                            <?php include 'createDeviceList.php'; ?>
                            <?php 
                                $html ="<div><ul>";
                                $query = "Select * From deviceLogs";
                               if(useLogFilter()){
                                   $query .= " WHERE ";
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
                                       $query .= "result = '{$_POST['divResult']}'";
                                    }
                                    if(isset($_POST['divUserName']) && !empty($_POST['divUserName'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "username = '{$_POST['divUserName']}'";
                                    }
                                   echo $query;
                                   $result = SqlQueryRaw($query);
                                   
                                   while($row = mysqli_fetch_assoc($result)){
                                       $html .= "<li> {$row['id']} </li>";
                                       //echo $row['id'];
                                   }
                                   
                                   
                               }else{
                                   //send query
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
                                    <select name= "Package">
                                        <option>Package</option>
                                        <option>Basic</option>
                                        <option>Premium</option>
                                        <option>Gold</option>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <select name="Role">
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
                        <div id='deviceList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Users</h3>
                            <?php 
                                $html ="<div class='container' style='overflow:hidden;overflow-y:scroll;height:15em;max-height:90%'><div class='btn-group' style='width:100%'>";
                                $query = "Select * From Users";
                               if(useUserFilter()){
                                   $query .= " WHERE ";
                                   if(isset($_POST['divId']) && !empty($_POST['divId'])){
                                       if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "id = '{$_POST['divId']}'";
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
                                       //echo $row['id'];
                                   }       
                               }else{
                                   //send query
                                    $result = SqlQueryRaw($query);
                                    //echo $result;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $html .= "<button style='dsiplay:block;width:95%'> {$row['id']} </button>";  
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
            
        </div>
        
        
    </body>
    
    
</html>
