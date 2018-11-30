<?
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM devices WHERE id = {$id}";
 
$row = SqlQuery($query);

?>