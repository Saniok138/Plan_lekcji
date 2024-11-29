<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form action='./PHP/presentation.php' method="post">
        <select class="change-classes" id="change-classes" name="change-classes" onfocus="size=2;" onblur="size=1;" onchange="size=1; blur();">
            <script>
                const classes = [];
                const all_classes = "1B;1C;1D;1E;1F;1O;1P;2B;2C;2D;2E;2F;2G;2K;2O;2P;3B;3C;3D;3E;3F;3G;3K;3P;3O;4C;4D;4E;4F;4G;4K;4P;4O;5C;5D;5E;5F;5G;5K;5O;5P";
                const class_names = all_classes.split(";");
                for(let i = 0; i < class_names.length; i++){
                    classes[i] = class_names[i];
                }
                classes.forEach(element => {
                    let option = document.createElement("option");
                    option.value = element;
                    option.text = element;
                    document.getElementById("change-classes").appendChild(option);
                });
            </script>
        </select><br>
        <input type="submit" class="presentation" value="PRESENTATION">
    </form>
    <?php
        if(isset($_SESSION["Admin"])){
            echo '<form action="./PHP/delete-session.php" method="post">
                    <input type="submit" class="presentation" value="Log-Out">
                </form>';
        }
    ?>
</body>
</html>