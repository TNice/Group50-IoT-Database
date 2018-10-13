<?php
session_start();

function DeterminLogButtons(){
    $loginButtons = "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li><li class='nav-link'>|<li><li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
    $loginActiveButtons = "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li><li class='nav-link'>|<li><li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
    $signUpActiveButtons = "<li class='nav-item'><a class='nav-link active' href='signup.php'>Sign Up</a></li><li class='nav-link'>|<li><li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
    $logoutButtons = "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout</a></li>";
    $currentPage = basename($_SERVER['PHP_SELF']);
    if(!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] == NULL)
    {
        if($currentPage == 'login.php'){
            echo $loginActiveButtons;
        }
        elseif($currentPage == 'signup.php'){
            echo $signUpActiveButtons;
        }
        else{
            echo $loginButtons;
        }
    }
    else {
        echo $logoutButtons;
    }
}
?>

<!--<div class='menu'>
    <ul class='topnav'>
        <li><a <?php if(basename($_SERVER['PHP_SELF']) == 'home.php'){echo "class='active'";}?> href='home.php'>Home</a></li>
        <li><a <?php if(basename($_SERVER['PHP_SELF']) == 'er.php'){echo "class='active'";}?> href='er.php'>ER Model</a></li>
        <li><a <?php if(basename($_SERVER['PHP_SELF']) == 'tables.php'){echo "class='active'";}?> href=tables.php>Tabels</a></li>
        <?php DeterminLogButtons(); ?>
    </ul>
</div>-->

<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <a class="navbar-brand" href="#">Group50</a>
  <ul class="navbar-nav">
    <li class="nav-link">|<li>
    <li class="nav-item">
      <a <?php if(basename($_SERVER['PHP_SELF']) == 'home.php'){echo "class='nav-link active'";} else{echo 'class="nav-link"'; }?> href="#">Home</a>
    </li>
    <li class="nav-link">|<li>
    <li class="nav-item">
      <a class="nav-link" <?php if(basename($_SERVER['PHP_SELF']) == 'er.php'){echo "class='active'";}?> href="er.php">ER</a>
    </li>
    <li class="nav-link">|<li>
    <li class="nav-item">
      <a class="nav-link" <?php if(basename($_SERVER['PHP_SELF']) == 'tables.php'){echo "class='active'";}?> href="er.php">Tables</a>
    </li>
    <li class="nav-link">|<li>
    <?php DeterminLogButtons();?>
  </ul>
</nav>

