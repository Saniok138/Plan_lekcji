<?php 
    if(!isset($_SESSION["Admin"])){
        header(header: "Location: ../index.php");
        exit();
    }else if(!isset($_COOKIE["generated"])){
        echo '<form action="./PHP/generator.php" method="post">
                <input type="submit" value="Generuj nowy plan">
            </form>';
    }
?>