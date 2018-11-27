<?php
    session_start();

    include 'util/sqlFunctions.php';

    $emailError = $userError = $passError = $nameError = $loginError = '';
    $fName = $lName = $username = $password = $email = $phone = $bday = $package = '';

    $package = UserHasPackage($_SESSION['currentUser']);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['packageButton'])){
            UpdatePackages();
        }
        if(isset($_POST['saveAccount'])){
            if(CheckUserPassword($_SESSION['currentUser'], $_POST['oldpass']) === TRUE){
                $query = "UPDATE users 
                SET email = {$_POST['email']}, userName = {$_POST['username']}, firstName = {$_POST['firstName']}, 
                lastName = {$_POST['lastName']}, phoneNumber = {$_POST['phone']}, birthDate = {$_POST['bday']}, password = {$_POST['password']} 
                WHERE id = {$_SESSION['currentUser']};";
                SqlQuery($query);
            }
        }
    }
    SetUserInfo();

   function SetUserInfo(){
        $query = "SELECT * FROM users WHERE id = {$_SESSION['currentUser']};";
        $row = SqlQuery($query);
        $GLOBALS['username'] = $row['userName'];
        $GLOBALS['email'] = $row['email'];
        $GLOBALS['password'] = $row['password'];
        
        if(!isset($row['firstName']) || $row['firstName'] === NULL){
            $GLOBALS['fName'] = 'First Name';
        }
        else{
            $GLOBALS['fName'] = $row['firstName'];
        }
        
        if(!isset($row['lastName']) || $row['lastName'] === NULL){
            $GLOBALS['lName'] = 'Last Name';
        }
        else{
            $GLOBALS['lName'] = $row['lastName'];
        }
        
        if(!isset($row['phoneNumber']) || $row['phoneNumber'] === NULL){
            $GLOBALS['phone'] = '555-555-5555';
        }
        else{
            $GLOBALS['phone'] = $row['phoneNumber'];
        }

        if(isset($row['birthDate']) && $row['birthDate'] !== NULL){
            $GLOBALS['bday'] = $row['birthDate'];
        }
        //ADD PHONE NUMBER AND BIRTH DATE AS WELL

        $row = SqlQuery("SELECT id FROM packages p, user_package u 
                        WHERE p.id = u.packageId and u.userId = {$_SESSION['currentUser']};");
        $GLOBALS['package'] = $row['id'];
   }

   function UpdatePackages(){
       if(isset($_POST['package'])){ 
            if($GLOBALS['package'] === NULL){
                $query = "INSERT INTO user_package VALUES ({$_SESSION['currentUser']}, {$_POST['package']});";
            }
            else{
                $query = "UPDATE user_package SET packageId = {$_POST['package']} WHERE userId = {$_SESSION['currentUser']};";
            }
            if($GLOBALS['package'] !== $_POST['package']){
                SqlQueryRaw($query);  
                $GLOBALS['package'] = $_POST['package'];
            }
            unset($_POST['package']);
       }
   }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'util/addbootstrap.php';?>

        <title>Account Info</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>

        <script>
        function EnableInputs(){
            document.getElementById("email").disabled = false;
            document.getElementById("username").disabled = false;
            document.getElementById("fname").disabled = false;
            document.getElementById("lname").disabled = false;
            document.getElementById("phone").disabled = false;
            document.getElementById("bday").disabled = false;
            document.getElementById("password").disabled = false;
        }
        function DisableInputs(){
            document.getElementById("email").disabled = true;
            document.getElementById("username").disabled = true;
            document.getElementById("fname").disabled = true;
            document.getElementById("lname").disabled = true;
            document.getElementById("phone").disabled = true;
            document.getElementById("bday").disabled = true;
            document.getElementById("password").disabled = true;
        }
        function HandleEditButton(event){
            EnableInputs();
            document.getElementById("saveButton").style.display = 'inline';
            document.getElementById("cancelButton").style.display = 'inline';
            document.getElementById("oldpassword").style.display = 'inline';
            document.getElementById("password").value = '';
            event.currentTarget.disabled = true;
        }

        function HandleCancelButton(event){
            DisableInputs();
            document.getElementById("saveButton").style.display = 'none';
            document.getElementById("editButton").disabled = false;
            document.getElementById("oldpassword").style.display = 'none';
            document.getElementById("password").value = '';
            event.currentTarget.style.display = 'none';
        }

        window.onload = DisableInputs;
    </script>
    </head>
    <body>
        <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1' style='text-transform:uppercase;'><?php echo GetUserName($_SESSION['currentUser']); ?></h1>            
            </div>   
            <div id='general'></div>
            <?php include 'navmenu.php'; ?>
            <div class='row'>
                <div class='col-3'>
                    <div class='list-group list-group-flush contentBox2 sticky-top stickyOffset'>
                        <li class='list-group-item homeTitle' style='font-weight:bold;color:lightgrey;'>Info</li>
                        <a href='#general' class='list-group-item homeList' style='color:lightgrey;'>General</a>
                        <a href='#package' class='list-group-item homeList' style='color:lightgrey;'>Package</a>
                    </div>
                </div>
                <div class='col-9'>
                    <div style='margin-right:3rem'>
                        <div class='contentBox'>
                            <h3 class='title2' style='margin-bottom:1.5rem;'>General Information</h3>
                            <div class='row'>
                                    <div class='col-1'></div>
                                    <form class='col-10' id='accountEdit' action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Email</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='<?php echo $email; ?>' name='email' id='email' ><span class='error'><?php echo $emailError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Username</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='<?php echo $username;?>' name='username' id='username' ><span class='error'><?php echo $userError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Name</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='<?php echo $fName; ?>' name='firstName' id='fname'> <span class='error'><?php?></span>
                                            <input type='text' class='form-control' placeholder='<?php echo $lName; ?>' name='lastName' id='lname'> <span class='error'><?php?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Password</span>
                                            </div>
                                            <input type='password' class='form-control' name='password' id='password' value='<?php echo $password;?>'> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <div id='oldpassword' style='display:none'>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Old Password</span>
                                            </div>
                                            <input type='password' class='form-control' name='oldpass' value=''> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Phone #</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder="<?php echo $phone; ?>" name='phone' id='phone'> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Birth Date</span>
                                            </div>
                                            <input type='date' class='form-control' name='bday' id='bday' value='<?php echo $bday; ?>'> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <button class='btn btn-secondary' onclick='HandleEditButton(event);return false;' style='margin-right:0.5rem' name='Edit' id='editButton'>Edit</button>
                                        <button class='btn btn-secondary' type='submit' style='display:none;margin-right:0.5rem;' name='Save' id='saveButton'>Save</button> 
                                        <button class='btn btn-secondary' onclick='HandleCancelButton(event);return false;' style='display:none' name='Cancel' id='cancelButton'>Cancel</button> 
                                        <button class='btn btn-danger' onclick='return false;' style='float:right;' name='deletAccount'>Delete Account</button>
                                        <br>
                                        <span class='error'><?php echo $loginError; ?></span>
                                    </form>
                                    <div class='col-1'></div>
                                </div>       
                        </div>
                        <div id='package'></div>
                        <br>
                        <?php                            
                            if($GLOBALS['package'] !== NULL){
                                $element = 
                                "<div class='contentBox'>
                                    <h3 class='title2'>" . GetPackageName($GLOBALS['package']) . "</h3>
                                    <div class='row'>
                                        <div class='col-6'>
                                            Package Info
                                        </div>
                                        <div class='col-6'>    
                                            Get Devices for package with sql package
                                        </div>
                                    </div>
                                </div>";
                                echo $element;
                            }
                            //If user is subscribed to package add a current package tab
                        ?>
                        <div class='contentBox'>
                            <h3 class='title2' style='margin-bottom:1.5rem;'>Subscribe To Package</h3>
                            <!--Radio button values for packages must be the corisponding package id-->
                            <form action='<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post' id='updatePackage'>
                            <div class='row'>
                                <div class='col-1'></div>
                                <div class='col-10 row'>
                                    <div class='col-1'></div>
                                    <div class='form-check col-5'>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='0'> Package 0
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='1'> Package 1
                                        </label>
                                         <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='2'> Package 2
                                        </label>
                                    </div>
                                    <div class='form-check col-5'>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='3'> Wifi With Charging
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='4'> Printer With WiFi
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package' value='5'> Charging With Printer
                                        </label>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                            </div>
                            <div class='row'>
                                <div class='col-9'></div>
                                <div class='col-3'>
                                        <button name='packageButton' class='btn btn-secondary' type='submit'>Subscribe</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>