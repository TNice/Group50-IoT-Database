<?php
    session_start();
    include 'sqlFunctions.php';
    $id = $_REQUEST['id'];
    $isAdmin = FALSE;
    $query = "select roleId from user_role where userId = {$_SESSION['currentUser']};";
//    echo "{$_SESSION['currentUser']} ";
    
    $row = SqlQuery($query);
    if($row['roleId'] != 1){
        $query = "select * from access_rule where roleId = {$row['roleId']} and deviceId = {$id}";
    }
    else{
        $isAdmin = TRUE;
    }
    
    $row = SqlQuery($query);
if(isset($row['ruleId']) && $isAdmin === FALSE){
    $ruleId = $row['ruleId'];
    $query = "SELECT * FROM accesstime_rule WHERE ruleId = {$ruleId};";
    $result = SqlQueryRaw($query);

    $today = date("l"); // = current day of week
    $today = strtolower($today);

    $row = SqlQuery($query);

    $sTime = $row['startTime'];
    $eTime = $row['endTime'];
    $sDay = $row['startDay'];
    $eDay = $row['endDay'];

    $result = "{$sTime}|{$eTime}|{$sDay}|{$eDay}";

    $packageId = UserHasPackage($_SESSION['currentUser']);
    echo "Package: " . $packageId;
    if($packageId !== NULL){
        $deviceInPackage = DeviceInPackage($packageId, $id);
        echo "IsDeviceInPackage: " . $deviceInPackage;
        if($deviceInPackage === TRUE){
            $result .= "|true";
        }
    }
    else{
        $result .= "|false";
    }

    echo $result;
}
else{
    echo "Any|Any|Any|Any|true";
}

?>