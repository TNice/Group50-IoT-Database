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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <?php include 'addbootstrap.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <h1>PLACEHOLDER</h1>
</body>
</html>