<?php
session_unset();
session_start();

$server = 'localhost';
$user = 'root';
$pass = '12345';
$db = 'testlogin';

$emptyFieldError = '* Required';
$error = FALSE;
$loginError = $userError = $emailError = $passError = $result = '';

if(!isset($_SESSION['username'])){
    $_SESSION['username'] = '';
}
if(!isset($_SESSION['email'])){
    $_SESSION['email'] = '';
}
$password = '';

function testData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['password'])){
       $passError = $emptyFieldError;
       $error = TRUE;
    }
    else{
        $password = testData($_POST['password']);
        if(!preg_match('/.{6,}/', $password)){
            $passError = '* Password must be atleast 6 characters long';
            $error = TRUE;
        }
    }
    if(empty($_POST['email'])){
        $emailError = $emptyFieldError;
        $error = TRUE;
    }
    else{
        $_SESSION['email'] = testData($_POST['email']);
        if(!filter_var($_SESSION['email'], FILTER_VALIDATE_EMAIL)){
            $emailError = '* Invalid Email';
        }
        elseif(CheckForDuplicateEmail($_SESSION['email']) === TRUE){
            $emailError = '* Account Already Created With That Email';
            $error = TRUE;
        }
    }
    if(empty($_POST['username'])){
        $userError = $emptyFieldError;
        $error = TRUE;
    }
    else{
        $_SESSION['username'] = testData($_POST['username']);
        if(!preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['username'])){
            $userError = '* Invalid Username: Only AlphaNumeric Characters Allowed';
            $error = TRUE;
        }
        elseif(CheckForDuplicateUser($_SESSION['username']) === TRUE){
            $userError = '* Username Already Taken';
            $error = TRUE;
        }
    }   

    if($error === FALSE){
       if(AddUserToDB($_SESSION['email'], $_SESSION['username'], $password) === TRUE){
           header('home.php');
       }
    }
}

function CheckForDuplicateUser($username){
    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT username FROM users';
    $result = $connection->query($sqlQuery);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['username'] == $username){
                return TRUE;
            }
        } 
    }  
    return FALSE;  
}

function CheckForDuplicateEmail($email){
    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT email FROM users';
    $result = $connection->query($sqlQuery);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['email'] == $email){
                return TRUE;
            }
        } 
    }  
    return FALSE;  
}

/*function AddUserToDB($email, $firstName, $lastName, $phoneNumber, $birthDay, $password){
    $password = (string)$password;
    $email = (string)$email;
    $firstName = (string)$firstName;
    $lastName = (string)$lastName;
    $birthDay = (string)$birthDay;
    $phoneNumber = (string)$phoneNumber;

    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = "INSERT INTO users (email, username, password) VALUES ('{$email}', '{$firstName}', '{$lastName}', '{$brithDay}', '{$phoneNumber}', '{$password}')";
    
    if($connection->query($sqlQuery) === TRUE){
        $_SESSION['result'] = "{$email}, {$firstName}, {$lastName}, {$brithDay}, {$phoneNumber}, {$password} ADDED";
        unset($_SESSION['username']);
        unset($_SESSION['email']);
    }
    else{
        $_SESSION['result'] = $connection->error . '\n' . $sqlQuery;
    }
}*/

function AddUserToDB($email, $username, $password){
    $password = (string)$password;
    $email = (string)$email;
    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = "INSERT INTO users (email, username, password) VALUES ('{$email}', '{$username}', '{$password}')";
    
    if($connection->query($sqlQuery) === TRUE){
        $_SESSION['result'] = "{$email}, {$username}, {$password} ADDED";
        unset($_SESSION['username']);
        unset($_SESSION['email']);
    }
    else{
        $_SESSION['result'] = $connection->error . '\n' . $sqlQuery;
    }
}
?>

<style>
.error{
    color: #ff0000;
}
</style>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'addbootstrap.php';?>

        <title>Database Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
    </head>

    <body>
        
        <div class="background"> 
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>Create An Account</h1>            
            </div>
            <?php include 'navmenu.php'; ?>
            <div class='container-fluid'>
            <div class='row'>
                <div class='col-1'></div>
                <div class='col-10'>
                    <div class='contentBox row' style='margin-left:0px'>           
                        <div class='col-11'>
                            <h5 class='title1' style='margin-bottom:1.5rem'>Account Info</h5>
                            <form id='signup' action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Email</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='exampl123@yahoo.com' name='email' value='<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>'> <span class='error'><?php echo $emailError; ?></span>
                                </div>
                                <br>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Username</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='Username' name='username' value='<?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?>'> <span class='error'><?php echo $userError; ?></span>
                                </div>
                                <br>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Name</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='First Name' name='firstName'> <span class='error'><?php?></span>
                                    <input type='text' class='form-control' placeholder='Middle Name' name='middleName'> <span class='error'><?php?></span>
                                    <input type='text' class='form-control' placeholder='Last Name' name='lastName'> <span class='error'><?php?></span>
                                </div>
                                <br>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Password</span>
                                    </div>
                                    <input type='text' class='form-control' name='password'> <span class='error'><?php echo $passError; ?></span>
                                </div>
                                <br>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Phone #</span>
                                    </div>
                                    <input type='text' class='form-control' placeholder='555-555-5555' name='username'> <span class='error'><?php echo $passError; ?></span>
                                </div>
                                <br>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text'>Birth Date</span>
                                    </div>
                                    <input type='date' class='form-control' name='bday'> <span class='error'><?php echo $passError; ?></span>
                                </div>
                                <br>
                                <button class='btn btn-secondary' type='submit' name='submit'>Create Account</button>
                                <br>
                                <span class='error'><?php echo $loginError; ?></span>
                            </form>
                        </div>
                        </div class='col-1'>
                    </div>
                </div>
                <div class='col-1'></div>
            </div>
            </div>
        </div>
    <body>
</html>
