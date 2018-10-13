<?php
session_start();
?>

<form id='login' action='login.php' action method='post'>
    Email/Username: <input type='text' name='email'>
    <br><br>
    Password: <input type='text' name='password'>
    <br><br>
    <input type=submit name='submit'>
</form>