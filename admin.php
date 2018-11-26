<?php 
    include 'util/sqlFunctions.php';
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
          <h3>Logs</h3>
          <p>This is where logs go.</p>
        </div>

        <div id="Devices" class="tabcontent" style='display:none;'>
          <h3>Devices</h3>
          <p>This is where Devices go.</p> 
        </div>

        <div id="User" class="tabcontent" style='display:none;'>
          <h3>User</h3>
          <p>This is Users go</p>
            
                    <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>User Search</h1>            
            </div>
            
            <div class="row" style='max-width:100%;'>
                <div class='col-3' style='margin-left:2rem;'>
                    <div id='filters' class='contentBoxLight'>
                        <h5 class='title1'>Filters</h5>
                        <form>
                            <div class='form-group'>
                                <input type="text" name="divName" placeholder="User Id">
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divType" placeholder="First Name">
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divLoc" placeholder="Last Name">
                            </div>
                            <div class='form-group'>
                                <input type="text" name="divLoc" placeholder="Email">
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
            
        </div>
        
        
    </body>
    
    
</html>
