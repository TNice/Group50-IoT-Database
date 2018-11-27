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
    }
    SetUserInfo();

    function EditAccount(){
        $_SESSION['edit'] = TRUE;
    }
    
    function ConfirmEdit(){ 
        //Save Logic Here
        unset($_SESSION['edit']);
    }

   function SetUserInfo(){
        $query = "SELECT * FROM users WHERE id = {$_SESSION['currentUser']};";
        $row = SqlQuery($query);
        $GLOBALS['username'] = $row['userName'];
        $GLOBALS['email'] = $row['email'];
        $GLOBALS['password'] = $row['password'];
        if(!isset($row['fName']) || $row['fName'] === NULL){
            $GLOBALS['fName'] = 'First Name';
        }
        else{
            $GLOBALS['fName'] = $row['fName'];
        }
        if(!isset($row['lName']) || $row['lName'] === NULL){
            $GLOBALS['lName'] = 'Last Name';
        }
        else{
            $GLOBALS['lName'] = $row['lName'];
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
                                            <input type='text' class='form-control' placeholder='<?php echo $email; ?>' name='email' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>><span class='error'><?php echo $emailError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Username</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='<?php echo $username;?>' name='username' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>><span class='error'><?php echo $userError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Name</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='<?php echo $fName; ?>' name='firstName' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php?></span>
                                            <input type='text' class='form-control' placeholder='<?php echo $lName; ?>' name='lastName' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Password</span>
                                            </div>
                                            <input type='password' class='form-control' name='password' value='<?php echo $password;?>' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Phone #</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder="<?php echo $phone; ?>" name='phone' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Birth Date</span>
                                            </div>
                                            <input type='date' class='form-control' name='bday' value='<?php echo $bday; ?>' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <button class='btn btn-secondary' type='submit' name='Edit'>Edit</button>&nbsp&nbsp&nbsp&nbsp&nbsp
                                        <button class='btn btn-danger' type='submit' name='deletAccount'>Delete Account</button>
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