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

?>