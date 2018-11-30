<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];
$query = "DELETE FROM users WHERE id = '{$id}';";

SqlQuery($query);
echo $id;
?>