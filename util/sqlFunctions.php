<?php

$user = 'root';
$pass = '12345';
$server = 'localhost';
$db = 'testlogin';

function GetUserName($id){    
    $connection = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    if(!$connection){
      die("Connection Failed: " . mysqli_connect_error());
    }
  
    $query = "SELECT username FROM users WHERE id = {$id}";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
  
}

//returns mysqli_fetch_assoc result
function SqlQuery($query){
  $connection = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    if(!$connection){
      die("Connection Failed: " . mysqli_connect_error());
    }
  
    $query = "SELECT username FROM users WHERE id = {$id}";
    $result = mysqli_query($connection, $query);

    return mysqli_fetch_assoc($result);
}

//Returns mysqli_query result
function SqlQueryRaw($query){

  $connection = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    if(!$connection){
      die("Connection Failed: " . mysqli_connect_error());
    }
  
    $query = "SELECT username FROM users WHERE id = {$id}";
    return mysqli_query($connection, $query);
}

function InsertToTable($table, $values){

}

?>