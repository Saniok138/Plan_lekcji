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
    case 'dn':
        echo "dni_nauczyciele.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_skrot">Old Teacher Shortcut:</label>
            <input type="text" name="old_skrot" required>
            <label for="new_skrot">New Teacher Shortcut:</label>
            <input type="text" name="new_skrot" required><br>
    
            <label for="old_dni">Old Day:</label>
            <input type="text" name="old_dni" required>
            <label for="new_dni">New Day:</label>
            <input type="text" name="new_dni" required><br>
    
            <label for="old_godzina">Old Hour:</label>
            <input type="text" name="old_godzina" required>
            <label for="new_godzina">New Hour:</label>
            <input type="text" name="new_godzina" required><br>
    
            <input name="tables" type="hidden" value="dn">
            <input name="update" type="submit" value="Update">
        </form>';
        if (isset($_POST["update"])) {
            $old_skrot = $conn->real_escape_string($_POST["old_skrot"]);
            $new_skrot = $conn->real_escape_string($_POST["new_skrot"]);
            $old_dni = intval($_POST["old_dni"]);
            $new_dni = intval($_POST["new_dni"]);
            $old_godzina = intval($_POST["old_godzina"]);
            $new_godzina = intval($_POST["new_godzina"]);
    
            $select_old_n = "SELECT id_n FROM nauczyciele WHERE skrot='$old_skrot'";
            $result_old_n = $conn->query($select_old_n);
            $old_id_n = mysqli_fetch_assoc($result_old_n)['id_n'];
    
            $select_new_n = "SELECT id_n FROM nauczyciele WHERE skrot='$new_skrot'";
            $result_new_n = $conn->query($select_new_n);
            $new_id_n = mysqli_fetch_assoc($result_new_n)['id_n'];
    
            $sql = "UPDATE dni_nauczyciele SET id_n=$new_id_n, dni=$new_dni, godzina=$new_godzina WHERE id_n=$old_id_n AND dni=$old_dni AND godzina=$old_godzina";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;
    

    case 'dw':
        echo "dni_wolne.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" name="new_numer_k" required><br>

            <label for="old_dni_wolne">Old Day Off:</label>
            <input type="text" name="old_dni_wolne" required>
            <label for="new_dni_wolne">New Day Off:</label>
            <input type="text" name="new_dni_wolne" required><br>
            
            <input name="tables" type="hidden" value="dw">
            <input name="update" type="submit" value="Update">
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

            $sql = "UPDATE dni_wolne SET id_k=$new_id_k, dni_wolne=$new_dni_wolne WHERE id_k=$old_id_k AND dni_wolne=$old_dni_wolne";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'g':
        echo "godzina.php<br>";
        echo '<form action="update.php" method="post">
            <label for="start">Old Start Time:</label>
            <input type="text" name="start" required>
            <label for="new_start">New Start Time:</label>
            <input type="text" name="new_start" required><br>
            <label for="koniec">Old End Time:</label>
            <input type="text" name="koniec" required>
            <label for="new_koniec">New End Time:</label>
            <input type="text" name="new_koniec" required><br>
            <input name="tables" type="hidden" value="g">
            <input name="update" type="submit" value="Update">
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
        echo "klasa.php<br>";
        echo '<form action="update.php" method="post">
            <label for="numer_k">Old Class Number:</label>
            <input type="text" name="numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" name="new_numer_k" required><br>
            <label for="wychowawca">Old Class Teacher:</label>
            <input type="text" name="wychowawca" required>
            <label for="new_wychowawca">New Class Teacher:</label>
            <input type="text" name="new_wychowawca" required><br>
            <input name="tables" type="hidden" value="k">
            <input name="update" type="submit" value="Update">
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
        echo "nauczyciele_klasa.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" name="new_numer_k" required><br>

            <label for="old_skrot">Old Teacher Shortcut:</label>
            <input type="text" name="old_skrot" required>
            <label for="new_skrot">New Teacher Shortcut:</label>
            <input type="text" name="new_skrot" required><br>
            
            <input name="tables" type="hidden" value="nk">
            <input name="update" type="submit" value="Update">
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
            $sql = "UPDATE nauczyciele_klasa SET id_k=$new_id_k, id_n=$new_id_n WHERE id_k=$old_id_k AND id_n=$old_id_n";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'np':
        echo "nauczyciele_przedmiot.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_skrot">Old Teacher Shortcut:</label>
            <input type="text" name="old_skrot" required>
            <label for="new_skrot">New Teacher Shortcut:</label>
            <input type="text" name="new_skrot" required><br>

            <label for="old_nazwa">Old Subject Name:</label>
            <input type="text" name="old_nazwa" required>
            <label for="new_nazwa">New Subject Name:</label>
            <input type="text" name="new_nazwa" required><br>
            
            <input name="tables" type="hidden" value="np">
            <input name="update" type="submit" value="Update">
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

            $sql = "UPDATE nauczyciele_przedmiot SET id_n=$new_id_n, id_p=$new_id_p WHERE id_n=$old_id_n AND id_p=$old_id_p";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'n':
        echo "nauczyciele.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_skrot">Old Shortcut:</label>
            <input type="text" name="old_skrot" required>
            <label for="new_skrot">New Shortcut:</label>
            <input type="text" name="new_skrot" required><br>
            <label for="old_imie_nazwisko">Old Name:</label>
            <input type="text" name="old_imie_nazwisko" required>
            <label for="new_imie_nazwisko">New Name:</label>
            <input type="text" name="new_imie_nazwisko" required><br>
            <input name="tables" type="hidden" value="n">
            <input name="update" type="submit" value="Update">
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
        echo "przedmiot_klasa.php<br>";
        echo '<form action="update.php" method="post">
            <label for="old_numer_k">Old Class Number:</label>
            <input type="text" name="old_numer_k" required>
            <label for="new_numer_k">New Class Number:</label>
            <input type="text" name="new_numer_k" required><br>

            <label for="old_nazwa">Old Subject Name:</label>
            <input type="text" name="old_nazwa" required>
            <label for="new_nazwa">New Subject Name:</label>
            <input type="text" name="new_nazwa" required><br>

            <label for="old_ilosc_godzin">Old Hours:</label>
            <input type="text" name="old_ilosc_godzin" required>
            <label for="new_ilosc_godzin">New Hours:</label>
            <input type="text" name="new_ilosc_godzin" required><br>
            
            <input name="tables" type="hidden" value="pk">
            <input name="update" type="submit" value="Update">
        </form>';
        if (isset($_POST["update"])) {
            $old_numer_k = $conn->real_escape_string($_POST["old_numer_k"]);
            $new_numer_k = $conn->real_escape_string($_POST["new_numer_k"]);
            $old_nazwa = $conn->real_escape_string($_POST["old_nazwa"]);
            $new_nazwa = $conn->real_escape_string($_POST["new_nazwa"]);
            $old_ilosc_godzin = intval($_POST["old_ilosc_godzin"]);
            $new_ilosc_godzin = intval($_POST["new_ilosc_godzin"]);

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
            $sql = "UPDATE przedmiot_klasa SET id_k=$new_id_k, id_p=$new_id_p, ilosc_godzin=$new_ilosc_godzin WHERE id_k=$old_id_k AND id_p=$old_id_p AND ilosc_godzin=$old_ilosc_godzin";
            mysqli_query($conn, $sql);
            header("Location: ../admin.php");
            exit;
        }
        break;


    case 'p':
        echo "przedmiot.php<br>";
        echo '<form action="update.php" method="post">
            <label for="nazwa">Old Name:</label>
            <input type="text" name="nazwa" required>
            <label for="new_nazwa">New Name:</label>
            <input type="text" name="new_nazwa" required><br>
            <label for="typ">Old Type:</label>
            <input type="text" name="typ" required>
            <label for="new_typ">New Type:</label>
            <input type="text" name="new_typ" required><br>
            <input name="tables" type="hidden" value="p">
            <input name="update" type="submit" value="Update">
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
        echo "sala.php<br>";
        echo '<form action="update.php" method="post">
            <label for="numer">Old Room Number:</label>
            <input type="text" name="numer" required>
            <label for="new_numer">New Room Number:</label>
            <input type="text" name="new_numer" required><br>
            <label for="rozmiar">Old Size:</label>
            <input type="text" name="rozmiar" required>
            <label for="new_rozmiar">New Size:</label>
            <input type="text" name="new_rozmiar" required><br>
            <label for="typ">Old Type:</label>
            <input type="text" name="typ" required>
            <label for="new_typ">New Type:</label>
            <input type="text" name="new_typ" required><br>
            <input name="tables" type="hidden" value="s">
            <input name="update" type="submit" value="Update">
        </form>';
        if (isset($_POST["update"])) {
            $numer = $conn->real_escape_string($_POST["numer"]);
            $new_numer = $conn->real_escape_string($_POST["new_numer"]);
            $old_rozmiar = intval($_POST["old_rozmiar"]);
            $new_rozmiar = intval($_POST["new_rozmiar"]);
            $typ = $conn->real_escape_string($_POST["typ"]);
            $new_typ = $conn->real_escape_string($_POST["new_typ"]);
            $sql = "UPDATE sala SET numer='$new_numer', rozmiar='$new_rozmiar', typ='$new_typ' WHERE numer='$numer' AND rozmiar='$rozmiar' AND typ='$typ'";
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