<?php
include 'sqlFunctions.php';

$id = $_REQUEST['id'];
$query = "DELETE FROM user_package WHERE userId = '{$id}';";
SqlQuery($query);
$query = "DELETE FROM user_role WHERE userId = '{$id}';";
SqlQuery($query);
$query = "DELETE FROM deviceLogs WHERE userId = '{$id}';";
SqlQuery($query);
$query = "DELETE FROM users WHERE id = '{$id}';";
SqlQuery($query);
?>