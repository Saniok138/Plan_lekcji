<link rel="stylesheet" href="../CSS/main-style.css">
<?php
    $selected_option = $_POST['change-classes'];
    include("../classes/classes.php");
    if(isset($_POST['exit'])){
        header(header: "Location: ../index.php");
    }
?>