<?php
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$location = $_REQUEST['loc'];
$type = $_REQUEST['type'];
$power = $_REQUEST['power'];
$ink = $_REQUEST['ink'];
$page = $_REQUEST['page'];
$ip = $_REQUEST['ip'];

$query = "UPDATE devices SET location = {$location} WHERE id = {$id}";
SqlQueryRaw($query);


switch ($type){
    case 'plug':
        $query = "UPDATE smartplug SET powerUseage = {$power} WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    case 'wifi':
        $query = "UPDATE wifi SET ipv4 = {$ip} WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    case 'print':
        $query = "UPDATE printer SET inkLevel = {$ink}, pageCount = {$page} WHERE id = {$id}";
        SqlQueryRaw($query);
        break;
    default:
        break;
}

?>