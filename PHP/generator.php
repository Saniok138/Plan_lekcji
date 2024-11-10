<?php 
    setcookie("generated", "1", time() + (86400 * 365),"/");
    header("Location: ../index.php");
    exit();