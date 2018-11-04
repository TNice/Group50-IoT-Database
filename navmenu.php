<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

function DeterminLogButtons(){
    $loginButtons = "<li class='nav-item mr-auto'><a class='nav-link' href='login.php'>Login</a></li>";
    $loginActiveButtons = "<li class='nav-item'><a class='nav-link active' href='login.php'>Login</a></li>";
    $logoutButtons = "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout</a></li>";
    $userButton0 = "<li class='nav-item'><a class='nav-link' href='userAccount.php'>";
    $userButton1 = "</a></li><li class='nav-link'>|</li>";
    $currentPage = basename($_SERVER['PHP_SELF']);
    if(!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] == NULL)
    {
        if($currentPage == 'login.php'){
            echo $loginActiveButtons;
        }

        else{
            echo $loginButtons;
        }
    }
    else {
        echo $userButton0 . GetUserName($_SESSION['currentUser']) . $userButton1 . $logoutButtons;
    }
}

function GetUserName($id){
  $user = 'root';
  $pass = '12345';
  $server = 'localhost';
  $db = 'testlogin';
  
  $connection = mysqli_connect($server, $user, $pass, $db);
  if(!$connection){
    die("Connection Failed: " . mysqli_connect_error());
  }

  $query = "SELECT username FROM users WHERE id = {$id}";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['username'];

}
?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
  <a class="navbar-brand" href="#">IoT</a>
  <ul class="navbar-nav">
    <li class="nav-link">|</li>
    <li class="nav-item">
      <a <?php if(basename($_SERVER['PHP_SELF']) == 'home.php'){echo "class='nav-link active'";} else{echo 'class="nav-link"'; }?> href="home.php">Home</a>
    </li>
    <li class="nav-link">|</li>
    <li class="nav-item">
      <a <?php if(basename($_SERVER['PHP_SELF']) == 'packages.php'){echo "class='nav-link active'";} else{echo 'class="nav-link"'; }?> href="packages.php">Packages</a>
    </li>
    <li class="nav-link">|</li>
    <li class="nav-item">
      <a <?php if(basename($_SERVER['PHP_SELF']) == 'devices.php'){echo "class='nav-link active'";} else{echo 'class="nav-link"'; }?> href="devices.php">Devices</a>
    </li>
    <li class="nav-link">|</li>
    <li class="nav-item">
      <a <?php if(basename($_SERVER['PHP_SELF']) == 'findDevice.php'){echo "class='nav-link active'";} else{echo 'class="nav-link"'; }?> href="findDevice.php">Find Devices</a>
    </li>
    <li class="nav-link">|</li>
    <?php DeterminLogButtons();?>
  </ul>
</nav>
