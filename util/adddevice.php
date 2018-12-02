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
    
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Start Day</span>
                </div>
                <div class='form-group input-group-text'>
                    <select id='typeModal'>
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
                    <select id='typeModal'>
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
                    <select id='typeModal'>
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
                    <select id='typeModal'>
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
<form style='width:100%'>
    <button class='btn btn-secondary' id='cancelButton' onclick='EditModal(event);return false;' style='text-align:left;'>Cancel</button>
    <button class='btn btn-secondary' onclick='CreateDeviceModal(); return false;' name='saveDevice' style='float:right'>Save</button>
</form>
</div>";
?>