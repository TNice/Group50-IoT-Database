<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];

$sTime = $eTime = $sDay = $eDay;

$query = "SELECT * FROM accesstime_rule WHERE ruleId = {$ruleId}";
$row = SqlQuery($query);

$result = array($row['startTime'], $row['endTime'], $row['startDay'], $row['endDay']);
echo $result;
?>