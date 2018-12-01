<?
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM devicelogs WHERE logId = {$id}";
 
$row = SqlQuery($query);

echo "
<div class='modal-header'>
    <h4 class='modal-title' id='idModal' style='margin:auto;width:100%;text-align:center'>"."{$row['logId']}"."</h4>
    <button type='button' class='close' onclick='CloseModal(0);'>×</button>
</div>
<div class='modal-body'>
    <div class='row'>
        <div class='col-1'></div>
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Log ID</span>
                </div>
                <input type='text' class='form-control' value='{$row['logId']}' id='logIDModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Device ID</span>
                </div>
               <input type='text' class='form-control' value='{$row['deviceId']}' id='deviceIDModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>User ID</span>
                </div>
               <input type='text' class='form-control' value='{$row['userId']}' id='userIDModal' disabled>
            </div>
        </div>
        <div class='col-5'>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Result</span>
                </div>
                <input type='text' class='form-control' value='{$row['result']}' id='resultModal' disabled>
            </div>
            <div class='input-group mb-3'>
                <div class='input-group-prepend'>
                    <span class='input-group-text'>Log Time</span>
                </div>
               <input type='date' class='form-control' value='{$row['logTime']}' id='logTimeModal' disabled>
            </div>
            
        </div>
        <div class='col-1'></div>
    </div>
</div>

";


?>