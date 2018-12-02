<?php
session_start();
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM devices WHERE id = {$id}";
$row = SqlQuery($query);

$type = 'none';

$smartPlugCheck = "SELECT * FROM devices d, smartplug s WHERE d.id = s.id and d.id = {$id}";
$plugRow = SqlQuery($smartPlugCheck);

$printCheck = "SELECT * FROM devices d, printer p WHERE d.id = p.id and d.id = {$id}";
$printRow = SqlQuery($printCheck);

$wifiCheck = "SELECT * FROM devices d, wifi w WHERE d.id = w.id and d.id = {$id}";
$wifiRow = SqlQuery($wifiCheck);

$html = "
<div class='modal-header'>
    <h4 class='modal-title' id='idModal' style='margin:auto;width:100%;text-align:center'>"."{$row['id']}"."</h4>
    <button type='button' class='close' onclick='CloseModal(0);'>×</button>
</div>
<div class='modal-body'>
    <div class='row'>
        <div class='col-1'></div>
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Location</span>
                </div>
               <input type='text' class='form-control' value='{$row['location']}' id='locationModal' disabled>
            </div>";
if(isset($plugRow)){
    $type = 'plug';
   $html .= "<div class='input-group mb-3'>
        <div class='input-group-prepend'>
            <span class='input-group-text'>PowerUsage</span>
        </div>
        <input type='text' class='form-control' value='{$plugRow['powerUseage']}' id='powerModal' disabled>
    </div>";
}
else if(isset($printRow)){
    $type = 'print';
    $html .= "<div class='input-group mb-3'>
        <div class='input-group-prepend'>
            <span class='input-group-text'>Page Count</span>
        </div>
        <input type='text' class='form-control' value='{$printRow['pageCount']}' id='pageModal' disabled>
    </div>
    <div class='input-group mb-3'>
        <div class='input-group-prepend'>
            <span class='input-group-text'>Ink Level</span>
        </div>
        <input type='text' class='form-control' value='{$printRow['inkLevel']}' id='inkModal' disabled>
    </div>";
}
else if(isset($wifiRow)){
    $type = 'wifi';
    $html .= "<div class='input-group mb-3'>
        <div class='input-group-prepend'>
            <span class='input-group-text'>Ip</span>
        </div>
        <input type='text' class='form-control' value='{$wifiRow['ipv4']}' id='ipModal' disabled>
    </div>";
}
if(isset($_REQUEST['isAdmin'])){ 


$html .= "</div>
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Start Day</span>
                </div>
                <div class='form-group input-group-text'>
                    <select id='sDayModal'>
                        <option>Any</option>
                        <option>Sunday</option>
                        <option>Monday</option>
                        <option>Tuesday</option>
                        <option>Wednesday</option>
                        <option>Thursday</option>
                        <option>Friday</option>
                        <option>Saturday</option>
                    </select>
                </div>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>End Day</span>
                </div>
                <div class='form-group input-group-text'>
                    <select id='eDayModal'>
                        <option>Any</option>
                        <option>Sunday</option>
                        <option>Monday</option>
                        <option>Tuesday</option>
                        <option>Wednesday</option>
                        <option>Thursday</option>
                        <option>Friday</option>
                        <option>Saturday</option>
                    </select>
                </div>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Start Time</span>
                </div>
                <div class='form-group input-group-text'>
                    <select id='eTimeModal'>
                        <option>Any</option>
                        <option>12 am</option>
                        <option>1 am</option>
                        <option>2 am</option>
                        <option>3 am</option>
                        <option>4 am</option>
                        <option>5 am</option>
                        <option>6 am</option>
                        <option>7 am</option>
                        <option>8 am</option>
                        <option>9 am</option>
                        <option>10 am</option>
                        <option>11 am</option>
                        <option>12 pm</option>
                        <option>1 pm</option>
                        <option>2 pm</option>
                        <option>3 pm</option>
                        <option>4 pm</option>
                        <option>5 pm</option>
                        <option>6 pm</option>
                        <option>7 pm</option>
                        <option>8 pm</option>
                        <option>9 pm</option>
                        <option>10 pm</option>
                        <option>11 pm</option>
                    </select>
                </div>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>End Time</span>
                </div>
                <div class='form-group input-group-text'>
                    <select id='eTimeModal'>
                        <option>Any</option>
                        <option>12 am</option>
                        <option>1 am</option>
                        <option>2 am</option>
                        <option>3 am</option>
                        <option>4 am</option>
                        <option>5 am</option>
                        <option>6 am</option>
                        <option>7 am</option>
                        <option>8 am</option>
                        <option>9 am</option>
                        <option>10 am</option>
                        <option>11 am</option>
                        <option>12 pm</option>
                        <option>1 pm</option>
                        <option>2 pm</option>
                        <option>3 pm</option>
                        <option>4 pm</option>
                        <option>5 pm</option>
                        <option>6 pm</option>
                        <option>7 pm</option>
                        <option>8 pm</option>
                        <option>9 pm</option>
                        <option>10 pm</option>
                        <option>11 pm</option>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-1'></div>
    </div>
</div>
<div class='modal-footer'>
    <form style='width:100%'>";
}
else{
    $html .= "</div>
        <div class='col-5'>";


        $radiobt = "select functionality from device_function where deviceID = {$row['id']}";
        //echo $radiobt; 
        $result = SqlQueryRaw($radiobt);
        $html .= "<form action=''>";
        while ($row = mysqli_fetch_assoc($result)){
            $html .= "<input type='radio' name=functionality' value='{$row['functionality']}'> {$row['functionality']}<br>";
        }
        $html .="</form>";
        
    $html .= "
    <div class='modal-footer'>
    <form style='width:100%'>";
}

if(isset($_REQUEST['isAdmin'])){   
    $html .= "<button class='btn btn-secondary' id='editButton' onclick='EditDeviceModal(event);return false;' style='text-align:left;'>Edit</button>
        <button class='btn btn-secondary' id='saveButton' onclick='SaveDeviceModal({$id});return false;' style='display:none'>Save</button>
        <button class='btn btn-secondary' id='cancelButton' onclick='CancelDeviceModal(event);return false;' style='display:none'>Cancel</button>
        <button class='btn btn-danger' onclick='DeleteDeviceModal(event, {$id});return false;' name='deleteDevice' style='float:right'>DELETE</button>";
}
else if(isset($_SESSION['currentUser'])){
    $html .= "<button class='btn btn-secondary' onclick='TryConnectToDevice({$id}); return false;' name='connect' style='float:right'>Connect</button>";
}

$html .= "</form></div>";

echo $html;
?>