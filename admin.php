<?php 
$host = "localhost";
$user = "root";
$password = "";
$database = "plan_lekcji";
if (!$conn) {
die("Error connect: " . mysqli_connect_error());
}

echo "<h3>dni_wolne</h3>";
include("./admin/dni_wolne.php");

echo "<br><br><h3>nauczyciele_klasa</h3>";
include("./admin/nauczyciele_klasa.php");

echo "<br><br><h3>dni_nauczyciele</h3>";
include("./admin/dni_nauczyciele.php");

echo "<br><br><h3>nauczyciele_przedmiot</h3>";
include("./admin/nauczyciele_przedmiot.php");

echo "<br><br><h3>przedmiot_klasa</h3>";
include("./admin/przedmiot_klasa.php");

echo "<br><br><h3>godzina</h3>";
include("./admin/godzina.php");

echo "<br><br><h3>klasa</h3>";
include("./admin/klasa.php");

echo "<br><br><h3>nauczyciele</h3>";
include("./admin/nauczyciele.php");

echo "<br><br><h3>przedmiot</h3>";
include("./admin/przedmiot.php");

echo "<br><br><h3>sala</h3>";
include("./admin/sala.php");
?>