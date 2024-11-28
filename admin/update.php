<link rel="stylesheet" href="../CSS/admin-style.css">
<body class="background">
<div class="menu-main">
<?php 
$host = "localhost";
$user = "root";
$password = "";
$database = "plan_lekcji";
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Error connect: " . mysqli_connect_error());
}

$table = $_POST["tables"] ?? null;

switch ($table) {
    case 'dw':
        echo "<h1>dni_wolne.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" class="text-input" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" class="text-input" name="new_numer_k" required><br>

            <label for="old_dni_wolne">Old Day Off:</label>
            <input type="text" class="text-input" name="old_dni_wolne" required>
            <label for="new_dni_wolne">New Day Off:</label>
            <input type="text" class="text-input" name="new_dni_wolne" required><br>
            
            <input name="tables" type="hidden" value="dw">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $old_numer_k = $conn->real_escape_string($_POST["old_numer_k"]);
            $new_numer_k = $conn->real_escape_string($_POST["new_numer_k"]);
            $old_dni_wolne = intval($_POST["old_dni_wolne"]);
            $new_dni_wolne = intval($_POST["new_dni_wolne"]);

            $select_old_k = "SELECT id_k FROM klasa WHERE numer_k='$old_numer_k'";
            $result_old_k = $conn->query($select_old_k);
            $old_id_k = mysqli_fetch_assoc($result_old_k)['id_k'];

            $select_new_k = "SELECT id_k FROM klasa WHERE numer_k='$new_numer_k'";
            $result_new_k = $conn->query($select_new_k);
            $new_id_k = mysqli_fetch_assoc($result_new_k)['id_k'];

            $sql = "UPDATE dni_wolne 
                    SET id_k=$new_id_k, dni_wolne=$new_dni_wolne 
                    WHERE id_k=$old_id_k AND dni_wolne=$old_dni_wolne";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'g':
        echo "<h1>godzina.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="start">Old Start Time:</label>
            <input type="text" class="text-input" name="start" required>
            <label for="new_start">New Start Time:</label>
            <input type="text" class="text-input" name="new_start" required><br>
            <label for="koniec">Old End Time:</label>
            <input type="text" class="text-input" name="koniec" required>
            <label for="new_koniec">New End Time:</label>
            <input type="text" class="text-input" name="new_koniec" required><br>
            <input name="tables" type="hidden" value="g">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $new_id_g = intval($_POST["new_id_g"]);
            $start = $conn->real_escape_string($_POST["start"]);
            $new_start = $conn->real_escape_string($_POST["new_start"]);
            $new_koniec = $conn->real_escape_string($_POST["new_koniec"]);
            $koniec = $conn->real_escape_string($_POST["koniec"]);
            $sql = "UPDATE godzina SET start='$new_start', koniec='$new_koniec' WHERE start='$start' AND koniec='$koniec'";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;

    case 'k':
        echo "<h1>klasa.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="numer_k">Old Class Number:</label>
            <input type="text" class="text-input" name="numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" class="text-input" name="new_numer_k" required><br>
            <label for="wychowawca">Old Class Teacher:</label>
            <input type="text" class="text-input" name="wychowawca" required>
            <label for="new_wychowawca">New Class Teacher:</label>
            <input type="text" class="text-input" name="new_wychowawca" required><br>
            <input name="tables" type="hidden" value="k">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $numer_k = $conn->real_escape_string($_POST["numer_k"]);
            $new_numer_k = $conn->real_escape_string($_POST["new_numer_k"]);
            $wychowawca = $conn->real_escape_string($_POST["wychowawca"]);
            $new_wychowawca = $conn->real_escape_string($_POST["new_wychowawca"]);
            $sql = "UPDATE klasa SET numer_k='$new_numer_k', wychowawca='$new_wychowawca' WHERE numer_k='$numer_k' AND wychowawca='$wychowawca'";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;

    case 'nk':
        echo "<h1>nauczyciele_klasa.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" class="text-input" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" class="text-input" name="new_numer_k" required><br>

            <label for="old_skrot">Old Teacher Shortcut:</label>
            <input type="text" class="text-input" name="old_skrot" required>
            <label for="new_skrot">New Teacher Shortcut:</label>
            <input type="text" class="text-input" name="new_skrot" required><br>
            
            <input name="tables" type="hidden" value="nk">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $old_numer_k = $conn->real_escape_string($_POST["old_numer_k"]);
            $new_numer_k = $conn->real_escape_string($_POST["new_numer_k"]);
            $old_skrot = $conn->real_escape_string($_POST["old_skrot"]);
            $new_skrot = $conn->real_escape_string($_POST["new_skrot"]);

            // Fetch `id_k` for old and new class numbers
            $select_old_k = "SELECT id_k FROM klasa WHERE numer_k='$old_numer_k'";
            $result_old_k = $conn->query($select_old_k);
            $old_id_k = mysqli_fetch_assoc($result_old_k)['id_k'];

            $select_new_k = "SELECT id_k FROM klasa WHERE numer_k='$new_numer_k'";
            $result_new_k = $conn->query($select_new_k);
            $new_id_k = mysqli_fetch_assoc($result_new_k)['id_k'];

            // Fetch `id_n` for old and new teacher shortcuts
            $select_old_n = "SELECT id_n FROM nauczyciele WHERE skrot='$old_skrot'";
            $result_old_n = $conn->query($select_old_n);
            $old_id_n = mysqli_fetch_assoc($result_old_n)['id_n'];

            $select_new_n = "SELECT id_n FROM nauczyciele WHERE skrot='$new_skrot'";
            $result_new_n = $conn->query($select_new_n);
            $new_id_n = mysqli_fetch_assoc($result_new_n)['id_n'];

            // Update `nauczyciele_klasa` table
            $sql = "UPDATE nauczyciele_klasa 
                    SET id_k=$new_id_k, id_n=$new_id_n 
                    WHERE id_k=$old_id_k AND id_n=$old_id_n";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'np':
        echo "<h1>nauczyciele_przedmiot.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="old_skrot">Old Teacher Shortcut:</label>
            <input type="text" class="text-input" name="old_skrot" required>
            <label for="new_skrot">New Teacher Shortcut:</label>
            <input type="text" class="text-input" name="new_skrot" required><br>

            <label for="old_nazwa">Old Subject Name:</label>
            <input type="text" class="text-input" name="old_nazwa" required>
            <label for="new_nazwa">New Subject Name:</label>
            <input type="text" class="text-input" name="new_nazwa" required><br>
            
            <input name="tables" type="hidden" value="np">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $old_skrot = $conn->real_escape_string($_POST["old_skrot"]);
            $new_skrot = $conn->real_escape_string($_POST["new_skrot"]);
            $old_nazwa = $conn->real_escape_string($_POST["old_nazwa"]);
            $new_nazwa = $conn->real_escape_string($_POST["new_nazwa"]);

            $select_old_n = "SELECT id_n FROM nauczyciele WHERE skrot='$old_skrot'";
            $result_old_n = $conn->query($select_old_n);
            $old_id_n = mysqli_fetch_assoc($result_old_n)['id_n'];

            $select_new_n = "SELECT id_n FROM nauczyciele WHERE skrot='$new_skrot'";
            $result_new_n = $conn->query($select_new_n);
            $new_id_n = mysqli_fetch_assoc($result_new_n)['id_n'];

            $select_old_p = "SELECT id_p FROM przedmiot WHERE nazwa='$old_nazwa'";
            $result_old_p = $conn->query($select_old_p);
            $old_id_p = mysqli_fetch_assoc($result_old_p)['id_p'];

            $select_new_p = "SELECT id_p FROM przedmiot WHERE nazwa='$new_nazwa'";
            $result_new_p = $conn->query($select_new_p);
            $new_id_p = mysqli_fetch_assoc($result_new_p)['id_p'];

            $sql = "UPDATE nauczyciele_przedmiot 
                    SET id_n=$new_id_n, id_p=$new_id_p 
                    WHERE id_n=$old_id_n AND id_p=$old_id_p";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'n':
        echo "<h1>nauczyciele.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="old_skrot">Old Shortcut:</label>
            <input type="text" class="text-input" name="old_skrot" required>
            <label for="new_skrot">New Shortcut:</label>
            <input type="text" class="text-input" name="new_skrot" required><br>
            <label for="old_imie_nazwisko">Old Name:</label>
            <input type="text" class="text-input" name="old_imie_nazwisko" required>
            <label for="new_imie_nazwisko">New Name:</label>
            <input type="text" class="text-input" name="new_imie_nazwisko" required><br>
            <input name="tables" type="hidden" value="n">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $old_skrot = $conn->real_escape_string($_POST["old_skrot"]);
            $new_skrot = $conn->real_escape_string($_POST["new_skrot"]);
            $old_imie_nazwisko = $conn->real_escape_string($_POST["old_imie_nazwisko"]);
            $new_imie_nazwisko = $conn->real_escape_string($_POST["new_imie_nazwisko"]);
            $sql = "UPDATE nauczyciele SET skrot='$new_skrot', imie_nazwisko='$new_imie_nazwisko' WHERE skrot='$old_skrot' AND imie_nazwisko='$old_imie_nazwisko'";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;

    case 'pk':
        echo "<h1>przedmiot_klasa.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" class="text-input" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" class="text-input" name="new_numer_k" required><br>

            <label for="old_nazwa">Old Subject Name:</label>
            <input type="text" class="text-input" name="old_nazwa" required>
            <label for="new_nazwa">New Subject Name:</label>
            <input type="text" class="text-input" name="new_nazwa" required><br>

            <label for="old_ilosc_godzin">Old Hours:</label>
            <input type="text" class="text-input" name="old_ilosc_godzin" required>
            <label for="new_ilosc_godzin">New Hours:</label>
            <input type="text" class="text-input" name="new_ilosc_godzin" required><br>

            <label for="old_ilosc_grup">Old Number of Grups:</label>
            <input type="text" class="text-input" name="old_ilosc_grup" required>
            <label for="new_ilosc_grup">New Number of Grups:</label>
            <input type="text" class="text-input" name="new_ilosc_grup" required><br>
            
            <input name="tables" type="hidden" value="pk">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $old_numer_k = $conn->real_escape_string($_POST["old_numer_k"]);
            $new_numer_k = $conn->real_escape_string($_POST["new_numer_k"]);
            $old_nazwa = $conn->real_escape_string($_POST["old_nazwa"]);
            $new_nazwa = $conn->real_escape_string($_POST["new_nazwa"]);
            $old_ilosc_godzin = intval($_POST["old_ilosc_godzin"]);
            $new_ilosc_godzin = intval($_POST["new_ilosc_godzin"]);
            $old_ilosc_grup = intval($_POST["old_ilosc_grup"]);
            $new_ilosc_grup = intval($_POST["new_ilosc_grup"]);

            // Fetch `id_k` for old and new class numbers
            $select_old_k = "SELECT id_k FROM klasa WHERE numer_k='$old_numer_k'";
            $result_old_k = $conn->query($select_old_k);
            $old_id_k = mysqli_fetch_assoc($result_old_k)['id_k'];

            $select_new_k = "SELECT id_k FROM klasa WHERE numer_k='$new_numer_k'";
            $result_new_k = $conn->query($select_new_k);
            $new_id_k = mysqli_fetch_assoc($result_new_k)['id_k'];

            // Fetch `id_p` for old and new subject names
            $select_old_p = "SELECT id_p FROM przedmiot WHERE nazwa='$old_nazwa'";
            $result_old_p = $conn->query($select_old_p);
            $old_id_p = mysqli_fetch_assoc($result_old_p)['id_p'];

            $select_new_p = "SELECT id_p FROM przedmiot WHERE nazwa='$new_nazwa'";
            $result_new_p = $conn->query($select_new_p);
            $new_id_p = mysqli_fetch_assoc($result_new_p)['id_p'];

            // Update `przedmiot_klasa` table
            $sql = "UPDATE przedmiot_klasa 
                    SET id_k=$new_id_k, id_p=$new_id_p, ilosc_godzin=$new_ilosc_godzin 
                    WHERE id_k=$old_id_k AND id_p=$old_id_p AND ilosc_godzin=$old_ilosc_godzin";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'p':
        echo "<h1>przedmiot.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="nazwa">Old Name:</label>
            <input type="text" class="text-input" name="nazwa" required>
            <label for="new_nazwa">New Name:</label>
            <input type="text" class="text-input" name="new_nazwa" required><br>
            <label for="typ">Old Type:</label>
            <input type="text" class="text-input" name="typ" required>
            <label for="new_typ">New Type:</label>
            <input type="text" class="text-input" name="new_typ" required><br>
            <input name="tables" type="hidden" value="p">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $nazwa = $conn->real_escape_string($_POST["nazwa"]);
            $new_nazwa = $conn->real_escape_string($_POST["new_nazwa"]);
            $typ = $conn->real_escape_string($_POST["typ"]);
            $new_typ = $conn->real_escape_string($_POST["new_typ"]);
            $sql = "UPDATE przedmiot SET nazwa='$new_nazwa', typ='$new_typ' WHERE nazwa='$nazwa' AND typ='$typ'";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;

    case 's':
        echo "<h1>sala.php</h1>";
        echo '<form action="update.php" method="post">
            <label for="nr_sali">Old Room Number:</label>
            <input type="text" class="text-input" name="nr_sali" required>
            <label for="new_nr_sali">New Room Number:</label>
            <input type="text" class="text-input" name="new_nr_sali" required><br>
            <label for="typ">Old Type:</label>
            <input type="text" class="text-input" name="typ" required>
            <label for="new_typ">New Type:</label>
            <input type="text" class="text-input" name="new_typ" required><br>
            <input name="tables" type="hidden" value="s">
            <input name="update" class="return" type="submit" value="Update">
        </form>
        <form action="../admin.php" method="post">
            <input type="submit" name="submit" class="return" value="RETURN">
        </form>';
        if (isset($_POST["update"])) {
            $nr_sali = $conn->real_escape_string($_POST["nr_sali"]);
            $new_nr_sali = $conn->real_escape_string($_POST["new_nr_sali"]);
            $typ = $conn->real_escape_string($_POST["typ"]);
            $new_typ = $conn->real_escape_string($_POST["new_typ"]);
            $sql = "UPDATE sala SET nr_sali='$new_nr_sali', typ='$new_typ' WHERE nr_sali='$nr_sali' AND typ='$typ'";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;

    default:
        echo "Invalid table selection.";
        break;
}

$conn->close();
?>
</div></body>