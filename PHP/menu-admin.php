<?php 
    if(!isset($_SESSION["Admin"])){
        echo '<div class="menu-top">
                <form action="./PHP/Admin.php" method="post">
                    <input class="log-in" type="submit" value="Login as Admin">
                </form>
            </div>';
    }
?>