<?php
include 'sqlFunctions.php'

$location = $_REQUEST['loc'];
$type = $_REQUEST['type'];

function GenerateUserId(){
    srand(make_seed());
    $temp = rand(10000, 99999);
    if(CheckForDuplicateUserId($temp) === TRUE){
        return GenerateUserId();
    }
    else{
        echo $temp;
        return $temp;
    }
}

function GenerateRuleId(){
    srand(make_seed());
    $temp = rand(10000, 99999);
    if(CheckForDuplicateRuleId($temp) === TRUE){
        return GenerateRuleId();
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

function CheckForDuplicateUserId($userId){
    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT id FROM devices';
    $result = $connection->query($sqlQuery);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['id'] == $userId){
                return TRUE;
            }
        } 
    }  
    return FALSE;
}

function CheckForDuplicateRuleId($userId){
    $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT id FROM access_rule';
    $result = $connection->query($sqlQuery);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['id'] == $userId){
                return TRUE;
            }
        } 
    }  
    return FALSE;
}

$id = GenerateUserId();

$query = "INSERT INTO devices VALUES ({$id}, $location)";
SqlQueryRaw($query);

switch($type){
    case "plug":
        $query = "INSERT INTO smartplugs(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    case "print":
        $query = "INSERT INTO printer(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    case "wifi":
        $query = "INSERT INTO wifi(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    default:
        break;
}

$query = "INSERT INTO package_device VALUES ({$id}, 2)";
SqlQueryRaw($query);

$ruleId = GenerateRuleId();

$query = "INSERT INTO access_rule VALUES ({$id}, 0, {$ruleId})"
SqlQueryRaw($query);
?>