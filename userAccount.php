<?php
    session_start();

    $emailError = $userError = $passError = $nameError = $loginError = '';

    function EditAccount(){
        $_SESSION['edit'] = TRUE;
    }
    
    function ConfirmEdit(){ 
        //Save Logic Here
        unset($_SESSION['edit']);
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'addbootstrap.php';?>

        <title>Account Info</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
    </head>
        
    <body>
        <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1' style='text-transform:uppercase;'><?php echo $_SESSION['currentUser']; ?></h1>            
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
                                            <input type='text' class='form-control' placeholder=<?php if(!isset($_SESSION['email'])){ echo 'example12345@gmail.com';}else{echo $_SESSION['email'];}?> name='email' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>><span class='error'><?php echo $emailError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Username</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder=<?php if(!isset($_SESSION['currentUser'])){ echo 'Username';}else{echo $_SESSION['currentUser'];}?> name='username' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>><span class='error'><?php echo $userError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Name</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder='First Name' name='firstName' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php?></span>
                                            <input type='text' class='form-control' placeholder='Middle Name' name='middleName' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php?></span>
                                            <input type='text' class='form-control' placeholder='Last Name' name='lastName' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Password</span>
                                            </div>
                                            <input type='text' class='form-control' name='password' placeholder='<?php if(isset($_SESSION['password'])){echo $_SESSION['password']; }?>' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Phone #</span>
                                            </div>
                                            <input type='text' class='form-control' placeholder="<?php if(!isset($_SESSION['phone'])){ echo '555-555-5555';}else{echo $_SESSION['phone'];}?>" name='phone' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
                                        </div>
                                        <br>
                                        <div class='input-group mb-3'>
                                            <div class='input-group-prepend'>
                                                <span class='input-group-text'>Birth Date</span>
                                            </div>
                                            <input type='date' class='form-control' name='bday' value='<?php if(isset($_SESSION['bday'])){ echo $_SESSION['bday']; } ?>' <?php if(!isset($_SESSION['edit'])){ echo 'disabled';}?>> <span class='error'><?php echo $passError; ?></span>
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
                        <div class='contentBox'>
                            <h3 class='title2' style='margin-bottom:1.5rem;'>Package Information</h3>
                            <div class='row'>
                                <div class='col-1'></div>
                                <div class='col-10 row'>
                                    <div class='col-1'></div>
                                    <div class='form-check col-5'>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Wifi Only
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Printer Only
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Charging Only
                                        </label>
                                    </div><div class='form-check col-5'>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Wifi With Charging
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Printer With WiFi
                                        </label>
                                        <br><br>
                                        <label class='form-check-lable'>
                                            <input type='radio' class='form-check-radio' name='package0'> Charging With Printer
                                        </label>
                                    </div>
                                    <div class='col-1'>
                                        <button class='btn btn-secondary' type='submit' style='position:relative;margin-top:450%'>Subscribe</button>
                                    </div>
                                </div>
                                <div class='col-1'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>