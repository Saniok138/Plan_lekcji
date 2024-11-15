<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "plan_lekcji";
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Error connect: " . mysqli_connect_error());
}

$delete = $_POST["delete"] ?? null;

switch ($delete) {
    case 'dn':
        echo "dni_nauczyciele.php";
        $dni = intval($_POST["dni"]);
        $godzina = intval($_POST["godzina"]);
        $id_n = $_POST["id_n"];
          $select = "SELECT id_n FROM nauczyciele where skrot = '$id_n'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_n = $row['id_n'];
        $sql = "DELETE FROM dni_nauczyciele where dni=$dni AND godzina=$godzina AND id_n=$id_n";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'dw':
        echo "dni_wolne.php<br>";
        $id_k = $_POST["id_k"];
        $select = "SELECT id_k FROM klasa where numer_k = '$id_k'";
        $result = $conn->query($select);
        $row = mysqli_fetch_assoc($result);
        $id_k = $row['id_k'];
        $dni_wolne = intval($_POST["dni_wolne"]);
        $sql = "DELETE FROM dni_wolne where id_k=$id_k AND dni_wolne=$dni_wolne";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'g':
        echo "godzina.php";
        $id_g = $_POST["id_g"];
        $start = $_POST["start"];
        $koniec = $_POST["koniec"];
        $sql = "DELETE FROM godzina where id_g=$id_g AND start='$start' AND koniec='$koniec'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'k':
        echo "klasa.php";
        $id_k = intval($_POST["id_k"]);
        $numer_k = $conn->real_escape_string($_POST["numer_k"]);
        $wychowawca = $conn->real_escape_string($_POST["wychowawca"]);
        $sql = "DELETE FROM klasa where id_k=$id_k and numer_k='$numer_k' and wychowawca='$wychowawca'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'nk':
        echo "nauczyciele_klasa.php";
        $id_k = $_POST["id_k"];
          $select = "SELECT id_k FROM klasa where numer_k = '$id_k'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_k = $row['id_k'];
        $id_n = $_POST["id_n"];
          $select = "SELECT id_n FROM nauczyciele where skrot = '$id_n'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_n = $row['id_n'];
        $sql = "DELETE FROM nauczyciele_klasa where id_k=$id_k and id_n=$id_n";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'np':
        echo "nauczyciele_przedmiot.php";
        $id_n = $_POST["id_n"];
          $select = "SELECT id_n FROM nauczyciele where skrot = '$id_n'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_n = $row['id_n'];
        $id_p = $_POST["id_p"];
          $select = "SELECT id_p FROM przedmiot where nazwa = '$id_p'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_p = $row['id_p'];
        $sql = "DELETE FROM nauczyciele_przedmiot where id_n=$id_n AND id_p=$id_p";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'n':
        echo "nauczyciele.php";
        $id_n = intval($_POST["id_n"]);
        $skrot = $conn->real_escape_string($_POST["skrot"]);
        $imie_nazwisko = $conn->real_escape_string($_POST["imie_nazwisko"]);
        $sql = "DELETE FROM nauczyciele where id_n=$id_n and skrot='$skrot' and imie_nazwisko='$imie_nazwisko'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'pk':
        echo "przedmiot_klasa.php";
        $id_k = $_POST["id_k"];
          $select = "SELECT id_k FROM klasa where numer_k = '$id_k'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_k = $row['id_k'];
        $id_p = $_POST["id_p"];
          $select = "SELECT id_p FROM przedmiot where nazwa = '$id_p'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_p = $row['id_p'];
        $ilosc_godzin = intval($_POST["ilosc_godzin"]);
        $sql = "DELETE FROM przedmiot_klasa where id_k=$id_k and id_p=$id_p and ilosc_godzin=$ilosc_godzin";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'p':
        echo "przedmiot.php";
        $id_p = $_POST["id_p"];
        $nazwa = $conn->real_escape_string($_POST["nazwa"]);
        $typ = $conn->real_escape_string($_POST["typ"]);
        $sql = "DELETE FROM przedmiot where id_p=$id_p and nazwa='$nazwa' and typ='$typ'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 's':
        echo "sala.php";
        $id_s = intval($_POST["id_s"]);
        $numer = $conn->real_escape_string($_POST["numer"]);
        $rozmiar = intval($_POST["rozmiar"]);
        $typ = $conn->real_escape_string($_POST["typ"]);
        $wychowawca = $conn->real_escape_string($_POST["wychowawca"]);
        $sql = "DELETE FROM sala where id_s=$id_s and numer='$numer' and rozmiar=$rozmiar and typ='$typ' and wychowawca='$wychowawca'";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    default:
        header("Location: ../admin.php");
        exit;
}

$conn->close();
?>
