<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];

$list = "<ul>";

$query = "SELECT * FROM package_device WHERE packageId = {$id}";
$result = SqlQueryRaw($query);

while($row = mysqli_fetch_assoc($result)){
    $newQuery = "SELECT * FROM smartplug WHERE id = {$row['deviceId']}";
    $newRow = SqlQuery($newQuery);
    if(isset($newRow['deviceId'])){
        $list .= "<li>Smart Plug</li>"
    }
    else{
        $newQuery = "SELECT * FROM printer WHERE id = {$row['deviceId']}";
        $newRow = SqlQuery($newQuery);
        if(isset($newRow['deviceId'])){
            $list .= "<li>Printer</li>"
        }
        else{
            $newQuery = "SELECT * FROM wifi WHERE id = {$row['deviceId']}";
            $newRow = SqlQuery($newQuery);
            if(isset($newRow['deviceId'])){
                $list .= "<li>Wifi</li>"
            }
            else{
                $list .= "<li>Other</li>"
            }
        }
    }
}

$list .= "</ul>";
?>