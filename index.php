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
            if(!isset($_COOKIE["generated"])){
                include('./HTML/menu-generation.html');
            }else{
                include('./HTML/menu-presentation.html');
            }
        ?>
    </div>
</body>
</html>