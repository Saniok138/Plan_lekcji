<?php
    setcookie("generated", "", time() - 3600, "/");
    header("Location: ../index.php");
    exit();