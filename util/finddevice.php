<?php
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
               <input type='text' class='form-control' value='{$row['location']}' id='usernameModal' disabled>
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
        <input type='text' class='form-control' value='{$printRow['inklevel']}' id='inkModal' disabled>
    </div>";
}
else if(isset($wifiRow)){
    $type = 'wifi';
    $html .= "<div class='input-group mb-3'>
        <div class='input-group-prepend'>
            <span class='input-group-text'>Ip</span>
        </div>
        <input type='text' class='form-control' value='{$wifiRow['ipv4']}' id='emailModal' disabled>
    </div>";
}
$html .= "</div>
        <div class='col-5'>
            
        </div>
        <div class='col-1'></div>
    </div>
</div>
<div class='modal-footer'>
    <form style='width:100%'>";

if(isset($_REQUEST['isAdmin'])){   
    $html .= "<button class='btn btn-secondary' id='editButton' onclick='EditDeviceModal(event);return false;' style='text-align:left;'>Edit</button>
        <button class='btn btn-secondary' id='saveButton' onclick='SaveDeviceModal(event, );return false;' style='display:none'>Save</button>
        <button class='btn btn-secondary' id='cancelButton' onclick='CancelDeviceEdit(event);return false;' style='display:none'>Cancel</button>
        <button class='btn btn-danger' onclick='DeleteDevice(event, {$id});' name='deleteAcct' style='float:right'>DELETE</button>";
}
else{
    $html .= "<button class='btn btn-secondary' onclick='ConnectDevice(event, {$id});' name='connect' style='float:right'>Connect</button>";
}

$html .= "</form></div>";

echo $html;
?>