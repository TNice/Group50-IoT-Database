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
$ruleId = $row['ruleId'];
$query = "SELECT * FROM accesstime_rule WHERE ruleId = {$ruleId};";
$result = SqlQueryRaw($query);

$today = date("l"); // = current day of week
$today = strtolower($today);
$currentTime; // = current time
//echo $today;

$response = false;

echo " {$query} ";
//echo "{$row['accessDate']} date ";
while($row = mysqli_fetch_assoc($result)){

    if(strcmp($row['accessDate'], "any")){
        $response = true;
        break;
    }
    if(strcmp($row['accessDay'], $today)){
        $response = true;
        break;
    }
    echo "hello";
    echo $row['accessDate'];
    
}

if($response == true){
    //check time
    echo "TRUE";
}
else{
    echo "False";
}
?>