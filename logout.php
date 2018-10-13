<?php
session_start();
$_SESSION['currentUser'] = NULL;
header('Location: home.php');
?>