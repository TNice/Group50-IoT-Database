<?php

$user = 'root';
$pass = '12345';
$server = 'localhost';
$db = 'project';

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

function GetPackageName($id){
  $connection = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
  if(!$connection){
    die("Connection Failed: " . mysqli_connect_error());
  }

  $query = "SELECT packageName FROM packages WHERE id = {$id}";
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

    $result = mysqli_query($connection, $query);

    return mysqli_fetch_assoc($result);
}

//Returns mysqli_query result
function SqlQueryRaw($query){

  $connection = mysqli_connect($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    if(!$connection){
      die("Connection Failed: " . mysqli_connect_error());
    }
  
    return mysqli_query($connection, $query);
}


?>