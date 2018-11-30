<?php
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$username = $_REQUEST['username'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$phone = $_REQUEST['phone'];
$bday = $_REQUEST['bday'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];

$query = "UPDATE users 
SET email = '{$email}', userName = '{$username}', firstName = '{$fname}', lastName = '{$lname}', phoneNumber = '{$phone}', birthDate = '{$bday}', password = '{$password}' 
WHERE id = {$id};";
SqlQueryRaw($query);

echo $query;
?>