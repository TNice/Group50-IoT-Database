<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];
$type = $_REQUEST['type'];

$query = "DELETE FROM package_device WHERE deviceId = {$id};";
SqlQueryRaw($query);
$query = "DELETE FROM deviceLogs WHERE deviceId = {$id};";
SqlQueryRaw($query);
$query = "DELETE FROM package_device WHERE deviceId = {$id};";
SqlQueryRaw($query);
$query = "DELETE FROM access_rule WHERE deviceId = {$id};";
SqlQueryRaw($query);


$query = 'no type';
switch ($type){
    case 'plug':
        $query = "DELETE FROM smartplug WHERE id = {$id}";
        
        SqlQueryRaw($query);
        break;
    case 'wifi':
        $query = "DELETE FROM wifi WHERE id = {$id}";
        
        SqlQueryRaw($query);
        break;

    case 'print':
        $query = "DELETE FROM printer WHERE id = {$id}";
        
        SqlQueryRaw($query);
        break;
    default:
        break;
}





$query = "DELETE FROM devices WHERE id = {$id}";


SqlQueryRaw($query);

?>