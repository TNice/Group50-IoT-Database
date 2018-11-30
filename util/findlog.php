<?
include 'sqlFunctions.php';
$id = $_REQUEST['id'];
$query = "SELECT * FROM devicelogs WHERE logId = {$id}";
 
$row = SqlQuery($query);

?>