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
                <span class='input-group-text'>Username</span>
            </div>
        <input type='text' class='form-control' value='userName' id='usernameModal' disabled>
        </div>
        <div class='input-group mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text'>Email</span>
            </div>
        <input type='text' class='form-control' value='email' id='emailModal' disabled>
        </div>
    </div>
    <div class='col-5'>
        <div class='input-group mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text'>Phone#</span>
            </div>
            <input type='text' class='form-control' value='phoneNumber' id='phoneModal' disabled>
        </div>
        <div class='input-group mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text'>Birth Date</span>
            </div>
        <input type='date' class='form-control' value='birthDate' id='bdayModal' disabled>
        </div>
    </div>
    <div class='col-1'></div>
</div>
</div>
<div class='modal-footer'>
<form style='width:100%'>
    <button class='btn btn-secondary' id='editButton' onclick='EditModal(event);return false;' style='text-align:left;'>Edit</button>
    <button class='btn btn-secondary' id='saveButton' onclick='SaveUserModal(event);return false;' style='display:none'>Save</button>
    <button class='btn btn-secondary' id='cancelButton' onclick='CancelEdit(event);return false;' style='display:none'>Cancel</button>
    <button class='btn btn-danger' type='submit' name='deleteAcct' style='float:right'>DELETE</button>
</form>
</div>";
?>