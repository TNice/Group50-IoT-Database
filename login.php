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

<html style='overflow:hidden'>
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
        <div class="background" style='height:100%;'> 
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>IoT Database Project</h1>            
            </div>
            <?php include 'navmenu.php'; ?>
            <div class='row'>
                <div class='col-3'></div>
                <div class='col-6 contentBox row' style='height: 22.5rem;margin-top: 1rem;'>
                    <div class='col-1'></div>
                    <div class='col-10'>
                        <form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <label for="email"><h4>Email address:</h4></label>
                                <input name='email' type="email" class="form-control" id="email">
                            <label for="pwd"><h4 style='margin-top:1rem;'>Password:</h4></label>
                                <input name='password' type="password" class="form-control" id="pwd">
                            <div class="form-check" style='text-align:right;margin:0.5rem'>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"> Remember me
                                </label>
                            </div>
                            <button type="submit" class="btn btn-secondary">Submit</button>&nbsp&nbsp&nbsp&nbsp&nbsp                                     
                            <a class="btn btn-secondary" href='signup.php'>Create Account</a>
                            <br><br>
                            <span class='text-danger'><?php echo $loginError; ?></span>
                        </form>  
                    </div>
                    <div class='col-1'></div>
                </div>
                <div class='col-3'></div>
            </div>
        </div>
    </body>
</html>