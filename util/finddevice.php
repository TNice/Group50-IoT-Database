<?
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM devices WHERE id = {$id}";
$row = SqlQuery($query);

if(isset($_REQUEST['isAdmin'])){
    //do adimin pannel logic here
}
else{
    //do find device page here
}
?>