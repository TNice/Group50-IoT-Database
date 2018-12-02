<?php

echo "<div class='modal-header'>
<h4 class='modal-title' id='idModal' style='margin:auto;width:100%;text-align:center'>Create Device</h4>
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
        <input type='text' class='form-control' placeholder='zipCode' id='locationModal'>
        </div>
        <div class='input-group mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text'>Type</span>
            </div>
            <div class='form-group input-group-text'>
                <select id='typeModal'>
                    <option>Smart Plug</option>
                    <option>Printer</option>
                    <option>WiFi</option>
                </select>
            </div>
        </div>
    </div>
   
    <div class='col-1'></div>
</div>
</div>
<div class='modal-footer'>
<form style='width:100%'>
    <button class='btn btn-secondary' id='cancelButton' onclick='EditModal(event);return false;' style='text-align:left;'>Cancel</button>
    <button class='btn btn-secondary' onclick='CreateDeviceModal(); return false;' name='saveDevice' style='float:right'>Save</button>
</form>
</div>";
?>