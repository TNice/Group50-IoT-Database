<?php 

    session_start();
    include 'util/sqlFunctions.php';
    
    if(!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'NONE';
    }
    
    function useFilter(){
        if(isset($_POST['divId']) || $_POST['divId'] != ""){
            return true;
        }
        if(isset($_POST['divfName']) || $_POST['divfName'] != ""){
            return true;
        }
        if(isset($_POST['divlName']) || $_POST['divlName'] != ""){
            return true;
        }
        if(isset($_POST['divEmail']) || $_POST['divEmail'] != ""){
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
        }
    </script>
        <div class="tab">
          <button class="tablinks" onclick="openTab(event, 'Logs')">Logs</button>
          <button class="tablinks" onclick="openTab(event, 'Devices')">Devices</button>
          <button class="tablinks" onclick="openTab(event, 'User')">User</button>
        </div>

        <div id="Logs" class="tabcontent" style='display:none;'>
          
            <div class="background">  
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
                                    <input type="text" name="divType" placeholder="Time">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divLoc" placeholder="Device Type">
                                </div>
                                <div class='form-group'>
                                    <input type="text" name="divLoc" placeholder="Username">
                                </div>
                                
                            </form>
                
                        </div>
                    </div>
                    <div class='col-1'></div>
                    <div class='col-7'>
                        <div id='deviceList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Logs</h3>
                            <?php include 'createDeviceList.php'; ?>
                        </div>
                    </div>
                    <div class='col-1'></div>
                </div>   
            </div>    
            
            
            
        </div>

        <div id="Devices" class="tabcontent" style='display:none;'>
          <h3>Devices</h3>
          <p>This is where Devices go.</p> 
        </div>

        <div id="User" class="tabcontent" style='display:none;'>
            
            <div class="background">  
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
                                    <input type="submit" value="Submit" onclick="submitFunction()">
                                </div>
                            </form>
                
                        </div>
                    </div>
                    <div class='col-1'></div>
                    <div class='col-7'>
                        <div id='deviceList' class='contentBoxLight'>
                            <h3 class='title1' style='margin-top:0.25rem;'>Users</h3>
                            <?php 
                                $html ="<div><ul>";
                                $query = "Select * From Users";
                               if(useFilter()){
                                   $query .= " WHERE ";
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
                                       $query .= "firstName = {$_POST['divfName']}";
                                    }
                                    if(isset($_POST['divlName']) && !empty($_POST['divlName'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "lastName = {$_POST['divlName']}";
                                    }
                                    if(isset($_POST['divEmail']) && !empty($_POST['divEmail'])){
                                        if(strpos($query, "=")){
                                           $query .= ' and ';
                                       } 
                                       $query .= "email = {$_POST['divEmail']}";
                                    }
                                   echo $query;
                                   $result = SqlQueryRaw($query);
                                   
                                   while($row = mysqli_fetch_assoc($result)){
                                       $html .= "<li> {$row['id']} </li>";
                                   }
                                   
                               }else{
                                   //send query
                                    $result = SqlQueryRaw($query);
                                   echo $result;
                                   while($row = mysqli_fetch_assoc($result)){
                                       $html .= "<li> {$row['id']} </li>";
                                   }
                               }
                            
                                $html = "</ul></div>";
                             ?>
                        </div>
                       
                    </div>
                    <div class='col-1'></div>
                </div>   
            </div>    
            
        </div>
        
        
    </body>
    
    
</html>
