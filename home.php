<?php 
    include 'util/sqlFunctions.php';
//test
?>

<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Bootstrap-->
        <?php include 'util/addbootstrap.php';?>

        <title>Database Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#969696">
        <link rel="stylesheet" type="text/css" href="mainstyle.css">
        <script src="main.js"></script>
    </head>
        
    <body>
        <div class="background">  
            <div id='title' class='container-fluid titleBox'>            
                <h1 class='title1'>IoT Database Project</h1>            
            </div>   
            <?php include 'navmenu.php'; ?>
            <div name='spacer' style='margin-top:3rem;'></div>
            
            <div class='row' style='max-width:100%;'>
                <div class='col-1'> </div>
                <div class='col-10'>
                    <div class=contentBox>
                        <h3 class='title1' style='margin-top:0.5rem;margin-bottom:2rem'>Project Info</h3>
                        <h5 style="color:white">Purpose Statement</h5>
                        <p style='color:white;text-indent:15px'>The purpose of our project is to create a system that controls access to smart devices in commercial areas such as an airport or student center. The control is based on packages that the user can subscribe to and device rules.</p>
                    </div>
                    <div class='contentBoxLight'>
                        <h3 class='title1' style='margin-top:0.5rem;margin-bottom:2rem'>ER Diagram</h3>
                        <img src='images/ERDiagram.png' class='mx-auto d-block' style='max-width:100%'>
                    </div>
                    <div class='contentBoxLight'>
                        <h3 class='title1' style='margin-top:0.5rem;margin-bottom:2rem'>Relational Model</h3>
                        <img src='images/Tables.png' class='mx-auto d-block' style='width:100%'>
                    </div>
                </div>
                <div class='col-1'></div>
            </div>
        </div>
    </body>
</html>