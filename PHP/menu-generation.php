<?php 
    if(!isset($_SESSION["Admin"])){
        header(header: "Location: ../index.php");
        exit();
    }else{
        echo '<form action="./PHP/generator.php" method="post">
                <input type="submit" value="Generuj nowy plan">
            </form>';
    }
?>