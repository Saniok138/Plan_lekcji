<?php 
    session_start();
    if(!isset($_SESSION["Admin"])){
        header(header: "Location: ../index.php");
        exit();
    }else{
        header(header: "Location: ../index.php");
        exit();
    }
    // $host = '127.0.0.1';
    // $user = 'root';
    // $password = '';
    // $db = "plan_lekcji";
    // $conn = mysqli_connect($host, $user, $password, $db);
    // if (mysqli_connect_errno()) {
    //     echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //     exit();
    // }else{}