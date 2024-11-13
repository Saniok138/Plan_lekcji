<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENERATOR</title>
    <link rel="stylesheet" href="./CSS/main-style.css">
</head>
<body>
    <div class="menu-main">
        <?php 
            include('./PHP/menu-presentation.php');
            if(isset($_SESSION["Admin"])){
                include('./PHP/menu-generation.php');
            }else{
                include('./PHP/menu-admin.php');
            }
        ?>
    </div>
</body>
</html>