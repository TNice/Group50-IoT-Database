<?php
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM users WHERE id = {$id}";
 
$row = SqlQuery($query);
echo "
<div class='modal-header'>
    <h4 class='modal-title' style='margin:auto;width:100%;text-align:center'>"."{$row['id']}"."</h4>
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
                <input type='text' class='form-control' value='{$row['firstName']}' name='firstName' id='fname'> <span class='error'><?php?></span>
                <input type='text' class='form-control' value='{$row['lastName']}' name='lastName' id='lname'> <span class='error'><?php?></span>
            </div>
            <div class='input-group mb-3'>
            <div class='input-group-prepend'>
                    <span class='input-group-text'>Username</span>
                </div>
               <input type='text' class='form-control' value='<?php echo $username;?>' name='username' id='username' ><span class='error'><?php echo $userError; ?></span>
            </div>
        </div>
        <div class='col-5'>
            <p style='display:block'>Phone Number: {$row['phoneNumber']}</p>
            <p style='display:block'>Birth Date: {$row['birthDate']}</p>
        </div>
        <div class='col-1'></div>
    </div>
</div>
<div class='modal-footer'>
    <form style='width:100%'>
        <button class='btn btn-secondary' id='editButton' onclick='EditModal(event);return false;' style='text-align:left;'>Edit</button>
        <button class='btn btn-secondary' id='saveButton' onclick='SaveModal(event);return false;' style='display:none'>Save</button>
        <button class='btn btn-secondary' id='cancelButton' onclick='CancelEdit(event);return false;' style='display:none'>Cancel</button>
        <button class='btn btn-danger' type='submit' name='deleteAcct' style='float:right'>DELETE</button>
    </form>
</div>
";

?>