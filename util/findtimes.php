<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];

$sTime = $eTime = $sDay = $eDay = '';

$query = "SELECT * FROM access_rule WHERE deviceId = {$id}";
//echo $query . " | ";
$row = SqlQuery($query);

if(isset($row['ruleId'])){
    $ruleId = $row['ruleId'];
    $query = "SELECT * FROM accesstime_rule WHERE ruleId = {$ruleId}";
    //echo $query . " | ";
    $row = SqlQuery($query);

    $sTime = $row['startTime'];
    $eTime = $row['endTime'];
    $sDay = $row['startDay'];
    $eDay = $row['endDay'];

    $result = "{$sTime}|{$eTime}|{$sDay}|{$eDay}";
    echo $result;
}
else{
    echo "Any|Any|Any|Any";
}
?>