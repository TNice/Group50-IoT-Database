<?php
#restarts session if terminal was accessed
if(isset($_SESSION['isTerminal'])){
    session_unset();
}
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
           ;
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

<form id='signup' action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
    Email: <input type='text' name='email' value='<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>'> <span class='error'><?php echo $emailError; ?></span>
    <br><br>
    Username: <input type='text' name='username' value='<?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?>'> <span class='error'><?php echo $userError; ?></span>
    <br><br>
    Password: <input type='text' name='password'> <span class='error'><?php echo $passError; ?></span>
    <br><br>
    <input type=submit name='submit'>
    <br>
    <span class='error'><?php echo $loginError; ?></span>
</form>
<br><br>
<span style='color:#00ff00;'><?php if(isset($_SESSION['result'])){echo $_SESSION['result']; }?></span>