<?php
session_start();

$_SESSION['isTerminal'] = TRUE;

$_SESSION['result'] = '';
if(!isset($_SESSION['lastInput'])){
    $_SESSION['lastInput'] = '';
}
if(!isset($_SESSION['connection'])){
    $_SESSION['connection'] = NULL;
}
if(!isset($_SESSION['currentDB'])){
    $_SESSION['currentDB'] = '';
}

# Handels Sql Querys
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['connect'])){
        if(isset($_SESSION['currentHost']) && $_SESSION['currentHost'] != NULL){
            @mysqli_close($_SESSION['connection']);
        }
        if(empty($_POST['db'])){
            Connect($_POST['user'], $_POST['password'], $_POST['host']);
            $_SESSION['currentHost'] = $_POST['host'];
            $_SESSION['nameList'] = Query("SHOW DATABASES");
            $_SESSION['listType'] = 'db';
        }
        else{
            ConnectDB($_POST['user'], $_POST['password'], $_POST['host'], $_POST['db']);
            $_SESSION['nameList'] = Query("SHOW TABLES FROM " . $_SESSION['currentDB']);
            $_SESSION['listType'] = 'table';
        }
    }
    elseif(isset($_POST['disconnect']))
    {
        $_SESSION['connection'] = NULL;
        $_SESSION['result'] = 'Disconnected';
    }
    elseif(isset($_POST['create'])){
        if($_POST['createType'] == 'table'){
            $query = 'CREATE TABLE ' . $_POST['name'] . ' (' . $_POST['attr'] . ')';
            
            if(isset($_SESSION['currentHost']) && $_SESSION['currentHost'] != NULL){
                @mysqli_close($_SESSION['connection']);
            }
            if(empty($_SESSION['currentDB']) || $_SESSION['currentDB'] = NULL){
                Connect($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost']);
            }
            else{
                ConnectDB($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost'], $_SESSION['currentDB']);
            }
            if(Query($query) === TRUE){
                $_SESSION['result'] = 'Table ' . $_POST['name'] . ' Created';
            }
            else{
                $_SESSION['result'] = 'FAILED TO CREATE TABLE: ' . @mysqli_error($_SESSION['connection']);
            }
        }
        elseif($_POST['createType'] == 'database'){
            $query = 'CREATE DATABASE ' . $_POST['name'];
            if(isset($_SESSION['currentHost']) && $_SESSION['currentHost'] != NULL){
                @mysqli_close($_SESSION['connection']);
            }
            if(empty($_SESSION['currentDB']) || $_SESSION['currentDB'] == NULL){
                Connect($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost']);
            }
            else{
                ConnectDB($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost'], $_SESSION['currentDB']);
            }
            if(Query($query) === TRUE){
                $_SESSION['result'] = 'Database ' . $_POST['name'] . ' Created';
            }
            else{
                $_SESSION['result'] = 'FAILED TO CREATE Database: ' . @mysqli_error($_SESSION['connection']);
            }
        }
    }
    elseif(isset($_POST['table'])){
        if(isset($_SESSION['currentHost']) && $_SESSION['currentHost'] != NULL){
            @mysqli_close($_SESSION['connection']);
        }
        if(empty($_SESSION['currentDB']) || $_SESSION['currentDB'] == NULL){
            Connect($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost']);
        }
        else{
            ConnectDB($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost'], $_SESSION['currentDB']);
        }
        $_SESSION['listType'] = 'entity';
        $_SESSION['nameList'] = Query('SELECT * FROM ' . key($_POST['table']));
        $_SESSION['currentTable'] = key($_POST['table']);
    }
    else{
        $_SESSION['lastInput'] = $_POST['sqlQuery'];
        if(isset($_SESSION['currentHost']) && $_SESSION['currentHost'] != NULL){
            @mysqli_close($_SESSION['connection']);
        }
        if(empty($_SESSION['currentDB']) || $_SESSION['currentDB'] == NULL){
            Connect($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost']);
        }
        else{
            ConnectDB($_SESSION['currentUser'], $_SESSION['currentPass'], $_SESSION['currentHost'], $_SESSION['currentDB']);
        }
        if(Query($_POST['sqlQuery'])){
            $_SESSION['result'] = 'QUERY SUCCESS: ' . $_SESSION['lastInput'];
        }
        else{
            $_SESSION['result'] = 'ERROR: ' . @mysqli_error($_SESSION['connection']);
        }
    }
}

# Renaming of mysqli query function to query
function Query($query){
    return mysqli_query($_SESSION['connection'], $query);
 }

function ConnectDB($user, $pass, $server, $db){
    $_SESSION['connection'] = mysqli_connect($server, $user, $pass, $db);

    if(!$_SESSION['connection']){
        $_SESSION['result'] = "Connection Failed: " . @mysqli_connect_error();
    }
    else{
        $_SESSION['result'] = 'CONNECTED TO ' . $db . ' IN ' . $server;
        $_SESSION['currentDB'] = $db;
        $_SESSION['currentUser'] = $user;
        $_SESSION['currentPass'] = $pass;
        $_SESSION['currentHost'] = $server;
    }
    $_SESSION['lastInput'] = '';
}
function Connect($user, $pass, $server){
    $_SESSION['connection'] = mysqli_connect($server, $user, $pass);

    if(!$_SESSION['connection']){
        $_SESSION['result'] = "Connection Failed: " . mysqli_connect_error();
    }
    else{
        $_SESSION['result'] = 'CONNECTED TO ' . $server;
        $_SESSION['currentUser'] = $user;
        $_SESSION['currentPass'] = $pass;
        $_SESSION['currentHost'] = $server;
        $_SESSION['currentDB'] = NULL;
    }
    $_SESSION['lastInput'] = '';
}
?>

<?php
    if($_SESSION['connection'] == NULL || !isset($_SESSION['connection'])){
        echo '<span style="color:red;">OFFLINE</span>';
    }
    elseif($_SESSION['connection'] != NULL){
        echo '<span style="color:mediumseagreen;">ONLINE</span>';
    }
?>
<br><br>
<form name='connect' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
    Host: <input type='text' name='host' value='localhost'>
    <br><br>
    User: <input type='text' name='user' value='root'>
    <br><br>
    Password: <input type='password' name='password' value='12345'>
    <br><br>
    Database: <input type='text' name='db' value="<?php echo $_SESSION['currentDB'];?>">
    <br><br>
    <input type='submit' name='connect' value='Connect'>
    <input type='submit'<?php if($_SESSION['connection'] == NULL || !isset($_SESSION['connection'])){ ?> disabled <?php } ?> name='disconnect' value='Disconnect'>
</form>
<div>
    <span>SQL Terminal</span>
    <form id='sql' name='sql' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
        <textarea name='sqlQuery' style="width:25vw;height:15vh;"><?php echo $_SESSION['lastInput']?></textarea>
        <br>
        <button type='submit' value='Submit' style='width:7.5vw;height:5vh;'>Submit</button>
        <button type='reset' value='Submit' style='width:7.5vw;height:5vh;'>Reset</button>
    </form>
</div>
<div>
    <form name='create' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method='post'>
        Name: <input type='text' name='name'>
        <br><br>
        Attributes: <input type='textarea' name='attr'><span>* Only required For Creating Table</span>
        <br><br>
        Table: <input type='radio' name='createType' value='table'> 
        Database: <input type='radio' name='createType' value='database'>
        <br><br>
        <input type='submit' name='create' value='Create'>
    </form>
</div>

<div name='databaseAndTableView' style='background-color:lightgrey;width:40vw;height:40vh;top:2vh;right:5vw;position:absolute;'>
    <form id='viewTable' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'></form>
    <h3 style='margin-top:1vh;margin-bottom:1vh;margin-left:3vw;margin-right:3vw;'><?php 
    if(isset($_SESSION['listType'])){
        if($_SESSION['listType'] == 'db') {
             echo 'DATABASES'; 
        } 
        elseif($_SESSION['listType'] == 'table'){ 
            echo 'TABLES'; 
        }
        elseif($_SESSION['listType'] == 'entity' && isset($_SESSION['currentTable'])){
            echo $_SESSION['currentTable'];
        }
    } ?></h3>
    <table><?php
        if(isset($_SESSION['nameList'])){
            if(@mysqli_num_rows($_SESSION['nameList']) > 0){
                if($_SESSION['listType'] == 'db'){
                    while($row = mysqli_fetch_row($_SESSION['nameList'])){
                        echo '<tr><td>' . $row[0] . '</td></tr>';
                    }
                }
                elseif($_SESSION['listType'] == 'table'){
                    while($row = mysqli_fetch_row($_SESSION['nameList'])){
                        $tableInfo = '<tr><td><button form="viewTable" name="table[' . $row[0] .']" value="table">' . $row[0] . ' (';
                        $attrResult = Query("SHOW COLUMNS FROM " . $row[0]);
                        $i = 0;
                        while($attr = mysqli_fetch_row($attrResult)){
                            if($i == 0){
                                $tableInfo .= $attr[0];
                            }
                            else{
                                $tableInfo .= ', ' . $attr[0];
                            }  
                            $i += 1;    
                        }
                        $tableInfo .= ')';
                        $tableInfo .= '</button></td></tr>';
                        echo $tableInfo;
                    }    
                }
                else if($_SESSION['listType'] == 'entity'){
                    while($row = mysqli_fetch_row($_SESSION['nameList'])){
                        $tableInfo = '<tr><td>| ';
                        for($i = 0; $i < count($row); $i++){
                            $tableInfo .= $row[$i] . ' | ';
                        }
                        echo $tableInfo;
                    }
                }
            }
        }
        ?>
    </table>
</div>
<br><br>
<div style='background-color:lightgrey;width:40vw;height:10vh;top:50vh;right:5vw;position:absolute;'>
    <span>Output > <?php echo $_SESSION['result']; ?></span>
<div>