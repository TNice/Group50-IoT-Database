<?php
include 'sqlFunctions.php';

$location = $_REQUEST['loc'];
$type = $_REQUEST['type'];
$sDay = $_REQUEST['startDay'];
$eDay = $_REQUEST['endDay'];
$sTime = $_REQUEST['startTime'];
$eTime = $_REQUEST['endTime'];

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
   // $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT id FROM devices';
    //$result = $connection->query($sqlQuery);
    $result = SqlQueryRaw($sqlQuery);
        while($row = mysqli_fetch_assoc($result)){
            if($row['id'] == $userId){
                return TRUE;
            }
        } 
    return FALSE;
}

function CheckForDuplicateRuleId($userId){
   // $connection = new mysqli($GLOBALS['server'], $GLOBALS['user'], $GLOBALS['pass'], $GLOBALS['db']);
    $sqlQuery = 'SELECT ruleId FROM access_rule';
    $result = SqlQueryRaw($sqlQuery);
        while($row = mysqli_fetch_assoc($result)){
            if($row['ruleId'] == $userId){
                return TRUE;
            }
        } 
    
    return FALSE;
}

$id = GenerateUserId();

$query = "INSERT INTO devices VALUES ({$id}, $location)";
SqlQueryRaw($query);
echo $type;
switch($type){
    case "Smart Plug":
        $query = "INSERT INTO smartplug(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    case "Printer":
        $query = "INSERT INTO printer(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    case "WiFi":
        $query = "INSERT INTO wifi(id) VALUES ({$id})";
        SqlQueryRaw($query);
        break;
    default:
        break;
}

$query = "INSERT INTO package_device VALUES ({$id}, 2);";
echo $query;
SqlQueryRaw($query);

$ruleId = GenerateRuleId();

$query = "INSERT INTO access_rule VALUES ({$id}, 0, {$ruleId}, 'any', 'any')";
SqlQueryRaw($query);

$query = "INSERT INTO accesstime_rule VALUES ({$id}, '{$sDay}', '{$eDay}', '{$sTime}', '{$eTime}')";
SqlQueryRaw($query);

?>