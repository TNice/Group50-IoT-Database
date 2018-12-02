<?php
include 'sqlFunctions.php';

function GenerateLogId(){
    srand(make_seed());
    $temp = rand(10000, 99999);
    if(CheckForDuplicateLogId($temp) === TRUE){
        return GenerateLogId();
    }
    else{
        echo $temp;
        return $temp;
    }
}


function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return $sec + $usec * 1000000;
}

function CheckForDuplicateLogId($logId){
   // $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT logId FROM deviceLogs';
    //$result = $connection->query($sqlQuery);
    $result = SqlQueryRaw($sqlQuery);
        while($row = mysqli_fetch_assoc($result)){
            if($row['logId'] == $logId){
                return TRUE;
            }
        }
    return FALSE;
}

session_start();
$userId =  $_SESSION['currentUser'];

$deviceId = $_REQUEST['deviceId'];
$connectResult = $_REQUEST['connectResult'];

$logId = GenerateLogId();
//generate log Id
//time
$currentTime = time();

$query = "INSERT INTO deviceLogs values({$deviceId}, {$userId}, {$logId}, {$connectResult}, {$currentTime});";
    
$row = SqlQuery($query); 
    
    


?>