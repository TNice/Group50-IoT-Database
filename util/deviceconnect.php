<?php
    session_start();
    include 'sqlFunctions.php';
    $id = $_REQUEST['id'];
    $query = "select roleId from user_role where userId = {$_SESSION['currentUser']};";
//    echo "{$_SESSION['currentUser']} ";
    
    $row = SqlQuery($query);

    $query = "select * from access_rule where roleId = {$row['roleId']} and deviceId = {$id}";

    $row = SqlQuery($query);
    
//$time = $row[''];
if(isset($row['ruleId'])){
    $ruleId = $row['ruleId'];
    $query = "SELECT * FROM accesstime_rule WHERE ruleId = {$ruleId};";
    $result = SqlQueryRaw($query);

    $today = date("l"); // = current day of week
    $today = strtolower($today);
    $currentTime; // = current time

    $row = SqlQuery($query);

    $sTime = $row['startTime'];
    $eTime = $row['endTime'];
    $sDay = $row['startDay'];
    $eDay = $row['endDay'];

    $result = "{$sTime}|{$eTime}|{$sDay}|{$eDay}";
    echo $result;
   
    
//    while($row = mysqli_fetch_assoc($result)){
//
//        if(strcmp($row['startDay'], "any") || strcmp($row['endDay']), "any"){
//            $response = true;
//            break;
//        }
//        
          
        
        
//        if(strcmp($row['accessDay'], $today)){
//            $response = true;
//            break;
//        }
        
//        echo $row['accessDate'];

    }

//    if($response == true){
//        //check time
//        echo "TRUE";
//    }
//    else{
//        echo "False";
//    }
}
else{
    echo "Any|Any|Any|Any";
}
?>