<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log-in</title>
    <link rel="stylesheet" href="../CSS/main-style.css">
</head>
<body>
    <div>
        <form action="" method="post">
            <input type="text" name="login" class="login">
            <input type="password" name="password" class="password">
            <input type="submit" value="log-in" name="log_in">
        </form>
        <?php
            session_start();
            if(isset($_POST["log_in"])){
                if ($_POST["login"] === "Admin" && $_POST["password"] === "1243") {
                    $_SESSION["name"] = "Admin";
                    $_SESSION["username"] = "Admin";
                    $_SESSION["role"] = "Admin";
                    $_SESSION["Admin"] = true;
                header(header: "Location: ../index.php");
                } else {
                    echo "Błędny login lub hasło.";
                }
            }
        ?>
    </div>
</body>
</html>