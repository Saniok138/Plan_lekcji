<?php 
    session_start();
    if(!isset($_SESSION["Admin"])){
        header(header: "Location: ../index.php");
        exit();
    }else{
        setcookie("generated", "1", time() + (86400 * 365));
    }