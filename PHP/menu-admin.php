<?php 
    if(!isset($_SESSION["Admin"])){
        echo '<form action="./PHP/Admin.php" method="post">
                <h2>Login as Admin</h2>
                <input type="submit" value="try">
            </form>';
    }
?>