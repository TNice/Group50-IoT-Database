<?php
session_start();

$loginError = '';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $_SESSION['email'] = $_POST['email'];
    $password = $_POST['password'];
    //$login = LoginRequest($email, $password);

    if(LoginRequest($_SESSION['email'], $password)){
        header('Location: home.php');
    }
    else{
        $loginError = 'Username or Password Is Incorrect';
    }
}

function LoginRequest($email, $password){
    if(empty($email) || empty($password)){
        return FALSE;
    }

    $connection = mysqli_connect('localhost', 'root', '12345', 'testlogin');
    if(!$connection){
        //return false;
        die("Connection Failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);


    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            if(($row['email'] == $email || $row['username'] == $email) && $row['password'] == $password){              
                $_SESSION['currentUser'] = $row['username'];
                return TRUE;           
            }
            else{
                return FALSE;
            }
        }
    }
    else{
        die("NO USERS");
    }
}

?>

<style>
.error{color: red;}
</style>

<form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Email/Username: <input type='text' name='email'>
    <br><br>
    Password: <input type='text' name='password'>
    <br><br>
    <input type=submit name='submit' value="Submit">
    <br><br>
    <span class='error'><?php echo $loginError; ?></span>
</form>