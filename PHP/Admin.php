<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log-in</title>
    <link rel="stylesheet" href="../CSS/main-style.css">
</head>
<body class="background">
    <div class="menu-main">
        <form action="" method="post">
            <input type="text" name="login" class="text-input"><br>
            <input type="password" name="password" class="text-input"><br>
            <?php
                session_start();
                if(isset($_POST["log_in"])){
                    if ($_POST["login"] === "Admin" && $_POST["password"] === "1243") {
                        $_SESSION["name"] = "Admin";
                        $_SESSION["username"] = "Admin";
                        $_SESSION["role"] = "Admin";
                        $_SESSION["Admin"] = true;
                    header(header: "Location: ../admin.php");
                    } else {
                        echo "Błędny login lub hasło.";
                    }
                }
                if(isset($_POST["exit"])){
                    session_destroy();
                    header(header: "Location: ../index.php");
                }
            ?><br>
            <input type="submit" value="Log-In" name="log_in" class="presentation"><br>
            <input type="submit" value="Exit" name="exit" class="presentation"><br>
        </form>
    </div>
</body>
</html>