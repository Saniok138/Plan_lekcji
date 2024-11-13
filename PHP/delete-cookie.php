<?php
setcookie("generated", "", time() - 3600, "/");
header(header: "Location: ../index.php");
exit();