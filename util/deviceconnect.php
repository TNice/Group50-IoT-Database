<?php
    session_start();
    include 'sqlFunctions.php';
    $id = $_REQUEST['id'];
    $query = "select roleId from user_role where userId = {$_SESSION['currentUser']};";
    
    $row = SqlQuery($query);

     echo "select * from access_rule a, user_role u where a.roleId = {$row['roleId']} and a.deviceId = {$id}"
    

?>