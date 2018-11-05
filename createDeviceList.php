<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(ConnectToDB()){
        $deviceIds = GetDeviceIds();
    }else{
        //display an error message;
    }


    function ConnectToDB(){
        //return true if connected
    }

    function GetDeviceIds(){
        $query ='SELECT deviceId FROM Devices';
        
        if(!isset($_SESSION['filter']) || $_SESSION['filter'] === 'NONE'){
            //Add filters to querry
        }

        $query .= ';';

        return 'DEVICE IDS';
    }
?>

<div>
    <h1>PLACEHOLDER</h1>
</div>