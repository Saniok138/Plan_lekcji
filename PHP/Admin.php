<?php
    session_start();
    $_SESSION["name"] = "Admin";
    $_SESSION["username"] = "Admin";
    $_SESSION["role"] = "Admin";
    $_SESSION["Admin"] = true;
    header(header: "Location: ../index.php");