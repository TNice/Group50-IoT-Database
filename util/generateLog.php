<?php



$deviceId = $_REQUEST['deviceId'];
$userId = $_REQUEST['userId'];
//generate log Id
//time
 $currentTime = date("h:i:sa");

$query = "INSERT INTO deviceLogs values({$deviceId}, {$userId}, {$logId}, {$currentTime})"


?>