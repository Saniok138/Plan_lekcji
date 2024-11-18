<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "plan_lekcji";
$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Error connect: " . mysqli_connect_error());
}

$insert = $_POST["insert"] ?? null;

switch ($insert) {
    case 'dn':
        echo "dni_nauczyciele.php";
        $dni = intval($_POST["dni"]);
        $godzina = intval($_POST["godzina"]);
        $id_n = $_POST["id_n"];
          $select = "SELECT id_n FROM nauczyciele where skrot = '$id_n'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_n = $row['id_n'];
        $sql = "INSERT INTO dni_nauczyciele(dni, godzina, id_n) VALUES ($dni, $godzina, $id_n)";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'dw':
        echo "dni_wolne.php";
        $id_k = $_POST["id_k"];
          $select = "SELECT id_k FROM klasa where numer_k = '$id_k'";
          $result = $conn->query($select);
          $row = mysqli_fetch_assoc($result);
        $id_k = $row['id_k'];
        $dni_wolne = intval($_POST["dni_wolne"]);
        $sql = "INSERT INTO dni_wolne (id_k, dni_wolne) VALUES ($id_k, $dni_wolne)";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'g':
        echo "godzina.php";
        $id_g = $_POST["id_g"];
        $start = $conn->real_escape_string($_POST["start"]);
        $koniec = $conn->real_escape_string($_POST["koniec"]);
        $sql = "INSERT INTO godzina (id_g, start, koniec) VALUES ($id_g, '$start', '$koniec')";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'k':
        echo "klasa.php";
        $id_k = intval($_POST["id_k"]);
        $numer_k = $conn->real_escape_string($_POST["numer_k"]);
        $wychowawca = $conn->real_escape_string($_POST["wychowawca"]);
        $sql = "INSERT INTO klasa (id_k, numer_k, wychowawca) VALUES ($id_k, '$numer_k', '$wychowawca')";
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
        $sql = "INSERT INTO nauczyciele_klasa (id_k, id_n) VALUES ($id_k, $id_n)";
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
        $sql = "INSERT INTO nauczyciele_przedmiot (id_n, id_p) VALUES ($id_n, $id_p)";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'n':
        echo "nauczyciele.php";
        $id_n = intval($_POST["id_n"]);
        $skrot = $conn->real_escape_string($_POST["skrot"]);
        $imie_nazwisko = $conn->real_escape_string($_POST["imie_nazwisko"]);
        $sql = "INSERT INTO nauczyciele (id_n, skrot, imie_nazwisko) VALUES ($id_n, '$skrot', '$imie_nazwisko')";
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
        $ilosc_grup = intval($_POST["ilosc_grup"]);
        $sql = "INSERT INTO przedmiot_klasa (id_k, id_p, ilosc_godzin, ilosc_grup) VALUES ($id_k, $id_p, $ilosc_godzin, $ilosc_grup)";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    case 'p':
        echo "przedmiot.php";
        $id_p = $_POST["id_p"];
        $nazwa = $conn->real_escape_string($_POST["nazwa"]);
        $typ = $conn->real_escape_string($_POST["typ"]);
        $sql = "INSERT INTO przedmiot (id_p, nazwa, typ) VALUES ($id_p, '$nazwa', '$typ')";
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
        $sql = "INSERT INTO sala (id_s, numer, rozmiar, typ, wychowawca) VALUES ($id_s, '$numer', $rozmiar, '$typ', '$wychowawca')";
        $result = mysqli_query($conn, $sql);
        header("Location: ../admin.php");
        exit;

    default:
        header("Location: ../admin.php");
        exit;
}

$conn->close();
?>
