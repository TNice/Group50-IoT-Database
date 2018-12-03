<?php
include 'sqlFunctions.php';

$type = $power = $ink = $page = $ip = '';

if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}
if(isset($_REQUEST['loc'])){
    $location = $_REQUEST['loc'];
}
if(isset($_REQUEST['type'])){
    $type = $_REQUEST['type'];
}
if(isset ($_REQUEST['power'])){
    $power = $_REQUEST['power'];
}
if(isset ($_REQUEST['link'])){
    $ink = $_REQUEST['ink'];
}
if(isset ($_REQUEST['page'])){
    $page = $_REQUEST['page'];
}
if(isset ($_REQUEST['ip'])){
    $ip = $_REQUEST['ip'];
}
if(isset ($_REQUEST['sDay'])){
    $sDay = $_REQUEST['sDay'];
}
if(isset ($_REQUEST['eDay'])){
    $eDay = $_REQUEST['eDay'];
}
if(isset ($_REQUEST['sTime'])){
    $sTime = $_REQUEST['sTime'];
}
if(isset ($_REQUEST['eTime'])){
    $eTime = $_REQUEST['eTime'];
}

$query = "UPDATE devices SET location = '{$location}' WHERE id = {$id}";
SqlQueryRaw($query);


switch ($type){
    case 'plug':
        $query = "UPDATE smartplug SET powerUseage = '{$power}' WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    case 'wifi':
        $query = "UPDATE wifi SET ipv4 = '{$ip}' WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    case 'print':
    
        $query = "UPDATE printer SET inkLevel = '{$ink}', pageCount = '{$page}' WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    default:
        break;
}

$query = "SELECT * FROM access_rule WHERE deviceId = {$id}";
$row = SqlQuery($query);

if(isset($row['ruleId'])){
    $query = "UPDATE accesstime_rule SET startTime = '{$sTime}', endTime = '{$eTime}', startDay = '{$sDay}', endDay = '{$eDay}' WHERE ruleId = {$row['ruleId']};";
    echo $query;
    SqlQueryRaw($query);
}



?>