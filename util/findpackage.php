<?php

include 'sqlFunctions.php';
$id = $_REQUEST['id'];

$query = "SELECT * FROM package_device WHERE deviceId = {$id};";
$result = SqlQueryRaw($query);
$lowestPackage = 10;
while($row = mysqli_fetch_assoc($result)){
    if($row['packageId'] < $lowestPackage){
        $lowestPackage = $row['packageId'];
    }
}

echo $lowestPackage;
?>