<?php
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM users WHERE id = {$id}";
 
$row = SqlQuery($query);
echo "
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
                    <span class='input-group-text'>Name</span>
                </div>
                <input type='text' class='form-control' value='{$row['firstName']}' id='fnameModal' disabled>
                <input type='text' class='form-control' value='{$row['lastName']}' id='lnameModal' disabled> 
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Username</span>
                </div>
               <input type='text' class='form-control' value='{$row['userName']}' id='usernameModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Email</span>
                </div>
               <input type='text' class='form-control' value='{$row['email']}' id='emailModal' disabled>
            </div>
        </div>
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Phone#</span>
                </div>
                <input type='text' class='form-control' value='{$row['phoneNumber']}' id='phoneModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Birth Date</span>
                </div>
               <input type='date' class='form-control' value='{$row['birthDate']}' id='bdayModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Password</span>
                </div>
               <input type='password' class='form-control' value='{$row['password']}' id='passwordModal' disabled>
            </div>
        </div>
        <div class='col-1'></div>
    </div>
</div>
<div class='modal-footer'>
    <form style='width:100%'>
        <button class='btn btn-secondary' id='editButton' onclick='EditUserModal(event);return false;' style='text-align:left;'>Edit</button>
        <button class='btn btn-secondary' id='saveButton' onclick='SaveUserModal(event);return false;' style='display:none'>Save</button>
        <button class='btn btn-secondary' id='cancelButton' onclick='CancelUserEdit(event);return false;' style='display:none'>Cancel</button>
        <button class='btn btn-danger' onclick='DeleteUser(event, {$id});return false;' name='deleteAcct' style='float:right'>DELETE</button>
    </form>
</div>
";

?>